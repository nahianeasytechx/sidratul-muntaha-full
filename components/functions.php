<?php

require_once "../admin-panel/database/dbConnection.php";


function authenticateUser($username, $password)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    $stmt = $conn->prepare("SELECT id, username, password_hash, created_at 
                           FROM users 
                           WHERE username = ?");

    if (!$stmt) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'System error.'
        ];
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {
            $stmt->close();
            $conn->close();

            unset($user['password_hash']);

            return [
                'success' => true,
                'message' => 'Login successful',
                'user' => $user
            ];
        }
    }

    $stmt->close();
    $conn->close();

    return [
        'success' => false,
        'message' => 'Invalid username or password'
    ];
}

/**
 * Register a new user
 */
function registerUser($username, $password)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Validate inputs
    if (empty($username) || empty($password)) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'All fields are required'
        ];
    }

    if (strlen($password) < 6) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Password must be at least 6 characters long'
        ];
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'Username already exists'
        ];
    }
    $stmt->close();

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return [
            'success' => true,
            'message' => 'User registered successfully'
        ];
    } else {
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'Registration failed.'
        ];
    }
}

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Logout user
 */
function logoutUser()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

/**
 * Get current logged-in user data
 */
function getCurrentUser()
{
    if (!isLoggedIn()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username']
    ];
}

/**
 * Protect page - redirect to login if not authenticated
 */
function protectPage()
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Change user password
 */
function changePassword($user_id, $old_password, $new_password)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error'
        ];
    }

    // Verify old password
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'User not found'
        ];
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($old_password, $user['password_hash'])) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Current password is incorrect'
        ];
    }

    if (strlen($new_password) < 6) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'New password must be at least 6 characters long'
        ];
    }

    // Update password
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
    $stmt->bind_param("si", $new_hash, $user_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return [
            'success' => true,
            'message' => 'Password changed successfully'
        ];
    }

    $stmt->close();
    $conn->close();
    return [
        'success' => false,
        'message' => 'Password change failed'
    ];
}



function createNotice($data)
{
    $conn = getDatabaseConnection();

    // Escape data
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $publish_date = mysqli_real_escape_string($conn, $data['publish_date']);
    $duration = intval($data['duration']);
    $type = mysqli_real_escape_string($conn, $data['type']);
    $age_limit = !empty($data['age_limit']) ? intval($data['age_limit']) : 'NULL';
    $category = mysqli_real_escape_string($conn, $data['category']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    // Build query
    $sql = "INSERT INTO notices (title, description, publish_date, duration, type, age_limit, category, status) 
            VALUES ('$title', '$description', '$publish_date', $duration, '$type', $age_limit, '$category', '$status')";

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        mysqli_close($conn);
        return ['success' => true, 'message' => 'Notice created successfully', 'id' => $id];
        
    } else {
        $error = mysqli_error($conn);
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Failed to create notice: ' . $error];
    }
}

/**
 * Get all notices
 */
function getAllNotices()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM notices ORDER BY publish_date DESC";
    $result = mysqli_query($conn, $sql);

    $notices = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notices[] = $row;
        }
    }

    mysqli_close($conn);
    return $notices;
}

/**
 * Get a single notice by ID
 */
function getNoticeById($id)
{
    $conn = getDatabaseConnection();
    $id = intval($id);

    $sql = "SELECT * FROM notices WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    $notice = null;
    if ($result && mysqli_num_rows($result) > 0) {
        $notice = mysqli_fetch_assoc($result);
    }

    mysqli_close($conn);
    return $notice;
}

/**
 * Update a notice
 */
/**
 * Update a notice
 */
// functions.php
   
function updateNotice(int $id, array $data): array
{
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'DB connection failed'];

    $sql = "UPDATE notices SET
                title = ?,
                description = ?,
                publish_date = ?,
                duration = ?,
                type = ?,
                category = ?,
                status = ?,
                age_limit = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ['success' => false, 'message' => $conn->error];
    }

    // Normalize age_limit
    $age_limit = ($data['age_limit'] === '' || $data['age_limit'] === null)
        ? null
        : (int)$data['age_limit'];

    $stmt->bind_param(
        "sssisssii",
        $data['title'],
        $data['description'],
        $data['publish_date'],
        $data['duration'],
        $data['type'],
        $data['category'],
        $data['status'],
        $age_limit,
        $id
    );

    if (!$stmt->execute()) {
        return ['success' => false, 'message' => $stmt->error];
    }

    $stmt->close();
    return ['success' => true, 'message' => 'Notice updated successfully'];
}



/**
 * Delete a notice
 */
function deleteNotice($id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM notices WHERE id = ?");

    if (!$stmt) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Failed to prepare delete statement.'
        ];
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        $conn->close();

        if ($affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Notice deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Notice not found or already deleted'
            ];
        }
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'Failed to delete notice: ' . $error
        ];
    }
}

/**
 * Get notice count by status
 */
function getNoticeCount($status = null)
{
    $conn = getDatabaseConnection();

    if ($status) {
        $status = mysqli_real_escape_string($conn, $status);
        $sql = "SELECT COUNT(*) as count FROM notices WHERE status = '$status'";
    } else {
        $sql = "SELECT COUNT(*) as count FROM notices";
    }

    $result = mysqli_query($conn, $sql);
    $count = 0;

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    }

    mysqli_close($conn);
    return $count;
}
