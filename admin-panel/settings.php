<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Settings';

// Mock current user data - Replace with actual session data
$current_user = [
    'name' => 'Admin User',
    'email' => 'admin@socialorg.com',
    'phone' => '+880 1234-567890',
    'profile_photo' => '../images/sidratulnewLogo1 (1).jpeg',
    'joined_date' => 'Jan 15, 2024'
];
?>
<?php require './components/header.php'; ?>

<style>
    /* Page Header - Updated to match notices styling */
    .page-title-section {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title-section .icon-box {
        width: 60px;
        height: 60px;
           background: linear-gradient(135deg, #10b981, #059669);
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
        border: none;
    }

    /* Settings Cards */
    .settings-card {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        font-size: 20px;
       color: linear-gradient(135deg, #10b981, #059669);
    }

    .section-title h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Profile Photo Section */
    .profile-photo-section {
        text-align: center;
        margin-bottom: 32px;
        padding: 24px;
        background: #f8fafc;
        border-radius: 16px;
        border: 2px dashed #e2e8f0;
    }

    .profile-photo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 12px;
    }

    .profile-photo {
        width: 220px;
        height: 220px;
        border-radius: 10%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .photo-upload-btn {
        position: absolute;
        bottom: 8px;
        right: 0px;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        border: 2px solid #fff;
    }

    .photo-upload-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.4);
    }

    .photo-input {
        display: none;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .input-group {
        position: relative;
    }

    .input-group-text {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-right: none;
        color: #64748b;
        font-size: 14px;
        padding: 14px 16px;
    }

    .form-control {
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }

    .input-group .input-group-text + .form-control {
        border-left: 2px solid #e2e8f0;
        border-radius: 12px;
    }

    /* Password Toggle */
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        background: #f1f5f9;
    color: linear-gradient(135deg, #10b981, #059669);
    }

    /* Password Strength */
    .password-strength {
        margin-top: 8px;
    }

    .password-strength-bar {
        height: 6px;
    background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .password-strength-bar::before {
        content: '';
        display: block;
        height: 100%;
        width: 0%;
        background: #ef4444;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .password-strength-bar.weak::before { width: 25%; background: #ef4444; }
    .password-strength-bar.fair::before { width: 50%; background: #f59e0b; }
    .password-strength-bar.good::before { width: 75%; background: #10b981; }
    .password-strength-bar.strong::before { width: 100%; background: #059669; }

    /* Button Styling */
    .btn-save {
          background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
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
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        color: white;
    }

    /* Alert Styling */
    .alert-modern {
        border-radius: 16px;
        border: none;
        padding: 20px 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .alert-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    /* Account Info Badges */
    .info-badge {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        color: #475569;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-modern {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .settings-card {
            padding: 20px;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
        }

        .btn-save, .btn-cancel {
            width: 100%;
            justify-content: center;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            gap: 12px !important;
        }
    }

    @media (max-width: 576px) {
                .btn-save, .btn-cancel {
            width:50%;
            justify-content: center;
            font-size: 12px;
        }
        .section-title {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .profile-photo-section {
            padding: 20px;
        }

        .input-group-text {
            padding: 12px 14px;
        }

        .form-control {
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

    .settings-card {
        animation: fadeIn 0.5s ease;
    }
    @media(max-width:350px){
            .btn-save {
        border-radius: 12px;
        padding: 12px 24px;
        font-size: large;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

}
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
<div class="row ">
    <div class="col-lg-10 mx-auto">
            <div class="settings">
        <!-- Page Title -->
        <div class="page-title-section">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div>
                    <h1>Account Settings</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Information -->
            <div class="col-md-8">
                <div class="settings-card">
                    <div class="section-title">
                        <i class="fa-solid fa-user-circle"></i>
                        <h3>Profile Information</h3>
                    </div>

                    <!-- Profile Photo -->
                    <div class="profile-photo-section">
                        <div class="profile-photo-container">
                            <img src="<?php echo $current_user['profile_photo']; ?>" alt="Profile Photo" class="profile-photo" id="profilePhotoPreview">
                            <label for="profilePhotoInput" class="photo-upload-btn">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" id="profilePhotoInput" class="photo-input" accept="image/*">
                        </div>
                        <p class="text-muted small">Click the camera icon to change <strong>Profile Photo</strong></p>
                    </div>

                    <form id="profileForm" method="POST" enctype="multipart/form-data">
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="fullName" class="form-label">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="fullName" 
                                    name="full_name" 
                                    value="<?php echo $current_user['name']; ?>"
                                    required
                                    placeholder="Enter your full name"
                                >
                            </div>
                        </div>

                        <!-- Email (Read-only) -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                Email Address
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    value="<?php echo $current_user['email']; ?>"
                                    readonly
                                >
                            </div>
                            <small class="text-muted mt-2 d-block">Email cannot be changed. Contact system administrator if needed.</small>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label for="phone" class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    id="phone" 
                                    name="phone" 
                                    value="<?php echo $current_user['phone']; ?>"
                                    required
                                    placeholder="+880 1234-567890"
                                >
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn-save" name="update_profile">
                                <i class="fa-solid fa-floppy-disk"></i>Save Changes
                            </button>
                            <button type="button" class="btn-cancel" onclick="resetForm()">
                                <i class="fa-solid fa-xmark"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="settings-card">
                    <div class="section-title">
                        <i class="fa-solid fa-lock"></i>
                        <h3>Change Password</h3>
                    </div>

                    <div class="alert-modern alert-info mb-4">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        <strong>Password Requirements:</strong> Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character.
                    </div>

                    <form id="passwordForm" method="POST">
                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="currentPassword" class="form-label">
                                Current Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group position-relative">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="currentPassword" 
                                    name="current_password" 
                                    required
                                    placeholder="Enter current password"
                                >
                                <span class="password-toggle" onclick="togglePassword('currentPassword')">
                                    <i class="fa-solid fa-eye" id="currentPasswordIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="newPassword" class="form-label">
                                New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group position-relative">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="newPassword" 
                                    name="new_password" 
                                    required
                                    minlength="8"
                                    placeholder="Enter new password"
                                    oninput="checkPasswordStrength(this.value)"
                                >
                                <span class="password-toggle" onclick="togglePassword('newPassword')">
                                    <i class="fa-solid fa-eye" id="newPasswordIcon"></i>
                                </span>
                            </div>
                            <div class="password-strength mt-3">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted mt-2 d-block" id="strengthText">Password strength: None</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label">
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group position-relative">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="confirmPassword" 
                                    name="confirm_password" 
                                    required
                                    placeholder="Confirm new password"
                                    oninput="checkPasswordMatch()"
                                >
                                <span class="password-toggle" onclick="togglePassword('confirmPassword')">
                                    <i class="fa-solid fa-eye" id="confirmPasswordIcon"></i>
                                </span>
                            </div>
                            <small class="text-danger mt-2 d-block" id="passwordMatch" style="display: none;">
                                <i class="fa-solid fa-circle-exclamation me-1"></i>Passwords do not match
                            </small>
                        </div>

                        <button type="submit" class="btn-save" name="change_password">
                            <i class="fa-solid fa-shield-halved"></i>Change Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Info Sidebar -->
            <div class="col-md-4">
                <div class="settings-card">
                    <div class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        <h3>Account Information</h3>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Account Status</label>
                        <div>
                            <span class="badge-modern badge-success">Active</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Member Since</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-calendar-days"></i>
                            <?php echo $current_user['joined_date']; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Last Login</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-clock"></i>
                            Today at 10:30 AM
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-user-shield"></i>
                            Administrator
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="alert-modern alert-warning">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <strong>Security Tip:</strong> Never share your password with anyone. Enable two-factor authentication for better security.
                    </div>
                </div>
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
// Password toggle functionality
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + 'Icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    let strength = 0;
    let text = '';
    
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 15;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 10;
    
    strengthBar.className = 'password-strength-bar';
    
    if (strength < 50) {
        strengthBar.classList.add('weak');
        text = 'Weak';
    } else if (strength < 75) {
        strengthBar.classList.add('fair');
        text = 'Fair';
    } else if (strength < 90) {
        strengthBar.classList.add('good');
        text = 'Good';
    } else {
        strengthBar.classList.add('strong');
        text = 'Strong';
    }
    
    strengthText.textContent = `Password strength: ${text}`;
}

// Password match checker
function checkPasswordMatch() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const matchText = document.getElementById('passwordMatch');
    
    if (confirmPassword && newPassword !== confirmPassword) {
        matchText.style.display = 'block';
    } else {
        matchText.style.display = 'none';
    }
}

// Profile photo preview
document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePhotoPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Form reset
function resetForm() {
    document.getElementById('profileForm').reset();
    document.getElementById('passwordForm').reset();
    document.getElementById('strengthBar').className = 'password-strength-bar';
    document.getElementById('strengthText').textContent = 'Password strength: None';
    document.getElementById('passwordMatch').style.display = 'none';
}

// Form submission handlers
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your profile update logic here
    alert('Profile updated successfully!');
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (newPassword !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }
    
    // Add your password change logic here
    alert('Password changed successfully!');
    this.reset();
    resetForm();
});
</script>

<?php require './components/footer.php'; ?>