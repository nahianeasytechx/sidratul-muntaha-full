<?php

    function getDatabaseConnection() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sidratul_muntaha';
    // $host = 'localhost';
    // $username = 'sidratul';
    // $password = 'L5e567zQnJx.A:';
    // $database = 'sidratul_muntaha';
    
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        return null;
    }
    
    return $conn;
}


// convert to slug 
function slug($text)
{
    $text = trim($text);
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
    return trim($text, '-');
}

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
   echo"<script>window.location.href='login.php'</script>";
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
         echo"<script>window.location.href='login.php'</script>";
        exit();
    }
}

/**
 * Change user password
 */



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


/**
 * Get user settings with user data - FIXED
 */


/**
 * Get user settings with linked username
 */
function getUserSettings($user_id)
{
    $conn = getDatabaseConnection();
    if (!$conn) return null;

    $stmt = $conn->prepare("
        SELECT 
            s.id,
            s.user_id,
            s.full_name,
            s.phone,
            s.email,
            s.address,
            s.profile_image,
            s.updated_at,
            u.username, 
            u.created_at as user_created_at
        FROM settings s
        LEFT JOIN users u ON s.user_id = u.id
        WHERE s.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $settings = $result->fetch_assoc() ?? null;

    $stmt->close();
    mysqli_close($conn);
    return $settings;
}

/**
 * Get user by ID
 */
function getUserById($user_id)
{
    $conn = getDatabaseConnection();
    if (!$conn) return null;

    $stmt = $conn->prepare("SELECT id, username, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc() ?? null;

    $stmt->close();
    mysqli_close($conn);
    return $user;
}

/**
 * Ensure settings exist
 */
function createUserSettings($user_id, $full_name)
{
    $conn = getDatabaseConnection();
    if (!$conn) return false;

    // Already exists?
    $check = $conn->prepare("SELECT id FROM settings WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;
    $check->close();

    if ($exists) {
        mysqli_close($conn);
        return true;
    }

    $stmt = $conn->prepare("INSERT INTO settings (user_id, full_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $full_name);
    $success = $stmt->execute();

    $stmt->close();
    mysqli_close($conn);
    return $success;
}

/**
 * Update user profile
 * This updates:
 * - settings.full_name, phone, profile_image
 * - users.username = settings.full_name
 */
function updateUserProfile($user_id, $data, $files = null)
{
    $conn = getDatabaseConnection();
    if (!$conn) return ['success'=>false, 'message'=>'Database connection error'];

    // Ensure settings exist
    $check = $conn->prepare("SELECT id FROM settings WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;
    $check->close();

    if (!$exists) {
        $user = getUserById($user_id);
        createUserSettings($user_id, $user['username']);
    }

    $full_name = trim($data['full_name'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $email = trim($data['email'] ?? '');
    $address = trim($data['address'] ?? '');
    $profile_image = null;

    // Handle profile image upload
    if ($files && isset($files['profile_image']) && $files['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $ext = pathinfo($files['profile_image']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array(strtolower($ext), $allowed)) {
            mysqli_close($conn);
            return ['success'=>false, 'message'=>'Invalid file type'];
        }
        if ($files['profile_image']['size'] > 5*1024*1024) {
            mysqli_close($conn);
            return ['success'=>false, 'message'=>'File too large'];
        }

        $filename = 'profile_'.$user_id.'_'.time().'.'.$ext;
        $upload_path = $upload_dir.$filename;

        // Delete old photo
        $old = getUserSettings($user_id);
        if ($old && !empty($old['profile_image']) && file_exists($old['profile_image'])) {
            unlink($old['profile_image']);
        }

        if (move_uploaded_file($files['profile_image']['tmp_name'], $upload_path)) {
            $profile_image = $upload_path;
        } else {
            mysqli_close($conn);
            return ['success'=>false, 'message'=>'Upload failed'];
        }
    }

    // Update settings - now includes email and address
    if ($profile_image) {
        $stmt = $conn->prepare("UPDATE settings SET full_name=?, phone=?, email=?, address=?, profile_image=? WHERE user_id=?");
        $stmt->bind_param("sssssi", $full_name, $phone, $email, $address, $profile_image, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE settings SET full_name=?, phone=?, email=?, address=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $full_name, $phone, $email, $address, $user_id);
    }

    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return ['success'=>false, 'message'=>'Settings update failed: '.$error];
    }
    $stmt->close();

    // Update username in users table
    $stmt = $conn->prepare("UPDATE users SET username=? WHERE id=?");
    $stmt->bind_param("si", $full_name, $user_id);
    $stmt->execute();
    $stmt->close();

    mysqli_close($conn);
    return ['success'=>true, 'message'=>'Profile updated successfully'];
}
/**
 * Change password
 */
function changePassword($user_id, $current_password, $new_password)
{
    $conn = getDatabaseConnection();
    if (!$conn) return ['success'=>false, 'message'=>'DB error'];

    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        mysqli_close($conn);
        return ['success'=>false, 'message'=>'User not found'];
    }

    if (!password_verify($current_password, $user['password_hash'])) {
        mysqli_close($conn);
        return ['success'=>false, 'message'=>'Current password incorrect'];
    }

    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password_hash=? WHERE id=?");
    $stmt->bind_param("si", $new_hash, $user_id);
    $stmt->execute();
    $changed = $stmt->affected_rows === 1;
    $stmt->close();
    mysqli_close($conn);

    return $changed
        ? ['success'=>true, 'message'=>'Password changed successfully']
        : ['success'=>false, 'message'=>'Password not changed'];
}

/**
 * Delete profile image
 */
function deleteProfileImage($user_id)
{
    $conn = getDatabaseConnection();
    if (!$conn) return ['success'=>false, 'message'=>'DB error'];

    $settings = getUserSettings($user_id);
    if (!$settings || empty($settings['profile_image'])) {
        mysqli_close($conn);
        return ['success'=>false, 'message'=>'No profile image'];
    }

    if (file_exists($settings['profile_image'])) unlink($settings['profile_image']);

    $stmt = $conn->prepare("UPDATE settings SET profile_image=NULL WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);

    return ['success'=>true, 'message'=>'Profile image deleted'];
}

/**
 * Save contact form submission
 */
function saveContactSubmission($data)
{
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection error.'];
    }

    // Validate required fields
    $required_fields = ['name', 'email', 'subject', 'message'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            mysqli_close($conn);
            return ['success' => false, 'message' => ucfirst($field) . ' is required.'];
        }
    }

    // Sanitize data
    $name = mysqli_real_escape_string($conn, trim($data['name']));
    $email = mysqli_real_escape_string($conn, trim($data['email']));
    $subject = mysqli_real_escape_string($conn, trim($data['subject']));
    $message = mysqli_real_escape_string($conn, trim($data['message']));
    
    // Get client information
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 500);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Invalid email address.'];
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO contact_submissions (name, email, subject, message, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error];
    }

    $stmt->bind_param(
        "ssssss",
        $name,
        $email,
        $subject,
        $message,
        $ip_address,
        $user_agent
    );

    // Execute the statement
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Your message has been sent successfully. We will contact you soon.',
            'id' => $id
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to send message: ' . $error
        ];
    }
    
}
function getAllContactSubmissions($filters = [])
{
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection error.'];
    }

    // Base query
    $sql = "SELECT id, name, email, subject, message, ip_address, user_agent, created_at, status 
            FROM contact_submissions";
    
    $conditions = [];
    $params = [];
    $types = "";

    // Optional filters
    if (isset($filters['status']) && !empty($filters['status'])) {
        $conditions[] = "status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }

    if (isset($filters['email']) && !empty($filters['email'])) {
        $conditions[] = "email = ?";
        $params[] = $filters['email'];
        $types .= "s";
    }

    if (isset($filters['date_from']) && !empty($filters['date_from'])) {
        $conditions[] = "created_at >= ?";
        $params[] = $filters['date_from'];
        $types .= "s";
    }

    if (isset($filters['date_to']) && !empty($filters['date_to'])) {
        $conditions[] = "created_at <= ?";
        $params[] = $filters['date_to'];
        $types .= "s";
    }

    // Add WHERE clause if filters exist
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Order by most recent first
    $sql .= " ORDER BY created_at DESC";

    // Optional pagination
    if (isset($filters['limit']) && is_numeric($filters['limit'])) {
        $sql .= " LIMIT ?";
        $params[] = (int)$filters['limit'];
        $types .= "i";
        
        if (isset($filters['offset']) && is_numeric($filters['offset'])) {
            $sql .= " OFFSET ?";
            $params[] = (int)$filters['offset'];
            $types .= "i";
        }
    }

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error];
    }

    // Bind parameters if any exist
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Failed to fetch submissions: ' . $error];
    }

    $result = $stmt->get_result();
    $submissions = [];

    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }

    $stmt->close();
    mysqli_close($conn);

    return [
        'success' => true,
        'data' => $submissions,
        'count' => count($submissions)
    ];
}
/**
 * Get contact information from database (address, phone, email)
 */
