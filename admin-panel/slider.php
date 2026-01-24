<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Slider Management';
require './components/header.php';
protectPage();

// Handle delete slider
if (isset($_GET['delete_id'])) {
    $id = (int) $_GET['delete_id'];

    if ($id > 0) {
        $result = deleteSlider($id);

        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
    }

    echo "<script>window.location.href = 'slider.php';</script>";
    exit;
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

// Handle form submissions
if (isset($_POST['add_slider'])) {
    $result = createSlider($_POST, $_FILES);
    if ($result['success']) {
        $success_message = $result['message'];
    } else {
        $error_message = $result['message'];
    }
}

if (isset($_POST['update_slider'])) {
    $id = intval($_POST['slider_id']);
    $result = updateSlider($id, $_POST, $_FILES);
    if ($result['success']) {
        $success_message = $result['message'];
    } else {
        $error_message = $result['message'];
    }
}

// Get all sliders and activities
$sliders = getAllSliders();
$activities = getAllActivitiesForDropdown();

// Get slider for editing
$edit_slider = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_slider = getSliderById($edit_id);
}
?>

<style>
    /* Previous styles remain the same... */
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

    /* Project Select Searchable Dropdown */
    .project-select-wrapper {
        position: relative;
    }

    .project-search-input {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        cursor: pointer;
    }

    .project-search-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
    }

    .project-dropdown-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
        transition: transform 0.3s ease;
    }

    .project-select-wrapper.active .project-dropdown-icon {
        transform: translateY(-50%) rotate(180deg);
    }

    .project-dropdown {
        position: absolute;
        top: calc(100% + 0.5rem);
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #10b981;
        border-radius: 12px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .project-select-wrapper.active .project-dropdown {
        display: block;
    }

    .project-option {
        padding: 0.875rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .project-option:last-child {
        border-bottom: none;
    }

    .project-option:hover {
        background: #f0fdf4;
    }

    .project-option.selected {
        background: #dcfce7;
        font-weight: 600;
        color: #059669;
    }

    .project-option-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .project-option-type {
        font-size: 0.8rem;
        color: #64748b;
    }

    .no-results {
        padding: 1.5rem;
        text-align: center;
        color: #94a3b8;
    }

    .clear-selection {
        position: absolute;
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
        padding: 0;
        transition: all 0.2s ease;
    }

    .clear-selection:hover {
        background: #dc2626;
        transform: translateY(-50%) scale(1.1);
    }

    .project-select-wrapper.has-selection .clear-selection {
        display: flex;
    }

    /* Existing styles continue... */
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

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }

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

    #charCount {
        font-weight: 600;
        color: #10b981;
    }

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

