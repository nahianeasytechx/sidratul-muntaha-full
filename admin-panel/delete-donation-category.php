<?php
require './components/header.php';
protectPage();

// Check if slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    $msg = "Category identifier is required!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

$category_slug = trim($_GET['slug']);

// Get category by slug to find its ID
$category = getDonationCategoryBySlug($category_slug);

if (!$category) {
    $msg = "Category not found!";
    echo "<script>
        alert(" . json_encode($msg) . ");
        window.history.back();
    </script>";
    exit;
}

// Delete the category using its ID
$result = deleteDonationCategory($category['id']);

// Determine redirect location
$redirect = 'donation-categories.php';
if (isset($_GET['from']) && $_GET['from'] === 'view') {
    $redirect = 'donation-categories.php?deleted=1';
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