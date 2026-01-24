<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Contact Submissions';
require './components/header.php';
protectPage();

// Get all contact submissions from database
$result = getAllContactSubmissions();
$submissions = $result['success'] ? $result['data'] : [];

// Calculate statistics from actual database data
$totalSubmissions = count($submissions);
$unreadCount = count(array_filter($submissions, fn($s) => ($s['status'] ?? 'unread') === 'unread'));
$readCount = count(array_filter($submissions, fn($s) => ($s['status'] ?? 'unread') === 'read'));
$todayCount = count(array_filter($submissions, fn($s) => date('Y-m-d', strtotime($s['created_at'])) === date('Y-m-d')));
?>

<!-- Add SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
  .stat-card-modern.unread { --gradient-start: #f59e0b; --gradient-end: #d97706; }
  .stat-card-modern.read { --gradient-start: #10b981; --gradient-end: #059669; }
  .stat-card-modern.today { --gradient-start: #3b82f6; --gradient-end: #2563eb; }

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
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    padding: 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
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

  /* Submission Cards */
  .submission-card {
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

  .submission-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--accent-color), var(--accent-color-dark));
  }

  .submission-card:hover {
    transform: translateX(4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  }

  .submission-card.status-unread { --accent-color: #f59e0b; --accent-color-dark: #d97706; }
  .submission-card.status-read { --accent-color: #10b981; --accent-color-dark: #059669; }

  .submission-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 16px;
    gap: 16px;
  }

  .submission-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .submission-meta {
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

  .submission-message {
    color: #475569;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 16px;
    padding: 16px;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 3px solid #8b5cf6;
  }

  .submission-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
  }

  .submission-badges {
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

  .badge-unread {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .badge-read {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }

  .submission-actions {
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

  .btn-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }

  .btn-action:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
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

    .submission-header {
      flex-direction: column;
    }

    .submission-footer {
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

  .submission-card {
    animation: fadeInCard 0.5s ease;
  }
</style>

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
            <h1><i class="fa-solid fa-envelope me-2"></i>Contact Submissions</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Submissions</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Display success/error messages
    if (isset($_GET['success']) && $_GET['success'] == '1') {
        echo '<div class="message-box success">
                <i class="fa-solid fa-circle-check"></i>
                Submission operation completed successfully!
              </div>';
    }
    
    if (isset($_GET['error'])) {
        echo '<div class="message-box error">
                <i class="fa-solid fa-circle-exclamation"></i>
                Error: ' . htmlspecialchars($_GET['error']) . '
              </div>';
    }
    
    // Show info if no submissions
    if ($totalSubmissions === 0) {
        echo '<div class="message-box info">
                <i class="fa-solid fa-circle-info"></i>
                No contact submissions yet.
              </div>';
    }
    ?>

    <!-- Statistics Grid -->
    <div class="stats-grid">
      <div class="stat-card-modern total">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Total Submissions</div>
            <h3><?= $totalSubmissions ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-envelope"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern unread">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Unread</div>
            <h3><?= $unreadCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-envelope-open"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern read">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Read</div>
            <h3><?= $readCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-circle-check"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern today">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Today</div>
            <h3><?= $todayCount ?></h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-calendar-day"></i>
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
        <div class="col-md-5">
          <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search by name, email, or subject..." id="searchInput">
          </div>
        </div>
        <div class="col-md-3">
          <select class="filter-select" id="statusFilter">
            <option value="all">All Status</option>
            <option value="unread">Unread</option>
            <option value="read">Read</option>
          </select>
        </div>
        <div class="col-md-4">
          <select class="filter-select" id="sortFilter">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Submissions List -->
    <div id="submissionsList">
      <?php if ($totalSubmissions > 0): ?>
        <?php foreach ($submissions as $submission): 
          // Determine badge colors based on status
          $status = $submission['status'] ?? 'unread';
          $statusClass = 'status-' . $status;
          $statusBadgeClass = 'badge-' . $status;
        ?>
        <div class="submission-card <?= $statusClass ?>" 
             data-search="<?= strtolower($submission['name'] . ' ' . $submission['email'] . ' ' . $submission['subject']) ?>"
             data-status="<?= $status ?>"
             data-created="<?= $submission['created_at'] ?>">
          <div class="submission-header">
            <div>
              <h4 class="submission-title"><?= htmlspecialchars($submission['subject']) ?></h4>
              <div class="submission-meta">
                <div class="meta-item">
                  <i class="fa-solid fa-user"></i>
                  <span><?= htmlspecialchars($submission['name']) ?></span>
                </div>
                <div class="meta-item">
                  <i class="fa-solid fa-envelope"></i>
                  <span><?= htmlspecialchars($submission['email']) ?></span>
                </div>
                <div class="meta-item">
                  <i class="fa-solid fa-calendar"></i>
                  <span><?= date('M d, Y g:i A', strtotime($submission['created_at'])) ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="submission-message">
            <?= nl2br(htmlspecialchars($submission['message'])) ?>
          </div>
          <div class="submission-footer">
            <div class="submission-badges">
              <span class="badge-modern <?= $statusBadgeClass ?>">
                <i class="fa-solid fa-<?= $status === 'read' ? 'circle-check' : 'envelope' ?> me-1"></i>
                <?= ucfirst($status) ?>
              </span>
            </div>
            <div class="submission-actions">
              <a href="view-submission.php?id=<?= $submission['id'] ?>" class="btn-action btn-view" title="View Details">
                <i class="fa-solid fa-eye"></i>
              </a>
              <button class="btn-action btn-delete btn-delete-submission" 
                      title="Delete"
                      data-id="<?= $submission['id'] ?>"
                      data-name="<?= htmlspecialchars($submission['name']) ?>">
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fa-solid fa-inbox"></i>
          </div>
          <h3>No submissions found</h3>
          <p>Contact submissions will appear here</p>
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
    const statusFilter = document.getElementById("statusFilter");
    const sortFilter = document.getElementById("sortFilter");
    const cards = document.querySelectorAll(".submission-card");

    function filterCards() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        cards.forEach(card => {
            const searchText = card.dataset.search;
            const cardStatus = card.dataset.status;
            let visible = true;

            if (search && !searchText.includes(search)) visible = false;
            if (status !== "all" && cardStatus !== status) visible = false;

            card.style.display = visible ? "" : "none";
        });
    }

    function sortCards() {
        const sortValue = sortFilter.value;
        const container = document.getElementById("submissionsList");
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
    const deleteButtons = document.querySelectorAll('.btn-delete-submission');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const id = this.dataset.id;
            const name = this.dataset.name;
            const deleteUrl = `delete-submission.php?id=${id}`;
            
            Swal.fire({
                title: 'Are you sure?',
                html: `<div style="text-align: center;">
                          <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                          <p>You are about to delete the submission from:</p>
                          <p><strong>"${name}"</strong></p>
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
    [searchInput, statusFilter].forEach(el => el.addEventListener("input", filterCards));
    sortFilter.addEventListener("change", sortCards);
});
</script>

<?php require './components/footer.php'; ?>