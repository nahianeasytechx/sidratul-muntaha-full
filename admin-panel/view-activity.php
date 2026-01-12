<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Activity';
require './components/header.php';
protectPage();

// Check if activity ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: all-activities.php?error=Activity ID is required');
    exit();
}

$activity_id = intval($_GET['id']);
$activity = getActivityById($activity_id);

if (!$activity) {
    header('Location: all-activities.php?error=Activity not found');
    exit();
}

// Determine status badge color and icon
$status_color = '';
$status_icon = '';

switch ($activity['status']) {
    case 'Active':
        $status_color = 'success';
        $status_icon = 'circle-check';
        break;
    case 'Inactive':
        $status_color = 'danger';
        $status_icon = 'circle-xmark';
        break;
    case 'Draft':
        $status_color = 'warning';
        $status_icon = 'file-pen';
        break;
    case 'Completed':
        $status_color = 'info';
        $status_icon = 'circle-check';
        break;
    case 'Expired':
        $status_color = 'danger';
        $status_icon = 'circle-xmark';
        break;
    default:
        $status_color = 'secondary';
        $status_icon = 'question-circle';
}

// Determine type badge color
$type_color = '';
switch ($activity['type']) {
    case 'Regular':
        $type_color = 'primary';
        break;
    case 'Financial':
        $type_color = 'success';
        break;
    case 'Social':
        $type_color = 'info';
        break;
    case 'Community Service':
        $type_color = 'info';
        break;
    case 'Educational':
        $type_color = 'primary';
        break;
    case 'Cultural':
        $type_color = 'purple';
        break;
    case 'Sports':
        $type_color = 'info';
        break;
    case 'Environmental':
        $type_color = 'success';
        break;
    default:
        $type_color = 'secondary';
}

// Get current user info
$current_user = getCurrentUser();

