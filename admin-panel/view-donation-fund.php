<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Donation';
require './components/header.php';



// Get donation ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
          echo"<script>window.location.href='donation-list.php'</script>";
    exit();
}

$donation_id = $_GET['id'];
$donation = getDonationById($donation_id);

if (!$donation) {
          echo"<script>window.location.href='donation-list.php?error=donation_not_found'</script>";
    exit();
}

// Get category donations for statistics
$conn = getDatabaseConnection();
$category_stats_sql = "SELECT 
    COUNT(DISTINCT id) as category_donations,
    SUM(amount) as category_total
    FROM donation_list 
    WHERE category_id = ? AND payment_status = 'completed'";
$stmt = $conn->prepare($category_stats_sql);
$stmt->bind_param("i", $donation['category_id']);
$stmt->execute();
$category_stats = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get recent donations in same category
$recent_sql = "SELECT * FROM donation_list 
    WHERE category_id = ? AND id != ? 
    ORDER BY created_at DESC 
    LIMIT 5";
$stmt = $conn->prepare($recent_sql);
$stmt->bind_param("ii", $donation['category_id'], $donation_id);
$stmt->execute();
$recent_result = $stmt->get_result();
$recent_donations = [];
while ($row = $recent_result->fetch_assoc()) {
    $recent_donations[] = $row;
}
$stmt->close();
mysqli_close($conn);

// Status badge classes
$status_classes = [
    'pending' => 'badge-pending',
    'completed' => 'badge-completed',
    'failed' => 'badge-failed',
    'cancelled' => 'badge-cancelled'
];

// Format dates
$created_date = date('F j, Y', strtotime($donation['created_at']));
$created_time = date('h:i A', strtotime($donation['created_at']));
$updated_date = !empty($donation['updated_at']) ? date('F j, Y', strtotime($donation['updated_at'])) : 'Not updated yet';
?>

