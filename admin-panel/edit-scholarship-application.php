<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Scholarship Application';
require './components/header.php';

// Get application ID from URL
$application_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch application from database
$application = getScholarshipApplicationById($application_id);

// If application not found, redirect
if (!$application) {
    $_SESSION['error_message'] = 'Application not found.';
    echo "<script>window.location='scholarship-application-list.php'</script>";
    exit;
}

// Handle document deletion
if (isset($_POST['delete_document'])) {
    $doc_id = intval($_POST['document_id']);
    $result = deleteScholarshipDocument($doc_id);
    
    if ($result['success']) {
        $_SESSION['success_message'] = 'Document deleted successfully.';
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
    
    echo "<script>window.location='edit-scholarship-application.php?id=" . $application_id . "'</script>";
    exit;
}

// Handle new document upload
if (isset($_POST['upload_documents']) && isset($_FILES['new_documents'])) {
    $uploadResult = handleScholarshipDocumentsUpload($_FILES['new_documents'], $application_id);
    
    if ($uploadResult['success'] && !empty($uploadResult['uploaded'])) {
        $docSaved = saveScholarshipDocuments($application_id, $uploadResult['uploaded']);
        
        if ($docSaved) {
            $_SESSION['success_message'] = $uploadResult['count'] . ' document(s) uploaded successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to save documents to database.';
        }
    } elseif (!empty($uploadResult['errors'])) {
        $_SESSION['error_message'] = 'Upload errors: ' . implode(', ', $uploadResult['errors']);
    }
    
    echo "<script>window.location='edit-scholarship-application.php?id=" . $application_id . "'</script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $result = updateScholarshipApplication($application_id, $_POST);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        echo "<script>window.location='scholarship-application-list.php'</script>";
        exit;
    } else {
        $_SESSION['error_message'] = $result['message'];
    }
}

