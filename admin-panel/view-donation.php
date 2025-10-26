<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Donation';

// Sample data - In production, fetch from database based on ID
$donation_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Mock data for different donation IDs
$donations = [
    1 => ['serial' => '001', 'category' => 'Education', 'name' => 'Md. Rahim Uddin', 'phone' => '+880 1712-345678', 'email' => 'rahim.uddin@email.com', 'amount' => '5,000', 'transaction_id' => 'TRX123456789', 'payment_method' => 'Bkash', 'date' => '15 Sep 2024', 'address' => 'House 45, Road 12, Dhanmondi, Dhaka', 'notes' => 'Donation for student scholarship program'],
    2 => ['serial' => '002', 'category' => 'Health', 'name' => 'Fatima Khatun', 'phone' => '+880 1812-987654', 'email' => 'fatima.k@email.com', 'amount' => '10,000', 'transaction_id' => 'TRX987654321', 'payment_method' => 'Nagad', 'date' => '20 Sep 2024', 'address' => 'Flat 3B, Gulshan Avenue, Dhaka', 'notes' => 'Medical equipment donation'],
    3 => ['serial' => '003', 'category' => 'Emergency', 'name' => 'Kamal Hossain', 'phone' => '+880 1912-456789', 'email' => 'kamal.h@email.com', 'amount' => '15,000', 'transaction_id' => 'TRX456789123', 'payment_method' => 'Rocket', 'date' => '25 Sep 2024', 'address' => 'Village: Rampur, Upazila: Savar, Dhaka', 'notes' => 'Flood relief emergency fund'],
    4 => ['serial' => '004', 'category' => 'Food', 'name' => 'Ayesha Siddika', 'phone' => '+880 1612-789456', 'email' => 'ayesha.s@email.com', 'amount' => '3,000', 'transaction_id' => 'TRX789456123', 'payment_method' => 'Bkash', 'date' => '28 Sep 2024', 'address' => 'House 78, Banani, Dhaka', 'notes' => 'Monthly food distribution program'],
    5 => ['serial' => '005', 'category' => 'General', 'name' => 'Ibrahim Khan', 'phone' => '+880 1512-321654', 'email' => 'ibrahim.khan@email.com', 'amount' => '7,500', 'transaction_id' => 'TRX321654987', 'payment_method' => 'Bank Transfer', 'date' => '01 Oct 2024', 'address' => 'Plot 23, Mirpur DOHS, Dhaka', 'notes' => 'General welfare fund'],
];

$donation = isset($donations[$donation_id]) ? $donations[$donation_id] : $donations[1];

// Mock previous donations by the same person
$previous_donations = [
    ['date' => '15 Aug 2024', 'amount' => '3,000', 'category' => 'Education', 'transaction_id' => 'TRX987123456'],
    ['date' => '10 Jul 2024', 'amount' => '2,000', 'category' => 'Health', 'transaction_id' => 'TRX456789321'],
    ['date' => '05 Jun 2024', 'amount' => '5,000', 'category' => 'General', 'transaction_id' => 'TRX789321654'],
];
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="view-donation-wrapper">
        <!-- Back Button -->
        <a href="donation-list.php" class="back-button">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Donation List
        </a>

        <!-- Donation Details Card -->
        <div class="donation-detail-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <h2>Donation Details</h2>
                    <p>Complete information about this donation</p>
                </div>
                <div class="serial-badge">Serial: #<?php echo $donation['serial']; ?></div>
                <button class="edit-btn-header" onclick="window.location.href='edit-donation.php?id=<?php echo $donation_id; ?>'">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit Donation
                </button>
            </div>

            <div class="card-body-custom">
                <!-- Donor Information Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fa-solid fa-user"></i>
                        Donor Information
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Donor Name</div>
                            <div class="detail-value"><?php echo $donation['name']; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">
                                <i class="fa-solid fa-phone me-2"></i><?php echo $donation['phone']; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donation Information Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        Donation Information
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Category</div>
                            <div class="detail-value">
                                <span class="category-badge-view badge-<?php echo strtolower($donation['category']); ?>">
                                    <?php echo $donation['category']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Donation Amount</div>
                            <div class="detail-value amount">৳ <?php echo $donation['amount']; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Donation Date</div>
                            <div class="detail-value">
                                <i class="fa-solid fa-calendar me-2"></i><?php echo $donation['date']; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information Section -->
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fa-solid fa-credit-card"></i>
                        Payment Information
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">
                                <i class="fa-solid fa-wallet me-2"></i><?php echo $donation['payment_method']; ?>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Transaction ID</div>
                            <div class="detail-value">
                                <code style="background: none; color: #0d7a3f; font-size: 15px; font-weight: 600;">
                                    <?php echo $donation['transaction_id']; ?>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <?php if (!empty($donation['notes'])): ?>
                <div class="detail-section">
                    <div class="section-title">
                        <i class="fa-solid fa-note-sticky"></i>
                        Additional Notes
                    </div>
                    <div class="notes-box">
                        <i class="fa-solid fa-quote-left me-2"></i>
                        <?php echo $donation['notes']; ?>
                        <i class="fa-solid fa-quote-right ms-2"></i>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Previous Donations by This Donor -->
        <div class="previous-donations-card">
            <div class="previous-header">
                <h3>
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Previous Donations by <?php echo $donation['name']; ?>
                </h3>
            </div>
            <div class="previous-body">
                <?php if (!empty($previous_donations)): ?>
                    <table class="previous-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($previous_donations as $prev): ?>
                            <tr>
                                <td>
                                    <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                    <?php echo $prev['date']; ?>
                                </td>
                                <td>
                                    <span class="category-badge-view badge-<?php echo strtolower($prev['category']); ?>">
                                        <?php echo $prev['category']; ?>
                                    </span>
                                </td>
                                <td class="amount-cell">৳ <?php echo $prev['amount']; ?></td>
                                <td>
                                    <code style="font-size: 13px;"><?php echo $prev['transaction_id']; ?></code>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-previous">
                        <i class="fa-solid fa-inbox"></i>
                        <p>No previous donations found for this donor.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-bottom mt-4">
            <button class="btn-action btn-edit" onclick="window.location.href='edit-donation.php?id=<?php echo $donation_id; ?>'">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit This Donation
            </button>
            <button class="btn-action btn-back" onclick="window.location.href='donation-list.php'">
                <i class="fa-solid fa-arrow-left"></i>
                Back to List
            </button>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require './components/footer.php'; ?>