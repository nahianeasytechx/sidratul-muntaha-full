<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="" class="nav-link">
        <div class="nav-profile-image">
          <img src="img/admin.jpg" alt="profile" />
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Name</span>
          <span class="text-secondary text-small">Role</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#notice" aria-expanded="false" aria-controls="notice">
        <span class="menu-title">Notice</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="notice">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="add-notice.php">Add Notice</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="all-notice.php">All Notices </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#activities" aria-expanded="false" aria-controls="activities">
        <span class="menu-title">Activities</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="activities">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="add-activity.php">Add Activity</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="all-activities.php">All Activities </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="slider.php">
        <span class="menu-title">Slider</span>
        <i class="mdi mdi-tune-variant menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="gallery.php">
        <span class="menu-title">Gallery</span>
        <i class="mdi mdi-tune-variant menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#donate" aria-expanded="false" aria-controls="notice">
        <span class="menu-title">Donation List</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
      <div class="collapse" id="donate">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="donation-list.php">Donation List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="donation-categories.php">Donation Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="all-donation.php">All Donation </a>
          </li>
        </ul>
      </div>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="zakat-collection.php">
        <span class="menu-title">Zakat Collection</span>
        <i class="mdi mdi-clipboard-outline menu-icon"></i>
      </a>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="scholarship-application-list.php">
        <span class="menu-title">Scholarship List</span>
        <i class="mdi mdi-clipboard-outline menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="settings.php">
        <span class="menu-title">Settings</span>
        <i class="mdi mdi-cog menu-icon"></i>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link" href="logout.php">
        <span class="menu-title">Logout</span>
        <i class="mdi mdi-logout menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>