<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Home';
?>
<?php require './components/header.php'; ?>

<style>
	/* ==========================================================================
   BASE STYLES (Desktop First - Default)
   ========================================================================== */

/* New Slider Styles */
.modern-hero {
	position: relative;
	min-height: 100vh;
	overflow: hidden;
}

.slider-container {
	width: 100%;
	height: 100vh;
	min-height: 600px;
	position: relative;
	overflow: hidden;
}

.slider {
	position: relative;
	width: 100%;
	height: 100%;
	overflow: hidden;
}

/* Replace the .slide and .slide.active styles (lines 54-66) with: */
.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 1;
    z-index: 1;
    transform: translateX(100%);
    transition: transform 1s ease-in-out; /* Reduced from 5s to 1s */
    overflow: hidden;
    pointer-events: none;
}

.slide.active {
    transform: translateX(0);
    z-index: 2;
    pointer-events: auto;
}

.slide.prev {
    transform: translateX(-100%);
    z-index: 1;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 8s ease-in-out; /* Keep this for zoom effect */
}

.slide.active img {
    transform: scale(1.1);
}

.slide-content {
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	text-align: center;
	padding: 60px 30px;
	background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 100%);
	color: white;
	opacity: 0;
	transition: opacity 0.7s ease;
}

.slide.active .slide-content {
	opacity: 1;
	transition-delay: 0.2s;
}

/* Slide title and description */
.slide-title {
	transform: translateX(-1000px);
	opacity: 0;
	transition: transform 2s ease, opacity 0.8s ease;
	transition-delay: 0.4s;
	font-size: 64px;
	font-weight: 800;
	margin-bottom: 24px;
	color: #fff;
	text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
	line-height: 1.2;
}

.slide-description {
	transform: translateX(1000px);
	opacity: 0;
	transition: transform 2s ease, opacity 1s ease;
	transition-delay: 0.6s;
	font-size: 20px;
	color: rgba(255, 255, 255, 0.95);
	margin-bottom: 40px;
	line-height: 1.7;
	max-width: 700px;
	padding-bottom: 30px;
}

.slide-buttons {
	transform: translateY(50px);
	opacity: 0;
	transition: transform 1s ease, opacity 1s ease;
	transition-delay: 0.8s;
	display: flex;
	gap: 20px;
	justify-content: center;
	flex-wrap: wrap;
}

.slide.active .slide-title,
.slide.active .slide-description,
.slide.active .slide-buttons {
	transform: translate(0, 0);
	opacity: 1;
}

