<?php
$page_title = 'Add Activity';
require './components/header.php';
protectPage(); // Protect this page - only logged in users can access

$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
  /* Modern Form Styles */
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
    padding: 14px 18px;
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

  /* Dynamic Sections Styling */
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

  /* File Upload Styling */
  input[type="file"] {
    padding: 12px;
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
  }

  input[type="file"]:hover {
    border-color: #10b981;
    background: #f0fdf4;
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

  /* Responsive Design */
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
  }

  /* Animation */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .notice-form-container {
    animation: fadeInUp 0.6s ease;
  }

  .modern-form-group {
    animation: fadeInUp 0.6s ease;
    animation-fill-mode: both;
  }

  .modern-form-group:nth-child(1) { animation-delay: 0.1s; }
  .modern-form-group:nth-child(2) { animation-delay: 0.15s; }
  .modern-form-group:nth-child(3) { animation-delay: 0.2s; }
  .modern-form-group:nth-child(4) { animation-delay: 0.25s; }
  .modern-form-group:nth-child(5) { animation-delay: 0.3s; }
  .modern-form-group:nth-child(6) { animation-delay: 0.35s; }
  
  .icon-box {
    background-color: #059669 !important;
  }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="dashboard">

    <!-- Page Title -->
    <div class="page-title-section">
      <div class="icon-box">
        <i class="fa-solid fa-bell-ring text"></i>
      </div>
      <h1>Add New Activity</h1>
    </div>

    <!-- Form Container -->
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="notice-form-container">

          <!-- Form Header -->
          <div class="form-header">
            <h1>Create New Activity</h1>
            <p>Fill in the details below to publish a new activity</p>
          </div>

          <?php
          // Handle form submission
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $title = trim($_POST['title']);
            $objectives = trim($_POST['objectives']);
            $short_description = trim($_POST['short_description']);
            $description = trim($_POST['description']);
            $type = $_POST['type'];
            $status = $_POST['status'];
            
            // Handle image upload
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
              $uploadDir = '../uploads/activities/';
              if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
              }
              
              $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
              $targetFile = $uploadDir . $fileName;
              
              // Check file type
              $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
              $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
              
              if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                  $image = $fileName; // Store only the filename
                } else {
                  echo '<div class="message-box error">
                          <i class="fa-solid fa-circle-exclamation"></i>
                          Error uploading image file.
                        </div>';
                }
              } else {
                echo '<div class="message-box error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Only JPG, JPEG, PNG, GIF & WEBP files are allowed.
                      </div>';
              }
            }
            
            // Handle dynamic sections data
            $sections_data = null;
            if (isset($_POST['section_titles']) && isset($_POST['section_items'])) {
              $sections = [];
              $section_titles = $_POST['section_titles'];
              $section_items = $_POST['section_items'];
              
              for ($i = 0; $i < count($section_titles); $i++) {
                if (!empty($section_titles[$i])) {
                  $sections[] = [
                    'title' => $section_titles[$i],
                    'items' => isset($section_items[$i]) ? $section_items[$i] : []
                  ];
                }
              }
              
              if (!empty($sections)) {
                $sections_data = json_encode($sections);
              }
            }
            
            // Validate required fields
            if (empty($title) || empty($objectives) || empty($short_description) || empty($description) || empty($type) || empty($status)) {
              echo '<div class="message-box error">
                      <i class="fa-solid fa-circle-exclamation"></i>
                      All required fields must be filled!
                    </div>';
            } else {
              // Prepare data array
              $activityData = [
                'title' => $title,
                'objectives' => $objectives,
                'short_description' => $short_description,
                'description' => $description,
                'type' => $type,
                'status' => $status
              ];
              
              // Add image only if uploaded
              if ($image !== null) {
                $activityData['image'] = $image;
              }
              
              // Add sections data only if exists
              if ($sections_data !== null) {
                $activityData['sections_data'] = $sections_data;
              }
              
              // Create activity using your function
              $result = createActivity($activityData);
              
              if ($result['success']) {
                echo '<div class="message-box success">
                        <i class="fa-solid fa-circle-check"></i>
                        Activity created successfully!
                      </div>';
                
                // Clear form after successful submission
                echo '<script>
                        setTimeout(function() {
                          window.location.href = "all-activities.php";
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

          <!-- Form -->
          <form action="" method="post" enctype="multipart/form-data" id="activityForm">

            <!-- Title -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-heading"></i> Activity Title</label>
              <input type="text" name="title" class="modern-input" placeholder="Enter activity title..." required
                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>

            <!-- Type & Status -->
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

            <!-- Image -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-image"></i> Activity Image (Optional)</label>
              <input type="file" name="image" class="modern-input" accept="image/*">
              <small class="text-muted">Upload JPG, PNG, GIF or WEBP image (max 5MB)</small>
            </div>

            <!-- Objectives -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-bullseye"></i> Objectives (Activity Goals)</label>
              <textarea name="objectives" class="modern-textarea" rows="3" placeholder="Write the activity objectives here..." required><?php echo isset($_POST['objectives']) ? htmlspecialchars($_POST['objectives']) : ''; ?></textarea>
            </div>

            <!-- Short Description -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-align-left"></i> Short Description</label>
              <textarea name="short_description" class="modern-textarea" rows="3" placeholder="Write a brief description..." required><?php echo isset($_POST['short_description']) ? htmlspecialchars($_POST['short_description']) : ''; ?></textarea>
            </div>

            <!-- Description -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-file-lines"></i> Detailed Description</label>
              <textarea name="description" class="modern-textarea" rows="5" placeholder="Write the detailed activity description..." required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>

            <!-- Add List Section -->
            <div class="modern-form-group">
              <label style="font-size: 16px; margin-bottom: 20px;"><i class="fa-solid fa-list-check"></i> List Sections (Optional)</label>

              <div id="dynamicSectionsContainer">
                <div class="card shadow-sm dynamic-section" data-section-id="1">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                      <span class="input-group-text"><i class="fas fa-list"></i></span>
                      <input type="text" class="section-title-input" name="section_titles[]" placeholder="Enter section title (e.g., Requirements, Procedures)" style="max-width: 400px;">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">
                      <i class="fas fa-trash"></i> Remove
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                      <label class="form-label" style="font-weight: 600; color: #334155; margin-bottom: 12px;">Items</label>
                      <div class="items-list">
                        <div class="item-row">
                          <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>
                            <input type="text" class="form-control" name="section_items[0][]" placeholder="Enter item text">
                            <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this, 0)">
                      <i class="fas fa-plus"></i> Add New Item
                    </button>
                  </div>
                </div>
              </div>

              <button type="button" class="btn btn-primary mt-3" onclick="addNewSectionDynamic()">
                <i class="fas fa-plus"></i> Add New Section
              </button>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
              <button type="button" class="btn-cancel" onclick="window.history.back()">
                <i class="fa-solid fa-times"></i> Cancel
              </button>
              <button type="submit" class="btn-submit" name="submit_activity">
                <i class="fa-solid fa-paper-plane"></i> Create Activity
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
  var activitySectionCounter = 1;
  var sectionItemCounters = [0]; // Track items for each section

  function addNewItemDynamic(button, sectionIndex) {
    var section = button.closest('.dynamic-section');
    var itemsList = section.querySelector('.items-list');

    var newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = '<div class="input-group">' +
      '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
      '<input type="text" class="form-control" name="section_items[' + sectionIndex + '][]" placeholder="Enter item text">' +
      '<button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">' +
      '<i class="fas fa-trash"></i>' +
      '</button>' +
      '</div>';

    itemsList.appendChild(newItem);
    newItem.querySelector('input').focus();
  }

  function removeItemDynamic(button) {
    var itemRow = button.closest('.item-row');
    var itemsList = itemRow.closest('.items-list');

    if (itemsList.querySelectorAll('.item-row').length <= 1) {
      alert('Section must have at least one item');
      return;
    }

    if (confirm('Are you sure you want to remove this item?')) {
      itemRow.remove();
    }
  }

  function addNewSectionDynamic() {
    activitySectionCounter++;
    sectionItemCounters.push(0);
    var container = document.getElementById('dynamicSectionsContainer');
    var sectionIndex = activitySectionCounter - 1;

    var newSection = document.createElement('div');
    newSection.className = 'card shadow-sm dynamic-section';
    newSection.setAttribute('data-section-id', activitySectionCounter);
    newSection.innerHTML = '<div class="card-header d-flex justify-content-between align-items-center">' +
      '<div class="d-flex align-items-center gap-2 flex-grow-1">' +
      '<span class="input-group-text"><i class="fas fa-list"></i></span>' +
      '<input type="text" class="section-title-input" name="section_titles[]" placeholder="Enter section title (e.g., Requirements, Procedures)" style="max-width: 400px;">' +
      '</div>' +
      '<button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">' +
      '<i class="fas fa-trash"></i> Remove' +
      '</button>' +
      '</div>' +
      '<div class="card-body">' +
      '<div class="mb-3">' +
      '<label class="form-label" style="font-weight: 600; color: #334155; margin-bottom: 12px;">Items</label>' +
      '<div class="items-list">' +
      '<div class="item-row">' +
      '<div class="input-group">' +
      '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
      '<input type="text" class="form-control" name="section_items[' + sectionIndex + '][]" placeholder="Enter item text">' +
      '<button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">' +
      '<i class="fas fa-trash"></i>' +
      '</button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '<button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this, ' + sectionIndex + ')">' +
      '<i class="fas fa-plus"></i> Add New Item' +
      '</button>' +
      '</div>';

    container.appendChild(newSection);
    newSection.querySelector('.section-title-input').focus();
  }

  function removeSectionDynamic(button) {
    var section = button.closest('.dynamic-section');
    var container = document.getElementById('dynamicSectionsContainer');

    if (container.querySelectorAll('.dynamic-section').length <= 1) {
      alert('You must have at least one section');
      return;
    }

    if (confirm('Are you sure you want to remove this entire section?')) {
      section.remove();
    }
  }

  // Form validation before submit
  document.getElementById('activityForm').addEventListener('submit', function(e) {
    const title = this.querySelector('input[name="title"]').value.trim();
    const objectives = this.querySelector('textarea[name="objectives"]').value.trim();
    const shortDescription = this.querySelector('textarea[name="short_description"]').value.trim();
    const description = this.querySelector('textarea[name="description"]').value.trim();
    const type = this.querySelector('select[name="type"]').value;
    const status = this.querySelector('select[name="status"]').value;

    if (title.length === 0) {
      e.preventDefault();
      alert('Please enter an activity title');
      this.querySelector('input[name="title"]').focus();
      return false;
    }

    if (objectives.length === 0) {
      e.preventDefault();
      alert('Please enter activity objectives');
      this.querySelector('textarea[name="objectives"]').focus();
      return false;
    }

    if (shortDescription.length === 0) {
      e.preventDefault();
      alert('Please enter a short description');
      this.querySelector('textarea[name="short_description"]').focus();
      return false;
    }

    if (description.length === 0) {
      e.preventDefault();
      alert('Please enter a detailed description');
      this.querySelector('textarea[name="description"]').focus();
      return false;
    }

    if (type === '') {
      e.preventDefault();
      alert('Please select an activity type');
      this.querySelector('select[name="type"]').focus();
      return false;
    }

    if (status === '') {
      e.preventDefault();
      alert('Please select a status');
      this.querySelector('select[name="status"]').focus();
      return false;
    }
  });
</script>

<?php require './components/footer.php'; ?>