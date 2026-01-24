<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Notice: ';
require './components/header.php';
protectPage();

// Get notice by slug only - NO ID FALLBACK
$notice = null;

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $slug = $_GET['slug'];
    $notice = getNoticeBySlug($slug);

    if (!$notice) {
        echo "<script>window.location.href='all-notice.php?error=" . urlencode('Notice not found') . "'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='all-notice.php?error=" . urlencode('Notice slug is required') . "'</script>";
    exit();
}

// Handle form submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = (int) $_POST['id'];

    $updateData = [
        'title'        => trim($_POST['title']),
        'description'  => trim($_POST['description']),
        'publish_date' => $_POST['publish_date'],
        'duration'     => (int)$_POST['duration'],
        'type'         => $_POST['type'],
        'category'     => $_POST['category'],
        'status'       => $_POST['status'],
        'age_limit'    => $_POST['age_limit'] ?? null
    ];

    $result = updateNoticeWithSlug($id, $updateData);

    if ($result['success']) {
        $redirectSlug = !empty($result['slug']) ? $result['slug'] : $notice['slug'];
        $redirectUrl = "view-notice.php?slug=" . urlencode($redirectSlug);

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: 'Notice updated successfully!<br><small class=\"text-muted\">Slug: " . htmlspecialchars($redirectSlug) . "</small>',
                confirmButtonColor: '#10b981',
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = '" . $redirectUrl . "';
                }
            });
        </script>";
        exit;
    } else {
        $error_message = $result['message'];
    }
}

// Calculate expiry date for display
$publish_date_obj = new DateTime($notice['publish_date']);
$expiry_date = clone $publish_date_obj;
$expiry_date->modify("+{$notice['duration']} months");
$current_date = new DateTime();
?>

