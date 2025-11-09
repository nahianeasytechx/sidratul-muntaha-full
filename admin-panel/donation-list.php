<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donation List';
require './components/header.php';

// Sample donation data (replace with DB data later)
$donations = [
    ["id" => 1, "category" => "education", "name" => "Md. Rahim Uddin", "phone" => "+880 1712-345678", "address" => "Mirpur, Dhaka", "amount" => 5000, "trx" => "TRX123456789", "month" => "10"],
    ["id" => 2, "category" => "health", "name" => "Fatima Khatun", "phone" => "+880 1812-987654", "address" => "Banani, Dhaka", "amount" => 10000, "trx" => "TRX987654321", "month" => "10"],
    ["id" => 3, "category" => "emergency", "name" => "Kamal Hossain", "phone" => "+880 1912-456789", "address" => "Chittagong", "amount" => 15000, "trx" => "TRX456789123", "month" => "09"],
    ["id" => 4, "category" => "food", "name" => "Ayesha Siddika", "phone" => "+880 1612-789456", "address" => "Uttara, Dhaka", "amount" => 3000, "trx" => "TRX789456123", "month" => "08"],
    ["id" => 5, "category" => "general", "name" => "Ibrahim Khan", "phone" => "+880 1512-321654", "address" => "Rajshahi", "amount" => 7500, "trx" => "TRX321654987", "month" => "09"],
    ["id" => 6, "category" => "education", "name" => "Nasrin Akter", "phone" => "+880 1712-654321", "address" => "Barisal", "amount" => 2000, "trx" => "TRX654321789", "month" => "08"],
    ["id" => 7, "category" => "health", "name" => "Mizanur Rahman", "phone" => "+880 1812-147258", "address" => "Sylhet", "amount" => 12000, "trx" => "TRX147258369", "month" => "07"],
    ["id" => 8, "category" => "food", "name" => "Sultana Begum", "phone" => "+880 1912-963852", "address" => "Khulna", "amount" => 4500, "trx" => "TRX963852741", "month" => "10"],
    ["id" => 9, "category" => "emergency", "name" => "Abdul Jabbar", "phone" => "+880 1612-852963", "address" => "Gazipur", "amount" => 20000, "trx" => "TRX852963147", "month" => "09"],
];

// Statistics
$totalDonations = count($donations);
$totalAmount = array_sum(array_column($donations, 'amount'));
$thisMonth = date('m');
$thisMonthAmount = array_sum(array_map(fn($d) => $d['month'] === $thisMonth ? $d['amount'] : 0, $donations));
$totalDonors = count(array_unique(array_column($donations, 'name')));
?>

