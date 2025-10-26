<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Settings';

// Mock current user data - Replace with actual session data
$current_user = [
    'name' => 'Admin User',
    'email' => 'admin@socialorg.com',
    'phone' => '+880 1234-567890',
    'profile_photo' => '../img/default-avatar.png',
    'joined_date' => 'Jan 15, 2024'
];
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="settings">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div>
                    <h1>Account Settings</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
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
                        Profile Information
                    </div>

                    <!-- Profile Photo -->
                    <div class="profile-photo-section">
                        <div class="profile-photo-container">
                            <img src="<?php echo $current_user['profile_photo']; ?>" alt="" class="profile-photo" id="profilePhotoPreview">
                            <label for="profilePhotoInput" class="photo-upload-btn">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" id="profilePhotoInput" class="photo-input" accept="image/*">
                        </div>
                        <p class="text-muted small">Click the camera icon to change <strong>website Logo</strong></p>
                    </div>

                    <form id="profileForm" method="POST" enctype="multipart/form-data">
                        <!-- Full Name -->
                        <div class="mb-3">
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
                                >
                            </div>
                        </div>

                        <!-- Email (Read-only) -->
                        <div class="mb-3">
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
                            <small class="text-muted">Email cannot be changed. Contact system administrator if needed.</small>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
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

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-save" name="update_profile">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                            </button>
                            <button type="button" class="btn btn-cancel" onclick="resetForm()">
                                <i class="fa-solid fa-xmark me-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="settings-card">
                    <div class="section-title">
                        <i class="fa-solid fa-lock"></i>
                        Change Password
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        <strong>Password Requirements:</strong> Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character.
                    </div>

                    <form id="passwordForm" method="POST">
                        <!-- Current Password -->
                        <div class="mb-3">
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
                                >
                                <span class="password-toggle" onclick="togglePassword('currentPassword')">
                                    <i class="fa-solid fa-eye" id="currentPasswordIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
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
                                >
                                <span class="password-toggle" onclick="togglePassword('newPassword')">
                                    <i class="fa-solid fa-eye" id="newPasswordIcon"></i>
                                </span>
                            </div>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted" id="strengthText">Password strength: None</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
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
                                >
                                <span class="password-toggle" onclick="togglePassword('confirmPassword')">
                                    <i class="fa-solid fa-eye" id="confirmPasswordIcon"></i>
                                </span>
                            </div>
                            <small class="text-danger" id="passwordMatch" style="display: none;">Passwords do not match</small>
                        </div>

                        <button type="submit" class="btn btn-save" name="change_password">
                            <i class="fa-solid fa-shield-halved me-2"></i>Change Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Info Sidebar -->
            <div class="col-md-4">
                <div class="settings-card">
                    <div class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        Account Information
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Status</label>
                        <div>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Member Since</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-calendar-days me-2"></i>
                            <?php echo $current_user['joined_date']; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Login</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-clock me-2"></i>
                            Today at 10:30 AM
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <div class="info-badge">
                            <i class="fa-solid fa-user-shield me-2"></i>
                            Administrator
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <strong>Security Tip:</strong> Never share your password with anyone. Enable two-factor authentication for better security.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->



<?php require './components/footer.php'; ?>