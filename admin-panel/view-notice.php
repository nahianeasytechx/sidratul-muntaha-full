<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Notice: ' . htmlspecialchars($notice['title']);
require './components/header.php';
protectPage();

// Check if notice ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: all-notices.php?error=Notice ID is required');
    exit();
}

$notice_id = intval($_GET['id']);
$notice = getNoticeById($notice_id);

if (!$notice) {
    header('Location: all-notices.php?error=Notice not found');
    exit();
}



// Calculate expiry date
$publish_date = new DateTime($notice['publish_date']);
$expiry_date = clone $publish_date;
$expiry_date->modify("+{$notice['duration']} months");
$current_date = new DateTime();

// Determine if notice is auto-expired
$is_auto_expired = ($notice['status'] === 'Active' && $current_date > $expiry_date);

// Get actual status (accounting for auto-expiry)
$actual_status = $notice['status'];
$status_color = '';
$status_icon = '';

if ($is_auto_expired) {
    $actual_status = 'Expired (Auto)';
    $status_color = 'danger';
    $status_icon = 'clock';
} elseif ($notice['status'] === 'Active') {
    $status_color = 'success';
    $status_icon = 'circle-check';
} elseif ($notice['status'] === 'Expired') {
    $status_color = 'danger';
    $status_icon = 'circle-xmark';
} elseif ($notice['status'] === 'Draft') {
    $status_color = 'warning';
    $status_icon = 'file-pen';
} else {
    $status_color = 'secondary';
    $status_icon = 'question-circle';
}

// Determine type badge color
$type_color = '';
switch ($notice['type']) {
    case 'Urgent': $type_color = 'danger'; break;
    case 'General': $type_color = 'primary'; break;
    case 'Info': $type_color = 'info'; break;
    case 'Announcement': $type_color = 'purple'; break;
    default: $type_color = 'secondary';
}

// Determine category badge color
$category_color = '';
switch ($notice['category']) {
    case 'Education': $category_color = 'success'; break;
    case 'Scholarship': $category_color = 'info'; break;
    case 'Health': $category_color = 'danger'; break;
    case 'Events': $category_color = 'purple'; break;
    case 'General': $category_color = 'secondary'; break;
    default: $category_color = 'secondary';
}