/**
 * Get contact information from settings table
 */
function getContactInformation()
{
    $conn = getDatabaseConnection();
    if (!$conn) {
        // Return default values if no connection
        return [
            'address' => '1481 Creekside Lane Avila Beach, CA 93424',
            'phone' => '+53 345 7953 32453',
            'email' => 'yourmail@gmail.com'
        ];
    }

    // Get the first user's contact info from settings table
    $sql = "SELECT email, phone, address FROM settings WHERE email IS NOT NULL AND email != '' LIMIT 1";
    
    $result = mysqli_query($conn, $sql);

    $contact_info = [
        'address' => '1481 Creekside Lane Avila Beach, CA 93424',
        'phone' => '+53 345 7953 32453',
        'email' => 'yourmail@gmail.com'
    ];
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user_info = mysqli_fetch_assoc($result);
        
        // Update with database values if they exist
        if (!empty($user_info['email'])) {
            $contact_info['email'] = $user_info['email'];
        }
        if (!empty($user_info['phone'])) {
            $contact_info['phone'] = $user_info['phone'];
        }
        if (!empty($user_info['address'])) {
            $contact_info['address'] = $user_info['address'];
        }
        
        mysqli_free_result($result);
    }

    mysqli_close($conn);
    return $contact_info;
}
/*
 * Send email notification to admin when contact form is submitted
 */

