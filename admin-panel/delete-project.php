<?php
require './components/header.php';
protectPage();

// Check for slug or ID parameter
$activity = null;

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    // Get activity by slug
    $slug = $_GET['slug'];
    $activity = getActivityBySlug($slug);
    
    if (!$activity) {
        $msg = "Project not found!";
        echo "<script>
            alert(" . json_encode($msg) . ");
            window.location.href = 'all-projects.php';
        </script>";
        exit;
    }
    
    $activity_id = $activity['id'];
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    // Fallback to ID for backward compatibility
    $activity_id = intval($_GET['id']);
    $activity = getActivityById($activity_id);
    
    if (!$activity) {
        $msg = "Project not found!";
        echo "<script>
            alert(" . json_encode($msg) . ");
            window.location.href = 'all-projects.php';
        </script>";
        exit;
    }
} else {
    $msg = "Project identifier is required!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.location.href = 'all-projects.php';
    </script>";
    exit;
}

// Delete the activity
$result = deleteActivity($activity_id);

if ($result['success']) {
    // Check if we came from view page
    $from = isset($_GET['from']) ? $_GET['from'] : '';
    $successMsg = "Project deleted successfully!";
    
    echo "<script>
        alert(" . json_encode($successMsg) . ");
        window.location.href = 'all-projects.php?success=1';
    </script>";
} else {
    echo "<script>
        alert(" . json_encode($result['message']) . ");
        window.history.back();
    </script>";
}
exit;