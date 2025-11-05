<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Dashboard'; // Set the page title
?>
<?php require './components/header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="dashboard">
    <!-- Statistics Cards -->
    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon donate">
            <i class="fa-solid fa-equals"></i>
          </div>
          <div>
            <p class="stat-card-label">Total Donations</p>
            <h3 class="stat-card-value">2</h3>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon donate">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </div>
          <div>
            <p class="stat-card-label">Donations Amount</p>
            <h3 class="stat-card-value">20000</h3>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon donate">
            <i class="fa-solid fa-list"></i>
          </div>
          <div>
            <p class="stat-card-label">Donations Category</p>
            <h3 class="stat-card-value">5</h3>
          </div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon media-files">
            <i class="fa-solid fa-photo-film"></i>
          </div>
          <div>
            <p class="stat-card-label">Media Files</p>
            <h3 class="stat-card-value">150</h3>
          </div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon notice">
            <i class="fa-solid fa-flag-checkered"></i>
          </div>
          <div>
            <p class="stat-card-label">Total Notices</p>
            <h3 class="stat-card-value">12</h3>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon notice">
            <i class="fa-solid fa-flag"></i>
          </div>
          <div>
            <p class="stat-card-label">Active Notices</p>
            <h3 class="stat-card-value">12</h3>
          </div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon activities">
            <i class="fa-solid fa-calendar-days"></i>
          </div>
          <div>
            <p class="stat-card-label">Upcoming Activities</p>
            <h3 class="stat-card-value">12</h3>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-card-content">
          <div class="stat-icon activities">
            <i class="fa-solid fa-arrows-rotate"></i>
          </div>
          <div>
            <p class="stat-card-label">Recent Activities</p>
            <h3 class="stat-card-value">12</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <h2 class="quick-actions-title">Quick Actions</h2>
    <div class="quick-actions-container">
      <!-- New Notice -->
      <button class="quick-action-card" onclick="window.location.href='add-notice.php'">
        <a href="add-notice.php">
          <div class="quick-action-icon new-notice">
            <i class="fa-solid fa-plus"></i>
          </div>
          <p class="quick-action-title">New Notice</p>
        </a>
      </button>

      <!-- Upload Media -->
      <button class="quick-action-card" onclick="window.location.href='upload-media.php'">
        <a href="gallery.php">
          <div class="quick-action-icon upload-media">
            <i class="fa-solid fa-upload"></i>
          </div>
          <p class="quick-action-title">Upload Media</p>
        </a>
      </button>

      <!-- Add Activity -->
      <button class="quick-action-card" onclick="window.location.href='add-activity.php'">
        <div class="quick-action-icon add-activity">
          <i class="fa-solid fa-calendar-plus"></i>
        </div>
        <p class="quick-action-title">Add Activity</p>
      </button>
      
      <!-- Add Donation -->
      <button class="quick-action-card" onclick="window.location.href='../donate.php'">
        <div class="quick-action-icon add-activity">
          <i class="fa-solid fa-hand-holding-medical"></i>
        </div>
        <p class="quick-action-title">Add Donation</p>
      </button>
    </div>

    <!-- Bottom Tables Section -->
    <div class="container-fluid mt-5">
      <div class="row g-4 mt-4">
        <!-- Recent Donations Table -->
        <div class="col-12">
          <div class="card p-3 shadow-sm">
            <div class="card-body">
              <h1 class="chart-title mb-1">Recent Donations</h1>
              <p class="text-muted">List of latest donations (Last 3 entries)</p><br>
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>SL</th>
                      <th>Donor Name</th>
                      <th>Phone</th>
                      <th>Category</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Transaction ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="donationTableBody">
                    <!-- Data will be populated by JavaScript -->
                    <tr>
                      <td colspan="8" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-transparent">
              <a href="donation-list.php" class="btn btn-dark w-100">
                <i class="fa-solid fa-list me-2"></i>See All Donations
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<!-- Add these scripts before footer -->
<script src="js/donationData.js"></script>
<script src="js/dashboardDonations.js"></script>

<?php require './components/footer.php'; ?>