/**
 * Get all donations with optional filters
 */
function getAllDonations($filters = [])
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT dl.*, dc.title as category_name 
            FROM donation_list dl 
            LEFT JOIN donation_categories dc ON dl.category_id = dc.id 
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    // Add filters
    if (!empty($filters['payment_status'])) {
        $sql .= " AND dl.payment_status = ?";
        $params[] = $filters['payment_status'];
        $types .= "s";
    }
    
    if (!empty($filters['category_id'])) {
        $sql .= " AND dl.category_id = ?";
        $params[] = $filters['category_id'];
        $types .= "i";
    }
    
    if (!empty($filters['start_date'])) {
        $sql .= " AND DATE(dl.created_at) >= ?";
        $params[] = $filters['start_date'];
        $types .= "s";
    }
    
    if (!empty($filters['end_date'])) {
        $sql .= " AND DATE(dl.created_at) <= ?";
        $params[] = $filters['end_date'];
        $types .= "s";
    }
    
    if (!empty($filters['search'])) {
        $sql .= " AND (dl.name LIKE ? OR dl.email LIKE ? OR dl.contact LIKE ? OR dl.transaction_id LIKE ?)";
        $searchTerm = "%{$filters['search']}%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $types .= str_repeat("s", 4);
    }
    
    $sql .= " ORDER BY dl.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $donations = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row;
        }
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $donations;
}

/**
 * Get donation by ID
 */
function getDonationById($id)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT dl.*, dc.title as category_name 
            FROM donation_list dl 
            LEFT JOIN donation_categories dc ON dl.category_id = dc.id 
            WHERE dl.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $donation = null;
    if ($result && $result->num_rows > 0) {
        $donation = $result->fetch_assoc();
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $donation;
}

/**
 * Get donation by transaction ID
 */
function getDonationByTransactionId($transaction_id)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT * FROM donation_list WHERE transaction_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $donation = null;
    if ($result && $result->num_rows > 0) {
        $donation = $result->fetch_assoc();
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $donation;
}

/**
 * Create new donation
 */

/**
 * Create new donation - FIXED VERSION
 */
function createDonation($data)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Generate transaction ID
    $transaction_id = 'DON' . date('YmdHis') . rand(100, 999);

    // Validate and sanitize category_id
    $category_id = null;
    if (!empty($data['category_id'])) {
        $cat_id = intval($data['category_id']);
        
        // Verify category exists
        $check_stmt = $conn->prepare("SELECT id FROM donation_categories WHERE id = ?");
        $check_stmt->bind_param("i", $cat_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $category_id = $cat_id;
        }
        $check_stmt->close();
    }

    // Safe variables
    $amount         = (float) $data['amount'];
    $name           = $data['name'];
    $contact        = $data['contact'] ?? null;
    $email          = $data['email'] ?? null;
    $address        = $data['address'] ?? null;
    $behalf_of      = $data['behalf_of'] ?? null;
    $payment_method = $data['payment_method'];
    $payment_status = $data['payment_status'] ?? 'pending';
    $notes          = $data['notes'] ?? null;

    // User info
    $donor_ip   = $_SERVER['REMOTE_ADDR'] ?? null;
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $sql = "INSERT INTO donation_list (
                transaction_id,
                amount,
                name,
                contact,
                email,
                address,
                category_id,
                behalf_of,
                payment_method,
                payment_status,
                donor_ip,
                user_agent,
                notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Prepare failed: ' . $conn->error
        ];
    }

    $stmt->bind_param(
        "sdssssissssss",
        $transaction_id,
        $amount,
        $name,
        $contact,
        $email,
        $address,
        $category_id,
        $behalf_of,
        $payment_method,
        $payment_status,
        $donor_ip,
        $user_agent,
        $notes
    );

    if ($stmt->execute()) {
        $insert_id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);

        return [
            'success' => true,
            'donation_id' => $insert_id,
            'transaction_id' => $transaction_id
        ];
    }

    $error = $stmt->error;
    $stmt->close();
    mysqli_close($conn);

    return [
        'success' => false,
        'message' => $error
    ];
}



/**
 * Update donation status
 */
function updateDonationStatus($id, $status, $notes = null)
{
    $conn = getDatabaseConnection();
    
    $sql = "UPDATE donation_list SET 
                payment_status = ?,
                notes = ?
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $notes, $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Donation status updated successfully'
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to update donation status: ' . $error
        ];
    }
}

/**
 * Delete donation
 */
