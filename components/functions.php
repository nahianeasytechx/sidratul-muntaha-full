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



// ============================================
// ACTIVITY MANAGEMENT FUNCTIONS
// ============================================

/**
 * Create a new activity
 */
/**
 * Create a new activity
 */
function createActivity($data)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Validate required fields
    $required_fields = ['title', 'objectives', 'short_description', 'description', 'type', 'status'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => ucfirst($field) . ' is required.'
            ];
        }
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO activities (title, objectives, short_description, description, type, status, image, sections_data) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    // Handle nullable fields
    $image = isset($data['image']) && !empty($data['image']) ? $data['image'] : null;
    $sections_data = isset($data['sections_data']) && !empty($data['sections_data']) ? $data['sections_data'] : null;

    // Bind parameters
    $stmt->bind_param(
        "ssssssss",
        $data['title'],
        $data['objectives'],
        $data['short_description'],
        $data['description'],
        $data['type'],
        $data['status'],
        $image,
        $sections_data
    );

    // Execute the statement
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Activity created successfully',
            'id' => $id
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to create activity: ' . $error
        ];
    }
}

/**
 * Get all activities
 */
function getAllActivities()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM activities ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    $activities = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $activities[] = $row;
        }
    }

    mysqli_close($conn);
    return $activities;
}

/**
 * Get a single activity by ID
 */
function getActivityById($id)
{
    $conn = getDatabaseConnection();
    $id = intval($id);

    $sql = "SELECT * FROM activities WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    $activity = null;
    if ($result && mysqli_num_rows($result) > 0) {
        $activity = mysqli_fetch_assoc($result);
    }

    mysqli_close($conn);
    return $activity;
}

/**
 * Update an activity
 */
function updateActivity(int $id, array $data): array
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection failed'
        ];
    }

    $sql = "UPDATE activities SET
                title = ?,
                objectives = ?,
                short_description = ?,
                description = ?,
                type = ?,
                status = ?,
                image = ?,
                sections_data = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    // Handle nullable fields
    $image = isset($data['image']) && !empty($data['image']) ? $data['image'] : null;
    $sections_data = isset($data['sections_data']) && !empty($data['sections_data']) ? $data['sections_data'] : null;

    $stmt->bind_param(
        "ssssssssi",
        $data['title'],
        $data['objectives'],
        $data['short_description'],
        $data['description'],
        $data['type'],
        $data['status'],
        $image,
        $sections_data,
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Activity updated successfully'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update activity: ' . $error
        ];
    }
}

/**
 * Delete an activity
 */
function deleteActivity($id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Use prepared statement for security
    $stmt = $conn->prepare("DELETE FROM activities WHERE id = ?");

    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare delete statement.'
        ];
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        mysqli_close($conn);

        if ($affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Activity deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Activity not found or already deleted'
            ];
        }
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to delete activity: ' . $error
        ];
    }
}

/**
 * Get activity count by status
 */
function getActivityCount($status = null)
{
    $conn = getDatabaseConnection();

    if ($status) {
        $status = mysqli_real_escape_string($conn, $status);
        $sql = "SELECT COUNT(*) as count FROM activities WHERE status = '$status'";
    } else {
        $sql = "SELECT COUNT(*) as count FROM activities";
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

/**
 * Get activity count by type
 */
function getActivityCountByType($type)
{
    $conn = getDatabaseConnection();
    $type = mysqli_real_escape_string($conn, $type);

    $sql = "SELECT COUNT(*) as count FROM activities WHERE type = '$type'";
    $result = mysqli_query($conn, $sql);
    $count = 0;

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    }

    mysqli_close($conn);
    return $count;
}

// ===========Slider Section========
function createSlider($data, $file)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Validate required fields
    if (empty($data['slider_title']) || empty($data['slider_description'])) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Title and description are required.'
        ];
    }

    // Handle file upload
    if (isset($file['slider_img']) && $file['slider_img']['error'] === 0) {
        $upload_dir = '../uploads/sliders/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // Validate file type
        if (!in_array($file['slider_img']['type'], $allowed_types)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
            ];
        }

        // Validate file size
        if ($file['slider_img']['size'] > $max_size) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'File size too large. Maximum 5MB allowed.'
            ];
        }

        // Generate unique filename
        $file_extension = pathinfo($file['slider_img']['name'], PATHINFO_EXTENSION);
        $new_filename = 'slider_' . time() . '_' . uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        // Move uploaded file
        if (!move_uploaded_file($file['slider_img']['tmp_name'], $upload_path)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Failed to upload image.'
            ];
        }

        $slider_img = $upload_path;
    } else {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Image is required.'
        ];
    }

    // Get the next display order
    $order_result = mysqli_query($conn, "SELECT MAX(display_order) as max_order FROM sliders");
    $order_row = mysqli_fetch_assoc($order_result);
    $next_order = ($order_row['max_order'] ?? 0) + 1;

    // Prepare the SQL statement
    $sql = "INSERT INTO sliders (slider_img, slider_title, slider_description, link_text, link_url, display_order, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    // Handle optional fields
    $link_text = isset($data['link_text']) && !empty($data['link_text']) ? $data['link_text'] : null;
    $link_url = isset($data['link_url']) && !empty($data['link_url']) ? $data['link_url'] : null;
    $status = isset($data['status']) && !empty($data['status']) ? $data['status'] : 'active';

    // Bind parameters
    $stmt->bind_param(
        "sssssis",
        $slider_img,
        $data['slider_title'],
        $data['slider_description'],
        $link_text,
        $link_url,
        $next_order,
        $status
    );

    // Execute the statement
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Slider created successfully',
            'id' => $id
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        
        // Delete uploaded file if database insert fails
        if (file_exists($slider_img)) {
            unlink($slider_img);
        }
        
        return [
            'success' => false,
            'message' => 'Failed to create slider: ' . $error
        ];
    }
}

