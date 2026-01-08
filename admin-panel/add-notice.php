<?php
$page_title = 'Add Notice';
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
    padding: 9px 18px;
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
    min-height: 140px;
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

  .char-counter {
    position: absolute;
    right: 12px;
    bottom: 12px;
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
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

  .modern-form-group:nth-child(1) {
    animation-delay: 0.1s;
  }

  .modern-form-group:nth-child(2) {
    animation-delay: 0.15s;
  }

  .modern-form-group:nth-child(3) {
    animation-delay: 0.2s;
  }

  .modern-form-group:nth-child(4) {
    animation-delay: 0.25s;
  }

  .modern-form-group:nth-child(5) {
    animation-delay: 0.3s;
  }

  .modern-form-group:nth-child(6) {
    animation-delay: 0.35s;
  }

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
        <i class="fa-solid fa-bullhorn text"></i>
      </div>
      <h1>Add New Notice</h1>
    </div>

    <!-- Form Container -->
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="notice-form-container">

          <!-- Form Header -->
          <div class="form-header">
            <h1>Create New Notice</h1>
            <p>Fill in the details below to publish a new notice</p>
          </div>

          <?php
          // Handle form submission
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $publish_date = $_POST['publish_date'];
            $duration = intval($_POST['duration']);
            $type = $_POST['type'];
            $age_limit = isset($_POST['age_limit']) && !empty($_POST['age_limit']) ? intval($_POST['age_limit']) : null;
            $category = $_POST['category'];
            $status = $_POST['status'];

            // Validate required fields
            if (empty($title) || empty($description) || empty($publish_date) || empty($duration) || empty($type) || empty($category) || empty($status)) {
              echo '<div class="message-box error">
                          <i class="fa-solid fa-circle-exclamation"></i>
                          All required fields must be filled!
                        </div>';
            } else {
              // Prepare data array
              $noticeData = [
                'title' => $title,
                'description' => $description,
                'publish_date' => $publish_date,
                'duration' => $duration,
                'type' => $type,
                'category' => $category,
                'status' => $status
              ];

              // Add age_limit only if provided
              if ($age_limit !== null && $age_limit > 0) {
                $noticeData['age_limit'] = $age_limit;
              }

              // Create notice using your function
              $result = createNotice($noticeData);

              if ($result['success']) {
                echo '<div class="message-box success">
                              <i class="fa-solid fa-circle-check"></i>
                              Notice created successfully!' .  '
                            </div>';

                // Clear form after successful submission
                echo '<script>
                              setTimeout(function() {
                                  document.getElementById("noticeForm").reset();
                              }, 1000);
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
          <form action="" method="post" id="noticeForm">

            <!-- Title -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-heading"></i> Notice Title</label>
              <input type="text" name="title" class="modern-input" placeholder="Enter notice title..." required
                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>

            <!-- Publishing Date & Duration -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-calendar"></i> Publishing Date</label>
                <input type="date" name="publish_date" class="modern-input" required
                  value="<?php echo isset($_POST['publish_date']) ? htmlspecialchars($_POST['publish_date']) : ''; ?>">
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-clock"></i> Duration (Months)</label>
                <input type="number" name="duration" class="modern-input" placeholder="e.g., 6" min="1" required
                  value="<?php echo isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : ''; ?>">
              </div>
            </div>

            <!-- Type & Age Limit -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-tag"></i> Notice Type</label>
                <select name="type" class="modern-select" required>
                  <option value="">Select Type</option>
                  <option value="General" <?php echo (isset($_POST['type']) && $_POST['type'] == 'General') ? 'selected' : ''; ?>>General</option>
                  <option value="Urgent" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Urgent') ? 'selected' : ''; ?>>Urgent</option>
                  <option value="Info" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Info') ? 'selected' : ''; ?>>Information</option>
                  <option value="Announcement" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Announcement') ? 'selected' : ''; ?>>Announcement</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-user-clock"></i> Age Limit (Optional)</label>
                <input type="number" name="age_limit" class="modern-input" placeholder="e.g., 18" min="0"
                  value="<?php echo isset($_POST['age_limit']) ? htmlspecialchars($_POST['age_limit']) : ''; ?>">
              </div>
            </div>

            <!-- Category & Status -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-folder"></i> Category</label>
                <select name="category" class="modern-select" required>
                  <option value="">Select Category</option>
                  <option value="Education" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Education') ? 'selected' : ''; ?>>Education</option>
                  <option value="Scholarship" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Scholarship') ? 'selected' : ''; ?>>Scholarship</option>
                  <option value="Health" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Health') ? 'selected' : ''; ?>>Health</option>
                  <option value="Events" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Events') ? 'selected' : ''; ?>>Events</option>
                  <option value="General" <?php echo (isset($_POST['category']) && $_POST['category'] == 'General') ? 'selected' : ''; ?>>General</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-toggle-on"></i> Status</label>
                <select name="status" class="modern-select" required>
                  <option value="">Select Status</option>
                  <option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Active') ? 'selected' : 'selected'; ?>>Active</option>
                  <option value="Expired" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Expired') ? 'selected' : ''; ?>>Expired</option>
                  <option value="Draft" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
              </div>
            </div>

            <!-- Description -->
            <div class="modern-form-group" style="position: relative;">
              <label><i class="fa-solid fa-align-left"></i> Description</label>
              <textarea name="description" class="modern-textarea" placeholder="Write the notice description here..." required id="descriptionField"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
              <span class="char-counter" id="charCounter">0 / 500</span>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
              <button type="button" class="btn-cancel" onclick="window.history.back()">
                <i class="fa-solid fa-times"></i> Cancel
              </button>
              <button type="submit" class="btn-submit" name="submit_notice">
                <i class="fa-solid fa-paper-plane"></i> Publish Notice
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
  // Character counter for description
  const descField = document.getElementById('descriptionField');
  const charCounter = document.getElementById('charCounter');

  // Initialize counter
  charCounter.textContent = `${descField.value.length} / 500`;

  descField.addEventListener('input', function() {
    const length = this.value.length;
    charCounter.textContent = `${length} / 500`;

    if (length > 500) {
      charCounter.style.color = '#ef4444';
    } else if (length > 400) {
      charCounter.style.color = '#f59e0b';
    } else {
      charCounter.style.color = '#94a3b8';
    }
  });

  // Set minimum date to today
  const dateInput = document.querySelector('input[type="date"]');
  const today = new Date().toISOString().split('T')[0];
  dateInput.setAttribute('min', today);

  // Set default date to today if not already set
  if (!dateInput.value) {
    dateInput.value = today;
  }

  // Form validation before submit
  document.getElementById('noticeForm').addEventListener('submit', function(e) {
    const title = this.querySelector('input[name="title"]').value.trim();
    const description = this.querySelector('textarea[name="description"]').value.trim();

    if (title.length === 0) {
      e.preventDefault();
      alert('Please enter a notice title');
      this.querySelector('input[name="title"]').focus();
      return false;
    }

    if (description.length === 0) {
      e.preventDefault();
      alert('Please enter a notice description');
      this.querySelector('textarea[name="description"]').focus();
      return false;
    }

    if (description.length > 500) {
      e.preventDefault();
      alert('Description must be 500 characters or less');
      this.querySelector('textarea[name="description"]').focus();
      return false;
    }
  });
</script>

<?php require './components/footer.php'; ?>