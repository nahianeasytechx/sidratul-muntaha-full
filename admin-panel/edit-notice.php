<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Notice';
require './components/header.php';
?>

<style>
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
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

    /* Cancel Button in Header */
    .btn-cancel-header {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #ffffff) !important;
        border-bottom: 2px solid #e9ecef;
        border-radius: 16px 16px 0 0 !important;
        padding: 1.25rem 1.5rem !important;
    }

    .card-header h5 {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header h5 i {
        color: #10b981;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
        outline: none;
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .form-text {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* File Item Styling */
    .file-item {
        background: #f8f9fa;
        border: 2px solid #e9ecef !important;
        border-radius: 12px;
        padding: 1rem !important;
        transition: all 0.3s ease;
    }

    .file-item:hover {
        border-color: #10b981 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .file-item .fw-semibold {
        color: #1e293b;
        font-weight: 600;
    }

    .file-item .text-muted {
        color: #94a3b8 !important;
        font-size: 0.85rem;
    }

    /* Alert Styling */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .alert-info i {
        color: #1e40af;
    }

    /* Status Card Special Styling */
    .card.border-primary {
        border: 2px solid #10b981 !important;
    }

    .card-header.bg-primary {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: white !important;
        border: none !important;
    }

    .card-header.bg-primary h6 {
        color: white !important;
        font-weight: 600;
    }

    /* Quick Tips List */
    .card-body ul {
        list-style: none;
        padding-left: 0;
    }

    .card-body ul li {
        position: relative;
        padding-left: 1.5rem;
        color: #475569;
    }

    .card-body ul li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 700;
    }

    /* Notice Details Card */
    .card-body .fw-bold {
        color: #1e293b;
        font-size: 1rem;
    }

    .card-body .form-label.text-muted {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b !important;
    }

    /* Button Styling */
    .btn {
        border-radius: 10px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    .btn-outline-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e9ecef;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-2px);
    }

    .btn-outline-danger {
        background: white;
        color: #ef4444;
        border: 2px solid #fee2e2;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #ef4444;
        color: #dc2626;
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }
    }

    @media (max-width: 767px) {
        .page-header h1 {
            font-size: 1.3rem;
        }

        .card-header h5 {
            font-size: 1rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
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

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Icon Colors */
    .text-primary {
        color: #2b579a !important;
    }

    .text-danger.fs-4 {
        color: #ef4444 !important;
    }
</style>

<div class="content-wrapper">
    <div class="edit-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-pen-to-square me-2"></i>Edit Notice</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-notices.php" class="text-decoration-none">All Notices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Notice</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-cancel-header" onclick="window.location.href='all-notice.php'">
                        <i class="fa-solid fa-xmark me-1"></i> Cancel
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
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-circle-info"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
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
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-calendar-days"></i>Date & Priority
                            </h5>
                        </div>
                        <div class="card-body">
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
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-address-card"></i>Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
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
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-paperclip"></i>Attachments
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Existing Attachments -->
                            <div class="mb-3">
                                <label class="form-label">Current Attachments</label>
                                <div class="existing-files">
                                    <div class="file-item d-flex align-items-center justify-content-between mb-2">
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
                                    <div class="file-item d-flex align-items-center justify-content-between mb-2">
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
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-toggle-on"></i>Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="noticeStatus" class="form-label">Notice Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="noticeStatus" name="status" required>
                                    <option value="active" selected>Active</option>
                                    <option value="draft">Draft</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>

                            <div class="alert alert-info mb-0">
                                <i class="fa-solid fa-circle-info"></i>
                                <small>Setting status to "Active" will publish this notice immediately.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Notice ID Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-hashtag"></i>Notice Details
                            </h5>
                        </div>
                        <div class="card-body">
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
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary py-3">
                            <h6 class="mb-0">
                                <i class="fa-solid fa-lightbulb me-2"></i>Quick Tips
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="mb-0 small">
                                <li class="mb-2">Use clear and concise titles</li>
                                <li class="mb-2">Set appropriate priority levels</li>
                                <li class="mb-2">Include contact information</li>
                                <li class="mb-2">Add relevant attachments</li>
                                <li class="mb-0">Review before publishing</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
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

<?php require './components/footer.php'; ?>