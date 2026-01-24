<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Contact';
require './components/header.php';


// Handle contact form submission
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $result = saveContactSubmission($_POST);
    if ($result['success']) {
        $success_msg = $result['message'];
    } else {
        $error_msg = $result['message'];
    }
}

// Get contact information from settings table
$contact_info = getContactInformation();
?>

<style>
.contact_form_container {
    margin-top: 38px;
}
    @media only screen and (max-width: 1600px) {
    .contact_content {
        width: 100%;
        padding-top: 55px;
        padding-left: 45px;
    }
}
    @media only screen and (max-width: 1199px) {
    .contact_info_container {
        padding-top: 0;
        padding-left: 0;
        margin-top: 50px;
    }
}
    @media only screen and (max-width: 991px) {
        .contact_content {
            padding-left: 57px;
            padding-right: 57px;
            padding-top: 0px;
        }
    }
    @media only screen and (max-width: 768px) {
.contact_form_container {
    margin-top: 30px;
}
    }

    @media(max-width:575px) {
        .contact_content {
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 10px;
            padding-bottom: 25px;
        }

        .contact_form_container {
            margin-top: 34px;
        }

        .contact_info_container {

            margin-top: 30px;
        }
    }
</style>

<!-- Home -->
<div class="contact-home">
    <div class="home">
        <!-- Background image artist https://unsplash.com/@thepootphotographer -->
        <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/contact.jpg" data-speed="0.8"></div>
        <div class="home_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="home_content text-center">
                            <div data-aos="fade-up" class="home_title">Contact</div>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li>Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact -->
<div class="contact">
    <div class="container-fluid">
        <!-- Success/Error Messages -->
        <?php if ($success_msg): ?>
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #a7f3d0;">
                <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #fecaca;">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <div class="row row-xl-eq-height">
            <!-- Contact Content -->
            <div class="col-xl-6">
                <div class="contact_content">
                    <div class="row">
                        <div class="col-xl-12">
                            <div data-aos="fade-up" data-aos-delay="300" class="contact_info_container">
                                <div class="contact_info_main_title">Contact Us</div>
                                <div class="contact_info">
                                    <div class="contact_info_item">
                                        <div class="contact_info_title">Address:</div>
                                        <div class="contact_info_line"><?php echo htmlspecialchars($contact_info['address']); ?></div>
                                    </div>
                                    <div class="contact_info_item">
                                        <div class="contact_info_title">Phone:</div>
                                        <div class="contact_info_line"><?php echo htmlspecialchars($contact_info['phone']); ?></div>
                                    </div>
                                    <div class="contact_info_item">
                                        <div class="contact_info_title">Email:</div>
                                        <div class="contact_info_line"><?php echo htmlspecialchars($contact_info['email']); ?></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-up" class="contact_form_container">
                        <form method="POST" action="" id="contact_form" class="contact_form">
                            <div>
                                <div class="row">
                                    <div class="col-lg-6 contact_name_col">
                                        <input type="text" name="name" class="contact_input" placeholder="Name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="email" name="email" class="contact_input" placeholder="E-mail" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="text" name="subject" class="contact_input" placeholder="Subject" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                            </div>
                            <div>
                                <textarea name="message" class="contact_input contact_textarea" placeholder="Message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                            </div>
                            <button type="submit" name="send_message" class="contact_button">
                                <span>send message</span>
                                <span class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Map -->
            <div class="col-xl-6 map_col">
                <div class="contact_map">
                    <!-- Google Map -->
                    <div id="google_map" class="google_map">
                        <div class="map_container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58790.02152727385!2d90.2768431486328!3d23.796921200000018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c1d40efc5951%3A0x2f0cda725c721b32!2sMirpur%20Tower!5e1!3m2!1sen!2sbd!4v1768297251481!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-100"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>