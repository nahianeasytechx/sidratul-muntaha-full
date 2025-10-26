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
            <p class="stat-card-label">Donations Ammount</p>
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
            <p class="stat-card-label">Upcoming Activities</p>
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
      <!-- Add Activity -->
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

        <!-- Latest Activities Table -->
        <div class="col-lg-4 col-md-6">
          <div class="table-card shadow-sm">
            <div class="table-header">
              <h5><i class="fa-solid fa-calendar-check me-2"></i>Latest Activities</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Tree Plantation</td>
                    <td>Oct 08, 2025</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Blood Donation Camp</td>
                    <td>Oct 06, 2025</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Charity Run</td>
                    <td>Oct 05, 2025</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Community Cleaning</td>
                    <td>Oct 03, 2025</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Education Drive</td>
                    <td>Oct 01, 2025</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end bg-white">
              <a href="all-activities.php" class="table-btn">See All</a>
            </div>
          </div>
        </div>

        <!-- Recent Donations Table -->
        <div class="col-lg-4 col-md-6">
          <div class="table-card shadow-sm">
            <div class="table-header">
              <h5><i class="fa-solid fa-hand-holding-heart me-2"></i>Recent Donations</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Donor</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Rahim Uddin</td>
                    <td>$100</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Mahmud Hasan</td>
                    <td>$200</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Jannat Ara</td>
                    <td>$75</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Rafi Khan</td>
                    <td>$120</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Sadia Islam</td>
                    <td>$90</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end bg-white">
              <a href="donation-list.php" class="table-btn">See All</a>
            </div>
          </div>
        </div>

        <!-- Recent Notices Table -->
        <div class="col-lg-4 col-md-6">
          <div class="table-card shadow-sm">
            <div class="table-header">
              <h5><i class="fa-solid fa-flag me-2"></i>Recent Notices</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Office Closed Notice</td>
                    <td><span class="px-3 rounded-1  badge-text  text-white bg-success">Active</span></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Donation Drive</td>
                    <td><span class="px-3 rounded-1 badge-text  text-white bg-danger">Expired</span></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Website Maintenance</td>
                    <td><span class="px-3 rounded-1 badge-text   text-white bg-danger">Expired</span></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Team Meeting</td>
                    <td><span class="px-3 rounded-1  badge-text  text-white bg-success">Active</span></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Blood Camp Alert</td>
                    <td><span class=" px-3 rounded-1 badge-text  text-white bg-success ">Active</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end bg-white">
              <a href="all-notice.php" class="table-btn">See All</a>
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

<?php require './components/footer.php'; ?>