<style>
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

    /* Details Card */
    .details-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Badge Styles */
    .badge-pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-completed {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-failed {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-cancelled {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-category {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-method {
        background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
        color: #6b21a8;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Info Boxes */
    .info-box {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #10b981;
    }

    .info-box h5 {
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-box h5 i {
        color: #10b981;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-weight: 600;
        min-width: 150px;
    }

    .info-value {
        color: #0f172a;
        font-weight: 500;
        text-align: right;
        flex: 1;
    }

    /* Amount Display */
    .amount-display {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 15px;
        color: white;
        margin-bottom: 2rem;
    }

    .amount-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .amount-value {
        font-size: 3rem;
        font-weight: 800;
        margin: 0;
        line-height: 1;
    }

    .amount-currency {
        font-size: 1.5rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    /* Recent Donations Table */
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

    /* Action Buttons */
    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
    }

    .btn-dark {
        background: linear-gradient(135deg, #1e293b, #374151);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-dark:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(30, 41, 59, 0.3);
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

        .details-card {
            padding: 1.5rem;
        }

        .amount-value {
            font-size: 2.5rem;
        }

        .info-row {
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            min-width: auto;
        }

        .info-value {
            text-align: left;
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

    .details-card,
    .table-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="donation-details">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-hand-holding-dollar me-2"></i>Donation Details</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="donation-list.php" class="text-decoration-none">All Donations</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Donation</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="donation-list.php" class="btn btn-info">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                    </a>
                    <a href="edit-donation.php?id=<?= $donation['id'] ?>" class="btn btn-warning">
                        <i class="fa-solid fa-edit me-2"></i>Edit Donation
                    </a>
                </div>
            </div>
        </div>

        <!-- Amount Display -->
        <div class="amount-display">
            <div class="amount-label">Donation Amount</div>
            <div class="amount-value">৳<?= number_format($donation['amount'], 2) ?></div>
        </div>

        <!-- Donation Details -->
        <div class="details-card">
            <div class="row">
                <!-- Left Column: Donor Information -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="info-box">
                        <h5><i class="fa-solid fa-user-circle"></i> Donor Information</h5>
                        
                        <div class="info-row">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value"><?= htmlspecialchars($donation['name']) ?></span>
                        </div>
                        
                        <?php if (!empty($donation['email'])): ?>
                        <div class="info-row">
                            <span class="info-label">Email Address:</span>
                            <span class="info-value"><?= htmlspecialchars($donation['email']) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($donation['contact'])): ?>
                        <div class="info-row">
                            <span class="info-label">Phone Number:</span>
                            <span class="info-value"><?= htmlspecialchars($donation['contact']) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($donation['address'])): ?>
                        <div class="info-row">
                            <span class="info-label">Address:</span>
                            <span class="info-value"><?= htmlspecialchars($donation['address']) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($donation['behalf_of'])): ?>
                        <div class="info-row">
                            <span class="info-label">Donated On Behalf Of:</span>
                            <span class="info-value"><?= htmlspecialchars($donation['behalf_of']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Donation Details -->
                <div class="col-lg-6">
                    <div class="info-box">
                        <h5><i class="fa-solid fa-hand-holding-heart"></i> Donation Details</h5>
                        
                        <div class="info-row">
                            <span class="info-label">Transaction ID:</span>
                            <span class="info-value">
                                <code><?= htmlspecialchars($donation['transaction_id']) ?></code>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Category:</span>
                            <span class="info-value">
                                <span class="badge-category">
                                    <i class="fa-solid fa-tag me-1"></i>
                                    <?= htmlspecialchars($donation['category_name'] ?? 'General') ?>
                                </span>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Payment Method:</span>
                            <span class="info-value">
                                <span class="badge-method">
                                    <i class="fa-solid fa-credit-card me-1"></i>
                                    <?= ucfirst($donation['payment_method']) ?>
                                </span>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Payment Status:</span>
                            <span class="info-value">
                                <span class="badge-<?= $donation['payment_status'] ?>">
                                    <?= ucfirst($donation['payment_status']) ?>
                                </span>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Donation Date:</span>
                            <span class="info-value"><?= $created_date ?> at <?= $created_time ?></span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Last Updated:</span>
                            <span class="info-value"><?= $updated_date ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Statistics -->
            <?php if (!empty($donation['category_id'])): ?>
            <div class="info-box mt-4">
                <h5><i class="fa-solid fa-chart-bar"></i> Category Statistics</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-row">
                            <span class="info-label">Category Donations:</span>
                            <span class="info-value"><?= $category_stats['category_donations'] ?? 0 ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <span class="info-label">Total Raised:</span>
                            <span class="info-value">৳<?= number_format($category_stats['category_total'] ?? 0, 2) ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <span class="info-label">Your Contribution:</span>
                            <span class="info-value">৳<?= number_format($donation['amount'], 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Notes Section -->
            <?php if (!empty($donation['notes'])): ?>
            <div class="info-box mt-4">
                <h5><i class="fa-solid fa-sticky-note"></i> Additional Notes</h5>
                <div class="p-3 bg-light rounded">
                    <?= nl2br(htmlspecialchars($donation['notes'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="donation-list-invoice.php?id=<?= $donation['id'] ?>" 
                   class="btn btn-dark" 
                   target="_blank">
                    <i class="fa-solid fa-file-invoice me-2"></i>Generate Invoice
                </a>
                <a href="edit-donation.php?id=<?= $donation['id'] ?>" 
                   class="btn btn-warning">
                    <i class="fa-solid fa-edit me-2"></i>Edit Donation
                </a>
                <a href="donation-list.php?delete=<?= $donation['id'] ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to delete this donation? This action cannot be undone.')">
                    <i class="fa-solid fa-trash me-2"></i>Delete Donation
                </a>
            </div>
        </div>

        <!-- Recent Donations in Same Category -->
        <?php if (!empty($recent_donations)): ?>
        <div class="table-container mt-4">
            <div class="p-4 border-bottom">
                <h5 class="mb-0">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>
                    Recent Donations in "<?= htmlspecialchars($donation['category_name'] ?? 'This Category') ?>"
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Donor Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_donations as $index => $recent): ?>
                            <tr>
                                <td>
                                    <strong style="color: #2c3e50;">#<?= str_pad($recent['id'], 3, '0', STR_PAD_LEFT) ?></strong>
                                </td>
                                <td>
                                    <strong style="color: #2c3e50;"><?= htmlspecialchars($recent['name']) ?></strong>
                                </td>
                                <td>
                                    <span class="amount-cell">৳<?= number_format($recent['amount'], 2) ?></span>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <?= date('M d, Y', strtotime($recent['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <small class="text-capitalize"><?= htmlspecialchars($recent['payment_method']) ?></small>
                                </td>
                                <td>
                                    <span class="badge-<?= $recent['payment_status'] ?>">
                                        <?= ucfirst($recent['payment_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view-donation-fund.php?id=<?= $recent['id'] ?>" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top text-center">
                <a href="donation-list.php?category_id=<?= urlencode($donation['category_name'] ?? '') ?>" 
                   class="btn btn-outline-primary">
                    View All Donations in This Category
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
// Print invoice functionality
function printInvoice() {
    window.open('donation-list-invoice.php?id=<?= $donation['id'] ?>', '_blank');
}

// Copy transaction ID
function copyTransactionId() {
    const transactionId = '<?= $donation['transaction_id'] ?>';
    navigator.clipboard.writeText(transactionId).then(() => {
        alert('Transaction ID copied to clipboard!');
    });
}
</script>

<?php require './components/footer.php'; ?>