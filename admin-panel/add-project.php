<?php
$page_title = 'Add Project';
require './components/header.php';
protectPage();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
  .notice-form-container {
    background: #fff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .notice-form-container:hover {
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
  }

  .form-header {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
  }

  .form-header::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 2px;
  }

  .form-header h1 {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(135deg, #10b981, #059669);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
  }

  .form-header p {
    color: #64748b;
    font-size: 15px;
    margin: 0;
  }

  .modern-form-group {
    margin-bottom: 28px;
    position: relative;
  }

  .modern-form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .modern-form-group label i {
    margin-right: 8px;
    color: #10b981;
  }

  .modern-input,
  .modern-select,
  .modern-textarea {
    width: 100%;
    padding: 10px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    color: #1e293b;
    background: #fff;
    transition: all 0.3s ease;
    font-family: inherit;
  }

  .modern-input:focus,
  .modern-select:focus,
  .modern-textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    transform: translateY(-2px);
  }

  .modern-input:hover,
  .modern-select:hover,
  .modern-textarea:hover {
    border-color: #cbd5e1;
  }

  .modern-textarea {
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
  }

  .modern-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2310b981' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 20px;
    padding-right: 45px;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #f1f5f9;
  }

  .btn-submit,
  .btn-cancel {
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .btn-submit {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
  }

  .btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
  }

  .btn-submit:active {
    transform: translateY(-1px);
  }

  .btn-cancel {
    background: #f1f5f9;
    color: #475569;
  }

  .btn-cancel:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
  }

  .dynamic-section {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    margin-bottom: 24px;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .dynamic-section:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .card-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
    padding: 20px !important;
    border-bottom: 2px solid #e2e8f0;
  }

  .section-title-input {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    transition: all 0.3s ease !important;
  }

  .section-title-input:focus {
    outline: none !important;
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
  }

  .card-body {
    padding: 24px !important;
    background: #fafbfc;
  }

  .items-list {
    margin-bottom: 16px;
  }

  .item-row {
    margin-bottom: 12px;
  }

  .input-group {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .input-group-text {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 48px;
    height: 48px;
  }

  .input-group .form-control {
    flex: 1;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  .input-group .form-control:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
  }

  .btn-outline-danger {
    background: #fff;
    border: 2px solid #ef4444;
    color: #ef4444;
    border-radius: 10px;
    padding: 10px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 48px;
    height: 48px;
  }

  .btn-outline-danger:hover {
    background: #ef4444;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
  }

  .btn-outline-primary {
    background: #fff;
    border: 2px solid #10b981;
    color: #10b981;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-outline-primary:hover {
    background: #10b981;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }

  .btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: #fff;
    border-radius: 12px;
    padding: 12px 28px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }

  .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
  }

  /* Multiple Images Upload Styles */
  .image-upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    background: #f8fafc;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .image-upload-area:hover {
    border-color: #10b981;
    background: #f0fdf4;
  }

  .image-upload-area.drag-over {
    border-color: #10b981;
    background: #d1fae5;
    border-style: solid;
  }

  .upload-icon {
    font-size: 48px;
    color: #10b981;
    margin-bottom: 15px;
  }

  .upload-text {
    color: #64748b;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .upload-hint {
    color: #94a3b8;
    font-size: 13px;
  }

  .image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
  }

  .image-preview-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    background: #fff;
    transition: all 0.3s ease;
  }

  .image-preview-item:hover {
    border-color: #10b981;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    transform: translateY(-2px);
  }

  .image-preview-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
  }

  .image-preview-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    opacity: 0.95;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  .image-preview-remove:hover {
    opacity: 1;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
  }

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

  .message-box i {
    font-size: 18px;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (max-width: 768px) {
    .notice-form-container {
      padding: 28px 20px;
      border-radius: 16px;
    }

    .form-header h1 {
      font-size: 26px;
    }

    .form-row {
      grid-template-columns: 1fr;
      gap: 0;
    }

    .form-actions {
      flex-direction: column-reverse;
    }

    .btn-submit,
    .btn-cancel {
      width: 100%;
    }

    .card-header {
      flex-direction: column;
      gap: 12px;
    }

    .section-title-input {
      max-width: 100% !important;
    }

    .image-preview-container {
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
  }

  .icon-box {
    background-color: #059669 !important;
  }
</style>
<div class="content-wrapper">
  <div class="dashboard">
    <div class="page-title-section">
      <div class="icon-box">
        <i class="mdi mdi-calendar-account-outline"></i>
      </div>
      <h1>Add New Project</h1>
    </div>

    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="notice-form-container">
          <div class="form-header">
            <h1>Create New Project</h1>
            <p>Fill in the details below to publish a new project</p>
          </div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $objectives = trim($_POST['objectives']);
  $short_description = trim($_POST['short_description']);
  $description = trim($_POST['description']);
  $type = $_POST['type'];
  $status = $_POST['status'];

  if (empty($title) || empty($objectives) || empty($short_description) || empty($description) || empty($type) || empty($status)) {
    echo '<div class="message-box error">
            <i class="fa-solid fa-circle-exclamation"></i>
            All required fields must be filled!
          </div>';
  } else {
    // Handle multiple image uploads
    $uploadedImages = [];
    $uploadErrors = [];
    
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
      $uploadDir = '../uploads/activities/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $maxFileSize = 5242880; // 5MB
      $maxImages = 10;

      $fileCount = count($_FILES['images']['name']);
      
      if ($fileCount > $maxImages) {
        $uploadErrors[] = "Maximum $maxImages images allowed";
      } else {
        for ($i = 0; $i < $fileCount; $i++) {
          if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$i]);
            $targetFile = $uploadDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowedTypes)) {
              $uploadErrors[] = "File " . $_FILES['images']['name'][$i] . ": Only JPG, JPEG, PNG, GIF & WEBP allowed";
              continue;
            }

            if ($_FILES['images']['size'][$i] > $maxFileSize) {
              $uploadErrors[] = "File " . $_FILES['images']['name'][$i] . ": Too large (max 5MB)";
              continue;
            }

            if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
              $uploadedImages[] = $targetFile;
            } else {
              $uploadErrors[] = "Failed to upload " . $_FILES['images']['name'][$i];
            }
          }
        }
      }
    }

    if (!empty($uploadErrors)) {
      foreach ($uploadErrors as $error) {
        echo '<div class="message-box error">
                <i class="fa-solid fa-circle-exclamation"></i>
                ' . htmlspecialchars($error) . '
              </div>';
      }
    }

    // Handle dynamic sections
    $sections_data = null;
    if (isset($_POST['section_titles']) && isset($_POST['section_items'])) {
      $sections = [];
      $section_titles = $_POST['section_titles'];
      $section_items = $_POST['section_items'];

      foreach ($section_titles as $index => $title_text) {
        $title_text = trim($title_text);

        if (!empty($title_text)) {
          $items = [];

          if (isset($section_items[$index]) && is_array($section_items[$index])) {
            foreach ($section_items[$index] as $item) {
              $item = trim($item);
              if (!empty($item)) {
                $items[] = $item;
              }
            }
          }

          if (!empty($items)) {
            $sections[] = [
              'title' => $title_text,
              'items' => $items
            ];
          }
        }
      }

      if (!empty($sections)) {
        $sections_data = json_encode($sections, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
      }
    }

    // Build activity data array
    $activityData = [
      'title' => $title,
      'objectives' => $objectives,
      'short_description' => $short_description,
      'description' => $description,
      'type' => $type,
      'status' => $status
    ];

    // Add images as JSON array if any were uploaded
    if (!empty($uploadedImages)) {
      $activityData['images'] = json_encode($uploadedImages);
      // Also set the first image as the main image for backward compatibility
      $activityData['image'] = $uploadedImages[0];
    }

    if ($sections_data !== null) {
      $activityData['sections_data'] = $sections_data;
    }

    // Create activity with slug in database
    $result = createActivityWithSlug($activityData);

    if ($result['success']) {
      $imageCount = count($uploadedImages);
      echo '<div class="message-box success">
              <i class="fa-solid fa-circle-check"></i>
              Project created successfully!' . ($imageCount > 0 ? " $imageCount image(s) uploaded." : '') . ' Slug: ' . htmlspecialchars($result['slug']) . '
            </div>';

      echo '<script>
              setTimeout(function() {
                window.location.href = "all-projects.php";
              }, 1500);
            </script>';
    } else {
      echo '<div class="message-box error">
              <i class="fa-solid fa-circle-exclamation"></i>
              Error: ' . htmlspecialchars($result['message']) . '
            </div>';
    }
  }
}
?>
          <form action="" method="post" enctype="multipart/form-data" id="activityForm">
            <div class="modern-form-group">
              <label><i class="fa-solid fa-heading"></i> Project Title</label>
              <input type="text" name="title" class="modern-input" placeholder="Enter activity title..." required
                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
              <small class="text-muted">A unique URL slug will be automatically generated from the title</small>
            </div>

            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-tag"></i> Type</label>
                <select name="type" class="modern-select" required>
                  <option value="">Select Type</option>
                  <option value="Regular" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Regular') ? 'selected' : ''; ?>>Regular</option>
                  <option value="Financial" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Financial') ? 'selected' : ''; ?>>Financial</option>
                  <option value="Social" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Social') ? 'selected' : ''; ?>>Social</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-toggle-on"></i> Status</label>
                <select name="status" class="modern-select" required>
                  <option value="">Select Status</option>
                  <option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Active') ? 'selected' : 'selected'; ?>>Active</option>
                  <option value="Inactive" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                  <option value="Draft" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
              </div>
            </div>

            <!-- Multiple Images Upload Section -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-images"></i> Project Images (Optional)</label>
              <div class="image-upload-area" id="imageUploadArea">
                <div class="upload-icon">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <div class="upload-text">
                  Click to select images or drag and drop here
                </div>
                <div class="upload-hint">
                  JPG, PNG, GIF or WEBP (max 5MB each, up to 10 images)
                </div>
                <input type="file" name="images[]" id="imagesInput" accept="image/*" multiple style="display: none;">
              </div>
              <div id="imagePreviewContainer" class="image-preview-container"></div>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-bullseye"></i> Objectives (Project Goals)</label>
              <textarea name="objectives" class="modern-textarea" rows="3" placeholder="Write the activity objectives here..." required><?php echo isset($_POST['objectives']) ? htmlspecialchars($_POST['objectives']) : ''; ?></textarea>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-align-left"></i> Short Description</label>
              <textarea name="short_description" class="modern-textarea" rows="3" placeholder="Write a brief description..." required><?php echo isset($_POST['short_description']) ? htmlspecialchars($_POST['short_description']) : ''; ?></textarea>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-file-lines"></i> Detailed Description</label>
              <textarea name="description" class="modern-textarea" rows="5" placeholder="Write the detailed activity description..." required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>

            <!-- DYNAMIC SECTIONS -->
            <div class="modern-form-group">
              <label style="font-size: 16px; margin-bottom: 20px;">
                <i class="fa-solid fa-list-check"></i> List Sections (Optional)
              </label>

              <div id="activitySectionsContainer"></div>

              <button type="button" class="btn btn-primary mt-3" onclick="ActivitySections.addSection()">
                <i class="fas fa-plus"></i> Add New Section
              </button>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-cancel" onclick="window.history.back()">
                <i class="fa-solid fa-times"></i> Cancel
              </button>
              <button type="submit" class="btn-submit" name="submit_activity">
                <i class="fa-solid fa-paper-plane"></i> Create Project
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Image Upload Handler
const ImageUploadHandler = (function() {
  'use strict';
  let selectedFiles = [];
  const maxFiles = 10;
  const maxFileSize = 5242880;
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

  function init() {
    const uploadArea = document.getElementById('imageUploadArea');
    const fileInput = document.getElementById('imagesInput');
    
    if (!uploadArea || !fileInput) return;
    
    uploadArea.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (e) => addFiles(Array.from(e.target.files)));
    uploadArea.addEventListener('dragover', (e) => { 
      e.preventDefault(); 
      e.currentTarget.classList.add('drag-over'); 
    });
    uploadArea.addEventListener('dragleave', (e) => { 
      e.preventDefault(); 
      e.currentTarget.classList.remove('drag-over'); 
    });
    uploadArea.addEventListener('drop', (e) => {
      e.preventDefault();
      e.currentTarget.classList.remove('drag-over');
      addFiles(Array.from(e.dataTransfer.files));
    });
  }

  function addFiles(files) {
    const validFiles = files.filter(file => {
      if (!allowedTypes.includes(file.type)) { 
        alert(`${file.name} is not a valid image type`); 
        return false; 
      }
      if (file.size > maxFileSize) { 
        alert(`${file.name} is too large (max 5MB)`); 
        return false; 
      }
      return true;
    });
    
    if (selectedFiles.length + validFiles.length > maxFiles) { 
      alert(`Maximum ${maxFiles} images allowed`); 
      return; 
    }
    selectedFiles = selectedFiles.concat(validFiles);
    updatePreview();
    updateFileInput();
  }

  function removeFile(index) {
    selectedFiles.splice(index, 1);
    updatePreview();
    updateFileInput();
  }

  function updatePreview() {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    selectedFiles.forEach((file, i) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = document.createElement('div');
        div.className = 'image-preview-item';
        div.innerHTML = `<img src="${e.target.result}" alt="Preview ${i + 1}">
          <button type="button" class="image-preview-remove" onclick="ImageUploadHandler.removeFile(${i})">
            <i class="fa-solid fa-times"></i></button>`;
        container.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }

  function updateFileInput() {
    const input = document.getElementById('imagesInput');
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
  }

  return { init, removeFile };
})();

