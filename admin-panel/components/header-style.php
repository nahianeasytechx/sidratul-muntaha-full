<style>

/* Dashboard CSS */
.cursor-pointer {
    cursor: pointer;
}

a{
    text-decoration: none;
}
button {
    border: 0;
}

/* Unified Stat Cards for All Pages */
.stats-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* exactly 4 per row */
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    min-height: 120px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.stat-card-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

/* Dashboard Specific Icon Backgrounds */
.stat-icon.donate {
    background: #1C87ED;
}

.stat-icon.media-files {
    background: radial-gradient(circle, rgba(63, 94, 251, 1) 0%, rgba(125, 17, 39, 1) 100%);
}

.stat-icon.notice {
    background: linear-gradient(65deg, rgba(9, 9, 121, 1) 0%, rgba(0, 212, 255, 1) 53%);
}

.stat-icon.activities {
    background: linear-gradient(90deg, rgba(252, 176, 69, 1) 0%, rgba(253, 29, 29, 1) 81%, rgba(252, 176, 69, 1) 100%);
}

/* All Notice Page Icon Backgrounds */
.stat-icon.active {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

.stat-icon.expired {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

.stat-icon.total {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.stat-icon.draft {
    background: linear-gradient(135deg, #fa709a, #fee140);
}

.stat-card-title {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.stat-card-value {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.stat-card-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin: 0;
}

/* Quick Actions - Unified Design */
.quick-actions-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #333;
}

.quick-actions-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.quick-action-card {
    background: white;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    color: white;
    padding: 26px;
}

/* Quick Action Icon Backgrounds */
.quick-action-icon.new-notice {
    background: #27A6F5;
}

.quick-action-icon.upload-media {
    background: linear-gradient(90deg, rgba(24, 178, 199, 1) 0%, rgba(16, 112, 181, 1) 100%);
}

.quick-action-icon.add-activity {
    background: linear-gradient(90deg, rgba(24, 199, 62, 1) 0%, rgba(16, 181, 132, 1) 100%);
}

.quick-action-icon.edit-about {
    background: radial-gradient(circle, rgba(179, 179, 179, 1) 0%, rgba(232, 188, 188, 1) 55%);
}

.quick-action-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: #333;
}

/* Legacy classes for backward compatibility */
.donate-bg {
    background-color: #1C87ED;
    border-radius: 20px;
}

.media-files-bg {
    background: #3F5EFB;
    background: radial-gradient(circle, rgba(63, 94, 251, 1) 0%, rgba(125, 17, 39, 1) 100%);
    border-radius: 20px;
}

.notice-bg {
    background: #090979;
    background: linear-gradient(65deg, rgba(9, 9, 121, 1) 0%, rgba(0, 212, 255, 1) 53%);
    border-radius: 20px;
}

.activities-bg {
    background: #FCB045;
    background: linear-gradient(90deg, rgba(252, 176, 69, 1) 0%, rgba(253, 29, 29, 1) 81%, rgba(252, 176, 69, 1) 100%);
    border-radius: 20px;
}

.new-notice-bg {
    background-color: #27A6F5;
    border-radius: 20px;
}

.upload-media-bg {
    background: #18b2c7;
    background: linear-gradient(90deg, rgba(24, 178, 199, 1) 0%, rgba(16, 112, 181, 1) 100%);
    border-radius: 20px;
}

.add-activity-bg {
    background: #18c73e;
    background: linear-gradient(90deg, rgba(24, 199, 62, 1) 0%, rgba(16, 181, 132, 1) 100%);
    border-radius: 20px;
}

.edit-about-bg {
    background: #b3b3b3;
    background: radial-gradient(circle, rgba(179, 179, 179, 1) 0%, rgba(232, 188, 188, 1) 55%);
    border-radius: 20px;
}


/* === Tables Section === */
.row.g-4 {
  display: flex;
  flex-wrap: wrap;
}

.row.g-4 > [class*="col-"] {
  display: flex;
  flex-direction: column;
}

.table-card {
  background: #ffffff;
  border-radius: 15px;
  overflow: hidden;
  transition: all 0.3s ease;
  border: 1px solid #e9ecef; 
  width: 100%;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.table-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.table-header {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  padding: 12px 16px;
  border-bottom: 1px solid #ddd;
}

.table-header h5 {
  margin: 0;
  font-weight: 600;
  font-size: 1rem;
}

.table-responsive {
  flex: 1;
}

.table {
  margin-bottom: 0;
}

.table thead th {
  background-color: #f8f9fa;
  color: #4a5568;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  border-bottom: 2px solid #dee2e6;
}

.table tbody td {
  color: #2d3748;
  font-size: 0.9rem;
  vertical-align: middle;
}

.table tbody tr:hover {
  background-color: #f1f5ff;
}

.badge {
  font-size: 0.75rem;
  padding: 5px 10px;
  border-radius: 12px;
}

.badge.bg-success {
  background-color: #10b981 !important;
}

.badge.bg-warning {
  background-color: #f59e0b !important;
}

.badge.bg-danger {
  background-color: #ef4444 !important;
}

/* Table Button Container */
.table-card > div:last-child {
  padding: 12px 16px;
  background-color: #f8f9fa;
  border-top: 1px solid #e9ecef;
  margin: 0 !important;
}

.table-btn {
  background: linear-gradient(135deg, #667eea, #764ba2);
  padding: 8px 20px;
  border-radius: 10px;
  color: white !important;
  font-weight: 500;
  text-decoration: none;
  display: inline-block;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.table-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  color: white !important;
}
.badge-text{
    font-size: 12px;
}


/* Create Notice Page Styling */
.create-notice {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.create-notice-title {
    font-size: 28px;
    margin-bottom: 25px;
    font-weight: 600;
}

.create-notice label {
    font-size: 16px;
    font-weight: 500;
}

.create-notice input,
.create-notice select,
.create-notice textarea {
    width: 100%;
    padding: 12px 15px;
    margin-top: 8px;
    border: 1px solid #d1d1d1;
    border-radius: 10px;
    font-size: 15px;
    transition: 0.3s;
}

.create-notice input:focus,
.create-notice select:focus,
.create-notice textarea:focus {
    border-color: #27A6F5;
    box-shadow: 0 0 6px rgba(39, 166, 245, 0.3);
    outline: none;
}

.create-notice textarea {
    resize: vertical;
}

.btn-submit {
    background-color: #27A6F5;
    color: #fff;
    padding: 12px 30px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    transition: 0.3s;
    cursor: pointer;
    border: none;
}

.btn-submit:hover {
    background-color: #1c87ed;
}

/* All Notice page Start */
.all-notice .page-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  
    
}

.all-notice .page-header h1 {
    margin: 0;
    color: #333;
    font-weight: 700;
}
.all-notice .page-header button{
margin-left: auto;
}

.all-notice .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0 0;
}

.all-notice .icon-box {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

/* Filter Card */
.all-notice .filter-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.all-notice .filter-title {
    color: #667eea;
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Notice Card */
.all-notice .notice-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    border-left: 5px solid transparent;
}

.all-notice .notice-card:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.all-notice .notice-card.active {
    border-left-color: #00f2fe;
}

.all-notice .notice-card.expired {
    border-left-color: #f5576c;
    opacity: 0.8;
}

.all-notice .notice-card.draft {
    border-left-color: #fee140;
}

.all-notice .notice-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.all-notice .notice-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    flex: 1;
}

.all-notice .notice-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.all-notice .badge-custom {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.875rem;
}

.all-notice .badge-active {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.all-notice .badge-expired {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.all-notice .badge-draft {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: white;
}

.all-notice .badge-type {
    background: #e0e0e0;
    color: #333;
}

.all-notice .notice-meta {
    display: flex;
    gap: 2rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    color: #6c757d;
    font-size: 0.9rem;
}

.all-notice .notice-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.all-notice .notice-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.all-notice .notice-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e0e0e0;
    flex-wrap: wrap;
    gap: 1rem;
}

.all-notice .action-buttons {
    display: flex;
    gap: 0.5rem;
}

.all-notice .btn-action {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.3s;
    cursor: pointer;
}

.all-notice .btn-action:hover {
    transform: scale(1.1);
}

.all-notice .btn-view {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.all-notice .btn-edit {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.all-notice .btn-delete {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.all-notice .btn-duplicate {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: white;
}

.all-notice .btn-add-new {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.all-notice .btn-add-new:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    color: white;
}

.all-notice .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.all-notice .empty-state i {
    font-size: 5rem;
    color: #e0e0e0;
    margin-bottom: 1rem;
}

.all-notice .pagination-custom {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.all-notice .pagination-custom .page-link {
    border-radius: 10px;
    border: none;
    color: #667eea;
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}

.all-notice .pagination-custom .page-link:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.all-notice .pagination-custom .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.all-notice .search-box {
    position: relative;
}

.all-notice .search-box input {
    border-radius: 15px;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e0e0e0;
}

.all-notice .search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

/* All Notice page End */

/* Gallery section start   */
/* Form Controls - Better Look */
.gallery .form-control,
.gallery .form-select {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 0.65rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s;
    box-shadow: none;
}

.gallery .form-control:focus,
.gallery .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Search input consistency */
.gallery #searchInput {
    padding-left: 2.5rem;
    background: #fff url('https://cdn-icons-png.flaticon.com/512/622/622669.png') no-repeat 10px center;
    background-size: 16px;
}
/* Gallery section End   */

/* Slider Managment start   */
.select2-container--bootstrap-5 .select2-selection {
    border-radius: 10px;
    border: 1px solid #ddd;
    min-height: 45px;
    padding: 0.375rem 0.75rem;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    line-height: 2;
}

.select2-container--bootstrap-5 .select2-dropdown {
    border-radius: 10px;
    border: 2px solid #667eea;
}

.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #667eea;
}
/* Slider Managment End   */
/* Settings Start    */
.settings .page-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.settings .page-header h1 {
    margin: 0;
    color: #333;
    font-weight: 700;
}

.settings .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0 0;
}

.settings .icon-box {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.settings .settings-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.settings .section-title {
    color: #667eea;
    font-weight: 600;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #667eea;
}

.settings .profile-photo-section {
    text-align: center;
    margin-bottom: 2rem;
}

.settings .profile-photo-container {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto 1rem;
}

.settings .profile-photo {
    width: 200px;
    height: 200px;
   object-fit: contain;
    border: 5px solid #667eea;

    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.settings .photo-upload-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    border: 3px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.settings .photo-upload-btn:hover {
    transform: scale(1.1);
}

.settings .photo-upload-btn i {
    color: white;
    font-size: 1rem;
}

.settings .photo-input {
    display: none;
}

.settings .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.settings .form-control {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}

.settings .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.settings .input-group-text {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 10px 0 0 10px;
}

.settings .btn-save {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s;
}

.settings .btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.settings .btn-cancel {
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s;
}

.settings .btn-cancel:hover {
    background: #5a6268;
    color: white;
}

.settings .info-badge {
    background: #f0f2ff;
    color: #667eea;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    display: inline-block;
    margin-bottom: 1rem;
}

.settings .password-strength {
    height: 5px;
    background: #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 0.5rem;
}

.settings .password-strength-bar {
    height: 100%;
    transition: all 0.3s;
}

.settings .password-toggle {
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.settings .alert-info {
    background: #e7f3ff;
    border: 1px solid #b3d9ff;
    border-radius: 10px;
    padding: 1rem;
    color: #004085;
}
/* Settings end    */

/* View Notice Page start  */
.view-notice .card {
    border: none;
}

.view-notice .badge {
    padding: 0.4rem 0.8rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.view-notice .content-text {
    line-height: 1.8;
    color: #333;
}

.view-notice .content-text p {
    margin-bottom: 1rem;
}

.view-notice .content-text ul {
    padding-left: 1.5rem;
}

.view-notice .content-text li {
    margin-bottom: 0.5rem;
}

.view-notice .info-box {
    transition: all 0.3s ease;
}

.view-notice .info-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
}

.view-notice .attachment-item {
    transition: all 0.3s ease;
}

.view-notice .attachment-item:hover {
    background-color: #f8f9fa;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.view-notice .contact-section {
    border-left: 4px solid #0d6efd;
}
/* View Notice Page end */

/* Edit activity page css start */
.edit-activity .card {
    border: none;
}

.edit-activity .card-header {
    border-bottom: 2px solid #e9ecef;
}

.edit-activity .form-label {
    font-weight: 500;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.edit-activity .form-control,
.edit-activity .form-select {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.625rem 0.875rem;
    transition: all 0.3s ease;
}

.edit-activity .form-control:focus,
.edit-activity .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.edit-activity .section-title-input {
    border: 1px dashed #cbd5e0;
    font-weight: 600;
    font-size: 1rem;
}

.edit-activity .section-title-input:focus {
    border-style: solid;
    border-color: #667eea;
}

.edit-activity .item-row {
    transition: all 0.3s ease;
}

.edit-activity .item-row:hover {
    transform: translateX(5px);
}

.edit-activity .file-item {
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.edit-activity .file-item:hover {
    background-color: #e9ecef;
}

.edit-activity .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    font-weight: 500;
    padding: 0.625rem 1.25rem;
}

.edit-activity .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.edit-activity .btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    border: none;
    font-weight: 500;
    padding: 0.625rem 1.25rem;
}

.edit-activity .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
}

.edit-activity .btn-outline-secondary {
    border: 2px solid #a0aec0;
    color: #4a5568;
    font-weight: 500;
}

.edit-activity .btn-outline-secondary:hover {
    background: #a0aec0;
    color: white;
}

.edit-activity .btn-outline-danger {
    border: 2px solid #f56565;
    color: #f56565;
    font-weight: 500;
}

.edit-activity .btn-outline-danger:hover {
    background: #f56565;
    color: white;
}

.edit-activity .btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    font-weight: 500;
}

.edit-activity .btn-outline-primary:hover {
    background: #667eea;
    color: white;
}

.edit-activity textarea {
    min-height: 200px;
}

.edit-activity .progress {
    border-radius: 10px;
    background-color: #e2e8f0;
}

.edit-activity .progress-bar {
    border-radius: 10px;
}

.edit-activity .dynamic-section {
    animation: slideIn 0.3s ease-out;
}

.edit-activity .image-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.edit-activity .image-item img {
    transition: transform 0.3s ease;
}

.edit-activity .image-item:hover img {
    transform: scale(1.05);
}

.edit-activity .image-item .btn-danger {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.edit-activity .image-item:hover .btn-danger {
    opacity: 1;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
/* Edit activity page css end  */


/* view donation page start   */
.view-donation-wrapper {
    padding: 30px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.view-donation-wrapper .back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #0d7a3f;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.view-donation-wrapper .back-button:hover {
    color: #0a5c2f;
    transform: translateX(-5px);
}

.view-donation-wrapper .donation-detail-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 30px;
}

.view-donation-wrapper .card-header-custom {
    background: linear-gradient(135deg, #0d7a3f 0%, #0a5c2f 100%);
    color: white;
    padding: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.view-donation-wrapper .header-left {
    flex: 1;
}

.view-donation-wrapper .header-left h2 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 600;
}

.view-donation-wrapper .header-left p {
    margin: 0;
    opacity: 0.9;
    font-size: 15px;
}

.view-donation-wrapper .serial-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 600;
}

.view-donation-wrapper .edit-btn-header {
    background: white;
    color: #0d7a3f;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.view-donation-wrapper  .edit-btn-header:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.view-donation-wrapper  .card-body-custom {
    padding: 40px;
}

.view-donation-wrapper  .detail-section {
    margin-bottom: 40px;
}

.view-donation-wrapper .section-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e0e0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.view-donation-wrapper  .section-title i {
    color: #0d7a3f;
}

.view-donation-wrapper .detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.view-donation-wrapper .detail-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.view-donation-wrapper .detail-label {
    font-size: 13px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.view-donation-wrapper .detail-value {
    font-size: 16px;
    color: #333;
    font-weight: 500;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #0d7a3f;
}

.view-donation-wrapper .detail-value.amount {
    font-size: 24px;
    color: #0d7a3f;
    font-weight: 700;
}

.view-donation-wrapper .category-badge-view {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
}

.view-donation-wrapper .badge-education { background: #0d6efd; color: white; }
.view-donation-wrapper .badge-health { background: #198754; color: white; }
.view-donation-wrapper .badge-emergency { background: #dc3545; color: white; }
.view-donation-wrapper .badge-food { background: #ffc107; color: #000; }
.view-donation-wrapper .badge-general { background: #6c757d; color: white; }

.view-donation-wrapper .notes-box {
    background: #fff9e6;
    border-left: 4px solid #ffc107;
    padding: 16px;
    border-radius: 6px;
    font-size: 15px;
    color: #333;
    line-height: 1.6;
}

.view-donation-wrapper .previous-donations-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.view-donation-wrapper .previous-header {
    background: #f8f9fa;
    padding: 20px 30px;
    border-bottom: 2px solid #e0e0e0;
}

.view-donation-wrapper .previous-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.view-donation-wrapper .previous-header h3 i {
    color: #0d7a3f;
}

.view-donation-wrapper .previous-body {
    padding: 30px;
}

.view-donation-wrapper .previous-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.view-donation-wrapper .previous-table thead th {
    background: #f8f9fa;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #666;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e0e0e0;
}

.view-donation-wrapper .previous-table tbody tr {
    background: #ffffff;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.view-donation-wrapper .previous-table tbody tr:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.view-donation-wrapper .previous-table tbody td {
    padding: 16px;
    color: #333;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
}

.view-donation-wrapper .previous-table tbody td:first-child {
    border-left: 1px solid #e0e0e0;
    border-radius: 8px 0 0 8px;
}

.view-donation-wrapper .previous-table tbody td:last-child {
    border-right: 1px solid #e0e0e0;
    border-radius: 0 8px 8px 0;
}

.view-donation-wrapper .amount-cell {
    font-weight: 700;
    color: #0d7a3f;
    font-size: 16px;
}

.view-donation-wrapper .no-previous {
    text-align: center;
    padding: 40px;
    color: #999;
}

.view-donation-wrapper .no-previous i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.3;
}

.view-donation-wrapper .view-donation-wrapper .action-buttons-bottom {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
    flex-wrap: wrap;
}

.view-donation-wrapper .btn-action {
    padding: 14px 30px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
}

.view-donation-wrapper .btn-edit {
    background: #0d7a3f;
    color: white;
}

.view-donation-wrapper .btn-edit:hover {
    background: #0a5c2f;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 122, 63, 0.3);
}

.view-donation-wrapper .btn-back {
    background: #6c757d;
    color: white;
}

.view-donation-wrapper .btn-back:hover {
    background: #5a6268;
    transform: translateY(-2px);
}
/* view donation page end  */

/* edit donation page start  */
.edit-donation-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.edit-donation-container .donation-form-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    max-width: 500px;
    width: 100%;
    padding: 40px;
}

.edit-donation-container .form-header {
    background: linear-gradient(135deg, #0d7a3f 0%, #0a5c2f 100%);
    color: white;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    text-align: center;
}

.edit-donation-container.form-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.edit-donation-container .form-header p {
    margin: 8px 0 0 0;
    font-size: 14px;
    opacity: 0.9;
}

.edit-donation-container .form-group {
    margin-bottom: 24px;
}

.edit-donation-container .form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.edit-donation-container .form-label .required {
    color: #dc3545;
    margin-left: 3px;
}

.edit-donation-container .form-control, .form-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background-color: #fff;
}

.form-control:focus, .form-select:focus {
    border-color: #0d7a3f;
    outline: none;
    box-shadow: 0 0 0 3px rgba(13, 122, 63, 0.1);
}

.edit-donation-container .form-control:disabled {
    background-color: #f5f5f5;
    cursor: not-allowed;
    color: #666;
}

.edit-donation-container .serial-display {
    background-color: #f8f9fa;
    border: 2px solid #e0e0e0;
    padding: 12px 16px;
    border-radius: 8px;
    font-weight: 600;
    color: #333;
    font-size: 18px;
    text-align: center;
}

.edit-donation-container .btn-save {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #0d7a3f 0%, #0a5c2f 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 122, 63, 0.3);
}

.edit-donation-container .btn-cancel {
    width: 100%;
    padding: 14px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.edit-donation-container .btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.edit-donation-container .info-badge {
    display: inline-block;
    background: #e7f5ed;
    color: #0d7a3f;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 8px;
}

.edit-donation-container .category-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    margin-top: 5px;
}

.edit-donation-container .badge-education { background: #0d6efd; color: white; }
.edit-donation-container .badge-health { background: #198754; color: white; }
.edit-donation-container .badge-emergency { background: #dc3545; color: white; }
.edit-donation-container .badge-food { background: #ffc107; color: #000; }
.edit-donation-container .badge-general { background: #6c757d; color: white; }
/* edit donation page end  */

/* More spacing on small devices */
@media (max-width: 991px) {
    .stat-card-title {
        font-size: 16px;
    }

.stat-icon {
    width: 45px;
    height: 45px;
    font-size: 19px;
    padding: 12px;
}
}

@media (max-width: 768px) {
    .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-card-title {
        font-size: 14px;
    }

    .stat-card-value {
        font-size: 1.5rem;
    }

    .quick-actions-container {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }

    .quick-action-card {
        padding: 1.5rem 1rem;
    }

    .quick-action-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .quick-action-title {
        font-size: 0.9rem;
    }

    .create-notice {
        padding: 20px;
    }

    .create-notice-title {
        font-size: 24px;
    }

    .all-notice .notice-header {
        flex-direction: column;
    }

    .all-notice .notice-meta {
        flex-direction: column;
        gap: 0.5rem;
    }

    .all-notice .notice-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .all-notice .action-buttons {
        justify-content: center;
    }


    /* view donation css   */
      .view-donation-wrapper   .card-header-custom {
        flex-direction: column;
        align-items: flex-start;
    }
    
 .view-donation-wrapper    .detail-grid {
        grid-template-columns: 1fr;
    }
    
  .view-donation-wrapper   .previous-table {
        font-size: 14px;
    }
    
  .view-donation-wrapper   .previous-table thead th,
  .view-donation-wrapper   .previous-table tbody td {
        padding: 10px;
    }
    .donation-list .stat-icon {
    width: 35px;
    height: 36px;
}
}

/* Donation List start  */

.donation-list .table-header {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
  padding: 12px 16px;
  border-bottom: 1px solid #ddd;
}

.donation-list .table-header th {
    color: black;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
    border: none;
    white-space: nowrap;
}

.donation-list .table tbody td {
    padding: 0.875rem 0.75rem;
    vertical-align: middle;
    font-size: 0.9rem;
    border-bottom: 1px solid #e9ecef;
}
.donation-list .table-responsive{
    height: 700px;
    overflow-y: scroll;
}
.donation-list .table tbody tr {
    transition: background-color 0.2s ease;
}

.donation-list .table tbody tr:hover {
    background-color: #f8f9fa;
}

.donation-list .table tbody tr:last-child td {
    border-bottom: none;
}

.donation-list .action-buttons {
    display: flex;
    gap: 0.4rem;
    justify-content: center;
    flex-wrap: nowrap;
}


/* Keep all action buttons same size */
.donation-list .action-buttons .btn {
  max-width: 90px; /* fixed button width */
  text-align: center;
  padding: 0.45rem 0.75rem;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.3s ease;
  white-space: nowrap;
}
.donation-list .btn-add-new {
    max-height: 46px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}
.donation-list .action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Equal height consistency */
.donation-list .action-buttons .btn-warning,
.donation-list .action-buttons .btn-info,
.donation-list .action-buttons .btn-danger
 {
 height: 36px;
}
.donation-list .badge {
    padding: 0.45rem 0.7rem;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 6px;
    white-space: nowrap;
}

.donation-list code {
    background-color: #f1f5f9;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    color: #475569;
    font-size: 0.8rem;
    font-family: 'Courier New', monospace;
    white-space: nowrap;
}

.donation-list .card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.donation-list .table-responsive {
    border-radius: 12px;
}

/* Improved spacing for stats */
.donation-list .stat-card-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Better filter card spacing */
.donation-list .filter-card {
    padding: 1.25rem 1.5rem;
}

.donation-list .filter-title {
    font-weight: 600;
    font-size: 1rem;
    color: #1e293b;
}

/* Stat Icon Colors - Customize these */
.donation-list .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.donation-list .stat-icon.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.donation-list .stat-icon.active {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.donation-list .stat-icon.expired {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.donation-list .stat-icon.draft {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

/* Page Header Icon */
.donation-list .icon-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

/* Action Button Icon Colors - Already handled by Bootstrap classes */
.donation-list .btn-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
    border: none;
    color: white;
}

.donation-list .btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    border: none;
    color: white;
}

.donation-list .btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: white;
}
/* Add Donation Category   */

/* Responsive adjustments */
@media (max-width: 768px) {
    .donation-list .action-buttons {
        gap: 0.25rem;
    }
    
    .donation-list .action-buttons .btn {
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .donation-list .table-header th {
        font-size: 0.75rem;
        padding: 0.75rem 0.5rem;
    }
    
    .donation-list .table tbody td {
        padding: 0.75rem 0.5rem;
        font-size: 0.85rem;
    }
}


/* Donation List end  */
@media print {
    .page-header,
    .view-notice .d-flex.gap-2,
    .view-notice .d-flex.justify-content-between:last-child,
    .sidebar,
    .navbar {
        display: none !important;
    }
    
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
}

@media(max-width:640px){
    .all-notice .page-header button {
    margin-left: 0;
}
}
@media (max-width:460px){
.breadcrumb .breadcrumb-item {
    font-size: 11px;
}
h1 {
    font-size: 25px;
    margin-bottom: 25px;
}
.donation-list .btn-add-new {
    font-size: 14px;
}
.stat-icon {
    width: 30px;
    height: 30px;
    font-size: 16px;
    padding: 12px;
}
}
</style>