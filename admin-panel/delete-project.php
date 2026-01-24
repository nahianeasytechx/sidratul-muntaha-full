<?php
require './components/header.php';
protectPage();

// Check if slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    echo "<script>window.location.href='all-projects.php?error=" . urlencode('Project slug is required') . "'</script>";
    exit();
}

$slug = $_GET['slug'];
$from = $_GET['from'] ?? 'list'; // 'list' or 'view'

// Get the activity details first (before deletion)
$activity = getActivityBySlug($slug);

if (!$activity) {
    echo "<script>window.location.href='all-projects.php?error=" . urlencode('Project not found') . "'</script>";
    exit();
}

// Store activity title for success message
$activityTitle = $activity['title'];

// Delete all associated images from filesystem
$deletedImagesCount = 0;
$imageDeleteErrors = [];

// Delete multiple images (new format)
if (!empty($activity['images'])) {
    $images = json_decode($activity['images'], true);
    if (is_array($images)) {
        foreach ($images as $imagePath) {
            // Ensure the path is safe and within uploads directory
            if (file_exists($imagePath) && strpos(realpath($imagePath), realpath('../uploads/')) === 0) {
                if (unlink($imagePath)) {
                    $deletedImagesCount++;
                } else {
                    $imageDeleteErrors[] = basename($imagePath);
                }
            }
        }
    }
}

// Delete single image (old format - backward compatibility)
if (!empty($activity['image'])) {
    $oldImagePath = (strpos($activity['image'], '../uploads/') === 0)
        ? $activity['image']
        : '../uploads/activities/' . $activity['image'];
    
    // Ensure the path is safe and within uploads directory
    if (file_exists($oldImagePath) && strpos(realpath($oldImagePath), realpath('../uploads/')) === 0) {
        if (unlink($oldImagePath)) {
            $deletedImagesCount++;
        } else {
            $imageDeleteErrors[] = basename($oldImagePath);
        }
    }
}

// Delete the activity from database
$deleteResult = deleteActivityBySlug($slug);

if ($deleteResult) {
    $successMessage = "Project '$activityTitle' deleted successfully!";
    
    if ($deletedImagesCount > 0) {
        $successMessage .= " ($deletedImagesCount image(s) removed)";
    }
    
    if (!empty($imageDeleteErrors)) {
        $successMessage .= " Note: Some images could not be deleted: " . implode(', ', $imageDeleteErrors);
    }
    
    echo "<script>window.location.href='all-projects.php?success=" . urlencode($successMessage) . "'</script>";
    exit();
} else {
    header("Location: all-projects.php?error=" . urlencode('Failed to delete project from database'));
    exit();
}
?>