<?php 
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Add Notice'; 
?>
<?php require './components/header.php'; ?>

<div class="content-wrapper">
  <h3 class="page-title my-5">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-bulletin-board"></i>
    </span>
    Add New Notice
  </h3>

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="create-notice">
        <div class="">
          <h1 class="create-notice-title">Create New Notice</h1>
          <form action="" method="post">

            <!-- Title -->
            <div class="form-group mt-3">
              <label>Title</label>
              <input type="text" name="title" placeholder="Notice Title" required>
            </div>

            <!-- Publishing Date -->
            <div class="form-group mt-3">
              <label>Publishing Date</label>
              <input type="date" name="publish_date" class="form-control datepicker" placeholder="Pick a Date" required>
            </div>

            <!-- Duration in months -->
            <div class="form-group mt-3">
              <label>Duration (Months)</label>
              <input type="number" name="duration" placeholder="Duration in months" min="1" required>
            </div>

            <!-- Type -->
            <div class="form-group mt-3">
              <label>Type</label>
              <select name="type" required>
                <option value="">Select Type</option>
                <option value="General">General</option>
                <option value="Urgent">Urgent</option>
                <option value="Info">Info</option>
              </select>
            </div>

            <!-- Age Limit -->
            <div class="form-group mt-3">
              <label>Age Limit</label>
              <input type="number" name="age_limit" placeholder="Age limit" min="0">
            </div>

            <!-- Category -->
            <div class="form-group mt-3">
              <label>Category</label>
              <select name="category" required>
                <option value="">Select Category</option>
                <option value="Education">Education</option>
                <option value="Health">Health</option>
                <option value="Events">Events</option>
              </select>
            </div>

            <!-- Status (Active/Expired) -->
            <div class="form-group mt-3">
              <label>Status</label>
              <select name="status" required>
                <option value="">Select Status</option>
                <option value="Active">Active</option>
                <option value="Expired">Expired</option>
              </select>
            </div>

            <!-- Description with Type -->
            <div class="form-group mt-3">
              <label>Description (Type: Notice Details)</label>
              <textarea name="description" rows="5" placeholder="Write the notice description..." required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-4 text-end">
              <button type="submit" class="btn btn-submit">Add Notice</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require './components/footer.php'; ?>