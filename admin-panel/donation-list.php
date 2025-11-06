<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donation List';
require './components/header.php';

// ✅ Donation data (replace with DB data later)
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

// ✅ Stats
$totalDonations = count($donations);
$totalAmount = array_sum(array_column($donations, 'amount'));
$thisMonth = date('m');
$thisMonthAmount = array_sum(array_map(fn($d) => $d['month'] === $thisMonth ? $d['amount'] : 0, $donations));
$totalDonors = count(array_unique(array_column($donations, 'name')));
?>

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
    .stat-card-modern.amount { --gradient-start: #10b981; --gradient-end: #059669; }
    .stat-card-modern.monthly { --gradient-start: #ef4444; --gradient-end: #dc2626; }
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
        border: none;
        margin: 8px 0 0 0;
        font-size: 14px;
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

    /* Table Styling - Updated to match modern design */
    .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 2px solid #e2e8f0;
    }

    .table-header th {
        padding: 20px 16px;
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }

    .table tbody td {
        padding: 20px 16px;
        vertical-align: middle;
        border: none;
        color: #475569;
        font-size: 14px;
    }

    /* Badge Styling */
    .badge-modern {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

       /* ... previous styles remain the same ... */

    /* Action Buttons - Fixed to stay horizontal */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap; /* Prevent wrapping to new lines */
        align-items: center;
    }

    .btn-action {
        padding: 8px 12px;
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
        white-space: nowrap; /* Prevent text wrapping */
        flex-shrink: 0; /* Prevent buttons from shrinking */
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

    .btn-invoice {
        background: linear-gradient(135deg, #1e293b, #374151);
        color: #fff;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .btn-view:hover { color: #1e40af; }
    .btn-edit:hover { color: #92400e; }
    .btn-delete:hover { color: #991b1b; }
    .btn-invoice:hover { color: #fff; }

    /* ... previous styles remain the same ... */

    /* Responsive - Fixed for action buttons */
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

        /* Fixed: Keep action buttons horizontal on mobile */
        .action-buttons {
            flex-direction: row; /* Keep horizontal on mobile */
            flex-wrap: wrap; /* Allow wrapping if really needed */
            justify-content: flex-start;
        }

        .btn-action {
            padding: 6px 10px; /* Slightly smaller on mobile */
            font-size: 11px; /* Slightly smaller text */
        }

        .table-responsive {
            border-radius: 16px;
        }
        
        /* Adjust table for mobile */
        .table-header th:nth-child(4),
        .table-header th:nth-child(5),
        .table tbody td:nth-child(4),
        .table tbody td:nth-child(5) {
            display: none; /* Hide less important columns on mobile */
        }
    }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="donation-list">

        <!-- Page Title -->
        <div class="page-title-section">
            <div class="page-title-content">
                <div class="icon-box">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <h1>Donation List</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Donation List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn-add-new" href="../donate.php">
                <i class="fa-solid fa-plus"></i> Add New Donation
            </a>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card-modern total">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Donations</div>
                        <h3><?= $totalDonations ?></h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern amount">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Amount</div>
                        <h3>৳ <?= number_format($totalAmount) ?></h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern monthly">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">This Month</div>
                        <h3>৳ <?= number_format($thisMonthAmount) ?></h3>
                    </div>
                    <div class="stat-icon-modern">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card-modern donors">
                <div class="stat-content-flex">
                    <div class="stat-info">
                        <div class="stat-label">Total Donors</div>
                        <h3><?= $totalDonors ?></h3>
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
                        <input type="text" placeholder="Search by name, phone, or transaction ID..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="education">Education</option>
                        <option value="health">Health</option>
                        <option value="emergency">Emergency Relief</option>
                        <option value="food">Food Distribution</option>
                        <option value="general">General</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="monthFilter">
                        <option value="all">All Months</option>
                        <option value="10">October 2024</option>
                        <option value="09">September 2024</option>
                        <option value="08">August 2024</option>
                        <option value="07">July 2024</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="amountFilter">
                        <option value="all">All Amounts</option>
                        <option value="0-1000">৳0 - ৳1,000</option>
                        <option value="1000-5000">৳1,000 - ৳5,000</option>
                        <option value="5000-10000">৳5,000 - ৳10,000</option>
                        <option value="10000+">৳10,000+</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="filter-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="highest">Highest Amount</option>
                        <option value="lowest">Lowest Amount</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Donation Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="donationTable">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Donor Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th >Actions</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $d): ?>
                            <tr data-category="<?= $d['category'] ?>" data-month="<?= $d['month'] ?>" data-amount="<?= $d['amount'] ?>">
                                <td><strong>#<?= str_pad($d['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                <td>
                                    <span class="badge-modern badge-<?= $d['category'] ?>">
                                        <?= ucfirst($d['category']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($d['name']) ?></td>
                                <td><small><?= htmlspecialchars($d['phone']) ?></small></td>
                                <td><?= htmlspecialchars($d['address']) ?></td>
                                <td class="amount-cell">৳ <?= number_format($d['amount']) ?></td>
                                <td><code class="trx-code"><?= htmlspecialchars($d['trx']) ?></code></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="view-donation-fund.php?id=<?= $d['id'] ?>" class="btn-action btn-view">
                                            <i class="fa-solid fa-eye"></i>View
                                        </a>
                                        <a href="edit-donation-category.php" class="btn-action btn-edit">
                                            <i class="fa-solid fa-pen-to-square"></i>Edit
                                        </a>
                                        <button onclick="deleteDonation(<?= $d['id'] ?>)" class="btn-action btn-delete">
                                            <i class="fa-solid fa-trash"></i>Delete
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a href="donation-list-invoice.php?id=<?= $d['id'] ?>" class="btn-action btn-invoice" target="_blank">
                                        <i class="fa-solid fa-file-invoice"></i>Invoice
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
        const aId = parseInt(a.children[0].innerText.replace("#", ""));
        const bId = parseInt(b.children[0].innerText.replace("#", ""));
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
    if (confirm(`Are you sure you want to delete donation #${id}?`)) {
        alert(`Donation #${id} deleted successfully!`);
    }
}
</script>

<?php require './components/footer.php'; ?>