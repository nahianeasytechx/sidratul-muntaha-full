<?php
session_start();
require_once './functions/functions.php';

// Protect page - ensure user is logged in
protectPage();

// Check if toggle_id is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Toggle the slider status
    $result = toggleSliderStatus($id);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
} else {
    $_SESSION['error_message'] = 'Invalid slider ID';
}

// Redirect back to slider management page
  echo"<script>window.location.href='slider.php'</script>";
exit();
?>