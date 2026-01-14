<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donation Categories';
require './components/header.php';

// Protect page
protectPage();

// Handle form submissions with POST-Redirect-GET pattern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $result = createDonationCategoryWithSlug($_POST, $_FILES);
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'] . '  ';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
        // Redirect to prevent form resubmission
        echo "<script>
            window.location.href = 'donation-categories.php';
        </script>";
        exit;
    }

    if (isset($_POST['update_category'])) {
        $slug = trim($_POST['category_slug']);
            // Use the edit parameter from the URL instead of POST
    if (isset($_GET['edit'])) {
        $slug = trim($_GET['edit']);
        
        // Get category by slug to find its ID
        $category = getDonationCategoryBySlug($slug);
        
        if ($category) {
            $result = updateDonationCategoryWithSlug($category['id'], $_POST, $_FILES);
            // ... rest of your code
        } else {
            $_SESSION['error_message'] = 'Category not found.';
        }
    } else {
        $_SESSION['error_message'] = 'No category specified for editing.';
    }

        // Get category by slug to find its ID
        $category = getDonationCategoryBySlug($slug);

        if ($category) {
            $result = updateDonationCategoryWithSlug($category['id'], $_POST, $_FILES);
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
            } else {
                $_SESSION['error_message'] = $result['message'];
            }
        } else {
            $_SESSION['error_message'] = 'Category not found.';
        }

        // Redirect to prevent form resubmission
        echo "<script>
            window.location.href = 'donation-categories.php';
        </script>";
        exit;
    }
}

// Get messages from session
$success_message = '';
$error_message = '';

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Check for deleted parameter
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $success_message = 'Category deleted successfully!';
}

// Get all categories
$categories = getAllDonationCategories();

// Get category for editing
$edit_category = null;
if (isset($_GET['edit'])) {
    $edit_slug = trim($_GET['edit']);
    $edit_category = getDonationCategoryBySlug($edit_slug);
}

