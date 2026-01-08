<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Notices';
require './components/header.php';
protectPage();

// Get all notices from database using your function
$notices = getAllNotices();

// Calculate statistics from actual database data
$totalNotices = count($notices);
$activeCount = getNoticeCount('Active');
$expiredCount = getNoticeCount('Expired');
$draftCount = getNoticeCount('Draft');
$currentDate = date('Y-m-d');

// Calculate auto-expired notices (active notices that have passed expiry)
$autoExpiredCount = 0;
foreach ($notices as $notice) {
    if ($notice['status'] === 'Active') {
        $expiryDate = date('Y-m-d', strtotime("+{$notice['duration']} months", strtotime($notice['publish_date'])));
        if ($currentDate > $expiryDate) {
            $autoExpiredCount++;
        }
    }
}
?>

<!-- Add SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    /* Modern Stats Card Styles */
    .stats-card {
        position: relative;
        padding: 24px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: visible;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
        min-height: 140px;
        display: flex;
        flex-direction: column;
    }

    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 20px 20px 0 0;
    }

    .stats-card:hover::before {
        opacity: 1;
    }

    .stats-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .stats-icon i {
        font-size: 28px;
        color: #fff;
    }

    .stats-content {
        position: relative;
        z-index: 1;
        padding-right: 76px;
    }

    .stats-label {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 12px;
    }

    .stats-value {
        font-size: 36px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1.2;
    }

    /* Gradient Variants */
    .stats-gradient-primary {
        --gradient-start: #8b5cf6;
        --gradient-end: #7c3aed;
    }

    .stats-gradient-success {
        --gradient-start: #10b981;
        --gradient-end: #059669;
    }

    .stats-gradient-warning {
        --gradient-start: #f59e0b;
        --gradient-end: #d97706;
    }

    .stats-gradient-danger {
        --gradient-start: #ef4444;
        --gradient-end: #dc2626;
    }

    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #10b981, #059669);
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

    .btn-add-new {
        background: #000;
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        color: white;
        background: #fff;
        color: #000;
    }

    /* Filter Card */
    .filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.15);
    }

    /* Table Styling */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-header {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .table-header th {
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
    }
    
    .table thead th {
        background-color: #10b981 !important;
        color: #fff;
        font-size: 16px;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
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

    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
    }

    .bg-purple {
        background: linear-gradient(135deg, #a855f7, #9333ea) !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .action-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* Message Styling */
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Design */
    @media (max-width: 1199px) {
        .stats-value {
            font-size: 28px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
        }

        .stats-icon i {
            font-size: 24px;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .stats-card {
            padding: 20px;
        }

        .stats-value {
            font-size: 24px;
        }

        .stats-icon {
            width: 46px;
            height: 46px;
            top: 16px;
            right: 16px;
        }

        .stats-icon i {
            font-size: 20px;
        }

        .table {
            font-size: 0.85rem;
        }
    }

    /* Loading Animation */
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

    .stats-card,
    .filter-card,
    .table-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="donation-list">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-flag me-2"></i>All Notices</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notices</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="add-notice.php">
                    <i class="fa-solid fa-plus me-2"></i>Add New Notice
                </a>
            </div>
        </div>

        <?php
        // Display success/error messages from actions
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo '<div class="message-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    Notice operation completed successfully!
                  </div>';
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="message-box error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Error: ' . htmlspecialchars($_GET['error']) . '
                  </div>';
        }
        
        // Show info if no notices
        if ($totalNotices === 0) {
            echo '<div class="message-box info">
                    <i class="fa-solid fa-circle-info"></i>
                    No notices found. <a href="add-notice.php">Create your first notice</a>.
                  </div>';
        }
        ?>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                    <div class="stats-icon">
                        <i class="fa-solid fa-flag"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Notices</h6>
                        <h2 class="stats-value"><?= $totalNotices ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                    <div class="stats-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Active</h6>
                        <h2 class="stats-value"><?= $activeCount ?></h2>
                        <?php if ($autoExpiredCount > 0): ?>
                            <small style="color: #dc2626; font-size: 12px;">
                                <i class="fa-solid fa-clock"></i> <?= $autoExpiredCount ?> auto-expired
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                    <div class="stats-icon">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Expired</h6>
                        <h2 class="stats-value"><?= $expiredCount + $autoExpiredCount ?></h2>
                        <?php if ($autoExpiredCount > 0): ?>
                            <small style="color: #f59e0b; font-size: 12px;">
                                (<?= $expiredCount ?> marked + <?= $autoExpiredCount ?> auto)
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-warning">
                    <div class="stats-icon">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Drafts</h6>
                        <h2 class="stats-value"><?= $draftCount ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title mb-3">
                <i class="fa-solid fa-filter me-2"></i>Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder=" Search by title...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Expired">Expired</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="General">General</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Info">Information</option>
                        <option value="Announcement">Announcement</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="Education">Education</option>
                        <option value="Scholarship">Scholarship</option>
                        <option value="Health">Health</option>
                        <option value="Events">Events</option>
                        <option value="General">General</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="expiring">Expiring Soon</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Notice Table -->
        <div class="table-container mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="noticeTable">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Published Date</th>
                            <th>Duration</th>
                            <th>Age Limit</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($totalNotices > 0): ?>
                            <?php foreach ($notices as $index => $notice): 
                                // Calculate expiry date
                                $publishDate = new DateTime($notice['publish_date']);
                                $expiryDate = clone $publishDate;
                                $expiryDate->modify("+{$notice['duration']} months");
                                $expiryDateFormatted = $expiryDate->format('Y-m-d');
                                
                                // Check if notice is auto-expired
                                $isAutoExpired = ($notice['status'] === 'Active' && $currentDate > $expiryDateFormatted);
                                
                                // Determine badge color based on status
                                $statusBadgeColor = '';
                                $statusIcon = '';
                                $statusText = $notice['status'];
                                
                                if ($isAutoExpired) {
                                    $statusBadgeColor = 'danger';
                                    $statusIcon = 'clock';
                                    $statusText = 'Expired (Auto)';
                                } elseif ($notice['status'] === 'Active') {
                                    $statusBadgeColor = 'success';
                                    $statusIcon = 'circle-check';
                                } elseif ($notice['status'] === 'Draft') {
                                    $statusBadgeColor = 'warning text-dark';
                                    $statusIcon = 'file-pen';
                                } elseif ($notice['status'] === 'Expired') {
                                    $statusBadgeColor = 'danger';
                                    $statusIcon = 'circle-xmark';
                                } else {
                                    $statusBadgeColor = 'secondary';
                                    $statusIcon = 'question-circle';
                                }
                                
                                // Type badge color
                                $typeBadgeColor = '';
                                switch ($notice['type']) {
                                    case 'Urgent': $typeBadgeColor = 'danger'; break;
                                    case 'General': $typeBadgeColor = 'primary'; break;
                                    case 'Info': $typeBadgeColor = 'info'; break;
                                    case 'Announcement': $typeBadgeColor = 'purple'; break;
                                    default: $typeBadgeColor = 'secondary';
                                }
                                
                                // Category badge color
                                $categoryBadgeColor = '';
                                switch ($notice['category']) {
                                    case 'Education': $categoryBadgeColor = 'success'; break;
                                    case 'Scholarship': $categoryBadgeColor = 'info'; break;
                                    case 'Health': $categoryBadgeColor = 'danger'; break;
                                    case 'Events': $categoryBadgeColor = 'purple'; break;
                                    case 'General': $categoryBadgeColor = 'secondary'; break;
                                    default: $categoryBadgeColor = 'secondary';
                                }
                            ?>
                            <tr data-type="<?= $notice['type'] ?>" data-status="<?= $notice['status'] ?>" 
                                data-category="<?= $notice['category'] ?>" data-title="<?= strtolower($notice['title']) ?>"
                                data-expiry="<?= $expiryDateFormatted ?>">
                                <td>
                                    <div><?= $index + 1 ?></div>
                                </td>
                                <td>
                                    <strong style="color: #2c3e50;"><?= htmlspecialchars($notice['title']) ?></strong>
                                </td>
                                <td>
                                    <small style="color: #94a3b8;">
                                        <?= htmlspecialchars(substr($notice['description'], 0, 80)) ?>
                                        <?= strlen($notice['description']) > 80 ? '...' : '' ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $typeBadgeColor ?>">
                                        <i class="fa-solid fa-tag me-1"></i>
                                        <?= htmlspecialchars($notice['type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $categoryBadgeColor ?>">
                                        <i class="fa-solid fa-folder me-1"></i>
                                        <?= htmlspecialchars($notice['category']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $statusBadgeColor ?>">
                                        <i class="fa-solid fa-<?= $statusIcon ?> me-1"></i>
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        <?= date('M d, Y', strtotime($notice['publish_date'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-clock me-1"></i>
                                        <?= $notice['duration'] ?> months
                                        <?php if ($isAutoExpired): ?>
                                            <br><small class="text-danger">(Expired: <?= date('M d, Y', strtotime($expiryDateFormatted)) ?>)</small>
                                        <?php endif; ?>
                                    </small>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-user me-1"></i>
                                        <?= !empty($notice['age_limit']) ? $notice['age_limit'] : 'N/A' ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="view-notice.php?id=<?= $notice['id'] ?>" class="btn btn-sm btn-info d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit-notice.php?id=<?= $notice['id'] ?>" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-delete-notice d-inline-flex align-items-center justify-content-center p-0" 
                                            style="height: 32px; width: 32px; min-width: 32px;" 
                                            title="Delete"
                                            data-id="<?= $notice['id'] ?>"
                                            data-title="<?= htmlspecialchars($notice['title']) ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="py-5">
                                        <i class="fa-solid fa-inbox fa-3x mb-3" style="color: #cbd5e1;"></i>
                                        <h5 class="text-muted">No notices found</h5>
                                        <p class="text-muted mb-0">Start by adding your first notice</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Add SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtering functionality
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const statusFilter = document.getElementById("statusFilter");
    const categoryFilter = document.getElementById("categoryFilter");
    const sortFilter = document.getElementById("sortFilter");
    const rows = document.querySelectorAll("#noticeTable tbody tr");

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const type = typeFilter.value;
        const status = statusFilter.value;
        const category = categoryFilter.value;

        rows.forEach(row => {
            if (row.cells.length <= 1) return; // Skip the "no notices" row
            
            const title = row.dataset.title;
            const rowType = row.dataset.type;
            const rowStatus = row.dataset.status;
            const rowCategory = row.dataset.category;
            let visible = true;

            if (search && !title.includes(search)) visible = false;
            if (type !== "all" && rowType !== type) visible = false;
            if (status !== "all" && rowStatus !== status) visible = false;
            if (category !== "all" && rowCategory !== category) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    function sortTable() {
        const sortValue = sortFilter.value;
        const tbody = document.querySelector("#noticeTable tbody");
        const rowsArr = Array.from(tbody.querySelectorAll("tr"));
        
        // Filter out the "no notices" row
        const validRows = rowsArr.filter(row => row.cells.length > 1);
        
        validRows.sort((a, b) => {
            const aDate = new Date(a.querySelector('td:nth-child(7) small')?.textContent.replace('Expired: ', '').split(', ')[1] || '');
            const bDate = new Date(b.querySelector('td:nth-child(7) small')?.textContent.replace('Expired: ', '').split(', ')[1] || '');
            const aExpiry = a.dataset.expiry;
            const bExpiry = b.dataset.expiry;
            
            if (sortValue === "oldest") {
                return aDate - bDate;
            }
            if (sortValue === "expiring") {
                // Sort by expiry date (soonest first)
                const now = new Date();
                const aTime = new Date(aExpiry) - now;
                const bTime = new Date(bExpiry) - now;
                return aTime - bTime;
            }
            // newest first (default)
            return bDate - aDate;
        });

        // Reorder rows in the table
        validRows.forEach(row => tbody.appendChild(row));
    }

    // SweetAlert Delete Confirmation
    const deleteButtons = document.querySelectorAll('.btn-delete-notice');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const id = this.dataset.id;
            const title = this.dataset.title;
            const deleteUrl = `delete-notice.php?id=${id}`;
            
            Swal.fire({
                title: 'Are you sure?',
                html: `<div style="text-align: center;">
                          <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                          <p>You are about to delete the notice:</p>
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
                        window.location.href = deleteUrl;
                        resolve();
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // The redirection happens in preConfirm
                }
            });
        });
    });

    // Event listeners for filters
    [searchInput, typeFilter, statusFilter, categoryFilter].forEach(el => el.addEventListener("input", filterTable));
    sortFilter.addEventListener("change", sortTable);
    
    // Add print styles
    const style = document.createElement('style');
    style.textContent = `
        @media print {
            .page-header, .filter-card, .bulk-actions,
            .dataTables_length, .dataTables_filter, .dataTables_info,
            .dataTables_paginate, .dt-buttons, .btn-add-new,
            .action-buttons-footer, .btn-back, .btn-edit-header {
                display: none !important;
            }
            .table-container {
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
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
            }
            th {
                background-color: #f2f2f2 !important;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>

<?php require './components/footer.php'; ?>