<style>
/* ============================================
   STANDARD DASHBOARD CSS - GREEN THEME
   ============================================ */

/* === ROOT VARIABLES === */
:root {
    --primary-color: #059669;
    --primary-dark: #047857;
    --primary-light: #10b981;
    --secondary-color: #0d9488;
    
    --text-dark: #1f2937;
    --text-medium: #4b5563;
    --text-light: #6b7280;
    
    --bg-white: #ffffff;
    --bg-gray: #f9fafb;
    --border-color: #e5e7eb;
    
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
    
    --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    
    --radius: 8px;
    --radius-lg: 12px;
    
    --transition: all 0.3s ease;
}

/* === GLOBAL RESETS === */
* {
    box-sizing: border-box;
}

.cursor-pointer {
    cursor: pointer;
}

a {
    text-decoration: none;
    transition: var(--transition);
}

button {
    border: 0;
    cursor: pointer;
    transition: var(--transition);
}

/* === CONTENT WRAPPER (FOR SIDEBAR LAYOUT) === */
.content-wrapper {
    width: 100%;
    max-width: 100%;
    padding: 20px;
}

/* === STAT CARDS === */
.stats-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 20px;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border: 1px solid var(--border-color);
    min-height: 130px;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.stat-card-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    flex-shrink: 0;
}

/* Dashboard Icons - Green Theme */
.stat-icon.donate {
    background: var(--primary-color);
}

.stat-icon.media-files {
    background: var(--secondary-color);
}

.stat-icon.notice {
    background: var(--info);
}

.stat-icon.activities {
    background: var(--warning);
}

.stat-icon.active {
    background: var(--success);
}

.stat-icon.expired {
    background: var(--danger);
}

.stat-icon.total {
    background: var(--primary-color);
}

.stat-icon.draft {
    background: var(--warning);
}

.stat-card-info {
    flex: 1;
}

.stat-card-title {
    font-size: 13px;
    font-weight: 600;
    margin: 0 0 8px 0;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card-value {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    color: var(--text-dark);
    line-height: 1;
}

.stat-card-label {
    font-size: 13px;
    color: var(--text-light);
    margin: 6px 0 0 0;
}

/* === QUICK ACTIONS === */
.quick-actions-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--text-dark);
}

.quick-actions-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.quick-action-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 28px;
    color: white;
}

.quick-action-icon.new-notice {
    background: var(--info);
}

.quick-action-icon.upload-media {
    background: var(--secondary-color);
}

.quick-action-icon.add-activity {
    background: var(--success);
}

.quick-action-icon.edit-about {
    background: var(--text-medium);
}

.quick-action-title {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
    color: var(--text-dark);
}

/* === TABLES === */
.row.g-4 {
    display: flex;
    flex-wrap: wrap;
}

.row.g-4 > [class*="col-"] {
    display: flex;
    flex-direction: column;
}
.chart-title{
    font-size: 24px;
    margin-bottom: 20px;
    color: var(--text-dark);
}
.table-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: var(--transition);
    border: 1px solid var(--border-color);
    width: 100%;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-shadow: var(--shadow);
}

.table-card:hover {
    box-shadow: var(--shadow-md);
}

.table-header {
    background: var(--primary-color);
    color: white;
    padding: 16px 20px;
    border: none;
}

.table-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 16px;
}

.table-responsive {
    flex: 1;
}

.table {
    margin-bottom: 0;
    width: 100%;
}

.table thead th {
    background-color: #f3f4f6;
    color: var(--text-medium);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    border-bottom: 2px solid var(--border-color);
    padding: 12px 16px;
    letter-spacing: 0.5px;
}

.table tbody td {
    color: var(--text-dark);
    font-size: 14px;
    vertical-align: middle;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
}

.table tbody tr:hover {
    background-color: var(--bg-gray);
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.badge {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 4px;
    font-weight: 600;
}

.badge.bg-success {
    background-color: var(--success) !important;
}

.badge.bg-warning {
    background-color: var(--warning) !important;
    color: white;
}

.badge.bg-danger {
    background-color: var(--danger) !important;
}

.table-card > div:last-child {
    padding: 14px 20px;
    background-color: var(--bg-gray);
    border-top: 1px solid var(--border-color);
    margin: 0 !important;
}

.table-btn {
    background: var(--primary-color);
    padding: 10px 20px;
    border-radius: var(--radius);
    color: white !important;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: var(--transition);
    font-size: 14px;
}

.table-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.badge-text {
    font-size: 12px;
}

/* === CREATE NOTICE PAGE === */
.create-notice {
    background: var(--bg-white);
    padding: 30px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.create-notice-title {
    font-size: 24px;
    margin-bottom: 24px;
    font-weight: 600;
    color: var(--text-dark);
}

.create-notice label {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-medium);
    display: block;
    margin-bottom: 6px;
}

.create-notice input,
.create-notice select,
.create-notice textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    font-size: 14px;
    transition: var(--transition);
    font-family: inherit;
}