// Get current user info (if needed for "Posted by")
$current_user = getCurrentUser();
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
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
    }

    .badge-success {
        --gradient-start: #10b981;
        --gradient-end: #059669;
    }

    .badge-danger {
        --gradient-start: #ef4444;
        --gradient-end: #dc2626;
    }

    .badge-warning {
        --gradient-start: #f59e0b;
        --gradient-end: #d97706;
    }

    .badge-primary {
        --gradient-start: #3b82f6;
        --gradient-end: #2563eb;
    }

    .badge-info {
        --gradient-start: #06b6d4;
        --gradient-end: #0891b2;
    }

    .badge-purple {
        --gradient-start: #a855f7;
        --gradient-end: #9333ea;
    }

    .badge-secondary {
        --gradient-start: #6b7280;
        --gradient-end: #4b5563;
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

    /* Info Boxes */
    .info-box-modern {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
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

    /* Status Indicator */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
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

    .message-box.info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .message-box i {
        font-size: 18px;
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
                    <a href="edit-notice.php?id=<?= $notice['id'] ?>" class="btn btn-edit-header">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Notice
                    </a>
                </div>
            </div>
        </div>

        <?php
        // Display success/error messages
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    Notice updated successfully!
                  </div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="message-box error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Error: ' . htmlspecialchars($_GET['error']) . '
                  </div>';
        }
        ?>

        <!-- Notice Details Card -->
        <div class="notice-detail-card">
            <div class="card-body">
                <!-- Notice Header -->
                <div class="notice-header-section">
                    <div style="flex: 1;">
                        <div class="mb-3">
                            <span class="badge-modern badge-<?= $status_color ?>">
                                <i class="fa-solid fa-<?= $status_icon ?> me-1"></i>
                                <?= $actual_status ?>
                            </span>
                            <span class="badge-modern badge-<?= $type_color ?>">
                                <i class="fa-solid fa-tag me-1"></i>
                                <?= htmlspecialchars($notice['type']) ?>
                            </span>
                            <span class="badge-modern badge-<?= $category_color ?>">
                                <i class="fa-solid fa-folder me-1"></i>
                                <?= htmlspecialchars($notice['category']) ?>
                            </span>
                        </div>
                        <h2 class="notice-title-main"><?= htmlspecialchars($notice['title']) ?></h2>
                        <div class="notice-meta-info">
                            <div class="meta-item-display">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Posted: <?= date('F d, Y', strtotime($notice['publish_date'])) ?></span>
                            </div>
                            <span class="text-muted">|</span>
                            <div class="meta-item-display">
                                <i class="fa-solid fa-clock"></i>
                                <span>Duration: <?= $notice['duration'] ?> months</span>
                            </div>
                            <span class="text-muted">|</span>
                            <div class="meta-item-display">
                                <i class="fa-solid fa-calendar-xmark"></i>
                                <span>Expires: <?= $expiry_date->format('F d, Y') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notice Content -->
                <div class="notice-content-section">
                    <h5 class="section-title">
                        <i class="fa-solid fa-file-lines"></i>
                        Notice Description
                    </h5>
                    <div class="content-text">
                        <?= nl2br(htmlspecialchars($notice['description'])) ?>
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
                                <div class="info-box-title">Publish Date</div>
                            </div>
                            <div class="info-box-value">
                                <?= date('F d, Y', strtotime($notice['publish_date'])) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon danger">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                </div>
                                <div class="info-box-title">Expiry Date</div>
                            </div>
                            <div class="info-box-value">
                                <?= $expiry_date->format('F d, Y') ?>
                                <?php if ($is_auto_expired): ?>
                                    <span class="badge-modern badge-danger ms-2">
                                        <i class="fa-solid fa-clock me-1"></i> Auto-Expired
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon warning">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="info-box-title">Duration</div>
                            </div>
                            <div class="info-box-value">
                                <?= $notice['duration'] ?> months
                                <?php if ($is_auto_expired): ?>
                                    <br><small class="text-danger">(Expired <?= $current_date->diff($expiry_date)->days ?> days ago)</small>
                                <?php else: ?>
                                    <?php 
                                    $days_remaining = $current_date->diff($expiry_date)->days;
                                    if ($days_remaining > 0 && $days_remaining <= 30): ?>
                                        <br><small class="text-warning">(<?= $days_remaining ?> days remaining)</small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon info">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="info-box-title">Age Limit</div>
                            </div>
                            <div class="info-box-value">
                                <?= !empty($notice['age_limit']) ? $notice['age_limit'] . ' years and above' : 'No age restriction' ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon primary">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <div class="info-box-title">Type</div>
                            </div>
                            <div class="info-box-value"><?= htmlspecialchars($notice['type']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon info">
                                    <i class="fa-solid fa-folder"></i>
                                </div>
                                <div class="info-box-title">Category</div>
                            </div>
                            <div class="info-box-value"><?= htmlspecialchars($notice['category']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box-modern">
                            <div class="info-box-header">
                                <div class="info-box-icon <?= $status_color ?>">
                                    <i class="fa-solid fa-flag"></i>
                                </div>
                                <div class="info-box-title">Status</div>
                            </div>
                            <div class="info-box-value"><?= $actual_status ?></div>
                        </div>
                    </div>
                </div>

                <!-- Created Information -->
                <div class="info-box-modern">
                    <div class="info-box-header">
                        <div class="info-box-icon secondary">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        <div class="info-box-title">Created Information</div>
                    </div>
                    <div class="info-box-value">
                        <div class="row">
                            <div class="col-md-6">
                                <small><strong>Created At:</strong> <?= date('F d, Y - h:i A', strtotime($notice['created_at'])) ?></small>
                            </div>
                            <div class="col-md-6">
                                <small><strong>Last Updated:</strong> <?= date('F d, Y - h:i A', strtotime($notice['created_at'])) ?></small>
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
                <button class="btn btn-delete-main" onclick="deleteNotice(<?= $notice['id'] ?>)">
                    <i class="fa-solid fa-trash me-2"></i> Delete
                </button>
                <a href="edit-notice.php?id=<?= $notice['id'] ?>" class="btn btn-edit-main">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Edit Notice
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteNotice(id) {
        if (confirm('Are you sure you want to delete this notice? This action cannot be undone.')) {
            window.location.href = `delete-notice.php?id=${id}&from=view`;
        }
    }

    // Add print styles
    const style = document.createElement('style');
    style.textContent = `
        @media print {
            .page-header, .action-buttons-footer, .btn-back, .btn-edit-header {
                display: none !important;
            }
            .notice-detail-card {
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