// Parse sections data if available
$sections = [];
if (!empty($activity['sections_data'])) {
    $sections = json_decode($activity['sections_data'], true) ?? [];
}
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

    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    }

    .bg-purple {
        background: linear-gradient(135deg, #a855f7, #9333ea) !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
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

    /* Dynamic Sections Display */
    .dynamic-section-display {
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dynamic-section-display:hover {
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .section-display-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-display-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-display-title i {
        color: #10b981;
    }

    .section-display-body {
        padding: 24px;
        background: #fafbfc;
    }

    .section-items-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .section-items-list li {
        padding: 12px 16px;
        margin-bottom: 8px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .section-items-list li:hover {
        border-color: #10b981;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
    }

    .section-items-list li i {
        color: #10b981;
        font-size: 1rem;
    }

    .section-items-list li span {
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.6;
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

    /* Message Box */
    .message-box {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: fadeIn 0.3s ease;
    }

    .message-box.success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .message-box.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .message-box i {
        font-size: 18px;
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

    /* Print Styles */
    @media print {
        .page-header, .action-buttons-container, .btn-back, .btn-edit-header {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        body {
            background: white !important;
        }
        .content-text {
            font-size: 14px !important;
            line-height: 1.6 !important;
        }
    }
</style>

<div class="content-wrapper">
    <div class="view-activity">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-eye me-2"></i>View Project</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-activities.php" class="text-decoration-none">All Activities</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Project</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-back" onclick="window.location.href='all-activities.php'">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                    </button>
                    <a href="edit-activity.php?id=<?= $activity['id'] ?>" class="btn btn-edit-header">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Activity
                    </a>
                </div>
            </div>
        </div>

        <?php
        // Display success/error messages
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    Activity updated successfully!
                  </div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="message-box error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Error: ' . htmlspecialchars($_GET['error']) . '
                  </div>';
        }
        ?>

        <!-- Activity Details Card -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- Activity Header -->
                <div class="activity-header-section">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                <span class="badge bg-<?= $status_color ?>">
                                    <i class="fa-solid fa-<?= $status_icon ?> me-1"></i> <?= htmlspecialchars($activity['status']) ?>
                                </span>
                                <span class="badge bg-<?= $type_color ?>">
                                    <i class="fa-solid fa-tag me-1"></i> <?= htmlspecialchars($activity['type']) ?>
                                </span>
                            </div>
                            <h2><?= htmlspecialchars($activity['title']) ?></h2>
                            <div class="text-muted small">
                                <i class="fa-solid fa-calendar-days me-1"></i> Created on: <?= date('F d, Y', strtotime($activity['created_at'])) ?>
                            </div>
                        </div>
                        <div class="activity-id">
                            <div class="label">Activity ID</div>
                            <div class="value">#ACT-<?= str_pad($activity['id'], 3, '0', STR_PAD_LEFT) ?></div>
                        </div>
                    </div>
                </div>
                                                        <!-- Activity Image -->
                <?php if (!empty($activity['image'])): ?>
                <div class="activity-image">
                   <img src="../uploads/activities/<?= htmlspecialchars($activity['image']) ?>"
     alt="<?= htmlspecialchars($activity['title']) ?>"
     class="img-fluid">

                    <div class="image-caption">
                        <i class="fa-solid fa-image me-1"></i> <?= htmlspecialchars($activity['title']) ?>
                    </div>
                </div>
                <?php endif; ?>



                <!-- Activity Description with formatted content -->
                <div class="mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        Activity Description
                    </h5>
                    <div class="content-text">
                        <?php if (!empty($activity['objectives'])): ?>
                            <?= nl2br(htmlspecialchars($activity['objectives'])) ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($activity['short_description'])): ?>
                            <p><?= nl2br(htmlspecialchars($activity['short_description'])) ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($activity['description'])): ?>
                            <?= nl2br(htmlspecialchars($activity['description'])) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Dynamic Sections Display -->
                <?php if (!empty($sections) && is_array($sections)): ?>
                <div class="mb-4">
                    <?php foreach ($sections as $section): ?>
                        <?php if (!empty($section['title']) && !empty($section['items']) && is_array($section['items'])): ?>
                        <div class="mb-4">
                            <h6 style="color: #1e293b; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.75rem;">
                                <?= htmlspecialchars($section['title']) ?>:
                            </h6>
                            <ul style="padding-left: 1.5rem; margin-bottom: 1rem;">
                                <?php foreach ($section['items'] as $item): ?>
                                    <?php if (!empty($item)): ?>
                                    <li style="margin-bottom: 0.5rem; color: #475569;">
                                        <?= htmlspecialchars($item) ?>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Related Documents Section -->
                <?php if (!empty($activity['attachments'])): ?>
                <div class="mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-paperclip"></i>
                        Related Documents
                    </h5>
                    <div class="row g-3">
                        <?php 
                        $attachments = json_decode($activity['attachments'], true);
                        if (is_array($attachments)):
                            foreach ($attachments as $attachment): 
                        ?>
                        <div class="col-md-6">
                            <div class="attachment-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-pdf text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($attachment['name'] ?? 'Document') ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($attachment['size'] ?? 'N/A') ?></div>
                                    </div>
                                </div>
                                <a href="<?= htmlspecialchars($attachment['url'] ?? '#') ?>" class="btn btn-sm btn-outline-secondary" download>
                                    <i class="fa-solid fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-danger" id="deleteBtn" data-id="<?= $activity['id'] ?>" data-title="<?= htmlspecialchars($activity['title']) ?>">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    <a href="edit-activity.php?id=<?= $activity['id'] ?>" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Project
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('deleteBtn').addEventListener('click', function() {
    const id = this.dataset.id;
    const title = this.dataset.title;
    
    Swal.fire({
        title: 'Are you sure?',
        html: `<div style="text-align: center;">
                  <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                  <p>You are about to delete the activity:</p>
                  <p><strong>"${title}"</strong></p>
                  <p class="text-danger">This action cannot be undone!</p>
               </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        backdrop: true,
        allowOutsideClick: false,
        allowEscapeKey: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Redirect to delete page after confirmation
                window.location.href = `delete-activity.php?id=${id}&from=view`;
                resolve();
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // The redirection happens in preConfirm
        }
    });
});

// Add print styles
const style = document.createElement('style');
style.textContent = `
    @media print {
        .page-header, .action-buttons-container, .btn-back, .btn-edit-header {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        body {
            background: white !important;
        }
        .content-text {
            font-size: 14px !important;
            line-height: 1.6 !important;
        }
    }
`;
document.head.appendChild(style);
</script>

<?php require './components/footer.php'; ?>