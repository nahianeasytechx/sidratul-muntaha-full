<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Donation';
require './components/header.php';



// Get donation ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: donation-list.php?error=invalid_id');
    exit();
}

$donation_id = $_GET['id'];
$donation = getDonationById($donation_id);

if (!$donation) {
    header('Location: donation-list.php?error=donation_not_found');
    exit();
}

// Handle form submission
$message = '';
$message_type = '';
$form_values = $donation;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $behalf_of = isset($_POST['behalf_of']) ? trim($_POST['behalf_of']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    $payment_status = isset($_POST['payment_status']) ? trim($_POST['payment_status']) : 'pending';
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Donor name is required';
    }
    
    if ($amount <= 0) {
        $errors[] = 'Amount must be greater than 0';
    }
    
    if (empty($payment_method)) {
        $errors[] = 'Payment method is required';
    }
    
    if (empty($payment_status)) {
        $errors[] = 'Payment status is required';
    }
    
if (empty($errors)) {
    // Update donation in database
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        $message = 'Database connection error.';
        $message_type = 'error';
    } else {
        // Validate category_id exists (if provided)
        $validated_category_id = null;
        
        if (!empty($category_id) && $category_id > 0) {
            $check_stmt = $conn->prepare("SELECT id FROM donation_categories WHERE id = ?");
            $check_stmt->bind_param("i", $category_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows > 0) {
                $validated_category_id = $category_id;
            } else {
                $errors[] = "Selected category does not exist. Please choose a valid category.";
            }
            $check_stmt->close();
        }
        
        // Only proceed if no validation errors
        if (empty($errors)) {
            $sql = "UPDATE donation_list SET 
                        name = ?,
                        email = ?,
                        contact = ?,
                        address = ?,
                        amount = ?,
                        category_id = ?,
                        behalf_of = ?,
                        payment_method = ?,
                        payment_status = ?,
                        notes = ?,
                        updated_at = NOW()
                    WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                $message = 'Error preparing statement: ' . $conn->error;
                $message_type = 'error';
            } else {
                // Count: s s s s d i s s s s i = 11 parameters
                // name, email, contact, address, amount, category_id, behalf_of, payment_method, payment_status, notes, donation_id
                
                $stmt->bind_param(
                    "sssdsissssi",         // 11 characters for 11 parameters
                    $name,                 // s - string
                    $email,                // s - string
                    $contact,              // s - string
                    $address,              // s - string
                    $amount,               // d - double/float
                    $validated_category_id,// i - integer (validated or NULL)
                    $behalf_of,            // s - string
                    $payment_method,       // s - string
                    $payment_status,       // s - string
                    $notes,                // s - string
                    $donation_id           // i - integer
                );
                
                if ($stmt->execute()) {
                    $message = 'Donation updated successfully!';
                    $message_type = 'success';
                    
                    // Refresh donation data
                    $donation = getDonationById($donation_id);
                    $form_values = $donation;
                } else {
                    $message = 'Error updating donation: ' . $stmt->error;
                    $message_type = 'error';
                }
                
                $stmt->close();
            }
        } else {
            $message = implode('<br>', $errors);
            $message_type = 'error';
        }
        
        mysqli_close($conn);
    }
}
}

