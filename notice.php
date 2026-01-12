<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Notices';

require './components/header.php';

// Fetch all notices from database
$notices = getAllNotices();
?>

<style>
    .notice-page {
        background: linear-gradient(135deg, #EBF4FF 0%, #ffffff 50%, #F3E8FF 100%);
        padding: 3rem 0;
    }

    .notice-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .notice-header h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }

    .notice-header p {
        color: #6b7280;
        font-size: 1.125rem;
    }

    .notices-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .notices-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .notices-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .notice-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .notice-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: translateY(-8px);
    }

    .notice-card-header {
        background: linear-gradient(to right, #02BD61, #01A855);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .notice-card-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 8rem;
        height: 8rem;
        background: white;
        opacity: 0.1;
        border-radius: 50%;
        margin-right: -4rem;
        margin-top: -4rem;
    }

    .notice-date-info {
        position: relative;
        z-index: 10;
        color: white;
    }

    .notice-full-date {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .notice-day {
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #fff;
    }

    .notice-date-number {
        font-size: 3rem;
        font-weight: bold;
        line-height: 1;
        color: #fff;
    }

    .notice-card-body {
        padding: 1.5rem;
    }

    .notice-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 0.75rem;
        transition: color 0.3s ease;
    }

    .notice-card:hover .notice-title {
        color: #02BD61;
    }

    .notice-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.625;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .view-image-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #02BD61;
        font-weight: 600;
        font-size: 0.875rem;
        transition: gap 0.3s ease;
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
    }

    .notice-card:hover .view-image-btn {
        gap: 0.75rem;
    }

    .notice-bottom-border {
        height: 4px;
        background: linear-gradient(to right, #02BD61, #01A855);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .notice-card:hover .notice-bottom-border {
        transform: scaleX(1);
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        padding: 1rem;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease-out;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        max-width: 56rem;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: scaleIn 0.3s ease-out;
        max-height: 90vh;
    }

    .modal-header {
        background: linear-gradient(to right, #02BD61, #01A855);
        padding: 1.5rem;
        position: relative;
        color: white;
    }

    .modal-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        padding: 0.5rem;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-date-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .modal-title {
        font-size: 1.875rem;
        font-weight: bold;
        margin: 0;
        color: #fff;
    }

    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
    }

    .modal-image {
        margin-bottom: 1.5rem;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .modal-image img {
        width: 100%;
        height: 24rem;
        object-fit: cover;
    }

    .modal-details h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .modal-details p {
        color: #6b7280;
        line-height: 1.625;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .calendar-icon {
        width: 20px;
        height: 20px;
    }

    .close-icon {
        width: 24px;
        height: 24px;
        color: white;
    }

    .no-notices {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .no-notices i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
</style>

<!-- Home Banner -->
<div class="home">
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
                                <li>Notices</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notice Page Content -->
<div class="notice-page">
    <div class="container">
        <!-- Header -->
        <div class="notice-header">
            <h1>Latest Notices</h1>
            <p>Stay updated with our announcements and events</p>
        </div>

        <!-- Notices Grid -->
        <?php if (!empty($notices)): ?>
            <div class="notices-grid">
                <?php foreach ($notices as $notice): 
                    // Format date
                    $timestamp = strtotime($notice['publish_date']);
                    $day = date('D', $timestamp);
                    $date = date('d', $timestamp);
                    $fullDate = date('F d, Y', $timestamp);
                    $imagePath = !empty($notice['image']) ? './admin-panel/' . $notice['image'] : 'images/default-notice.jpg';
                ?>
                    <a href="#notice-<?php echo $notice['id']; ?>" class="notice-card modal-trigger" data-id="<?php echo $notice['id']; ?>" data-date="<?php echo $fullDate; ?>" data-title="<?php echo htmlspecialchars($notice['title']); ?>" data-description="<?php echo htmlspecialchars($notice['description']); ?>" data-image="<?php echo $imagePath; ?>">
                        <!-- Card Header -->
                        <div class="notice-card-header">
                            <div class="notice-date-info">
                                <div class="notice-full-date">
                                    <svg class="calendar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><?php echo $fullDate; ?></span>
                                </div>
                                <div>
                                    <p class="notice-day"><?php echo strtoupper($day); ?></p>
                                    <h3 class="notice-date-number"><?php echo $date; ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="notice-card-body">
                            <h3 class="notice-title"><?php echo htmlspecialchars($notice['title']); ?></h3>
                            <p class="notice-description"><?php echo htmlspecialchars($notice['description']); ?></p>

                            <div class="view-image-btn">
                                <svg class="calendar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>View Details</span>
                                <span style="font-size: 1.25rem;">→</span>
                            </div>
                        </div>

                        <!-- Bottom Border -->
                        <div class="notice-bottom-border"></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-notices">
                <i class="fa fa-bell-slash"></i>
                <h3>No Notices Available</h3>
                <p>There are currently no notices to display. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div id="noticeModal" class="modal-overlay">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <button class="modal-close-btn" onclick="closeModal()">
                <svg class="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div>
                <div class="modal-date-info">
                    <svg class="calendar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="modalDate"></span>
                </div>
                <h2 class="modal-title" id="modalTitle"></h2>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <div class="modal-image">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-details">
                <h3>Details</h3>
                <p id="modalDescription"></p>
            </div>
        </div>
    </div>
</div>

<script>
// Simple modal functionality without external data storage
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('noticeModal');
    const modalDate = document.getElementById('modalDate');
    const modalTitle = document.getElementById('modalTitle');
    const modalImage = document.getElementById('modalImage');
    const modalDescription = document.getElementById('modalDescription');
    
    // Add click handlers to all notice cards
    document.querySelectorAll('.modal-trigger').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get data from data attributes
            const date = this.getAttribute('data-date');
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');
            const image = this.getAttribute('data-image');
            
            // Update modal content
            modalDate.textContent = date;
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalImage.src = image;
            modalImage.alt = title;
            
            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when clicking on overlay
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
});

function closeModal() {
    const modal = document.getElementById('noticeModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

<?php require './components/join-platform-text.php'; ?>
<?php require './components/footer.php'; ?>