<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Donation Categories';
?>
<?php require './components/header.php'; ?>

<style>
    /* Statistics Cards - Updated to match notices styling */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card-modern {
        position: relative;
        padding: 28px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card-modern:hover::before {
        opacity: 1;
    }

    .stat-card-modern.total { --gradient-start: #8b5cf6; --gradient-end: #7c3aed; }
    .stat-card-modern.active { --gradient-start: #10b981; --gradient-end: #059669; }
    .stat-card-modern.raised { --gradient-start: #ef4444; --gradient-end: #dc2626; }
    .stat-card-modern.donors { --gradient-start: #f59e0b; --gradient-end: #d97706; }

    .stat-content-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-info h3 {
        font-size: 36px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 8px 0 0 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon-modern {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .stat-card-modern:hover .stat-icon-modern {
        transform: rotate(10deg) scale(1.1);
    }

    .stat-icon-modern i {
        font-size: 28px;
        color: #fff;
    }

    /* Page Header - Updated to match notices styling */
    .page-title-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-title-section .icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
    }

    .page-title-section h1 {
        margin: 0;
        color: #1e293b;
        font-weight: 700;
        font-size: 28px;
    }

    .page-title-section .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 8px 0 0 0;
        font-size: 14px;
        border:none;
    }

    .btn-add-new {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
        color: white;
    }

    /* Filter Section - Updated to match notices styling */
    .filter-section {
        background: #fff;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 32px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .filter-header i {
        font-size: 20px;
        color: #8b5cf6;
    }

    .filter-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .filter-select {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        background-color: #fff;
        padding-right: 45px;
    }

    .filter-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 14px 18px 14px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .search-input-wrapper input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
    }

    /* Category Cards - Updated to match notices styling */
    .category-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .category-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--accent-color), var(--accent-color-dark));
    }

    .category-card.status-active { --accent-color: #10b981; --accent-color-dark: #059669; }
    .category-card.status-inactive { --accent-color: #64748b; --accent-color-dark: #475569; }
    .category-card.status-completed { --accent-color: #8b5cf6; --accent-color-dark: #7c3aed; }

    .category-card:hover {
        transform: translateX(4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 16px;
        gap: 16px;
    }

    .category-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .category-description {
        color: #475569;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .category-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #64748b;
    }

    .meta-item i {
        color: #8b5cf6;
        font-size: 14px;
    }

    /* Progress Bar Styling */
    .progress-section {
        margin-bottom: 16px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 14px;
        color: #64748b;
    }

    .progress-percent {
        font-weight: 700;
        color: #059669;
        font-size: 14px;
    }

    .progress-bar-modern {
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .progress-stats {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #64748b;
    }

    .category-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .category-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge-modern {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-active {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-inactive {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        color: #475569;
    }

    .badge-completed {
        background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
        color: #6b21a8;
    }

    .badge-type {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .category-actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 10px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-view {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .btn-edit {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .btn-delete {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state-icon i {
        font-size: 36px;
        color: #94a3b8;
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 16px;
    }

    /* Pagination */
    .pagination-modern {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 32px;
    }

    .page-btn {
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .page-btn:hover:not(.disabled):not(.active) {
        border-color: #8b5cf6;
        color: #8b5cf6;
        transform: translateY(-2px);
    }

    .page-btn.active {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
    }

    .page-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
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

    .category-card {
        animation: fadeIn 0.5s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-info h3 {
            font-size: 28px;
        }

        .stat-icon-modern {
            width: 50px;
            height: 50px;
        }

        .stat-icon-modern i {
            font-size: 22px;
        }

        .page-title-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .category-header {
            flex-direction: column;
        }

        .category-footer {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .category-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-section .row {
            gap: 16px;
        }
        
        .filter-section .col-md-4,
        .filter-section .col-md-2 {
            width: 100%;
        }
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="donation-categories">

        <!-- Page Title -->
        <div class="page-title-section">
            <div class="page-title-content">
                <div class="icon-box">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h1>All Donation Categories</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Donation Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <button class="btn-add-new" onclick="window.location.href='add-donation.php'">
                <i class="fa-solid fa-plus"></i>Add New Category
            </button>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card-modern total">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Categories</div>
                        <h3 id="totalCount">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern active">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Active</div>
                        <h3 id="activeCount">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern raised">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Raised</div>
                        <h3 id="totalRaised">৳ 0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern donors">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Donors</div>
                        <h3 id="totalDonors">0</h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <i class="fa-solid fa-filter"></i>
                <h5>Filters & Search</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search categories..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="emergency">Emergency</option>
                        <option value="general">General</option>
                        <option value="project">Project</option>
                        <option value="zakat">Zakat</option>
                        <option value="sadaqah">Sadaqah</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="targetFilter">
                        <option value="all">All Targets</option>
                        <option value="reached">Target Reached</option>
                        <option value="progress">In Progress</option>
                        <option value="new">Just Started</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="amount">By Amount</option>
                        <option value="donors">By Donors</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div id="categoriesList"></div>

        <!-- Pagination -->
        <div class="pagination-modern">
            <a class="page-btn disabled">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <a class="page-btn active">1</a>
            <a class="page-btn">2</a>
            <a class="page-btn">3</a>
            <a class="page-btn">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
const sampleCategories = [
    {
        id: 1, 
        name: "Education Support Fund", 
        description: "Help underprivileged children access quality education and build a better future through learning opportunities", 
        type: "general", 
        status: "active", 
        targetAmount: 50000, 
        raisedAmount: 35000, 
        donors: 145, 
        image: "education.jpg", 
        createdDate: "2024-01-15"
    },
    {
        id: 2, 
        name: "Emergency Relief", 
        description: "Immediate assistance for disaster-affected families providing food, shelter, and medical aid", 
        type: "emergency", 
        status: "active", 
        targetAmount: 100000, 
        raisedAmount: 78000, 
        donors: 230, 
        image: "emergency.jpg", 
        createdDate: "2024-02-10"
    },
    {
        id: 3, 
        name: "Medical Treatment Fund", 
        description: "Supporting patients who cannot afford medical care and life-saving treatments", 
        type: "general", 
        status: "active", 
        targetAmount: 75000, 
        raisedAmount: 45000, 
        donors: 189, 
        image: "medical.jpg", 
        createdDate: "2024-01-20"
    },
    {
        id: 4, 
        name: "Clean Water Project", 
        description: "Building wells and water purification systems for communities without access to clean water", 
        type: "project", 
        status: "completed", 
        targetAmount: 30000, 
        raisedAmount: 32000, 
        donors: 95, 
        image: "water.jpg", 
        createdDate: "2023-12-05"
    }
];

document.addEventListener('DOMContentLoaded', function() {
    updateStatistics();
    displayCategories(sampleCategories);
    setupFilters();
});

function updateStatistics() {
    document.getElementById('totalCount').textContent = sampleCategories.length;
    document.getElementById('activeCount').textContent = sampleCategories.filter(c => c.status === 'active').length;
    const totalRaised = sampleCategories.reduce((sum, c) => sum + c.raisedAmount, 0);
    document.getElementById('totalRaised').textContent = '৳ ' + totalRaised.toLocaleString();
    const totalDonors = sampleCategories.reduce((sum, c) => sum + c.donors, 0);
    document.getElementById('totalDonors').textContent = totalDonors;
}

function displayCategories(categories) {
    const container = document.getElementById('categoriesList');
    if (categories.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3>No Categories Found</h3>
                <p>No donation categories match your current filters</p>
            </div>
        `;
        return;
    }

    container.innerHTML = categories.map(category => {
        const progress = (category.raisedAmount / category.targetAmount) * 100;
        const statusClass = `badge-${category.status}`;
        const cardStatusClass = `status-${category.status}`;

        return `
        <div class="category-card ${cardStatusClass}">
            <div class="category-header">
                <div class="flex-grow-1">
                    <h4 class="category-title">${category.name}</h4>
                    <p class="category-description">${category.description}</p>
                </div>
                <div class="category-badges">
                    <span class="badge-modern ${statusClass}">${category.status.toUpperCase()}</span>
                    <span class="badge-modern badge-type">${category.type}</span>
                </div>
            </div>

            <div class="category-meta">
                <div class="meta-item">
                    <i class="fa-solid fa-users"></i>
                    <span>${category.donors} Donors</span>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-calendar"></i>
                    <span>${new Date(category.createdDate).toLocaleDateString()}</span>
                </div>
            </div>

            <div class="progress-section">
                <div class="progress-header">
                    <span class="progress-label">Fundraising Progress</span>
                    <span class="progress-percent">${progress.toFixed(1)}%</span>
                </div>
                <div class="progress-bar-modern">
                    <div class="progress-fill" style="width: ${progress}%"></div>
                </div>
                <div class="progress-stats">
                    <span>Raised: <strong>৳ ${category.raisedAmount.toLocaleString()}</strong></span>
                    <span>Goal: <strong>৳ ${category.targetAmount.toLocaleString()}</strong></span>
                </div>
            </div>

            <div class="category-footer">
                <div class="category-actions">
                    <button class="btn-action btn-view" onclick="window.location.href='view-donation-fund.php?id=${category.id}'">
                        <i class="fa-solid fa-eye"></i> View
                    </button>
                    <button class="btn-action btn-edit" onclick="window.location.href='edit-donation-category.php?id=${category.id}'">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <button class="btn-action btn-delete" onclick="deleteCategory(${category.id})">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        `;
    }).join('');
}

function setupFilters() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    const targetFilter = document.getElementById('targetFilter');
    const sortFilter = document.getElementById('sortFilter');

    [searchInput, statusFilter, typeFilter, targetFilter, sortFilter].forEach(el => {
        el.addEventListener('change', applyFilters);
        if (el.type === 'text') el.addEventListener('input', applyFilters);
    });
}

function applyFilters() {
    let filtered = [...sampleCategories];

    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    if (searchTerm) {
        filtered = filtered.filter(c => 
            c.name.toLowerCase().includes(searchTerm) || 
            c.description.toLowerCase().includes(searchTerm)
        );
    }

    const status = document.getElementById('statusFilter').value;
    if (status !== 'all') filtered = filtered.filter(c => c.status === status);

    const type = document.getElementById('typeFilter').value;
    if (type !== 'all') filtered = filtered.filter(c => c.type === type);

    const target = document.getElementById('targetFilter').value;
    if (target !== 'all') {
        filtered = filtered.filter(c => {
            const progress = (c.raisedAmount / c.targetAmount) * 100;
            if (target === 'reached') return progress >= 100;
            if (target === 'progress') return progress >= 25 && progress < 100;
            if (target === 'new') return progress < 25;
            return true;
        });
    }

    const sort = document.getElementById('sortFilter').value;
    filtered.sort((a, b) => {
        if (sort === 'newest') return new Date(b.createdDate) - new Date(a.createdDate);
        if (sort === 'oldest') return new Date(a.createdDate) - new Date(b.createdDate);
        if (sort === 'amount') return b.raisedAmount - a.raisedAmount;
        if (sort === 'donors') return b.donors - a.donors;
        return 0;
    });

    displayCategories(filtered);
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        console.log('Deleting category:', id);
        // Add actual deletion logic here
    }
}
</script>

<?php require './components/footer.php'; ?>