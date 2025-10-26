<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Contact'; // Set the page title
?>
<?php require './components/header.php'; ?>

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
							<div data-aos="fade-up" class="home_title">Notices</div>
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

<div class="notice-page">
	<div class="container">
<a href="notice-details.php">
        <div class="card_container">
<div class="date">
    <p>SAT</p>
    <h3>23</h3>
</div>
<div class="notice_text">
    <p>August 23,2025</p>
    <h3>Teacher Training Program</h3>
    <p>4-month residential/non-residential teacher training at As-Sunnah Skill Development Institute – Registration is ongoing.</p>
</div>
<div class="btn">
    <button>Notice</button>
</div>
    </div>
</a>
</div>
</div>
	</div>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>