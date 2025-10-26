<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Home'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>


	.footer {
		width: 100%;
		background: #0F2920;
		color: #fff;
		padding-top: 174px;
		padding-bottom: 50px;
	}
.join {
    position: absolute;
    top: -47%;
    left: 0;
    right: 0;
    background: transparent;
}
	@media(max-width:991px) {
		.join-input {
			width: 58%;
			border-top-left-radius: 10px;
			border-bottom-left-radius: 10px;
			border: none;
			outline: none;
			padding: 5px 20px;
		}


	}

	/* Featured Banner Overlay Styles */
	.featured_background_wrapper {
		position: relative;
		height: 93%;
		min-height: 400px;
	}

	.featured_background {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 93%;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}

	.featured_overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 93%;
		background: rgba(15, 41, 32, 0.7);
		z-index: 1;
	}

	.featured_banner_content {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 2;
		text-align: center;
		color: #fff;
		width: 90%;
		padding: 20px;
	}

	.featured_banner_content h1 {
		font-size: 36px;
		font-weight: 700;
		margin-bottom: 20px;
		color: #fff;
	}

	.featured_banner_content p {
		font-size: 16px;
		line-height: 1.6;
		margin-bottom: 30px;
		color: #fff;
	}
.featured_content {
    padding-left: 50px;
    padding-top: 32px;
    padding-right: 50px;
    padding-bottom: 41px;
    background: #f2f1f8;
}
.button_arrow {
    border-radius: 0px;
    top: 0px;
}
	.buttons {
		display: flex;
		gap: 15px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.buttons .btn {

		padding: 5px 18px;
		background: #008E48;
		text-decoration: none;
		color: white;
		border-radius: 10px;
		font-weight: 600px;
	}
.featured_footer {
    margin-top: 30px;
}
	.featured_footer i{
		font-size: 25px;
		margin: 10px;
	}
	.featured_footer i:hover{
		color: #008E48;
		transition: all ease-in-out .3s;
		cursor: pointer;
		
	}
	/* Remove the custom button styles since we're using existing .btn classes */

	/* Responsive Design */
	@media(max-width: 1199px) {
.featured_content {
    padding-left: 50px;
    padding-top: 82px;
    padding-right: 50px;
    padding-bottom: 41px;
    background: #f2f1f8;
}
	}
	@media(max-width: 991px) {
		.featured_background_wrapper {
			min-height: 350px;
		}

		.featured_banner_content h1 {
			font-size: 28px;
		}

		.featured_banner_content p {
			font-size: 14px;
		}
		.button_arrow {
    border-radius: 10px;
    top: 0px;
    right: 0px;
    height: 100%;
}
	}


	@media(max-width: 575px) {
		.home_slider_background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 89%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
}
		.featured_background_wrapper {
			min-height: 300px;
		}

		.featured_banner_content h1 {
			font-size: 24px;
			margin-bottom: 15px;
		}

		.featured_banner_content p {
			font-size: 13px;
			margin-bottom: 20px;
		}

		.buttons {
			flex-direction: column;
			gap: 10px;
		}

		.buttons .btn {
			padding: 5px 18px;
			background: #008E48;
			text-decoration: none;
			color: white;
			border-radius: 10px;
			font-weight: 600px;
		}

		.featured_banner_content {
			top: 47%;
		}
		.home_buttons {
    margin-top: 50px;
}
	}
</style>
<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

