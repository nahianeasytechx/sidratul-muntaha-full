<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Activity';
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

    /* Header Buttons */
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
        background: #000;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-edit-header:hover {
        background: #fff;
        color: #000;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card-body {
        padding: 2rem;
    }

    /* Activity Header Section */
    .activity-header-section {
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 2rem;
    }

    .activity-header-section h2 {
        color: #1e293b;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .activity-id {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-align: center;
    }

    .activity-id .label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .activity-id .value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-top: 0.25rem;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .bg-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    /* Activity Image */
    .activity-image {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .activity-image img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px;
    }

    .image-caption {
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        color: #64748b;
        font-size: 0.9rem;
        text-align: center;
    }

    /* Content Sections */
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
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

    .content-text p {
        margin-bottom: 1rem;
    }

    .content-text h6 {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.1rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .content-text ul {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .content-text ul li {
        margin-bottom: 0.5rem;
        color: #475569;
    }

    .content-text strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        border-color: #10b981;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.1);
    }

    .info-item .icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .info-item .icon i {
        font-size: 1.5rem;
        color: white;
    }

    .info-item .label {
        font-size: 0.85rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .info-item .value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Attachment Item */
    .attachment-item {
        background: #f8f9fa;
        border: 2px solid #e9ecef !important;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .attachment-item:hover {
        border-color: #10b981 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .attachment-item .file-icon i {
        font-size: 2.5rem;
    }

    .attachment-item .fw-semibold {
        color: #1e293b;
        font-weight: 600;
    }

    /* Contact Section */
    .contact-section {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e9ecef;
    }

    .contact-section h6 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
    }

    .contact-section .row > div {
        margin-bottom: 1rem;
    }

    .contact-section i {
        color: #10b981;
    }

    .contact-section strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* Button Styling */
    .btn {
        border-radius: 10px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    .btn-outline-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e9ecef;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-2px);
    }

    .btn-outline-info {
        background: white;
        color: #0891b2;
        border: 2px solid #bae6fd;
    }

    .btn-outline-info:hover {
        background: linear-gradient(135deg, #cffafe, #bae6fd);
        border-color: #0891b2;
        color: #0e7490;
        transform: translateY(-2px);
    }

    .btn-outline-danger {
        background: white;
        color: #ef4444;
        border: 2px solid #fee2e2;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #ef4444;
        color: #dc2626;
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    /* Action Buttons Container */
    .action-buttons-container {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .page-header h1 {
            font-size: 1.3rem;
        }

        .activity-header-section h2 {
            font-size: 1.4rem;
        }

        .action-buttons-container {
            padding: 1rem;
        }

        .action-buttons-container .d-flex {
            flex-direction: column;
            gap: 1rem;
        }

        .action-buttons-container .btn {
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

    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="view-activity">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-eye me-2"></i>View Activity</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-activities.php" class="text-decoration-none">All Activities</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Activity</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-back" onclick="window.location.href='all-activities.php'">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                    </button>
                    <button class="btn btn-edit-header" onclick="window.location.href='edit-activity.php'">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Activity
                    </button>
                </div>
            </div>
        </div>

        <!-- Activity Details Card -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- Activity Header -->
                <div class="activity-header-section">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                <span class="badge bg-success">
                                    <i class="fa-solid fa-circle-check me-1"></i> Active
                                </span>
                                <span class="badge bg-info">
                                    <i class="fa-solid fa-tag me-1"></i> Community Service
                                </span>
                                <span class="badge bg-warning text-dark">
                                    <i class="fa-solid fa-spinner me-1"></i> Ongoing
                                </span>
                            </div>
                            <h2>Tree Plantation Drive 2024</h2>
                            <div class="text-muted small">
                                <i class="fa-solid fa-calendar-days me-1"></i> Created on: January 10, 2024
                                <span class="mx-2">|</span>
                                <i class="fa-solid fa-user me-1"></i> By: Admin User
                            </div>
                        </div>
                        <div class="activity-id">
                            <div class="label">Activity ID</div>
                            <div class="value">#ACT-001</div>
                        </div>
                    </div>
                </div>

                <!-- Activity Image -->
                <div class="activity-image">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1200&h=600&fit=crop" alt="Tree Plantation Drive" class="img-fluid">
                    <div class="image-caption">
                        <i class="fa-solid fa-image me-1"></i> Tree Plantation Drive - Community Volunteer Event
                    </div>
                </div>

                <!-- Activity Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="icon">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <div class="label">Activity Date</div>
                        <div class="value">March 15, 2024</div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="label">Time</div>
                        <div class="value">9:00 AM - 2:00 PM</div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="label">Location</div>
                        <div class="value">Central Park, Dhaka</div>
                    </div>
                    <div class="info-item">
                        <div class="icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="label">Participants</div>
                        <div class="value">85 / 150</div>
                    </div>
                </div>

                <!-- Activity Description -->
                <div class="mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        Activity Description
                    </h5>
                    <div class="content-text">
                        <p>Join us for our annual Tree Plantation Drive 2024, a community initiative aimed at creating a greener and more sustainable environment for future generations.</p>

                        <p>This year, we aim to plant <strong>1,000 trees</strong> across various locations in Dhaka. The plantation drive will focus on native species that are well-adapted to our local climate and require minimal maintenance.</p>

                        <h6>Event Highlights:</h6>
                        <ul>
                            <li>Plant native tree species in designated areas</li>
                            <li>Educational sessions on environmental conservation</li>
                            <li>Community engagement and team building activities</li>
                            <li>Refreshments and certificates for all participants</li>
                            <li>Photo opportunities and media coverage</li>
                        </ul>

                        <h6>What to Bring:</h6>
                        <ul>
                            <li>Comfortable outdoor clothing and closed-toe shoes</li>
                            <li>Water bottle and sun protection (hat, sunscreen)</li>
                            <li>Gardening gloves (if available)</li>
                            <li>Enthusiasm and positive energy!</li>
                        </ul>

                        <p>This is a great opportunity to give back to the community, meet like-minded individuals, and make a lasting environmental impact. All ages are welcome, and families are encouraged to participate together.</p>

                        <p class="mb-0"><strong>Note:</strong> Registration is required. Please sign up by February 20, 2024.</p>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-paperclip"></i>
                        Related Documents
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="attachment-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-pdf text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Activity-Guidelines.pdf</div>
                                        <div class="text-muted small">320 KB</div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attachment-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-excel text-success"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Participant-List.xlsx</div>
                                        <div class="text-muted small">145 KB</div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="contact-section">
                    <h6>
                        <i class="fa-solid fa-address-card me-2"></i>Contact Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa-solid fa-user me-2"></i>
                            <strong>Coordinator:</strong> Sarah Johnson
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-envelope me-2"></i>
                            <strong>Email:</strong> sarah.j@organization.org
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-phone me-2"></i>
                            <strong>Phone:</strong> +880 1987-654321
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-globe me-2"></i>
                            <strong>Website:</strong> www.organization.org/events
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="fa-solid fa-share-nodes"></i> Share
                    </button>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this activity?')) window.location.href='all-activities.php'">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-primary" onclick="window.location.href='edit-activity.php?id=1'">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Activity
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './components/footer.php'; ?>