<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Slider Management';
require './components/header.php';
// Protect page - ensure user is logged in
protectPage();
// Handle delete slider
if (isset($_GET['delete_id'])) {
    $id = (int) $_GET['delete_id'];

    if ($id > 0) {
        $result = deleteSlider($id); // your function

        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
    }

    echo "<script>
        window.location.href = 'slider.php';
    </script>";
    exit;
}
// Get messages from session FIRST (before any processing)
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

// Handle form submissions
// Add Slider
if (isset($_POST['add_slider'])) {
    $result = createSlider($_POST, $_FILES);
    if ($result['success']) {
        $success_message = $result['message'];
    } else {
        $error_message = $result['message'];
    }
}

// Update Slider
if (isset($_POST['update_slider'])) {
    $id = intval($_POST['slider_id']);
    $result = updateSlider($id, $_POST, $_FILES);
    if ($result['success']) {
        $success_message = $result['message'];
    } else {
        $error_message = $result['message'];
    }
}


// Get all sliders
$sliders = getAllSliders();

// Get slider for editing
$edit_slider = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_slider = getSliderById($edit_id);
}
?>

<style>
    /* Page Header Styling */
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
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    /* Section Headers */
    .section-header {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header i {
        color: #10b981;
        font-size: 1.3rem;
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }

    /* Slider Item Card */
    .slider-item {
        background: #f8fafc;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .slider-item:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .slider-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #10b981, #059669);
    }

    .slider-item h4 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .slider-img {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .slider-img:hover {
        transform: scale(1.02);
    }

    .slider-info h5 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1rem;
    }

    .slider-info p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge.bg-secondary {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0) !important;
        color: #475569;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
        color: #065f46;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
        color: #92400e;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe) !important;
        color: #1e40af;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
        color: #065f46;
    }

    /* Form Styling */
    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Custom File Upload */
    .custum-file-upload {
        height: 200px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 20px;
        cursor: pointer;
        border: 2px dashed #10b981;
        background-color: #f0fdf4;
        padding: 1.5rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .custum-file-upload:hover {
        background-color: #dcfce7;
        border-color: #059669;
    }

    .custum-file-upload .icon svg {
        height: 60px;
        fill: #10b981;
    }

    .custum-file-upload .text span {
        font-weight: 600;
        color: #059669;
    }

    .custum-file-upload input {
        display: none;
    }

    #imagePreview {
        text-align: center;
        margin-top: 1rem;
    }

    #previewImg {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #0891b2, #0e7490);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #d97706, #b45309);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64748b, #475569);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #475569, #334155);
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    /* Character Counter */
    #charCount {
        font-weight: 600;
        color: #10b981;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f8fafc;
        border-radius: 16px;
        border: 2px dashed #e2e8f0;
    }

    .empty-state i {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #64748b;
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

        .section-header {
            font-size: 1.2rem;
        }

        .slider-item {
            padding: 1rem !important;
        }

        .card {
            padding: 1rem;
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

    .slider-item,
    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div class="d-flex gap-3">
                <div>
                    <h1><i class="fa-solid fa-image me-2"></i>Slider Management</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Slider Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <?= htmlspecialchars($success_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <?= htmlspecialchars($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Display Existing Slider Images -->
    <div class="row">
        <div class="col-lg-7 mb-4">
            <h2 class="section-header">
                <i class="fa-solid fa-images"></i>
                Existing Slider Images (<?= count($sliders) ?>)
            </h2>

            <div class="card">
                <div class="slider-images">
                    <?php if (empty($sliders)): ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-image"></i>
                            <h3>No Slider Images Yet</h3>
                            <p>Add your first slider image to get started</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($sliders as $slider): ?>
                            <div class="slider-item p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h4 class="mb-0">Slider #<?= $slider['id'] ?></h4>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-secondary">Order: <?= $slider['display_order'] ?></span>
                                        <span class="badge <?= $slider['status'] === 'active' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= ucfirst($slider['status']) ?>
                                        </span>
                                    </div>
                                </div>

                                <img src="<?= htmlspecialchars($slider['slider_img']) ?>"
                                    alt="<?= htmlspecialchars($slider['slider_title']) ?>"
                                    class="slider-img img-fluid mb-3"
                                    style="max-height: 300px; object-fit: cover; width: 100%;"
                                    onerror="this.src='../img/placeholder.jpg'">

                                <div class="slider-info mb-3">
                                    <h5 class="mb-2"><?= htmlspecialchars($slider['slider_title']) ?></h5>
                                    <p class="text-muted mb-2"><?= htmlspecialchars($slider['slider_description']) ?></p>

                                    <?php if (!empty($slider['link_text']) || !empty($slider['link_url'])): ?>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <?php if (!empty($slider['link_url'])): ?>
                                                <span class="badge bg-primary">
                                                    <i class="fa-solid fa-link me-1"></i>
                                                    <?= htmlspecialchars($slider['link_url']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!empty($slider['link_text'])): ?>
                                                <span class="badge bg-info">
                                                    <i class="fa-solid fa-hand-pointer me-1"></i>
                                                    "<?= htmlspecialchars($slider['link_text']) ?>"
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="?edit_id=<?= $slider['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-pen me-1"></i>Edit
                                    </a>
                                    <a href="toggle-slider.php?id=<?= $slider['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-toggle-<?= $slider['status'] === 'active' ? 'on' : 'off' ?> me-1"></i>
                                        <?= $slider['status'] === 'active' ? 'Deactivate' : 'Activate' ?>
                                    </a>
                                    <a href="slider.php?delete_id=<?= $slider['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this slider?');">
                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <!-- Add/Edit Slider Form -->
            <form action="" method="POST" enctype="multipart/form-data" id="sliderForm">
                <h2 class="section-header">
                    <i class="fa-solid fa-<?= $edit_slider ? 'edit' : 'plus-circle' ?>"></i>
                    <?= $edit_slider ? 'Edit Slider Image' : 'Add Slider Image' ?>
                </h2>

                <?php if ($edit_slider): ?>
                    <input type="hidden" name="slider_id" value="<?= $edit_slider['id'] ?>">
                <?php endif; ?>

                <div class="card">
                    <!-- Image Upload -->
                    <div class="mb-3 mx-auto">
                        <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                    <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                    <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="text">
                                <span>Click to upload image</span>
                            </div>
                            <input type="file" id="file" name="slider_img" <?= !$edit_slider ? 'required' : '' ?> accept="image/*">
                        </label>
                        <div id="imagePreview" class="mt-2" <?= $edit_slider ? '' : 'style="display: none;"' ?>>
                            <img id="previewImg"
                                src="<?= $edit_slider ? htmlspecialchars($edit_slider['slider_img']) : '' ?>"
                                alt="Preview"
                                class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="slider_title" class="form-label">
                            Slider Title <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="slider_title"
                            name="slider_title"
                            placeholder="Enter slider title"
                            value="<?= $edit_slider ? htmlspecialchars($edit_slider['slider_title']) : '' ?>"
                            required
                            maxlength="100">
                        <small class="text-muted">Maximum 100 characters</small>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="slider_description" class="form-label">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control"
                            id="slider_description"
                            name="slider_description"
                            rows="4"
                            placeholder="Enter slider description"
                            required
                            maxlength="250"><?= $edit_slider ? htmlspecialchars($edit_slider['slider_description']) : '' ?></textarea>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Maximum 250 characters</small>
                            <small class="text-muted">
                                <span id="charCount"><?= $edit_slider ? strlen($edit_slider['slider_description']) : 0 ?></span>/250
                            </small>
                        </div>
                    </div>

                    <!-- Link Text (Optional) -->
                    <!-- <div class="mb-3">
                        <label for="link_text" class="form-label">
                            Button Text (Optional)
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="link_text"
                            name="link_text"
                            placeholder="e.g., Learn More, Join Now"
                            value="<?= $edit_slider ? htmlspecialchars($edit_slider['link_text'] ?? '') : '' ?>"
                            maxlength="100">
                    </div> -->

                    <!-- Link URL (Optional) -->
                    <!-- <div class="mb-3">
                        <label for="link_url" class="form-label">
                            Link URL (Optional)
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="link_url"
                            name="link_url"
                            placeholder="e.g., programs.php, #contact"
                            value="<?= $edit_slider ? htmlspecialchars($edit_slider['link_url'] ?? '') : '' ?>"
                            maxlength="255">
                    </div> -->

                    <!-- Status -->
                    <?php if ($edit_slider): ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= $edit_slider['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $edit_slider['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <!-- Display Order -->
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input
                                type="number"
                                class="form-control"
                                id="display_order"
                                name="display_order"
                                value="<?= $edit_slider['display_order'] ?>"
                                min="1">
                        </div>
                    <?php endif; ?>

                    <div class="d-flex gap-2">
                        <input class="btn btn-submit flex-grow-1"
                            type="submit"
                            name="<?= $edit_slider ? 'update_slider' : 'add_slider' ?>"
                            value="<?= $edit_slider ? 'Update Slider' : 'Add Slider' ?>">

                        <?php if ($edit_slider): ?>
                            <a href="slider.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ===============================
   Image Preview
================================ */
    const fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    /* ===============================
       Character Counter
    ================================ */
    document.addEventListener('DOMContentLoaded', function() {
        const description = document.getElementById('slider_description');
        const charCount = document.getElementById('charCount');

        if (!description || !charCount) return;

        const updateCount = () => {
            const count = description.value.length;
            charCount.textContent = count;
            charCount.style.color = count > 200 ? '#ef4444' : '#10b981';
        };

        description.addEventListener('input', updateCount);
        updateCount(); // initialize

        /* ===============================
           SweetAlert for Success Messages
        ================================ */
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

    /* ===============================
       SweetAlert Delete Confirmation
    ================================ */
    /* ===============================
       SweetAlert Delete Confirmation
    ================================ */
    function confirmDelete(id) {
        document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete-slider');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.id;
            const title = this.dataset.title;
            const deleteUrl = `slider.php?delete_id=${id}`;

            Swal.fire({
                title: 'Are you sure?',
                html: `<div style="text-align:center;">
                          <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                          <p>You are about to delete the slider:</p>
                          <p><strong>"${title}"</strong></p>
                          <p class="text-danger">This action cannot be undone!</p>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                preConfirm: () => {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
});
    }

    /* ===============================
       Handle SweetAlert Messages on Page Load
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
                timerProgressBar: true,
                didOpen: () => {
                    // Remove Bootstrap alerts
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => alert.remove());
                }
            });
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= addslashes($error_message) ?>',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK',
                didOpen: () => {
                    // Remove Bootstrap alerts
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => alert.remove());
                }
            });
        <?php endif; ?>
    });
</script>




<?php require './components/footer.php'; ?>