<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'View Activity'; // Set the page title
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="view-activity">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">

                    <div>
                        <h1>View Activity</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-activities.php" class="text-decoration-none">All Activities</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Activity</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="window.location.href='all-activities.php'">
                        <i class="fa-solid fa-arrow-left"></i> Back to List
                    </button>
                    <a href="edit-activity.php ">
                         <button class="btn btn-primary text-white" >
                            <i class="fa-solid fa-pen-to-square"></i> Edit Activity
                        </button></a>
                </div>
            </div>
        </div>

        <!-- Activity Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <!-- Activity Header -->
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success">Active</span>
                            <span class="badge bg-info">Community Service</span>
                            <span class="badge bg-warning text-dark">Ongoing</span>
                        </div>
                        <h2 class="mb-2">Tree Plantation Drive 2024</h2>
                        <div class="text-muted small">
                            <i class="fa-solid fa-calendar-days me-1"></i> Created on: January 10, 2024
                            <span class="mx-2">|</span>
                            <i class="fa-solid fa-user me-1"></i> By: Admin User
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small mb-1">Activity ID</div>
                        <div class="fw-bold">#ACT-001</div>
                    </div>
                </div>

                <!-- Activity Featured Image -->
                <div class="activity-image mb-4">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1200&h=600&fit=crop" alt="Tree Plantation Drive" class="img-fluid rounded">
                    <div class="image-caption mt-2 text-muted small text-center">
                        <i class="fa-solid fa-image me-1"></i> Tree Plantation Drive - Community Volunteer Event
                    </div>
                </div>

                <!-- Activity Content -->
                <div class="activity-content mb-4">
                    <h5 class="mb-3">Activity Description</h5>
                    <div class="content-text">
                        <p>Join us for our annual Tree Plantation Drive 2024, a community initiative aimed at creating a greener and more sustainable environment for future generations.</p>

                        <p>This year, we aim to plant <strong>1,000 trees</strong> across various locations in Dhaka. The plantation drive will focus on native species that are well-adapted to our local climate and require minimal maintenance.</p>

                        <h6 class="mt-4 mb-2">Event Highlights:</h6>
                        <ul>
                            <li>Plant native tree species in designated areas</li>
                            <li>Educational sessions on environmental conservation</li>
                            <li>Community engagement and team building activities</li>
                            <li>Refreshments and certificates for all participants</li>
                            <li>Photo opportunities and media coverage</li>
                        </ul>

                        <h6 class="mt-4 mb-2">What to Bring:</h6>
                        <ul>
                            <li>Comfortable outdoor clothing and closed-toe shoes</li>
                            <li>Water bottle and sun protection (hat, sunscreen)</li>
                            <li>Gardening gloves (if available)</li>
                            <li>Enthusiasm and positive energy!</li>
                        </ul>

                        <p class="mt-3">This is a great opportunity to give back to the community, meet like-minded individuals, and make a lasting environmental impact. All ages are welcome, and families are encouraged to participate together.</p>

                        <p class="mb-0"><strong>Note:</strong> Registration is required. Please sign up by February 20, 2024.</p>
                    </div>
                </div>



                <!-- Attachments Section -->
                <div class="attachments-section mb-4">
                    <h5 class="mb-3">
                        <i class="fa-solid fa-paperclip me-2"></i>Related Documents
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="attachment-item p-3 border rounded d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-pdf text-danger fs-2"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Activity-Guidelines.pdf</div>
                                        <div class="text-muted small">320 KB</div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attachment-item p-3 border rounded d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-excel text-success fs-2"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Participant-List.xlsx</div>
                                        <div class="text-muted small">145 KB</div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="contact-section p-3 bg-light rounded">
                    <h6 class="mb-3">
                        <i class="fa-solid fa-address-card me-2"></i>Contact Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-user me-2 text-muted"></i>
                            <strong>Coordinator:</strong> Sarah Johnson
                        </div>
                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-envelope me-2 text-muted"></i>
                            <strong>Email:</strong> sarah.j@organization.org
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-phone me-2 text-muted"></i>
                            <strong>Phone:</strong> +880 1987-654321
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-globe me-2 text-muted"></i>
                            <strong>Website:</strong> www.organization.org/events
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <button class="btn btn-outline-info">
                    <i class="fa-solid fa-share-nodes"></i> Share
                </button>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this activity?')) window.location.href='all-activities.php'">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <button class="btn btn-primary" onclick="window.location.href='edit-activity.php?id=1'">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Activity
                </button>
            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->






<?php require './components/footer.php'; ?>