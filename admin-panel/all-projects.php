<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Projects';
require './components/header.php';
protectPage();

// Get all activities from database
$activities = getAllActivities();

// Calculate statistics from actual database data
$totalActivities = count($activities);
$activeCount = getActivityCount('Active');
$expiredCount = getActivityCount('Expired');

// Count by type
$regularCount = getActivityCountByType('Regular');
$financialCount = getActivityCountByType('Financial');
$socialCount = getActivityCountByType('Social');
?>

<style>
  /* Statistics Cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
  }

  .stat-card-modern {
    position: relative;
    padding: 28px;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .stat-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .stat-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .stat-card-modern:hover::before {
    opacity: 1;
  }

  .stat-card-modern.total { --gradient-start: #8b5cf6; --gradient-end: #7c3aed; }
  .stat-card-modern.active { --gradient-start: #10b981; --gradient-end: #059669; }
  .stat-card-modern.expired { --gradient-start: #ef4444; --gradient-end: #dc2626; }
  .stat-card-modern.regular { --gradient-start: #3b82f6; --gradient-end: #2563eb; }

  .stat-content-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .stat-info h3 {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 8px 0 0 0;
    line-height: 1;
  }

  .stat-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .stat-icon-modern {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
  }

  .stat-card-modern:hover .stat-icon-modern {
    transform: rotate(10deg) scale(1.1);
  }

  .stat-icon-modern i {
    font-size: 28px;
    color: #fff;
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #10b981, #059669);
    padding: 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
  }

  .page-header h1 {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
  }

  .page-header .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    transition: color 0.3s ease;
  }

  .page-header .breadcrumb-item a:hover {
    color: white;
  }

  .page-header .breadcrumb-item.active {
    color: white;
  }

  .page-header .breadcrumb-item+.breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
  }

  .btn-add-new {
    background: #000;
    color: #fff;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-add-new:hover {
    background: #fff;
    color: #000;
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
  }

  /* Filter Card */
  .filter-section {
    background: #fff;
    padding: 28px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin-bottom: 32px;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .filter-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f1f5f9;
  }

  .filter-header i {
    font-size: 20px;
    color: #8b5cf6;
  }

  .filter-header h5 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
  }

  .search-input-wrapper {
    position: relative;
  }

  .search-input-wrapper i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
  }

  .search-input-wrapper input {
    width: 100%;
    padding: 14px 18px 14px 48px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.3s ease;
  }

  .search-input-wrapper input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
  }

  .filter-select {
    width: 100%;
    padding: 12px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    color: #1e293b;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 20px;
    background-color: #fff;
    padding-right: 45px;
  }

  .filter-select:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
  }

  /* Activity Cards */
  .activity-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .activity-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--accent-color), var(--accent-color-dark));
  }

  .activity-card:hover {
    transform: translateX(4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  }

  .activity-card.status-Active { --accent-color: #10b981; --accent-color-dark: #059669; }
  .activity-card.status-Expired { --accent-color: #ef4444; --accent-color-dark: #dc2626; }

  .activity-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 16px;
    gap: 16px;
  }

  .activity-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .activity-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 16px;
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #64748b;
  }

  .meta-item i {
    color: #8b5cf6;
    font-size: 14px;
  }

  .activity-description {
    color: #475569;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 16px;
  }

  .activity-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
  }

  .activity-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .badge-modern {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .badge-active {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }

  .badge-expired {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }

  .badge-type {
    background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
    color: #6b21a8;
    padding: 5px 10px;
    border-radius: 50px;
  }

  .activity-actions {
    display: flex;
    gap: 8px;
  }

  .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    flex-shrink: 0;
  }

  .btn-view {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }

  .btn-edit {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .btn-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }

  .btn-action:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
  }
.message-box {
  position: relative;
}

.message-box .close-btn {
  position: absolute;
  top: 10px;
  right: 12px;
  background: transparent;
  border: none;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  color: inherit;
  opacity: 0.6;
}

