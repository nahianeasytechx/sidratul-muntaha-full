<?php 
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Add Notice'; 
require './components/header.php';
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
    color:linear-gradient(135deg, #10b981, #059669);;
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
    border-color: #8b5cf6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
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
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
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
    box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
  }

  .btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(139, 92, 246, 0.4);
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

  .input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color:linear-gradient(135deg, #10b981, #059669);;
    pointer-events: none;
  }

  .has-icon .modern-input,
  .has-icon .modern-select {
    padding-left: 45px;
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

          <!-- Form -->
          <form action="" method="post" id="noticeForm">

            <!-- Title -->
            <div class="modern-form-group">
              <label><i class="fa-solid fa-heading"></i> Notice Title</label>
              <input type="text" name="title" class="modern-input" placeholder="Enter notice title..." required>
            </div>

            <!-- Publishing Date & Duration -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-calendar"></i> Publishing Date</label>
                <input type="date" name="publish_date" class="modern-input" required>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-clock"></i> Duration (Months)</label>
                <input type="number" name="duration" class="modern-input" placeholder="e.g., 6" min="1" required>
              </div>
            </div>

            <!-- Type & Age Limit -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-tag"></i> Notice Type</label>
                <select name="type" class="modern-select" required>
                  <option value="">Select Type</option>
                  <option value="General">General</option>
                  <option value="Urgent">Urgent</option>
                  <option value="Info">Information</option>
                  <option value="Announcement">Announcement</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-user-clock"></i> Age Limit</label>
                <input type="number" name="age_limit" class="modern-input" placeholder="e.g., 18" min="0">
              </div>
            </div>

            <!-- Category & Status -->
            <div class="form-row">
              <div class="modern-form-group">
                <label><i class="fa-solid fa-folder"></i> Category</label>
                <select name="category" class="modern-select" required>
                  <option value="">Select Category</option>
                  <option value="Education">Education</option>
                  <option value="Scholarship">Scholarship</option>
                  <option value="Health">Health</option>
                  <option value="Events">Events</option>
                  <option value="General">General</option>
                </select>
              </div>

              <div class="modern-form-group">
                <label><i class="fa-solid fa-toggle-on"></i> Status</label>
                <select name="status" class="modern-select" required>
                  <option value="">Select Status</option>
                  <option value="Active" selected>Active</option>
                  <option value="Expired">Expired</option>
                  <option value="Draft">Draft</option>
                </select>
              </div>
            </div>

            <!-- Description -->
            <div class="modern-form-group" style="position: relative;">
              <label><i class="fa-solid fa-align-left"></i> Description</label>
              <textarea name="description" class="modern-textarea" placeholder="Write the notice description here..." required id="descriptionField"></textarea>
              <span class="char-counter" id="charCounter">0 / 500</span>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
              <button type="button" class="btn-cancel" onclick="window.history.back()">
                <i class="fa-solid fa-times"></i> Cancel
              </button>
              <button type="submit" class="btn-submit">
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
</script>

<?php require './components/footer.php'; ?>