<div class="content-wrapper">
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

                                    <?php if (!empty($slider['project_slug'])): ?>
                                        <div class="mb-2">
                                            <span class="badge bg-info">
                                                <i class="fa-solid fa-link me-1"></i>
                                                Linked Project: <?= htmlspecialchars($slider['project_title'] ?? 'Unknown') ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

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
            <!-- Debug Info (remove this after testing) -->
            <?php if (isset($_GET['debug'])): ?>
                <div class="alert alert-warning mb-3">
                    <strong>Debug Info:</strong><br>
                    Total Activities: <?= count($activities) ?><br>
                    <?php foreach ($activities as $act): ?>
                        - <?= htmlspecialchars($act['title']) ?> (<?= htmlspecialchars($act['slug']) ?>)<br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="POST" enctype="multipart/form-data" id="sliderForm">
                <h2 class="section-header">
                    <i class="fa-solid fa-<?= $edit_slider ? 'edit' : 'plus-circle' ?>"></i>
                    <?= $edit_slider ? 'Edit Slider Image' : 'Add Slider Image' ?>
                </h2>

                <?php if ($edit_slider): ?>
                    <input type="hidden" name="slider_id" value="<?= $edit_slider['id'] ?>">
                    <!-- Debug: Show current project_slug -->
                    <?php if (!empty($edit_slider['project_slug'])): ?>
                        <div class="alert alert-info mb-3" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            <strong>Currently linked to:</strong> <?= htmlspecialchars($edit_slider['project_slug']) ?>
                        </div>
                    <?php endif; ?>
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

                    <!-- Linked Project Selection -->
                    <div class="mb-3">
                        <label for="project_slug" class="form-label">
                            <i class="fa-solid fa-diagram-project me-1"></i>
                            Link to Project (Optional)
                        </label>
                        <div class="project-select-wrapper" id="projectSelectWrapper">
                            <input
                                type="text"
                                class="form-control project-search-input"
                                id="projectSearchInput"
                                placeholder="Search and select a project..."
                                autocomplete="off">
                            <i class="fa-solid fa-chevron-down project-dropdown-icon"></i>
                            <button type="button" class="clear-selection" id="clearProjectSelection">
                                <i class="fa-solid fa-times"></i>
                            </button>
                            <input type="hidden" name="project_slug" id="projectSlugInput" value="<?= $edit_slider ? htmlspecialchars($edit_slider['project_slug'] ?? '') : '' ?>">
                            
                            <div class="project-dropdown" id="projectDropdown">
                                <div class="project-option" data-slug="" data-title="No Project Link">
                                    <div class="project-option-title">
                                        <i class="fa-solid fa-ban me-1"></i> No Project Link
                                    </div>
                                    <div class="project-option-type">Don't link to any project</div>
                                </div>
                                <?php if (empty($activities)): ?>
                                    <div class="no-results">
                                        <i class="fa-solid fa-info-circle me-2"></i>
                                        No published projects available
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($activities as $activity): ?>
                                        <div class="project-option" 
                                             data-slug="<?= htmlspecialchars($activity['slug']) ?>" 
                                             data-title="<?= htmlspecialchars($activity['title']) ?>"
                                             data-type="<?= htmlspecialchars($activity['type']) ?>">
                                            <div class="project-option-title"><?= htmlspecialchars($activity['title']) ?></div>
                                            <div class="project-option-type">
                                                <i class="fa-solid fa-tag me-1"></i><?= ucfirst($activity['type']) ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="fa-solid fa-info-circle me-1"></i>
                            Optionally link this slider to a specific project page
                        </small>
                    </div>

                    <?php if ($edit_slider): ?>
                        <!-- Status -->
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Project Selection Functionality - CLEAN VERSION
class ProjectSelector {
    constructor() {
        this.wrapper = document.getElementById('projectSelectWrapper');
        this.searchInput = document.getElementById('projectSearchInput');
        this.dropdown = document.getElementById('projectDropdown');
        this.slugInput = document.getElementById('projectSlugInput');
        this.clearBtn = document.getElementById('clearProjectSelection');
        this.options = Array.from(this.dropdown.querySelectorAll('.project-option'));
        
        console.log('ProjectSelector initialized');
        console.log('Total options:', this.options.length);
        console.log('Current slug:', this.slugInput.value);
        
        this.init();
    }

