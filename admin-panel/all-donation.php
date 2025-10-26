<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'All Donation Categories';
?>
<?php require './components/header.php'; ?>

<div class="content-wrapper">
    <div class="all-notice">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <div>
                        <h1>All Donation Categories</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Donation Categories</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <button class="btn btn-add-new" onclick="window.location.href='add-donation.php'">
                    <i class="fa-solid fa-plus me-2"></i>Add New Category
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Categories</div>
                        <h3 class="mb-0" id="totalCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active</div>
                        <h3 class="mb-0" id="activeCount">0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Raised</div>
                        <h3 class="mb-0" id="totalRaised">৳ 0</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Donors</div>
                        <h3 class="mb-0" id="totalDonors">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title">
                <i class="fa-solid fa-filter"></i>
                Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" class="form-control" placeholder="Search categories..." id="searchInput">
                    </div>
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
        <div id="categoriesList"></div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination pagination-custom">
                <li class="page-item disabled">
                    <a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
const sampleCategories = [
    {id:1, name:"Education Support Fund", description:"Help underprivileged children access quality education", type:"general", status:"active", targetAmount:50000, raisedAmount:35000, donors:145, image:"education.jpg", createdDate:"2024-01-15"},
    {id:2, name:"Emergency Relief", description:"Immediate assistance for disaster-affected families", type:"emergency", status:"active", targetAmount:100000, raisedAmount:78000, donors:230, image:"emergency.jpg", createdDate:"2024-02-10"},
    {id:3, name:"Medical Treatment Fund", description:"Supporting patients who cannot afford medical care", type:"general", status:"active", targetAmount:75000, raisedAmount:45000, donors:189, image:"medical.jpg", createdDate:"2024-01-20"}
];

document.addEventListener('DOMContentLoaded', function() {
    updateStatistics();
    displayCategories(sampleCategories);
    setupFilters();
});

function updateStatistics() {
    document.getElementById('totalCount').textContent = sampleCategories.length;
    document.getElementById('activeCount').textContent = sampleCategories.filter(c => c.status==='active').length;
    const totalRaised = sampleCategories.reduce((sum,c)=>sum+c.raisedAmount,0);
    document.getElementById('totalRaised').textContent = 'BDT '+totalRaised.toLocaleString();
    const totalDonors = sampleCategories.reduce((sum,c)=>sum+c.donors,0);
    document.getElementById('totalDonors').textContent = totalDonors;
}

function displayCategories(categories) {
    const container = document.getElementById('categoriesList');
    if(categories.length===0){
        container.innerHTML = `<div class="text-center py-5"><i class="fa-solid fa-hand-holding-heart fa-3x text-muted mb-3"></i><p class="text-muted">No donation categories found</p></div>`;
        return;
    }

    container.innerHTML = categories.map(category=>{
        const progress = (category.raisedAmount / category.targetAmount)*100;
        const statusClass = category.status==='active'?'badge-active':'badge-expired';

        return `
        <div class="notice-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="mb-1">${category.name}</h5>
                    <p class="text-muted mb-2">${category.description}</p>
                </div>
                <span class="badge ${statusClass}">${category.status.toUpperCase()}</span>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Progress</span>
                    <span class="fw-bold">${progress.toFixed(1)}%</span>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width:${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted small">Raised: <strong>${category.raisedAmount.toLocaleString()}</strong></span>
                    <span class="text-muted small">Goal: <strong>${category.targetAmount.toLocaleString()}</strong></span>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 align-items-center">
                <div class="notice-meta"><i class="fa-solid fa-users"></i> <span>${category.donors} Donors</span></div>
                <div class="notice-meta"><i class="fa-solid fa-tag"></i> <span>${category.type}</span></div>
                <div class="notice-meta"><i class="fa-solid fa-calendar"></i> <span>${new Date(category.createdDate).toLocaleDateString()}</span></div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="window.location.href='view-donation-fund.php?id=${category.id}'">
                        <i class="fa-solid fa-eye"></i> View
                    </button>
                    <button class="btn btn-sm btn-outline-success me-2" onclick="window.location.href='edit-donation-category.php?id=${category.id}'">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${category.id})">
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

    [searchInput,statusFilter,typeFilter,targetFilter,sortFilter].forEach(el=>{
        el.addEventListener('change', applyFilters);
        if(el.type==='text') el.addEventListener('input', applyFilters);
    });
}

function applyFilters() {
    let filtered = [...sampleCategories];

    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    if(searchTerm) filtered = filtered.filter(c=>c.name.toLowerCase().includes(searchTerm)||c.description.toLowerCase().includes(searchTerm));

    const status = document.getElementById('statusFilter').value;
    if(status!=='all') filtered = filtered.filter(c=>c.status===status);

    const type = document.getElementById('typeFilter').value;
    if(type!=='all') filtered = filtered.filter(c=>c.type===type);

    const target = document.getElementById('targetFilter').value;
    if(target!=='all') filtered = filtered.filter(c=>{
        const progress = (c.raisedAmount/c.targetAmount)*100;
        if(target==='reached') return progress>=100;
        if(target==='progress') return progress>=25 && progress<100;
        if(target==='new') return progress<25;
        return true;
    });

    const sort = document.getElementById('sortFilter').value;
    filtered.sort((a,b)=>{
        if(sort==='newest') return new Date(b.createdDate)-new Date(a.createdDate);
        if(sort==='oldest') return new Date(a.createdDate)-new Date(b.createdDate);
        if(sort==='amount') return b.raisedAmount - a.raisedAmount;
        if(sort==='donors') return b.donors - a.donors;
        return 0;
    });

    displayCategories(filtered);
}

function deleteCategory(id) {
    if(confirm('Are you sure you want to delete this category?')){
        console.log('Deleting category:',id);
    }
}
</script>

<?php require './components/footer.php'; ?>
