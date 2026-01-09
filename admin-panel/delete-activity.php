<?php
require './components/header.php';
protectPage();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $msg = "Activity ID is required!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

$activity_id = intval($_GET['id']);
$result = deleteActivity($activity_id);

if ($result['success']) {
    echo "<script>
        window.location.href = 'all-activities.php?success=1';
    </script>";
} else {
    echo "<script>
        alert(" . json_encode($result['message']) . ");
        window.history.back();
    </script>";
}
exit;