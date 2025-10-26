<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Donation';

// Sample data - In production, fetch from database based on ID
$donation_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Mock data for different donation IDs
$donations = [
    1 => ['serial' => '001', 'category' => 'education', 'name' => 'Md. Rahim Uddin', 'phone' => '+880 1712-345678', 'amount' => '5000', 'transaction_id' => 'TRX123456789'],
    2 => ['serial' => '002', 'category' => 'health', 'name' => 'Fatima Khatun', 'phone' => '+880 1812-987654', 'amount' => '10000', 'transaction_id' => 'TRX987654321'],
    3 => ['serial' => '003', 'category' => 'emergency', 'name' => 'Kamal Hossain', 'phone' => '+880 1912-456789', 'amount' => '15000', 'transaction_id' => 'TRX456789123'],
    4 => ['serial' => '004', 'category' => 'food', 'name' => 'Ayesha Siddika', 'phone' => '+880 1612-789456', 'amount' => '3000', 'transaction_id' => 'TRX789456123'],
    5 => ['serial' => '005', 'category' => 'general', 'name' => 'Ibrahim Khan', 'phone' => '+880 1512-321654', 'amount' => '7500', 'transaction_id' => 'TRX321654987'],
    6 => ['serial' => '006', 'category' => 'education', 'name' => 'Nasrin Akter', 'phone' => '+880 1712-654321', 'amount' => '2000', 'transaction_id' => 'TRX654321789'],
    7 => ['serial' => '007', 'category' => 'health', 'name' => 'Mizanur Rahman', 'phone' => '+880 1812-147258', 'amount' => '12000', 'transaction_id' => 'TRX147258369'],
    8 => ['serial' => '008', 'category' => 'food', 'name' => 'Sultana Begum', 'phone' => '+880 1912-963852', 'amount' => '4500', 'transaction_id' => 'TRX963852741'],
    9 => ['serial' => '009', 'category' => 'emergency', 'name' => 'Abdul Jabbar', 'phone' => '+880 1612-852963', 'amount' => '20000', 'transaction_id' => 'TRX852963147'],
    10 => ['serial' => '010', 'category' => 'general', 'name' => 'Sabina Yasmin', 'phone' => '+880 1512-741852', 'amount' => '6000', 'transaction_id' => 'TRX741852963'],
];

$donation = isset($donations[$donation_id]) ? $donations[$donation_id] : $donations[1];
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="edit-donation-container">
        <div class="donation-form-card">
            <div class="form-header">
                <h2>Edit Donation</h2>
                <p>Update donation information below</p>
            </div>

            <form >
                <!-- Serial Number (Not Editable) -->
                <div class="form-group">
                    <label class="form-label">Serial Number</label>
                    <div class="serial-display">#<?php echo $donation['serial']; ?></div>
                    <input type="hidden" name="serial" value="<?php echo $donation['serial']; ?>">
                    <input type="hidden" name="donation_id" value="<?php echo $donation_id; ?>">
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label class="form-label">
                        Donation Category <span class="required">*</span>
                    </label>
                    <select class="form-select" name="category" required>
                        <option value="">Select Category</option>
                        <option value="education" <?php echo $donation['category'] == 'education' ? 'selected' : ''; ?>>Education</option>
                        <option value="health" <?php echo $donation['category'] == 'health' ? 'selected' : ''; ?>>Health</option>
                        <option value="emergency" <?php echo $donation['category'] == 'emergency' ? 'selected' : ''; ?>>Emergency Relief</option>
                        <option value="food" <?php echo $donation['category'] == 'food' ? 'selected' : ''; ?>>Food Distribution</option>
                        <option value="general" <?php echo $donation['category'] == 'general' ? 'selected' : ''; ?>>General</option>
                    </select>
                </div>

                <!-- Donor Name -->
                <div class="form-group">
                    <label class="form-label">
                        Donor Name <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" name="donor_name" value="<?php echo $donation['name']; ?>" placeholder="Enter donor name" required>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label class="form-label">
                        Phone Number <span class="required">*</span>
                    </label>
                    <input type="tel" class="form-control" name="phone" value="<?php echo $donation['phone']; ?>" placeholder="+880 1XXX-XXXXXX" required>
                </div>

                <!-- Donation Amount -->
                <div class="form-group">
                    <label class="form-label">
                        Donation Amount <span class="required">*</span>
                    </label>
                    <input type="number" class="form-control" name="amount" value="<?php echo $donation['amount']; ?>" placeholder="Enter amount in BDT" min="1" required>
                </div>

                <!-- Transaction ID -->
                <div class="form-group">
                    <label class="form-label">
                        Transaction ID <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" name="transaction_id" value="<?php echo $donation['transaction_id']; ?>" placeholder="Enter transaction ID" required>
                </div>

                <!-- Save Button -->
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                </button>

                <!-- Cancel Button -->
                <button type="button" class="btn-cancel" onclick="window.location.href='donation-list.php'">
                    <i class="fa-solid fa-xmark me-2"></i>Cancel
                </button>
            </form>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->



<?php require './components/footer.php'; ?>