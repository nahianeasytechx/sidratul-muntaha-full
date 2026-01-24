<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Project Details';
require './components/header.php';

// Get activity slug from URL (slug-based routing)
$activity_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

// If no slug provided, redirect to projects page
if (empty($activity_slug)) {
    echo "<script>
    window.location.href='" . BASE_URL . "projects'
    </script>";
    exit();
}

// Fetch activity by slug from database
$activity = getActivityBySlug($activity_slug);

// Check if activity exists
if (!$activity) {
    echo "<script>
    alert('Project not found!');
    window.location.href='" . BASE_URL . "projects'
    </script>";
    exit();
}

// Decode sections data
$sections = [];
if (!empty($activity['sections_data'])) {
    $sections = json_decode($activity['sections_data'], true);
}

// Parse multiple images - use images_array from getActivityBySlug if available
$images = [];
if (isset($activity['images_array']) && is_array($activity['images_array'])) {
    $images = $activity['images_array'];
} elseif (!empty($activity['images'])) {
    $images = json_decode($activity['images'], true) ?? [];
}

// Get full URL for parallax background
$parallax_image = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . BASE_URL . "images/about.jpg";
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/project-details.css">

<!-- Project details start -->
<div class="container top-margin">
    <div class="row mt-5">
        <!-- Left Column: Image, Objectives, and Description -->
        <div class="col-md-12 <?php echo !empty($sections) ? 'col-lg-6' : 'col-lg-12'; ?> program-details">
            <h2><?php echo htmlspecialchars($activity['title']); ?> Details</h2>

            <!-- Multiple Images Gallery -->
            <?php if (!empty($images) && is_array($images) && count($images) > 0): ?>
                <div class="images-gallery mb-4">
                    <?php if (count($images) === 1): ?>
                        <!-- Single Image Display -->
                        <div class="single-image-container">
                            <img src="<?php echo preg_replace('/^\.\.\//', BASE_URL, htmlspecialchars($images[0])); ?>"
                                alt="<?php echo htmlspecialchars($activity['title']); ?>"
                                class="w-100 rounded-5 main-project-image"
                                onclick="openLightbox(0)">
                        </div>
                    <?php else: ?>
                        <!-- Multiple Images Grid -->
                        <div class="images-gallery-grid">
                            <?php foreach ($images as $index => $imagePath): ?>
                                <div class="gallery-image-item" onclick="openLightbox(<?php echo $index; ?>)">
                                    <img src="<?php echo preg_replace('/^\.\.\//', BASE_URL, htmlspecialchars($imagePath)); ?>"
                                        alt="<?php echo htmlspecialchars($activity['title']); ?> - Image <?php echo $index + 1; ?>"
                                        loading="lazy">
                                    <div class="gallery-image-overlay">
                                        <div class="gallery-image-number">
                                            <i class="fa fa-search-plus"></i>
                                            <?php echo $index + 1; ?> / <?php echo count($images); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (!empty($activity['image'])): ?>
                <!-- Fallback for single image (backward compatibility) -->
                <?php
                $projectImage = BASE_URL . 'images/school.png'; // default placeholder
                if (!empty($activity['image'])) {
                    $projectImage = preg_replace('/^\.\.\//', BASE_URL, $activity['image']);
                }
                ?>
                <div class="single-image-container">
                    <img src="<?php echo htmlspecialchars($projectImage); ?>"
                        alt="<?php echo htmlspecialchars($activity['title']); ?>"
                        class="w-100 rounded-5 main-project-image"
                        onclick="openLightbox(0)">
                </div>
            <?php else: ?>
                <!-- Default placeholder image -->
                <img src="<?php echo BASE_URL; ?>images/school.png" alt="Default Project Image" class="w-100 rounded-5">
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
                <a href="<?php echo BASE_URL; ?>scholarship" class="scholarship-btn">
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

<!-- Lightbox for Image Viewing -->
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox(event)">
            <i class="fa fa-times"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="changeImage(-1, event)">
            <i class="fa fa-chevron-left"></i>
        </button>
        <img id="lightboxImage" class="lightbox-image" src="" alt="">
        <button class="lightbox-nav lightbox-next" onclick="changeImage(1, event)">
            <i class="fa fa-chevron-right"></i>
        </button>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>
</div>

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>

<style>
    .top-margin {
        margin-top: 30px;
    }

    @media(min-width:991px) {
        .top-margin {
            margin-top: 131px;
        }
    }

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

    /* Single Image Container */
    .single-image-container {
        margin-bottom: 20px;
    }

    .main-project-image {
        cursor: pointer;
        border-radius: 20px !important;
    }

    /* Multiple Images Gallery */
    .images-gallery {
        margin-bottom: 2rem;
    }

    .images-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .gallery-image-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        aspect-ratio: 4/3;
    }

    .gallery-image-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
    }

    .gallery-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-image-item:hover .gallery-image-overlay {
        opacity: 1;
    }

    .gallery-image-number {
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Lightbox for image viewing */
    .lightbox-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .lightbox-overlay.active {
        display: flex;
    }

    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 85vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: white;
        color: #1e293b;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: #ef4444;
        color: white;
        transform: rotate(90deg);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        color: #1e293b;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-nav:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-prev {
        left: -70px;
    }

    .lightbox-next {
        right: -70px;
    }

    .lightbox-counter {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.9);
        color: #1e293b;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
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

        .images-gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .lightbox-prev {
            left: 10px;
        }

        .lightbox-next {
            right: 10px;
        }
    }
</style>

<script>
    // Image Gallery Lightbox
    const galleryImages = <?php 
    if (!empty($images) && is_array($images)) {
        echo json_encode(array_map(function($path) {
            return preg_replace('/^\.\.\//', BASE_URL, $path);
        }, $images));
    } elseif (!empty($activity['image'])) {
        $singleImage = preg_replace('/^\.\.\//', BASE_URL, $activity['image']);
        echo json_encode([$singleImage]);
    } else {
        echo '[]';
    }
    ?>;

    let currentImageIndex = 0;

    function openLightbox(index) {
        if (galleryImages.length === 0) return;
        
        currentImageIndex = index;
        updateLightboxImage();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(event) {
        if (event) {
            event.stopPropagation();
            if (event.target.id === 'lightbox' || event.target.closest('.lightbox-close')) {
                document.getElementById('lightbox').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        } else {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    function changeImage(direction, event) {
        if (event) event.stopPropagation();

        currentImageIndex += direction;

        if (currentImageIndex >= galleryImages.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = galleryImages.length - 1;
        }

        updateLightboxImage();
    }

    function updateLightboxImage() {
        const lightboxImg = document.getElementById('lightboxImage');
        const counter = document.getElementById('lightboxCounter');

        if (galleryImages.length > 0) {
            lightboxImg.src = galleryImages[currentImageIndex];
            counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
        }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const lightbox = document.getElementById('lightbox');
        if (lightbox.classList.contains('active')) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                changeImage(-1);
            } else if (e.key === 'ArrowRight') {
                changeImage(1);
            }
        }
    });
</script>