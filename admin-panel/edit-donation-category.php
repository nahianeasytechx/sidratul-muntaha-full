<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Edit Donation Category';

require_once './components/header.php';

protectPage();


// Get slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
  echo"<script>window.location.href='donation-categories.php'</script>";
    exit;
}

// Get category by slug
$category = getDonationCategoryBySlug($slug);

if (!$category) {
    $_SESSION['error_message'] = 'Category not found!';
  echo"<script>window.location.href='donation-categories.php'</script>";
    exit;
}

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $data = [
        'title' => trim($_POST['title']),
        'description' => trim($_POST['description'])
    ];
    
    // Handle file upload
    $file = isset($_FILES['image']) ? $_FILES : null;
    
    // Update category with slug handling
    $result = updateDonationCategoryWithSlug($category['id'], $data, $file);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        // Redirect to new slug if it changed
echo "<script>
        window.location.href = 'donation-category-edit.php?slug=" . $result['slug'] . "';
      </script>";
exit;

    } else {
        $message = $result['message'];
        $message_type = 'danger';
    }
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $result = deleteDonationCategory($category['id']);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
  echo"<script>window.location.href='donation-categories.php'</script>";
        exit;
    } else {
        $message = $result['message'];
        $message_type = 'danger';
    }
}
?>
<?php require './components/header.php'; ?>

<link rel="stylesheet" href="./assets/css/donation-category-edit.css">

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div class="d-flex gap-3">
                <div>
                    <h1><i class="fa-solid fa-pen-to-square me-2"></i>Edit Donation Category</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="donation-categories.php">Categories</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="donation-categories.php" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        
        <!-- Session Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Current Page Alert -->
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-<?php echo $message_type === 'success' ? 'check' : 'exclamation'; ?> me-2"></i>
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            
            <!-- Category Information Card -->
            <div class="col-lg-4 mb-4">
                <div class="card info-card">
                    <div class="card-body">
                        <h3><i class="fa-solid fa-info-circle me-2"></i>Category Information</h3>
                        
                        <div class="info-item">
                            <div class="info-label">Category ID</div>
                            <div class="info-value">#<?php echo str_pad($category['id'], 4, '0', STR_PAD_LEFT); ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Slug</div>
                            <div class="info-value slug-display">
                                <code><?php echo htmlspecialchars($category['slug']); ?></code>
                                <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" 
                                        onclick="copySlug('<?php echo htmlspecialchars($category['slug']); ?>')">
                                    <i class="fa-solid fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge bg-<?php echo $category['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($category['status']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Display Order</div>
                            <div class="info-value">#<?php echo $category['display_order']; ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Created Date</div>
                            <div class="info-value">
                                <?php echo date('M d, Y', strtotime($category['created_at'])); ?>
                            </div>
                        </div>

                        <div class="info-item mb-0">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">
                                <?php echo date('M d, Y h:i A', strtotime($category['updated_at'])); ?>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="donation-category-view.php?slug=<?php echo urlencode($category['slug']); ?>" 
                               class="btn btn-info btn-sm flex-grow-1">
                                <i class="fa-solid fa-eye me-2"></i>View Details
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Current Image Card -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3><i class="fa-solid fa-image me-2"></i>Current Image</h3>
                        <?php if (!empty($category['image'])): ?>
                        <div class="current-image-preview">
                            <img src="<?php echo htmlspecialchars($category['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($category['title']); ?>"
                                 class="img-fluid rounded">
                        </div>
                        <?php else: ?>
                        <div class="no-image text-center py-4">
                            <i class="fa-solid fa-image-slash fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No image available</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fa-solid fa-edit me-2"></i>Edit Category Details</h3>

                        <form action="" method="post" enctype="multipart/form-data" id="editCategoryForm">
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title" class="form-label">
                                        Category Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title" 
                                           class="form-control"
                                           placeholder="Enter category title"
                                           value="<?php echo htmlspecialchars($category['title']); ?>" 
                                           required>
                                    <small class="text-muted">
                                        <i class="fa-solid fa-info-circle me-1"></i>
                                        Slug will be auto-generated from title if changed
                                    </small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="image" class="form-label">
                                        Category Image
                                    </label>
                                    <input type="file" 
                                           name="image" 
                                           id="image" 
                                           class="form-control" 
                                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                           onchange="previewImage(event)">
                                    <small class="text-muted">
                                        <i class="fa-solid fa-info-circle me-1"></i>
                                        Accepted formats: JPG, PNG, GIF, WEBP (Max: 5MB). Leave empty to keep current image.
                                    </small>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <label class="form-label">New Image Preview:</label>
                                        <img id="preview" src="" class="img-thumbnail" style="max-width: 300px;">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">
                                        Description <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="6" 
                                              class="form-control"
                                              placeholder="Write a detailed description about this donation category..."
                                              required><?php echo htmlspecialchars($category['description']); ?></textarea>
                                    <small class="text-muted">
                                        <i class="fa-solid fa-info-circle me-1"></i>
                                        Provide clear information about what this category supports
                                    </small>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="donation-categories.php" class="btn btn-secondary">
                                    <i class="fa-solid fa-times me-2"></i>Cancel
                                </a>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fa-solid fa-rotate-left me-2"></i>Reset
                                </button>
                                <button type="submit" name="update_category" class="btn btn-success">
                                    <i class="fa-solid fa-save me-2"></i>Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="fa-solid fa-trash-can fa-4x text-danger mb-3"></i>
                    <h5>Are you sure you want to delete this category?</h5>
                    <p class="text-muted mb-0">
                        Category: <strong><?php echo htmlspecialchars($category['title']); ?></strong>
                    </p>
                    <p class="text-danger mt-2">
                        <i class="fa-solid fa-warning me-1"></i>
                        This action cannot be undone!
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-2"></i>Cancel
                </button>
                <a href="?slug=<?php echo urlencode($category['slug']); ?>&action=delete" 
                   class="btn btn-danger">
                    <i class="fa-solid fa-trash me-2"></i>Yes, Delete It
                </a>
            </div>
        </div>
    </div>
</div>

<?php require './components/footer.php'; ?>

<script>
// Copy slug to clipboard
function copySlug(slug) {
    navigator.clipboard.writeText(slug).then(function() {
        // Show temporary success message
        const btn = event.target.closest('.copy-btn');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-secondary');
        
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

// Preview image before upload
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Form validation
document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    
    if (title === '' || description === '') {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }
    
    return true;
});
</script>

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

    /* Button Styles - Matching donation-list.php */
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
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

    .table-responsive {
        border-radius: 16px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .table thead th {
        color: white;
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
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #475569;
    }

    .table tbody td strong {
        color: #2c3e50;
    }

    .table tbody td.fw-semibold {
        color: #2c3e50;
        font-weight: 700;
    }

    .table img {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .table img:hover {
        transform: scale(1.1);
    }

    /* Action Buttons - Matching donation-list.php */
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
        color: white;
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
        color: white;
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
        color: white;
    }

    /* Image Thumbnail */
    .img-thumbnail {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        .btn-success,
        .btn-secondary {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
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