/**
 * Get all sliders
 */
function getAllSliders()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM sliders ORDER BY display_order ASC, created_at DESC";
    $result = mysqli_query($conn, $sql);

    $sliders = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sliders[] = $row;
        }
    }

    mysqli_close($conn);
    return $sliders;
}

/**
 * Get active sliders only
 */
function getActiveSliders()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM sliders WHERE status = 'active' ORDER BY display_order ASC";
    $result = mysqli_query($conn, $sql);

    $sliders = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sliders[] = $row;
        }
    }

    mysqli_close($conn);
    return $sliders;
}

/**
 * Get a single slider by ID
 */
function getSliderById($id)
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return null;
    }

    $stmt = $conn->prepare("SELECT * FROM sliders WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $slider = null;
    if ($result && $result->num_rows > 0) {
        $slider = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $slider;
}

/**
 * Update a slider
 */
function updateSlider($id, $data, $file = null)
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection failed'
        ];
    }

    // Get existing slider data
    $existing_slider = getSliderById($id);
    
    if (!$existing_slider) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Slider not found'
        ];
    }

    $slider_img = $existing_slider['slider_img'];

    // Handle file upload if new file is provided
    if (isset($file['slider_img']) && $file['slider_img']['error'] === 0) {
        $upload_dir = '../uploads/sliders/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['slider_img']['type'], $allowed_types)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
            ];
        }

        if ($file['slider_img']['size'] > $max_size) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'File size too large. Maximum 5MB allowed.'
            ];
        }

        $file_extension = pathinfo($file['slider_img']['name'], PATHINFO_EXTENSION);
        $new_filename = 'slider_' . time() . '_' . uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['slider_img']['tmp_name'], $upload_path)) {
            // Delete old image
            if (file_exists($existing_slider['slider_img'])) {
                unlink($existing_slider['slider_img']);
            }
            $slider_img = $upload_path;
        } else {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Failed to upload new image.'
            ];
        }
    }

    $sql = "UPDATE sliders SET
                slider_img = ?,
                slider_title = ?,
                slider_description = ?,
                link_text = ?,
                link_url = ?,
                display_order = ?,
                status = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    $link_text = isset($data['link_text']) && !empty($data['link_text']) ? $data['link_text'] : null;
    $link_url = isset($data['link_url']) && !empty($data['link_url']) ? $data['link_url'] : null;
    $display_order = isset($data['display_order']) ? intval($data['display_order']) : $existing_slider['display_order'];
    $status = isset($data['status']) ? $data['status'] : $existing_slider['status'];

    $stmt->bind_param(
        "sssssisi",
        $slider_img,
        $data['slider_title'],
        $data['slider_description'],
        $link_text,
        $link_url,
        $display_order,
        $status,
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Slider updated successfully'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update slider: ' . $error
        ];
    }
}

/**
 * Delete a slider
 */
/**
 * Delete a slider
 */
