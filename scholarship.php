<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donate';
?>
<?php require './components/header.php'; ?>
<style>
    .form-check img {
        width: 70px;
    }

    .custom-border {
        border: 1px solid #ccc;

    }
.donate-page .card-header-custom {
    background: linear-gradient(135deg, #02BD61 0%, #11844b 100%);
    color: #ffffff;
    padding: 2.5rem 2rem;
    border: none;
}
</style>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->
<div class="donate-home">
    <div class="home">
        <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
        <div class="home_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="home_content text-center">
                            <div data-aos="fade-up" class="home_title">Get Scholarship</div>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li>Scholarship</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="donate-page ">
    <div class="container mx-auto">
        <div class="row  d-flex justify-content-center ">
            <div class="">
                <div class="donation-card">
                    <!-- Header -->
                    <div class="card-header-custom">
                        <h4>Get a Scholarship Now</h4>
                        <p>Scholarship For Meritorious Students and Students with financial problems </p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">
                        <form id="donationForm" method="POST" action="">

                            <!-- Your Name -->
                            <div class="mb-3">
                                <label for="yourName" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="yourName" name="name" placeholder="Enter your full name">
                            </div>

                            <!-- Your Mail -->
                            <div class="mb-3">
                                <label for="yourmail" class="form-label">Your Mail</label>
                                <input type="email" class="form-control" id="yourmail" name="email" placeholder="Enter your email">
                            </div>
                            <!-- Address   -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Your Address</label>
                                <input type="text" class="form-control" id="youraddress" name="youraddress" placeholder="Enter your adderess">
                            </div>
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="institution-type" class="form-label">Institution Type</label>
                                <br>
                                <select class="w-100 px-4 py-3 rounded-2  category_options" id="category" name="category">
                                    <option value="">-- Select a category --</option>
                                    <option value="hifz">Hifz Program</option>
                                    <option value="school">School</option>
                                    <option value="college">College</option>
                                    <option value="university">University</option>
                                    <option value="madrasha-program">Madrasha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="institute-name" class="form-label">Institution Name</label>
                                <input type="text" class="form-control" id="instituename" name="instituename" placeholder="Enter your institure name">
                            </div>
                            <!-- Phone  -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">
                                    Phone
                                    <i class="bi bi-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="We'll send the receipt to this contact"></i>
                                </label>
                                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter phone number ">
                            </div>

                            <!-- Donate Button -->
                            <button type="submit" class=" my-3 btn btn-success btn-donate w-100">
                                <i class="bi bi-heart-fill me-2"></i>
                                <span>Apply Now</span>
                            </button>

                            <!-- Terms -->
                            <div class="terms-text">
                                By Applying you agree to our
                                <a href="#">Terms and Conditions</a> and
                                <a href="#">Privacy Policy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>