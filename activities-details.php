<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Activities Details'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>
	.parallax-window {
    min-height: 308px;
    background: transparent;
}
</style>
<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->


<!-- Home -->

<div class="home">
	<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_content text-center">
						<div class="home_title">Activity Title</div>
						<div class="breadcrumbs">
							<ul>
								<li><a href="activities.php">Activities</a></li>
								<li>Activity</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Program details start  -->
<div class="container  ">
	<div class="row mt-5 ">
		<div class="col-md-12 col-lg-6 program-details">
			<h2>Program Details</h2>
			<img src="images/act1.webp" alt="" class="w-75 rounded-5">
			<p class="fs-6 fw-bold py-2">Sidratul Skill Development Institute is an institution for self-development and skill enhancement. This affiliate of the As-Sunnah Foundation, registered with the National Skill Development Authority, was established in 2022. Since its inception, it has been working to bring information technology and technical education to all levels of society, with the goal of eliminating unemployment and creating employment opportunities.</p>
			<p>The specialty of this institute is that it provides computer, information technology, and various technical training courses in a completely separate environment and with suitable curricula for both men and women. There are also special scholarships for talented and underprivileged students, enabling them to receive training free of charge.</p>
			<p>By developing skilled human resources, this institute has already started to solidify its position as an effective tool for alleviating the country's unemployment problem and fostering self-employment</p>
		</div>
		<div 
		data-aos="fade-up"
		class="col-md-12 col-lg-6">
			<div class="p-4 card-bg">
				<h4>Project Goals & Objectives</h4>
				<ul>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Skill Enhancement
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Unemployment Alleviation
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Employment Creation
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Sustainable Poverty Reduction
					</li>
				</ul>
			</div>
			<div class="mt-4 p-4 card-bg">
				<h4>Expenditure Sectors</h4>
				<ul>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Land purchase for the institute
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Construction of the institute's infrastructure
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Smart Tailoring and Fashion Design
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
				Procurement of equipment
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
				Covering accommodation and food costs for trainees through scholarships
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
				Management expenses
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Driving Training
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Chef and Kitchen Management
					</li>
				</ul>

			</div>
			<div class="mt-4 p-4 card-bg">
				<h4>Expenditure Sectors</h4>
				<ul>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Land purchase for the institute
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Construction of the institute's infrastructure
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Procurement of equipment
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						Covering accommodation and food costs for trainees through scholarship
					</li>
					<li class="d-flex gap-2 fs-6">
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
	Management expenses
					</li>
				</ul>
			</div>
		</div>

	</div>
</div>
<!-- Program details end  -->

 <!-- Donate card start  -->
  <!-- <div
 data-aos="fade-up" 
  class="container">
	<div class="d-flex justify-content-center align-items-center">
		<div class="donate_card_bg">
	<div class="cardp">
				<p>Join the effort to alleviate poverty and create employment.</p>
	</div>
			<div class="card-btn">
				<a href="donate.php">Donate Now</a>
			</div>
		</div>
	
	</div>
  </div> -->
 <!-- Donate card end  -->


  <!-- Course Description End  -->


<!-- ADD THIS SCRIPT AT THE BOTTOM, BEFORE THE CLOSING PHP TAG -->

  
<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>