function deleteSlider($id) {
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Get image path first
    $stmt = $conn->prepare("SELECT slider_img FROM sliders WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement.'
        ];
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $slider = $result->fetch_assoc();
    $stmt->close();

    if (!$slider) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Slider not found'
        ];
    }

    // Delete image file
    if (!empty($slider['slider_img']) && file_exists($slider['slider_img'])) {
        unlink($slider['slider_img']);
    }

    // Delete record
    $stmt = $conn->prepare("DELETE FROM sliders WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare delete statement.'
        ];
    }
    
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        mysqli_close($conn);
        
        if ($affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Slider deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Slider not found or already deleted'
            ];
        }
    }

    $error = $stmt->error;
    $stmt->close();
    mysqli_close($conn);
    
    return [
        'success' => false,
        'message' => 'Database delete failed: ' . $error
    ];
}


/**
 * Get slider count by status
 */
function getSliderCount($status = null)
{
    $conn = getDatabaseConnection();

    if ($status) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM sliders WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();
    } else {
        $sql = "SELECT COUNT(*) as count FROM sliders";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    }

    mysqli_close($conn);
    return $count;
}

/**
 * Update slider order
 */
function updateSliderOrder($id, $new_order)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    $stmt = $conn->prepare("UPDATE sliders SET display_order = ? WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement.'
        ];
    }

    $stmt->bind_param("ii", $new_order, $id);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Slider order updated successfully'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update order: ' . $error
        ];
    }
}

/**
 * Toggle slider status
 */
function toggleSliderStatus($id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    $slider = getSliderById($id);
    
    if (!$slider) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Slider not found'
        ];
    }

    $new_status = ($slider['status'] === 'active') ? 'inactive' : 'active';

    $stmt = $conn->prepare("UPDATE sliders SET status = ? WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement.'
        ];
    }

    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Slider status updated successfully',
            'new_status' => $new_status
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update status: ' . $error
        ];
    }
}

// ============================================
// DONATION CATEGORY MANAGEMENT FUNCTIONS
// ============================================

/**
 * Create a new donation category
 */
function createDonationCategory($data, $file)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Validate required fields
    if (empty($data['title']) || empty($data['description'])) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Title and description are required.'
        ];
    }

    // Handle file upload
    if (isset($file['image']) && $file['image']['error'] === 0) {
        $upload_dir = '../uploads/donation-categories/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // Validate file type
        if (!in_array($file['image']['type'], $allowed_types)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
            ];
        }

        // Validate file size
        if ($file['image']['size'] > $max_size) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'File size too large. Maximum 5MB allowed.'
            ];
        }

        // Generate unique filename
        $file_extension = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'category_' . time() . '_' . uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        // Move uploaded file
        if (!move_uploaded_file($file['image']['tmp_name'], $upload_path)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Failed to upload image.'
            ];
        }

        $image = $upload_path;
    } else {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Image is required.'
        ];
    }

    // Get the next display order
    $order_result = mysqli_query($conn, "SELECT MAX(display_order) as max_order FROM donation_categories");
    $order_row = mysqli_fetch_assoc($order_result);
    $next_order = ($order_row['max_order'] ?? 0) + 1;

    // Prepare the SQL statement
    $sql = "INSERT INTO donation_categories (title, image, description, display_order, status) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    $status = 'active';

    // Bind parameters
    $stmt->bind_param(
        "sssis",
        $data['title'],
        $image,
        $data['description'],
        $next_order,
        $status
    );

    // Execute the statement
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Category added successfully',
            'id' => $id
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        
        // Delete uploaded file if database insert fails
        if (file_exists($image)) {
            unlink($image);
        }
        
        return [
            'success' => false,
            'message' => 'Failed to create category: ' . $error
        ];
    }
}

/**
 * Get all donation categories
 */
function getAllDonationCategories()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM donation_categories ORDER BY display_order ASC, created_at DESC";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }

    mysqli_close($conn);
    return $categories;
}

/**
 * Get active donation categories only
 */
function getActiveDonationCategories()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM donation_categories WHERE status = 'active' ORDER BY display_order ASC";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }

    mysqli_close($conn);
    return $categories;
}

/**
 * Get a single donation category by ID
 */