// Display messages if any
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<style>
    /* Previous styles remain the same... */
    .page-title-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-title-section .icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
    }

    .page-title-section h1 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .page-title-section .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 8px 0 0 0;
        font-size: 14px;
    }

    .btn-back {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(100, 116, 139, 0.4);
        color: white;
    }

    .form-card {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .form-card-header i {
        font-size: 20px;
        color: #10b981;
    }

    .form-card-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .form-section {
        margin-bottom: 32px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-header i {
        font-size: 18px;
        color: #10b981;
    }

    .section-header h6 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        color: white;
    }

    .btn-reset {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* Documents Section Styles */
    .documents-section {
        background: #f8fafc;
        padding: 24px;
        border-radius: 16px;
        border: 2px dashed #cbd5e1;
    }

    .document-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .document-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #10b981;
        transform: translateY(-2px);
    }

    .document-info {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }

    .document-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 24px;
        flex-shrink: 0;
    }

    .document-icon.pdf { 
        color: #dc2626; 
        background: linear-gradient(135deg, #fee2e2, #fecaca);
    }
    .document-icon.doc { 
        color: #2563eb; 
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    }
    .document-icon.img { 
        color: #059669; 
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    }

    .document-details h6 {
        margin: 0 0 4px 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }

    .document-details small {
        color: #6b7280;
        font-size: 13px;
    }

    .document-actions {
        display: flex;
        gap: 8px;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-download {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        color: white;
    }

    .upload-area {
        border: 3px dashed #cbd5e1;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        background: white;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #8b5cf6;
        background: #f8fafc;
    }

    .upload-area i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .upload-area:hover i {
        color: #8b5cf6;
    }

    .btn-upload {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        margin-top: 16px;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        border: none;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .document-card {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .document-actions {
            width: 100%;
        }

        .document-actions button,
        .document-actions a {
            flex: 1;
        }
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="scholarship-application">

            <!-- Page Title -->
            <div class="page-title-section">
                <div class="page-title-content">
                    <div class="icon-box">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h1>Edit Scholarship Application</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="scholarship-application-list.php">Applications</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn-back" href="scholarship-application-list.php">
                    <i class="fa-solid fa-arrow-left"></i> Back to List
                </a>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- Edit Form -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <h5>Edit Application Details - ID: <?= $application['id'] ?></h5>
                </div>

                <form id="editApplicationForm" method="POST" action="">
                    <input type="hidden" name="application_id" value="<?= $application['id'] ?>">

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fa-solid fa-user"></i>
                            <h6>Personal Information</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($application['name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($application['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($application['phone']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="youraddress" name="youraddress" value="<?= htmlspecialchars($application['address']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h6>Academic Information</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="instituename" name="instituename" value="<?= htmlspecialchars($application['institute_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Institution Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="institution_type" name="institution_type" required>
                                    <option value="">Select Type</option>
                                    <option value="hifz" <?= $application['institution_type'] === 'hifz' ? 'selected' : '' ?>>Hifz</option>
                                    <option value="program" <?= $application['institution_type'] === 'program' ? 'selected' : '' ?>>Program</option>
                                    <option value="school" <?= $application['institution_type'] === 'school' ? 'selected' : '' ?>>School</option>
                                    <option value="college" <?= $application['institution_type'] === 'college' ? 'selected' : '' ?>>College</option>
                                    <option value="university" <?= $application['institution_type'] === 'university' ? 'selected' : '' ?>>University</option>
                                    <option value="madrasha-program" <?= $application['institution_type'] === 'madrasha-program' ? 'selected' : '' ?>>Madrasha</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex gap-3 justify-content-end mt-4 pt-4 border-top">
                        <a href="scholarship-application-list.php" class="btn-cancel">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </a>
                        <button type="reset" class="btn-reset">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Documents Section -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fa-solid fa-file-pdf"></i>
                    <h5>Submitted Documents (<?= count($application['documents']) ?>)</h5>
                </div>

                <?php if (empty($application['documents'])): ?>
                    <div class="empty-state">
                        <i class="fa-solid fa-folder-open"></i>
                        <h5>No Documents Uploaded</h5>
                        <p>Upload documents using the form below</p>
                    </div>
                <?php else: ?>
                    <div class="documents-section">
                        <?php foreach ($application['documents'] as $document): ?>
                            <?php
                            $iconClass = 'fa-file-lines';
                            $iconType = 'doc';
                            
                            if ($document['document_type'] === 'pdf') {
                                $iconClass = 'fa-file-pdf';
                                $iconType = 'pdf';
                            } elseif (in_array($document['document_type'], ['jpg', 'jpeg', 'png'])) {
                                $iconClass = 'fa-file-image';
                                $iconType = 'img';
                            }
                            
                            $fileSize = $document['file_size'];
                            if ($fileSize < 1024) {
                                $sizeText = $fileSize . ' B';
                            } elseif ($fileSize < 1024 * 1024) {
                                $sizeText = round($fileSize / 1024, 2) . ' KB';
                            } else {
                                $sizeText = round($fileSize / (1024 * 1024), 2) . ' MB';
                            }
                            ?>
                            
                            <div class="document-card">
                                <div class="document-info">
                                    <div class="document-icon <?= $iconType ?>">
                                        <i class="fa-solid <?= $iconClass ?>"></i>
                                    </div>
                                    <div class="document-details">
                                        <h6><?= htmlspecialchars($document['document_original_name']) ?></h6>
                                        <small>
                                            <i class="fa-solid fa-weight-scale me-1"></i><?= $sizeText ?> • 
                                            <i class="fa-solid fa-calendar me-1"></i><?= date('M j, Y', strtotime($document['uploaded_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="document-actions">
                                    <a href="download-document.php?id=<?= $document['id'] ?>" 
                                       class="btn-download">
                                        <i class="fa-solid fa-download"></i> Download
                                    </a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                        <input type="hidden" name="document_id" value="<?= $document['id'] ?>">
                                        <button type="submit" name="delete_document" class="btn-delete">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Upload New Documents -->
                <form method="POST" enctype="multipart/form-data" class="mt-4">
                    <div class="section-header">
                        <i class="fa-solid fa-upload"></i>
                        <h6>Upload Additional Documents</h6>
                    </div>
                    
                    <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h5>Click to upload or drag and drop</h5>
                        <p class="text-muted mb-0">PDF, DOC, DOCX, JPG, PNG (Max 5MB per file)</p>
                    </div>
                    
                    <input type="file" 
                           id="fileInput" 
                           name="new_documents[]" 
                           multiple 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           style="display: none;"
                           onchange="showSelectedFiles(this)">
                    
                    <div id="selectedFiles" class="mt-3"></div>
                    
                    <div class="text-center">
                        <button type="submit" name="upload_documents" class="btn-upload">
                            <i class="fa-solid fa-upload me-2"></i> Upload Documents
                        </button>
                    </div>
                </form>
            </div>

            <!-- Application Info Card -->
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fa-solid fa-info-circle"></i>
                    <h5>Application Information</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Application ID:</strong> #<?= $application['id'] ?></p>
                        <p><strong>Submitted Date:</strong> <?= date('F d, Y', strtotime($application['created_at'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Last Modified:</strong> <?= date('F d, Y g:i A', strtotime($application['created_at'])) ?></p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-warning text-dark">Pending Review</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showSelectedFiles(input) {
    const container = document.getElementById('selectedFiles');
    container.innerHTML = '';
    
    if (input.files.length > 0) {
        const fileList = document.createElement('div');
        fileList.className = 'alert alert-info';
        fileList.innerHTML = '<strong><i class="fa-solid fa-file me-2"></i>Selected files:</strong><ul class="mb-0 mt-2">';
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const size = file.size < 1024 ? file.size + ' B' : 
                        file.size < 1024 * 1024 ? (file.size / 1024).toFixed(2) + ' KB' : 
                        (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            fileList.innerHTML += `<li>${file.name} (${size})</li>`;
        }
        
        fileList.innerHTML += '</ul>';
        container.appendChild(fileList);
    }
}

// Form validation
document.getElementById('editApplicationForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return;
    }
    
    if (!confirm('Are you sure you want to save these changes?')) {
        e.preventDefault();
    }
});
</script>

<?php require './components/footer.php'; ?>