button:focus {
	outline: none;
	outline: 0px auto -webkit-focus-ring-color;
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

/* Navigation arrows */
.navigation {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 20;
	pointer-events: none;
}

.nav-btn {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	background-color: #008E48;
	color: #fff;
	border: none;
	outline: none;
	border-radius: 50%;
	width: 50px;
	height: 50px;
	cursor: pointer;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 1.5rem;
	transition: all 0.3s ease;
	pointer-events: auto;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
	z-index: 30;
}

.nav-btn.prev {
	left: 20px;
}

.nav-btn.next {
	right: 20px;
}

/* Dots indicators */
.dots-container {
	display: flex;
	justify-content: center;
	position: absolute;
	bottom: 40px;
	width: 100%;
	z-index: 40;
}

.dot {
	width: 12px;
	height: 12px;
	border-radius: 50%;
	margin: 0 5px;
	background-color: rgba(255, 255, 255, 0.5);
	cursor: pointer;
	transition: all 0.3s ease;
	display: none;
}

.dot.active {
	width: 40px;
	border-radius: 6px;
	background-color: white;
}

/* Animation keyframes for transitions */
@keyframes fadeIn {
	from {
		opacity: 0;
	}
	to {
		opacity: 1;
	}
}

@keyframes slideInRight {
	from {
		transform: translateX(50px);
		opacity: 0;
	}
	to {
		transform: translateX(0);
		opacity: 1;
	}
}

@keyframes slideInLeft {
	from {
		transform: translateX(-50px);
		opacity: 0;
	}
	to {
		transform: translateX(0);
		opacity: 1;
	}
}

@keyframes zoomIn {
	from {
		transform: scale(1.2);
		opacity: 0;
	}
	to {
		transform: scale(1);
		opacity: 1;
	}
}

@keyframes slideInUp {
	from {
		transform: translateY(50px);
		opacity: 0;
	}
	to {
		transform: translateY(0);
		opacity: 1;
	}
}

/* Transition effect classes */
.transition-fade .slide-content {
	animation: fadeIn 1s forwards;
}

.transition-slideRight .slide-content {
	animation: slideInRight 1s forwards;
}

.transition-slideLeft .slide-content {
	animation: slideInLeft 1s forwards;
}

.transition-zoom .slide-content {
	animation: zoomIn 1s forwards;
}

.transition-slideUp .slide-content {
	animation: slideInUp 1s forwards;
}

/* Modern Featured Section */
.modern-featured {
	padding: 50px 0;
	background: rgb(248, 250, 249);
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
	background: #84848426;
	min-height: 400px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	border: 2px solid #f9f9f9;
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

/* Activities Slider */
.activities-section {
	padding: 100px 0;
	background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
}

.course {
	background: #fff;
	border-radius: 20px;
	overflow: hidden;
	transition: all 0.4s ease;
}

.course:hover {
	transform: translateY(-10px);
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

/* Footer Styles */
.footer {
	width: 100%;
	background: #0F2920;
	color: #fff;
	padding-top: 60px;
	padding-bottom: 50px;
}


/* ==========================================================================
   RESPONSIVE MEDIA QUERIES - Bootstrap Breakpoint Order
   ========================================================================== */

/* 
 * Bootstrap Breakpoints Reference:
 * xs: <576px (Extra small devices - phones)
 * sm: ≥576px (Small devices - landscape phones)
 * md: ≥768px (Medium devices - tablets)
 * lg: ≥992px (Large devices - desktops)
 * xl: ≥1200px (Extra large devices - large desktops)
 * xxl: ≥1400px (Extra extra large devices)
 */

/* XX-Large devices (larger desktops, 1400px and up) */
@media (max-width: 1400px) {
	/* Add styles for extra large screens if needed */
}

/* X-Large devices (large desktops, 1200px and up) */
@media (max-width: 1200px) {
	.slide-title {
		font-size: 45px;
	}
}

/* Large devices (desktops, less than 1200px) */
@media (max-width: 1199.98px) {
	/* Add styles for large tablets/small desktops if needed */
}

/* Medium devices (tablets, less than 992px) */
@media (max-width: 991.98px) {
	.modern-hero {
		min-height: 50vh;
		margin-top: 61px;
	}

	.slider-container {
		height: 60vh;
		min-height: 400px;
	}

	.slider {
		height: 350px;
	}
	.slide-title {
		font-size: 42px;
	}
	.nav-btn {
		display: none;
	}

	.section-title {
		font-size: 36px;
	}

	.featured-card-body {
		padding: 35px;
	}

	.featured-left,
	.featured-right {
		border-radius: 0;
		min-height: auto;
		padding: 40px 20px !important;
	}

	.unified-card {
		flex-direction: column;
	}

	.mission-card {
		padding: 35px 25px;
	}
}

/* Small devices (landscape phones, less than 768px) */
@media (max-width: 767.98px) {
	.slider-container {
		height: 70vh;
	}
}

/* Extra small devices (portrait phones, less than 576px) */
@media (max-width: 575.98px) {
	.modern-hero {
		min-height: 50vh;
	}

	.slider-container {
		height: 52vh;
		min-height: 400px;
	}

	.slider {
		height: 100%;
	}

	.nav-btn {
		width: 40px;
		height: 40px;
		font-size: 1.2rem;
		background: #008E48;
		color: #fff;
	}

	.nav-btn.prev {
		left: 10px;
	}

	.nav-btn.next {
		right: 10px;
	}

	.slide-title {
		font-size:32px;
	}

	.slide-description {
		font-size: 16px;
	}

	.slide-buttons {
		margin-top: 10px;
		transform: translateY(50px);
		gap: 20px;
		flex-wrap: nowrap;
	}

	.hero-btn {
		padding: 10px 10px;
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

@media (max-width: 399px) {
	.hero-btn {
    padding: 12px 93px;
	font-size: 14px;
}
.slide-buttons {
    flex-wrap: wrap;
}
}
</style>

<!-- Modern Hero Slider -->
<div class="modern-hero">
	<div class="slider-container">
		<div class="slider">
			<div class="slide active transition-fade">
				<img src="images/Banner3.jpg" alt="Mosque Project">
				<div class="slide-content">
					<h1 class="slide-title">Mosque Project</h1>
					<p class="slide-description">Sidratul Muntaha Foundation is a non-political, non-profit government-registered organization dedicated to education, da'wah and total human welfare.</p>
					<div class="slide-buttons">
						<a href="donate.php" class="hero-btn hero-btn-primary">
							Donate Now
							<i class="fa fa-arrow-right"></i>
						</a>
						<a href="projects.php" class="hero-btn hero-btn-secondary">
							View Projects
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="slide">
				<img src="images/Bannertwo.jpg" alt="School Project">
				<div class="slide-content">
					<h1 class="slide-title">School Project</h1>
					<p class="slide-description">Establishing educational excellence through integrated religious and general education, creating the next generation of Islamic scholars and leaders.</p>
					<div class="slide-buttons">
						<a href="donate.php" class="hero-btn hero-btn-primary">
							Donate Now
							<i class="fa fa-arrow-right"></i>
						</a>
						<a href="projects.php" class="hero-btn hero-btn-secondary">
							View Projects
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="slide">
				<img src="images/bannerfour.jpg" alt="Hospital Project">
				<div class="slide-content">
					<h1 class="slide-title">Hospital Project</h1>
					<p class="slide-description">Providing compassionate healthcare and medical support to those in need, ensuring wellness and dignity for every member of our community.</p>
					<div class="slide-buttons">
						<a href="donate.php" class="hero-btn hero-btn-primary">
							Donate Now
							<i class="fa fa-arrow-right"></i>
						</a>
						<a href="projects.php" class="hero-btn hero-btn-secondary">
							View Projects
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="navigation">
			<button class="nav-btn prev">&lt;</button>
			<button class="nav-btn next">&gt;</button>
		</div>

		<div class="dots-container">
			<!-- Dots will be added dynamically with JavaScript -->
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
						<a href="projects.php" class="hero-btn hero-btn-outline" style="border:2px solid rgb(255, 255, 255); padding:12px 25px; border-radius:10px; color: #fff; font-weight:600; text-decoration:none;">Projects</a>
					</div>
				</div>

				<!-- Right Side: Logo + Socials -->
				 <style>
					.featured-logo {
						width: 400px !important;
					}
					@media only screen and (max-width: 768px) {
						.featured-logo {
							width: 300px !important;
						}
					}
				 </style>
				<div class="col-lg-6 p-5 featured-right text-center">
					<img src="images/final-logo.png" alt="Logo" class="featured-logo mb-4"><br><br>
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
					<div class="text-center mt-5" data-aos="fade-up">
						<a href="about.php" class="see-all-btn">
							See More
							<i class="fa fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="mission-card">
					<div class="mission-icon">
						<i class="fa fa-handshake-o"></i>
					</div>
					<h3>Service</h3>
					<p>Empowering the poor, providing relief for flood victims, installing water purification plants, tree plantation, distributing winter clothing, Iftar meals, and organizing inclusive Qurbani programs.</p>
					<div class="text-center mt-5" data-aos="fade-up">
						<a href="about.php" class="see-all-btn">
							See More
							<i class="fa fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="mission-card">
					<div class="mission-icon">
						<i class="fa fa-book"></i>
					</div>
					<h3>Dawah</h3>
					<p>Online-based da'wah, writing and publishing Islamic books, conducting religious study circles, and organizing training programs and workshops for Islamic outreach.</p>
					<div class="text-center mt-5" data-aos="fade-up">
						<a href="about.php" class="see-all-btn">
							See More
							<i class="fa fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Projects Section -->
<div class="activities-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">WHAT WE DO</span>
			<h2 class="section-title">Our Projects</h2>
			<p class="section-subtitle">Making a difference through meaningful actions and sustainable projects</p>
		</div>
		<div class="courses_slider_container" data-aos="fade-up" data-aos-delay="200">
			<div class="owl-carousel owl-theme courses_slider">
				<!-- Activity 1 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="project-details.php">
								<img src="images/school.png" alt="School Project">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Major Prjects</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">School Project</a></h3>
							</div>
							<div class="course_text">Building educational institutions that nurture both Islamic values and modern knowledge for future generations</div>
							<a href="project-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Project 2 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="project-details.php">
								<img src="images/New walkway.jpg" alt="General Fund">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Social Works</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">Walkway Development</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="project-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Projects 3 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="project-details.php">
								<img src="images/SocialWork11.jpg "alt="social works">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Regular Project</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">Relief Distribution</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="project-details.php" class="project-btn mt-3">
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
						<img src="images/Hospital Project.jpg" alt="Hospital">
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
		<div class="text-center mt-5" data-aos="fade-up">
			<a href="donation-fund.php" class="see-all-btn">
				View All Projects
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
</div>
<!-- Social  Projects -->
<div class="activities-section">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<span class="section-badge">WHAT WE DO</span>
			<h2 class="section-title">Our Social Works</h2>
			<p class="section-subtitle">Making a difference through meaningful actions and sustainable projects</p>
		</div>
		<div class="courses_slider_container" data-aos="fade-up" data-aos-delay="200">
			<div class="owl-carousel owl-theme courses_slider">
				<!-- Social Project 1 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="project-details.php">
								<img src="images/SocialWork10.jpg" alt="Tree Plantation">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Social Projects</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">Relief Distribution</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="project-details.php" class="project-btn mt-3">
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
							<a href="project-details.php">
								<img src="images/Scholarship1.jpg" alt="General Fund">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Social Project</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">Scholarship Oportunity</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower education community through comprehensive financial aids to students.</div>
							<a href="project-details.php" class="project-btn mt-3">
								See Details
								<i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Project 3 -->
				<div class="owl-item">
					<div class="course">
						<div class="course_image">
							<a href="project-details.php">
								<img src="images/SocialWork17.jpg" alt="Dawah">
							</a>
						</div>
						<div class="course_body">
							<div class="course_header">
								<span class="course_tag">Social Project</span>
							</div>
							<div class="course_title">
								<h3><a href="project-details.php">Relief Donation</a></h3>
							</div>
							<div class="course_text">Supporting various welfare initiatives to create sustainable impact and empower communities through comprehensive development programs.</div>
							<a href="project-details.php" class="project-btn mt-3">
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


<script>
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    const dotsContainer = document.querySelector('.dots-container');

    let currentIndex = 0;
    let autoSlideInterval;
    const autoSlideDelay = 6000; // 6 seconds total
    let isTransitioning = false;
    let isInitialized = false;

    // Initialize slides
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
        if (index === 0) {
            slide.style.transform = 'translateX(0)';
            slide.style.zIndex = '2';
            slide.classList.add('active');
        } else {
            slide.style.transform = 'translateX(100%)';
            slide.style.zIndex = '1';
        }
    });

    // Enable transitions
    slides.forEach(slide => {
        slide.style.transition = 'transform 1s ease-in-out, z-index 0s';
    });
    isInitialized = true;

    // Create dots
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
            if (!isTransitioning && isInitialized) {
                const direction = index > currentIndex ? 'next' : 'prev';
                showSlide(index, direction);
            }
        });
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function showSlide(index, direction = 'next') {
        let newIndex = index;
        if (newIndex < 0) newIndex = slides.length - 1;
        if (newIndex >= slides.length) newIndex = 0;

        if (newIndex === currentIndex || isTransitioning) return;

        isTransitioning = true;

        const currentSlide = slides[currentIndex];
        const nextSlide = slides[newIndex];

        // Set up next slide
        nextSlide.style.transition = 'none';
        nextSlide.style.zIndex = '2';
        
        if (direction === 'next') {
            nextSlide.style.transform = 'translateX(100%)';
        } else {
            nextSlide.style.transform = 'translateX(-100%)';
        }

        // Force reflow
        nextSlide.offsetHeight;

        // Enable transitions
        currentSlide.style.transition = 'transform 1s ease-in-out';
        nextSlide.style.transition = 'transform 1s ease-in-out';
        
        currentSlide.style.zIndex = '1';

        // Animate
        if (direction === 'next') {
            currentSlide.style.transform = 'translateX(-100%)';
        } else {
            currentSlide.style.transform = 'translateX(100%)';
        }
        nextSlide.style.transform = 'translateX(0)';

        // Update classes
        currentSlide.classList.remove('active');
        nextSlide.classList.add('active');

        // Update dots
        dots.forEach(dot => dot.classList.remove('active'));
        dots[newIndex].classList.add('active');

        currentIndex = newIndex;

        setTimeout(() => {
            isTransitioning = false;
        }, 1000);

        resetAutoSlide();
    }

    function nextSlide() {
        if (!isInitialized) return;
        const nextIndex = (currentIndex + 1) % slides.length;
        showSlide(nextIndex, 'next');
    }

    function prevSlide() {
        if (!isInitialized) return;
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(prevIndex, 'prev');
    }

    function startAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
        
        autoSlideInterval = setInterval(() => {
            if (isInitialized && !isTransitioning) {
                nextSlide();
            }
        }, autoSlideDelay);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (!isTransitioning && isInitialized) {
                prevSlide();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (!isTransitioning && isInitialized) {
                nextSlide();
            }
        });
    }

    // Start auto slide
    setTimeout(() => {
        if (isInitialized) {
            startAutoSlide();
        }
    }, 1000);
});
</script>
<!-- Join Platform -->
<?php require './components/join-platform-text.php'; ?>

<!-- Footer -->
<?php require './components/footer.php'; ?>