?>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Page Header Styling - Matching donation-list.php */
    .page-header {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .page-header h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        border: none;
    }

    .page-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .page-header .breadcrumb-item a:hover {
        color: white;
    }

    .page-header .breadcrumb-item.active {
        color: white;
    }

    .page-header .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Alert Styling */
    .alert {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-weight: 500;
        padding: 1rem 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .alert i {
        font-size: 1.1rem;
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 2rem;
    }

    .card h3 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
    }

    /* Form Styling */
    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* File Input */
    input[type="file"].form-control {
        cursor: pointer;
        padding: 0.6rem;
    }

    input[type="file"].form-control::-webkit-file-upload-button {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 1rem;
    }

    input[type="file"].form-control::-webkit-file-upload-button:hover {
        background: linear-gradient(135deg, #059669, #047857);
    }

    /* Button Styles */
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64748b, #475569);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #475569, #334155);
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table thead th {
        color: white;
        background: linear-gradient(135deg, #10b981, #059669);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #475569;
    }

    .table tbody td.fw-semibold {
        color: #2c3e50;
        font-weight: 700;
    }

    .table img {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Action Buttons */
    .btn-outline-primary {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #0891b2, #0e7490);
    }

    .btn-outline-info {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #d97706, #b45309);
    }

    .btn-outline-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
        border: none;
    }

    .modal-header .modal-title {
        color: white;
        font-weight: 700;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body img {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-body p {
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Image Preview */
    #imagePreview {
        text-align: center;
        margin-top: 1rem;
    }

    #previewImg {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* No Image Fallback */
    .no-image-fallback {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .no-image-fallback.small {
        width: 55px;
        height: 55px;
    }

    .no-image-fallback.medium {
        width: 100%;
        height: 200px;
    }

    /* Responsive Design */
    @media (max-width: 767px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            font-size: 0.875rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card,
    .alert {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div class="d-flex gap-3">
                <div>
                    <h1><i class="fa-solid fa-layer-group me-2"></i>Donation Categories</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <!-- Alerts -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <?php echo htmlspecialchars($success_message); ?> 
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">

            <!-- Add/Edit Form -->
            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3>
                            <?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?>
                        </h3>

                        <form action="" method="post" enctype="multipart/form-data" id="categoryForm">


                            <div class="mb-3">
                                <label for="title" class="form-label">Category Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter category title"
                                    value="<?php echo $edit_category ? htmlspecialchars($edit_category['title']) : ''; ?>" required maxlength="255">
                               
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                    <?php echo $edit_category ? '' : 'required'; ?>>
                                <small class="text-muted">JPG, PNG, WEBP (max 5MB)</small>

                                <div id="imagePreview" class="mt-3" <?php echo $edit_category && !empty($edit_category['image']) ? '' : 'style="display: none;"'; ?>>
                                    <?php if ($edit_category && !empty($edit_category['image'])): ?>
                                        <img id="previewImg"
                                            src="<?php echo htmlspecialchars($edit_category['image']); ?>"
                                            alt="Preview"
                                            class="img-fluid rounded"
                                            style="max-height: 200px;">
                                    <?php else: ?>
                                        <div id="previewFallback" class="no-image-fallback medium">
                                            <p class="mb-0">No image selected</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="4" class="form-control"
                                    placeholder="Write a short description..." ><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" name="<?php echo $edit_category ? 'update_category' : 'add_category'; ?>"
                                    class="btn btn-success flex-grow-1">
                                    <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                                </button>
                                <?php if ($edit_category): ?>
                                    <a href="donation-categories.php" class="btn btn-secondary" style="height: 100%;">Cancel</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category List -->
            <div class="col-lg-7">
                <div class="table-container">
                    <div class="card-body">
                        <h3 class="mb-4">All Categories (<?php echo count($categories); ?>)</h3>

                        <?php if (empty($categories)): ?>
                            <div class="text-center py-5">
                                <i class="fa-solid fa-layer-group fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No categories found. Add your first category!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Created</th>
                                            <th colspan="3" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $index => $category): ?>
                                            <tr>
                                                <td><strong>#<?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></strong></td>
                                                <td>
                                                    <?php if (!empty($category['image'])): ?>
                                                        <img src="<?php echo htmlspecialchars($category['image']); ?>"
                                                            alt="<?php echo htmlspecialchars($category['title']); ?>"
                                                            class="rounded"
                                                            width="55"
                                                            height="55"
                                                            style="object-fit:cover;">
                                                    <?php else: ?>
                                                        <div class="no-image-fallback small">
                                                            <small>No Image</small>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="fw-semibold"><?php echo htmlspecialchars($category['title']); ?></td>
                                                <td><small class="text-muted"><?php echo htmlspecialchars($category['slug']); ?></small></td>
                                                <td><small class="text-muted"><?php echo date('M d, Y', strtotime($category['created_at'])); ?></small></td>
                                                <td class="text-center">
                                                    <button class="p-2 btn-outline-primary" data-bs-toggle="modal" data-bs-target="#descModal<?php echo $category['id']; ?>" title="View Details">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <a href="?edit=<?php echo urlencode($category['slug']); ?>" class="p-2 btn-outline-info" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="p-2 btn-outline-danger"
                                                        title="Delete"
                                                        onclick="window.location.href='delete-donation-category.php?slug=<?= urlencode($category['slug']) ?>'">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                            <!-- Description Modal -->
                                            <div class="modal fade" id="descModal<?php echo $category['id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <?php echo htmlspecialchars($category['title']); ?>
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php if (!empty($category['image'])): ?>
                                                                <img src="<?php echo htmlspecialchars($category['image']); ?>"
                                                                    class="img-fluid rounded mb-3"
                                                                    alt="<?php echo htmlspecialchars($category['title']); ?>">
                                                            <?php else: ?>
                                                                <div class="no-image-fallback medium mb-3">
                                                                    <h5>No Image Available</h5>
                                                                </div>
                                                            <?php endif; ?>
                                                            <p><?php echo htmlspecialchars($category['description']); ?></p>
                                                            <div class="text-muted mt-3">
                                                                <small>
                                                                    <i class="fa-solid fa-link me-2"></i>
                                                                    Slug: <code><?php echo htmlspecialchars($category['slug']); ?></code>
                                                                </small>
                                                                <br>
                                                                <small>
                                                                    <i class="fa-solid fa-calendar me-2"></i>
                                                                    Created: <?php echo date('F d, Y', strtotime($category['created_at'])); ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    /* ===============================
       Image Preview
    ================================ */
    const fileInput = document.getElementById('image');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');

                // Check if there's already an image or fallback
                const existingImg = document.getElementById('previewImg');
                const existingFallback = document.getElementById('previewFallback');

                if (existingImg) {
                    // Update existing image
                    existingImg.src = e.target.result;
                } else if (existingFallback) {
                    // Replace fallback with image
                    const newImg = document.createElement('img');
                    newImg.id = 'previewImg';
                    newImg.src = e.target.result;
                    newImg.alt = 'Preview';
                    newImg.className = 'img-fluid rounded';
                    newImg.style.maxHeight = '200px';

                    imagePreview.removeChild(existingFallback);
                    imagePreview.appendChild(newImg);
                } else {
                    // Create new image
                    const newImg = document.createElement('img');
                    newImg.id = 'previewImg';
                    newImg.src = e.target.result;
                    newImg.alt = 'Preview';
                    newImg.className = 'img-fluid rounded';
                    newImg.style.maxHeight = '200px';

                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(newImg);
                }

                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    /* ===============================
       SweetAlert Delete Confirmation
    ================================ */
    function confirmDelete(slug) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This category will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Use the separate delete page instead of inline deletion
                window.location.href = 'delete-donation-category.php?slug=' + encodeURIComponent(slug);
            }
        });
    }

    /* ===============================
       SweetAlert for Success/Error Messages
    ================================ */
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($success_message)): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= addslashes($success_message) ?>',
                icon: 'success',
                confirmButtonColor: '#10b981',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= addslashes($error_message) ?>',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    });
</script>

<?php require './components/footer.php'; ?>