function deleteDonation($id)
{
    $conn = getDatabaseConnection();
    
    // First check if donation exists
    $check_sql = "SELECT id FROM donation_list WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 0) {
        $check_stmt->close();
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Donation not found'
        ];
    }
    $check_stmt->close();
    
    // Delete donation
    $sql = "DELETE FROM donation_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        mysqli_close($conn);
        
        if ($affected_rows > 0) {
            return [
                'success' => true,
                'message' => 'Donation deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Donation not found or already deleted'
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
 * Get donation statistics
 */
function getDonationStatistics($period = 'all')
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT 
                COUNT(*) as total_donations,
                SUM(CASE WHEN payment_status = 'completed' THEN amount ELSE 0 END) as total_amount,
                AVG(CASE WHEN payment_status = 'completed' THEN amount ELSE NULL END) as avg_amount,
                MIN(CASE WHEN payment_status = 'completed' THEN amount ELSE NULL END) as min_amount,
                MAX(CASE WHEN payment_status = 'completed' THEN amount ELSE NULL END) as max_amount
            FROM donation_list";
    
    // Add period filter
    if ($period === 'today') {
        $sql .= " WHERE DATE(created_at) = CURDATE()";
    } elseif ($period === 'month') {
        $sql .= " WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    } elseif ($period === 'year') {
        $sql .= " WHERE YEAR(created_at) = YEAR(CURDATE())";
    } elseif ($period === 'week') {
        $sql .= " WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
    }
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $stats = $result->fetch_assoc();
    } else {
        $stats = [
            'total_donations' => 0,
            'total_amount' => 0,
            'avg_amount' => 0,
            'min_amount' => 0,
            'max_amount' => 0
        ];
    }
    
    mysqli_close($conn);
    return $stats;
}

/**
 * Get donations by category
 */
function getDonationsByCategory($limit = 10)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT 
                dc.title as category_name,
                COUNT(dl.id) as donation_count,
                SUM(CASE WHEN dl.payment_status = 'completed' THEN dl.amount ELSE 0 END) as total_amount
            FROM donation_categories dc
            LEFT JOIN donation_list dl ON dc.id = dl.category_id
            GROUP BY dc.id
            ORDER BY total_amount DESC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $categories;
}
function getAllScholarshipApplications($filters = [], $sortBy = 'newest') {
    $conn = getDatabaseConnection();
    
    // Base query - adjusted to match your actual table structure
    $sql = "SELECT id, name, phone, email, address, institute_name as institution, 
            institution_type as type, created_at as applied_date 
            FROM scholarship_list WHERE 1=1";
    
    $params = [];
    $types = "";
    
    // Apply filters
    if (!empty($filters['type']) && $filters['type'] !== 'all') {
        $sql .= " AND institution_type = ?";
        $params[] = $filters['type'];
        $types .= "s";
    }
    
    if (!empty($filters['search'])) {
        $sql .= " AND (name LIKE ? OR phone LIKE ? OR email LIKE ?)";
        $searchParam = '%' . $filters['search'] . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    if (!empty($filters['institution'])) {
        $sql .= " AND institute_name LIKE ?";
        $params[] = '%' . $filters['institution'] . '%';
        $types .= "s";
    }
    
    // Apply sorting
    switch ($sortBy) {
        case 'oldest':
            $sql .= " ORDER BY created_at ASC";
            break;
        case 'name-asc':
            $sql .= " ORDER BY name ASC";
            break;
        case 'name-desc':
            $sql .= " ORDER BY name DESC";
            break;
        case 'newest':
        default:
            $sql .= " ORDER BY created_at DESC";
            break;
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return [];
    }
    
    // Bind parameters if any
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $applications = [];
    while ($row = $result->fetch_assoc()) {
        // Add a default status of 'pending' since the table doesn't have a status column
        $row['status'] = 'pending';
        $applications[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $applications;
}

/**
 * Get scholarship application by ID
 * @param int $id Application ID
 * @return array|null Application data or null if not found
 */
function getScholarshipApplicationById($id) {
    $conn = getDatabaseConnection();
    
    $sql = "SELECT id, name, phone, email, address, institute_name, 
            institution_type, created_at 
            FROM scholarship_list WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return null;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $application = $result->fetch_assoc();
    
    // Add default status
    if ($application) {
        $application['status'] = 'pending';
    }
    
    $stmt->close();
    $conn->close();
    
    return $application;
}

/**
 * Get scholarship statistics
 * @return array Statistics data
 */
function getScholarshipStatistics() {
    $conn = getDatabaseConnection();
    
    $stats = [
        'total' => 0,
        'processed' => 0,
        'pending' => 0,
        'rejected' => 0
    ];
    
    // Get total count
    $result = $conn->query("SELECT COUNT(*) as count FROM scholarship_list");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total'] = $row['count'];
        // Since there's no status column, all applications are considered pending
        $stats['pending'] = $row['count'];
    }
    
    $conn->close();
    
    return $stats;
}

/**
 * Delete scholarship application
 * @param int $id Application ID
 * @return array Result array
 */
function deleteScholarshipApplication($id) {
    $conn = getDatabaseConnection();
    
    $sql = "DELETE FROM scholarship_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ];
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        $stmt->close();
        $conn->close();
        
        if ($affected > 0) {
            return [
                'success' => true,
                'message' => 'Application deleted successfully!'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Application not found.'
            ];
        }
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        
        return [
            'success' => false,
            'message' => 'Failed to delete application: ' . $error
        ];
    }
}

/**
 * Save scholarship application
 * @param array $data Application data
 * @return array Result array
 */
function saveScholarshipApplication($data) {
    $conn = getDatabaseConnection();
    
    // Validate required fields
    if (empty($data['name']) || empty($data['institution_type'])) {
        return [
            'success' => false,
            'message' => 'Name and Institution Type are required fields.'
        ];
    }
    
    // Validate email format if provided
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Invalid email format.'
        ];
    }
    
    // Sanitize inputs
    $name = $conn->real_escape_string(trim($data['name']));
    $email = $conn->real_escape_string(trim($data['email']));
    $address = $conn->real_escape_string(trim($data['youraddress']));
    $institution_type = $conn->real_escape_string(trim($data['institution_type']));
    $institute_name = $conn->real_escape_string(trim($data['instituename']));
    $phone = $conn->real_escape_string(trim($data['contact']));
    
    // Prepare SQL statement (removed status field)
    $sql = "INSERT INTO scholarship_list (name, email, address, institution_type, institute_name, phone) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ];
    }
    
    // Bind parameters
    $stmt->bind_param("ssssss", $name, $email, $address, $institution_type, $institute_name, $phone);
    
    // Execute statement
    if ($stmt->execute()) {
        $application_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        
        return [
            'success' => true,
            'message' => 'Scholarship application submitted successfully!',
            'application_id' => $application_id
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        
        return [
            'success' => false,
            'message' => 'Failed to submit application: ' . $error
        ];
    }
}

