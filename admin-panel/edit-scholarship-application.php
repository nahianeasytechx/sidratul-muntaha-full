<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Scholarship Application';
require './components/header.php';


// Get application ID from URL
$application_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch application from database
$application = getScholarshipApplicationById($application_id);

// If application not found, redirect
if (!$application) {
    $_SESSION['error_message'] = 'Application not found.';
    echo"<script>scholarship-application-list.php</script> ";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = updateScholarshipApplication($application_id, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    echo"<script>scholarship-application-list.php</script> ";
        exit;
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
}

// Display messages if any
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<style>
    /* Page Header - Updated to match notices styling */
    .page-title-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-title-section .icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
    }

    .page-title-section h1 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .page-title-section .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 8px 0 0 0;
        font-size: 14px;
    }

    .btn-back {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(100, 116, 139, 0.4);
        color: white;
    }

    /* Form Card Styling */
    .form-card {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .form-card-header i {
        font-size: 20px;
        color: #10b981;
    }

    .form-card-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Section Styling */
    .form-section {
        margin-bottom: 32px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-header i {
        font-size: 18px;
        color: #10b981;
    }

    .section-header h6 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    /* Button Styling */
    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        color: white;
    }

    .btn-reset {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* Form Validation */
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    }

    .is-valid {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 13px;
        margin-top: 4px;
        display: none;
    }

    .is-invalid + .invalid-feedback {
        display: block;
    }

    /* Alert Styling */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        border: none;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .form-card {
            padding: 20px;
        }

        .btn-save, .btn-cancel, .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .d-flex.gap-3 {
            flex-direction: column;
            gap: 12px !important;
        }
    }

    @media (max-width: 576px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .form-control, .form-select {
            padding: 12px 14px;
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

    .form-card {
        animation: fadeIn 0.5s ease;
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="col-lg-10 col-xl-9 mx-auto">
    <div class="scholarship-application">

        <!-- Page Title -->
        <div class="page-title-section">
            <div class="page-title-content">
                <div class="icon-box">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h1>Edit Scholarship Application</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="scholarship-application-list.php">Applications</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn-back" href="scholarship-application-list.php">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>

        <!-- Edit Form -->
        <div class="form-card">
            <div class="form-card-header">
                <i class="fa-solid fa-pen-to-square"></i>
                <h5>Edit Application Details - ID: <?= $application['id'] ?></h5>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form id="editApplicationForm" method="POST" action="">
                <input type="hidden" name="application_id" value="<?= $application['id'] ?>">

                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fa-solid fa-user"></i>
                        <h6>Personal Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($application['name']) ?>" required>
                            <div class="invalid-feedback">Please enter the full name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($application['email']) ?>" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($application['phone']) ?>" required>
                            <div class="invalid-feedback">Please enter a valid phone number.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="youraddress" name="youraddress" value="<?= htmlspecialchars($application['address']) ?>" required>
                            <div class="invalid-feedback">Please enter the address.</div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <h6>Academic Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="instituename" name="instituename" value="<?= htmlspecialchars($application['institute_name']) ?>" required>
                            <div class="invalid-feedback">Please enter institution name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Institution Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="institution_type" name="institution_type" required>
                                <option value="">Select Type</option>
                                <option value="hifz" <?= $application['institution_type'] === 'hifz' ? 'selected' : '' ?>>Hifz</option>
                                <option value="program" <?= $application['institution_type'] === 'program' ? 'selected' : '' ?>>Program</option>
                                <option value="school" <?= $application['institution_type'] === 'school' ? 'selected' : '' ?>>School</option>
                                <option value="college" <?= $application['institution_type'] === 'college' ? 'selected' : '' ?>>College</option>
                                <option value="university" <?= $application['institution_type'] === 'university' ? 'selected' : '' ?>>University</option>
                                <option value="madrasha-program" <?= $application['institution_type'] === 'madrasha-program' ? 'selected' : '' ?>>Madrasha</option>
                            </select>
                            <div class="invalid-feedback">Please select institution type.</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-3 justify-content-end mt-4 pt-4 border-top">
                    <a href="scholarship-application-list.php" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                    <button type="reset" class="btn-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Application Info Card -->
        <div class="form-card">
            <div class="form-card-header">
                <i class="fa-solid fa-info-circle"></i>
                <h5>Application Information</h5>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Application ID:</strong> #<?= $application['id'] ?></p>
                    <p><strong>Submitted Date:</strong> <?= date('F d, Y', strtotime($application['created_at'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Last Modified:</strong> <?= date('F d, Y g:i A', strtotime($application['created_at'])) ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-warning">Pending Review</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
// Form validation and submission
document.getElementById('editApplicationForm').addEventListener('submit', function(e) {
    // Validate all required fields
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return;
    }
    
    // Show confirmation dialog
    if (!confirm('Are you sure you want to save these changes?')) {
        e.preventDefault();
        return;
    }
});

// Reset form confirmation
document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
    if (!confirm('Are you sure you want to reset all changes?')) {
        e.preventDefault();
    } else {
        // Clear validation classes on reset
        const fields = document.querySelectorAll('.form-control, .form-select');
        fields.forEach(field => {
            field.classList.remove('is-invalid', 'is-valid');
        });
    }
});

// Real-time validation feedback
const requiredFields = document.querySelectorAll('[required]');
requiredFields.forEach(field => {
    field.addEventListener('blur', function() {
        if (this.value.trim() === '') {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
});
</script>

<?php require './components/footer.php'; ?>