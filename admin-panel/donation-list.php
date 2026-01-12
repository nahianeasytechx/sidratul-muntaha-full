<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donation List';
require './components/header.php';





// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $result = deleteDonation($_GET['delete']);
    $message = $result['message'];
    $message_type = $result['success'] ? 'success' : 'error';
    
    // Show message if any
    if ($message) {
        echo '<script>alert("' . addslashes($message) . '");</script>';
    }
}

// Get filter parameters
$filters = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $filters['search'] = $_GET['search'];
}
if (isset($_GET['payment_status']) && !empty($_GET['payment_status'])) {
    $filters['payment_status'] = $_GET['payment_status'];
}
if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $filters['category_id'] = $_GET['category_id'];
}
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $filters['start_date'] = $_GET['start_date'];
}
if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $filters['end_date'] = $_GET['end_date'];
}

// Get donations from database
$donations = getAllDonations($filters);

// Get statistics
$stats_all = getDonationStatistics('all');
$stats_month = getDonationStatistics('month');
$stats_today = getDonationStatistics('today');

// Get unique donors count
$conn = getDatabaseConnection();
$donors_sql = "SELECT COUNT(DISTINCT email) as total_donors FROM donation_list WHERE email IS NOT NULL AND email != ''";
$donors_result = mysqli_query($conn, $donors_sql);
$donors_data = $donors_result->fetch_assoc();
$total_donors = $donors_data['total_donors'] ?? 0;
mysqli_close($conn);