function getDonationCategoryById($id)
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return null;
    }

    $stmt = $conn->prepare("SELECT * FROM donation_categories WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $category = null;
    if ($result && $result->num_rows > 0) {
        $category = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $category;
}

/**
 * Update a donation category
 */
function updateDonationCategory($id, $data, $file = null)
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection failed'
        ];
    }

    // Get existing category data
    $existing_category = getDonationCategoryById($id);
    
    if (!$existing_category) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Category not found'
        ];
    }

    $image = $existing_category['image'];

    // Handle file upload if new file is provided
    if (isset($file['image']) && $file['image']['error'] === 0) {
        $upload_dir = '../uploads/donation-categories/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['image']['type'], $allowed_types)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
            ];
        }

        if ($file['image']['size'] > $max_size) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'File size too large. Maximum 5MB allowed.'
            ];
        }

        $file_extension = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'category_' . time() . '_' . uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['image']['tmp_name'], $upload_path)) {
            // Delete old image if it's not a placeholder URL
            if (file_exists($existing_category['image']) && strpos($existing_category['image'], 'placeholder') === false) {
                unlink($existing_category['image']);
            }
            $image = $upload_path;
        } else {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Failed to upload new image.'
            ];
        }
    }

    $sql = "UPDATE donation_categories SET
                title = ?,
                image = ?,
                description = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    $stmt->bind_param(
        "sssi",
        $data['title'],
        $image,
        $data['description'],
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Category updated successfully'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update category: ' . $error
        ];
    }
}

/**
 * Delete a donation category
 */
function deleteDonationCategory($id)
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Get image path first
    $stmt = $conn->prepare("SELECT image FROM donation_categories WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement.'
        ];
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    if (!$category) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Category not found'
        ];
    }

    // Delete image file if it's not a placeholder URL
    if (!empty($category['image']) && file_exists($category['image']) && strpos($category['image'], 'placeholder') === false) {
        unlink($category['image']);
    }

    // Delete record
    $stmt = $conn->prepare("DELETE FROM donation_categories WHERE id = ?");
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare delete statement.'
        ];
    }
    
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        mysqli_close($conn);
        
        if ($affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Category deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Category not found or already deleted'
            ];
        }
    }

    $error = $stmt->error;
    $stmt->close();
    mysqli_close($conn);
    
    return [
        'success' => false,
        'message' => 'Database delete failed: ' . $error
    ];
}

/**
 * Get donation category count
 */
function getDonationCategoryCount($status = null)
{
    $conn = getDatabaseConnection();

    if ($status) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM donation_categories WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();
    } else {
        $sql = "SELECT COUNT(*) as count FROM donation_categories";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    }

    mysqli_close($conn);
    return $count;
}

/**
 * Get user settings with user data from users table
 */
function getUserSettings($user_id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return null;
    }

    // JOIN settings with users table to get complete user data
    $stmt = $conn->prepare("
        SELECT 
            s.*, 
            u.username, 
            u.created_at as user_created_at
        FROM settings s
        LEFT JOIN users u ON s.user_id = u.id
        WHERE s.user_id = ?
    ");
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $settings = null;
    if ($result->num_rows > 0) {
        $settings = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $settings;
}

/**
 * Get user data from users table only
 */
function getUserById($user_id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return null;
    }

    $stmt = $conn->prepare("SELECT id, username, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $user;
}

/**
 * Create user settings
 */
function createUserSettings($user_id, $username)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO settings (user_id, full_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $username);
    $success = $stmt->execute();

    $stmt->close();
    mysqli_close($conn);
    return $success;
}

/**
 * Update user profile
 */
function updateUserProfile($user_id, $data, $files = null)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    $full_name = $data['full_name'];
    $phone = $data['phone'];
    $profile_image = null;

    // Handle profile image upload
    if ($files && isset($files['profile_image']) && $files['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = pathinfo($files['profile_image']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, JPEG, PNG, GIF, and WebP are allowed.'
            ];
        }

        // Validate file size (5MB max)
        if ($files['profile_image']['size'] > 5 * 1024 * 1024) {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'File size too large. Maximum 5MB allowed.'
            ];
        }

        // Generate unique filename
        $filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $filename;

        // Delete old profile image if exists
        $old_settings = getUserSettings($user_id);
        if ($old_settings && !empty($old_settings['profile_image']) && file_exists($old_settings['profile_image'])) {
            unlink($old_settings['profile_image']);
        }

        // Upload new image
        if (move_uploaded_file($files['profile_image']['tmp_name'], $upload_path)) {
            $profile_image = $upload_path;
        } else {
            mysqli_close($conn);
            return [
                'success' => false,
                'message' => 'Failed to upload image.'
            ];
        }
    }

    // Update settings
    if ($profile_image) {
        $stmt = $conn->prepare("UPDATE settings SET full_name = ?, phone = ?, profile_image = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $full_name, $phone, $profile_image, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE settings SET full_name = ?, phone = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $full_name, $phone, $user_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Profile updated successfully'
        ];
    }

    $error = $stmt->error;
    $stmt->close();
    mysqli_close($conn);
    return [
        'success' => false,
        'message' => 'Profile update failed: ' . $error
    ];
}