.create-notice input:focus,
.create-notice select:focus,
.create-notice textarea:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.create-notice textarea {
    resize: vertical;
    min-height: 100px;
}

.btn-submit {
    background: var(--primary-color);
    color: white;
    padding: 12px 24px;
    border-radius: var(--radius);
    font-size: 14px;
    font-weight: 600;
    transition: var(--transition);
    cursor: pointer;
    border: none;
}

.btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* === ALL NOTICE PAGE === */
.all-notice .page-header {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.all-notice .page-header h1 {
    margin: 0;
    color: var(--text-dark);
    font-weight: 600;
    font-size: 24px;
}

.all-notice .page-header button {
    margin-left: auto;
}

.all-notice .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 8px 0 0 0;
}

.all-notice .icon-box {
    width: 48px;
    height: 48px;
    background: var(--primary-color);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.all-notice .filter-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.all-notice .filter-title {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 16px;
}

.all-notice .notice-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border-left: 4px solid transparent;
    border: 1px solid var(--border-color);
}

.all-notice .notice-card:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
}

.all-notice .notice-card.active {
    border-left-color: var(--success);
}

.all-notice .notice-card.expired {
    border-left-color: var(--danger);
}

.all-notice .notice-card.draft {
    border-left-color: var(--warning);
}

.all-notice .notice-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0 0 12px 0;
}

.all-notice .notice-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 12px;
    flex-wrap: wrap;
    color: var(--text-light);
    font-size: 13px;
}

.all-notice .notice-description {
    color: var(--text-medium);
    line-height: 1.6;
    margin-bottom: 16px;
    font-size: 14px;
}

.all-notice .notice-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid var(--border-color);
}

.all-notice .action-buttons {
    display: flex;
    gap: 8px;
}

.all-notice .btn-action {
    width: 36px;
    height: 36px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: var(--transition);
    cursor: pointer;
    font-size: 14px;
}

.all-notice .btn-action:hover {
    transform: scale(1.1);
}

.all-notice .btn-view {
    background: var(--primary-color);
    color: white;
}

.all-notice .btn-edit {
    background: var(--info);
    color: white;
}

.all-notice .btn-delete {
    background: var(--danger);
    color: white;
}

.all-notice .btn-duplicate {
    background: var(--warning);
    color: white;
}

.all-notice .btn-add-new {
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--radius);
    padding: 10px 20px;
    font-weight: 600;
    transition: var(--transition);
    font-size: 14px;
}

.all-notice .btn-add-new:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.all-notice .search-box {
    position: relative;
}

.all-notice .search-box input {
    border-radius: var(--radius);
    padding: 10px 14px 10px 40px;
    border: 1px solid var(--border-color);
    width: 100%;
}

.all-notice .search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-light);
}

/* === GALLERY === */
.gallery .form-control,
.gallery .form-select {
    border-radius: var(--radius);
    border: 1px solid var(--border-color);
    padding: 10px 14px;
    font-size: 14px;
    transition: var(--transition);
}

.gallery .form-control:focus,
.gallery .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    outline: none;
}

/* === SETTINGS === */
.settings .page-header {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.settings .page-header h1 {
    margin: 0;
    color: var(--text-dark);
    font-weight: 600;
    font-size: 24px;
}

.settings .settings-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.settings .section-title {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 18px;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border-color);
}

.settings .profile-photo {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border: 4px solid var(--primary-color);
    border-radius: 50%;
}

.settings .form-label {
    font-weight: 500;
    color: var(--text-medium);
    margin-bottom: 6px;
    font-size: 14px;
}

.settings .form-control {
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 10px 14px;
    transition: var(--transition);
}

.settings .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    outline: none;
}

.settings .btn-save {
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--radius);
    padding: 10px 24px;
    font-weight: 600;
    transition: var(--transition);
    font-size: 14px;
}

.settings .btn-save:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* === DONATION LIST === */
.donation-list .table-header th {
    color: white;
    background: transparent;
}

.donation-list .table-responsive {
    max-height: 600px;
    overflow-y: auto;
}

