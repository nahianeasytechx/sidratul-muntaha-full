<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Contact'; // Set the page title
?>
<?php require './components/header.php'; ?>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

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
			<div class="row row-xl-eq-height">
				<!-- Contact Content -->
				<div class="col-xl-6">
					<div class="contact_content">
						<div class="row">
							<div class="col-xl-12">
								<div data-aos="fade-up" data-aos-delay="300"  class="contact_info_container">
									<div class="contact_info_main_title">Contact Us</div>
									<div class="contact_info">
										<div class="contact_info_item">
											<div class="contact_info_title">Address:</div>
											<div class="contact_info_line">1481 Creekside Lane Avila Beach, CA 93424</div>
										</div>
										<div class="contact_info_item">
											<div class="contact_info_title">Phone:</div>
											<div class="contact_info_line">+53 345 7953 32453</div>
										</div>
										<div class="contact_info_item">
											<div class="contact_info_title">Email:</div>
											<div class="contact_info_line">yourmail@gmail.com</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div data-aos="fade-up"  class="contact_form_container">
							<form action="#" id="contact_form" class="contact_form">
								<div>
									<div class="row">
										<div class="col-lg-6 contact_name_col">
											<input type="text" class="contact_input" placeholder="Name" required="required">
										</div>
										<div class="col-lg-6">
											<input type="email" class="contact_input" placeholder="E-mail" required="required">
										</div>
									</div>
								</div>
								<div><input type="text" class="contact_input" placeholder="Subject" required="required"></div>
								<div><textarea class="contact_input contact_textarea" placeholder="Message"></textarea></div>
								<button class="contact_button"><span>send message</span><span class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
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
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.0480549166914!2d90.3667632!3d23.7731584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf6de2c3b19b%3A0xeeef7eec6d1d012a!2sEasy%20Tech%20Solutions!5e1!3m2!1sen!2sbd!4v1759752382793!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-100"></iframe>
							</div>
						</div>

					</div>
				</div>
			</div>
				
		</div>
	</div>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/footer.php'; ?>