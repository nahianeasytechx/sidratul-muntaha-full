<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Activity';
?>
<?php require './components/header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="edit-activity">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h1>Edit Activity</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-activities.php" class="text-decoration-none">All Activities</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Activity</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="window.location.href='all-activities.php'">
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
                                <label for="activityTitle" class="form-label">Activity Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="activityTitle" name="title" value="Youth Skills Development Initiative" required>
                            </div>

                            <div class="mb-3">
                                <label for="activityDescription" class="form-label">Activity Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="activityDescription" name="description" rows="10" required>An ScuntSS (Skill Development Institute) is an initiative-driven self-skill development journey and community that helps to unlock the next billion creators. Here, Scunters can find programs that will help them in their skill development career.

As ScuntSS SDE, we aim to see that our country is full of skill-self reliance people. We imagine, in a few years coaching on skillful information technology, and ethical hacking as well as data science courses to a community reaction.

By developing skilled human resources, DNS helpers; we believe, should be equally be a platform as an effective tool for defending the country's security and Prosperity and identifying and nurturing merit.</textarea>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="activityType" class="form-label">Activity Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="activityType" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="training" selected>Training</option>
                                        <option value="workshop">Workshop</option>
                                        <option value="seminar">Seminar</option>
                                        <option value="conference">Conference</option>
                                        <option value="community">Community Service</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="activityCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="activityCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="skill_development" selected>Skill Development</option>
                                        <option value="education">Education</option>
                                        <option value="health">Health</option>
                                        <option value="environment">Environment</option>
                                        <option value="awareness">Awareness</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Sections Container -->
                    <div id="dynamicSectionsContainer">
                        <!-- Existing Section 1: Goals & Objectives -->
                        <div class="card shadow-sm mb-4 dynamic-section" data-section-id="1">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2 flex-grow-1">
                                    <i class="fa-solid fa-bullseye"></i>
                                    <input type="text" class="form-control form-control-sm section-title-input" name="section_title_1" value="Project Goals & Objectives" placeholder="Enter section title" style="max-width: 300px;">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">
                                    <i class="fa-solid fa-trash"></i> Remove Section
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label">Items</label>
                                    <div class="items-list">
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-circle-check text-success"></i></span>
                                                <input type="text" class="form-control" name="section_1_items[]" value="Skill enhancement">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-circle-check text-success"></i></span>
                                                <input type="text" class="form-control" name="section_1_items[]" value="Job placement assistance">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-circle-check text-success"></i></span>
                                                <input type="text" class="form-control" name="section_1_items[]" value="Employment initiation">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-circle-check text-success"></i></span>
                                                <input type="text" class="form-control" name="section_1_items[]" value="Knowledge base creation">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this)">
                                    <i class="fa-solid fa-plus"></i> Add New Item
                                </button>
                            </div>
                        </div>

                        <!-- Existing Section 2: Expenditure Sectors -->
                        <div class="card shadow-sm mb-4 dynamic-section" data-section-id="2">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2 flex-grow-1">
                                    <i class="fa-solid fa-money-bill-trend-up"></i>
                                    <input type="text" class="form-control form-control-sm section-title-input" name="section_title_2" value="Expenditure Sectors" placeholder="Enter section title" style="max-width: 300px;">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSectionDynamic(this)">
                                    <i class="fa-solid fa-trash"></i> Remove Section
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label">Items</label>
                                    <div class="items-list">
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign text-primary"></i></span>
                                                <input type="text" class="form-control" name="section_2_items[]" value="Small purchase for the handouts">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign text-primary"></i></span>
                                                <input type="text" class="form-control" name="section_2_items[]" value="Consultation of key business & field-hands">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign text-primary"></i></span>
                                                <input type="text" class="form-control" name="section_2_items[]" value="Snack, Launching point (participant)">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign text-primary"></i></span>
                                                <input type="text" class="form-control" name="section_2_items[]" value="Management and duplicate">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="item-row mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-dollar-sign text-primary"></i></span>
                                                <input type="text" class="form-control" name="section_2_items[]" value="Going by modifying">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeItemDynamic(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewItemDynamic(this)">
                                    <i class="fa-solid fa-plus"></i> Add New Item
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Section Button -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-success" onclick="addNewSectionDynamic()">
                            <i class="fa-solid fa-plus-circle"></i> Add New Section
                        </button>
                    </div>

                    <!-- Date & Budget Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-calendar-days me-2"></i>Date & Budget
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="startDate" name="start_date" value="2024-02-01" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="endDate" name="end_date" value="2024-06-30" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="totalBudget" class="form-label">Total Budget <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" class="form-control" id="totalBudget" name="budget" value="500000" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="targetParticipants" class="form-label">Target Participants</label>
                                    <input type="number" class="form-control" id="targetParticipants" name="participants" value="150">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Venue Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-location-dot me-2"></i>Location & Venue
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="venueName" class="form-label">Venue Name</label>
                                    <input type="text" class="form-control" id="venueName" name="venue" value="Community Center Hall">
                                </div>

                                <div class="col-md-6">
                                    <label for="venueAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="venueAddress" name="address" value="Dhanmondi, Dhaka">
                                </div>

                                <div class="col-md-6">
                                    <label for="district" class="form-label">District</label>
                                    <select class="form-select" id="district" name="district">
                                        <option value="">Select District</option>
                                        <option value="dhaka" selected>Dhaka</option>
                                        <option value="chittagong">Chittagong</option>
                                        <option value="rajshahi">Rajshahi</option>
                                        <option value="khulna">Khulna</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="division" class="form-label">Division</label>
                                    <select class="form-select" id="division" name="division">
                                        <option value="">Select Division</option>
                                        <option value="dhaka" selected>Dhaka</option>
                                        <option value="chittagong">Chittagong</option>
                                        <option value="rajshahi">Rajshahi</option>
                                        <option value="khulna">Khulna</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Images Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-images me-2"></i>Activity Images
                            </h5>
                        </div>
                        <div class="card-body p-4">

                            <div>
                                <label for="newImages" class="form-label">Add New Images</label>
                          <input type="file" class="form-control" id="newImages" name="image" accept="image/*" onchange="previewNewImages(this)">

                                <div class="form-text">You can upload single image. Max size: 5MB per image. Supported formats: JPG, PNG, GIF</div>
                            </div>

                            <!-- Preview New Images -->
                            <div class="row g-3 mt-2" id="newImagesPreview"></div>
                        </div>
                    </div>

                    <!-- Attachments & Resources Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-paperclip me-2"></i>Attachments & Resources
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Current Attachments</label>
                                <div class="existing-files" id="existingFilesContainer">
                                    <div class="file-item d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa-solid fa-file-pdf text-danger fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">Activity-Proposal.pdf</div>
                                                <div class="text-muted small">342 KB</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingFile(this)">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="file-item d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fa-solid fa-file-word text-primary fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">Activity-Details.docx</div>
                                                <div class="text-muted small">156 KB</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExistingFile(this)">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

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
                                <i class="fa-solid fa-circle-info me-2"></i>
                                <small>Changing status to "Ongoing" will make this activity visible on the public page.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Activity ID Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-hashtag me-2"></i>Activity Details
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Activity ID</label>
                                <div class="fw-bold">#ACT-2024-001</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created By</label>
                                <div>Admin User</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">Created On</label>
                                <div>January 10, 2024</div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted small">Last Modified</label>
                                <div>January 15, 2024</div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fa-solid fa-chart-line me-2"></i>Progress
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Registered Participants</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">87</span>
                                    <span class="text-muted">/ 150</span>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: 58%"></div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted small">Budget Used</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">৳ 245,000</span>
                                    <span class="text-muted">/ ৳ 500,000</span>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 49%"></div>
                                </div>
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
                                <li class="mb-2">Define clear objectives</li>
                                <li class="mb-2">Set realistic budget limits</li>
                                <li class="mb-2">Add custom sections as needed</li>
                                <li class="mb-2">Include venue information</li>
                                <li class="mb-0">Update progress regularly</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow-sm">
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
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<style>

</style>



<?php require './components/footer.php'; ?>