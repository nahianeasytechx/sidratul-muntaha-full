<?php
// delete-scholarship.php - Simple scholarship deletion
session_start();
require './components/header.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = 'No application ID provided.';
 echo"<script>window.location.href='scholarship-application-list.php'</script>";
    exit;
}

$application_id = intval($_GET['id']);

// Verify application exists
$application = getScholarshipApplicationById($application_id);

if (!$application) {
    $_SESSION['error_message'] = 'Application not found.';
 echo"<script>window.location.href='scholarship-application-list.php'</script>";
    exit;
}

// Delete the application
$result = deleteScholarshipApplication($application_id);

if ($result['success']) {
    $_SESSION['success_message'] = '';
} else {
    $_SESSION['error_message'] = $result['message'];
}

// Redirect back to list
 echo"<script>window.location.href='scholarship-application-list.php'</script>";
exit;
?>