/**
 * Update scholarship application
 * @param int $id Application ID
 * @param array $data Updated data
 * @return array Result array
 */
function updateScholarshipApplication($id, $data) {
    $conn = getDatabaseConnection();
    
    // Validate required fields
    if (empty($data['name']) || empty($data['institution_type'])) {
        return [
            'success' => false,
            'message' => 'Name and Institution Type are required fields.'
        ];
    }
    
    // Validate email format if provided
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Invalid email format.'
        ];
    }
    
    // Sanitize inputs
    $name = $conn->real_escape_string(trim($data['name']));
    $email = $conn->real_escape_string(trim($data['email']));
    $address = $conn->real_escape_string(trim($data['youraddress']));
    $institution_type = $conn->real_escape_string(trim($data['institution_type']));
    $institute_name = $conn->real_escape_string(trim($data['instituename']));
    $phone = $conn->real_escape_string(trim($data['contact']));
    
    $sql = "UPDATE scholarship_list 
            SET name = ?, email = ?, address = ?, institution_type = ?, 
                institute_name = ?, phone = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return [
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ];
    }
    
    $stmt->bind_param("ssssssi", $name, $email, $address, $institution_type, 
                      $institute_name, $phone, $id);
    
    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        $stmt->close();
        $conn->close();
        
        return [
            'success' => true,
            'message' => 'Application updated successfully!',
            'affected_rows' => $affected
        ];
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        
        return [
            'success' => false,
            'message' => 'Failed to update application: ' . $error
        ];
    }
}




function getTotalApplications() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT COUNT(*) as count FROM scholarship_list");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get total count of active scholarship categories
 */
function getTotalScholarshipCategories() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    // Count distinct institution types from scholarship applications
    $result = $conn->query("SELECT COUNT(DISTINCT institution_type) as count FROM scholarship_list WHERE institution_type IS NOT NULL AND institution_type != ''");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get total count of students
 */
function getTotalStudents() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT COUNT(*) as count FROM scholarship_list");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get total donations count
 */
function getTotalDonationsCount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT COUNT(*) as count FROM donation_list");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get total donation amount
 */
function getTotalDonationAmount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT SUM(amount) as total FROM donation_list WHERE payment_status = 'completed'");
    $total = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'] ?? 0;
    }
    
    $conn->close();
    return $total;
}

/**
 * Get pending applications count
 */
function getPendingApplicationsCount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    // Since there's no status column, we'll consider recent applications as pending
    $result = $conn->query("SELECT COUNT(*) as count FROM scholarship_list WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get processed applications count
 */
function getProcessedApplicationsCount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    // Applications older than 30 days considered processed
    $result = $conn->query("SELECT COUNT(*) as count FROM scholarship_list WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get approved scholarships count (simulated as 60% of total)
 */
function getApprovedScholarshipsCount() {
    $total = getTotalApplications();
    return floor($total * 0.6);
}

/**
 * Get rejected applications count (simulated as 10% of total)
 */
function getRejectedApplicationsCount() {
    $total = getTotalApplications();
    return floor($total * 0.1);
}

/**
 * Get active notices count
 */
function getActiveNoticesCount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT COUNT(*) as count FROM notices WHERE status = 'active'");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get upcoming activities count
 */
function getUpcomingActivitiesCount() {
    $conn = getDatabaseConnection();
    if (!$conn) return 0;
    
    $result = $conn->query("SELECT COUNT(*) as count FROM activities WHERE status = 'active'");
    $count = 0;
    
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    
    $conn->close();
    return $count;
}

/**
 * Get recent donations for dashboard table
 */
function getRecentDonations($limit = 5) {
    $conn = getDatabaseConnection();
    if (!$conn) return [];
    
    $sql = "SELECT dl.*, dc.title as category_name 
            FROM donation_list dl 
            LEFT JOIN donation_categories dc ON dl.category_id = dc.id 
            ORDER BY dl.created_at DESC 
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $donations = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row;
        }
    }
    
    $stmt->close();
    $conn->close();
    return $donations;
}

