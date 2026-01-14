<?php
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Settings'; 
require './components/header.php';

// Protect page - check admin or user login
if (!isset($_SESSION['user_id'])) {
  echo"<script>window.location.href='login.php'</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle profile update
$success_msg = '';
$error_msg = '';
if (isset($_POST['update_profile'])) {
    $result = updateUserProfile($user_id, $_POST, $_FILES);
    if ($result['success']) {
        $_SESSION['success_msg'] = $result['message'];
        echo "<script>
        window.location.href = 'settings.php';
    </script>";
        exit;
    } else {
        $error_msg = $result['message'];
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($new !== $confirm) {
        $error_msg = 'New password and confirm password do not match';
    } else {
        $result = changePassword($user_id, $current, $new);
        if ($result['success']) {
            $_SESSION['success_msg'] = $result['message'];
               echo "<script>
        window.location.href = 'settings.php';
    </script>";
            exit;
        } else {
            $error_msg = $result['message'];
        }
    }
}

// Handle profile image deletion
if (isset($_POST['delete_image'])) {
    $result = deleteProfileImage($user_id);
    if ($result['success']) {
        $_SESSION['success_msg'] = $result['message'];
     echo"<script>window.location.href='settings.php'</script>";
        exit;
    } else {
        $error_msg = $result['message'];
    }
}

// Get success message from session
if (isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
}

// Get current user settings
$settings = getUserSettings($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Page Title Section - Match Zakat List */
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
            background:linear-gradient(135deg, #10b981, #059669);
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

        .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-item a:hover {
            color: #8b5cf6;
        }

        .breadcrumb-item.active {
            color: #1e293b;
            font-weight: 500;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: #94a3b8;
            padding: 0 8px;
        }

        /* Messages - Match Zakat List */
        .message {
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        }

        .message span {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message-close {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 4px 8px;
            font-size: 16px;
            opacity: 0.7;
            transition: opacity 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            flex-shrink: 0;
        }

        .message-close:hover {
            opacity: 1;
            transform: none;
            box-shadow: none;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .success::before {
            content: '✓';
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .error::before {
            content: '✕';
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        /* Card Styling - Match Zakat List */
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            padding: 20px 28px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            color: #fff;
            gap: 12px;
        }

        .card-header i {
            font-size: 20px;
            color: linear-gradient(135deg, #10b981, #059669);
        }

        .card-header h2 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .card-body {
            padding: 28px;
        }

        /* Info Box - Match Zakat List */
        .info-box {
            background: #dbeafe;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-box::before {
            content: 'ℹ';
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            flex-shrink: 0;
            font-size: 14px;
        }

        .warning-box {
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .warning-box::before {
            content: '⚠';
            display: inline-block;
            width: 20px;
            height: 20px;
            background: #f59e0b;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            flex-shrink: 0;
            font-size: 14px;
        }

        /* Profile Image Section */
        .profile-image-wrapper {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        img.profile {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f0f0f0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        img.profile:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
        }

        .profile-placeholder {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 48px;
            transition: all 0.3s ease;
        }

        .profile-placeholder:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        }

        .profile-change-link {
            color: #8b5cf6;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            margin-top: 8px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .profile-change-link:hover {
            color: #7c3aed;
            text-decoration: underline;
        }

        /* Form Styling - Match Zakat List */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            font-size: 16px;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #1e293b;
            font-family: inherit;
        }

        input[type="text"].with-icon,
        input[type="password"].with-icon {
            padding-left: 42px;
        }

        textarea.with-icon {
            padding-left: 42px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }

        input[type="text"]:disabled {
            background: #f8fafc;
            color: #94a3b8;
            cursor: not-allowed;
        }

        input[type="file"] {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 13px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-note {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
            font-style: italic;
        }

        /* Buttons - Match Zakat List */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
        }

        button {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button.btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        button.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4);
        }

        button.btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        button.btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        button.btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 8px 16px;
            font-size: 12px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        button.btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        /* Info Items - Match Zakat List */
        .info-item {
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-item-value {
            font-size: 15px;
            color: #1e293b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Password Match Error */
        .passwords-match {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .passwords-match::before {
            content: '⚠';
        }

        /* Responsive */
        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-title-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title-section h1 {
                font-size: 22px;
            }

            .card-body {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .page-title-section .icon-box {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            img.profile,
            .profile-placeholder {
                width: 100px;
                height: 100px;
            }

            .profile-placeholder {
                font-size: 40px;
            }
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <!-- Page Title -->
        <div class="page-title-section">
            <div class="page-title-content">
                <div class="icon-box">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div>
                    <h1>Account Settings</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?php if ($success_msg): ?>
            <div class="message success">
                <span><?= htmlspecialchars($success_msg) ?></span>
                <button type="button" class="message-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($error_msg): ?>
            <div class="message error">
                <span><?= htmlspecialchars($error_msg) ?></span>
                <button type="button" class="message-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <div class="content-grid">
            <!-- Left Column -->
            <div>
                <!-- Profile Information -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-user-circle"></i>
                        <h2>Profile & Credentials Information</h2>
                    </div>
                    <div class="card-body">
                        <!-- <div class="profile-image-wrapper">
                            <?php if (!empty($settings['profile_image']) && file_exists($settings['profile_image'])): ?>
                                <img src="<?= $settings['profile_image'] ?>" class="profile" alt="Profile">
                                <form method="post" style="display: inline;">
                                    <button type="submit" name="delete_image" class="btn-danger">
                                        <i class="fa-solid fa-trash"></i> Remove
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="profile-placeholder">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <br>
                            <a href="#" class="profile-change-link" onclick="document.getElementById('profile_image').click(); return false;">
                                <i class="fa-solid fa-camera"></i> Click the current icon to change Profile Image
                            </a>
                        </div> -->

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Username <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-user"></i>
                                    <input type="text" name="full_name" class="with-icon" value="<?= htmlspecialchars($settings['full_name'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email Address <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-envelope"></i>
                                    <input type="text" name="email" class="with-icon" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-phone"></i>
                                    <input type="text" name="phone" class="with-icon" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" placeholder="+880 123-456-7890">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-map-marker-alt"></i>
                                    <textarea name="address" class="with-icon" placeholder="Enter your full address"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;">

                            <div class="button-group">
                                <button type="submit" name="update_profile" class="btn-primary">
                                    <i class="fa-solid fa-save"></i> Save Changes
                                </button>
                                <button type="button" class="btn-secondary" onclick="window.location.reload();">
                                    <i class="fa-solid fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

            <!-- Right Column -->
            <div>
                <!-- <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-info-circle"></i>
                        <h2>Account Information</h2>
                    </div>
                    <div class="card-body ">
                        <div class="info-item d-none">
                            <div class="info-item-label">Account Status</div>
                            <div class="info-item-value">
                                <span class="badge active">Active</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item-label">Member Since</div>
                            <div class="info-item-value">
                                <i class="fa-solid fa-calendar"></i> <?= htmlspecialchars($settings['created_at'] ?? 'June 12, 2023') ?>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item-label">Role</div>
                            <div class="info-item-value">
                                <i class="fa-solid fa-user-shield"></i> <?= htmlspecialchars($settings['role'] ?? 'Administrator') ?>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="card" style="margin-top: 24px;">
                    <div class="card-header">
                        <i class="fa-solid fa-shield-halved"></i>
                        <h2>Security Tip</h2>
                    </div>
                    <div class="card-body">
                        <div class="warning-box">
                            Never share your password with anyone. Change your password regularly for better security.
                        </div>
                    </div>
                </div> -->
           
                           <!-- Change Password -->
                <div class="card" style="margin-top: 24px;">
                    <div class="card-header">
                        <i class="fa-solid fa-lock"></i>
                        <h2>Change Password</h2>
                    </div>
                    <div class="card-body">
                        <div class="info-box">
                            <div>
                                <strong>Password Requirements:</strong> Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character.
                            </div>
                        </div>

                        <form method="post">
                            <div class="form-group">
                                <label>Current Password <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-lock"></i>
                                    <input type="password" name="current_password" class="with-icon" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>New Password <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-key"></i>
                                    <input type="password" name="new_password" class="with-icon" required>
                                </div>
                                <div class="form-note">Password strength: N/A</div>
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="input-icon fa-solid fa-check-circle"></i>
                                    <input type="password" name="confirm_password" class="with-icon" required>
                                </div>
                            </div>

                            <div class="passwords-match" id="password-match-error" style="display: none;">
                                Passwords do not match
                            </div>

                            <div class="button-group">
                                <button type="submit" name="change_password" class="btn-primary">
                                    <i class="fa-solid fa-key"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password match validation
        document.addEventListener('DOMContentLoaded', function() {
            const newPass = document.querySelector('input[name="new_password"]');
            const confirmPass = document.querySelector('input[name="confirm_password"]');
            const errorMsg = document.getElementById('password-match-error');

            if (confirmPass) {
                confirmPass.addEventListener('input', function() {
                    if (newPass.value !== confirmPass.value && confirmPass.value.length > 0) {
                        errorMsg.style.display = 'block';
                    } else {
                        errorMsg.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>

</html>