<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Scholarship Application';
require './components/header.php';

// Initialize variables to avoid undefined warnings
$success_message = '';
$error_message = '';

// Read messages from session (if any)
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// IMPORTANT: Reset form_submitted flag after displaying messages
// This allows new submissions while preventing refresh resubmission
if (isset($_SESSION['form_submitted'])) {
    unset($_SESSION['form_submitted']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Debug: Log what we're receiving
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));

    // Pass the correct files array structure
    $filesArray = isset($_FILES['documents']) ? $_FILES['documents'] : null;
    
    $result = saveScholarshipApplication($_POST, $filesArray);

    if ($result['success']) {
        $_SESSION['form_submitted'] = true;
        $_SESSION['success_message'] = $result['message'];
        
        // Log success
        error_log("Application saved successfully. ID: " . $result['application_id'] . ", Documents: " . $result['documents_uploaded']);
    } else {
        $_SESSION['error_message'] = $result['message'];
        error_log("Application failed: " . $result['message']);
    }

    // Use proper redirect instead of JavaScript
    echo "<script>
    window.location.href='" . BASE_URL . "scholarship'
    </script>";
    exit;
}
?>

<style>
    .form-check img {
        width: 70px;
    }

    .custom-border {
        border: 1px solid #ccc;
    }

    .donate-page .card-header-custom {
        background: linear-gradient(135deg, #02BD61 0%, #11844b 100%);
        color: #ffffff;
        padding: 2.5rem 2rem;
        border: none;
    }

    /* Document Upload Styles */
    .file-upload-wrapper {
        border: 2px dashed #02BD61;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(2, 189, 97, 0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .file-upload-wrapper:hover {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border-color: #11844b;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(2, 189, 97, 0.2);
    }

    .file-upload-wrapper.dragover {
        background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
        border-color: #059669;
        border-width: 3px;
        transform: scale(1.02);
    }

    .file-upload-icon {
        font-size: 3.5rem;
        color: #02BD61;
        margin-bottom: 1rem;
        animation: bounce 2s infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .file-upload-wrapper h5 {
        color: #11844b;
        font-weight: 600;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .file-upload-wrapper p {
        color: #059669;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .btn-browse-files {
        background: linear-gradient(135deg, #02BD61, #11844b);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(2, 189, 97, 0.3);
        position: relative;
        z-index: 1;
    }

    .btn-browse-files:hover {
        background: linear-gradient(135deg, #11844b, #059669);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(2, 189, 97, 0.4);
    }

    .upload-info {
        font-size: 0.875rem;
        color: #059669;
        margin-top: 1rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 8px;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 1;
    }

    .upload-info i {
        color: #02BD61;
    }

    .file-list {
        margin-top: 20px;
    }

    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .file-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #02BD61;
        transform: translateX(5px);
    }

    .file-item-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .file-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 8px;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .file-icon.pdf {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #dc2626;
    }

    .file-icon.doc {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #2563eb;
    }

    .file-icon.img {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #059669;
    }

    .file-details {
        flex: 1;
        min-width: 0;
    }

    .file-name {
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 4px 0;
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size {
        color: #6b7280;
        font-size: 0.85rem;
    }

    .remove-file {
        cursor: pointer;
        color: #dc2626;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        background: transparent;
        border: none;
        font-size: 1.2rem;
    }

    .remove-file:hover {
        background: #fee2e2;
        color: #b91c1c;
        transform: scale(1.1);
    }

    .btn-donate {
        background: linear-gradient(135deg, #02BD61, #11844b);
        border: none;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(2, 189, 97, 0.3);
    }

    .btn-donate:hover {
        background: linear-gradient(135deg, #11844b, #059669);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(2, 189, 97, 0.4);
    }

    /* Form Control Focus States */
    .form-control:focus,
    .category_options:focus {
        border-color: #02BD61;
        box-shadow: 0 0 0 0.2rem rgba(2, 189, 97, 0.25);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .file-upload-wrapper {
            padding: 20px 15px;
        }

        .file-upload-icon {
            font-size: 2.5rem;
        }

        .file-item {
            padding: 12px;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->
<div class="donate-home">
    <div class="home">
        <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="<?= BASE_URL ?>images/about.jpg" data-speed="0.8"></div>
        <div class="home_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="home_content text-center">
                            <div data-aos="fade-up" class="home_title">Get Scholarship</div>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="<?= BASE_URL ?>index.php">Home</a></li>
                                    <li>Scholarship</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="donate-page">
    <div class="container mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="">
                <div class="donation-card">
                    <!-- Header -->
                    <div class="card-header-custom">
                        <h4>Get a Scholarship Now</h4>
                        <p>Scholarship For Meritorious Students and Students with financial problems</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">
                        <form id="donationForm" method="POST" action="" enctype="multipart/form-data">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <?php echo htmlspecialchars($success_message); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if ($error_message): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <?php echo htmlspecialchars($error_message); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Your Name -->
                            <div class="mb-3">
                                <label for="yourName" class="form-label">
                                    Your Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="yourName" name="name" placeholder="Enter your full name" required>
                            </div>

                            <!-- Your Mail -->
                            <div class="mb-3">
                                <label for="yourmail" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="yourmail" name="email" placeholder="Enter your email">
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Your Address</label>
                                <input type="text" class="form-control" id="youraddress" name="youraddress" placeholder="Enter your address">
                            </div>

                            <!-- Institution Type -->
                            <div class="mb-3">
                                <label for="institution-type" class="form-label">
                                    Institution Type <span class="text-danger">*</span>
                                </label>
                                <select class="w-100 px-4 py-3 rounded-2 category_options" id="category" name="institution_type" required>
                                    <option value="">-- Select a category --</option>
                                    <option value="hifz">Hifz Program</option>
                                    <option value="school">School</option>
                                    <option value="college">College</option>
                                    <option value="university">University</option>
                                    <option value="madrasha-program">Madrasha</option>
                                </select>
                            </div>

                            <!-- Institution Name -->
                            <div class="mb-3">
                                <label for="institute-name" class="form-label">Institution Name</label>
                                <input type="text" class="form-control" id="instituename" name="instituename" placeholder="Enter your institution name">
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">
                                    Phone
                                    <i class="bi bi-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="We'll contact you on this number"></i>
                                </label>
                                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter phone number">
                            </div>

                            <!-- Document Upload Section -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Supporting Documents
                                    <i class="bi bi-info-circle tooltip-icon ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload transcripts, certificates, ID card, income proof, or other supporting documents"></i>
                                </label>
                                
                                <div class="file-upload-wrapper" id="fileUploadWrapper">
                                    <i class="bi bi-cloud-upload file-upload-icon"></i>
                                    <h5>Drag & Drop Your Files Here</h5>
                                    <p class="mb-2">or click to browse</p>
                                    <label for="fileInput" class="btn-browse-files">
                                        <i class="bi bi-folder2-open me-2"></i>Browse Files
                                    </label>
                                    <input type="file" 
                                           id="fileInput" 
                                           name="documents[]" 
                                           multiple 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           style="display: none;">
                                    
                                    <div class="upload-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        <strong>Accepted:</strong> PDF, DOC, DOCX, JPG, PNG | 
                                        <strong>Max Size:</strong> 5MB per file
                                    </div>
                                </div>

                                <!-- File List -->
                                <div id="fileList" class="file-list"></div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="my-3 btn btn-success btn-donate w-100">
                                <i class="bi bi-send-fill me-2"></i>
                                <span>Apply Now</span>
                            </button>

                            <!-- Terms -->
                            <div class="terms-text text-center">
                                By applying you agree to our
                                <a href="#" class="text-decoration-none">Terms and Conditions</a> and
                                <a href="#" class="text-decoration-none">Privacy Policy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const fileUploadWrapper = document.getElementById('fileUploadWrapper');
    let selectedFiles = [];

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop handlers
    fileUploadWrapper.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadWrapper.classList.add('dragover');
    });

    fileUploadWrapper.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadWrapper.classList.remove('dragover');
    });

    fileUploadWrapper.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileUploadWrapper.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    // Click on wrapper to trigger file input
    fileUploadWrapper.addEventListener('click', function(e) {
        if (e.target !== fileInput && !e.target.closest('label')) {
            fileInput.click();
        }
    });

    function handleFiles(files) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['application/pdf', 'application/msword', 
                              'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                              'image/jpeg', 'image/jpg', 'image/png'];

        Array.from(files).forEach(file => {
            // Validate file size
            if (file.size > maxSize) {
                alert(`❌ ${file.name} is too large. Maximum size is 5MB.`);
                return;
            }

            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                alert(`❌ ${file.name} is not allowed. Only PDF, DOC, DOCX, JPG, PNG files are accepted.`);
                return;
            }

            // Check if file already added
            if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                alert(`ℹ️ ${file.name} is already added.`);
                return;
            }

            selectedFiles.push(file);
        });

        updateFileList();
        updateFileInput();
    }

    function updateFileList() {
        fileList.innerHTML = '';

        if (selectedFiles.length === 0) {
            return;
        }

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            
            const fileExtension = file.name.split('.').pop().toLowerCase();
            let iconClass = 'bi-file-earmark';
            let iconType = 'doc';
            
            if (fileExtension === 'pdf') {
                iconClass = 'bi-file-pdf-fill';
                iconType = 'pdf';
            } else if (['doc', 'docx'].includes(fileExtension)) {
                iconClass = 'bi-file-word-fill';
                iconType = 'doc';
            } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                iconClass = 'bi-file-image-fill';
                iconType = 'img';
            }

            fileItem.innerHTML = `
                <div class="file-item-info">
                    <div class="file-icon ${iconType}">
                        <i class="bi ${iconClass}"></i>
                    </div>
                    <div class="file-details">
                        <div class="file-name" title="${file.name}">${file.name}</div>
                        <small class="file-size">${formatFileSize(file.size)}</small>
                    </div>
                </div>
                <button type="button" class="remove-file" onclick="removeFile(${index})" title="Remove file">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            `;

            fileList.appendChild(fileItem);
        });
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileList();
        updateFileInput();
    };

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>