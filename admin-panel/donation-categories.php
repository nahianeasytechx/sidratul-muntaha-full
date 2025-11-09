<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Donation Categories'; 

// Dummy data
$categories = [
    [
        'id' => 1,
        'title' => 'Education Support',
        'image' => 'https://via.placeholder.com/400x300/4CAF50/ffffff?text=Education',
        'description' => 'Help provide quality education to underprivileged children. Your donation will help buy books, stationery, and educational materials.',
        'created_at' => '2024-01-15'
    ],
    [
        'id' => 2,
        'title' => 'Medical Emergency',
        'image' => 'https://via.placeholder.com/400x300/FF5722/ffffff?text=Medical',
        'description' => 'Support medical treatments for those who cannot afford healthcare. Every contribution saves lives and brings hope.',
        'created_at' => '2024-02-20'
    ],
    [
        'id' => 3,
        'title' => 'Food Distribution',
        'image' => 'https://via.placeholder.com/400x300/FF9800/ffffff?text=Food',
        'description' => 'Fight hunger by providing nutritious meals to families in need. Join us in making sure no one goes to bed hungry.',
        'created_at' => '2024-03-10'
    ],
    [
        'id' => 4,
        'title' => 'Clean Water Projects',
        'image' => 'https://via.placeholder.com/400x300/2196F3/ffffff?text=Water',
        'description' => 'Bring clean drinking water to communities lacking access. Help us build wells and water purification systems.',
        'created_at' => '2024-03-25'
    ],
    [
        'id' => 5,
        'title' => 'Orphan Care',
        'image' => 'https://via.placeholder.com/400x300/9C27B0/ffffff?text=Orphan+Care',
        'description' => 'Provide shelter, education, and care for orphaned children. Give them a chance at a brighter future.',
        'created_at' => '2024-04-05'
    ],
    [
        'id' => 6,
        'title' => 'Disaster Relief',
        'image' => 'https://via.placeholder.com/400x300/F44336/ffffff?text=Disaster+Relief',
        'description' => 'Support communities affected by natural disasters. Help provide emergency supplies, shelter, and rebuilding efforts.',
        'created_at' => '2024-04-18'
    ]
];

$message = '';
$message_type = '';
$edit_category = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $message = 'Category added successfully! (Demo Mode)';
        $message_type = 'success';
    } elseif (isset($_POST['update_category'])) {
        $message = 'Category updated successfully! (Demo Mode)';
        $message_type = 'success';
    }
}

if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    foreach ($categories as $cat) {
        if ($cat['id'] == $edit_id) {
            $edit_category = $cat;
            break;
        }
    }
}

if (isset($_GET['delete'])) {
    $message = 'Category deleted successfully! (Demo Mode)';
    $message_type = 'success';
}
?>
<?php require './components/header.php'; ?>

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
 .btn {
    width: 100%;
    padding: 15px;
    margin-bottom: 10px;
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
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <?php echo $message; ?>
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

                        <form action="" method="post" enctype="multipart/form-data">
                            <?php if ($edit_category): ?>
                                <input type="hidden" name="category_id" value="<?php echo $edit_category['id']; ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="title" class="form-label">Category Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="Enter category title"
                                       value="<?php echo $edit_category ? htmlspecialchars($edit_category['title']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                       <?php echo $edit_category ? '' : 'required'; ?>>
                                <small class="text-muted">JPG, PNG, WEBP (max 2MB)</small>
                                <?php if ($edit_category && $edit_category['image']): ?>
                                <div class="mt-3">
                                    <img src="<?php echo $edit_category['image']; ?>" class="img-thumbnail" style="max-width: 140px;">
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control"
                                          placeholder="Write a short description..." required><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" name="<?php echo $edit_category ? 'update_category' : 'add_category'; ?>" 
                                        class="btn btn-success flex-grow-1">
                                    <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                                </button>
                                <?php if ($edit_category): ?>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary h-25">Cancel</a>
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
                        <h3 class="mb-4">All Categories</h3>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Created</th>
                                        <th colspan="3" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $index => $category): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td>
                                            <img src="<?php echo $category['image']; ?>" alt="" class="rounded" width="55" height="55" style="object-fit:cover;">
                                        </td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($category['title']); ?></td>
                                        <td><small class="text-muted"><?php echo date('M d, Y', strtotime($category['created_at'])); ?></small></td>
                                        <td class="text-center">
                                            <button class="p-2  btn-outline-primary" data-bs-toggle="modal" data-bs-target="#descModal<?php echo $category['id']; ?>" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="?edit=<?php echo $category['id']; ?>" class="p-2 btn-outline-info" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="?delete=<?php echo $category['id']; ?>" class="p-2 btn-outline-danger" title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
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
                                                    <img src="<?php echo $category['image']; ?>" class="img-fluid rounded mb-3" alt="">
                                                    <p><?php echo htmlspecialchars($category['description']); ?></p>
                                                    <div class="text-muted mt-3">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require './components/footer.php'; ?>