/**
 * Update user password - Updates password in USERS table
 */
/**
 * Update user password - Updates password in USERS table
 */
function updateUserPassword($user_id, $current_password, $new_password)
{
    // Clean inputs
    $current_password = trim($current_password);
    $new_password = trim($new_password);
    
    // Debug logging
    error_log("=== Password Change Debug ===");
    error_log("User ID: $user_id");
    error_log("Current Password (cleaned): '$current_password'");
    error_log("New Password (cleaned): '$new_password'");
    
    $conn = getDatabaseConnection();

    if (!$conn) {
        error_log("Database connection failed");
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Get password hash AND username from USERS table
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        $conn->close();
        return [
            'success' => false,
            'message' => 'System error: Failed to prepare query'
        ];
    }
    
    $stmt->bind_param("i", $user_id);
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'System error: Failed to execute query'
        ];
    }
    
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        error_log("User not found with ID: $user_id");
        $stmt->close();
        $conn->close();
        return [
            'success' => false,
            'message' => 'User not found'
        ];
    }

    $user = $result->fetch_assoc();
    $stmt->close();
    
    error_log("Found user: {$user['username']}");
    error_log("Current hash in DB: " . $user['password_hash']);

    // Verify current password
    error_log("Verifying password: '$current_password' against hash");
    $password_verified = password_verify($current_password, $user['password_hash']);
    error_log("password_verify result: " . ($password_verified ? "TRUE" : "FALSE"));
    
    if (!$password_verified) {
        // Additional check: maybe the hash itself is the password?
        if ($current_password === $user['password_hash']) {
            error_log("Password matches hash directly (hash was stored as plain text?)");
        }
        
        // Try trimming whitespace and newlines
        $clean_current = trim($current_password, " \t\n\r\0\x0B");
        error_log("Trying with trimmed password: '$clean_current'");
        if (password_verify($clean_current, $user['password_hash'])) {
            error_log("password_verify SUCCESS with trimmed password!");
            $password_verified = true;
        }
        
        if (!$password_verified) {
            $conn->close();
            error_log("Password verification FAILED");
            return [
                'success' => false,
                'message' => 'Current password is incorrect'
            ];
        }
    }
    
    error_log("Current password verification SUCCESS");

    // Check if new password is same as old (already verified above)
    if (password_verify($new_password, $user['password_hash'])) {
        $conn->close();
        error_log("New password is the same as current password");
        return [
            'success' => false,
            'message' => 'New password cannot be the same as current password'
        ];
    }

    // Validate new password strength (simplified for now)
    if (strlen($new_password) < 6) {
        $conn->close();
        error_log("New password too short: " . strlen($new_password) . " characters");
        return [
            'success' => false,
            'message' => 'New password must be at least 6 characters long'
        ];
    }

    // Hash new password
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    error_log("New hash generated: " . substr($new_hash, 0, 30) . "...");
    
    // Update password
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare UPDATE failed: " . $conn->error);
        $conn->close();
        return [
            'success' => false,
            'message' => 'System error: Failed to prepare update'
        ];
    }
    
    $stmt->bind_param("si", $new_hash, $user_id);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        $conn->close();
        
        error_log("Update executed. Affected rows: $affected_rows");
        
        if ($affected_rows > 0) {
            error_log("Password update SUCCESS for user: {$user['username']}");
            return [
                'success' => true,
                'message' => 'Password changed successfully'
            ];
        } else {
            error_log("Update executed but NO rows affected");
            // Still return success if the password hash was identical?
            return [
                'success' => false,
                'message' => 'No changes made. Please try a different password.'
            ];
        }
    }

    $error = $stmt->error;
    $stmt->close();
    $conn->close();
    
    error_log("Update failed with error: " . $error);
    
    return [
        'success' => false,
        'message' => 'Password change failed: ' . $error
    ];
}
/**
 * Delete user profile image
 */
function deleteProfileImage($user_id)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Get current image path
    $settings = getUserSettings($user_id);

    if (!$settings || empty($settings['profile_image'])) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'No profile image to delete'
        ];
    }

    // Delete image file
    if (file_exists($settings['profile_image'])) {
        unlink($settings['profile_image']);
    }

    // Update database
    $stmt = $conn->prepare("UPDATE settings SET profile_image = NULL WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Profile image deleted successfully'
        ];
    }

    $error = $stmt->error;
    $stmt->close();
    mysqli_close($conn);
    return [
        'success' => false,
        'message' => 'Failed to delete profile image: ' . $error
    ];
}