/**
 * Get dashboard statistics summary
 */
function getDashboardStats() {
    return [
        'total_applications' => getTotalApplications(),
        'scholarship_categories' => getTotalScholarshipCategories(),
        'total_awarded' => getApprovedScholarshipsCount(),
        'total_students' => getTotalStudents(),
        'total_donations' => getTotalDonationsCount(),
        'donation_amount' => getTotalDonationAmount(),
        'pending_applications' => getPendingApplicationsCount(),
        'processed_applications' => getProcessedApplicationsCount(),
        'approved_scholarships' => getApprovedScholarshipsCount(),
        'rejected_applications' => getRejectedApplicationsCount(),
        'active_notices' => getActiveNoticesCount(),
        'upcoming_activities' => getUpcomingActivitiesCount()
    ];
}

// ============================================
// SLUG GENERATION AND VALIDATION FUNCTIONS
// ============================================

/**
 * Generate a unique slug from text
 * @param string $text The text to convert to slug
 * @param string $table The table name (notices or activities)
 * @param int|null $exclude_id ID to exclude when checking uniqueness (for updates)
 * @return string Unique slug
 */
function generateUniqueSlug($text, $table, $exclude_id = null)
{
    $conn = getDatabaseConnection();
    if (!$conn) return slug($text);

    $base_slug = slug($text);
    $final_slug = $base_slug;
    $counter = 1;

    // Check if slug exists
    while (true) {
        $sql = "SELECT id FROM $table WHERE slug = ?";
        if ($exclude_id !== null) {
            $sql .= " AND id != ?";
        }

        $stmt = $conn->prepare($sql);
        
        if ($exclude_id !== null) {
            $stmt->bind_param("si", $final_slug, $exclude_id);
        } else {
            $stmt->bind_param("s", $final_slug);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            break;
        }

        $final_slug = $base_slug . '-' . $counter;
        $counter++;
        $stmt->close();
    }

    mysqli_close($conn);
    return $final_slug;
}

/**
 * Validate and sanitize slug
 * @param string $slug The slug to validate
 * @return string Sanitized slug
 */
function validateSlug($slug)
{
    // Remove any invalid characters
    $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));
    // Remove multiple consecutive hyphens
    $slug = preg_replace('/-+/', '-', $slug);
    // Trim hyphens from start and end
    return trim($slug, '-');
}

// ============================================
// NOTICE SLUG FUNCTIONS
// ============================================

/**
 * Get notice by slug
 * @param string $slug The notice slug
 * @return array|null Notice data or null if not found
 */
function getNoticeBySlug($slug)
{
    $conn = getDatabaseConnection();
    if (!$conn) return null;

    $sql = "SELECT * FROM notices WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    $notice = null;
    if ($result && $result->num_rows > 0) {
        $notice = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $notice;
}

/**
 * Create notice with slug (updated version)
 */
/**
 * Create notice with slug (updated version - backward compatible)
 */
function createNoticeWithSlug($data)
{
    $conn = getDatabaseConnection();

    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection error.'
        ];
    }

    // Generate unique slug
    $slug = generateUniqueSlug($data['title'], 'notices');

    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $publish_date = mysqli_real_escape_string($conn, $data['publish_date']);
    $duration = intval($data['duration']);
    $type = mysqli_real_escape_string($conn, $data['type']);
    $age_limit = !empty($data['age_limit']) ? intval($data['age_limit']) : 'NULL';
    $category = mysqli_real_escape_string($conn, $data['category']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    // Check if slug column exists
    $check_column = mysqli_query($conn, "SHOW COLUMNS FROM notices LIKE 'slug'");
    $slug_column_exists = mysqli_num_rows($check_column) > 0;

    if ($slug_column_exists) {
        // New version with slug column
        $sql = "INSERT INTO notices (title, slug, description, publish_date, duration, type, age_limit, category, status) 
                VALUES ('$title', '$slug', '$description', '$publish_date', $duration, '$type', $age_limit, '$category', '$status')";
    } else {
        // Old version without slug column
        $sql = "INSERT INTO notices (title, description, publish_date, duration, type, age_limit, category, status) 
                VALUES ('$title', '$description', '$publish_date', $duration, '$type', $age_limit, '$category', '$status')";
    }

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Notice created successfully',
            'id' => $id,
            'slug' => $slug
        ];
    } else {
        $error = mysqli_error($conn);
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to create notice: ' . $error
        ];
    }
}

/**
 * Update notice with slug handling
 */