<style>
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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

    .slug-info {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        color: white;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .slug-info code {
        background: rgba(255, 255, 255, 0.3);
        padding: 4px 8px;
        border-radius: 6px;
        color: white;
    }

    /* Cancel Button in Header */
    .btn-cancel-header {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #ffffff) !important;
        border-bottom: 2px solid #e9ecef;
        border-radius: 16px 16px 0 0 !important;
        padding: 1.25rem 1.5rem !important;
    }

    .card-header h5 {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header h5 i {
        color: #10b981;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
        outline: none;
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .form-text {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Alert Styling */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert i {
        margin-right: 0.5rem;
    }

    /* Status Card Special Styling */
    .card.border-primary {
        border: 2px solid #10b981 !important;
    }

    .card-header.bg-primary {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: white !important;
        border: none !important;
    }

    .card-header.bg-primary h6 {
        color: white !important;
        font-weight: 600;
    }

    /* Quick Tips List */
    .card-body ul {
        list-style: none;
        padding-left: 0;
    }

    .card-body ul li {
        position: relative;
        padding-left: 1.5rem;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .card-body ul li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 700;
    }

    /* Notice Details Card */
    .card-body .fw-bold {
        color: #1e293b;
        font-size: 1rem;
    }

    .card-body .form-label.text-muted {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b !important;
    }

    /* Button Styling */
    .btn {
        border-radius: 10px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    .btn-outline-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e9ecef;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-2px);
    }

    .btn-outline-danger {
        background: white;
        color: #ef4444;
        border: 2px solid #fee2e2;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #ef4444;
        color: #dc2626;
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }
    }

    @media (max-width: 767px) {
        .page-header h1 {
            font-size: 1.3rem;
        }

        .card-header h5 {
            font-size: 1rem;
        }

        .btn {
            padding: 0.6rem 1rem;
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

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Character Counter */
    .char-counter {
        position: absolute;
        right: 12px;
        bottom: 12px;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
    }

    .text-area-wrapper {
        position: relative;
    }

    /* Message Box */
    .message-box {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: fadeIn 0.3s ease;
    }

    .message-box.success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .message-box.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="content-wrapper">
    <div class="edit-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-pen-to-square me-2"></i>Edit Notice</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-notice.php" class="text-decoration-none">All Notices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Notice</li>
                            </ol>
                        </nav>
                        <div class="slug-info">
                            <i class="fa-solid fa-link me-1"></i>
                            Current slug: <code><?= htmlspecialchars($notice['slug']) ?></code>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="all-notice.php" class="btn btn-cancel-header">
                        <i class="fa-solid fa-xmark me-1"></i> Cancel
                    </a>
                </div>
            </div>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <?= $success_message ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <!-- Edit Form -->
        <form method="POST" action="" id="noticeForm">
            <input type="hidden" name="id" value="<?= $notice['id'] ?>">

            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-circle-info"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="noticeTitle" class="form-label">Notice Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="noticeTitle" name="title"
                                    value="<?= htmlspecialchars($notice['title']) ?>" required>
                                <small class="text-muted">Changing the title will update the URL slug</small>
                            </div>

                            <div class="mb-3 text-area-wrapper">
                                <label for="noticeDescription" class="form-label">Notice Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="noticeDescription" name="description" rows="10" required><?= htmlspecialchars($notice['description']) ?></textarea>
                                <span class="char-counter" id="charCounter"><?= strlen($notice['description']) ?> / 2000</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="noticeType" class="form-label">Notice Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="noticeType" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="General" <?= $notice['type'] === 'General' ? 'selected' : '' ?>>General</option>
                                        <option value="Urgent" <?= $notice['type'] === 'Urgent' ? 'selected' : '' ?>>Urgent</option>
                                        <option value="Info" <?= $notice['type'] === 'Info' ? 'selected' : '' ?>>Information</option>
                                        <option value="Announcement" <?= $notice['type'] === 'Announcement' ? 'selected' : '' ?>>Announcement</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="noticeCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="noticeCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Education" <?= $notice['category'] === 'Education' ? 'selected' : '' ?>>Education</option>
                                        <option value="Scholarship" <?= $notice['category'] === 'Scholarship' ? 'selected' : '' ?>>Scholarship</option>
                                        <option value="Health" <?= $notice['category'] === 'Health' ? 'selected' : '' ?>>Health</option>
                                        <option value="Events" <?= $notice['category'] === 'Events' ? 'selected' : '' ?>>Events</option>
                                        <option value="General" <?= $notice['category'] === 'General' ? 'selected' : '' ?>>General</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Duration Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-calendar-days"></i>Date & Duration
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="publishDate" class="form-label">Publish Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="publishDate" name="publish_date"
                                        value="<?= $notice['publish_date'] ?>" required>
                                    <div class="form-text">Date when notice becomes visible</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="duration" class="form-label">Duration (Months) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration" name="duration"
                                        value="<?= $notice['duration'] ?>" min="1" max="36" required>
                                    <div class="form-text">How long the notice will remain active (1-36 months)</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="ageLimit" class="form-label">Age Limit (Optional)</label>
                                    <input type="number" class="form-control" id="ageLimit" name="age_limit"
                                        value="<?= $notice['age_limit'] ?>" min="0" max="100">
                                    <div class="form-text">Minimum age requirement (leave empty for no restriction)</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="expiryDate" class="form-label">Calculated Expiry Date</label>
                                    <input type="text" class="form-control" id="expiryDate"
                                        value="<?= $expiry_date->format('F d, Y') ?>" readonly style="background-color: #f8f9fa;">
                                    <div class="form-text">Auto-calculated based on publish date + duration</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-info-circle"></i>Additional Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fa-solid fa-circle-info"></i>
                                <strong>Current Status:</strong>
                                <span class="badge <?=
                                                    $notice['status'] === 'Active' ? 'bg-success' : ($notice['status'] === 'Draft' ? 'bg-warning text-dark' : 'bg-danger')
                                                    ?> ms-2">
                                    <?= $notice['status'] ?>
                                </span>
                                <?php
                                if ($notice['status'] === 'Active' && $current_date > $expiry_date):
                                ?>
                                    <span class="badge bg-danger ms-2">
                                        <i class="fa-solid fa-clock me-1"></i> Auto-Expired
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Notice ID</label>
                                        <div class="fw-bold">#<?= str_pad($notice['id'], 4, '0', STR_PAD_LEFT) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Created On</label>
                                        <div><?= date('F d, Y', strtotime($notice['created_at'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Status Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-toggle-on"></i>Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="noticeStatus" class="form-label">Notice Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="noticeStatus" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active" <?= $notice['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Draft" <?= $notice['status'] === 'Draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="Expired" <?= $notice['status'] === 'Expired' ? 'selected' : '' ?>>Expired</option>
                                </select>
                            </div>

                            <div class="alert alert-info mb-0">
                                <i class="fa-solid fa-circle-info"></i>
                                <small>
                                    <?php if ($notice['status'] === 'Active' && $current_date > $expiry_date): ?>
                                        This notice has auto-expired. You can change status to "Active" to renew it with new dates.
                                    <?php else: ?>
                                        Setting status to "Active" will publish this notice immediately.
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips Card -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary py-3">
                            <h6 class="mb-0">
                                <i class="fa-solid fa-lightbulb me-2"></i>Quick Tips
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="mb-0 small">
                                <li class="mb-2">Use clear and concise titles</li>
                                <li class="mb-2">Provide detailed descriptions</li>
                                <li class="mb-2">Set appropriate durations (1-36 months)</li>
                                <li class="mb-2">Choose correct notice type</li>
                                <li class="mb-0">Update status before saving</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body p-3">
                            <button type="submit" name="update" class="btn btn-primary w-100 mb-2">
                                <i class="fa-solid fa-floppy-disk"></i> Update Notice
                            </button>
                            <button type="submit" name="save_draft" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="fa-solid fa-file-pen"></i> Save as Draft
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete-notice d-inline-flex align-items-center justify-content-center p-0"
                                style="height: 32px; width: 32px; min-width: 32px;"
                                title="Delete"
                                data-slug="<?= htmlspecialchars($notice['slug']) ?>"
                                data-title="<?= htmlspecialchars($notice['title']) ?>">
                                <i class="fa-solid fa-trash"></i> Delete Notice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // Character counter for description
    const descField = document.getElementById('noticeDescription');
    const charCounter = document.getElementById('charCounter');

    // Initialize counter
    charCounter.textContent = `${descField.value.length} / 2000`;

    descField.addEventListener('input', function() {
        const length = this.value.length;
        charCounter.textContent = `${length} / 2000`;

        if (length > 2000) {
            charCounter.style.color = '#ef4444';
        } else if (length > 1800) {
            charCounter.style.color = '#f59e0b';
        } else {
            charCounter.style.color = '#94a3b8';
        }
    });

    // Update expiry date when publish date or duration changes
    const publishDateInput = document.getElementById('publishDate');
    const durationInput = document.getElementById('duration');
    const expiryDateInput = document.getElementById('expiryDate');

    function updateExpiryDate() {
        const publishDate = new Date(publishDateInput.value);
        const duration = parseInt(durationInput.value) || 1;

        if (publishDate && !isNaN(publishDate.getTime())) {
            const expiryDate = new Date(publishDate);
            expiryDate.setMonth(expiryDate.getMonth() + duration);

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            expiryDateInput.value = expiryDate.toLocaleDateString('en-US', options);
        }
    }

    publishDateInput.addEventListener('change', updateExpiryDate);
    durationInput.addEventListener('input', updateExpiryDate);

    // Set minimum date to today for publish date
    const today = new Date().toISOString().split('T')[0];
    publishDateInput.setAttribute('min', today);

    // Delete notice function with slug
    function deleteNotice(slug) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#10b981',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `delete-notice.php?slug=${encodeURIComponent(slug)}&from=edit`;
            }
        });
    }

    // Form submission with confirmation
    document.getElementById('noticeForm').addEventListener('submit', function(e) {
        const form = this;
        const submitButton = e.submitter;

        if (!form.checkValidity()) {
            return;
        }

        e.preventDefault();

        const actionText = submitButton.name === 'save_draft' ? 'save as draft' : 'update';

        Swal.fire({
            title: 'Update Notice?',
            text: `Are you sure you want to ${actionText}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Updating...';
                form.submit();
            }
        });
    });
</script>

<?php require './components/footer.php'; ?>