<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Donation Categories';
?>
<?php require './components/header.php'; ?>

<style>
    /* Modern Stats Card Styles - Matching donation-list.php */
    .stats-card {
        position: relative;
        padding: 24px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: visible;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
        min-height: 140px;
        display: flex;
        flex-direction: column;
    }

    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 20px 20px 0 0;
    }

    .stats-card:hover::before {
        opacity: 1;
    }

    .stats-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .stats-icon i {
        font-size: 28px;
        color: #fff;
    }

    .stats-content {
        position: relative;
        z-index: 1;
        padding-right: 76px;
    }

    .stats-label {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 12px;
    }

    .stats-value {
        font-size: 36px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1.2;
    }

    /* Gradient Variants */
    .stats-gradient-primary {
        --gradient-start: #8b5cf6;
        --gradient-end: #7c3aed;
    }

    .stats-gradient-success {
        --gradient-start: #10b981;
        --gradient-end: #059669;
    }

    .stats-gradient-danger {
        --gradient-start: #ef4444;
        --gradient-end: #dc2626;
    }

    .stats-gradient-warning {
        --gradient-start: #f59e0b;
        --gradient-end: #d97706;
    }

    /* Page Header Styling - Matching donation-list.php */
    .page-header {
        background: linear-gradient(135deg, #10b981, #059669);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .page-header h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .page-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .page-header .breadcrumb-item a:hover {
        color: white;
    }

    .page-header .breadcrumb-item.active {
        color: white;
    }

    .page-header .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .btn-add-new {
        background: #000;
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        background: #fff;
        color: #000;
    }

    /* Filter Card - Matching donation-list.php */
    .filter-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
    }

    /* Category Cards - Updated to match table styling */
    .category-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
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
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .category-description {
        color: #64748b;
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
        color: #10b981;
        font-size: 14px;
    }

    /* Badge Styles - Matching donation-list.php */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

    .badge-emergency {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .badge-general {
        background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
        color: #6b21a8;
    }

    .badge-project {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .badge-zakat {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .badge-sadaqah {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
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
        font-weight: 600;
    }

    .progress-percent {
        font-weight: 700;
        color: #10b981;
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

    .category-actions {
        display: flex;
        gap: 8px;
    }

    /* Action Buttons - Matching donation-list.php */
    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .btn-sm {
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 1199px) {
        .stats-value {
            font-size: 28px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
        }

        .stats-icon i {
            font-size: 24px;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .stats-card {
            padding: 20px;
        }

        .stats-value {
            font-size: 24px;
        }

        .stats-icon {
            width: 46px;
            height: 46px;
            top: 16px;
            right: 16px;
        }

        .stats-icon i {
            font-size: 20px;
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

    /* Loading Animation */
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

    .stats-card,
    .filter-card,
    .category-card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="donation-categories">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-hand-holding-heart me-2"></i>All Donation Categories</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Donation Categories</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="donation-categories.php">
                    <i class="fa-solid fa-plus me-2"></i>Add New Category
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                    <div class="stats-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Categories</h6>
                        <h2 class="stats-value" id="totalCount">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                    <div class="stats-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Active</h6>
                        <h2 class="stats-value" id="activeCount">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                    <div class="stats-icon">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Raised</h6>
                        <h2 class="stats-value" id="totalRaised">৳0</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-warning">
                    <div class="stats-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Donors</h6>
                        <h2 class="stats-value" id="totalDonors">0</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title mb-3">
                <i class="fa-solid fa-filter me-2"></i>Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder=" Search categories...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="emergency">Emergency</option>
                        <option value="general">General</option>
                        <option value="project">Project</option>
                        <option value="zakat">Zakat</option>
                        <option value="sadaqah">Sadaqah</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="targetFilter">
                        <option value="all">All Targets</option>
                        <option value="reached">Target Reached</option>
                        <option value="progress">In Progress</option>
                        <option value="new">Just Started</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="amount">By Amount</option>
                        <option value="donors">By Donors</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div id="categoriesList" class="mt-4"></div>

    </div>
</div>

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
    },
    {
        id: 5, 
        name: "Orphan Care Program", 
        description: "Providing shelter, education, and care for orphaned children in need", 
        type: "sadaqah", 
        status: "active", 
        targetAmount: 60000, 
        raisedAmount: 28000, 
        donors: 112, 
        image: "orphan.jpg", 
        createdDate: "2024-02-20"
    },
    {
        id: 6, 
        name: "Zakat Distribution", 
        description: "Annual Zakat collection and distribution to eligible recipients", 
        type: "zakat", 
        status: "active", 
        targetAmount: 120000, 
        raisedAmount: 95000, 
        donors: 340, 
        image: "zakat.jpg", 
        createdDate: "2024-01-01"
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
    document.getElementById('totalRaised').textContent = '৳' + totalRaised.toLocaleString();
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
                    <span class="badge ${statusClass}">${category.status.toUpperCase()}</span>
                    <span class="badge badge-${category.type}">${category.type}</span>
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
                    <div class="progress-fill" style="width: ${Math.min(progress, 100)}%"></div>
                </div>
                <div class="progress-stats">
                    <span>Raised: <strong>৳${category.raisedAmount.toLocaleString()}</strong></span>
                    <span>Goal: <strong>৳${category.targetAmount.toLocaleString()}</strong></span>
                </div>
            </div>

            <div class="category-footer">
                <div class="category-actions">
                    <a href="view-donation-fund.php?id=${category.id}" class="btn btn-sm btn-info">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                    <a href="donation-categories.php?edit=${category.id}" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(${category.id})">
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
    if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
        alert(`Category #${id} deleted successfully!`);
        // Here you would make an AJAX call to delete from database
        location.reload();
    }
}
</script>

<?php require './components/footer.php'; ?>