function updateNoticeWithSlug(int $id, array $data): array
{
    $conn = getDatabaseConnection();
    if (!$conn) return ['success' => false, 'message' => 'DB connection failed'];

    // Get current notice to check if title changed
    $current_notice = getNoticeById($id);
    if (!$current_notice) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Notice not found'];
    }

    // Generate new slug if title changed
    $slug = $current_notice['slug'];
    if ($current_notice['title'] !== $data['title']) {
        $slug = generateUniqueSlug($data['title'], 'notices', $id);
    }

    $sql = "UPDATE notices SET
                title = ?,
                slug = ?,
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
        mysqli_close($conn);
        return ['success' => false, 'message' => $conn->error];
    }

    $age_limit = ($data['age_limit'] === '' || $data['age_limit'] === null)
        ? null
        : (int)$data['age_limit'];

    $stmt->bind_param(
        "sssissssii",
        $data['title'],
        $slug,
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
        $error = $stmt->error;
        $stmt->close();
        mysqli_close($conn);
        return ['success' => false, 'message' => $error];
    }

    $stmt->close();
    mysqli_close($conn);
    return [
        'success' => true,
        'message' => 'Notice updated successfully',
        'slug' => $slug
    ];
}

/**
 * Get active notices with slugs for frontend display
 */
