<?php
require_once './components/header.php';

// Protect page - ensure user is logged in
protectPage();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = 'Invalid slider ID';
    echo "<script>
        window.location.href = 'slider.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

$result = deleteSlider($id);

if ($result['success']) {
    $_SESSION['success_message'] = 'Slider deleted successfully';
} else {
    $_SESSION['error_message'] = $result['message'] ?? 'Failed to delete slider';
}

    echo "<script>
        window.location.href = 'slider.php';
    </script>";
exit;
?>