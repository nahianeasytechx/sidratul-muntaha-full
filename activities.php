<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Activities'; // Set the page title
?>
<?php require './components/header.php'; ?>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

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
							<div data-aos="fade-up" class="home_title">Activities</div>
							<div class="breadcrumbs">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>Activities</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Courses -->
	<div class="courses">



<div class="container">
	<div class="row courses_row" id="activitiesGrid"></div>
				<!-- Pagination -->
			<div class="row">
				<div class="col">
					<div class="courses_paginations">
						<ul>
							<li class="active"><a href="#">01</a></li>
							<li><a href="#">02</a></li>
							<li><a href="#">03</a></li>
							<li><a href="#">04</a></li>
							<li><a href="#">05</a></li>
						</ul>
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