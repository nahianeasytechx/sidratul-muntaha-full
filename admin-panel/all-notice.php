<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Notices';
require './components/header.php';
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
  .stat-card-modern.draft { --gradient-start: #f59e0b; --gradient-end: #d97706; }

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
    padding: 14px 18px;
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

  /* Notice Cards */
  .notice-card {
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

  .notice-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--accent-color), var(--accent-color-dark));
  }

  .notice-card:hover {
    transform: translateX(4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  }

  .notice-card.status-active { --accent-color: #10b981; --accent-color-dark: #059669; }
  .notice-card.status-expired { --accent-color: #ef4444; --accent-color-dark: #dc2626; }
  .notice-card.status-draft { --accent-color: #f59e0b; --accent-color-dark: #d97706; }

  .notice-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 16px;
    gap: 16px;
  }

  .notice-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .notice-meta {
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

  .notice-description {
    color: #475569;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 16px;
  }

  .notice-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
  }

  .notice-badges {
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

  .badge-draft {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .badge-type {
    background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
    color: #6b21a8;
  }

  .notice-actions {
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

  /* Pagination */
  .pagination-modern {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 32px;
  }

  .page-btn {
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .page-btn:hover:not(.disabled):not(.active) {
    border-color: #8b5cf6;
    color: #8b5cf6;
    transform: translateY(-2px);
  }

  .page-btn.active {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
  }

  .page-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
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

    .notice-header {
      flex-direction: column;
    }

    .notice-footer {
      flex-direction: column;
      gap: 12px;
      align-items: flex-start;
    }
  }

  /* Animation */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .notice-card {
    animation: fadeIn 0.5s ease;
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
        <i class="fa-solid fa-flag"></i>
      </div>
      <h1>All Notices</h1>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid">
      <div class="stat-card-modern total">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Total Notices</div>
            <h3 id="totalCount">0</h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-flag"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern active">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Active Notices</div>
            <h3 id="activeCount">0</h3>
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
            <h3 id="expiredCount">0</h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-circle-xmark"></i>
          </div>
        </div>
      </div>

      <div class="stat-card-modern draft">
        <div class="stat-content-flex">
          <div class="stat-info">
            <div class="stat-label">Drafts</div>
            <h3 id="draftCount">0</h3>
          </div>
          <div class="stat-icon-modern">
            <i class="fa-solid fa-file-pen"></i>
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
            <input type="text" placeholder="Search notices..." id="searchInput">
          </div>
        </div>
        <div class="col-md-2">
          <select class="filter-select" id="statusFilter">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="expired">Expired</option>
            <option value="draft">Draft</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="filter-select" id="typeFilter">
            <option value="all">All Types</option>
            <option value="announcement">Announcement</option>
            <option value="event">Event</option>
            <option value="meeting">Meeting</option>
            <option value="deadline">Deadline</option>
            <option value="recruitment">Recruitment</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="filter-select" id="categoryFilter">
            <option value="all">All Categories</option>
            <option value="administrative">Administrative</option>
            <option value="volunteer">Volunteer</option>
            <option value="program">Program</option>
            <option value="training">Training</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="filter-select" id="sortFilter">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="expiring">Expiring Soon</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Notices List -->
    <div id="noticesList">
      <!-- Sample Notice Card -->
      <div class="notice-card status-active">
        <div class="notice-header">
          <div>
            <h4 class="notice-title">Annual Volunteer Recruitment 2025</h4>
            <div class="notice-meta">
              <div class="meta-item">
                <i class="fa-solid fa-calendar"></i>
                <span>Published: Jan 15, 2025</span>
              </div>
              <div class="meta-item">
                <i class="fa-solid fa-clock"></i>
                <span>Expires: Jun 15, 2025</span>
              </div>
              <div class="meta-item">
                <i class="fa-solid fa-user"></i>
                <span>Age: 18-35</span>
              </div>
            </div>
          </div>
        </div>
        <p class="notice-description">
          We are looking for passionate volunteers to join our community programs. 
          This is a great opportunity to make a difference in society and gain valuable experience.
        </p>
        <div class="notice-footer">
          <div class="notice-badges">
            <span class="badge-modern badge-active">Active</span>
            <span class="badge-modern badge-type">Recruitment</span>
          </div>
          <div class="notice-actions">
            <button class="btn-action btn-view" title="View">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-edit" title="Edit">
              <i class="fa-solid fa-pen"></i>
            </button>
            <button class="btn-action btn-delete" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sample Expired Notice -->
      <div class="notice-card status-expired">
        <div class="notice-header">
          <div>
            <h4 class="notice-title">Training Session - December 2024</h4>
            <div class="notice-meta">
              <div class="meta-item">
                <i class="fa-solid fa-calendar"></i>
                <span>Published: Dec 1, 2024</span>
              </div>
              <div class="meta-item">
                <i class="fa-solid fa-clock"></i>
                <span>Expired: Dec 31, 2024</span>
              </div>
            </div>
          </div>
        </div>
        <p class="notice-description">
          Professional development training for all team members. Topics include leadership, 
          communication, and project management skills.
        </p>
        <div class="notice-footer">
          <div class="notice-badges">
            <span class="badge-modern badge-expired">Expired</span>
            <span class="badge-modern badge-type">Training</span>
          </div>
          <div class="notice-actions">
            <button class="btn-action btn-view" title="View">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-edit" title="Edit">
              <i class="fa-solid fa-pen"></i>
            </button>
            <button class="btn-action btn-delete" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sample Draft Notice -->
      <div class="notice-card status-draft">
        <div class="notice-header">
          <div>
            <h4 class="notice-title">Upcoming Community Event</h4>
            <div class="notice-meta">
              <div class="meta-item">
                <i class="fa-solid fa-calendar"></i>
                <span>Created: Nov 5, 2025</span>
              </div>
              <div class="meta-item">
                <i class="fa-solid fa-file-pen"></i>
                <span>Status: Draft</span>
              </div>
            </div>
          </div>
        </div>
        <p class="notice-description">
          Planning a major community event for the spring season. Details to be finalized soon.
        </p>
        <div class="notice-footer">
          <div class="notice-badges">
            <span class="badge-modern badge-draft">Draft</span>
            <span class="badge-modern badge-type">Event</span>
          </div>
          <div class="notice-actions">
            <button class="btn-action btn-view" title="View">
              <i class="fa-solid fa-eye"></i>
            </button>
            <button class="btn-action btn-edit" title="Edit">
              <i class="fa-solid fa-pen"></i>
            </button>
            <button class="btn-action btn-delete" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-modern">
      <button class="page-btn disabled">
        <i class="fa-solid fa-chevron-left"></i>
      </button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">4</button>
      <button class="page-btn">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>

  </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
  // Update statistics (example)
  document.getElementById('totalCount').textContent = '3';
  document.getElementById('activeCount').textContent = '1';
  document.getElementById('expiredCount').textContent = '1';
  document.getElementById('draftCount').textContent = '1';

  // Search functionality
  const searchInput = document.getElementById('searchInput');
  searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const noticeCards = document.querySelectorAll('.notice-card');
    
    noticeCards.forEach(card => {
      const title = card.querySelector('.notice-title').textContent.toLowerCase();
      const description = card.querySelector('.notice-description').textContent.toLowerCase();
      
      if (title.includes(searchTerm) || description.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });

  // Filter by status
  const statusFilter = document.getElementById('statusFilter');
  statusFilter.addEventListener('change', function(e) {
    const status = e.target.value;
    const noticeCards = document.querySelectorAll('.notice-card');
    
    noticeCards.forEach(card => {
      if (status === 'all') {
        card.style.display = 'block';
      } else {
        const cardStatus = card.classList.contains(`status-${status}`);
        card.style.display = cardStatus ? 'block' : 'none';
      }
    });
  });
</script>

<?php require './components/footer.php'; ?>