<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Projects';

require './components/header.php';

$projects = getAllActivities(); // fetch all


$projects = array_filter($projects, fn($p) => $p['status'] === 'Active');

// Get unique project types
$projectTypes = array_unique(array_column($projects, 'type'));


?>
<style>
    /* Filter Buttons */
    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 12px 30px;
        background: transparent;
        color: #008E48;
        border: 2px solid #008E48;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #008E48;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 142, 72, 0.3);
    }

    /* Project Cards - Matching Index Style */
    .project-item {
        margin-bottom: 30px;
    }

    .project-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .project-img {
        position: relative;
        height: 280px;
        overflow: hidden;
    }

    .project-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img img {
        transform: scale(1.1);
    }

    .project-body {
        padding: 35px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .project-tag {
        display: inline-block;
        padding: 6px 16px;
        color: #008E48;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .project-title {
        font-size: 24px;
        font-weight: 700;
        color: #0F2920;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .project-text {
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 25px;
        font-size: 15px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .project-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(135deg, #008E48 0%, #00a854 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        align-self: flex-start;
    }

    .project-btn:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 20px rgba(0, 142, 72, 0.3);
        color: #fff;
    }

    /* Section Styling */
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-badge {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(0, 142, 72, 0.1);
        color: #008E48;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 48px;
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

    .courses {
        padding: 80px 0;
        background: #fff;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .project-item {
        animation: fadeIn 0.5s ease;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .section-title {
            font-size: 36px;
        }

        .project-img {
            height: 240px;
        }

        .project-body {
            padding: 25px;
        }
    }

    @media (max-width: 575.98px) {
        .section-title {
            font-size: 28px;
        }

        .filter-btn {
            padding: 10px 20px;
            font-size: 14px;
        }

        .project-img {
            height: 220px;
        }

        .project-title {
            font-size: 20px;
        }

        .project-body {
            padding: 20px;
        }
    }
</style>
<link rel="stylesheet" href="./assets/css/projects.css">


<div class="courses pb-0 mb-0 mt-3">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">All Our Projects</h2>
        </div>

        <!-- Dynamic Filter Buttons -->
        <div class="filter-buttons" data-aos="fade-up" data-aos-delay="100">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <?php foreach ($projectTypes as $type): ?>
                <button class="filter-btn" data-filter="<?php echo htmlspecialchars($type); ?>">
                    <?php echo htmlspecialchars($type); ?> Projects
                </button>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <div class="col-lg-4 col-md-6 project-item" data-type="<?php echo htmlspecialchars($project['type']); ?>">
                        <div class="project-card">
                            <div class="project-img">
<?php
    // Clean project image path
    $projectImage = 'images/'; // default placeholder
    if (!empty($project['image'])) {
        $projectImage = preg_replace('/^\.\.\//', '', $project['image']);
    }
?>
<img src="<?php echo htmlspecialchars($projectImage); ?>" 
     alt="<?php echo htmlspecialchars($project['title']); ?>">


                            </div>
                            <div class="project-body">
                                <span class="project-tag"><?php echo htmlspecialchars($project['type']); ?> Projects</span>
                                <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                                <p class="project-text"><?php echo htmlspecialchars($project['short_description']); ?></p>
                                <?php if (!empty($project['slug'])): ?>
                                    <a href="project-details.php?slug=<?php echo urlencode($project['slug']); ?>" class="project-btn">
                                        See Details
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Details not available</span>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No projects available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const projectItems = document.querySelectorAll('.project-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter').toLowerCase();

                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter projects
                projectItems.forEach(item => {
                    const type = item.getAttribute('data-type').toLowerCase();

                    if (filter === 'all' || type === filter) {
                        item.style.display = 'block';
                        // Trigger animation
                        item.style.animation = 'none';
                        setTimeout(() => {
                            item.style.animation = 'fadeIn 0.5s ease';
                        }, 10);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>


