<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Donation Category';
?>
<?php require './components/header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
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
                        <h1 id="categoryTitle">Donation Category</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="all-donation-categories.php" class="text-decoration-none">All Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Category</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="window.location.href='all-donation-categories.php'">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                    </button>
                    <button class="btn btn-primary" onclick="editCategory()">
                        <i class="fa-solid fa-edit me-2"></i>Edit
                    </button>
                </div>
            </div>
        </div>

        <!-- Category Details Card -->
        <div class="notice-card mb-4">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="category-image-display">
                        <img src="" alt="Category Image" id="categoryImage" class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2" id="categoryName">Category Name</h2>
                            <span class="badge badge-active me-2" id="statusBadge">ACTIVE</span>
                            <span class="badge bg-info text-dark" id="typeBadge">General</span>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4" id="categoryDescription">
                        Category description will appear here
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="mb-0">Fundraising Progress</h5>
                            <span class="fw-bold fs-5 text-success" id="progressPercent">0%</span>
                        </div>
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progressBar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded">
                                    <div class="text-muted small mb-1">Deposit Amount</div>
                                    <h4 class="mb-0 text-success" id="raisedAmount">৳0</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded">
                                    <div class="text-muted small mb-1">Target Goal</div>
                                    <h4 class="mb-0 text-primary" id="targetAmount">৳ 0</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded">
                                    <div class="text-muted small mb-1">Remaining</div>
                                    <h4 class="mb-0 text-warning" id="remainingAmount">৳0</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-users fs-4 text-primary"></i>
                                <div>
                                    <div class="text-muted small">Total Donors</div>
                                    <div class="fw-bold" id="donorCount">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-calendar-plus fs-4 text-success"></i>
                                <div>
                                    <div class="text-muted small">Created Date</div>
                                    <div class="fw-bold" id="createdDate">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-clock fs-4 text-warning"></i>
                                <div>
                                    <div class="text-muted small">Last Updated</div>
                                    <div class="fw-bold" id="updatedDate">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-tag fs-4 text-info"></i>
                                <div>
                                    <div class="text-muted small">Category Type</div>
                                    <div class="fw-bold text-capitalize" id="categoryType">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Donations Section -->
        <div class="notice-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>
                    Recent Donations
                </h4>
                <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='donation-list.php'">
                    View All Donations
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Donor Name</th>
                            <th>Amount</th>
                            <th>Date</th>

                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="donationsTable">
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-spinner fa-spin me-2"></i>
                                Loading donations...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
// Sample data - replace with actual database fetch
const categoryData = {
    id: 1,
    name: "Education Support Fund",
    description: "Help underprivileged children access quality education. This fund supports school fees, books, uniforms, and other educational materials for children from low-income families. Together we can make education accessible to all.",
    type: "general",
    status: "active",
    targetAmount: 50000,
    raisedAmount: 35000,
    donors: 145,
    image: "./assets/images/education.jpg",
    createdDate: "2024-01-15",
    updatedDate: "2024-10-10"
};

const recentDonations = [
    {
        id: 1,
        donorName: "John Doe",
        amount: 500,
        date: "2024-10-14",
        paymentMethod: "Credit Card",
        status: "completed"
    },
    {
        id: 2,
        donorName: "Sarah Smith",
        amount: 250,
        date: "2024-10-13",
        paymentMethod: "PayPal",
        status: "completed"
    },
    {
        id: 3,
        donorName: "Anonymous",
        amount: 1000,
        date: "2024-10-12",
        paymentMethod: "Bank Transfer",
        status: "completed"
    },
    {
        id: 4,
        donorName: "Michael Johnson",
        amount: 150,
        date: "2024-10-11",
        paymentMethod: "Credit Card",
        status: "completed"
    },
    {
        id: 5,
        donorName: "Emily Davis",
        amount: 300,
        date: "2024-10-10",
        paymentMethod: "Debit Card",
        status: "pending"
    }
];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadCategoryData();
    loadRecentDonations();
});

// Load category data
function loadCategoryData() {
    // Update page title
    document.getElementById('categoryTitle').textContent = categoryData.name;
    document.getElementById('categoryName').textContent = categoryData.name;
    document.getElementById('categoryDescription').textContent = categoryData.description;
    

    
    // Update status badge
    const statusBadge = document.getElementById('statusBadge');
    statusBadge.textContent = categoryData.status.toUpperCase();
    statusBadge.className = `badge ${categoryData.status === 'active' ? 'badge-active' : 'badge-expired'}`;
    
    // Update type badge
    document.getElementById('typeBadge').textContent = categoryData.type.toUpperCase();
    
    // Calculate and update progress
    const progress = (categoryData.raisedAmount / categoryData.targetAmount) * 100;
    const remaining = categoryData.targetAmount - categoryData.raisedAmount;
    
    document.getElementById('progressPercent').textContent = progress.toFixed(1) + '%';
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressBar').setAttribute('aria-valuenow', progress);
    
    document.getElementById('raisedAmount').textContent = '৳' + categoryData.raisedAmount.toLocaleString();
    document.getElementById('targetAmount').textContent = '৳' + categoryData.targetAmount.toLocaleString();
    document.getElementById('remainingAmount').textContent = '৳' + remaining.toLocaleString();
    
    // Update meta information
    document.getElementById('donorCount').textContent = categoryData.donors;
    document.getElementById('createdDate').textContent = new Date(categoryData.createdDate).toLocaleDateString();
    document.getElementById('updatedDate').textContent = new Date(categoryData.updatedDate).toLocaleDateString();
    document.getElementById('categoryType').textContent = categoryData.type;
}

// Load recent donations
function loadRecentDonations() {
    const tableBody = document.getElementById('donationsTable');
    
    if (recentDonations.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="fa-solid fa-inbox me-2"></i>
                    No donations yet
                </td>
            </tr>
        `;
        return;
    }
    
    tableBody.innerHTML = recentDonations.map((donation, index) => {
        const statusClass = donation.status === 'completed' ? 'badge-active' : 'bg-warning';
        
        return `
            <tr>
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-circle fs-5 text-muted"></i>
                        <span>${donation.donorName}</span>
                    </div>
                </td>
                <td><strong class="text-success">৳${donation.amount.toLocaleString()}</strong></td>
                <td>${new Date(donation.date).toLocaleDateString()}</td>

                <td><span class="badge ${statusClass}">${donation.status.toUpperCase()}</span></td>
            </tr>
        `;
    }).join('');
}

// Edit function
function editCategory() {
    window.location.href = `edit-donation-category.php?id=${categoryData.id}`;
}

// Get category ID from URL (for actual implementation)
function getCategoryIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// TODO: Replace sample data with actual fetch from backend
// fetch(`get-donation-category.php?id=${getCategoryIdFromUrl()}`)
//     .then(response => response.json())
//     .then(data => {
//         categoryData = data;
//         loadCategoryData();
//     });
</script>

<style>
.category-image-display {
    width: 100%;
    height: 100%;
    min-height: 300px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.category-image-display img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .category-image-display {
        min-height: 250px;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>

<?php require './components/footer.php'; ?>