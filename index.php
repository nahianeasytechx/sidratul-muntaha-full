<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Home';
?>
<?php require './components/header.php'; ?>
<style>
	/* Modern Hero Slider Styles */
	.modern-hero {
		position: relative;
		height: 100vh;
		min-height: 600px;
		overflow: hidden;
	}

	.hero-slide {
		position: relative;
		height: 100vh;
		min-height: 600px;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.hero-bg {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-size: cover;
		background-position: center;
		transition: transform 0.6s ease;
	}

	.hero-slide:hover .hero-bg {
		transform: scale(1.05);
	}

	.hero-overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: linear-gradient(135deg, rgba(15, 41, 32, 0.85) 0%, rgba(0, 142, 72, 0.75) 100%);
		z-index: 1;
	}

	.hero-content {
		position: relative;
		z-index: 2;
		max-width: 900px;
		padding: 0 30px;
		text-align: center;
		animation: fadeInUp 1s ease;
	}

	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(40px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.hero-badge {
		display: inline-block;
		padding: 8px 24px;
		background: rgba(255, 255, 255, 0.15);
		backdrop-filter: blur(10px);
		border-radius: 50px;
		color: #fff;
		font-size: 14px;
		font-weight: 600;
		letter-spacing: 1px;
		margin-bottom: 30px;
		border: 1px solid rgba(255, 255, 255, 0.2);
	}

	.hero-title {
		font-size: 64px;
		font-weight: 800;
		color: #fff;
		margin-bottom: 24px;
		line-height: 1.2;
		text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
	}

	.hero-subtitle {
		font-size: 20px;
		color: rgba(255, 255, 255, 0.95);
		margin-bottom: 40px;
		line-height: 1.7;
		max-width: 700px;
		margin-left: auto;
		margin-right: auto;
	}

	.hero-buttons {
		display: flex;
		gap: 20px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.hero-btn {
		padding: 16px 40px;
		font-size: 16px;
		font-weight: 700;
		border-radius: 12px;
		text-decoration: none;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 10px;
		position: relative;
		overflow: hidden;
	}

	.hero-btn-primary {
		background: #008E48;
		color: #fff;
		box-shadow: 0 8px 24px rgba(0, 142, 72, 0.4);
	}

	.hero-btn-primary:hover {
		background: #00a854;
		transform: translateY(-3px);
		box-shadow: 0 12px 32px rgba(0, 142, 72, 0.5);
		color: #fff;
	}

	.hero-btn-secondary {
		background: rgba(255, 255, 255, 0.15);
		backdrop-filter: blur(10px);
		color: #fff;
		border: 2px solid rgba(255, 255, 255, 0.3);
	}

	.hero-btn-secondary:hover {
		background: rgba(255, 255, 255, 0.25);
		transform: translateY(-3px);
		color: #fff;
	}

	.hero-slider-dots {
		position: absolute;
		bottom: 40px;
		left: 50%;
		transform: translateX(-50%);
		z-index: 3;
		display: flex;
		gap: 12px;
	}

	.hero-dot {
		width: 12px;
		height: 12px;
		border-radius: 50%;
		background: rgba(255, 255, 255, 0.4);
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.hero-dot.active {
		width: 40px;
		border-radius: 6px;
		background: #fff;
	}

	/* Modern Featured Section */
	.modern-featured {
		padding: 50px 0;
		background:rgb(248, 250, 249);
	}
	.unified-card {
		background: #fff;
		border-radius: 24px;
		overflow: hidden;
		box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
		transition: all 0.4s ease;
	}
	.unified-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
	}

	.featured-left {
		background: linear-gradient(135deg, #0F2920 0%, #00a854 100%);
		min-height: 400px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		border-top-left-radius: 24px;
		border-bottom-left-radius: 24px;
	}

	.featured-right {
		background: #f9fafb;
		min-height: 400px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

	.social-icons {
		display: flex;
		gap: 15px;
	}
	.social-icon {
		width: 45px;
		height: 45px;
		border-radius: 50%;
		background: #00a854;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		font-size: 18px;
		transition: all 0.3s ease;
		text-decoration: none;
	}
	.social-icon:hover {
		transform: translateY(-5px);
		box-shadow: 0 8px 20px rgba(0, 168, 84, 0.4);
	}

	/* Responsive */
	@media (max-width: 991px) {
		.featured-left, .featured-right {
			border-radius: 0;
			min-height: auto;
			padding: 40px 20px !important;
		}
		.unified-card {
			flex-direction: column;
		}
	}

	/* Mission Cards */
	.mission-section {
		padding: 100px 0;
		background: #fff;
	}

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
	}

	.section-subtitle {
		font-size: 18px;
		color: #6c757d;
		max-width: 700px;
		margin: 0 auto;
	}

	.mission-card {
		background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		border-radius: 20px;
		padding: 50px 35px;
		text-align: center;
		transition: all 0.4s ease;
		border: 2px solid transparent;
		height: 100%;
	}

	.mission-card:hover {
		background: #fff;
		border-color: #008E48;
		transform: translateY(-10px);
		box-shadow: 0 20px 50px rgba(0, 142, 72, 0.15);
	}

	.mission-icon {
		width: 80px;
		height: 80px;
		border-radius: 20px;
		background: linear-gradient(135deg, #008E48 0%, #00a854 100%);
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 30px;
		font-size: 36px;
		color: #fff;
		transition: all 0.4s ease;
	}

	.mission-card:hover .mission-icon {
		transform: rotateY(360deg);
	}

	.mission-card h3 {
		font-size: 28px;
		font-weight: 700;
		color: #0F2920;
		margin-bottom: 20px;
	}

	.mission-card p {
		color: #6c757d;
		line-height: 1.8;
		font-size: 16px;
	}

	/* Activities Slider - Keep Original */
	.activities-section {
		padding: 100px 0;
		background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
	}

	.course {
		background: #fff;
		border-radius: 20px;
		overflow: hidden;
		/* box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); */
		transition: all 0.4s ease;
	}

	.course:hover {
		transform: translateY(-10px);
		/* box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12); */
	}

	.course_image {
		position: relative;
		overflow: hidden;
		height: 250px;
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
	}

	/* Projects Section */
	.projects-section {
		padding: 50px 0;
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
		display: inline-flex;
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

	/* Associates Section */
	.associates-section {
		padding: 80px 0;
		background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
	}

	.associates-grid {
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 50px;
		flex-wrap: wrap;
	}

	.associate-logo {
		height: 80px;
		width: auto;
		opacity: 0.7;
		transition: all 0.3s ease;
		filter: grayscale(100%);
	}

	.associate-logo:hover {
		opacity: 1;
		transform: scale(1.1);
		filter: grayscale(0%);
	}

	/* Responsive */
	@media(max-width: 991px) {
		.hero-title {
			font-size: 42px;
		}

		.hero-subtitle {
			font-size: 16px;
		}

		.section-title {
			font-size: 36px;
		}

		.featured-card-body {
			padding: 35px;
		}

		.mission-card {
			padding: 35px 25px;
		}

		.modern-hero {
			height: auto;
			min-height: 500px;
		}

		.hero-slide {
			height: auto;
			min-height: 500px;
		}
	}

	@media(max-width: 575px) {
		.hero-title {
			font-size: 32px;
		}

		.hero-subtitle {
			font-size: 15px;
		}

		.hero-buttons {
			flex-direction: column;
		}

		.hero-btn {
			width: 100%;
			justify-content: center;
		}

		.section-title {
			font-size: 28px;
		}

		.featured-img-wrapper {
			height: 300px;
		}

		.mission-card {
			margin-bottom: 20px;
		}

		.project-img {
			height: 220px;
		}
	}

	/* Footer Styles */
	.footer {
		width: 100%;
		background: #0F2920;
		color: #fff;
		padding-top: 60px;
		padding-bottom: 50px;
	}
</style>

<!-- Modern Hero Slider -->
<div class="modern-hero">
	<div class="owl-carousel owl-theme home_slider">
		<!-- Slide 1 -->
		<div class="hero-slide">
			<div class="hero-bg" style="background-image: url(images/Banner3.jpg);"></div>
			<div class="hero-overlay"></div>
			<div class="hero-content">
				<!-- <div class="hero-badge">BUILDING FUTURES</div> -->
				<h1 class="hero-title">Mosque Project</h1>
				<p class="hero-subtitle">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare.</p>
				<div class="hero-buttons pt-3">
					<a href="donate.php" class="hero-btn hero-btn-primary">
						Donate Now
						<i class="fa fa-arrow-right"></i>
					</a>
					<a href="activities.php" class="hero-btn hero-btn-secondary">
						View Activities
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</div>
		</div>

		<!-- Slide 2 -->
		<div class="hero-slide">
			<div class="hero-bg" style="background-image: url(images/Bannertwo.jpg);"></div>
			<div class="hero-overlay"></div>
			<div class="hero-content">
				<!-- <div class="hero-badge">EMPOWERING MINDS</div> -->
				<h1 class="hero-title">School Project</h1>
				<p class="hero-subtitle">Establishing educational excellence through integrated religious and general education, creating the next generation of Islamic scholars and leaders.</p>
				<div class="hero-buttons pt-3">
					<a href="donate.php" class="hero-btn hero-btn-primary">
						Donate Now
						<i class="fa fa-arrow-right"></i>
					</a>
					<a href="activities.php" class="hero-btn hero-btn-secondary">
						View Activities
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</div>
		</div>

		<!-- Slide 3 -->
		<div class="hero-slide">
			<div class="hero-bg" style="background-image: url(images/bannerfour.jpg);"></div>
			<div class="hero-overlay"></div>
			<div class="hero-content">
				<!-- <div class="hero-badge">HEALING HEARTS</div> -->
				<h1 class="hero-title">Hospital Project</h1>
				<p class="hero-subtitle">Providing compassionate healthcare and medical support to those in need, ensuring wellness and dignity for every member of our community.</p>
				<div class="hero-buttons pt-3">
					<a href="donate.php" class="hero-btn hero-btn-primary">
						Donate Now
						<i class="fa fa-arrow-right"></i>
					</a>
					<a href="activities.php" class="hero-btn hero-btn-secondary">
						View Activities
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modern Featured Section (Single Card Layout) -->
<div class="modern-featured">
	<div class="container" data-aos="fade-up">
		<div class="featured-card unified-card px-3">
			<div class="row g-0 align-items-center">
				<!-- Left Side: Info -->
				<div class="col-lg-6 p-5 featured-left">
					<h2 class="fw-bold mb-3" style="font-size: 2rem; color: #fff; font-weight: 800;">Sidratul Muntaha Foundation</h2>
					<p class="mb-4" style="color: #f1f1f1; font-size: 1rem; line-height: 1.7;">
						Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare. 
						Registration Number: S-14117/2024.
					</p>
					<div class="d-flex flex-wrap" style="gap: 20px">
						<a href="about.php" class="hero-btn hero-btn-primary" style="background:#00a854; padding:12px 25px; border-radius:10px; color:#fff; font-weight:600; text-decoration:none;">Know More</a>
						<a href="activities.php" class="hero-btn hero-btn-outline" style="border:2px solid rgb(255, 255, 255); padding:12px 25px; border-radius:10px; color: #fff; font-weight:600; text-decoration:none;">Activities</a>
					</div>
				</div>

				<!-- Right Side: Logo + Socials -->
				<div class="col-lg-6 p-5 featured-right text-center">
					<img src="images/sr-logo.png" alt="Logo" class="featured-logo mb-4" style="max-width:180px;">
					<div class="social-icons justify-content-center">
						<a href="#" class="social-icon"><i class="fa fa-facebook"></i></a>
						<a href="#" class="social-icon"><i class="fa fa-youtube-play"></i></a>
						<a href="#" class="social-icon"><i class="fa fa-instagram"></i></a>
						<a href="#" class="social-icon"><i class="fa fa-twitter"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Mission Section -->
<div class="mission-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">OUR MISSION</span>
			<h2 class="section-title">For Ummah, With Sunnah</h2>
			<p class="section-subtitle">Dedicated to serving humanity through three core pillars of excellence</p>
		</div>
		<div class="row" data-aos="fade-up" data-aos-delay="200">
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="mission-card">
					<div class="mission-icon">
						<i class="fa fa-graduation-cap"></i>
					</div>
					<h3>Education</h3>
					<p>Establishing and managing madrasas with an integrated syllabus of religious and general education to produce distinguished Islamic scholars and contemporary da'wah practitioners.</p>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="mission-card">
					<div class="mission-icon">
						<i class="fa fa-handshake-o"></i>
					</div>
					<h3>Service</h3>
					<p>Empowering the poor, providing relief for flood victims, installing water purification plants, tree plantation, distributing winter clothing, Iftar meals, and organizing inclusive Qurbani programs.</p>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="mission-card">
					<div class="mission-icon">
						<i class="fa fa-book"></i>
					</div>
					<h3>Dawah</h3>
					<p>Online-based da'wah, writing and publishing Islamic books, conducting religious study circles, and organizing training programs and workshops for Islamic outreach.</p>
				</div>
			</div>
		</div>
		<div class="text-center mt-5" data-aos="fade-up">
			<a href="about.php" class="see-all-btn">
				Learn More About Us
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
</div>

<!-- Activities Section -->
<div class="activities-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">WHAT WE DO</span>
			<h2 class="section-title">Our Activities</h2>
			<p class="section-subtitle">Making a difference through meaningful actions and sustainable programs</p>
		</div>
		<div class="courses_slider_container" data-aos="fade-up" data-aos-delay="200">
			<div class="owl-carousel owl-theme courses_slider">
				<!-- Activity 1 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="activities-details.php">
								<img src="images/tree-plantation.webp" alt="Tree Plantation">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Activities</span>
							</div>
							<div class="course_title">
								<h3><a href="activities-details.php">Tree Plantation</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="activities-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Activity 2 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="activities-details.php">
								<img src="images/self-reliance.webp" alt="General Fund">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">New</span>
							</div>
							<div class="course_title">
								<h3><a href="activities-details.php">General Fund</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="activities-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Activity 3 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="activities-details.php">
								<img src="images/dawah-education.webp" alt="Dawah">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Featured</span>
							</div>
							<div class="course_title">
								<h3><a href="activities-details.php">Dawah</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="activities-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Slider Navigation -->
			<div class="courses_slider_nav courses_slider_prev trans_200">
				<i class="fa fa-angle-left"></i>
			</div>
			<div class="courses_slider_nav courses_slider_next trans_200">
				<i class="fa fa-angle-right"></i>
			</div>
		</div>
	</div>
</div>

<!-- Major Projects -->
<div class="projects-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">MAJOR INITIATIVES</span>
			<h2 class="section-title">Our Major Projects</h2>
			<p class="section-subtitle">Building infrastructure for long-term community development</p>
		</div>
		<div class="row" data-aos="fade-up" data-aos-delay="200">
			<div class="col-lg-4 col-md-6">
				<div class="project-card">
					<div class="project-img">
						<img src="images/hospital.jpg" alt="Hospital">
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
			<div class="col-lg-4 col-md-6">
				<div class="project-card">
					<div class="project-img">
						<img src="images/school.jpg" alt="School">
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


			<div class="col-lg-4 col-md-6">
				<div class="project-card">
					<div class="project-img">
						<img src="images/mosque.jpg" alt="Mosque">
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
		<div class="text-center mt-5" data-aos="fade-up">
			<a href="donation-fund.php" class="see-all-btn">
				View All Projects
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
</div>

<!-- Associates Section -->
<div class="associates-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">PARTNERS</span>
			<h2 class="section-title">Our Associates</h2>
			<p class="section-subtitle">Collaborating with trusted organizations to amplify our impact</p>
		</div>
		<div class="associates-grid" data-aos="fade-up" data-aos-delay="200">
			<img src="images/islami bank img.png" alt="Islami Bank" class="associate-logo">
			<img src="images/assunnah.png" alt="As-Sunnah" class="associate-logo">
			<img src="images/insurancep.png" alt="Insurance" class="associate-logo">
		</div>
	</div>
</div>

<!-- Join Platform -->
<?php require './components/join-platform-text.php'; ?>

<!-- Footer -->
<?php require './components/footer.php'; ?>