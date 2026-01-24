<!-- Navbar -->
        <style>
        	.main_nav li a,
        	.nav-donate-btn {
        		font-size: 14px;
        		text-transform: uppercase;
        	}

        	.main_nav li:not(:last-child) {
        		margin-right: 0px;
        	}

        	.nav-donate-btn {
        		font-weight: 700;
        	}

        	.nav-zakat-btn {
        		border-color: #05a657;
        		text-transform: uppercase;
        		color: #05a657;
        		font-size: 14px;
        		transition: .3s;
        		font-weight: 700;
				padding-bottom: 11px;
        	}


        	.nav-zakat-btn:hover {
        		background-color: #05a657;
        		color: #fff;
        	}

        	/* .logo_img img{
				min-width: 160px
			}
			@media(max-width:460px){
				.logo_img img{
				width: 150px
			} */
        </style>
        <div class="header_container mx-auto">
        	<div class=" container ">
        		<div class="row">
        			<div class="col">
        				<div class=" header_content d-flex flex-col align-items-center justify-content-between">
        					<div class="logo_container">
        						<a href="<?php echo BASE_URL; ?>">
        							<div class="logo_content mt-1">
        								<div class="logo_img">
        									<img src="<?php echo BASE_URL; ?>images/sidratul logo.png" alt="sidratul logo.png">
        								</div>

        							</div>
        						</a>
        					</div>
        					<nav class="main_nav_container d-flex ">
        						<ul class="main_nav">
        							<li
        								<?php
										if ($current_page == 'index.php') {
											echo 'class="active"';
										}
										?>>
        								<a href="<?php echo BASE_URL; ?>">home</a>
        							</li>
        							<li
        								<?php
										if ($current_page == 'about.php') {
											echo 'class="active"';
										}
										?>>
        								<a href="<?php echo BASE_URL; ?>about">About us</a>
        							</li>
        							<li
        								<?php
										if ($current_page == 'projects.php') {
											echo 'class="active"';
										}
										?>>
        								<a href="<?php echo BASE_URL; ?>projects">Our Projects</a>
        							</li>

        							<li
        								<?php
										if ($current_page == 'contact.php') {
											echo 'class="active"';
										}
										?>>
        								<a href="<?php echo BASE_URL; ?>contact">Contact Us</a>
        							</li>

        							<li
        								<?php
										if ($current_page == 'notice.php') {
											echo 'class="active"';
										}
										?>>
        								<a href="<?php echo BASE_URL; ?>notice">Notice</a>
        							</li>

        						</ul>


        						<div class="donate-btn-section d-lg-none">
        							<a href="<?php echo BASE_URL; ?>zakat-calculator" class="nav-donate-btn">Zakat Calculator</a>
        						</div>

        						<!-- Hamburger -->

        						<div class="hamburger menu_mm">
        							<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
        						</div>

        					</nav>

        					<!-- Language Toggle -->
        					<!-- <div class="d-none d-lg-flex">
        						<div class="language-toggle mx-2">
        							<button id="lang-toggle" class="lang-btn border-0" data-lang="en">EN</button>
        							<button id="lang-toggle" class="lang-btn active border-0" data-lang="bn">বাংলা</button>

        						</div> -->

        					<div class="d-flex ">
        						<div class="d-none d-lg-block mt-2 ">
        							<a href="<?php echo BASE_URL; ?>zakat-calculator" class="active text-decoration-none nav-zakat-btn">Zakat Calculator </a>
        						</div>
        						<div class="donate-btn-section d-none d-lg-block">
        							<a href="<?php echo BASE_URL; ?>donate" class="nav-donate-btn">Donate</a>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        </div>