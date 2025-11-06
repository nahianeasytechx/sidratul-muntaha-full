<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Scholarship Application';
require './components/header.php';

// Get application ID from URL
$application_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ✅ Sample application data (replace with DB query later)
$application = [
    "id" => $application_id,
    "name" => "Md. Rahim Uddin",
    "phone" => "+880 1712-345678",
    "email" => "rahim.uddin@email.com",
    "address" => "Mirpur, Dhaka",
    "institution" => "Dhaka College",
    "type" => "college",
    "status" => "pending",
    "applied_date" => "2024-10-15",
    "father_name" => "Md. Karim Uddin",
    "mother_name" => "Amena Begum",
    "date_of_birth" => "2005-03-15",
    "gender" => "male",
    "class_year" => "HSC 1st Year",
    "gpa" => "5.00",
    "family_income" => "15000",
    "notes" => "Excellent student with financial need. Active in extracurricular activities."
];

// If application not found, redirect
if (!$application) {
    header("Location: scholarship-application-list.php");
    exit;
}
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

    /* History Card */
    .history-card {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .history-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .history-card-header i {
        font-size: 20px;
        color: #64748b;
    }

    .history-card-header h6 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Timeline Styling */
    .timeline {
        position: relative;
        padding-left: 20px;
    }

    .timeline-item {
        padding: 16px 0 16px 20px;
        border-left: 2px solid #e2e8f0;
        position: relative;
        margin-bottom: 8px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -7px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #8b5cf6;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #8b5cf6;
    }

    .timeline-item:last-child::before {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }

    /* Badge Styling */
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .badge-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
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

    /* Responsive */
    @media (max-width: 768px) {
        .page-title-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .form-card, .history-card {
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

    .form-card, .history-card {
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
                <h5>Edit Application Details</h5>
            </div>

            <form id="editApplicationForm" method="POST" action="update-application.php">
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
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($application['phone']) ?>" required>
                            <div class="invalid-feedback">Please enter a valid phone number.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= $application['date_of_birth'] ?>" required>
                            <div class="invalid-feedback">Please select date of birth.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" <?= $application['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $application['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= $application['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <div class="invalid-feedback">Please select gender.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($application['address']) ?>" required>
                            <div class="invalid-feedback">Please enter the address.</div>
                        </div>
                    </div>
                </div>

                <!-- Family Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fa-solid fa-people-roof"></i>
                        <h6>Family Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="father_name" class="form-label">Father's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="father_name" name="father_name" value="<?= htmlspecialchars($application['father_name']) ?>" required>
                            <div class="invalid-feedback">Please enter father's name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?= htmlspecialchars($application['mother_name']) ?>" required>
                            <div class="invalid-feedback">Please enter mother's name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="family_income" class="form-label">Monthly Family Income (৳) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="family_income" name="family_income" value="<?= $application['family_income'] ?>" required>
                            <div class="invalid-feedback">Please enter family income.</div>
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
                            <input type="text" class="form-control" id="institution" name="institution" value="<?= htmlspecialchars($application['institution']) ?>" required>
                            <div class="invalid-feedback">Please enter institution name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Institution Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="hifz" <?= $application['type'] === 'hifz' ? 'selected' : '' ?>>Hifz</option>
                                <option value="program" <?= $application['type'] === 'program' ? 'selected' : '' ?>>Program</option>
                                <option value="school" <?= $application['type'] === 'school' ? 'selected' : '' ?>>School</option>
                                <option value="college" <?= $application['type'] === 'college' ? 'selected' : '' ?>>College</option>
                                <option value="university" <?= $application['type'] === 'university' ? 'selected' : '' ?>>University</option>
                            </select>
                            <div class="invalid-feedback">Please select institution type.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="class_year" class="form-label">Class/Year <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="class_year" name="class_year" value="<?= htmlspecialchars($application['class_year']) ?>" placeholder="e.g., Class 10, HSC 1st Year, 3rd Semester" required>
                            <div class="invalid-feedback">Please enter class/year.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="gpa" class="form-label">Last GPA/Result <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="gpa" name="gpa" value="<?= htmlspecialchars($application['gpa']) ?>" placeholder="e.g., 5.00, 4.50" required>
                            <div class="invalid-feedback">Please enter GPA/result.</div>
                        </div>
                    </div>
                </div>

                <!-- Application Status Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fa-solid fa-clipboard-check"></i>
                        <h6>Application Status</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" <?= $application['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="processed" <?= $application['status'] === 'processed' ? 'selected' : '' ?>>Processed</option>
                                <option value="rejected" <?= $application['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <div class="invalid-feedback">Please select status.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="applied_date" class="form-label">Applied Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="applied_date" name="applied_date" value="<?= $application['applied_date'] ?>" required>
                            <div class="invalid-feedback">Please select applied date.</div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes Section -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fa-solid fa-note-sticky"></i>
                        <h6>Additional Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes/Remarks</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Add any additional notes or remarks about this application..."><?= htmlspecialchars($application['notes']) ?></textarea>
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

        <!-- Application History Card -->
        <div class="history-card">
            <div class="history-card-header">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h6>Application History</h6>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <span class="badge-modern badge-success">Created</span>
                    <span class="ms-2 text-muted">October 15, 2024 at 10:30 AM</span>
                    <p class="mb-0 mt-1 text-muted">Application submitted by applicant</p>
                </div>
                <div class="timeline-item">
                    <span class="badge-modern badge-info">Updated</span>
                    <span class="ms-2 text-muted">October 20, 2024 at 02:15 PM</span>
                    <p class="mb-0 mt-1 text-muted">Status changed to pending review</p>
                </div>
                <div class="timeline-item">
                    <span class="badge-modern badge-warning">Modified</span>
                    <span class="ms-2 text-muted">October 25, 2024 at 09:45 AM</span>
                    <p class="mb-0 mt-1 text-muted">Contact information updated</p>
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
    e.preventDefault();
    
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
        alert('Please fill in all required fields.');
        return;
    }
    
    // Show confirmation dialog
    if (confirm('Are you sure you want to save these changes?')) {
        // Here you would normally submit the form via AJAX or regular form submission
        alert('Application updated successfully!');
        // window.location.href = 'scholarship-application-list.php';
        
        // For now, just show success message
        // In production, uncomment the line below to submit the form
        // this.submit();
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