<?php
require './components/header.php';
protectPage();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $msg = "Notice ID is required!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

$notice_id = intval($_GET['id']);
$result = deleteNotice($notice_id);

if ($result['success']) {
    echo "<script>
        window.location.href = 'all-notice.php';
    </script>";
} else {
    echo "<script>
        alert(" . json_encode($result['message']) . ");
        window.history.back();
    </script>";
}
exit;
