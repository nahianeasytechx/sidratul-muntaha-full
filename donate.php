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

<div class="donate-page ">
    <div class="container">
        <div class="row ">
            <div data-aos="fade-up" class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <div>
                    <h3 class="section-title">Make a Difference Today</h3>
                    <p class="section-description">
                        Your generous donation helps us continue our mission to support communities in need.
                        Every contribution, no matter the size, makes a significant impact in transforming lives
                        and building a better future together.
                    </p>

                    <p class="section-description">
                        Join thousands of donors who are already making a difference. Your support provides
                        essential resources, education, and hope to those who need it most.
                    </p>
                </div>
                <img src="images/Financial Support For Madrasha Students.jpeg" alt="" class="w-100 ">
                <p class="section-description pt-3">
                    Bangladesh is a country prone to natural disasters. Every year, millions of people are affected by floods, cyclones, tidal waves, landslides and other natural disasters. Especially during the rainy season, about 26,000 square kilometers (18%) of the country is flooded, which causes extreme suffering and displacement of people in various regions, including the northern region. In addition, the lives of helpless people are disrupted by various disasters including cyclones, fires, cold waves. As-Sunnah Foundation has been working tirelessly to stand by the people affected by disasters across the country. Since its establishment, we have been implementing relief activities in emergency situations as well as long-term rehabilitation programs in various disasters.
                </p>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="donation-card">
                    <!-- Header -->
                    <div class="card-header-custom">
                        <h4>হাত বাড়ান দুর্গতের প্রতি</h4>
                        <p>বন্যা, ঘূর্ণিঝড়, অগ্নিকাণ্ড—প্রতিটি দুর্যোগে অসহায় মানুষের পাশে আছে সিদরাতুল মুনতাহা ফাউন্ডেশন। এই মানবিক অভিযাত্রায় আপনিও আমাদের সঙ্গী হতে পারেন।</p>
                    </div>

                    <!-- Body -->
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
                            <!-- Your Mail -->
                            <div class="mb-3">
                                <label for="yourmail" class="form-label">Your Mail</label>
                                <input type="email" class="form-control" id="yourmail" name="name" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Your Address</label>
                                <input type="text" class="form-control" id="youraddress" name="youraddress" placeholder="Enter your adderess">
                            </div>
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <br>
                                <select class="w-100 px-4 py-3 rounded-2  category_options" id="category" name="category">
                                    <option value="">-- Select a category --</option>
                                    <option value="mosque-fund">Mosque Project</option>
                                    <option value="madrasha-fund">Madrasha Project</option>
                                    <option value="school">School Project</option>
                                    <option value="hospital">Hospital Project</option>
                                    <option value="zakat">Zakatul Sadaka</option>
                                    <option value="disaster-relief">Disaster Relief</option>
                                    <option value="education-support">Education Support</option>
                                    <option value="food-financial">Food and Financial Aid Support</option>
                                    <option value="orphan-homeless">For Orphan and Homeless</option>
                                    <option value="disaster-relief">Disaster Relief</option>
                                    <option value="tree-plantation">Tree Plantation</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Phone  -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">
                                    Phone
                                    <i class="bi bi-info-circle tooltip-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="We'll send the receipt to this contact"></i>
                                </label>
                                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter phone number ">
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
                                    <div class="form-check">
                                        <div class="d-flex p-1">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="sslcommerz" value="sslcommerz" checked>
                                            <label class="form-check-label d-flex align-items-center" for="sslcommerz">
                                                <span class="badge"><img src="images/ssl logo.png" alt=""></span>
                                            </label>
                                        </div>

                                        <div class="d-flex p-1">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="bkash" value="bkash">
                                            <label class="form-check-label d-flex align-items-center" for="bkash">
                                                <span class="badge"><img src="images/bkash.png" alt=""></span>
                                            </label>
                                        </div>

                                        <div class="d-flex p-1">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="nagad" value="nagad">
                                            <label class="form-check-label d-flex align-items-center" for="nagad">
                                                <span class="badge"><img src="images/nogod.png" alt=""></span>
                                            </label>
                                        </div>

                                        <div class="d-flex p-1">
                                            <input class="form-check-input mt-2" type="radio" name="payment_method" id="paypal" value="paypal">
                                            <label class="form-check-label d-flex align-items-center" for="paypal">
                                                <span class="badge"><img src="images/paypal.png" alt=""></span>
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
                            <button type="submit" class=" my-3 btn btn-success btn-donate w-100">
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



<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>