<style>
    /* Modern Stats Card Styles */
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

    /* Page Header Styling */
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
    }

    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        background: #fff;
        color: #000;
    }

    /* Filter Card */
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

    /* Table Styling */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-header {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .table-header th {
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
    }

    .table thead th {
        background-color: #10b981 !important;
        color: #fff;
        font-size: 16px;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-education {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .badge-health {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-emergency {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .badge-food {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .badge-general {
        background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
        color: #6b21a8;
    }

    /* Transaction Code Styling */
    .trx-code {
        background: #f8f9fa;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #475569;
        font-weight: 600;
        border: 1px solid #e9ecef;
    }

    /* Amount Cell Styling */
    .amount-cell {
        font-weight: 700;
        color: #10b981;
        font-size: 1rem;
    }

    /* Action Buttons */
    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-dark {
        background: linear-gradient(135deg, #1e293b, #374151);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-sm {
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
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

        .table {
            font-size: 0.85rem;
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
    .table-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="donation-list">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1><i class="fa-solid fa-hand-holding-dollar me-2"></i>Donation List</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Donations</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="../donate.php">
                    <i class="fa-solid fa-plus me-2"></i>Add New Donation
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                    <div class="stats-icon">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Donations</h6>
                        <h2 class="stats-value"><?= $totalDonations ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                    <div class="stats-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Amount</h6>
                        <h2 class="stats-value">৳<?= number_format($totalAmount) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                    <div class="stats-icon">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">This Month</h6>
                        <h2 class="stats-value">৳<?= number_format($thisMonthAmount) ?></h2>
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
                        <h2 class="stats-value"><?= $totalDonors ?></h2>
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
                    <input type="text" class="form-control" id="searchInput" placeholder=" Search by name, phone, or transaction ID...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="education">Education</option>
                        <option value="health">Health</option>
                        <option value="emergency">Emergency Relief</option>
                        <option value="food">Food Distribution</option>
                        <option value="general">General</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="monthFilter">
                        <option value="all">All Months</option>
                        <option value="10">October 2024</option>
                        <option value="09">September 2024</option>
                        <option value="08">August 2024</option>
                        <option value="07">July 2024</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="amountFilter">
                        <option value="all">All Amounts</option>
                        <option value="0-1000">৳0 - ৳1,000</option>
                        <option value="1000-5000">৳1,000 - ৳5,000</option>
                        <option value="5000-10000">৳5,000 - ৳10,000</option>
                        <option value="10000+">৳10,000+</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="highest">Highest Amount</option>
                        <option value="lowest">Lowest Amount</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Donation Table -->
        <div class="table-container mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="donationTable">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Donor Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Invoice</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $d): ?>
                            <tr data-category="<?= $d['category'] ?>" data-month="<?= $d['month'] ?>" data-amount="<?= $d['amount'] ?>">
                                <td>
                                    <strong style="color: #2c3e50;">#<?= str_pad($d['id'], 3, '0', STR_PAD_LEFT) ?></strong>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $d['category'] ?>">
                                        <i class="fa-solid fa-tag me-1"></i>
                                        <?= ucfirst($d['category']) ?>
                                    </span>
                                </td>
                                <td>
                                    <strong style="color: #2c3e50;"><?= htmlspecialchars($d['name']) ?></strong>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-phone me-1"></i>
                                        <?= htmlspecialchars($d['phone']) ?>
                                    </small>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-location-dot me-1"></i>
                                        <?= htmlspecialchars($d['address']) ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="amount-cell">৳<?= number_format($d['amount']) ?></span>
                                </td>
                                <td>
                                    <code class="trx-code"><?= htmlspecialchars($d['trx']) ?></code>
                                </td>
                                <td>
                                    <a href="donation-list-invoice.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-dark d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Invoice" target="_blank">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="view-donation-fund.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit-donation-category.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <button onclick="deleteDonation(<?= $d['id'] ?>)" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const monthFilter = document.getElementById("monthFilter");
const amountFilter = document.getElementById("amountFilter");
const sortFilter = document.getElementById("sortFilter");
const rows = document.querySelectorAll("#donationTable tbody tr");

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    const month = monthFilter.value;
    const amount = amountFilter.value;

    rows.forEach(row => {
        const name = row.children[2].innerText.toLowerCase();
        const phone = row.children[3].innerText.toLowerCase();
        const trx = row.children[6].innerText.toLowerCase();
        const rowCategory = row.dataset.category;
        const rowMonth = row.dataset.month;
        const rowAmount = parseInt(row.dataset.amount);
        let visible = true;

        if (search && !name.includes(search) && !phone.includes(search) && !trx.includes(search)) visible = false;
        if (category !== "all" && rowCategory !== category) visible = false;
        if (month !== "all" && rowMonth !== month) visible = false;
        if (amount !== "all") {
            const [min, max] = amount.split("-");
            if (amount.includes("+") && rowAmount < parseInt(min)) visible = false;
            else if (max && (rowAmount < parseInt(min) || rowAmount > parseInt(max))) visible = false;
        }
        row.style.display = visible ? "" : "none";
    });
}

function sortTable() {
    const sortValue = sortFilter.value;
    const tbody = document.querySelector("#donationTable tbody");
    const rowsArr = Array.from(tbody.querySelectorAll("tr"));

    rowsArr.sort((a, b) => {
        const aAmount = parseInt(a.dataset.amount);
        const bAmount = parseInt(b.dataset.amount);
        const aId = parseInt(a.children[0].innerText.replace("#", "").replace(/^0+/, ""));
        const bId = parseInt(b.children[0].innerText.replace("#", "").replace(/^0+/, ""));
        if (sortValue === "highest") return bAmount - aAmount;
        if (sortValue === "lowest") return aAmount - bAmount;
        if (sortValue === "oldest") return aId - bId;
        return bId - aId;
    });

    tbody.innerHTML = "";
    rowsArr.forEach(r => tbody.appendChild(r));
}

[searchInput, categoryFilter, monthFilter, amountFilter].forEach(el => el.addEventListener("input", filterTable));
sortFilter.addEventListener("change", sortTable);

function deleteDonation(id) {
    if (confirm(`Are you sure you want to delete donation #${id}? This action cannot be undone.`)) {
        alert(`Donation #${id} deleted successfully!`);
        // Here you would make an AJAX call to delete from database
        location.reload();
    }
}
</script>

<?php require './components/footer.php'; ?>