.donation-list .action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.donation-list .action-buttons .btn {
    min-width: 80px;
    padding: 6px 12px;
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 500;
    transition: var(--transition);
}

.donation-list .action-buttons .btn:hover {
    transform: translateY(-2px);
}

.donation-list .btn-add-new {
    background: var(--primary-color);
    color: white;
    font-size: 14px;
}

.donation-list .btn-add-new:hover {
    background: var(--primary-dark);
}

.donation-list .btn-info {
    background: var(--info);
    color: white;
}

.donation-list .btn-warning {
    background: var(--warning);
    color: white;
}

.donation-list .btn-danger {
    background: var(--danger);
    color: white;
}

/* === VIEW & EDIT DONATION === */
/* ===================================
   VIEW DONATION PAGE STYLES
   =================================== */

.view-donation .view-donation-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Back Button */
.view-donation .back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: #059669;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 500;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 2px solid #e5e7eb;
}

.view-donation .back-button:hover {
    background: #059669;
    color: white;
    border-color: #059669;
    transform: translateX(-5px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
}

/* Main Card */
.view-donation .donation-detail-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.view-donation .donation-detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

/* Card Header */
.view-donation .card-header-custom {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    padding: 2rem;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.view-donation .card-header-custom::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-10%, -10%); }
}

.view-donation .header-left {
    flex: 1;
    min-width: 250px;
    position: relative;
    z-index: 1;
}

.view-donation .header-left h2 {
    margin: 0 0 0.5rem 0;
    font-size: 1.75rem;
    font-weight: 700;
}

.view-donation .header-left p {
    margin: 0;
    opacity: 0.95;
    font-size: 0.95rem;
}

.view-donation .serial-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 1;
}

.view-donation .edit-btn-header {
    background: white;
    color: #059669;
    border: none;
    padding: 0.875rem 1.75rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    z-index: 1;
}

.view-donation .edit-btn-header:hover {
    background: #f0fdf4;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Card Body */
.view-donation .card-body-custom {
    padding: 2rem;
}

/* Detail Sections */
.view-donation .detail-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #f0f0f0;
}

.view-donation .detail-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.view-donation .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #059669;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.view-donation .section-title i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    border-radius: 10px;
    font-size: 1rem;
}