<!-- Home -->
<div class="home">
	<div class="home_slider_container">

		<!-- Home Slider -->
		<div class="owl-carousel owl-theme home_slider">

			<!-- Slider Item -->
			<div class="owl-item">
				<!-- Background image artist https://unsplash.com/@benwhitephotography -->
				<div class="home_slider_background" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(images/Banner3.jpg);background-repeat:no-repeat;background-position:center;"></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">

									<div class="home_text">
										<div class="home_title">Sidratul Muntaha Foundation</div>
										<div class="home_subtitle">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. Registration Number: .</div>
									</div>
									<div class="home_buttons">
										<div class="button home_button"><a href="#">Know more<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
										<div class="button home_button"><a href="#">All Activities<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Slider Item -->
			<div class="owl-item">
				<!-- Background image artist https://unsplash.com/@benwhitephotography -->
				<div class="home_slider_background" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(images/Banner.jpg);background-repeat:no-repeat;background-position:center;"></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">

									<div class="home_text">
										<div class="home_title">Sidratul Muntaha Foundation</div>
										<div class="home_subtitle">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. Registration Number: .</div>
									</div>
									<div class="home_buttons">
										<div class="button home_button"><a href="#">Know more<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
										<div class="button home_button"><a href="#">All Activities<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Slider Item -->
			<div class="owl-item">
				<!-- Background image artist https://unsplash.com/@benwhitephotography -->
				<div class="home_slider_background" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(images/Bannertwo.jpg)"></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">

									<div class="home_text">
										<div class="home_title">Sidratul Muntaha Foundation</div>
										<div class="home_subtitle">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. Registration Number: .</div>
									</div>
									<div class="home_buttons">
										<div class="button home_button"><a href="#">Know more<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
										<div class="button home_button"><a href="#">All Activities<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Slider Item -->
			<div class="owl-item">
				<!-- Background image artist https://unsplash.com/@benwhitephotography -->
				<div class="home_slider_background" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(images/bannerfour.jpg)"></div>
				<div class="home_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content text-center">

									<div class="home_text">
										<div class="home_title">Sidratul Muntaha Foundation</div>
										<div class="home_subtitle">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. Registration Number: .</div>
									</div>
									<div class="home_buttons">
										<div class="button home_button"><a href="#">Know more<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
										<div class="button home_button"><a href="#">All Activities<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>



<!-- Featured Course -->


