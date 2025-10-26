<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Gallery'; // Set the page title
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

<!-- Home -->
<div class="home">
    <!-- Background image artist https://unsplash.com/@thepootphotographer -->
    <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/news.jpg" data-speed="0.8"></div>
    <div class="home_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content text-center">
                        <div data-aos="fade-up" class="home_title">Gallery</div>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>News</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photos Section -->
<div class="photos">
    <div class="container py-5 mt-5">

        <div class="row pt-3 mt-5">
            <?php
            // Array of photos
            $photos = [
				"images/gallery one.jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.40.42 AM.jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (2).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (3).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (4).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (5).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (6).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (7).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (8).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.30.27 AM.jpeg",           
                "images/WhatsApp Image 2025-09-26 at 2.30.29 AM (2).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.30.29 AM (3).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.30.29 AM (4).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.30.29 AM (5).jpeg",
                "images/WhatsApp Image 2025-09-26 at 2.30.29 AM (6).jpeg",
				"images/WhatsApp Image 2025-09-26 at 2.30.29 AM.jpeg",
            ];

            foreach ($photos as $photo) {
                echo '<div class="col-sm-12 col-md-6 col-lg-4 image-alignment">';
                echo '<a href="'.$photo.'" data-lightbox="news-gallery">';
                echo '<img src="'.$photo.'" alt="" class="img-fluid ">';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div>

    </div>
</div>



<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->

<?php require './components/footer.php'; ?>
