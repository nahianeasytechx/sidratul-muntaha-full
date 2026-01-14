<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Project Details';
require './components/header.php';

// Get activity slug from URL (slug-based routing)
$activity_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

// If no slug provided, redirect to projects page
if (empty($activity_slug)) {
    echo "<script>
    window.location.href='projects.php'
    </script>";
    exit();
}

// Fetch activity by slug from database
$activity = getActivityBySlug($activity_slug);

// Check if activity exists
if (!$activity) {
    echo "<script>
    alert('Project not found!');
    window.location.href='projects.php'
    </script>";
    exit();
}

// Decode sections data
$sections = [];
if (!empty($activity['sections_data'])) {
    $sections = json_decode($activity['sections_data'], true);
}
?>

<link rel="stylesheet" href="./assets/css/project-details.css">

<!-- Home Section -->
<div class="home">
    <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
    <div class="home_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content text-center">
                        <div class="home_title"><?php echo htmlspecialchars($activity['title']); ?></div>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="projects.php">Projects</a></li>
                                <li><?php echo htmlspecialchars($activity['title']); ?></li>
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
        <!-- Left Column: Image, Objectives, and Description -->
        <div class="col-md-12 <?php echo !empty($sections) ? 'col-lg-6' : 'col-lg-12'; ?> program-details">
            <h2><?php echo htmlspecialchars($activity['title']); ?> Details</h2>

            <!-- Activity Image -->
            <?php if (!empty($activity['image'])): ?>
                <?php
                $projectImage = 'images/school.png'; // default placeholder
                if (!empty($activity['image'])) {
                    $projectImage = preg_replace('/^\.\.\//', '', $activity['image']);
                }
                ?>
                <img src="<?php echo htmlspecialchars($projectImage); ?>"
                    alt="<?php echo htmlspecialchars($activity['title']); ?>"
                    class="w-100 rounded-5">
            <?php else: ?>
                <img src="images/school.png" alt="Default Project Image" class="w-100 rounded-5">
            <?php endif; ?>

            <!-- Objectives -->
            <div class="mt-4">
                <p><?php echo nl2br(htmlspecialchars($activity['objectives'])); ?></p>
            </div>

            <!-- Detailed Description -->
            <div class="mt-4">
                <p><?php echo nl2br(htmlspecialchars($activity['description'])); ?></p>
            </div>

            <!-- Static Scholarship Button -->
            <div class="mt-4">
                <a href="scholarship.php" class="scholarship-btn">
                    Get a Scholarship
                </a>
            </div>
        </div>

        <!-- Right Column: Dynamic Sections (Only show if sections exist) -->
        <?php if (!empty($sections)): ?>
            <div data-aos="fade-up" class="col-md-12 col-lg-6 mt-5">
                <?php foreach ($sections as $index => $section): ?>
                    <div class="mt-4 p-4 card-bg">
                        <h4><?php echo htmlspecialchars($section['title']); ?></h4>
                        <ul>
                            <?php foreach ($section['items'] as $item): ?>
                                <li class="d-flex gap-2 fs-6">
                                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                    <?php echo htmlspecialchars($item); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Program details end -->

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>


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
        margin-bottom: 20px;
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

    .scholarship-btn {
        padding: 10px 25px;
        background: #00a854;
        color: white;
        font-weight: 700;
        font-size: 20px;
        border-radius: 15px;
        text-decoration: none;
    }

    .scholarship-btn:hover {
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