<?php
$page_title = 'Edit Project';
require './components/header.php';
protectPage();

// Get activity by slug only - NO ID FALLBACK
$activity = null;

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $slug = $_GET['slug'];
    $activity = getActivityBySlug($slug);
    
    if (!$activity) {
        echo "<script>window.location.href='all-projects.php?error=" . urlencode('Project not found') . "'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='all-projects.php?error=" . urlencode('Project slug is required') . "'</script>";
    exit();
}

// Decode sections data
$sections = [];
if (!empty($activity['sections_data'])) {
  $sections = json_decode($activity['sections_data'], true);
  if (!is_array($sections)) {
    $sections = [];
  }
}

// Decode existing images
$existingImages = [];
if (!empty($activity['images'])) {
  $existingImages = json_decode($activity['images'], true);
  if (!is_array($existingImages)) {
    $existingImages = [];
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $objectives = trim($_POST['objectives']);
  $short_description = trim($_POST['short_description']);
  $description = trim($_POST['description']);
  $type = $_POST['type'];
  $status = $_POST['status'];

  if (empty($title) || empty($objectives) || empty($short_description) || empty($description) || empty($type) || empty($status)) {
    echo '<script>
            Swal.fire({
              icon: "error",
              title: "Validation Error",
              text: "All required fields must be filled!",
              confirmButtonColor: "#10b981"
            });
          </script>';
  } else {
    // Handle existing images to keep
    $keepImages = isset($_POST['keep_images']) ? $_POST['keep_images'] : [];
    $finalImages = [];
    
    // Delete removed images
    foreach ($existingImages as $existingImage) {
      if (in_array($existingImage, $keepImages)) {
        $finalImages[] = $existingImage;
      } else {
        // Delete the file
        if (file_exists($existingImage)) {
          unlink($existingImage);
        }
      }
    }
    
    // Handle new image uploads
    $uploadErrors = [];
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
      $uploadDir = '../uploads/activities/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $maxFileSize = 5242880;
      $maxImages = 10;

      $fileCount = count($_FILES['images']['name']);
      $totalImages = count($finalImages) + $fileCount;
      
      if ($totalImages > $maxImages) {
        $uploadErrors[] = "Maximum $maxImages images allowed (you have " . count($finalImages) . " existing)";
      } else {
        for ($i = 0; $i < $fileCount; $i++) {
          if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$i]);
            $targetFile = $uploadDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowedTypes)) {
              $uploadErrors[] = "File " . $_FILES['images']['name'][$i] . ": Invalid type";
              continue;
            }

            if ($_FILES['images']['size'][$i] > $maxFileSize) {
              $uploadErrors[] = "File " . $_FILES['images']['name'][$i] . ": Too large";
              continue;
            }

            if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
              $finalImages[] = $targetFile;
            } else {
              $uploadErrors[] = "Failed to upload " . $_FILES['images']['name'][$i];
            }
          }
        }
      }
    }

    if (!empty($uploadErrors)) {
      foreach ($uploadErrors as $error) {
        echo '<script>
                Swal.fire({
                  icon: "warning",
                  title: "Upload Warning",
                  text: "' . addslashes($error) . '",
                  confirmButtonColor: "#10b981"
                });
              </script>';
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

    // Build update data
    $activityData = [
      'title' => $title,
      'objectives' => $objectives,
      'short_description' => $short_description,
      'description' => $description,
      'type' => $type,
      'status' => $status,
      'sections_data' => $sections_data
    ];

    // Add images if any
    if (!empty($finalImages)) {
      $activityData['images'] = json_encode($finalImages);
      $activityData['image'] = $finalImages[0]; // First image as main
    } else {
      $activityData['images'] = null;
      $activityData['image'] = null;
    }

    $result = updateActivityWithSlug($activity['id'], $activityData);

    if ($result['success']) {
      $redirectSlug = !empty($result['slug']) ? $result['slug'] : $activity['slug'];
      $redirectUrl = "view-project.php?slug=" . urlencode($redirectSlug);
      $imageCount = count($finalImages);
      
      echo '<script>
              Swal.fire({
                icon: "success",
                title: "Success!",
                html: "Project updated successfully!<br>' . 
                      ($imageCount > 0 ? "$imageCount image(s) saved.<br>" : '') .
                      '<small class=\"text-muted\">Slug: ' . htmlspecialchars($redirectSlug) . '</small>",
                confirmButtonColor: "#10b981",
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                  window.location.href = "' . $redirectUrl . '";
                }
              });
            </script>';
    } else {
      echo '<script>
              Swal.fire({
                icon: "error",
                title: "Update Failed",
                text: "' . addslashes($result['message']) . '",
                confirmButtonColor: "#ef4444"
              });
            </script>';
    }
  }
}
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

  .modern-input, .modern-select, .modern-textarea {
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

  .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    transform: translateY(-2px);
  }

  .modern-textarea {
    resize: vertical;
    min-height: 120px;
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

  .btn-submit, .btn-cancel {
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
  }

  .btn-outline-primary {
    background: #fff;
    border: 2px solid #10b981;
    color: #10b981;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
  }

  .btn-outline-primary:hover {
    background: #10b981;
    color: #fff;
  }

  .btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: #fff;
    border-radius: 12px;
    padding: 12px 28px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }

  /* Image Gallery Styles */
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
  }

  .existing-image-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    background: #10b981;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
  }

  @media (max-width: 768px) {
    .image-preview-container {
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
  }
</style>

<div class="content-wrapper">
  <div class="dashboard">
    <div class="page-title-section">
      <div class="icon-box" style="background-color: #059669 !important;">
        <i class="fa-solid fa-pen-to-square text"></i>
      </div>
      <h1>Edit Project</h1>
    </div>

    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="notice-form-container">
          <div class="form-header">
            <h1>Edit Project</h1>
            <p>Update project details below</p>
            <p class="text-muted" style="font-size: 0.9rem; margin-top: 0.5rem;">
              <i class="fa-solid fa-link me-1"></i> 
              Current slug: <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px;"><?= htmlspecialchars($activity['slug']) ?></code>
            </p>
          </div>

          <form action="" method="post" enctype="multipart/form-data" id="activityForm">
            <div class="modern-form-group">
              <label><i class="fa-solid fa-heading"></i> Project Title</label>
              <input type="text" name="title" class="modern-input" required
                value="<?php echo htmlspecialchars($activity['title']); ?>">
              <small class="text-muted">Changing the title will update the URL slug</small>
            </div>

            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-tag"></i> Type</label>
                <select name="type" class="modern-select" required>
                  <option value="">Select Type</option>
                  <option value="Regular" <?php echo $activity['type'] == 'Regular' ? 'selected' : ''; ?>>Regular</option>
                  <option value="Financial" <?php echo $activity['type'] == 'Financial' ? 'selected' : ''; ?>>Financial</option>
                  <option value="Social" <?php echo $activity['type'] == 'Social' ? 'selected' : ''; ?>>Social</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-toggle-on"></i> Status</label>
                <select name="status" class="modern-select" required>
                  <option value="">Select Status</option>
                  <option value="Active" <?php echo $activity['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                  <option value="Inactive" <?php echo $activity['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                  <option value="Draft" <?php echo $activity['status'] == 'Draft' ? 'selected' : ''; ?>>Draft</option>
                </select>
              </div>
            </div>

            <!-- Multiple Images Section -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-images"></i> Project Images</label>
              
              <!-- Existing Images -->
              <div id="existingImagesContainer" class="image-preview-container">
                <?php if (!empty($existingImages)): ?>
                  <?php foreach ($existingImages as $index => $imagePath): ?>
                    <div class="image-preview-item" data-image-path="<?php echo htmlspecialchars($imagePath); ?>">
                      <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Existing Image <?php echo $index + 1; ?>">
                      <span class="existing-image-badge">Existing</span>
                      <button type="button" class="image-preview-remove" onclick="ImageManager.removeExistingImage(this, '<?php echo htmlspecialchars($imagePath); ?>')">
                        <i class="fa-solid fa-times"></i>
                      </button>
                      <input type="hidden" name="keep_images[]" value="<?php echo htmlspecialchars($imagePath); ?>">
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>

              <!-- New Images Upload -->
              <div class="image-upload-area" id="imageUploadArea" style="margin-top: 20px;">
                <div class="upload-icon">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <div class="upload-text">
                  Click to select new images or drag and drop here
                </div>
                <div class="upload-hint">
                  JPG, PNG, GIF or WEBP (max 5MB each, up to 10 images total)
                </div>
                <input type="file" name="images[]" id="imagesInput" accept="image/*" multiple style="display: none;">
              </div>
              <div id="newImagesContainer" class="image-preview-container"></div>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-bullseye"></i> Objectives</label>
              <textarea name="objectives" class="modern-textarea" rows="3" required><?php echo htmlspecialchars($activity['objectives']); ?></textarea>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-align-left"></i> Short Description</label>
              <textarea name="short_description" class="modern-textarea" rows="3" required><?php echo htmlspecialchars($activity['short_description']); ?></textarea>
            </div>

            <div class="modern-form-group">
              <label><i class="fa-solid fa-file-lines"></i> Detailed Description</label>
              <textarea name="description" class="modern-textarea" rows="5" required><?php echo htmlspecialchars($activity['description']); ?></textarea>
            </div>

            <!-- DYNAMIC SECTIONS -->
            <div class="modern-form-group">
              <label style="font-size: 16px; margin-bottom: 20px;">
                <i class="fa-solid fa-list-check"></i> List Sections (Optional)
              </label>

              <div id="activitySectionsContainer">
                <?php if (!empty($sections)): ?>
                  <?php foreach ($sections as $index => $section): ?>
                    <div class="card shadow-sm dynamic-section" data-section-index="<?php echo $index; ?>">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2 flex-grow-1">
                          <span class="input-group-text"><i class="fas fa-list"></i></span>
                          <input type="text" class="section-title-input" name="section_titles[]" 
                                 value="<?php echo htmlspecialchars($section['title']); ?>" 
                                 placeholder="Enter section title" style="max-width: 400px;">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="ActivitySections.removeSection(this)">
                          <i class="fas fa-trash"></i> Remove
                        </button>
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <label class="form-label" style="font-weight: 600; color: #334155;">Items</label>
                          <div class="items-list">
                            <?php foreach ($section['items'] as $item): ?>
                              <div class="item-row">
                                <div class="input-group">
                                  <span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>
                                  <input type="text" class="form-control" name="section_items[<?php echo $index; ?>][]" 
                                         value="<?php echo htmlspecialchars($item); ?>" placeholder="Enter item text">
                                  <button type="button" class="btn btn-outline-danger" onclick="ActivitySections.removeItem(this)">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="ActivitySections.addItem(this)">
                          <i class="fas fa-plus"></i> Add Item
                        </button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>

              <button type="button" class="btn btn-primary mt-3" onclick="ActivitySections.addSection()">
                <i class="fas fa-plus"></i> Add New Section
              </button>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-cancel" onclick="window.location.href='all-projects.php'">
                <i class="fa-solid fa-times"></i> Cancel
              </button>
              <button type="submit" class="btn-submit">
                <i class="fa-solid fa-floppy-disk"></i> Update Project
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Image Manager for Edit Page
const ImageManager = (function() {
  'use strict';
  let newFiles = [];
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

  function getTotalImageCount() {
    const existingCount = document.querySelectorAll('#existingImagesContainer .image-preview-item').length;
    return existingCount + newFiles.length;
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
    
    if (getTotalImageCount() + validFiles.length > maxFiles) { 
      alert(`Maximum ${maxFiles} images allowed (including existing images)`); 
      return; 
    }
    
    newFiles = newFiles.concat(validFiles);
    updateNewImagesPreview();
    updateFileInput();
  }

  function removeNewImage(index) {
    newFiles.splice(index, 1);
    updateNewImagesPreview();
    updateFileInput();
  }

  function removeExistingImage(button, imagePath) {
    Swal.fire({
      title: 'Remove this image?',
      text: 'This image will be deleted permanently',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#10b981',
      confirmButtonText: 'Yes, remove it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        const item = button.closest('.image-preview-item');
        item.remove();
        
        Swal.fire({
          title: 'Removed!',
          text: 'Image will be deleted when you save',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  }

  function updateNewImagesPreview() {
    const container = document.getElementById('newImagesContainer');
    container.innerHTML = '';
    
    newFiles.forEach((file, i) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = document.createElement('div');
        div.className = 'image-preview-item';
        div.innerHTML = `
          <img src="${e.target.result}" alt="New Image ${i + 1}">
          <button type="button" class="image-preview-remove" onclick="ImageManager.removeNewImage(${i})">
            <i class="fa-solid fa-times"></i>
          </button>`;
        container.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }

  function updateFileInput() {
    const input = document.getElementById('imagesInput');
    const dt = new DataTransfer();
    newFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
  }

  return { 
    init, 
    removeNewImage, 
    removeExistingImage 
  };
})();

// Activity Sections Handler
const ActivitySections = (function() {
  'use strict';

  async function confirmRemove(message) {
    const result = await Swal.fire({
      title: 'Are you sure?',
      text: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Yes, remove it!',
      cancelButtonText: 'Cancel'
    });
    return result.isConfirmed;
  }

  async function removeItem(button) {
    const itemRow = button.closest('.item-row');
    const itemsList = itemRow.closest('.items-list');

    if (itemsList.querySelectorAll('.item-row').length <= 1) {
      await Swal.fire({
        icon: 'warning',
        title: 'Cannot Remove',
        text: 'Section must have at least one item',
        confirmButtonColor: '#10b981'
      });
      return;
    }

    const confirmed = await confirmRemove('Remove this item?');
    if (confirmed) {
      itemRow.remove();
    }
  }

  async function removeSection(button) {
    const confirmed = await confirmRemove('Remove this entire section?');
    if (confirmed) {
      const section = button.closest('.dynamic-section');
      section.remove();
      reindexSections();
    }
  }

  function addItem(button) {
    const section = button.closest('.dynamic-section');
    const sectionIndex = parseInt(section.getAttribute('data-section-index'));
    const itemsList = section.querySelector('.items-list');

    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = 
      '<div class="input-group">' +
        '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
        '<input type="text" class="form-control" name="section_items[' + sectionIndex + '][]" placeholder="Enter item text">' +
        '<button type="button" class="btn btn-outline-danger" onclick="ActivitySections.removeItem(this)">' +
          '<i class="fas fa-trash"></i>' +
        '</button>' +
      '</div>';

    itemsList.appendChild(newItem);
    newItem.querySelector('input').focus();
  }

  function addSection() {
    const container = document.getElementById('activitySectionsContainer');
    const newIndex = container.querySelectorAll('.dynamic-section').length;

    const newSection = document.createElement('div');
    newSection.className = 'card shadow-sm dynamic-section';
    newSection.setAttribute('data-section-index', newIndex);

    newSection.innerHTML = 
      '<div class="card-header d-flex justify-content-between align-items-center">' +
        '<div class="d-flex align-items-center gap-2 flex-grow-1">' +
          '<span class="input-group-text"><i class="fas fa-list"></i></span>' +
          '<input type="text" class="section-title-input" name="section_titles[]" placeholder="Enter section title" style="max-width: 400px;">' +
        '</div>' +
        '<button type="button" class="btn btn-sm btn-outline-danger" onclick="ActivitySections.removeSection(this)">' +
          '<i class="fas fa-trash"></i> Remove' +
        '</button>' +
      '</div>' +
      '<div class="card-body">' +
        '<div class="mb-3">' +
          '<label class="form-label" style="font-weight: 600; color: #334155;">Items</label>' +
          '<div class="items-list">' +
            '<div class="item-row">' +
              '<div class="input-group">' +
                '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
                '<input type="text" class="form-control" name="section_items[' + newIndex + '][]" placeholder="Enter item text">' +
                '<button type="button" class="btn btn-outline-danger" onclick="ActivitySections.removeItem(this)">' +
                  '<i class="fas fa-trash"></i>' +
                '</button>' +
              '</div>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<button type="button" class="btn btn-outline-primary btn-sm" onclick="ActivitySections.addItem(this)">' +
          '<i class="fas fa-plus"></i> Add Item' +
        '</button>' +
      '</div>';

    container.appendChild(newSection);
    newSection.querySelector('.section-title-input').focus();
  }

  function reindexSections() {
    const container = document.getElementById('activitySectionsContainer');
    const sections = container.querySelectorAll('.dynamic-section');

    sections.forEach(function(section, newIndex) {
      section.setAttribute('data-section-index', newIndex);
      
      const itemInputs = section.querySelectorAll('.items-list input[type="text"]');
      itemInputs.forEach(function(input) {
        input.setAttribute('name', 'section_items[' + newIndex + '][]');
      });
    });
  }

  return {
    addSection,
    removeSection,
    addItem,
    removeItem
  };
})();

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  ImageManager.init();
});

// Form submission confirmation
document.getElementById('activityForm').addEventListener('submit', function(e) {
  const form = this;
  const submitButton = form.querySelector('button[type="submit"]');
  
  if (!form.checkValidity()) {
    return;
  }
  
  e.preventDefault();
  
  Swal.fire({
    title: 'Update Project?',
    text: 'Are you sure you want to update this project?',
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
      submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';
      form.submit();
    }
  });
});
</script>

<?php require './components/footer.php'; ?>