<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Gallery Management';
?>
<?php require './components/header.php'; ?>

<style>
    /* Statistics Cards - Updated to match notices styling */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card-modern {
        position: relative;
        padding: 28px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card-modern:hover::before {
        opacity: 1;
    }

    .stat-card-modern.total { --gradient-start: #8b5cf6; --gradient-end: #7c3aed; }
    .stat-card-modern.photos { --gradient-start: #10b981; --gradient-end: #059669; }
    .stat-card-modern.videos { --gradient-start: #ef4444; --gradient-end: #dc2626; }
    .stat-card-modern.storage { --gradient-start: #f59e0b; --gradient-end: #d97706; }

    .stat-content-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-info h3 {
        font-size: 36px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 8px 0 0 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon-modern {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .stat-card-modern:hover .stat-icon-modern {
        transform: rotate(10deg) scale(1.1);
    }

    .stat-icon-modern i {
        font-size: 28px;
        color: #fff;
    }

    /* Page Header - Updated to match notices styling */
    .page-title-section {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title-section .icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
    }

    .page-title-section h1 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .page-title-section .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 8px 0 0 0;
        font-size: 14px;
    }

    /* Upload Section - Updated to match notices styling */
    .upload-section {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 32px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        font-size: 20px;
        color: #8b5cf6;
    }

    .section-title h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .upload-area {
        border: 3px dashed #e2e8f0;
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f8fafc;
    }

    .upload-area:hover {
        background: #f1f5f9;
        border-color: #8b5cf6;
    }

    .upload-area.dragover {
        background: #e9d5ff;
        border-color: #8b5cf6;
        transform: scale(1.02);
    }

    .upload-icon {
        font-size: 4rem;
        color: #8b5cf6;
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 1.2rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .upload-hint {
        color: #64748b;
        font-size: 0.95rem;
    }

    .file-input {
        display: none;
    }

    .btn-browse {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        margin-top: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
    }

    .btn-browse:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
    }

    /* Filter Section - Updated to match notices styling */
    .filter-section {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 32px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .filter-header i {
        font-size: 20px;
        color: #8b5cf6;
    }

    .filter-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .filter-select {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        background-color: #fff;
        padding-right: 45px;
    }

    .filter-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 14px 18px 14px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .search-input-wrapper input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    /* Media Cards - Updated to match notices styling */
    .media-card {
        background: #fff;
        border-radius: 16px;
        padding: 0;
        margin-bottom: 0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .media-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--accent-color), var(--accent-color-dark));
    }

    .media-card.photo { --accent-color: #10b981; --accent-color-dark: #059669; }
    .media-card.video { --accent-color: #ef4444; --accent-color-dark: #dc2626; }

    .media-card:hover {
        transform: translateX(4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
    }

    .media-thumbnail {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f1f5f9;
    }

    .media-type-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-photo {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .badge-video {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .media-info {
        padding: 20px;
    }

    .media-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .media-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .media-actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        flex-shrink: 0;
    }

    .btn-view {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .btn-edit {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .btn-delete {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    /* Preview Section */
    .preview-section {
        margin-top: 24px;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
    }

    .preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #f1f5f9;
        aspect-ratio: 1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-remove {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .preview-remove:hover {
        background: rgba(239, 68, 68, 1);
        transform: scale(1.1);
    }

    /* Upload Progress */
    .upload-progress {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        margin-top: 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        transition: width 0.3s;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state-icon i {
        font-size: 36px;
        color: #94a3b8;
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 16px;
    }

    /* Pagination */
    .pagination-modern {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 32px;
    }

    .page-btn {
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-btn:hover:not(.disabled):not(.active) {
        border-color: #8b5cf6;
        color: #8b5cf6;
        transform: translateY(-2px);
    }

    .page-btn.active {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
    }

    .page-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .media-card {
        animation: fadeIn 0.5s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-info h3 {
            font-size: 28px;
        }

        .stat-icon-modern {
            width: 50px;
            height: 50px;
        }

        .stat-icon-modern i {
            font-size: 22px;
        }

        .page-title-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .upload-area {
            padding: 2rem 1rem;
        }

        .upload-icon {
            font-size: 3rem;
        }
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="gallery">

        <!-- Page Title -->
        <div class="page-title-section">
            <div class="icon-box">
                <i class="fa-solid fa-images"></i>
            </div>
            <div>
                <h1>Gallery Management</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card-modern total">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Media</div>
                        <h3 id="totalMedia">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-images"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern photos">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Photos</div>
                        <h3 id="photoCount">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-image"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern videos">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Videos</div>
                        <h3 id="videoCount">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-video"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern storage">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Storage Used</div>
                        <h3 id="storageUsed">0 MB</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-hard-drive"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-section">
            <div class="section-title">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <h5>Upload Media</h5>
            </div>
            
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <p class="upload-text">Drag and drop your files here</p>
                <p class="upload-hint">or</p>
                <button class="btn-browse" onclick="document.getElementById('fileInput').click()">
                    <i class="fa-solid fa-folder-open me-2"></i>Browse Files
                </button>
                <input type="file" id="fileInput" class="file-input" multiple accept="image/*,video/*">
                <p class="upload-hint mt-3">Supports: JPG, PNG, GIF, MP4, WebM (Max 50MB per file)</p>
            </div>

            <!-- Preview Section -->
            <div class="preview-section" id="previewSection" style="display: none;">
                <h5 class="mb-3">Selected Files</h5>
                <div class="preview-grid" id="previewGrid"></div>
                <button class="btn-browse mt-3" onclick="uploadFiles()">
                    <i class="fa-solid fa-upload me-2"></i>Upload All Files
                </button>
            </div>

            <!-- Upload Progress -->
            <div class="upload-progress" id="uploadProgress" style="display: none;">
                <div class="d-flex justify-content-between mb-2">
                    <span>Uploading...</span>
                    <span id="progressPercent">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <i class="fa-solid fa-filter"></i>
                <h5>Filter Media</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="filter-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="photo">Photos</option>
                        <option value="video">Videos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="filter-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="events">Events</option>
                        <option value="activities">Activities</option>
                        <option value="team">Team</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="filter-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name">Name A-Z</option>
                        <option value="size">Size</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search media..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Grid -->
        <div class="media-grid" id="mediaGrid">
            <!-- Sample Media Cards -->
            <div class="media-card photo">
                <img src="https://via.placeholder.com/300x200" alt="Sample Image" class="media-thumbnail">
                <div class="media-type-badge badge-photo">Photo</div>
                <div class="media-info">
                    <h5 class="media-title">Community Event 2025</h5>
                    <div class="media-meta">
                        <span>2.5 MB</span>
                        <span>Jan 15, 2025</span>
                    </div>
                    <div class="media-actions">
                        <button class="btn-action btn-view" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="media-card video">
                <img src="https://via.placeholder.com/300x200" alt="Sample Video" class="media-thumbnail">
                <div class="media-type-badge badge-video">Video</div>
                <div class="media-info">
                    <h5 class="media-title">Volunteer Training Session</h5>
                    <div class="media-meta">
                        <span>15.2 MB</span>
                        <span>Jan 10, 2025</span>
                    </div>
                    <div class="media-actions">
                        <button class="btn-action btn-view" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="media-card photo">
                <img src="https://via.placeholder.com/300x200" alt="Sample Image" class="media-thumbnail">
                <div class="media-type-badge badge-photo">Photo</div>
                <div class="media-info">
                    <h5 class="media-title">Team Building Activity</h5>
                    <div class="media-meta">
                        <span>3.1 MB</span>
                        <span>Jan 5, 2025</span>
                    </div>
                    <div class="media-actions">
                        <button class="btn-action btn-view" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-modern">
            <button class="page-btn disabled">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
    // Update statistics (example)
    document.getElementById('totalMedia').textContent = '3';
    document.getElementById('photoCount').textContent = '2';
    document.getElementById('videoCount').textContent = '1';
    document.getElementById('storageUsed').textContent = '20.8 MB';

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const mediaCards = document.querySelectorAll('.media-card');
        
        mediaCards.forEach(card => {
            const title = card.querySelector('.media-title').textContent.toLowerCase();
            
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter by type
    const typeFilter = document.getElementById('typeFilter');
    typeFilter.addEventListener('change', function(e) {
        const type = e.target.value;
        const mediaCards = document.querySelectorAll('.media-card');
        
        mediaCards.forEach(card => {
            if (type === 'all') {
                card.style.display = 'block';
            } else {
                const cardType = card.classList.contains(type);
                card.style.display = cardType ? 'block' : 'none';
            }
        });
    });
</script>

<?php require './components/footer.php'; ?>