// Activity Sections Handler
const ActivitySections = (function() {
  'use strict';

  function addItem(button) {
    const section = button.closest('.dynamic-section');
    const sectionIndex = parseInt(section.getAttribute('data-section-index'));
    const itemsList = section.querySelector('.items-list');
    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = `<div class="input-group">
      <span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>
      <input type="text" class="form-control" name="section_items[${sectionIndex}][]" placeholder="Enter item text">
      <button type="button" class="btn btn-outline-danger" onclick="ActivitySections.removeItem(this)">
        <i class="fas fa-trash"></i></button></div>`;
    itemsList.appendChild(newItem);
  }

  function removeItem(button) {
    const itemRow = button.closest('.item-row');
    const itemsList = itemRow.closest('.items-list');
    if (itemsList.querySelectorAll('.item-row').length <= 1) { alert('Section must have at least one item'); return; }
    if (confirm('Remove this item?')) itemRow.remove();
  }

  function addSection() {
    const container = document.getElementById('activitySectionsContainer');
    const newIndex = container.querySelectorAll('.dynamic-section').length;
    const newSection = document.createElement('div');
    newSection.className = 'card shadow-sm dynamic-section';
    newSection.setAttribute('data-section-index', newIndex);
    newSection.innerHTML = `
      <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
          <span class="input-group-text"><i class="fas fa-list"></i></span>
          <input type="text" class="section-title-input" name="section_titles[]" placeholder="Enter section title" style="max-width: 400px;">
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="ActivitySections.removeSection(this)">
          <i class="fas fa-trash"></i> Remove</button>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label" style="font-weight: 600; color: #334155; margin-bottom: 12px;">Items</label>
          <div class="items-list">
            <div class="item-row">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>
                <input type="text" class="form-control" name="section_items[${newIndex}][]" placeholder="Enter item text">
                <button type="button" class="btn btn-outline-danger" onclick="ActivitySections.removeItem(this)">
                  <i class="fas fa-trash"></i></button>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="ActivitySections.addItem(this)">
          <i class="fas fa-plus"></i> Add Item</button>
      </div>`;
    container.appendChild(newSection);
  }

  function removeSection(button) {
    const section = button.closest('.dynamic-section');
    const container = document.getElementById('activitySectionsContainer');
    if (container.querySelectorAll('.dynamic-section').length <= 1) { alert('Must have at least one section'); return; }
    if (confirm('Remove this entire section?')) { section.remove(); reindexSections(); }
  }

  function reindexSections() {
    const sections = document.querySelectorAll('.dynamic-section');
    sections.forEach((section, newIndex) => {
      section.setAttribute('data-section-index', newIndex);
      section.querySelectorAll('.items-list input[type="text"]').forEach(input => {
        input.setAttribute('name', `section_items[${newIndex}][]`);
      });
    });
  }

  return { addSection, removeSection, addItem, removeItem };
})();

document.addEventListener('DOMContentLoaded', function() {
  window.scrollTo(0, 0);
  ImageUploadHandler.init();
  ActivitySections.addSection();
  
  const form = document.getElementById('activityForm');
  if (form) {
    form.addEventListener('submit', function(e) {
      const required = ['title', 'objectives', 'short_description', 'description', 'type', 'status'];
      const missing = required.filter(name => !this.querySelector(`[name="${name}"]`).value.trim());
      
      if (missing.length) {
        e.preventDefault();
        alert('Please fill in all required fields');
        return false;
      }

      const submitBtn = this.querySelector('.btn-submit');
      if (submitBtn) {
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating...';
        submitBtn.disabled = true;
      }
    });
  }
});

window.addEventListener('load', () => setTimeout(() => window.scrollTo({top: 0, left: 0, behavior: 'instant'}), 100));
</script>

<?php require './components/footer.php'; ?>