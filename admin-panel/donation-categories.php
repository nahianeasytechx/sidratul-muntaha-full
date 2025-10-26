<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Donation Categories'; 

// Dummy data
$categories = [
    [
        'id' => 1,
        'title' => 'Education Support',
        'image' => 'https://via.placeholder.com/400x300/4CAF50/ffffff?text=Education',
        'description' => 'Help provide quality education to underprivileged children. Your donation will help buy books, stationery, and educational materials.',
        'created_at' => '2024-01-15'
    ],
    [
        'id' => 2,
        'title' => 'Medical Emergency',
        'image' => 'https://via.placeholder.com/400x300/FF5722/ffffff?text=Medical',
        'description' => 'Support medical treatments for those who cannot afford healthcare. Every contribution saves lives and brings hope.',
        'created_at' => '2024-02-20'
    ],
    [
        'id' => 3,
        'title' => 'Food Distribution',
        'image' => 'https://via.placeholder.com/400x300/FF9800/ffffff?text=Food',
        'description' => 'Fight hunger by providing nutritious meals to families in need. Join us in making sure no one goes to bed hungry.',
        'created_at' => '2024-03-10'
    ],
    [
        'id' => 4,
        'title' => 'Clean Water Projects',
        'image' => 'https://via.placeholder.com/400x300/2196F3/ffffff?text=Water',
        'description' => 'Bring clean drinking water to communities lacking access. Help us build wells and water purification systems.',
        'created_at' => '2024-03-25'
    ],
    [
        'id' => 5,
        'title' => 'Orphan Care',
        'image' => 'https://via.placeholder.com/400x300/9C27B0/ffffff?text=Orphan+Care',
        'description' => 'Provide shelter, education, and care for orphaned children. Give them a chance at a brighter future.',
        'created_at' => '2024-04-05'
    ],
    [
        'id' => 6,
        'title' => 'Disaster Relief',
        'image' => 'https://via.placeholder.com/400x300/F44336/ffffff?text=Disaster+Relief',
        'description' => 'Support communities affected by natural disasters. Help provide emergency supplies, shelter, and rebuilding efforts.',
        'created_at' => '2024-04-18'
    ]
];

$message = '';
$message_type = '';
$edit_category = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $message = 'Category added successfully! (Demo Mode)';
        $message_type = 'success';
    } elseif (isset($_POST['update_category'])) {
        $message = 'Category updated successfully! (Demo Mode)';
        $message_type = 'success';
    }
}

if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    foreach ($categories as $cat) {
        if ($cat['id'] == $edit_id) {
            $edit_category = $cat;
            break;
        }
    }
}

if (isset($_GET['delete'])) {
    $message = 'Category deleted successfully! (Demo Mode)';
    $message_type = 'success';
}
?>
<?php require './components/header.php'; ?>

<div class="content-wrapper">
  <div class="container-fluid">
    
    <!-- Alerts -->
    <?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show mt-4" role="alert">
      <?php echo $message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row mt-4">
      
      <!-- Add/Edit Form -->
      <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm rounded-3">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4">
              <b><?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?></b>
            </h3>

            <form action="" method="post" enctype="multipart/form-data">
              <?php if ($edit_category): ?>
                <input type="hidden" name="category_id" value="<?php echo $edit_category['id']; ?>">
              <?php endif; ?>

              <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Category Title</label>
                <input type="text" name="title" id="title" class="form-control"
                       placeholder="Enter category title"
                       value="<?php echo $edit_category ? htmlspecialchars($edit_category['title']) : ''; ?>" required>
              </div>

              <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Category Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*"
                       <?php echo $edit_category ? '' : 'required'; ?>>
                <small class="text-muted">JPG, PNG, WEBP (max 2MB)</small>
                <?php if ($edit_category && $edit_category['image']): ?>
                <div class="mt-2">
                  <img src="<?php echo $edit_category['image']; ?>" class="img-thumbnail" style="max-width: 140px;">
                </div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" rows="4" class="form-control"
                          placeholder="Write a short description..." required><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
              </div>

              <div class="text-center mt-4">
                <button type="submit" name="<?php echo $edit_category ? 'update_category' : 'add_category'; ?>" 
                        class="btn btn-gradient-dark px-4 fw-semibold">
                  <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                </button>
                <?php if ($edit_category): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary px-3 fw-semibold">Cancel</a>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Category List -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4">
              <b>All Categories</b>
            </h3>

            <div class="table-responsive">
              <table class="table align-middle table-hover">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th colspan="3" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($categories as $index => $category): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img src="<?php echo $category['image']; ?>" alt="" class="rounded" width="55" height="55" style="object-fit:cover;"></td>
                    <td class="fw-semibold"><?php echo htmlspecialchars($category['title']); ?></td>
                    <td><small><?php echo date('M d, Y', strtotime($category['created_at'])); ?></small></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#descModal<?php echo $category['id']; ?>">
                        <i class="mdi mdi-eye"></i>
                      </button>
                    </td>
                    <td>
                      <a href="?edit=<?php echo $category['id']; ?>" class="btn btn-sm btn-outline-info me-1">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </td>
                    <td>
                      <a href="?delete=<?php echo $category['id']; ?>" class="btn btn-sm btn-outline-danger"
                         onclick="return confirm('Are you sure you want to delete this category?')">
                        <i class="mdi mdi-delete"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Description Modal -->
                  <div class="modal fade" id="descModal<?php echo $category['id']; ?>" tabindex="-1" aria-labelledby="descLabel<?php echo $category['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content rounded-3 border-0 shadow-sm">
                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title" id="descLabel<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['title']); ?>
                          </h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <img src="<?php echo $category['image']; ?>" class="img-fluid rounded mb-3" alt="">
                          <p class="text-muted"><?php echo htmlspecialchars($category['description']); ?></p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
.table td, .table th { vertical-align: middle; }
.btn-outline-primary, .btn-outline-info, .btn-outline-danger {
  border-radius: 8px;
}
.card {
  border-radius: 12px;
}
</style>

<?php require './components/footer.php'; ?>