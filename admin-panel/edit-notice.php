<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Edit Notice'; // Set the page title
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="edit-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h1>Edit Notice</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-notices.php" class="text-decoration-none">All Notices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Notice</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="window.location.href='all-notices.php'">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="noticeTitle" class="form-label">Notice Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="noticeTitle" name="title" value="Annual General Meeting 2024" required>
                            </div>

                            <div class="mb-3">
                                <label for="noticeDescription" class="form-label">Notice Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="noticeDescription" name="description" rows="10" required>Dear Members,

We are pleased to announce that the Annual General Meeting (AGM) for 2024 will be held on March 15, 2024 at our main office premises.

The meeting will commence at 10:00 AM and is expected to conclude by 2:00 PM. Lunch will be provided for all attendees.

Agenda:
- Review of 2023 activities and achievements
- Financial report and budget approval
- Election of new board members
- Discussion on upcoming projects for 2024
- Q&A session

All members are encouraged to attend and participate in this important meeting. Please confirm your attendance by replying to this notice.

Looking forward to seeing you all there!</textarea>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="noticeType" class="form-label">Notice Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="noticeType" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="announcement" selected>Announcement</option>
                                        <option value="event">Event</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="deadline">Deadline</option>
                                        <option value="recruitment">Recruitment</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="noticeCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="noticeCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="administrative" selected>Administrative</option>
                                        <option value="volunteer">Volunteer</option>
                                        <option value="program">Program</option>
                                        <option value="training">Training</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Priority Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-calendar-days me-2"></i>Date & Priority
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="validFrom" class="form-label">Valid From <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="validFrom" name="valid_from" value="2024-01-15" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="validUntil" class="form-label">Valid Until <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="validUntil" name="valid_until" value="2024-03-15" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="priorityLevel" class="form-label">Priority Level <span class="text-danger">*</span></label>
                                    <select class="form-select" id="priorityLevel" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high" selected>High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="targetAudience" class="form-label">Target Audience <span class="text-danger">*</span></label>
                                    <select class="form-select" id="targetAudience" name="target_audience" required>
                                        <option value="">Select Audience</option>
                                        <option value="all" selected>All Members</option>
                                        <option value="volunteers">Volunteers Only</option>
                                        <option value="staff">Staff Only</option>
                                        <option value="donors">Donors</option>
                                        <option value="partners">Partners</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-address-card me-2"></i>Contact Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contactPerson" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" id="contactPerson" name="contact_person" value="John Doe">
                                </div>

                                <div class="col-md-6">
                                    <label for="contactEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="contactEmail" name="contact_email" value="john.doe@organization.org">
                                </div>

                                <div class="col-md-6">
                                    <label for="contactPhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="contactPhone" name="contact_phone" value="+880 1234-567890">
                                </div>

                                <div class="col-md-6">
                                    <label for="contactLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="contactLocation" name="contact_location" value="Main Office, Dhaka">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-paperclip me-2"></i>Attachments
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Existing Attachments -->
                            <div class="mb-3">
                                <label class="form-label">Current Attachments</label>
                                <div class="existing-files">
                                    <div class="file-item d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa-solid fa-file-pdf text-danger fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">AGM-Agenda-2024.pdf</div>
                                                <div class="text-muted small">245 KB</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="file-item d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa-solid fa-file-word text-primary fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">Annual-Report-2023.docx</div>
                                                <div class="text-muted small">1.2 MB</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add New Attachments -->
                            <div>
                                <label for="newAttachments" class="form-label">Add New Attachments</label>
                                <input type="file" class="form-control" id="newAttachments" name="attachments[]" multiple>
                                <div class="form-text">You can upload multiple files. Max size: 5MB per file.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Status Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-toggle-on me-2"></i>Status
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label for="noticeStatus" class="form-label">Notice Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="noticeStatus" name="status" required>
                                    <option value="active" selected>Active</option>
                                    <option value="draft">Draft</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>

                            <div class="alert alert-info mb-0">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                <small>Setting status to "Active" will publish this notice immediately.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Notice ID Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-hashtag me-2"></i>Notice Details
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Notice ID</label>
                                <div class="fw-bold">#NOT-001</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created By</label>
                                <div>Admin User</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created On</label>
                                <div>January 15, 2024</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted small">Last Modified</label>
                                <div>January 16, 2024</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips Card -->
                    <div class="card shadow-sm mb-4 border-primary">
                        <div class="card-header bg-primary text-white py-3">
                            <h6 class="mb-0">
                                <i class="fa-solid fa-lightbulb me-2"></i>Quick Tips
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="mb-0 ps-3 small">
                                <li class="mb-2">Use clear and concise titles</li>
                                <li class="mb-2">Set appropriate priority levels</li>
                                <li class="mb-2">Include contact information</li>
                                <li class="mb-2">Add relevant attachments</li>
                                <li class="mb-0">Review before publishing</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <button type="submit" name="update" class="btn btn-primary w-100 mb-2">
                                <i class="fa-solid fa-floppy-disk"></i> Update Notice
                            </button>
                            <button type="submit" name="save_draft" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="fa-solid fa-file-pen"></i> Save as Draft
                            </button>
                            <button type="button" class="btn btn-outline-danger w-100" onclick="if(confirm('Are you sure you want to delete this notice?')) window.location.href='all-notices.php'">
                                <i class="fa-solid fa-trash"></i> Delete Notice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->





<?php require './components/footer.php'; ?>