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
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        background: linear-gradient(to right, #02BD61, #01A855);
        padding: 1.5rem;
        position: relative;
        color: white;
        flex-shrink: 0;
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
        z-index: 10;
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
        padding-right: 3rem;
    }

    .modal-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .badge-modern {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
        flex: 1;
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

    .modal-section {
        margin-bottom: 1.5rem;
    }

    .modal-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-section-title i {
        color: #02BD61;
    }

    .modal-description {
        color: #475569;
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .modal-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .modal-info-box {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .modal-info-box:hover {
        border-color: #02BD61;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(2, 189, 97, 0.15);
    }

    .info-box-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.5rem;
    }

    .info-box-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .info-box-icon.primary {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .info-box-icon.danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .info-box-icon.warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .info-box-icon.info {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #3730a3;
    }

    .info-box-icon.success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .info-box-title {
        font-weight: 600;
        color: #64748b;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-box-value {
        color: #1e293b;
        font-size: 0.95rem;
        font-weight: 600;
        margin-top: 0.25rem;
    }

    .info-box-value small {
        font-size: 0.8rem;
        font-weight: 500;
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

    @media (max-width: 768px) {
        .modal-content {
            max-height: 95vh;
        }

        .modal-title {
            font-size: 1.4rem;
        }

        .modal-info-grid {
            grid-template-columns: 1fr;
        }

        .modal-image img {
            height: 16rem;
        }
    }
</style>

<!-- Home Banner -->
<div class="home">
    <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/notice.jpg" data-speed="0.8"></div>
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
                    
                    // Calculate expiry date
                    $publish_date = new DateTime($notice['publish_date']);
                    $expiry_date = clone $publish_date;
                    $expiry_date->modify("+{$notice['duration']} months");
                    $current_date = new DateTime();
                    
                    // Determine if notice is auto-expired
                    $is_auto_expired = ($notice['status'] === 'Active' && $current_date > $expiry_date);
                    $actual_status = $is_auto_expired ? 'Expired (Auto)' : $notice['status'];
                    
                    // Encode all data as JSON for the modal
                    $noticeData = json_encode([
                        'id' => $notice['id'],
                        'title' => $notice['title'],
                        'description' => $notice['description'],
                        'image' => $imagePath,
                        'publish_date' => $fullDate,
                        'expiry_date' => $expiry_date->format('F d, Y'),
                        'duration' => $notice['duration'],
                        'type' => $notice['type'],
                        'category' => $notice['category'],
                        'status' => $actual_status,
                        'age_limit' => $notice['age_limit'],
                        'is_auto_expired' => $is_auto_expired,
                        'days_remaining' => $is_auto_expired ? -$current_date->diff($expiry_date)->days : $current_date->diff($expiry_date)->days,
                        'created_at' => date('F d, Y - h:i A', strtotime($notice['created_at']))
                    ]);
                ?>
                    <a href="#notice-<?php echo $notice['id']; ?>" class="notice-card modal-trigger" data-notice='<?php echo htmlspecialchars($noticeData, ENT_QUOTES); ?>'>
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

<!-- Enhanced Modal -->
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
                <div class="modal-badges" id="modalBadges"></div>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <div class="modal-image">
                <img id="modalImage" src="" alt="">
            </div>

            <!-- Description Section -->
            <div class="modal-section">
                <h5 class="modal-section-title">
                    <i class="fa-solid fa-file-lines"></i>
                    Notice Description
                </h5>
                <p class="modal-description" id="modalDescription"></p>
            </div>

            <!-- Date Information -->
            <div class="modal-info-grid">
                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon primary">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div class="info-box-title">Publish Date</div>
                    </div>
                    <div class="info-box-value" id="modalPublishDate"></div>
                </div>

                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon danger">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <div class="info-box-title">Expiry Date</div>
                    </div>
                    <div class="info-box-value" id="modalExpiryDate"></div>
                </div>

                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon warning">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="info-box-title">Duration</div>
                    </div>
                    <div class="info-box-value" id="modalDuration"></div>
                </div>

                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon info">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="info-box-title">Age Limit</div>
                    </div>
                    <div class="info-box-value" id="modalAgeLimit"></div>
                </div>
            </div>

            <!-- Category & Type Information -->
            <div class="modal-info-grid">
                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon primary">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div class="info-box-title">Type</div>
                    </div>
                    <div class="info-box-value" id="modalType"></div>
                </div>

                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon info">
                            <i class="fa-solid fa-folder"></i>
                        </div>
                        <div class="info-box-title">Category</div>
                    </div>
                    <div class="info-box-value" id="modalCategory"></div>
                </div>

                <div class="modal-info-box">
                    <div class="info-box-header">
                        <div class="info-box-icon success">
                            <i class="fa-solid fa-flag"></i>
                        </div>
                        <div class="info-box-title">Status</div>
                    </div>
                    <div class="info-box-value" id="modalStatus"></div>
                </div>
            </div>

            <!-- Created Information -->
            <div class="modal-info-box">
                <div class="info-box-header">
                    <div class="info-box-icon primary">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </div>
                    <div class="info-box-title">Created At</div>
                </div>
                <div class="info-box-value" id="modalCreatedAt"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('noticeModal');
    
    // Add click handlers to all notice cards
    document.querySelectorAll('.modal-trigger').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Parse notice data from data attribute
            const noticeData = JSON.parse(this.getAttribute('data-notice'));
            
            // Update modal content
            document.getElementById('modalDate').textContent = noticeData.publish_date;
            document.getElementById('modalTitle').textContent = noticeData.title;
            document.getElementById('modalDescription').textContent = noticeData.description;
            document.getElementById('modalImage').src = noticeData.image;
            document.getElementById('modalImage').alt = noticeData.title;
            
            // Update badges
            const badgesHtml = `
                <span class="badge-modern">
                    <i class="fa-solid fa-flag"></i>
                    ${noticeData.status}
                </span>
                <span class="badge-modern">
                    <i class="fa-solid fa-tag"></i>
                    ${noticeData.type}
                </span>
                <span class="badge-modern">
                    <i class="fa-solid fa-folder"></i>
                    ${noticeData.category}
                </span>
            `;
            document.getElementById('modalBadges').innerHTML = badgesHtml;
            
            // Update info boxes
            document.getElementById('modalPublishDate').textContent = noticeData.publish_date;
            
            // Expiry date with auto-expired badge
            let expiryHtml = noticeData.expiry_date;
            if (noticeData.is_auto_expired) {
                expiryHtml += '<br><small class="text-danger"><i class="fa-solid fa-clock me-1"></i>Auto-Expired</small>';
            }
            document.getElementById('modalExpiryDate').innerHTML = expiryHtml;
            
            // Duration with remaining days
            let durationHtml = noticeData.duration + ' months';
            if (noticeData.is_auto_expired) {
                durationHtml += '<br><small class="text-danger">(Expired ' + Math.abs(noticeData.days_remaining) + ' days ago)</small>';
            } else if (noticeData.days_remaining > 0 && noticeData.days_remaining <= 30) {
                durationHtml += '<br><small class="text-warning">(' + noticeData.days_remaining + ' days remaining)</small>';
            }
            document.getElementById('modalDuration').innerHTML = durationHtml;
            
            document.getElementById('modalAgeLimit').textContent = noticeData.age_limit ? noticeData.age_limit + ' years and above' : 'No age restriction';
            document.getElementById('modalType').textContent = noticeData.type;
            document.getElementById('modalCategory').textContent = noticeData.category;
            document.getElementById('modalStatus').textContent = noticeData.status;
            document.getElementById('modalCreatedAt').textContent = noticeData.created_at;
            
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