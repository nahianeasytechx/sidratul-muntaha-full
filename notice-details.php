<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Notice Details'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>



</style>
<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

    <!-- Home -->
	<div class="home">
		<!-- Background image artist https://unsplash.com/@thepootphotographer -->
		<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/contact.jpg" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div class="home_title">Title</div>
							<div class="breadcrumbs">
								<ul>
									<li><a href="index.php">Notice</a></li>
									<li>Details</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="notice">
    <div class="container my-5">
<div class="d-flex justify-content-between">
    <h6 class="mt-3">August 23, 2025</h6>
    <button class="notice-btn">Notice</button>
</div>
<h3 class="py-4 notice-title">Teacher Training Program</h3>
<h6>4-month residential/non-residential teacher training at As-Sunnah Skill Development Institute – Registration is ongoing.</h6>
<div class="mt-5">
    <div class="row">
<div class="col-lg-6 gap-5 mt-3">
    <div class="notice-features ">
<h1 class="text-center">4 months</h1>
<p class="text-center">Duration</p>
    </div>
</div>
<div class="col-lg-6 gap-5 mt-3">
    <div class="notice-features ">
<h1 class="text-center">Residential / Non-Residential</h1>
<p class="text-center">Type</p>
    </div>
</div>
<div class="col-lg-6 gap-5 mt-3">
    <div class="notice-features ">
<h1 class="text-center">Maximum 30</h1>
<p class="text-center">Age Limit</p>
    </div>
</div>
<div class="col-lg-6 gap-5 mt-3">
    <div class="notice-features ">
<h1 class="text-center">Male (General Teacher / Arabic Teacher)</h1>
<p class="text-center">Category</p>
    </div>
</div>
    </div>
</div>
<hr class="my-5">
<h3>Application Process</h3>
<div class="container d-flex justify-content-between">
<div class="my-3">
        <p>Deadline:</p>
        <h5>September 1 (4:00 PM)</h5>
        <br>
        <p>3-Day Workshop:</p>
        <h5>September 7-9</h5>
</div>
<div class="my-3">
        <p>Online Exam & Results:</p>
        <h5>September 3</h5>
        <br>
        <p>Required Documents:</p>
        <h5>CV, ID, Academic Certificates</h5>
</div>
</div>

</div>
</div>
	</div>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/footer.php'; ?>