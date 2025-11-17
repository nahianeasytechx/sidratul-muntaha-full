<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Projects'; // Set the page title
?>
<?php require './components/header.php'; ?>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->
<style>
	.course {
		margin-bottom: 30px;
	}

	.course_image img {
		width: 100%;
		height: 250px;
		object-fit: cover;
	}

	/* Tab styles */
	.project-tabs-wrapper {
		margin-top: 60px;
		margin-bottom: 50px;
	}

	.project-tabs {
		display: flex;
		justify-content: center;
		gap: 15px;
		flex-wrap: wrap;
		padding: 10px;
	}

	.tab-button {
		padding: 14px 32px;
		background: #ffffff;
		border: 2px solid #e8e8e8;
		border-radius: 50px;
		font-size: 15px;
		font-weight: 600;
		color: #555;
		cursor: pointer;
		transition: all 0.3s ease;
		position: relative;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
		letter-spacing: 0.5px;
	}

	.tab-button:hover {
		background: #f8f9fa;
		border-color: #28a745;
		color: #28a745;
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
	}

	.tab-button.active {
		background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
		border-color: #28a745;
		color: #ffffff;
		box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
		transform: translateY(-2px);
	}

	.tab-button.active:hover {
		background: linear-gradient(135deg, #259b3e 0%, #1db88a 100%);
		transform: translateY(-2px);
	}

	.tab-button::before {
		content: '';
		position: absolute;
		top: 50%;
		left: 15px;
		transform: translateY(-50%);
		width: 6px;
		height: 6px;
		border-radius: 50%;
		background: currentColor;
		opacity: 0;
		transition: opacity 0.3s ease;
	}

	.tab-button.active::before {
		opacity: 1;
		background: #ffffff;
	}

	/* Project grid styles */
	#projectsGrid {
		min-height: 400px;
	}

	/* Responsive tabs */
	@media (max-width: 768px) {
		.project-tabs-wrapper {
			margin-top: 40px;
		}

		.tab-button {
			padding: 12px 24px;
			font-size: 14px;
		}
	}
</style>

<!-- Home banner-->
<div class="home">
	<!-- Background image artist https://unsplash.com/@thepootphotographer -->
	<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/courses.jpg" data-speed="0.8">

	</div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div data-aos="fade-up" class="home_title">Projects</div>
						<div class="breadcrumbs">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li>Projects</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Courses -->
<div class="courses pb-0 mb-0">
	<div class="container">
		<!-- Tab Buttons -->
		<div class="project-tabs-wrapper">
			<div class="project-tabs" data-aos="fade-up">
				<button class="tab-button active" data-category="all">
					All Projects
				</button>
				<button class="tab-button" data-category="regular">
					Regular Projects
				</button>
				<button class="tab-button" data-category="major">
					Major Projects
				</button>
				<button class="tab-button" data-category="social">
					Social Works
				</button>

			</div>
		</div>

		<div class="row courses_row" id="projectsGrid" data-aos="fade-up">
			<!-- Projects will be loaded here by JavaScript -->
			<div class="col-12 text-center">
				<div class="loading-spinner">Loading projects...</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<!-- Additional content if needed -->
			</div>
		</div>
	</div>
</div>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>