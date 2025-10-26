<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Activities';
?>
<?php require './components/header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="all-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <h1>All Activities</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Activities</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <button class="btn btn-add-new" onclick="window.location.href='add-activity.php'">
                    <i class="fa-solid fa-plus me-2"></i>Add New Activity
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Activities</div>
                        <h3 class="mb-0" id="totalCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Upcoming</div>
                        <h3 class="mb-0" id="upcomingCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired">
                        <i class="fa-solid fa-spinner"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Ongoing</div>
                        <h3 class="mb-0" id="ongoingCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Completed</div>
                        <h3 class="mb-0" id="completedCount">0</h3>
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
                        <input type="text" class="form-control" placeholder="Search activities..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="community service">Community Service</option>
                        <option value="workshop">Workshop</option>
                        <option value="training">Training</option>
                        <option value="event">Event</option>
                        <option value="outreach">Outreach</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="environmental">Environmental</option>
                        <option value="health">Health</option>
                        <option value="education">Education</option>
                        <option value="fundraising">Fundraising</option>
                        <option value="social welfare">Social Welfare</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="date">By Date</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Activities List -->
        <div id="activitiesList"></div>

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