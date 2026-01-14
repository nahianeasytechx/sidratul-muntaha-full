<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donate';
require './components/header.php';

// Get all donation categories from database
$donationCategories = getAllDonationCategories();

// Handle form submission
$message = '';
$message_type = '';
$form_values = [
    'amount' => '',
    'name' => '',
    'contact' => '',
    'email' => '',
    'youraddress' => '',
    'category' => '',
    'behalf_of' => '',
    'payment_method' => 'sslcommerz'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['youraddress']) ? trim($_POST['youraddress']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $behalf_of = isset($_POST['behalf_of']) ? trim($_POST['behalf_of']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : 'sslcommerz';

    $form_values = [
        'amount' => $amount,
        'name' => $name,
        'contact' => $contact,
        'email' => $email,
        'youraddress' => $address,
        'category' => $category,
        'behalf_of' => $behalf_of,
        'payment_method' => $payment_method
    ];

    if ($amount <= 0) {
        $message = 'Please enter a valid donation amount.';
        $message_type = 'error';
    } elseif (empty($name)) {
        $message = 'Please enter your name.';
        $message_type = 'error';
    } elseif (empty($payment_method)) {
        $message = 'Please select a payment method.';
        $message_type = 'error';
    } else {
        $category_id = null;
        if (!empty($category)) {
            $selectedCategory = getDonationCategoryBySlug($category);
            if ($selectedCategory) {
                $category_id = $selectedCategory['id'];
            }
        }

        $donation_data = [
            'amount' => $amount,
            'name' => $name,
            'contact' => $contact,
            'email' => $email,
            'address' => $address,
            'category_id' => $category_id,
            'behalf_of' => $behalf_of,
            'payment_method' => $payment_method,
            'payment_status' => 'pending'
        ];

        if (function_exists('createDonation')) {
            $result = createDonation($donation_data);
            if ($result['success']) {
                $message = 'Thank you for your donation! Transaction ID: ' . $result['transaction_id'];
                $message_type = 'success';
                $form_values = array_fill_keys(array_keys($form_values), '');
                $form_values['payment_method'] = 'sslcommerz';
            } else {
                $message = 'Error: ' . $result['message'];
                $message_type = 'error';
            }
        } else {
            $message = 'Thank you for your donation of ৳' . number_format($amount, 2);
            $message_type = 'success';
            $form_values = array_fill_keys(array_keys($form_values), '');
            $form_values['payment_method'] = 'sslcommerz';
        }
    }
}
?>

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

<div class="donate-page">
    <div class="container">
        <?php if ($message): ?>
            <div class="alert-message alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div data-aos="fade-up" class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <div id="categoryInfoSection">
                    <div id="defaultContent">
                        <h3 class="section-title">Make a Difference Today</h3>
                        <p class="section-description">
                            Your donation is endless possibilities. Educate a child with Sidratul Muntaha Foundation.
                            <br><br>
                            Together, we can uplift lives, nurture faith, and build a brighter future.
                        </p>
                        <img src="images/Financial Support For Madrasha Students.jpeg" alt="Financial Support" class="w-100 rounded mb-3">

                    </div>

                    <div id="dynamicContent" style="display: none;">
                        <h3 class="section-title" id="dynamicTitle"></h3>
                        <p class="section-description" id="dynamicDescription"></p>
                        <img id="dynamicImage" src="" alt="" class="w-100 rounded mb-3" style="max-height: 400px; object-fit: cover;">
                    </div>
                    <p>In Islam, giving in charity, known as Sadaqah or Zakat, is considered a fundamental act of worship and compassion. It is a way to purify one’s wealth, help those in need, and earn Allah’s blessings. The Quran emphasizes helping the poor, supporting orphans, and assisting the vulnerable in society.

                        Zakat is obligatory for eligible Muslims, calculated as a fixed percentage of wealth, while Sadaqah is voluntary and can be given at any time. Donations are not only a form of financial support but also a means to promote social justice, reduce inequality, and foster a caring community.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="donation-card">
                    <div class="card-header-custom">
                        <h4>Make Your Donation </h4>
                        <p>Join us in creating a stronger, healthier, and more compassionate society, where every effort contributes to the well-being and progress of our communities.</p>

                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="donationAmount" class="form-label">
                                    Donation Amount <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" class="form-control" id="donationAmount" name="amount"
                                        placeholder="Enter amount"
                                        value="<?php echo htmlspecialchars($form_values['amount'] ?: ''); ?>"
                                        required min="10" step="any">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="yourName" class="form-label">Your Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="yourName" name="name"
                                    placeholder="Enter your full name"
                                    value="<?php echo htmlspecialchars($form_values['name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="contact" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="contact" name="contact"
                                    placeholder="Enter phone number"
                                    value="<?php echo htmlspecialchars($form_values['contact']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="yourmail" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="yourmail" name="email"
                                    placeholder="Enter your email"
                                    value="<?php echo htmlspecialchars($form_values['email']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Your Address</label>
                                <textarea class="form-control" id="youraddress" name="youraddress"
                                    placeholder="Enter your address"><?php echo htmlspecialchars($form_values['youraddress']); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="w-100 px-4 py-3 rounded-2 category_options" id="category" name="category">
                                    <option value="">-- Select a category --</option>
                                    <?php foreach ($donationCategories as $cat): ?>
                                        <?php
                                        $image = '';
                                        if (!empty($cat['image'])) {
                                            // Remove ../ if present
                                            $image = preg_replace('/^\.\.\//', '', $cat['image']);
                                        }
                                        ?>
                                        <option value="<?php echo htmlspecialchars($cat['slug']); ?>"
                                            data-title="<?php echo htmlspecialchars($cat['title']); ?>"
                                            data-description="<?php echo htmlspecialchars($cat['description']); ?>"
                                            data-image="<?php echo htmlspecialchars($image); ?>"
                                            <?php echo ($form_values['category'] == $cat['slug']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="onBehalfOf" class="form-label">Donate on behalf of</label>
                                <input type="text" class="form-control" id="onBehalfOf" name="behalf_of"
                                    placeholder="Optional: Someone's name"
                                    value="<?php echo htmlspecialchars($form_values['behalf_of']); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Payment Method <span class="required">*</span></label>
                                <div class="payment-method">
                                    <div class="form-check d-flex">
                                        <?php
                                        $payment_methods = [
                                            'sslcommerz' => 'images/ssl logo.png',
                                            'bkash' => 'images/bkash.png',
                                            'nagad' => 'images/nogod.png',
                                            'paypal' => 'images/paypal.png'
                                        ];
                                        foreach ($payment_methods as $method => $image) {
                                            $checked = ($form_values['payment_method'] == $method) ? 'checked' : '';
                                            echo '<div class="d-flex p-1 ' . ($method != 'sslcommerz' ? 'mx-3' : '') . '">
                                                    <input class="form-check-input mt-2" type="radio" name="payment_method" id="' . $method . '" value="' . $method . '" ' . $checked . '>
                                                    <label class="form-check-label d-flex align-items-center" for="' . $method . '">
                                                        <span class="badge"><img src="' . $image . '" alt="' . ucfirst($method) . '"></span>
                                                    </label>
                                                </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="info-box">
                                <p><i class="bi bi-gift-fill me-2"></i><strong>Tax Relief Available!</strong> You will receive tax relief when you donate. <a href="#">Learn more</a></p>
                            </div>

                            <button type="submit" class="my-3 btn btn-success btn-donate w-100">
                                <i class="bi bi-heart-fill me-2"></i><span>Donate Now</span>
                            </button>

                            <div class="terms-text">
                                By donating you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const defaultContent = document.getElementById('defaultContent');
        const dynamicContent = document.getElementById('dynamicContent');
        const dynamicTitle = document.getElementById('dynamicTitle');
        const dynamicImage = document.getElementById('dynamicImage');
        const dynamicDescription = document.getElementById('dynamicDescription');

        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (this.value === '') {
                // Show default content
                defaultContent.style.display = 'block';
                dynamicContent.style.display = 'none';
            } else {
                // Get data from selected option
                const title = selectedOption.getAttribute('data-title');
                const description = selectedOption.getAttribute('data-description');
                const image = selectedOption.getAttribute('data-image');

                // Update dynamic content
                dynamicTitle.textContent = title;
                dynamicDescription.textContent = description;
                dynamicImage.src = image;
                dynamicImage.alt = title;

                // Show dynamic content
                defaultContent.style.display = 'none';
                dynamicContent.style.display = 'block';
            }
        });
    });
</script>

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

    /* Message styles */
    .alert-message {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .text-elipsis {
        width: 300px;
        height: 50px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: wrap;
        -webkit-line-clamp: 2;
        /* Number of lines to show */
        line-clamp: 2;
        /* Official property */
        -webkit-box-orient: vertical;
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