<!-- Courses -->
<div class="home-page courses">
	<div class="container">



		<!-- Featured banner -->

		<div class="featured">
			<div class="container mt-5" data-aos="fade-up">
				<div class="row">
					<div class="col">
						<div class="featured_container">
							<div class="row">
								<div class="col-lg-6 featured_col">
									<!-- Background image with overlay -->
									<div class="featured_background_wrapper" style="position: relative;">
										<div class="featured_background" style="background-image:url(images/Banner3.jpg)"></div>
										<div class="featured_overlay"></div>
										<div class="featured_banner_content">
											<h1>Sidratul Muntaha Foundation</h1>
											<p>Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. Registration Number: S-14117/2024 .</p>
											<div class="buttons">
												<a href="about.php" class="btn">Know More</a>
												<a href="activities.php" class="btn btn-outline d-none d-lg-block">Activities</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 featured_col">
									<div class="featured_content">
										<div class="featured_header d-flex flex-row align-items-center justify-content-start">
										</div>
										<div class="featured_image d-flex justify-content-center align-items-center">
											<img src="images/sidratul logo.png" alt="sidratul logo.png" class="w-50 ">
										</div>

										<div class="featured_footer d-flex align-items-center justify-content-center ">
											<i class="fa fa-facebook" aria-hidden="true"></i>
											<i class="fa fa-youtube-play" aria-hidden="true"></i>
											<i class="fa fa-instagram" aria-hidden="true"></i>
											<i class="fa fa-twitter-square" aria-hidden="true"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="section_title">
			<h2 class="text-center  pt-5 pb-2 ">For Ummah, With Sunnah</h2>
		</div>





		<div
			data-aos="fade-up"
			class="about-quotes mb-5">
			<div class="container mx-auto">
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-4">

						<div class=" quote-item d-flex flex-column justify-content-center align-items-center">
							<i class="fa fa-graduation-cap " aria-hidden="true"></i>
							<h1 class="text-sm-center">Education</h1>
							<p class="text-sm-center">Establishing and managing madrasas with an integrated syllabus of religious and general education to produce distinguished Islamic scholars and contemporary da'wah practitioners.</p>
						</div>

					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">

						<div class=" quote-item d-flex flex-column justify-content-center align-items-center">
							<i class="fa fa-handshake-o" aria-hidden="true"></i>
							<h1 class="text-sm-center">Service</h1>
							<p class="text-sm-center">Empowering the poor, providing relief and rehabilitation for flood victims, installing tube wells and water purification plants, tree plantation, distributing winter clothing, Iftar meals, and organizing inclusive Qurbani programs, among other welfare activities.</p>
						</div>

					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">

						<div class=" quote-item d-flex flex-column justify-content-center align-items-center">
							<i class="fa fa-book" aria-hidden="true"></i>
							<h1 class="text-sm-center">Dawah</h1>
							<p class="text-sm-center">Online-based da'wah, writing and publishing Islamic books, conducting religious study circles, and organizing training programs and workshops for Islamic outreach.</p>
						</div>

					</div>


				</div>
			</div>
		</div>

		<div class="about-quote-btn">
			<a href="about.php">See More</a>
		</div>
		<div class="row">
			<div class="col">

				<!-- Courses Slider -->
				<br><br><br>
				<div class="section_title text-center">
					<h2>Activities</h2>
				</div>
				<div class="courses_slider_container">
					<div class="owl-carousel owl-theme courses_slider">

						<!-- Slider Item -->
						<div class="owl-item">
							<div class="course">
								<div class="course_image"><a href="activities-details.php"><img src="images/tree-plantation.webp" alt=""></a></div>
								<div class="course_body">
									<div class="course_header d-flex flex-row align-items-center justify-content-start">
										<div class="course_tag"><a href="#">Activities</a></div>

									</div>
									<div class="course_title">
										<h3><a href="activities-details.php">Tree Plantation</a></h3>
									</div>
									<div class="course_text">Planting Tree is Sadaqah Jariyah.As Long as animals and other people benifite from the tree ,the one wo planted it will continue to earn ... </div>
									<div class="course_footer d-flex align-items-center justify-content-start">
										<!-- <div class="course_author_image"><img src="images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
											<div class="course_author_name">By <a href="#">James S. Morrison</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
									</div>
								</div>
							</div>
						</div>

						<!-- Slider Item -->
						<div class="owl-item">
							<div class="course">
								<div class="course_image"><a href="activities-details.php"><img src="images/self-reliance.webp" alt=""></a></div>
								<div class="course_body">
									<div class="course_header d-flex flex-row align-items-center justify-content-start">
										<div class="course_tag"><a href="#">New</a></div>

									</div>
									<div class="course_title">
										<h3><a href="activities-details.php">General Fund</a></h3>
									</div>
									<div class="course_text">Planting Tree is Sadaqah Jariyah.As Long as animals and other people benifite from the tree ,the one wo planted it will continue to earn ...</div>
									<div class="course_footer d-flex align-items-center justify-content-start">
										<!-- <div class="course_author_image"><img src="images/course_author_2.jpg" alt=""></div>
											<div class="course_author_name">By <a href="#">Mark Smith</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
									</div>
								</div>
							</div>
						</div>

						<!-- Slider Item -->
						<div class="owl-item">
							<div class="course">
								<div class="course_image"><a href="activities-details.php"><img src="images/dawah-education.webp" alt="https://unsplash.com/@annademy"></a></div>
								<div class="course_body">
									<div class="course_header d-flex flex-row align-items-center justify-content-start">
										<div class="course_tag"><a href="#">Featured</a></div>

									</div>
									<div class="course_title">
										<h3><a href="activities-details.php">Dawah</a></h3>
									</div>
									<div class="course_text">Planting Tree is Sadaqah Jariyah.As Long as animals and other people benifite from the tree ,the one wo planted it will continue to earn ...</div>
									<div class="course_footer d-flex align-items-center justify-content-start">
										<!-- <div class="course_author_image"><img src="images/course_author_3.jpg" alt=""></div>
											<div class="course_author_name">By <a href="#">Julia Williams</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
									</div>
								</div>
							</div>
						</div>

					</div>

					<!-- Courses Slider Nav -->
					<div class="courses_slider_nav courses_slider_prev trans_200"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
					<div class="courses_slider_nav courses_slider_next trans_200"><i class="fa fa-angle-right" aria-hidden="true"></i></div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Donation Category  -->