/* Detail Grid */
.view-donation .detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.view-donation .detail-item {
    background: #f9fafb;
    padding: 1.25rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.view-donation .detail-item:hover {
    background: white;
    border-color: #059669;
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
}

.view-donation .detail-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.view-donation .detail-value {
    font-size: 1.05rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
}

.view-donation .detail-value.amount {
    color: #059669;
    font-size: 1.5rem;
    font-weight: 700;
}

/* Category Badges */
.view-donation .category-badge-view {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
}

.view-donation .badge-education {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.view-donation .badge-health {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.view-donation .badge-emergency {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.view-donation .badge-food {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.view-donation .badge-general {
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

/* Notes Box */
.view-donation .notes-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #059669;
    font-style: italic;
    color: #1f2937;
    line-height: 1.6;
}

/* Previous Donations Card */
.view-donation .previous-donations-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}

.view-donation .previous-header {
    background: linear-gradient(135deg, #1f2937, #111827);
    padding: 1.5rem 2rem;
    color: white;
}

.view-donation .previous-header h3 {
    margin: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
}

.view-donation .previous-header i {
    font-size: 1.2rem;
}

.view-donation .previous-body {
    padding: 2rem;
}

/* Previous Table */
.view-donation .previous-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.view-donation .previous-table thead tr {
    background: linear-gradient(135deg, #f9fafb, #f3f4f6);
}

.view-donation .previous-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-weight: 700;
    color: #1f2937;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #059669;
}

.view-donation .previous-table th:first-child {
    border-top-left-radius: 10px;
}

.view-donation .previous-table th:last-child {
    border-top-right-radius: 10px;
}

.view-donation .previous-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e5e7eb;
}

.view-donation .previous-table tbody tr:hover {
    background: #f9fafb;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.view-donation .previous-table td {
    padding: 1rem 1.25rem;
    color: #4b5563;
}

.view-donation .previous-table .amount-cell {
    font-weight: 700;
    color: #059669;
    font-size: 1.05rem;
}

.view-donation .previous-table code {
    background: #f1f5f9;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    color: #475569;
    font-weight: 500;
}

/* No Previous Donations */
.view-donation .no-previous {
    text-align: center;
    padding: 3rem;
    color: #9ca3af;
}

.view-donation .no-previous i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.view-donation .no-previous p {
    margin: 0;
    font-size: 1.05rem;
}

/* Action Buttons */
.view-donation .action-buttons-bottom {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.view-donation .btn-action {
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.view-donation .btn-edit {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
}

.view-donation .btn-edit:hover {
    background: linear-gradient(135deg, #047857, #065f46);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(5, 150, 105, 0.3);
}

.view-donation .btn-back {
    background: white;
    color: #1f2937;
    border: 2px solid #e5e7eb;
}

.view-donation .btn-back:hover {
    background: #f9fafb;
    border-color: #059669;
    color: #059669;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

/* Utility Classes */
.view-donation .me-2 {
    margin-right: 0.5rem;
}

.view-donation .ms-2 {
    margin-left: 0.5rem;
}

.view-donation .mt-4 {
    margin-top: 1.5rem;
}

.view-donation .text-muted {
    color: #9ca3af;
}

/* Responsive Design */
@media (max-width: 768px) {
    .view-donation .view-donation-wrapper {
        padding: 1rem;
    }

    .view-donation .card-header-custom {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .view-donation .header-left h2 {
        font-size: 1.5rem;
    }

    .view-donation .serial-badge {
        width: 100%;
        text-align: center;
    }

    .view-donation .edit-btn-header {
        width: 100%;
        justify-content: center;
    }

    .view-donation .detail-grid {
        grid-template-columns: 1fr;
    }

    .view-donation .previous-table {
        display: block;
        overflow-x: auto;
    }

    .view-donation .previous-table thead {
        display: none;
    }

    .view-donation .previous-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
    }

    .view-donation .previous-table td {
        display: block;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .view-donation .previous-table td:last-child {
        border-bottom: none;
    }

    .view-donation .previous-table td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #6b7280;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .view-donation .action-buttons-bottom {
        flex-direction: column;
    }

    .view-donation .btn-action {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .view-donation .header-left h2 {
        font-size: 1.25rem;
    }

    .view-donation .section-title {
        font-size: 1.1rem;
    }

    .view-donation .card-body-custom {
        padding: 1.5rem;
    }

    .view-donation .previous-body {
        padding: 1.5rem;
    }
}
.donation-detail-card,
.donation-form-card {
    background: var(--bg-white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.card-header-custom {
    background: var(--primary-color);
    color: white;
    padding: 24px;
}

.card-header-custom h2 {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
}

.form-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-medium);
}

.form-control,
.form-select {
    padding: 10px 14px;
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    font-size: 14px;
    transition: var(--transition);
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    outline: none;
}

/* === LEGACY BACKGROUNDS === */
.donate-bg {
    background: var(--primary-color);
    border-radius: var(--radius-lg);
}

.media-files-bg {
    background: var(--secondary-color);
    border-radius: var(--radius-lg);
}

.notice-bg {
    background: var(--info);
    border-radius: var(--radius-lg);
}

.activities-bg {
    background: var(--warning);
    border-radius: var(--radius-lg);
}

.new-notice-bg {
    background: var(--info);
    border-radius: var(--radius-lg);
}

.upload-media-bg {
    background: var(--secondary-color);
    border-radius: var(--radius-lg);
}

.add-activity-bg {
    background: var(--success);
    border-radius: var(--radius-lg);
}

.edit-about-bg {
    background: var(--text-medium);
    border-radius: var(--radius-lg);
}

/* === RESPONSIVE === */
@media (max-width: 1200px) {
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 15px;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .stat-card {
        padding: 16px;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    
    .stat-card-value {
        font-size: 24px;
    }
    
    .quick-actions-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .create-notice,
    .all-notice .page-header {
        padding: 20px;
    }
    
    .table thead th,
    .table tbody td {
        padding: 10px;
        font-size: 13px;
    }
}

@media (max-width: 640px) {
    .all-notice .page-header button {
        margin-left: 0;
        margin-top: 12px;
        width: 100%;
    }
    
    .all-notice .notice-footer {
        flex-direction: column;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .stats-container {
        gap: 12px;
    }
    
    .stat-card-value {
        font-size: 20px;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    h1 {
        font-size: 20px;
    }
    
    .quick-actions-container {
        grid-template-columns: 1fr;
    }
}

/* === PRINT === */
@media print {
    .page-header .btn,
    .sidebar,
    .navbar,
    .action-buttons {
        display: none !important;
    }
}

/* === SCROLLBAR === */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: var(--bg-gray);
}

::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}
</style>