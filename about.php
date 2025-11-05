<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'About'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>
.about {
padding-top: 0;
}
.tabs-rounded {
    margin-bottom: 50px;
}
	@media(max-width:575px) {
		.parallax-window {
			min-height: 290px;
			background: transparent;
		}
	}
</style>
<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

<!-- Home -->
<div class="about-home">
	<div class="home">
		<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div data-aos="fade-up" class="home_title">About</div>
							<div class="breadcrumbs">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>About</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container my-5">
	<!-- About -->
	<div class="about mb-0 pb-0">
		<div class="container">

			<div
				data-aos="fade-up"
					data-aos-delay="300"
				class="row">

				<div class="col-lg-6 mt-3">
					<div class="about_content">
						<h2><b>Our Platform's Main Goal</b></h2>
						<div class="about_text">
							<p>Sidratul Muntaha Foundation is a non-political and non-profit service-oriented organization registered with the government, dedicated to education, Dawah, and overall humanitarian welfare. Its registration number is S-13111/2019. It was founded in 2017 by Sheikh Ahmadullah, who directly oversees its operations as the chairman. This organization follows the footsteps of the teacher of humanity, the messenger of peace and salvation for mankind, the ideal of humanitarian service—Prophet Muhammad (peace and blessings be upon him). It is continuously</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6 mb-5">
					<div class="about_image text-center"><img src="images/sr-logo.png" width="50%" alt=""></div>
				</div>
			</div>


			<div class="section_title text-center mt-5">
				<h2>Goals and Objectives</h2>
			</div>

			<div class="mt-5 row tabs-rounded">
				<!-- Goals and Objectives Tabs -->
				<div class="tabs">
					<div class="tabs_container">
						<div class="tabs d-flex flex-row align-items-center justify-content-center flex-wrap">
							<div class="tab active">Education</div>
							<div class="tab">Service</div>
							<div class="tab">Dawah</div>
							<div class="tab">Humanitarian</div>
						</div>

						<div
							data-aos="fade-up"
							data-aos-delay="400"
							class="tab_panels">
							<!-- Education -->
							<div class="tab_panel active">
								<div class="tab_panel_content">
									<div class="row">
										<div class="col-lg-12">
											<div class="tab_text_title">Education</div>
											<div class="tab_text">
												<p>Spread of pure Islamic knowledge based on the Quran and Sunnah.</p>
												<p>Develop qualified Islamic scholars and speakers at national and international levels.</p>
												<p>Establish contemporary education research centers, curricula, and institutions based on Quran and Sunnah.</p>
												<p>Establish and operate schools, colleges, universities, and technical institutes centered on the principles of As-Sunnah Foundation.</p>
												<p>Through As-Sunnah Skill Development Institute, provide technical training to create employment for 100,000 unemployed youth annually by 2030.</p>
												<p>Empower underprivileged and poor women through technical training.</p>
												<p>Provide scholarships, educational resources, and support programs to meritorious poor and underprivileged students.</p>
												<p>Organize competitions on education, culture, and various social and life skills subjects.</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Service -->
							<div class="tab_panel">
								<div class="tab_panel_content">
									<div class="row">
										<div class="col-lg-12">
											<div class="tab_text_title">Service</div>
											<div class="tab_text">
												<p>Alleviate poverty, serve humanity, and contribute to a prosperous nation.</p>
												<p>Provide relief during natural disasters and carry out rehabilitation programs afterward.</p>
												<p>Install tube wells and water treatment facilities in areas lacking safe drinking water.</p>
												<p>Plant and maintain trees for Sadaqah Jariyah, environmental protection, and sustainable self-reliance.</p>
												<p>Distribute Iftar items to the needy during Ramadan.</p>
												<p>Organize Qurbani on behalf of the affluent and distribute to the underprivileged.</p>
												<p>Provide training and assistance to make students self-reliant.</p>
												<p>Take responsibility for orphans’ education and care until they become independent.</p>
												<p>Provide suitable income-generating resources to ensure sustainable self-reliance.</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Dawah -->
							<div class="tab_panel">
								<div class="tab_panel_content">
									<div class="row">
										<div class="col-lg-12">
											<div class="tab_text_title">Dawah</div>
											<div class="tab_text">
												<p>Establish monotheism (Tawheed) in the light of Quran and Sunnah.</p>
												<p>Conduct Dawah activities to eliminate shirk, innovations, and extremism.</p>
												<p>Plan Dawah programs to encourage good deeds and discourage wrongdoing.</p>
												<p>Construct and manage model mosques to promote peaceful and welfare-oriented society following the Prophet’s mosque (PBUH) example.</p>
												<p>Organize weekly, monthly, annual, and occasion-based religious gatherings, discussions, and halaqas in mosques, madrasas, and auditoriums to convey Islamic perspectives.</p>
												<p>Publish and propagate fundamental and authentic books covering Islamic knowledge, Aqeedah, ethics, and viewpoints.</p>
												<p>Provide Dawah training for Imams, Khatibs, and Da‘ees.</p>
												<p>Deliver Dawah alongside service activities based on a structured syllabus.</p>
												<p>Record topic-specific discussion programs and share them on social media.</p>
												<p>Write and publish original and translated books for non-Muslims highlighting the beauty of Islam.</p>
												<p>Raise public awareness about religious and social superstitions.</p>
												<p>Operate a Family Counseling department.</p>
												<p>Establish an open 'Call Center' for religious inquiries and guidance.</p>
												<p>Run Islamic Youth Clubs and Cultural Centers to strengthen the moral character of youth and children.</p>
												<p>Operate a Shariah Solution department for in-person religious guidance.</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Humanitarian -->
							<div class="tab_panel">
								<div class="tab_panel_content">
									<div class="row">
										<div class="col-lg-12">
											<div class="tab_text_title">Humanitarian</div>
											<div class="tab_text">
												<p>Provide food, shelter, and healthcare for the underprivileged.</p>
												<p>Run blood donation and health awareness campaigns.</p>
												<p>Support refugee and displaced communities.</p>
												<p>Promote sustainable community development initiatives.</p>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div><!-- tab_panels -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>