<div class="container mx-auto mb-5">
	<div class="section_title text-center pb-5">
		<h2>Our Major Projects</h2>
	</div>
	<div
		data-aos="fade-up"
		data-aos-delay="500"
		class="row">
		<div class="col-sm-6 col-md-6 col-lg-4">
			<div class="donate-preview_item">
				<div class="course">
					<div class="course_image"><a href="donate.php"><img src="images/hospital.jpg" alt="" class="w-100"></a></div>
					<div class="course_body ">
						<div class="course_title ">
							<h3 class=""><a href="donate.php">Hospital Project</a></h3>
						</div>
						<div class="course_text text-truncated">Many people want to donate regularly but often forget to do so.From now on, bKash-Nagad App and Visa-Mastercard users can make regular donations from the As-Sunnah Foundation website by activating the automated system. On our website, you can choose from daily, or monthly donation options and select the amount. Even if you forget, the specified amount will be credited to the foundation's account at the scheduled time.

							Users can opt out of this feature at any time.</div>
						<div class="course_footer d-flex align-items-center justify-content-start">
							<!-- <div class="course_author_image"><img src="images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
											<div class="course_author_name">By <a href="#">James S. Morrison</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
						</div>
						<div class="d-flex justify-content-center">
							<a href="donate.php" class=" donate-preview_item-btn">Donate Fund</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-4">

			<div class="donate-preview_item">
				<div class="course">
					<div class="course_image"><a href="donate.php"><img src="images/mosque.jpg" alt="" class="w-100"></a></div>
					<div class="course_body ">
						<div class="course_title ">
							<h3 class=""><a href="donate.php">Mosque Project</a></h3>
						</div>
						<div class="course_text text-truncated">Many people want to donate regularly but often forget to do so.From now on, bKash-Nagad App and Visa-Mastercard users can make regular donations from the As-Sunnah Foundation website by activating the automated system. On our website, you can choose from daily, or monthly donation options and select the amount. Even if you forget, the specified amount will be credited to the foundation's account at the scheduled time.

							Users can opt out of this feature at any time.</div>
						<div class="course_footer d-flex align-items-center justify-content-start">
							<!-- <div class="course_author_image"><img src="images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
											<div class="course_author_name">By <a href="#">James S. Morrison</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
						</div>
						<div class="d-flex justify-content-center">
							<a href="donate.php" class=" donate-preview_item-btn">Donate Fund</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-4">

			<div class="donate-preview_item">
				<div class="course">
					<div class="course_image"><a href="donate.php"><img src="images/school.jpg" alt="" class="w-100 h-100"></a></div>
					<div class="course_body ">
						<div class="course_title ">
							<h3 class=""><a href="donate.php">School Project</a></h3>
						</div>
						<div class="course_text text-truncated">Many people want to donate regularly but often forget to do so.From now on, bKash-Nagad App and Visa-Mastercard users can make regular donations from the As-Sunnah Foundation website by activating the automated system. On our website, you can choose from daily, or monthly donation options and select the amount. Even if you forget, the specified amount will be credited to the foundation's account at the scheduled time.

							Users can opt out of this feature at any time.</div>
						<div class="course_footer d-flex align-items-center justify-content-start">
							<!-- <div class="course_author_image"><img src="images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
											<div class="course_author_name">By <a href="#">James S. Morrison</a></div>
											<div class="course_sales ml-auto"><span>352</span> Sales</div> -->
						</div>
						<div class="d-flex justify-content-center">
							<a href="donate.php" class=" donate-preview_item-btn">Donate Fund</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row my-5 d-flex justify-content-center align-items-center">
		<div class="about-quote-btn">
			<a href="donation-fund.php">See All</a>
		</div>
	</div>
</div>
<!-- Milestones -->
<!-- <div class="milestones">
	
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/milestones.jpg" data-speed="0.8"></div>
	<div class="container">
		<div class="row milestones_container">


			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="images/milestone_1.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="1548">0</div>
					<div class="milestone_text">Online Courses</div>
				</div>
			</div>

	
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="images/milestone_2.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="7286">0</div>
					<div class="milestone_text">Students</div>
				</div>
			</div>


			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="images/milestone_3.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="257">0</div>
					<div class="milestone_text">Teachers</div>
				</div>
			</div>


			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="images/milestone_4.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="39">0</div>
					<div class="milestone_text">Countries</div>
				</div>
			</div>

		</div>
	</div>
</div> -->






<div class="container mx-auto">
	<div class="section_title">
		<h2 class="text-center">Our Associatives</h2>
	</div>
	<div class="d-flex justify-content-center gap-4 my-5 associatives">

		<img src="images/islami bank img.png" alt="">
		<img src="images/assunnah.png" alt="">
		<img src="images/insurancep.png" alt="">

	</div>
</div>




<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/footer.php'; ?>