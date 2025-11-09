<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Notice';
require './components/header.php';
?>

<style>
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .page-header h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .page-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        transition: color 0.3s ease;
    }

    .page-header .breadcrumb-item a:hover {
        color: white;
    }

    .page-header .breadcrumb-item.active {
        color: white;
    }

    .page-header .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Action Buttons in Header */
    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit-header {
        background: white;
        color: #10b981;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .btn-edit-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        color: #fff;
    }

    /* Main Card Styling */
    .notice-detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-body {
        padding: 2rem;
    }

    /* Notice Header Section */
    .notice-header-section {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .notice-title-main {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .notice-meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        color: #64748b;
        font-size: 0.9rem;
    }

    .meta-item-display {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .meta-item-display i {
        color: #10b981;
    }

    .notice-id-box {
        text-align: right;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
    }

    .notice-id-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .notice-id-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Badge Styles */
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .badge-active {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .badge-secondary {
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        color: #475569;
    }

    /* Content Section */
    .notice-content-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #10b981;
    }

    .content-text {
        color: #475569;
        font-size: 1rem;
        line-height: 1.8;
    }

    .content-text h6 {
        color: #1e293b;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .content-text ul {
        padding-left: 1.5rem;
    }

    .content-text li {
        margin-bottom: 0.5rem;
    }

    /* Info Boxes */
    .info-box-modern {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-box-modern:hover {
        border-color: #10b981;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.15);
    }

    .info-box-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .info-box-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .info-box-icon.primary {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .info-box-icon.danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .info-box-icon.warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .info-box-icon.info {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #3730a3;
    }

    .info-box-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .info-box-value {
        color: #64748b;
        font-size: 1rem;
        margin-left: 3.25rem;
    }

    /* Attachments Section */
    .attachment-item {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .attachment-item:hover {
        border-color: #10b981;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.15);
        transform: translateY(-2px);
    }

    .file-icon i {
        font-size: 2.5rem;
    }

    .attachment-info {
        flex-grow: 1;
    }

    .attachment-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .attachment-size {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .btn-download {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    /* Contact Section */
    .contact-section {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .contact-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-title i {
        color: #10b981;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #475569;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-item i {
        color: #10b981;
        width: 20px;
    }

    .contact-item strong {
        color: #1e293b;
        margin-right: 0.25rem;
    }

    /* Action Buttons Footer */
    .action-buttons-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-print {
        background: white;
        color: #64748b;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-print:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-delete-main {
        background: white;
        color: #ef4444;
        border: 2px solid #fee2e2;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-delete-main:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #ef4444;
        color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-edit-main {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        transition: all 0.3s ease;
    }

    .btn-edit-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .notice-header-section {
            flex-direction: column;
            gap: 1.5rem;
        }

        .notice-id-box {
            text-align: left;
        }

        .notice-title-main {
            font-size: 1.4rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .action-buttons-footer {
            flex-direction: column;
        }

        .action-buttons-footer > * {
            width: 100%;
        }
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

    .notice-detail-card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="view-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-flag me-2"></i>View Notice</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-notices.php" class="text-decoration-none">All Notices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Notice</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-back" onclick="window.location.href='all-notices.php'">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                    </button>
                    <button class="btn btn-edit-header" onclick="window.location.href='edit-notice.php?id=1'">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Notice
                    </button>
                </div>
            </div>
        </div>

        <!-- Notice Details Card -->
        <div class="notice-detail-card">
            <div class="card-body">
                <!-- Notice Header -->
                <div class="notice-header-section">
                    <div style="flex: 1;">
                        <div class="mb-3">
                            <span class="badge-modern badge-active">Active</span>
                            <span class="badge-modern badge-info">Announcement</span>
                            <span class="badge-modern badge-secondary">Administrative</span>
                        </div>
                        <h2 class="notice-title-main">Annual General Meeting 2024</h2>
                        <div class="notice-meta-info">
                            <div class="meta-item-display">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Posted: January 15, 2024</span>
                            </div>
                            <span class="text-muted">|</span>
                            <div class="meta-item-display">
                                <i class="fa-solid fa-user"></i>
                                <span>By: Admin User</span>
                            </div>
                        </div>
                    </div>
                    <div class="notice-id-box">
                        <div class="notice-id-label">Notice ID</div>
                        <div class="notice-id-value">#NOT-001</div>
                    </div>
                </div>

                <!-- Notice Content -->
                <div class="notice-content-section">
                    <h5 class="section-title">
                        <i class="fa-solid fa-file-lines"></i>
                        Notice Details
                    </h5>
                    <div class="content-text">
                        <p>Dear Members,</p>
                        <p>We are pleased to announce that the Annual General Meeting (AGM) for 2024 will be held on <strong>March 15, 2024</strong> at our main office premises.</p>
                        <p>The meeting will commence at <strong>10:00 AM</strong> and is expected to conclude by 2:00 PM. Lunch will be provided for all attendees.</p>
                        
                        <h6>Agenda:</h6>
                        <ul>
                            <li>Review of 2023 activities and achievements</li>
                            <li>Financial report and budget approval</li>
                            <li>Election of new board members</li>
                            <li>Discussion on upcoming projects for 2024</li>
                            <li>Q&A session</li>
                        </ul>

                        <p>All members are encouraged to attend and participate in this important meeting. Please confirm your attendance by replying to this notice.</p>
                        
                        <p class="mb-0">Looking forward to seeing you all there!</p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon primary">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div class="info-box-title">Valid From</div>
                            </div>
                            <div class="info-box-value">January 15, 2024</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon danger">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                </div>
                                <div class="info-box-title">Valid Until</div>
                            </div>
                            <div class="info-box-value">March 15, 2024</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon warning">
                                    <i class="fa-solid fa-flag"></i>
                                </div>
                                <div class="info-box-title">Priority Level</div>
                            </div>
                            <div class="info-box-value">High</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon info">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="info-box-title">Target Audience</div>
                            </div>
                            <div class="info-box-value">All Members</div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-paperclip"></i>
                        Attachments
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="attachment-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-pdf text-danger"></i>
                                    </div>
                                    <div class="attachment-info">
                                        <div class="attachment-name">AGM-Agenda-2024.pdf</div>
                                        <div class="attachment-size">245 KB</div>
                                    </div>
                                </div>
                                <button class="btn btn-download">
                                    <i class="fa-solid fa-download me-1"></i> Download
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attachment-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-word" style="color: #2b579a;"></i>
                                    </div>
                                    <div class="attachment-info">
                                        <div class="attachment-name">Annual-Report-2023.docx</div>
                                        <div class="attachment-size">1.2 MB</div>
                                    </div>
                                </div>
                                <button class="btn btn-download">
                                    <i class="fa-solid fa-download me-1"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="contact-section">
                    <h6 class="contact-title">
                        <i class="fa-solid fa-address-card"></i>
                        Contact Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fa-solid fa-user"></i>
                                <span><strong>Contact Person:</strong> John Doe</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fa-solid fa-envelope"></i>
                                <span><strong>Email:</strong> john.doe@organization.org</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fa-solid fa-phone"></i>
                                <span><strong>Phone:</strong> +880 1234-567890</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fa-solid fa-map-marker-alt"></i>
                                <span><strong>Location:</strong> Main Office, Dhaka</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-footer">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fa-solid fa-print me-2"></i> Print Notice
            </button>
            <div class="d-flex gap-2">
                <button class="btn btn-delete-main" onclick="if(confirm('Are you sure you want to delete this notice?')) window.location.href='all-notices.php'">
                    <i class="fa-solid fa-trash me-2"></i> Delete
                </button>
                <button class="btn btn-edit-main" onclick="window.location.href='edit-notice.php?id=1'">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Edit Notice
                </button>
            </div>
        </div>
    </div>
</div>

<?php require './components/footer.php'; ?>