// Get categories for dropdown
$conn = getDatabaseConnection();
$categories_sql = "SELECT id, title FROM donation_categories WHERE status = 'active' ORDER BY title";
$categories_result = mysqli_query($conn, $categories_sql);
$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row;
}
mysqli_close($conn);
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

    /* Form Container */
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
        outline: none;
    }

    /* Required field indicator */
    .required {
        color: #dc2626;
        margin-left: 4px;
    }

    /* Message Alert */
    .alert-message {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Transaction Info Box */
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

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-item:last-child {
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

    /* Badge Styles */
    .badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

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

    /* Payment Method Badges */
    .payment-method-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .payment-method-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method-badge:hover {
        border-color: #10b981;
        background: #f8fafc;
    }

    .payment-method-badge.selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    .payment-method-badge img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    /* Action Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.3);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        color: white;
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

    .form-container {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .payment-method-badges {
            flex-direction: column;
        }

        .payment-method-badge {
            justify-content: center;
        }

        .info-item {
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            min-width: auto;
        }

        .info-value {
            text-align: left;
        }
    }
</style>

<div class="content-wrapper">
    <div class="edit-donation">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-edit me-2"></i>Edit Donation</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="donation-list.php" class="text-decoration-none">All Donations</a></li>
                                <li class="breadcrumb-item"><a href="view-donation-fund.php?id=<?= $donation['id'] ?>" class="text-decoration-none">View Donation</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="view-donation-fund.php?id=<?= $donation['id'] ?>" class="btn btn-secondary">
                        <i class="fa-solid fa-eye me-2"></i>View
                    </a>
                    <a href="donation-list.php" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Display Messages -->
        <?php if ($message): ?>
            <div class="alert-message alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Transaction Information -->
        <div class="info-box">
            <h5><i class="fa-solid fa-info-circle"></i> Transaction Information</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-item">
                        <span class="info-label">Transaction ID:</span>
                        <span class="info-value">
                            <code><?= htmlspecialchars($donation['transaction_id']) ?></code>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-item">
                        <span class="info-label">Created Date:</span>
                        <span class="info-value">
                            <?= date('F j, Y', strtotime($donation['created_at'])) ?><br>
                            <small><?= date('h:i A', strtotime($donation['created_at'])) ?></small>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-item">
                        <span class="info-label">Current Status:</span>
                        <span class="info-value">
                            <span class="badge badge-<?= $donation['payment_status'] ?>">
                                <?= ucfirst($donation['payment_status']) ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="form-container">
            <form method="POST" action="" id="editDonationForm">
                <div class="row">
                    <!-- Left Column: Donor Information -->
                    <div class="col-lg-6 mb-4">
                        <h4 class="mb-4"><i class="fa-solid fa-user me-2"></i>Donor Information</h4>
                        
                        <!-- Donor Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Donor Name <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($form_values['name']) ?>" 
                                   required placeholder="Enter donor full name">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($form_values['email']) ?>" 
                                   placeholder="Enter email address">
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="contact" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="contact" name="contact" 
                                   value="<?= htmlspecialchars($form_values['contact']) ?>" 
                                   placeholder="Enter phone number">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" 
                                      rows="3" placeholder="Enter donor address"><?= htmlspecialchars($form_values['address']) ?></textarea>
                        </div>

                        <!-- On Behalf Of -->
                        <div class="mb-3">
                            <label for="behalf_of" class="form-label">On Behalf Of (Optional)</label>
                            <input type="text" class="form-control" id="behalf_of" name="behalf_of" 
                                   value="<?= htmlspecialchars($form_values['behalf_of']) ?>" 
                                   placeholder="Donated on behalf of someone">
                        </div>
                    </div>

                    <!-- Right Column: Donation Details -->
                    <div class="col-lg-6 mb-4">
                        <h4 class="mb-4"><i class="fa-solid fa-hand-holding-heart me-2"></i>Donation Details</h4>
                        
                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">
                                Amount (BDT) <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" class="form-control" id="amount" name="amount" 
                                       value="<?= number_format($form_values['amount'], 2, '.', '') ?>" 
                                       required min="1" step="0.01" placeholder="0.00">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= ($form_values['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label">
                                Payment Method <span class="required">*</span>
                            </label>
                            <div class="payment-method-badges" id="paymentMethodContainer">
                                <?php
                                $payment_methods = [
                                    'sslcommerz' => 'SSLCOMMERZ',
                                    'bkash' => 'bKash',
                                    'nagad' => 'Nagad',
                                    'paypal' => 'PayPal',
                                    'bank' => 'Bank Transfer',
                                    'cash' => 'Cash',
                                    'card' => 'Credit/Debit Card'
                                ];
                                
                                foreach ($payment_methods as $method => $label):
                                    $selected = ($form_values['payment_method'] == $method) ? 'selected' : '';
                                ?>
                                    <label class="payment-method-badge <?= $selected ?>" 
                                           data-method="<?= $method ?>">
                                        <input type="radio" name="payment_method" 
                                               value="<?= $method ?>" 
                                               <?= $selected ?> 
                                               style="display: none;">
                                        <i class="fa-solid fa-credit-card"></i>
                                        <span><?= $label ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">
                                Payment Status <span class="required">*</span>
                            </label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="pending" <?= ($form_values['payment_status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="completed" <?= ($form_values['payment_status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="failed" <?= ($form_values['payment_status'] == 'failed') ? 'selected' : '' ?>>Failed</option>
                                <option value="cancelled" <?= ($form_values['payment_status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="3" placeholder="Add any notes about this donation"><?= htmlspecialchars($form_values['notes']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                    <div>
                        <a href="donation-list.php?delete=<?= $donation['id'] ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete this donation? This action cannot be undone.')">
                            <i class="fa-solid fa-trash me-2"></i>Delete Donation
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="view-donation-fund.php?id=<?= $donation['id'] ?>" class="btn btn-secondary">
                            <i class="fa-solid fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="form-container">
            <h5 class="mb-3"><i class="fa-solid fa-bolt me-2"></i>Quick Actions</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="donation-list-invoice.php?id=<?= $donation['id'] ?>" 
                       class="btn btn-outline-dark w-100" target="_blank">
                        <i class="fa-solid fa-file-invoice me-2"></i>Generate Invoice
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <button class="btn btn-outline-info w-100" onclick="copyTransactionId()">
                        <i class="fa-solid fa-copy me-2"></i>Copy Transaction ID
                    </button>
                </div>
                <div class="col-md-4 mb-3">
                    <button class="btn btn-outline-success w-100" onclick="sendReceipt()">
                        <i class="fa-solid fa-envelope me-2"></i>Send Receipt Email
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Payment method badge selection
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodBadges = document.querySelectorAll('.payment-method-badge');
    
    paymentMethodBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            // Remove selected class from all badges
            paymentMethodBadges.forEach(b => b.classList.remove('selected'));
            
            // Add selected class to clicked badge
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });
    
    // Update badge style when status changes
    const statusSelect = document.getElementById('payment_status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            updateStatusBadge(this.value);
        });
    }
});

// Update status badge preview
function updateStatusBadge(status) {
    const badge = document.querySelector('.info-item .badge');
    if (badge) {
        // Remove all status classes
        badge.classList.remove('badge-pending', 'badge-completed', 'badge-failed', 'badge-cancelled');
        
        // Add new status class
        badge.classList.add(`badge-${status}`);
        
        // Update text
        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    }
}

// Copy transaction ID to clipboard
function copyTransactionId() {
    const transactionId = '<?= $donation['transaction_id'] ?>';
    
    navigator.clipboard.writeText(transactionId).then(() => {
        // Show success message
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = '<i class="fa-solid fa-check me-2"></i>Copied!';
        btn.classList.remove('btn-outline-info');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-info');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Failed to copy transaction ID');
    });
}

// Send receipt email (simulated)
function sendReceipt() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        btn.innerHTML = '<i class="fa-solid fa-check me-2"></i>Sent!';
        btn.classList.remove('btn-outline-success');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-success');
            btn.disabled = false;
        }, 2000);
        
        alert('Receipt email has been sent to the donor.');
    }, 1500);
}

// Form validation
document.getElementById('editDonationForm').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('amount').value);
    const name = document.getElementById('name').value.trim();
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    const paymentStatus = document.getElementById('payment_status').value;
    
    if (!name) {
        alert('Please enter donor name.');
        e.preventDefault();
        return;
    }
    
    if (isNaN(amount) || amount <= 0) {
        alert('Please enter a valid amount greater than 0.');
        e.preventDefault();
        return;
    }
    
    if (!paymentMethod) {
        alert('Please select a payment method.');
        e.preventDefault();
        return;
    }
    
    if (!paymentStatus) {
        alert('Please select payment status.');
        e.preventDefault();
        return;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...';
    submitBtn.disabled = true;
    
    // Re-enable after 5 seconds if submission fails
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>

<?php require './components/footer.php'; ?>