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

<div class="content-wrapper">
    <div class="donation-list">

        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex align-items-start  justify-content-between gap-3">
                <div class="d-flex gap-3">
                    <div>
                        <h1>Donation List</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Donation List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="../donate.php">
                    <i class="fa-solid fa-plus me-1"></i> Add New Donation
                </a>
            </div>
        </div>

        <!-- ✅ Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <div><div class="text-muted small mb-1">Total Donations</div><h3 class="mb-0"><?= $totalDonations ?></h3></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div><div class="text-muted small mb-1">Total Amount</div><h3 class="mb-0">৳ <?= number_format($totalAmount) ?></h3></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired"><i class="fa-solid fa-calendar-day"></i></div>
                    <div><div class="text-muted small mb-1">This Month</div><h3 class="mb-0">৳ <?= number_format($thisMonthAmount) ?></h3></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft"><i class="fa-solid fa-users"></i></div>
                    <div><div class="text-muted small mb-1">Total Donors</div><h3 class="mb-0"><?= $totalDonors ?></h3></div>
                </div>
            </div>
        </div>

        <!-- ✅ Filters -->
        <div class="filter-card mt-4">
            <div class="filter-title mb-3"><i class="fa-solid fa-filter me-2"></i>Filters & Search</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by name, phone, or transaction ID...">
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

        <!-- ✅ Donation Table -->
        <div class="card shadow-sm mt-4">
            <div class="card-body p-0">
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
                                <th>Actions</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $d): ?>
                                <tr data-category="<?= $d['category'] ?>" data-month="<?= $d['month'] ?>" data-amount="<?= $d['amount'] ?>">
                                    <td><strong>#<?= str_pad($d['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                    <td><span class="badge bg-<?=
                                        $d['category'] === 'education' ? 'primary' :
                                        ($d['category'] === 'health' ? 'success' :
                                        ($d['category'] === 'emergency' ? 'danger' :
                                        ($d['category'] === 'food' ? 'warning text-dark' : 'secondary')))
                                    ?>"><?= ucfirst($d['category']) ?></span></td>
                                    <td><?= htmlspecialchars($d['name']) ?></td>
                                    <td><small><?= htmlspecialchars($d['phone']) ?></small></td>
                                    <td><?= htmlspecialchars($d['address']) ?></td>
                                    <td><strong>৳ <?= number_format($d['amount']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($d['trx']) ?></code></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="view-donation.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info">
                                                <i class="fa-solid fa-eye me-1"></i>View
                                            </a>
                                            <a href="edit-donation.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                                            </a>
                                            <button onclick="deleteDonation(<?= $d['id'] ?>)" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="donation-list-invoice.php?id=<?= $d['id'] ?>" class="btn btn-sm bg-black text-white" target="_blank">
                                            <i class="fa-solid fa-file-invoice me-1"></i>Invoice
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