    init() {
        // Initialize existing value first
        this.initializeExistingValue();
        
        // Toggle dropdown on click
        this.searchInput.addEventListener('click', (e) => {
            e.stopPropagation();
            this.openDropdown();
        });

        // Handle search/filter
        this.searchInput.addEventListener('input', () => {
            this.filterOptions();
        });

        // Option selection
        this.options.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.selectOption(option);
            });
        });

        // Clear selection
        this.clearBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.clearSelection();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.wrapper.contains(e.target)) {
                this.closeDropdown();
            }
        });
    }

    openDropdown() {
        this.wrapper.classList.add('active');
    }

    closeDropdown() {
        this.wrapper.classList.remove('active');
        this.searchInput.value = this.getCurrentDisplayText();
    }

    filterOptions() {
        const query = this.searchInput.value.toLowerCase().trim();
        let hasResults = false;

        this.options.forEach((option, index) => {
            // Always show "No Project Link" option
            if (index === 0) {
                option.style.display = '';
                hasResults = true;
                return;
            }

            const title = (option.dataset.title || '').toLowerCase();
            const type = (option.dataset.type || '').toLowerCase();
            const matches = title.includes(query) || type.includes(query);
            
            option.style.display = matches ? '' : 'none';
            if (matches) hasResults = true;
        });

        // Show/hide no results message
        const existingNoResults = this.dropdown.querySelector('.no-results-search');
        if (!hasResults && query) {
            if (!existingNoResults) {
                const noResults = document.createElement('div');
                noResults.className = 'no-results no-results-search';
                noResults.innerHTML = '<i class="fa-solid fa-search me-2"></i>No projects found matching "' + query + '"';
                this.dropdown.appendChild(noResults);
            }
        } else if (existingNoResults) {
            existingNoResults.remove();
        }
    }

    selectOption(option) {
        const slug = option.dataset.slug || '';
        const title = option.dataset.title || 'No Project Link';

        console.log('Selecting:', { slug, title });

        // Update hidden input
        this.slugInput.value = slug;
        console.log('Hidden input now:', this.slugInput.value);

        // Update visual state
        this.options.forEach(opt => opt.classList.remove('selected'));
        option.classList.add('selected');

        // Update display
        this.searchInput.value = title;
        this.searchInput.style.color = '';

        // Update wrapper state
        if (slug) {
            this.wrapper.classList.add('has-selection');
        } else {
            this.wrapper.classList.remove('has-selection');
        }

        // Close dropdown
        this.closeDropdown();
    }

    clearSelection() {
        console.log('Clearing selection');
        this.slugInput.value = '';
        this.searchInput.value = '';
        this.wrapper.classList.remove('has-selection');
        this.options.forEach(opt => opt.classList.remove('selected'));
        this.options[0].classList.add('selected');
    }

    getCurrentDisplayText() {
        const selectedOption = this.options.find(opt => 
            opt.dataset.slug === this.slugInput.value
        );
        return selectedOption?.dataset.title || '';
    }

    initializeExistingValue() {
        const currentSlug = this.slugInput.value.trim();
        
        console.log('Initializing with slug:', currentSlug);
        
        if (currentSlug) {
            const option = this.options.find(opt => {
                const optSlug = (opt.dataset.slug || '').trim();
                return optSlug === currentSlug;
            });
            
            if (option) {
                console.log('Found matching option:', option.dataset.title);
                option.classList.add('selected');
                this.searchInput.value = option.dataset.title || '';
                this.wrapper.classList.add('has-selection');
            } else {
                console.warn('No matching option found for slug:', currentSlug);
                this.searchInput.value = 'Linked to: ' + currentSlug;
                this.searchInput.style.color = '#f59e0b';
                this.wrapper.classList.add('has-selection');
            }
        } else {
            console.log('No slug, selecting "No Project Link"');
            this.options[0].classList.add('selected');
            this.searchInput.value = '';
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready, initializing ProjectSelector');
    const selector = new ProjectSelector();
    
    // Debug form submission
    const form = document.getElementById('sliderForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const slugValue = document.getElementById('projectSlugInput').value;
            console.log('Form submitting with project_slug:', slugValue);
            
            // Optional: Show confirmation
            if (slugValue) {
                console.log('Will link to project:', slugValue);
            } else {
                console.log('No project link selected');
            }
        });
    }
});

// Image Preview
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

// Character Counter
const description = document.getElementById('slider_description');
const charCount = document.getElementById('charCount');

if (description && charCount) {
    const updateCount = () => {
        const count = description.value.length;
        charCount.textContent = count;
        charCount.style.color = count > 200 ? '#ef4444' : '#10b981';
    };

    description.addEventListener('input', updateCount);
    updateCount();
}

  
</script>

<?php require './components/footer.php'; ?>