// Get categories for filter
$categories = getDonationsByCategory(100); // Get all categories
?>

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

    .stats-gradient-danger {
        --gradient-start: #ef4444;
        --gradient-end: #dc2626;
    }

    .stats-gradient-warning {
        --gradient-start: #f59e0b;
        --gradient-end: #d97706;
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
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
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
        background: linear-gradient(135deg, #10b981, #059669);
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

    /* Badge Styles for Status */
    .badge-pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .badge-completed {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-failed {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .badge-cancelled {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        color: #374151;
    }

    /* Category Badges */
    .badge-category {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    /* Transaction Code Styling */
    .trx-code {
        background: #f8f9fa;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #475569;
        font-weight: 600;
        border: 1px solid #e9ecef;
    }

    /* Amount Cell Styling */
    .amount-cell {
        font-weight: 700;
        color: #10b981;
        font-size: 1rem;
    }

    /* Action Buttons */
    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-dark {
        background: linear-gradient(135deg, #1e293b, #374151);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-sm {
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
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
         <div class="feature-alert alert alert-danger fs-1">
    ⚠️ Feature in Progress
</div>
    <div class="donation-list">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-hand-holding-dollar me-2"></i>Donation List</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Donations</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="donate.php">
                    <i class="fa-solid fa-plus me-2"></i>Add New Donation
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                    <div class="stats-icon">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Donations</h6>
                        <h2 class="stats-value"><?= $stats_all['total_donations'] ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                    <div class="stats-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Amount</h6>
                        <h2 class="stats-value">৳<?= number_format($stats_all['total_amount'] ?? 0, 2) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                    <div class="stats-icon">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">This Month</h6>
                        <h2 class="stats-value">৳<?= number_format($stats_month['total_amount'] ?? 0, 2) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-warning">
                    <div class="stats-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Donors</h6>
                        <h2 class="stats-value"><?= $total_donors ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title mb-3">
                <i class="fa-solid fa-filter me-2"></i>Filters & Search
            </div>
            <form method="GET" action="">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search by name, email, phone, or transaction ID"
                               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="payment_status">
                            <option value="">All Status</option>
                            <option value="pending" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="completed" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="failed" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'failed' ? 'selected' : '' ?>>Failed</option>
                            <option value="cancelled" <?= isset($_GET['payment_status']) && $_GET['payment_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="category_id">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <?php if (!empty($category['category_name'])): ?>
                                    <option value="<?= $category['category_name'] ?>" 
                                            <?= isset($_GET['category_id']) && $_GET['category_id'] == $category['category_name'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="start_date" 
                               value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>"
                               placeholder="Start Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="end_date" 
                               value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>"
                               placeholder="End Date">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100">Filter</button>
                    </div>
                </div>
            </form>
            <?php if (!empty($_GET)): ?>
                <div class="mt-3">
                    <a href="donation-list.php" class="btn btn-sm btn-outline-danger">Clear Filters</a>
                    <small class="text-muted ms-2">Showing <?= count($donations) ?> donation(s)</small>
                </div>
            <?php endif; ?>
        </div>

        <!-- Donation Table -->
        <div class="table-container mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Donor Name</th>
                            <th>Contact Info</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Transaction ID</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($donations)): ?>
                            <tr>
                                <td colspan="12" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-inbox fa-2x mb-3"></i>
                                        <p class="mb-0">No donations found</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($donations as $index => $donation): ?>
                                <tr>
                                    <td>
                                        <strong style="color: #2c3e50;">#<?= str_pad($donation['id'], 3, '0', STR_PAD_LEFT) ?></strong>
                                    </td>
                                    <td>
                                        <small style="color: #64748b;">
                                            <?= date('M d, Y', strtotime($donation['created_at'])) ?><br>
                                            <small class="text-muted"><?= date('h:i A', strtotime($donation['created_at'])) ?></small>
                                        </small>
                                    </td>
                                    <td>
                                        <strong style="color: #2c3e50;"><?= htmlspecialchars($donation['name']) ?></strong>
                                        <?php if (!empty($donation['behalf_of'])): ?>
                                            <br>
                                            <small class="text-muted">On behalf of: <?= htmlspecialchars($donation['behalf_of']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($donation['email'])): ?>
                                            <small style="color: #64748b;">
                                                <i class="fa-solid fa-envelope me-1"></i>
                                                <?= htmlspecialchars($donation['email']) ?>
                                            </small><br>
                                        <?php endif; ?>
                                        <?php if (!empty($donation['contact'])): ?>
                                            <small style="color: #64748b;">
                                                <i class="fa-solid fa-phone me-1"></i>
                                                <?= htmlspecialchars($donation['contact']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($donation['category_name'])): ?>
                                            <span class="badge badge-category">
                                                <i class="fa-solid fa-tag me-1"></i>
                                                <?= htmlspecialchars($donation['category_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="amount-cell">৳<?= number_format($donation['amount'], 2) ?></span>
                                    </td>
                                    <td>
                                        <small class="text-capitalize"><?= htmlspecialchars($donation['payment_method']) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $donation['payment_status'] ?>">
                                            <?= ucfirst($donation['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <code class="trx-code"><?= htmlspecialchars($donation['transaction_id']) ?></code>
                                    </td>
                                    <td>
                                        <!-- Invoice Button -->
                                        <a href="donation-list-invoice.php?id=<?= $donation['id'] ?>" 
                                           class="btn btn-sm btn-dark d-inline-flex align-items-center justify-content-center p-0" 
                                           style="height: 32px; width: 32px; min-width: 32px;" 
                                           title="Invoice" 
                                           target="_blank">
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- View Button - Goes to separate page -->
                                        <a href="view-donation-fund.php?id=<?= $donation['id'] ?>" 
                                           class="btn btn-sm btn-info d-inline-flex align-items-center justify-content-center p-0" 
                                           style="height: 32px; width: 32px; min-width: 32px;" 
                                           title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Edit Button - Goes to separate page -->
                                        <a href="edit-donation.php?id=<?= $donation['id'] ?>" 
                                           class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center p-0" 
                                           style="height: 32px; width: 32px; min-width: 32px;" 
                                           title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Delete Button - Simple link to delete -->
                                        <a href="donation-list.php?delete=<?= $donation['id'] ?>" 
                                           class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center p-0" 
                                           style="height: 32px; width: 32px; min-width: 32px;" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete donation #<?= $donation['id'] ?>? This action cannot be undone.')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
// Simple confirmation for delete
function confirmDelete(id) {
    return confirm('Are you sure you want to delete donation #' + id + '? This action cannot be undone.');
}
</script>

<?php require './components/footer.php'; ?>