function getActiveNoticesWithSlugs($limit = null)
{
    $conn = getDatabaseConnection();

    $sql = "SELECT id, title, slug, description, publish_date, duration, type, category 
            FROM notices 
            WHERE status = 'active' 
            ORDER BY publish_date DESC";
    
    if ($limit !== null) {
        $sql .= " LIMIT " . intval($limit);
    }

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

// ============================================
// ACTIVITY SLUG FUNCTIONS
// ============================================

/**
 * Get activity by slug
 * @param string $slug The activity slug
 * @return array|null Activity data or null if not found
 */
function getActivityBySlug($slug)
{
    $conn = getDatabaseConnection();
    if (!$conn) return null;

    $sql = "SELECT * FROM activities WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    $activity = null;
    if ($result && $result->num_rows > 0) {
        $activity = $result->fetch_assoc();
    }

    $stmt->close();
    mysqli_close($conn);
    return $activity;
}

/**
 * Create activity with slug (updated version)
 */
function createActivityWithSlug($data)
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

    // Generate unique slug
    $slug = generateUniqueSlug($data['title'], 'activities');

    $sql = "INSERT INTO activities (title, slug, objectives, short_description, description, type, status, image, sections_data) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    $image = isset($data['image']) && !empty($data['image']) ? $data['image'] : null;
    $sections_data = isset($data['sections_data']) && !empty($data['sections_data']) ? $data['sections_data'] : null;

    $stmt->bind_param(
        "sssssssss",
        $data['title'],
        $slug,
        $data['objectives'],
        $data['short_description'],
        $data['description'],
        $data['type'],
        $data['status'],
        $image,
        $sections_data
    );

    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Activity created successfully',
            'id' => $id,
            'slug' => $slug
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
 * Update activity with slug handling
 */
function updateActivityWithSlug(int $id, array $data): array
{
    $conn = getDatabaseConnection();
    
    if (!$conn) {
        return [
            'success' => false,
            'message' => 'Database connection failed'
        ];
    }

    // Get current activity to check if title changed
    $current_activity = getActivityById($id);
    if (!$current_activity) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Activity not found'];
    }

    // Generate new slug if title changed
    $slug = $current_activity['slug'];
    if ($current_activity['title'] !== $data['title']) {
        $slug = generateUniqueSlug($data['title'], 'activities', $id);
    }

    $sql = "UPDATE activities SET
                title = ?,
                slug = ?,
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

    $image = isset($data['image']) && !empty($data['image']) ? $data['image'] : null;
    $sections_data = isset($data['sections_data']) && !empty($data['sections_data']) ? $data['sections_data'] : null;

    $stmt->bind_param(
        "sssssssssi",
        $data['title'],
        $slug,
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
            'message' => 'Activity updated successfully',
            'slug' => $slug
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
 * Get active activities with slugs for frontend display
 */
function getActiveActivitiesWithSlugs($limit = null, $type = null)
{
    $conn = getDatabaseConnection();

    $sql = "SELECT id, title, slug, short_description, type, image, created_at 
            FROM activities 
            WHERE status = 'active'";
    
    if ($type !== null) {
        $sql .= " AND type = '" . mysqli_real_escape_string($conn, $type) . "'";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit !== null) {
        $sql .= " LIMIT " . intval($limit);
    }

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
 * Search activities by slug pattern
 */
function searchActivitiesBySlug($search_term, $limit = 10)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT id, title, slug, short_description, type 
            FROM activities 
            WHERE slug LIKE ? AND status = 'active'
            ORDER BY created_at DESC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $search_pattern = '%' . slug($search_term) . '%';
    $stmt->bind_param("si", $search_pattern, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $activities;
}

/**
 * Get related activities by type
 */
function getRelatedActivities($current_slug, $type, $limit = 3)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT id, title, slug, short_description, image 
            FROM activities 
            WHERE type = ? AND slug != ? AND status = 'active'
            ORDER BY created_at DESC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $type, $current_slug, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $activities;
}

/**
 * Check if slug exists in table
 */
function slugExists($slug, $table, $exclude_id = null)
{
    $conn = getDatabaseConnection();
    
    $sql = "SELECT id FROM $table WHERE slug = ?";
    if ($exclude_id !== null) {
        $sql .= " AND id != ?";
    }
    
    $stmt = $conn->prepare($sql);
    
    if ($exclude_id !== null) {
        $stmt->bind_param("si", $slug, $exclude_id);
    } else {
        $stmt->bind_param("s", $slug);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    
    $stmt->close();
    mysqli_close($conn);
    
    return $exists;
}

// ============================================
// DONATION CATEGORY SLUG FUNCTIONS
// ============================================

/**
 * Get donation category by slug
 * @param string $slug The category slug
 * @return array|null Category data or null if not found
 */
function getDonationCategoryBySlug($slug)
{
    $conn = getDatabaseConnection();
    if (!$conn) return null;

    $sql = "SELECT * FROM donation_categories WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    $stmt->bind_param("s", $slug);
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
 * Create donation category with slug (updated version)
 */
/**
 * Create donation category with slug (FIXED VERSION)
 */
function createDonationCategoryWithSlug($data, $file)
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

    // Generate unique slug
    $slug = generateUniqueSlug($data['title'], 'donation_categories');

    // Get the next display order
    $order_result = mysqli_query($conn, "SELECT MAX(display_order) as max_order FROM donation_categories");
    $order_row = mysqli_fetch_assoc($order_result);
    $next_order = ($order_row['max_order'] ?? 0) + 1;

    // Prepare the SQL statement
    $sql = "INSERT INTO donation_categories (title, slug, image, description, display_order, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        mysqli_close($conn);
        return [
            'success' => false,
            'message' => 'Failed to prepare statement: ' . $conn->error
        ];
    }

    $status = 'active';

    // FIXED: Changed 'sssis' to 'ssssis' (6 parameters)
    // Parameters: title, slug, image, description, display_order, status
    $stmt->bind_param(
        "ssssis",
        $data['title'],
        $slug,
        $image,
        $data['description'],
        $next_order,
        $status
    );

    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Category added successfully',
            'id' => $id,
            'slug' => $slug
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
 * Update donation category with slug handling
 */
function updateDonationCategoryWithSlug($id, $data, $file = null)
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

    // Generate new slug if title changed
    $slug = $existing_category['slug'];
    if ($existing_category['title'] !== $data['title']) {
        $slug = generateUniqueSlug($data['title'], 'donation_categories', $id);
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
                slug = ?,
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
        "ssssi",
        $data['title'],
        $slug,
        $image,
        $data['description'],
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        return [
            'success' => true,
            'message' => 'Category updated successfully',
            'slug' => $slug
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
 * Get active donation categories with slugs for frontend display
 */
function getActiveDonationCategoriesWithSlugs()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT id, title, slug, image, description, display_order 
            FROM donation_categories 
            WHERE status = 'active' 
            ORDER BY display_order ASC";
    
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
 * Get donations by category slug
 */
function getDonationsByCategorySlug($slug, $filters = [])
{
    $conn = getDatabaseConnection();
    
    // First get the category ID from slug
    $category = getDonationCategoryBySlug($slug);
    
    if (!$category) {
        mysqli_close($conn);
        return [];
    }
    
    $sql = "SELECT dl.*, dc.title as category_name 
            FROM donation_list dl 
            LEFT JOIN donation_categories dc ON dl.category_id = dc.id 
            WHERE dl.category_id = ?";
    
    $params = [$category['id']];
    $types = "i";
    
    // Add additional filters
    if (!empty($filters['payment_status'])) {
        $sql .= " AND dl.payment_status = ?";
        $params[] = $filters['payment_status'];
        $types .= "s";
    }
    
    $sql .= " ORDER BY dl.created_at DESC";
    
    if (!empty($filters['limit'])) {
        $sql .= " LIMIT ?";
        $params[] = intval($filters['limit']);
        $types .= "i";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $donations = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row;
        }
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $donations;
}

/**
 * Get donation category statistics by slug
 */
function getDonationCategoryStatsBySlug($slug)
{
    $conn = getDatabaseConnection();
    
    $category = getDonationCategoryBySlug($slug);
    
    if (!$category) {
        mysqli_close($conn);
        return [
            'total_donations' => 0,
            'total_amount' => 0,
            'avg_amount' => 0
        ];
    }
    
    $sql = "SELECT 
                COUNT(*) as total_donations,
                SUM(CASE WHEN payment_status = 'completed' THEN amount ELSE 0 END) as total_amount,
                AVG(CASE WHEN payment_status = 'completed' THEN amount ELSE NULL END) as avg_amount
            FROM donation_list 
            WHERE category_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stats = [
        'total_donations' => 0,
        'total_amount' => 0,
        'avg_amount' => 0
    ];
    
    if ($result) {
        $stats = $result->fetch_assoc();
    }
    
    $stmt->close();
    mysqli_close($conn);
    return $stats;
}

?>




