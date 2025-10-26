<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Slider Management';
?>
<?php require './components/header.php'; ?>



<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-image-multiple"></i>
            </span> Slider Management
        </h3>
    </div>
    <br>

    <!-- Display Existing Slider Images -->
    <div class="row">
        <div class="col-md-7">
            <h1>Existing Slider Images</h1>

            <div class="card p-3 rounded-0">
                <div class="slider-images">
                    <!-- Slider Item 1 -->
                    <div class="slider-item border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0">Image No: 1</h4>
                            <span class="badge bg-secondary">Order: 1</span>
                        </div>
                        <img src="../img/compressed_banner1.jpg" alt="Slider Image" class="slider-img img-fluid mb-3" style="max-height: 300px; object-fit: cover; width: 100%;">

                        <div class="slider-info mb-3">
                            <h5 class="mb-2">Welcome to Our Organization</h5>
                            <p class="text-muted mb-2">Join us in making a difference in our community through various social initiatives and programs.</p>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="badge bg-primary">
                                    <i class="fa-solid fa-link me-1"></i>
                                    Community Clean-up Drive
                                </span>
                                <span class="badge bg-info">
                                    <i class="fa-solid fa-hand-pointer me-1"></i>
                                    "Join Now"
                                </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm" onclick="editSlider(1)">
                                <i class="fa-solid fa-pen me-1"></i>Edit
                            </button>
                            <button onclick="confirmDelete(1)" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>

                    <hr>



                </div>
            </div>
        </div>

        <div class="col-md-5">
            <!-- Add New Slider Image -->
            <form action="" method="POST" enctype="multipart/form-data" id="sliderForm">
                <h1>Add Slider Image</h1>
                <div class="card p-4 rounded-0">
                    <!-- Image Upload -->
                    <div class="mb-3 d-flex justify-content-center ">
                        <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                    <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                    <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="text">
                                <span>Click to upload image</span>
                            </div>
                            <input type="file" id="file" name="slider_img" required accept="image/*">
                        </label>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="slider_title" class="form-label fw-bold">
                            Slider Title <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="slider_title"
                            name="slider_title"
                            placeholder="Enter slider title"
                            required
                            maxlength="100">
                        <small class="text-muted">Maximum 100 characters</small>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="slider_description" class="form-label fw-bold">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control"
                            id="slider_description"
                            name="slider_description"
                            rows="4"
                            placeholder="Enter slider description"
                            required
                            maxlength="250"></textarea>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Maximum 250 characters</small>
                            <small class="text-muted"><span id="charCount">0</span>/250</small>
                        </div>
                    </div>



                    <!-- Button Text (Optional) -->
                    <div class="mb-3" id="buttonTextSection" style="display: none;">
                        <label for="button_text" class="form-label fw-bold">
                            Button Text <span class="text-muted">(Optional)</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="button_text"
                            name="button_text"
                            placeholder="e.g., Learn More, Register Now, Join Us"
                            maxlength="30">
                        <small class="text-muted">Default is "Learn More" if left empty</small>
                    </div>



                    <input class="btn btn-submit w-100" type="submit" name="add_slider" value="Add Slider">
                </div>
            </form>
        </div>
    </div>
    <br>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->






<?php require './components/footer.php'; ?>