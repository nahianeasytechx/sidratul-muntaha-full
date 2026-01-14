<?php
require './components/header.php';
protectPage();

// Check if slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    $msg = "Notice identifier is required!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

$notice_slug = trim($_GET['slug']);

// Get notice by slug to find its ID
$notice = getNoticeBySlug($notice_slug);

if (!$notice) {
    $msg = "Notice not found!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

// Delete the notice using its ID
$result = deleteNotice($notice['id']);

// Determine redirect location
$redirect = 'all-notice.php';
if (isset($_GET['from']) && $_GET['from'] === 'view') {
    $redirect = 'all-notice.php?deleted=1';
}

if ($result['success']) {
    echo "<script>
        window.location.href = '{$redirect}';
    </script>";
} else {
    echo "<script>
        alert(" . json_encode($result['message']) . ");
        window.history.back();
    </script>";
}
exit;