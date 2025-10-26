<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'View Notice'; // Set the page title
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="view-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1>View Notice</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-notices.php" class="text-decoration-none">All Notices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Notice</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="window.location.href='all-notices.php'">
                        <i class="fa-solid fa-arrow-left"></i> Back to List
                    </button>
                      <a href="edit-notice.php"></a> <button class="btn btn-primary text-white" onclick="window.location.href='edit-notice.php?id=1'">
                     <i class="fa-solid fa-pen-to-square text-white"></i> Edit Notice
                    </button></a>
                </div>
            </div>
        </div>

        <!-- Notice Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <!-- Notice Header -->
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success">Active</span>
                            <span class="badge bg-info">Announcement</span>
                            <span class="badge bg-secondary">Administrative</span>
                        </div>
                        <h2 class="mb-2">Annual General Meeting 2024</h2>
                        <div class="text-muted small">
                            <i class="fa-solid fa-calendar-days me-1"></i> Posted on: January 15, 2024
                            <span class="mx-2">|</span>
                            <i class="fa-solid fa-user me-1"></i> By: Admin User
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small mb-1">Notice ID</div>
                        <div class="fw-bold">#NOT-001</div>
                    </div>
                </div>

                <!-- Notice Content -->
                <div class="notice-content mb-4">
                    <h5 class="mb-3">Notice Details</h5>
                    <div class="content-text">
                        <p>Dear Members,</p>
                        <p>We are pleased to announce that the Annual General Meeting (AGM) for 2024 will be held on <strong>March 15, 2024</strong> at our main office premises.</p>
                        <p>The meeting will commence at <strong>10:00 AM</strong> and is expected to conclude by 2:00 PM. Lunch will be provided for all attendees.</p>
                        
                        <h6 class="mt-4 mb-2">Agenda:</h6>
                        <ul>
                            <li>Review of 2023 activities and achievements</li>
                            <li>Financial report and budget approval</li>
                            <li>Election of new board members</li>
                            <li>Discussion on upcoming projects for 2024</li>
                            <li>Q&A session</li>
                        </ul>

                        <p class="mt-3">All members are encouraged to attend and participate in this important meeting. Please confirm your attendance by replying to this notice.</p>
                        
                        <p class="mb-0">Looking forward to seeing you all there!</p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-calendar-check text-primary me-2"></i>
                                <strong>Valid From</strong>
                            </div>
                            <div class="ms-4">January 15, 2024</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-calendar-xmark text-danger me-2"></i>
                                <strong>Valid Until</strong>
                            </div>
                            <div class="ms-4">March 15, 2024</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-flag text-warning me-2"></i>
                                <strong>Priority Level</strong>
                            </div>
                            <div class="ms-4">High</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-users text-info me-2"></i>
                                <strong>Target Audience</strong>
                            </div>
                            <div class="ms-4">All Members</div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="attachments-section mb-4">
                    <h5 class="mb-3">
                        <i class="fa-solid fa-paperclip me-2"></i>Attachments
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="attachment-item p-3 border rounded d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon">
                                        <i class="fa-solid fa-file-pdf text-danger fs-2"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">AGM-Agenda-2024.pdf</div>
                                        <div class="text-muted small">245 KB</div>
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
                                        <i class="fa-solid fa-file-word text-primary fs-2"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Annual-Report-2023.docx</div>
                                        <div class="text-muted small">1.2 MB</div>
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
                            <strong>Contact Person:</strong> John Doe
                        </div>
                        <div class="col-md-6 mb-2">
                            <i class="fa-solid fa-envelope me-2 text-muted"></i>
                            <strong>Email:</strong> john.doe@organization.org
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-phone me-2 text-muted"></i>
                            <strong>Phone:</strong> +880 1234-567890
                        </div>
                        <div class="col-md-6">
                            <i class="fa-solid fa-map-marker-alt me-2 text-muted"></i>
                            <strong>Location:</strong> Main Office, Dhaka
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print Notice
            </button>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this notice?')) window.location.href='all-notice.php'">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <button class="btn btn-primary" onclick="window.location.href='edit-notice.php?id=1'">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Notice
                </button>
            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->





<?php require './components/footer.php'; ?>