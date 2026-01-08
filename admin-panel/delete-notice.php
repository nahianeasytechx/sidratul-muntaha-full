<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include functions file (adjust path based on your file structure)
require_once "./components/header.php";

// Protect page - only logged in users can delete
protectPage();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: all-notices.php?error=' . urlencode('Notice ID is required'));
    exit();
}

$notice_id = intval($_GET['id']);
$from = isset($_GET['from']) ? $_GET['from'] : 'list';

// Check if notice exists
$notice = getNoticeById($notice_id);

if (!$notice) {
    header('Location: all-notices.php?error=' . urlencode('Notice not found'));
    exit();
}

// Perform deletion
$result = deleteNotice($notice_id);

// Redirect based on result and source
if ($result['success']) {
    if ($from === 'view') {
        // If deleting from view page, go back to list with success message
        header('Location: all-notices.php?success=' . urlencode('Notice deleted successfully'));
    } else {
        // If deleting from list, stay on list with success message
        header('Location: all-notices.php?success=' . urlencode('Notice deleted successfully'));
    }
} else {
    if ($from === 'view') {
        // If deletion failed from view page, go back to view with error
        header('Location: view-notice.php?id=' . $notice_id . '&error=' . urlencode($result['message']));
    } else {
        // If deletion failed from list, stay on list with error
        header('Location: all-notices.php?error=' . urlencode($result['message']));
    }
}
exit();
?>