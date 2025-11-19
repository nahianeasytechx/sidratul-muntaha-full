<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donate';
?>
<?php require './components/header.php'; ?>

<style>
    /* ========================================= */
    /* DONATION FORM STYLES */
    /* ========================================= */
    .form-check img {
        width: 70px;
    }

    .form-check-label {
        padding-left: 0;
        margin-bottom: 0;
    }

    .custom-border {
        border: 1px solid #ccc;
    }

    .donate-page {
        margin: 50px 20px;
    }

    .section-description {
        font-size: 16px;
        line-height: 1.6;
        color: #555;
    }

    /* ========================================= */
    /* SECTION HEADER STYLES */
    /* ========================================= */
    .section-header {
        text-align: center;
        margin-bottom: 70px;
    }

    .section-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(0, 142, 72, 0.1);
        color: #008E48;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 48px;
        font-weight: 800;
        color: #0F2920;
        margin-bottom: 20px;
        margin-top: 0;
    }

    .section-subtitle {
        font-size: 18px;
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto;
    }

    /* ========================================= */
    /* MAJOR PROJECTS SECTION (GRID) */
    /* ========================================= */
    .projects-section {
        padding: 80px 0;
        background: #fff;
    }

    .project-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        margin-bottom: 30px;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .project-img {
        position: relative;
        height: 280px;
        overflow: hidden;
    }

    .project-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img img {
        transform: scale(1.1);
    }

    .project-body {
        padding: 35px;
    }

    .project-title {
        font-size: 26px;
        font-weight: 700;
        color: #0F2920;
        margin-bottom: 15px;
    }

    .project-text {
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .project-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(135deg, #008E48 0%, #00a854 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .project-btn:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 20px rgba(0, 142, 72, 0.3);
        color: #fff;
    }

    .see-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 48px;
        background: transparent;
        color: #008E48;
        border: 2px solid #008E48;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .see-all-btn:hover {
        background: #008E48;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 142, 72, 0.3);
    }

    /* ========================================= */
    /* ACTIVITIES SECTION (SLIDER) */
    /* ========================================= */
    .activities-section {
        padding: 80px 0;
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    /* ========================================= */
    /* COURSE CARD STYLES */
    /* ========================================= */
    .course {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .course_image {
        position: relative;
        overflow: hidden;
        height: 250px;
        flex-shrink: 0;
    }

    .course_image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .course:hover .course_image img {
        transform: scale(1.15);
    }

    .course_body {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course_tag {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(0, 142, 72, 0.1);
        color: #008E48;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .course_title h3 {
        font-size: 24px;
        font-weight: 700;
        color: #0F2920;
        margin: 20px 0 15px;
    }

    .course_title h3 a {
        color: #0F2920;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 24px;
        font-weight: 800;
    }

    .course_title h3 a:hover {
        color: #008E48;
    }

    .course_text {
        color: #6c757d;
        line-height: 1.7;
        font-size: 15px;
        margin-bottom: 20px;
        flex: 1;
    }

    /* ========================================= */
    /* CUSTOM SLIDER CONTAINER */
    /* ========================================= */
    .custom-slider-container {
        position: relative;
        padding: 0 70px;
        margin-top: 30px;
    }

    .custom-slider-wrapper {
        overflow: hidden;
        border-radius: 10px;
    }

    .custom-slider-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        will-change: transform;
    }

    .custom-slide {
        flex: 0 0 auto;
        width: calc(33.333% - 20px);
        margin-right: 30px;
    }

    .custom-slide:last-child {
        margin-right: 0;
    }

    /* ========================================= */
    /* SLIDER NAVIGATION BUTTONS */
    /* ========================================= */
    .custom-slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: #008E48;
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-slider-nav:hover {
        background: #00a854;
        transform: translateY(-50%) scale(1.1);
    }

    .custom-slider-nav:disabled {
        background: #ccc;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .custom-slider-prev {
        left: 0;
    }

    .custom-slider-next {
        right: 0;
    }

    /* ========================================= */
    /* SLIDER DOTS NAVIGATION */
    /* ========================================= */
    .custom-slider-dots {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }

    .slider-dot {
        width: 12px;
        height: 12px;
        background: #ddd;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        padding: 0;
    }

    .slider-dot:hover {
        background: #008E48;
        opacity: 0.7;
    }

    .slider-dot.active {
        background: #008E48;
        width: 30px;
        border-radius: 10px;
    }

    /* ========================================= */
    /* RESPONSIVE DESIGN */
    /* ========================================= */
    @media (max-width: 992px) {
        .custom-slide {
            width: calc(50% - 15px);
            margin-right: 30px;
        }

        .section-title {
            font-size: 40px;
        }
    }

    @media (max-width: 768px) {
        .custom-slider-container {
            padding: 0 60px;
        }

        .custom-slide {
            width: 100%;
            margin-right: 0;
        }

        .custom-slider-nav {
            width: 45px;
            height: 45px;
            font-size: 20px;
        }

        .section-title {
            font-size: 36px;
        }

        .section-subtitle {
            font-size: 16px;
        }
    }

    @media (max-width: 576px) {
        .donate-page {
            margin-top: 70px;
        }

        .custom-slider-container {
            padding: 0 50px;
        }

        .custom-slider-nav {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .section-title {
            font-size: 28px;
        }

        .course_image {
            height: 200px;
        }

        .course_body {
            padding: 20px;
        }

        .course_title h3 {
            font-size: 20px;
        }

        .project-img {
            height: 220px;
        }
    }
</style>

<!--=======================================================================-->
<!------------------------ CONTENT START ------------------------------------->
<!--=======================================================================-->

<!-- Hero Section -->
<div class="donate-home">
    <div class="home">
        <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
        <div class="home_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="home_content text-center">
                            <div data-aos="fade-up" class="home_title">Donate Now</div>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li>Donate</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Donation Form Section -->
<div class="donate-page">
    <div class="container">
        <div class="row">
            <!-- Left Column: Information -->
            <div data-aos="fade-up" class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <div>
                    <h3 class="section-title">Make a Difference Today</h3>
                    <p class="section-description">
                        Your donation is endless possibilities. Educate a child with Sidratul Muntaha Foundation.”
                        <br><br>
                        Together, we can uplift lives, nurture faith, and build a brighter future — support Sidratul
                        Muntaha Foundation today.
                        <br><br>
                        Together, we can uplift lives, nurture faith, and build a brighter future — support Sidratul
                        Muntaha Foundation today.
                        <br><br>
                        Supporting a madrasha is planting the seeds of knowledge that will shade generations
                        to come.
                        <br><br>
                        Your donation to Sidratul Muntaha Foundation helps provide education, books, and a
                        brighter future for underprivileged children.
                        <br><br>
                    </p>
                </div>
                <img src="images/Financial Support For Madrasha Students.jpeg" alt="Financial Support" class="w-100">
                <p class="section-description mt-2">
                    Whoever teaches knowledge will have the reward of those who act upon it.” — Prophet
                    Muhammad ﷺ
                    <br><br>
                    Through Sidratul Muntaha Foundation, your donation supports Islamic and academic
                    education for children in need.
                    <br><br>
                    📘 Every book, every pen, every lesson — becomes sadaqah jariyah that lives beyond
                    your lifetime.
                </p>
            </div>

            <!-- Right Column: Donation Form -->
            <div class="col-lg-6 col-md-12">
                <div class="donation-card">
                    <div class="card-header-custom">
                        <h4>হাত বাড়ান দুর্গতের প্রতি</h4>
                        <p>বন্যা, ঘূর্ণিঝড়, অগ্নিকাণ্ড—প্রতিটি দুর্যোগে অসহায় মানুষের পাশে আছে সিদরাতুল মুনতাহা ফাউন্ডেশন। এই মানবিক অভিযাত্রায় আপনিও আমাদের সঙ্গী হতে পারেন।</p>
                    </div>

                    <div class="card-body p-4">
                        <form id="donationForm" method="POST" action="">
                            <!-- Merchant Info -->
                            <div class="merchant-info">
                                <strong>
                                    <i class="bi bi-phone-fill"></i>
                                    Bkash/Nagad: 012345678921
                                </strong>
                                <small>Donate by choosing the payment option below</small>
                            </div>

                            <!-- Quick Amount Selection -->
                            <div class="amount-grid">
                                <button type="button" class="amount-btn" data-amount="100">৳ 100</button>
                                <button type="button" class="amount-btn" data-amount="500">৳ 500</button>
                                <button type="button" class="amount-btn" data-amount="1000">৳ 1,000</button>
                                <button type="button" class="amount-btn" data-amount="5000">৳ 5,000</button>
                                <button type="button" class="amount-btn" data-amount="10000">৳ 10,000</button>
                                <button type="button" class="amount-btn" id="otherBtn">Other</button>
                            </div>

                            <!-- Donation Amount -->
                            <div class="mb-3">
                                <label for="donationAmount" class="form-label">
                                    Donation Amount <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" class="form-control" id="donationAmount" name="amount" placeholder="Enter amount" value="100" required min="10">
                                </div>
                            </div>

                            <!-- Your Name -->
                            <div class="mb-3">
                                <label for="yourName" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="yourName" name="name" placeholder="Enter your full name">
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">
                                    Phone
                                    <i class="bi bi-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="We'll send the receipt to this contact"></i>
                                </label>
                                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter phone number">
                            </div>

                            <!-- Your Mail -->
                            <div class="mb-3">
                                <label for="yourmail" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="yourmail" name="email" placeholder="Enter your email">
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Your Address</label>
                                <textarea class="form-control" id="youraddress" name="youraddress" placeholder="Enter your address"></textarea>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <br>
                                <select class="w-100 px-4 py-3 rounded-2 category_options" id="category" name="category">
                                    <option value="">-- Select a category --</option>
                                    <option value="mosque-fund">Mosque Project</option>
                                    <option value="madrasha-fund">Madrasha Project</option>
                                    <option value="school">School Project</option>
                                    <option value="hospital">Hospital Project</option>
                                    <option value="zakat">Zakatul Sadaka</option>
                                    <option value="disaster-relief">Disaster Relief</option>
                                    <option value="education-support">Education Support</option>
                                    <option value="orphan-homeless">Food & Financial Aid Support For Orphan & Homeless</option>
                                    <option value="tree-plantation">Plant A Tree</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Donate on behalf of -->
                            <div class="mb-3">
                                <label for="onBehalfOf" class="form-label">Donate on behalf of</label>
                                <input type="text" class="form-control" id="onBehalfOf" name="behalf_of" placeholder="Optional: Someone's name">
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Payment Method <span class="required">*</span>
                                </label>
                                <div class="payment-method">
                                    <div class="form-check d-flex">
                                        <div class="d-flex p-1">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="sslcommerz" value="sslcommerz" checked>
                                            <label class="form-check-label d-flex align-items-center" for="sslcommerz">
                                                <span class="badge"><img src="images/ssl logo.png" alt="SSL"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex p-1 mx-3">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="bkash" value="bkash">
                                            <label class="form-check-label d-flex align-items-center" for="bkash">
                                                <span class="badge"><img src="images/bkash.png" alt="Bkash"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex p-1 mx-3">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="nagad" value="nagad">
                                            <label class="form-check-label d-flex align-items-center" for="nagad">
                                                <span class="badge"><img src="images/nogod.png" alt="Nagad"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex p-1 mx-3">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="paypal" value="paypal">
                                            <label class="form-check-label d-flex align-items-center" for="paypal">
                                                <span class="badge"><img src="images/paypal.png" alt="Paypal"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax Relief Info -->
                            <div class="info-box">
                                <p>
                                    <i class="bi bi-gift-fill me-2"></i>
                                    <strong>Tax Relief Available!</strong> You will receive tax relief when you donate to Sidratul Muntaha Foundation.
                                    <a href="#">Learn more</a>
                                </p>
                            </div>

                            <!-- Donate Button -->
                            <button type="submit" class="my-3 btn btn-success btn-donate w-100">
                                <i class="bi bi-heart-fill me-2"></i>
                                <span>Donate Now</span>
                            </button>

                            <!-- Terms -->
                            <div class="terms-text">
                                By donating you agree to our
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

<!-- Major Projects Section (Grid Layout) -->
<div class="projects-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">MAJOR INITIATIVES</span>
            <h2 class="section-title">Our Major Projects</h2>
            <p class="section-subtitle">Building infrastructure for long-term community development</p>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="200">
            <!-- Project Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <div class="project-img">
                        <img src="images/hospital.png" alt="Hospital">
                    </div>
                    <div class="project-body">
                        <h3 class="project-title">Hospital Project</h3>
                        <p class="project-text">Providing quality healthcare services to underserved communities with compassion and excellence.</p>
                        <a href="donate.php" class="project-btn mt-3">
                            Donate Now
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <div class="project-img">
                        <img src="images/school.png" alt="School">
                    </div>
                    <div class="project-body">
                        <h3 class="project-title">School Project</h3>
                        <p class="project-text">Building educational institutions that nurture both Islamic values and modern knowledge for future generations.</p>
                        <a href="donate.php" class="project-btn mt-3">
                            Donate Now
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <div class="project-img">
                        <img src="images/mosque.png" alt="Mosque">
                    </div>
                    <div class="project-body">
                        <h3 class="project-title">Mosque Project</h3>
                        <p class="project-text">Creating spiritual centers for worship, learning, and community gathering for all Muslims.</p>
                        <a href="donate.php" class="project-btn mt-3">
                            Donate Now
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="donation-fund.php" class="see-all-btn">
                View All Projects
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Social Projects Slider -->
<div class="activities-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">WHAT WE DO</span>
            <h2 class="section-title">Our Social Works</h2>
            <p class="section-subtitle">Making a difference through meaningful actions and sustainable projects</p>
        </div>

        <div class="custom-slider-container" data-aos="fade-up" data-aos-delay="200">
            <div class="custom-slider-wrapper">
                <div class="custom-slider-track">

                    <!-- Slide 1: Tree Plantation -->
                    <div class="custom-slide">
                        <div class="course">
                            <div class="course_image">
                                <a href="project-details.php">
                                    <img src="images/tree-plantation.webp" alt="Tree Plantation">
                                </a>
                            </div>
                            <div class="course_body">
                                <div class="course_header">
                                    <span class="course_tag">Social Projects</span>
                                </div>
                                <div class="course_title">
                                    <h3><a href="project-details.php">School Project</a></h3>
                                </div>
                                <div class="course_text">Building educational institutions that nurture both Islamic values and modern knowledge for future generations.</div>
                                <a href="project-details.php" class="project-btn mt-3">
                                    See Details
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5: Hospital Project -->
                    <div class="custom-slide">
                        <div class="course">
                            <div class="course_image">
                                <a href="project-details.php">
                                    <img src="images/hospital.png" alt="Hospital Project">
                                </a>
                            </div>
                            <div class="course_body">
                                <div class="course_header">
                                    <span class="course_tag">Healthcare</span>
                                </div>
                                <div class="course_title">
                                    <h3><a href="project-details.php">Hospital Project</a></h3>
                                </div>
                                <div class="course_text">Providing quality healthcare services to underserved communities with compassion and excellence.</div>
                                <a href="project-details.php" class="project-btn mt-3">
                                    See Details
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6: Mosque Project -->
                    <div class="custom-slide">
                        <div class="course">
                            <div class="course_image">
                                <a href="project-details.php">
                                    <img src="images/mosque.png" alt="Mosque Project">
                                </a>
                            </div>
                            <div class="course_body">
                                <div class="course_header">
                                    <span class="course_tag">Religious</span>
                                </div>
                                <div class="course_title">
                                    <h3><a href="project-details.php">Mosque Project</a></h3>
                                </div>
                                <div class="course_text">Creating spiritual centers for worship, learning, and community gathering for all Muslims.</div>
                                <a href="project-details.php" class="project-btn mt-3">
                                    See Details
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Navigation Buttons -->
            <button class="custom-slider-nav custom-slider-prev" aria-label="Previous">
                <i class="fa fa-angle-left"></i>
            </button>
            <button class="custom-slider-nav custom-slider-next" aria-label="Next">
                <i class="fa fa-angle-right"></i>
            </button>

            <!-- Dots Navigation -->
            <div class="custom-slider-dots"></div>
        </div>
    </div>
</div>

<!--=======================================================================-->
<!------------------------ CONTENT END ---------------------------------------->
<!--=======================================================================-->

<script>
    // ================================================================
    // INFINITE LOOP SLIDER JAVASCRIPT - FIXED VERSION
    // ================================================================
    document.addEventListener('DOMContentLoaded', function() {
        const sliderWrapper = document.querySelector('.custom-slider-wrapper');
        const sliderTrack = document.querySelector('.custom-slider-track');
        const slides = document.querySelectorAll('.custom-slide');
        const prevBtn = document.querySelector('.custom-slider-prev');
        const nextBtn = document.querySelector('.custom-slider-next');
        const dotsContainer = document.querySelector('.custom-slider-dots');

        if (!sliderTrack || slides.length === 0) return;

        let currentIndex = 0;
        let slidesPerView = 3;
        let autoPlayInterval;
        let isTransitioning = false;
        let slideWidth = 0;
        let gap = 30;

        // Clone slides for infinite loop
        function cloneSlides() {
            // Remove any existing clones
            const existingClones = sliderTrack.querySelectorAll('.clone');
            existingClones.forEach(clone => clone.remove());

            // Clone first set of slides and append to end
            slides.forEach(slide => {
                const cloneEnd = slide.cloneNode(true);
                cloneEnd.classList.add('clone');
                sliderTrack.appendChild(cloneEnd);
            });

            // Clone last set of slides and prepend to start
            for (let i = slides.length - 1; i >= 0; i--) {
                const cloneStart = slides[i].cloneNode(true);
                cloneStart.classList.add('clone');
                sliderTrack.insertBefore(cloneStart, sliderTrack.firstChild);
            }
        }

        // Calculate slides per view based on window width
        function updateSlidesPerView() {
            const width = window.innerWidth;
            if (width < 768) {
                slidesPerView = 1;
                gap = 0;
            } else if (width < 992) {
                slidesPerView = 2;
                gap = 30;
            } else {
                slidesPerView = 3;
                gap = 30;
            }
        }

        // Calculate dimensions
        function calculateDimensions() {
            const containerWidth = sliderWrapper.offsetWidth;
            slideWidth = (containerWidth - (gap * (slidesPerView - 1))) / slidesPerView;

            // Update all slides width
            const allSlides = sliderTrack.querySelectorAll('.custom-slide');
            allSlides.forEach(slide => {
                slide.style.width = `${slideWidth}px`;
                slide.style.marginRight = gap > 0 ? `${gap}px` : '0';
            });
        }

        // Get total number of original slides
        function getTotalSlides() {
            return slides.length;
        }

        // Calculate transform value
        function calculateTransform(index) {
            // Offset by the number of cloned slides at the start
            const offset = slides.length;
            const actualIndex = offset + index;
            return actualIndex * (slideWidth + gap);
        }

        // Go to specific slide
        function goToSlide(index, instant = false) {
            if (isTransitioning && !instant) return;

            const totalSlides = getTotalSlides();

            if (instant) {
                sliderTrack.style.transition = 'none';
                currentIndex = index;
            } else {
                sliderTrack.style.transition = 'transform 0.5s ease-in-out';
                currentIndex = index;
                isTransitioning = true;
            }

            const transformValue = calculateTransform(currentIndex);
            sliderTrack.style.transform = `translateX(-${transformValue}px)`;

            updateDots();

            if (!instant) {
                setTimeout(() => {
                    isTransitioning = false;

                    // Handle infinite loop
                    if (currentIndex >= totalSlides) {
                        // We've gone past the end, jump to start
                        currentIndex = 0;
                        goToSlide(0, true);
                    } else if (currentIndex < 0) {
                        // We've gone before the start, jump to end
                        currentIndex = totalSlides - 1;
                        goToSlide(totalSlides - 1, true);
                    }
                }, 500);
            }
        }

        // Next slide
        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        // Previous slide
        function prevSlide() {
            goToSlide(currentIndex - 1);
        }

        // Create dots (only for original slides)
        function createDots() {
            dotsContainer.innerHTML = '';
            const totalSlides = getTotalSlides();

            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.classList.add('slider-dot');
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                if (i === currentIndex) {
                    dot.classList.add('active');
                }
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
        }

        // Update dots
        function updateDots() {
            const dots = document.querySelectorAll('.slider-dot');
            const totalSlides = getTotalSlides();

            // Handle wrapping for dot display
            let displayIndex = currentIndex % totalSlides;
            if (displayIndex < 0) displayIndex = totalSlides + displayIndex;

            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === displayIndex);
            });
        }

        // Auto play
        function startAutoPlay() {
            stopAutoPlay();
            autoPlayInterval = setInterval(nextSlide, 4000);
        }

        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        }

        // Event listeners
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoPlay();
            startAutoPlay();
        });

        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoPlay();
            startAutoPlay();
        });

        // Pause on hover
        sliderWrapper.addEventListener('mouseenter', stopAutoPlay);
        sliderWrapper.addEventListener('mouseleave', startAutoPlay);

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                updateSlidesPerView();
                calculateDimensions();
                goToSlide(currentIndex, true);
            }, 250);
        });

        // Touch/swipe support
        let touchStartX = 0;
        let touchEndX = 0;
        let touchStartY = 0;
        let touchEndY = 0;

        sliderWrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
            stopAutoPlay();
        }, {
            passive: true
        });

        sliderWrapper.addEventListener('touchmove', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
        }, {
            passive: true
        });

        sliderWrapper.addEventListener('touchend', () => {
            const diffX = touchStartX - touchEndX;
            const diffY = touchStartY - touchEndY;

            // Only trigger if horizontal swipe is dominant
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    nextSlide(); // Swipe left
                } else {
                    prevSlide(); // Swipe right
                }
            }

            startAutoPlay();
        });

        // Initialize slider
        updateSlidesPerView();
        cloneSlides();
        calculateDimensions();
        createDots();
        goToSlide(0, true);
        startAutoPlay();
    });
</script>
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?><a href="project-details.php">