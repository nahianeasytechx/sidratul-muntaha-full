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

	/* Project grid styles */
	#projectsGrid {
		min-height: 400px;
		margin-top: 60px;
	}

	.section-header {
		text-align: center;
		margin-bottom: 50px;
	}

	.section-badge {
		display: inline-block;
		padding: 8px 20px;
		background: rgba(40, 167, 69, 0.1);
		color: #28a745;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 700;
		letter-spacing: 1px;
		margin-bottom: 20px;
	}

	.section-title {
		font-size: 42px;
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

	@media (max-width: 768px) {
		#projectsGrid {
			margin-top: 40px;
		}

		.section-title {
			font-size: 32px;
		}

		.section-subtitle {
			font-size: 16px;
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