<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Activity';
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

    /* Activity Details Card */
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
    <div class="edit-activity">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h1><i class="fa-solid fa-pen-to-square me-2"></i>Edit Activity</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-activities.php" class="text-decoration-none">All Activities</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Activity</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-cancel-header" onclick="window.location.href='all-activities.php'">
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
                                <label for="activityTitle" class="form-label">Activity Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="activityTitle" name="title" value="Community Health Camp 2024" required>
                            </div>

                            <div class="mb-3">
                                <label for="activityDescription" class="form-label">Activity Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="activityDescription" name="description" rows="10" required>Join us for a comprehensive health camp aimed at providing free medical checkups and health awareness to our community members.

Event Highlights:
- Free health screenings and consultations
- Blood pressure and diabetes checkups
- Nutrition counseling sessions
- Distribution of free medicines
- Health awareness workshops

Our team of qualified doctors and healthcare professionals will be present to assist you. This is a great opportunity for community members to get their health checked and receive valuable medical advice.

Registration is required. Please bring a valid ID card with you.</textarea>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="activityType" class="form-label">Activity Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="activityType" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="community" selected>Community Service</option>
                                        <option value="education">Education</option>
                                        <option value="health">Health</option>
                                        <option value="environment">Environment</option>
                                        <option value="fundraising">Fundraising</option>
                                        <option value="awareness">Awareness Campaign</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="activityCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="activityCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="program" selected>Program</option>
                                        <option value="workshop">Workshop</option>
                                        <option value="seminar">Seminar</option>
                                        <option value="training">Training</option>
                                        <option value="campaign">Campaign</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule & Location Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-calendar-days"></i>Schedule & Location
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="activityDate" class="form-label">Activity Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="activityDate" name="activity_date" value="2024-03-20" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="activityTime" class="form-label">Activity Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="activityTime" name="activity_time" value="09:00" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="duration" class="form-label">Duration (Hours) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration" name="duration" value="6" min="1" step="0.5" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="maxParticipants" class="form-label">Max Participants</label>
                                    <input type="number" class="form-control" id="maxParticipants" name="max_participants" value="100" min="1">
                                </div>

                                <div class="col-md-12">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location" value="Community Center, Mirpur-10, Dhaka" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="locationLink" class="form-label">Location Link (Google Maps)</label>
                                    <input type="url" class="form-control" id="locationLink" name="location_link" value="https://maps.google.com/..." placeholder="https://maps.google.com/...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration & Requirements Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-clipboard-check"></i>Registration & Requirements
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="registrationDeadline" class="form-label">Registration Deadline</label>
                                    <input type="date" class="form-control" id="registrationDeadline" name="registration_deadline" value="2024-03-15">
                                </div>

                                <div class="col-md-6">
                                    <label for="ageRequirement" class="form-label">Age Requirement</label>
                                    <input type="text" class="form-control" id="ageRequirement" name="age_requirement" value="All Ages" placeholder="e.g., 18-35, All Ages">
                                </div>

                                <div class="col-md-12">
                                    <label for="requirements" class="form-label">Special Requirements</label>
                                    <textarea class="form-control" id="requirements" name="requirements" rows="4" placeholder="List any special requirements or prerequisites...">- Valid ID card
- Registration confirmation
- Comfortable clothing
- Water bottle</textarea>
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
                                    <label for="coordinatorName" class="form-label">Coordinator Name</label>
                                    <input type="text" class="form-control" id="coordinatorName" name="coordinator_name" value="Dr. Sarah Ahmed">
                                </div>

                                <div class="col-md-6">
                                    <label for="coordinatorEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="coordinatorEmail" name="coordinator_email" value="sarah.ahmed@organization.org">
                                </div>

                                <div class="col-md-6">
                                    <label for="coordinatorPhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="coordinatorPhone" name="coordinator_phone" value="+880 1712-345678">
                                </div>

                                <div class="col-md-6">
                                    <label for="alternateContact" class="form-label">Alternate Contact</label>
                                    <input type="tel" class="form-control" id="alternateContact" name="alternate_contact" value="+880 1823-456789">
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
                                                <div class="fw-semibold">Health-Camp-Schedule.pdf</div>
                                                <div class="text-muted small">320 KB</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="file-item d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa-solid fa-file-image text-primary fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">Event-Poster.jpg</div>
                                                <div class="text-muted small">850 KB</div>
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
                                <label for="activityStatus" class="form-label">Activity Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="activityStatus" name="status" required>
                                    <option value="upcoming" selected>Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>

                            <div class="alert alert-info mb-0">
                                <i class="fa-solid fa-circle-info"></i>
                                <small>Setting status to "Upcoming" will publish this activity immediately.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Details Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-hashtag"></i>Activity Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Activity ID</label>
                                <div class="fw-bold">#ACT-001</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created By</label>
                                <div>Admin User</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created On</label>
                                <div>January 10, 2024</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Last Modified</label>
                                <div>January 18, 2024</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted small">Current Participants</label>
                                <div class="fw-bold text-success">45 / 100</div>
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
                                <li class="mb-2">Use clear and descriptive titles</li>
                                <li class="mb-2">Include detailed location info</li>
                                <li class="mb-2">Set realistic participant limits</li>
                                <li class="mb-2">Add relevant photos or documents</li>
                                <li class="mb-0">Update status regularly</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body p-3">
                            <button type="submit" name="update" class="btn btn-primary w-100 mb-2">
                                <i class="fa-solid fa-floppy-disk"></i> Update Activity
                            </button>
                            <button type="submit" name="save_draft" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="fa-solid fa-file-pen"></i> Save as Draft
                            </button>
                            <button type="button" class="btn btn-outline-danger w-100" onclick="if(confirm('Are you sure you want to delete this activity?')) window.location.href='all-activities.php'">
                                <i class="fa-solid fa-trash"></i> Delete Activity
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require './components/footer.php'; ?>