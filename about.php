<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'About'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>
	body{
		font-family: "Poppins" ,sans-serif;
	}
	/* Main About Section */
	.main-about-section {
		padding: 80px 0 0px;
		margin-top: 70px;
		background: #ffffff;
	}
.custom-underline::after {
    content: '';
    position: absolute;
    bottom: -8px; /* adjust distance */
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #4CAF50, #45A049);
    border-radius: 2px;
}
	.about-content-wrapper {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		gap: 40px;
		margin-bottom: 10px;
	}

	/* Left Side - Image Gallery */
	.about-image-section {
		flex: 0 0 40%;
		max-width: 100%;
		padding-bottom: 30px;
		border-bottom: 3px solid #02BD61;
	}

	.about-image-gallery {
		position: relative;
		border-radius: 12px;
		overflow: hidden;

	}

	.about-image-gallery img {
		width: 60%;
		height: 60%;
		display: block;
	}

	/* Right Side - Text Content */
	.about-text-section {
		flex: 1;
	}

	.about-text-section h2 {
		font-size: 28px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 20px;
		line-height: 1.3;
	}

	.about-description {
		font-size: 15px;
		line-height: 1.9;
		color: #555;
		text-align: justify;
		font-weight: 400;
	}

	.about-description p {
		margin-bottom: 15px;
	}

	/* Principles and Values Section */
	.principles-section {
		background: #f8f9fa;
		padding: 60px 0;
	}

	.section-title {
		text-align: center;
		margin-bottom: 50px;
	}

	.section-title h2 {
		font-size: 32px;
		font-weight: 700;
		color: #2c3e50;
		position: relative;
		display: inline-block;
		padding-bottom: 15px;
	}

	.section-title h2::after {
		content: '';
		position: absolute;
		bottom: 0;
		left: 50%;
		transform: translateX(-50%);
		width: 80px;
		height: 4px;
		background: linear-gradient(to right, #4CAF50, #45a049);
		border-radius: 2px;
	}

	/* Principles List */
	.principles-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.principles-list li {
		display: flex;
		align-items: flex-start;
		gap: 15px;
		padding: 20px;
		margin-bottom: 15px;
		background: white;
		border-radius: 10px;
		box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
	}

	.principles-list li:hover {
		transform: translateX(10px);
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
	}

	.principle-icon {
		flex-shrink: 0;
		width: 30px;
		height: 30px;
		background: linear-gradient(135deg, #4CAF50, #45a049);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-weight: bold;
		font-size: 16px;
	}

	.principle-text {
		flex: 1;
		font-size: 15px;
		line-height: 1.7;
		color: #555;
	}

	/* Mission Section Cards */
	.mission-cards-section {
		padding: 60px 0;
		background: white;
	}

	.mission-cards-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 30px;
		margin-top: 40px;
	}

	.mission-card {
		background: white;
		border-radius: 12px;
		padding: 35px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
		transition: all 0.3s ease;
		border-left: 4px solid #4CAF50;
	}

	.mission-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
	}

	.mission-card-header {
		display: flex;
		align-items: center;
		gap: 15px;
		margin-bottom: 20px;
	}

	.mission-card-icon {
		width: 50px;
		height: 50px;
		background: linear-gradient(135deg, #4CAF50, #45a049);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-size: 24px;
	}

	.mission-card h3 {
		font-size: 22px;
		font-weight: 700;
		color: #2c3e50;
		margin: 0;
	}

	.mission-card ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.mission-card ul li {
		padding: 10px 0 10px 25px;
		position: relative;
		font-size: 14px;
		line-height: 1.7;
		color: #555;
		border-bottom: 1px solid #f0f0f0;
	}

	.mission-card ul li:last-child {
		border-bottom: none;
	}

	.mission-card ul li::before {
		content: '✓';
		position: absolute;
		left: 0;
		color: #4CAF50;
		font-weight: bold;
		font-size: 16px;
	}

	/* Support Card */
	.support-card {
		background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%);
		border-left-color: #FFA726;
	}

	.support-card .mission-card-icon {
		background: linear-gradient(135deg, #FFA726, #FB8C00);
	}

	.support-card ul li::before {
		color: #FFA726;
	}

	.donors-highlight {
		margin-top: 20px;
		padding: 20px;
		background: white;
		border-radius: 10px;
		border: 2px dashed #FFA726;
	}

	.donors-highlight strong {
		display: block;
		margin-bottom: 10px;
		color: #333;
	}

	.donor-names {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}

	.donor-badge {
		padding: 8px 18px;
		background: linear-gradient(135deg, #FFA726, #FB8C00);
		color: white;
		border-radius: 20px;
		font-size: 13px;
		font-weight: 600;
	}

	/* CTA Card */
	.cta-full-card {
		background: linear-gradient(135deg, #4CAF50, #45a049);
		color: white;
		text-align: center;
		padding: 50px;
		border-radius: 12px;
		box-shadow: 0 10px 40px rgba(76, 175, 80, 0.3);
		margin-top: 30px;
	}

	.cta-full-card h3 {
		font-size: 28px;
		font-weight: 700;
		margin-bottom: 20px;
		color: white;
	}

	.cta-full-card p {
		font-size: 16px;
		line-height: 1.8;
		margin-bottom: 15px;
		color: white;
	}

	.cta-highlight-text {
		font-size: 18px;
		font-weight: 600;
		padding: 25px;
		background: rgba(255, 255, 255, 0.15);
		border-radius: 10px;
		margin: 25px 0;
	}

	/* Custom Goals Tabs Styles */
	.goals-section {
		background: #f8f9fa;
		padding: 60px 0;
	}

	.custom-tab-navigation {
		display: flex;
		justify-content: center;
		align-items: center;
		flex-wrap: wrap;
		gap: 15px;
		margin-bottom: 40px;
		padding: 0;
		list-style: none;
	}

	.custom-tab-btn {
		background: #ffffff;
		border: 2px solid #e0e0e0;
		color: #333;
		padding: 15px 30px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		border-radius: 8px;
		min-width: 160px;
		text-align: center;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
	}

	.custom-tab-btn:hover {
		background: #f0f0f0;
		border-color: #4CAF50;
		transform: translateY(-2px);
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	}

	.custom-tab-btn.active-tab {
		background: linear-gradient(135deg, #4CAF50 0%, #05A057 100%);
		color: #ffffff;
		border-color: #4CAF50;
		box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
		transform: translateY(-2px);
	}

	.custom-tab-content-wrapper {
		background: #ffffff;
		border-radius: 12px;
		padding: 40px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
		min-height: 400px;
	}

	.custom-tab-pane {
		display: none;
		animation: fadeIn 0.5s ease-in;
	}

	.custom-tab-pane.active-content {
		display: block;
	}

	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(10px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.custom-tab-title {
		font-size: 28px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 25px;
		padding-bottom: 15px;
		border-bottom: 3px solid #4CAF50;
		display: inline-block;
	}

	.custom-tab-text {
		line-height: 1.8;
		color: #555;
	}

	.custom-tab-text p {
		margin-bottom: 15px;
		padding-left: 20px;
		position: relative;
	}

	.custom-tab-text p::before {
		content: "✓";
		position: absolute;
		left: 0;
		color: #4CAF50;
		font-weight: bold;
		font-size: 18px;
	}

	/* Responsive Design */
	@media(max-width: 992px) {
		.about-content-wrapper {
			flex-direction: column;
		}

		.about-image-gallery {
			margin-top: 0px;
		}

		.about-image-section {
			flex: 0 0 100%;
			max-width: 100%;
			margin-bottom: 30px;
		}

		.mission-cards-grid {
			grid-template-columns: 1fr;
		}
	}

	@media(max-width: 768px) {
		.main-about-section {
			padding: 50px 0 40px;
			margin-top: 60px;
		}

		.about-text-section h2 {
			font-size: 24px;
		}

		.section-title h2 {
			font-size: 26px;
		}

		.custom-tab-navigation {
			gap: 10px;
		}

		.custom-tab-btn {
			padding: 12px 20px;
			font-size: 14px;
			min-width: 140px;
		}

		.custom-tab-content-wrapper {
			padding: 25px 20px;
		}

		.custom-tab-title {
			font-size: 24px;
		}

		.mission-card {
			padding: 25px;
		}

		.cta-full-card {
			padding: 35px 20px;
		}
	}

	@media(max-width: 575px) {
		.custom-tab-btn {
			min-width: 120px;
			padding: 10px 15px;
			font-size: 13px;
		}

		.custom-tab-content-wrapper {
			padding: 20px 15px;
		}

		.about-text-section h2 {

			font-size: 19px;
		}

		.principles-list li {
			padding: 15px;
		}

		.mission-card {
			padding: 20px 15px;
		}

		.donor-names {
			flex-direction: column;
		}
	}
</style>

<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->

<!-- Main About Section -->
<div class="main-about-section">
	<div class="container">
		<div class="about-content-wrapper" data-aos="fade-up" data-aos-delay="200">

			<!-- Left Side - Image Gallery -->
			<div class="about-image-section">
				<div class="about-image-gallery d-flex justify-content-center">
					<img src="images/final-logo.png" alt="Sidratul Muntaha Foundation" />
				</div>
			</div>

			<!-- Right Side - Text Content -->
			<div class="about-text-section">
						<div class=" ">
			<h2 class="section-title border-bottom-0 custom-underline "  style="font-size:32px; padding-bottom: 20px; ">About Sidratul Muntaha Foundation</h2>
		</div>
				<h2 style="font-weight: 500; margin-top:36px;">Sidratul MuntahaFoundation is a non-political and non-profit service-oriented organization registered with the government</h2>
				<div class="">
					<p style="font-size: 28px;  ">Assalamualaikum Warahmatullahi Wabarakatuh,</p>

					<p>Sidratul Muntaha Foundation is a charitable, non-government, and non-political organization. It is a government registered Foundation and we have received Certificate of Registration from Joint Stock Companies & Firms Bangladesh on 24th April 2024.</p>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="container" data-aos="fade-up">
	<p>Our aim is a social welfare and benevolent institution dedicated to establishing an Islamic society that seeks the pleasure of Allah (SWT) through acts of goodness and service to humanity. We strive to promote social development programs benefiting people of all backgrounds regardless of nationality, religion, caste, or creed through voluntary initiatives.</p>

	<p>Our mission is to foster an environment of Unity, Faith, Knowledge and Compassion. Following the path of the Salaf as-Salih and righteous predecessors, we are dedicated to education, humanitarian welfare, and Dawah based on Quran and Sunnah.</p>

	<p>We continuously engage in various initiatives to serve humanity, spread authentic knowledge, promote good deeds, and develop a pure mindset. Our aim is to build an ideal Muslim society, spread authentic knowledge following the path of the Salaf as-Salih, promote good deeds, and strive for a balanced approach based on the Quran and Sunnah.</p>
</div>
<!-- Principles and Values Section -->
<div class="principles-section">
	<div class="container">
		<div class="section-title">
			<h2>Our Initiatives</h2>
		</div>

		<ul class="principles-list" data-aos="fade-up" data-aos-delay="300">
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">We have completed and ongoing various projects in Matlob Uttar, Chadpur, Dhaka and
Gopalganj area.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">We have completed Eidgha Minar in Shakrikandi, construction of new roads,
kindergartens and madrasa building. We also involved in social works such as
distributing Zakat, Sadaka and financial aid to orphans, scholarship to schools and
madrasha for underprivileged students, provide medical treat for poor peoples. Besides
we also provided essential items during Ramadan, Eid, natural disasters, emergencies,
nand the times of hardship.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">Inculcating the teachings of unity, solidarity and mutual brotherhood within the Ummah.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">We also have various projects are ongoing such as establishing kindergartens and
madrasa, providing scholarships and financial aid to underprivileged students, designing
and approval for five stories Hospital, designing and approval for two stories of Mosque,
new road and construction, new road, Solar Lamppost and Street name plate,
Distributing zakat and financial aid, essential items during natural disasters,
emergencies, and times of hardship.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">In Islamic Dawah and activities, we avoid extremism or rigidity, embracing generosity and tolerance, and making decisions wisely while maintaining ethical standards.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">Currently we are receving land and financial aid for Hospital and Mosque.We have
received land donation commitments for our Hospital and Mosque project from MD
Aglmamun Chowdhury, Muhammad Nadir Chowdhury, Sharmin Sultana Tamannah.</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">We humbly and sincerely invite you to join hands in supporting this noble mission of
Islamic education, building Mosque and Hospital and help spread the light of
knowledge, humanity for the pleasure of Allah (SWT).</div>
			</li>
			<li>
				<div class="principle-icon">●</div>
				<div class="principle-text">Your generosity can change lives. Through your Sadaqah, Zakat, and kind donations,
countless underprivileged and deserving students can continue their education and
build a brighter future. Together, we can uplift lives, nurture faith, and build a brighter
future by supporting Sidratul Muntaha Foundation today.</div>
			</li>
		</ul>
	</div>
</div>

<!-- Mission Cards Section -->
<div class="mission-cards-section">
	<div class="container">
		<div class="mission-cards-grid">

			<!-- Completed Projects Card -->
			<div class="mission-card" data-aos="fade-up" data-aos-delay="400">
				<div class="mission-card-header">
					<div class="mission-card-icon">
						<i class="fa fa-check-circle"></i>
					</div>
					<h3>Completed Projects</h3>
				</div>
				<ul>
					<li>Eidgah Minar in Shakrikandi</li>
					<li>Construction of new roads</li>
					<li>Kindergartens and madrasa buildings</li>
					<li>Distribution of Zakat and Sadaqah</li>
					<li>Financial aid to orphans</li>
					<li>Scholarships for underprivileged students</li>
					<li>Medical treatment support for poor people</li>
					<li>Essential items distribution during Ramadan, Eid, and emergencies</li>
				</ul>
			</div>

			<!-- Ongoing Projects Card -->
			<div class="mission-card" data-aos="fade-up" data-aos-delay="500">
				<div class="mission-card-header">
					<div class="mission-card-icon">
						<i class="fa fa-spinner"></i>
					</div>
					<h3>Ongoing Projects</h3>
				</div>
				<ul>
					<li>Mosque Project</li>
					<li>School project</li>
					<li>Hospital Project</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container mx-auto">
	<div class="mission-cards-section">
		<!-- Empty space for visual balance -->
		<div class="mission-card cta-full-card" data-aos="fade-up" data-aos-delay="700">
			<div class="mission-card-icon" style="margin: 0 auto 20px; background: rgba(255,255,255,0.2);">
				<i class="fa fa-heart"></i>
			</div>
			<h3>Join Our Noble Mission</h3>
			<p>We humbly and sincerely invite you to join hands in supporting this noble mission of Islamic education, building Mosque and Hospital, and help spread the light of knowledge and humanity for the pleasure of Allah (SWT).</p>
			<div class="cta-highlight-text">
				Your generosity can change lives. Through your Sadaqah, Zakat, and kind donations, countless underprivileged and deserving students can continue their education and build a brighter future.
			</div>
			<p><strong>Together, we can uplift lives, nurture faith, and build a brighter future.</strong></p>
		</div>
	</div>
</div>
<!-- Goals and Objectives Section with Custom Tabs -->
<div class="goals-section">
	<div class="container">
		<div class="section-title">
			<h2>Goals and Objectives</h2>
		</div>

		<div data-aos="fade-up" data-aos-delay="400">
			<!-- Custom Tab Navigation -->
			<ul class="custom-tab-navigation">
				<li>
					<button class="custom-tab-btn active-tab" data-target="education-panel">
						Education
					</button>
				</li>
				<li>
					<button class="custom-tab-btn" data-target="service-panel">
						Service
					</button>
				</li>
				<li>
					<button class="custom-tab-btn" data-target="dawah-panel">
						Dawah
					</button>
				</li>
				<li>
					<button class="custom-tab-btn" data-target="humanitarian-panel">
						Humanitarian
					</button>
				</li>
			</ul>

			<!-- Custom Tab Content Wrapper -->
			<div class="custom-tab-content-wrapper">

				<!-- Education Panel -->
				<div class="custom-tab-pane active-content" id="education-panel">
					<div class="custom-tab-title">Education</div>
					<div class="custom-tab-text">
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

				<!-- Service Panel -->
				<div class="custom-tab-pane" id="service-panel">
					<div class="custom-tab-title">Service</div>
					<div class="custom-tab-text">
						<p>Alleviate poverty, serve humanity, and contribute to a prosperous nation.</p>
						<p>Provide relief during natural disasters and carry out rehabilitation programs afterward.</p>
						<p>Install tube wells and water treatment facilities in areas lacking safe drinking water.</p>
						<p>Plant and maintain trees for Sadaqah Jariyah, environmental protection, and sustainable self-reliance.</p>
						<p>Distribute Iftar items to the needy during Ramadan.</p>
						<p>Organize Qurbani on behalf of the affluent and distribute to the underprivileged.</p>
						<p>Provide training and assistance to make students self-reliant.</p>
						<p>Take responsibility for orphans' education and care until they become independent.</p>
						<p>Provide suitable income-generating resources to ensure sustainable self-reliance.</p>
					</div>
				</div>

				<!-- Dawah Panel -->
				<div class="custom-tab-pane" id="dawah-panel">
					<div class="custom-tab-title">Dawah</div>
					<div class="custom-tab-text">
						<p>Establish monotheism (Tawheed) in the light of Quran and Sunnah.</p>
						<p>Conduct Dawah activities to eliminate shirk, innovations, and extremism.</p>
						<p>Plan Dawah programs to encourage good deeds and discourage wrongdoing.</p>
						<p>Construct and manage model mosques to promote peaceful and welfare-oriented society following the Prophet's mosque (PBUH) example.</p>
						<p>Organize weekly, monthly, annual, and occasion-based religious gatherings, discussions, and halaqas in mosques, madrasas, and auditoriums to convey Islamic perspectives.</p>
						<p>Publish and propagate fundamental and authentic books covering Islamic knowledge, Aqeedah, ethics, and viewpoints.</p>
						<p>Provide Dawah training for Imams, Khatibs, and Da'ees.</p>
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

				<!-- Humanitarian Panel -->
				<div class="custom-tab-pane" id="humanitarian-panel">
					<div class="custom-tab-title">Humanitarian</div>
					<div class="custom-tab-text">
						<p>Provide food, shelter, and healthcare for the underprivileged.</p>
						<p>Run blood donation and health awareness campaigns.</p>
						<p>Support refugee and displaced communities.</p>
						<p>Promote sustainable community development initiatives.</p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	// Custom Tab Switching Functionality
	document.addEventListener('DOMContentLoaded', function() {
		const tabButtons = document.querySelectorAll('.custom-tab-btn');
		const tabPanes = document.querySelectorAll('.custom-tab-pane');

		tabButtons.forEach(button => {
			button.addEventListener('click', function() {
				const targetId = this.getAttribute('data-target');

				// Remove active class from all buttons and panes
				tabButtons.forEach(btn => btn.classList.remove('active-tab'));
				tabPanes.forEach(pane => pane.classList.remove('active-content'));

				// Add active class to clicked button and corresponding pane
				this.classList.add('active-tab');
				document.getElementById(targetId).classList.add('active-content');
			});
		});
	});
</script>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>