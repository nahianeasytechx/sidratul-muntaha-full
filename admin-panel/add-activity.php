<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Add Notice';
?>
<?php require './components/header.php'; ?>

<style>
  .input-group-text {
    background: #f7f7f7;
    margin-top: 8px;
    height: 50px;
    border: 1px solid #ccc;
  }
</style>

<div class="content-wrapper">
  <h3 class="page-title my-5">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-bell-ring"></i>
    </span> Add New Activity
  </h3>

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="create-notice">
        <div class="">
          <h1 class="create-notice-title">Create New Activity</h1>
          <form action="" method="post">

            <!-- Title -->
            <div class="form-group mt-3">
              <label>Title</label>
              <input type="text" name="title" placeholder="Activity Title" required>
            </div>

            <!-- Type -->
            <div class="form-group mt-3">
              <label>Type</label>
              <select name="type" required>
                <option value="">Select Type</option>
                <option value="Regular">Regular</option>
                <option value="Financial">Financial</option>
                <option value="Social">Social</option>
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

            <!-- Image -->
            <div class="form-group mt-3">
              <label>Image:</label>
              <input type="file" name="image" accept="image/*">
            </div>

            <!-- Objectives -->
            <div class="form-group mt-3">
              <label>Objectives (Type: Activity Goals)</label>
              <textarea name="objectives" rows="2" placeholder="Write the objectives here..." required></textarea>
            </div>

            <!-- Short Description -->
            <div class="form-group mt-3">
              <label>Short Description</label>
              <textarea name="short_description" rows="2" placeholder="Write the activity short description..." required></textarea>
            </div>

            <!-- Description -->
            <div class="form-group mt-3">
              <label>Description (Type: Detailed Information)</label>
              <textarea name="description" rows="5" placeholder="Write the activity detailed description..." required></textarea>
            </div>

            <!-- Add List Section -->
            <div class="form-group mt-4">
              <label style="font-weight: 600; font-size: 16px; display: block; margin-bottom: 15px;">Add List Sections</label>

              <div id="dynamicSectionsContainer">
                <div class="card shadow-sm mb-4 dynamic-section" data-section-id="1">
                  <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                      <span class="input-group-text"> <i class="fas fa-list"></i></span>
                      <input type="text" class="form-control form-control-sm section-title-input" name="section_title_1" value="" placeholder="Enter section title (e.g., Requirements, Procedures)" style="max-width: 300px;">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">
                      <i class="fas fa-trash"></i> Remove Section
                    </button>
                  </div>
                  <div class="card-body p-4">
                    <div class="mb-3">
                      <label class="form-label">Items</label>
                      <div class="items-list">
                        <div class="item-row mb-2">
                          <div class="input-group d-flex">
                            <span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>
                            <input type="text" class="form-control" name="section_1_items[]" placeholder="Enter item text">
                            <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this)">
                      <i class="fas fa-plus"></i> Add New Item
                    </button>
                  </div>
                </div>
              </div>

              <button type="button" class="btn btn-primary" onclick="addNewSectionDynamic()">
                <i class="fas fa-plus"></i> Add New Section
              </button>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-4 text-end">
              <button type="submit" class="btn btn-submit">Add Activity</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var activitySectionCounter = 2;

  function addNewItemDynamic(button) {
    var section = button.closest('.dynamic-section');
    var sectionId = section.getAttribute('data-section-id');
    var itemsList = section.querySelector('.items-list');

    var newItem = document.createElement('div');
    newItem.className = 'item-row mb-2';
    newItem.innerHTML = '<div class="input-group d-flex">' +
      '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
      '<input type="text" class="form-control" name="section_' + sectionId + '_items[]" placeholder="Enter item text">' +
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
    var container = document.getElementById('dynamicSectionsContainer');

    var newSection = document.createElement('div');
    newSection.className = 'card shadow-sm mb-4 dynamic-section';
    newSection.setAttribute('data-section-id', activitySectionCounter);
    newSection.innerHTML = '<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">' +
      '<div class="d-flex align-items-center gap-2 flex-grow-1">' +
      '<i class="fas fa-list"></i>' +
      '<input type="text" class="form-control form-control-sm section-title-input" name="section_title_' + activitySectionCounter + '" value="" placeholder="Enter section title (e.g., Requirements, Procedures)" style="max-width: 300px;">' +
      '</div>' +
      '<button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">' +
      '<i class="fas fa-trash"></i> Remove Section' +
      '</button>' +
      '</div>' +
      '<div class="card-body p-4">' +
      '<div class="mb-3">' +
      '<label class="form-label">Items</label>' +
      '<div class="items-list">' +
      '<div class="item-row mb-2">' +
      '<div class="input-group d-flex">' +
      '<span class="input-group-text"><i class="fas fa-circle-check text-success"></i></span>' +
      '<input type="text" class="form-control" name="section_' + activitySectionCounter + '_items[]" placeholder="Enter item text">' +
      '<button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">' +
      '<i class="fas fa-trash"></i>' +
      '</button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '<button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this)">' +
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
</script>

<?php require './components/footer.php'; ?>