<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Gallery Management';
?>
<?php require './components/header.php'; ?>

<!-- Gallery CSS -->
<style>
    .gallery .page-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .gallery .page-header h1 {
        margin: 0;
        color: #333;
        font-weight: 700;
    }

    .gallery .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0.5rem 0 0 0;
    }

    .gallery .icon-box {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .gallery .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .gallery .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .gallery .stat-card:hover {
        transform: translateY(-5px);
    }

    .gallery .stat-card-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .gallery .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .gallery .stat-icon.photos {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .gallery .stat-icon.videos {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .gallery .stat-icon.total {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .gallery .stat-icon.storage {
        background: linear-gradient(135deg, #fa709a, #fee140);
    }

    .gallery .upload-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .gallery .section-title {
        color: #667eea;
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gallery .upload-area {
        border: 3px dashed #667eea;
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #f8f9ff;
    }

    .gallery .upload-area:hover {
        background: #f0f2ff;
        border-color: #764ba2;
    }

    .gallery .upload-area.dragover {
        background: #e8ebff;
        border-color: #764ba2;
        transform: scale(1.02);
    }

    .gallery .upload-icon {
        font-size: 4rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .gallery .upload-text {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .gallery .upload-hint {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .gallery .file-input {
        display: none;
    }

    .gallery .btn-browse {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        margin-top: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .gallery .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .gallery .filters-section {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .gallery .filter-title {
        color: #667eea;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .gallery .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .gallery .media-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        position: relative;
    }

    .gallery .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .gallery .media-thumbnail {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .gallery .media-type-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        color: white;
    }

    .gallery .badge-photo {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .gallery .badge-video {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .gallery .media-info {
        padding: 1rem;
    }

    .gallery .media-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gallery .media-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .gallery .media-actions {
        display: flex;
        gap: 0.5rem;
    }

    .gallery .btn-action {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .gallery .btn-view {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .gallery .btn-edit {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
    }

    .gallery .btn-delete {
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
    }

    .gallery .btn-action:hover {
        transform: translateY(-2px);
    }

    .gallery .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .gallery .empty-state i {
        font-size: 5rem;
        color: #e0e0e0;
        margin-bottom: 1rem;
    }

    .gallery .preview-section {
        margin-top: 2rem;
    }

    .gallery .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .gallery .preview-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        background: #f0f0f0;
        aspect-ratio: 1;
    }

    .gallery .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery .preview-remove {
        position: absolute;
        top: 5px;
        right: 5px;
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
        transition: all 0.3s;
    }

    .gallery .preview-remove:hover {
        background: rgba(239, 68, 68, 1);
        transform: scale(1.1);
    }

    .gallery .upload-progress {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .gallery .progress-bar {
        height: 8px;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .gallery .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        transition: width 0.3s;
    }

    @media (max-width: 767px) {
        .gallery .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .gallery .upload-area {
            padding: 2rem 1rem;
        }

        .gallery .upload-icon {
            font-size: 3rem;
        }
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="gallery">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
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
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Media</div>
                        <h3 class="mb-0" id="totalMedia">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon photos">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Photos</div>
                        <h3 class="mb-0" id="photoCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon videos">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Videos</div>
                        <h3 class="mb-0" id="videoCount">0</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Upload Section -->
        <div class="upload-section">
            <div class="section-title">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                Upload Media
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
                <button class="btn btn-primary mt-3" onclick="uploadFiles()">
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

        <!-- Filters -->
        <div class="filters-section">
            <div class="filter-title">
                <i class="fa-solid fa-filter"></i>
                Filter Media
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="photo">Photos</option>
                        <option value="video">Videos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="events">Events</option>
                        <option value="activities">Activities</option>
                        <option value="team">Team</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name">Name A-Z</option>
                        <option value="size">Size</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                </div>
            </div>
        </div>

        <!-- Media Grid -->
        <div class="media-grid" id="mediaGrid"></div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->



<?php require './components/footer.php'; ?>