<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Edit Donation Category'; 
?>
<?php require './components/header.php'; ?>

<div class="content-wrapper">
  <h3 class="page-title my-5">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-pencil-box"></i>
    </span>
    Edit Donation Category
  </h3>

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="edit-donation-category">
        <div class="">
          <h1 class="edit-donation-category-title mb-4">Update Donation Category</h1>

          <form action="" method="post" enctype="multipart/form-data">
            
            <!-- Current Image Preview -->
            <div class="form-group mt-3">
              <label>Current Category Image</label>
              <div class="mb-2">
                <img src="images/sample-category.jpg" alt="Category Image" class="img-thumbnail" style="max-width: 200px;">
              </div>
              <label for="image">Change Image (optional)</label>
              <input type="file" name="image" id="image" class="form-control" accept="image/*">
              <small class="form-text text-muted">Upload new image if you want to replace the current one.</small>
            </div>

            <!-- Title -->
            <div class="form-group mt-3">
              <label for="title">Category Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter donation category title" value="Sample Category" required>
            </div>

            <!-- Description -->
            <div class="form-group mt-3">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="form-control" rows="5" placeholder="Write about this donation category..." required>Sample description of this donation category.</textarea>
            </div>

            <!-- Target Amount -->
            <div class="form-group mt-3">
              <label for="target_amount">Target Amount (৳)</label>
              <input type="number" name="target_amount" id="target_amount" class="form-control" placeholder="Enter target donation amount" value="50000" min="0" required>
            </div>

            <!-- Status -->
            <div class="form-group mt-3">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-4 text-end">
              <button type="submit" class="btn btn-submit">Update Category</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require './components/footer.php'; ?>
