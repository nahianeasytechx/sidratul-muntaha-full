<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Project Details'; // Set the page title
?>
<?php require './components/header.php'; ?>
<style>
    .parallax-window {
        min-height: 308px;
        background: transparent;
    }

    
    /* Program Details */
    .program-details h2 {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
    }

    .program-details img {
        margin-top: 0;
        margin-bottom:20px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .program-details img:hover {
        transform: translateY(-5px);
    }

    .program-details p {
        color: #475569;
        line-height: 1.8;
        font-size: 1rem;
    }

    .program-details p.fw-bold {
        color: #1e293b;
    }

    /* Card Background */
    .card-bg {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-bg:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .card-bg h4 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
    }

    .card-bg ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .card-bg ul li {
        padding: 0.75rem 0;
        color: #475569;
        font-size: 0.95rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .card-bg ul li:last-child {
        border-bottom: none;
    }

    .card-bg ul li:hover {
        padding-left: 0.5rem;
        color: #1e293b;
    }

    .card-bg ul li i {
        color: #10b981;
        font-size: 1.1rem;
        margin-right: 0.5rem;
    }

    /* Spacing */
    .mt-5 {
        margin-top: 4rem !important;
    }

    .scholarship-btn{
        padding: 10px 25px;
        background: #00a854;
        color: white;
        font-weight: 700;
        font-size: 20px;
        border-radius: 15px;
        text-decoration: none;
    }
    .scholarship-btn:hover{

color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .program-details h2 {
            font-size: 1.75rem;
        }

        .card-bg {
            margin-bottom: 1.5rem;
        }
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
                        <div class="home_title">School Project</div>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="projects.php">Projects</a></li>
                                <li>Project</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project details start -->
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12 col-lg-6 program-details">
            <h2>Project Details</h2>
            <img src="images/school.png" alt="" class="w-75 rounded-5">
            <p class="fs-6 fw-bold py-2">Sidratul School Development Project is an institutional Project for self-development and skill enhancement. This affiliate of the Sidratul Foundation, registered with the National Skill Development Authority, was established in 2022. Since its inception, it has been working to bring information technology and technical education to all levels of society, with the goal of eliminating unemployment and creating employment opportunities.</p>
            <p>The specialty of this institute is that it provides computer, information technology, and various technical training courses in a completely separate environment and with suitable curricula for both men and women. There are also special scholarships for talented and underprivileged students, enabling them to receive training free of charge.</p>
            <p>By developing skilled human resources, this institute has already started to solidify its position as an effective tool for alleviating the country's unemployment problem and fostering self-employment</p>
            <div class="mt-4">
                <a href="scholarship.php" class="scholarship-btn">
                    Get a Scholarship
                </a>
            </div>
        </div>


        <div data-aos="fade-up" class="col-md-12 col-lg-6 mt-5">
            <div class="p-4 card-bg">
                <h4>Project Goals & Objectives</h4>
                <ul>
                    <li class="d-flex gap-2 fs-6">
                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        Creativity Enhancement
                    </li>
                    <li class="d-flex gap-2 fs-6">
                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                       Elevating Skill
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
<!-- Program details end -->
<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->
<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>