.message-box .close-btn:hover {
  opacity: 1;
}
  /* Message Box */
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

  .message-box.info {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #bfdbfe;
  }

  .message-box i {
    font-size: 18px;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
  }

  .empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .empty-state-icon i {
    font-size: 36px;
    color: #94a3b8;
  }

  .empty-state h3 {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .empty-state p {
    color: #64748b;
    font-size: 16px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .stat-info h3 {
      font-size: 28px;
    }

    .stat-icon-modern {
      width: 50px;
      height: 50px;
    }

    .stat-icon-modern i {
      font-size: 22px;
    }

    .activity-header {
      flex-direction: column;
    }

    .activity-footer {
      flex-direction: column;
      gap: 12px;
      align-items: flex-start;
    }
  }

  /* Animation */
  @keyframes fadeInCard {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .activity-card {
    animation: fadeInCard 0.5s ease;
  }
</style>
<!-- Add SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="dashboard">

    <!-- Page Header -->
    <div class="page-header">
      <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
          <div>
            <h1><i class="fa-solid fa-calendar-days me-2"></i>All Projects</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Projects</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="d-flex gap-2">
          <a class="btn btn-add-new" href="add-project.php">
            <i class="fa-solid fa-plus me-2"></i>Add New Project
          </a>
        </div>
      </div>
    </div>

    <?php
    // Display success/error messages
    if (isset($_GET['success']) && $_GET['success'] == '1') {
echo '<div class="message-box success">
        <i class="fa-solid fa-circle-check"></i>
        Project operation completed successfully!
        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
      </div>';
    }
    
    if (isset($_GET['error'])) {
        echo '<div class="message-box error">
                <i class="fa-solid fa-circle-exclamation"></i>
                Error: ' . htmlspecialchars($_GET['error']) . '
              </div>';
    }
    
    // Show info if no activities
    if ($totalActivities === 0) {
        echo '<div class="message-box info">
                <i class="fa-solid fa-circle-info"></i>
                No activities found. <a href="add-project.php">Create your first project</a>.
              </div>';
    }
    ?>

    <!-- Statistics Grid -->
    <div class="stats-grid">
      <div class="stat-card-modern total">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Total Projects</div>
            <h3><?= $totalActivities ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-calendar-days"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern active">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Active</div>
            <h3><?= $activeCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-circle-check"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern expired">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Expired</div>
            <h3><?= $expiredCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-circle-xmark"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern regular">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Regular</div>
            <h3><?= $regularCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-tag"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-header">
        <i class="fa-solid fa-filter"></i>
        <h5>Filters & Search</h5>
      </div>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search projects..." id="searchInput">
          </div>
        </div>
        <div class="col-md-3">
          <select class="filter-select" id="statusFilter">
            <option value="all">All Status</option>
            <option value="Active">Active</option>
            <option value="Expired">Expired</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="filter-select" id="typeFilter">
            <option value="all">All Types</option>
            <option value="Regular">Regular</option>
            <option value="Financial">Financial</option>
            <option value="Social">Social</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="filter-select" id="sortFilter">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Activities List -->
    <div id="activitiesList">
      <?php if ($totalActivities > 0): ?>
        <?php foreach ($activities as $activity): 
          // Determine badge colors based on status
          $statusClass = '';
          $statusBadgeClass = '';
          
          if ($activity['status'] === 'Active') {
              $statusClass = 'status-Active';
              $statusBadgeClass = 'badge-active';
          } elseif ($activity['status'] === 'Expired') {
              $statusClass = 'status-Expired';
              $statusBadgeClass = 'badge-expired';
          }
        ?>
        <div class="activity-card <?= $statusClass ?>" 
             data-title="<?= strtolower($activity['title']) ?>"
             data-status="<?= $activity['status'] ?>"
             data-type="<?= $activity['type'] ?>"
             data-created="<?= $activity['created_at'] ?>">
          <div class="activity-header">
            <div>
              <h4 class="activity-title"><?= htmlspecialchars($activity['title']) ?></h4>
              <div class="activity-meta">
                <div class="meta-item">
                  <i class="fa-solid fa-calendar"></i>
                  <span>Created: <?= date('M d, Y', strtotime($activity['created_at'])) ?></span>
                </div>
                <div class="meta-item">
                  <i class="fa-solid fa-tag"></i>
                  <span><?= htmlspecialchars($activity['type']) ?></span>
                </div>
                <?php if (!empty($activity['slug'])): ?>
                <div class="meta-item">
                  <i class="fa-solid fa-link"></i>
                  <span class="text-muted" style="font-size: 12px;"><?= htmlspecialchars($activity['slug']) ?></span>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <p class="activity-description">
            <?= htmlspecialchars($activity['short_description']) ?>
          </p>
          <div class="activity-footer">
            <div class="activity-badges">
              <span class="badge-modern <?= $statusBadgeClass ?>">
                <i class="fa-solid fa-<?= $activity['status'] === 'Active' ? 'circle-check' : 'circle-xmark' ?> me-1"></i>
                <?= htmlspecialchars($activity['status']) ?>
              </span>
              <span class="badge-modern badge-type"><?= htmlspecialchars($activity['type']) ?></span>
            </div>
            <div class="activity-actions">
              <?php if (!empty($activity['slug'])): ?>
                <a href="view-project.php?slug=<?= urlencode($activity['slug']) ?>" class="btn-action btn-view" title="View">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a href="edit-project.php?slug=<?= urlencode($activity['slug']) ?>" class="btn-action btn-edit" title="Edit">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <button class="btn-action btn-delete btn-delete-activity" 
                        title="Delete"
                        data-slug="<?= htmlspecialchars($activity['slug']) ?>"
                        data-title="<?= htmlspecialchars($activity['title']) ?>">
                  <i class="fa-solid fa-trash"></i>
                </button>
              <?php else: ?>
                <!-- Fallback: Show warning if no slug exists -->
                <span class="text-warning" title="No slug available">
                  <i class="fa-solid fa-exclamation-triangle"></i>
                </span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fa-solid fa-inbox"></i>
          </div>
          <h3>No projects found</h3>
          <p>Start by adding your first project</p>
          <a href="add-project.php" class="btn btn-add-new mt-3">
            <i class="fa-solid fa-plus me-2"></i>Add Project
          </a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<!-- Add SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtering functionality
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const statusFilter = document.getElementById("statusFilter");
    const sortFilter = document.getElementById("sortFilter");
    const cards = document.querySelectorAll(".activity-card");

    function filterCards() {
        const search = searchInput.value.toLowerCase();
        const type = typeFilter.value;
        const status = statusFilter.value;

        cards.forEach(card => {
            const title = card.dataset.title;
            const cardType = card.dataset.type;
            const cardStatus = card.dataset.status;
            let visible = true;

            if (search && !title.includes(search)) visible = false;
            if (type !== "all" && cardType !== type) visible = false;
            if (status !== "all" && cardStatus !== status) visible = false;

            card.style.display = visible ? "" : "none";
        });
    }

    function sortCards() {
        const sortValue = sortFilter.value;
        const container = document.getElementById("activitiesList");
        const cardsArr = Array.from(cards);

        cardsArr.sort((a, b) => {
            const aDate = new Date(a.dataset.created);
            const bDate = new Date(b.dataset.created);
            
            if (sortValue === "oldest") {
                return aDate - bDate;
            }
            // newest first (default)
            return bDate - aDate;
        });

        // Reorder cards in the DOM
        cardsArr.forEach(card => container.appendChild(card));
    }

    // SweetAlert Delete Confirmation
    const deleteButtons = document.querySelectorAll('.btn-delete-activity');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const slug = this.dataset.slug;
            const title = this.dataset.title;
            
            // Only proceed if slug exists
            if (!slug) {
                Swal.fire({
                    title: 'Error',
                    text: 'This project does not have a slug and cannot be deleted.',
                    icon: 'error',
                    confirmButtonColor: '#6b7280'
                });
                return;
            }
            
            const deleteUrl = `delete-project.php?slug=${encodeURIComponent(slug)}`;
            
            Swal.fire({
                title: 'Are you sure?',
                html: `<div style="text-align: center;">
                          <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                          <p>You are about to delete the project:</p>
                          <p><strong>"${title}"</strong></p>
                          <p class="text-muted" style="font-size: 12px;">Slug: ${slug}</p>
                          <p class="text-danger">This action cannot be undone!</p>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        window.location.href = deleteUrl;
                        resolve();
                    });
                }
            });
        });
    });

    // Event listeners for filters
    [searchInput, typeFilter, statusFilter].forEach(el => el.addEventListener("input", filterCards));
    sortFilter.addEventListener("change", sortCards);
});
</script>

<?php require './components/footer.php'; ?>


