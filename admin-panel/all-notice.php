<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'All Notices'; // Set the page title
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="all-notice">
        <!-- Page Header -->
<div class="page-header">
  <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="icon-box">
        <i class="fa-solid fa-flag"></i>
      </div>
      <div>
        <h1>All Notices</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Notices</li>
          </ol>
        </nav>
      </div>
    </div>

    <button class="btn btn-add-new" onclick="window.location.href='add-notice.php'">
      <i class="fa-solid fa-plus"></i> Add New Notice
    </button>
  </div>
</div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-flag"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Notices</div>
                        <h3 class="mb-0" id="totalCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active Notices</div>
                        <h3 class="mb-0" id="activeCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Expired</div>
                        <h3 class="mb-0" id="expiredCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Drafts</div>
                        <h3 class="mb-0" id="draftCount">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fa-solid fa-filter"></i>
                Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" class="form-control" placeholder="Search notices..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="announcement">Announcement</option>
                        <option value="event">Event</option>
                        <option value="meeting">Meeting</option>
                        <option value="deadline">Deadline</option>
                        <option value="recruitment">Recruitment</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="administrative">Administrative</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="program">Program</option>
                        <option value="training">Training</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="expiring">Expiring Soon</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Notices List -->
        <div id="noticesList"></div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination pagination-custom">
                <li class="page-item disabled">
                    <a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->



<?php require './components/footer.php'; ?>