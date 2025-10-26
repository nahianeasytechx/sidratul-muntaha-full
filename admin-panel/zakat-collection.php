<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Zakat Collection List';
require './components/header.php';

// ✅ Sample Data Array (replace with DB data later)
$donations = [
    ["id" => 1, "name" => "Md. Rahim Uddin", "phone" => "+880 1712-345678", "address" => "Mirpur, Dhaka", "amount" => 5000, "trx" => "TRX123456789", "category" => "education", "month" => "10"],
    ["id" => 2, "name" => "Fatima Khatun", "phone" => "+880 1812-987654", "address" => "Banani, Dhaka", "amount" => 10000, "trx" => "TRX987654321", "category" => "health", "month" => "10"],
    ["id" => 3, "name" => "Kamal Hossain", "phone" => "+880 1912-456789", "address" => "Chittagong City", "amount" => 15000, "trx" => "TRX456789123", "category" => "emergency", "month" => "09"],
    ["id" => 4, "name" => "Ayesha Siddika", "phone" => "+880 1612-789456", "address" => "Uttara, Dhaka", "amount" => 3000, "trx" => "TRX789456123", "category" => "food", "month" => "08"],
    ["id" => 5, "name" => "Ibrahim Khan", "phone" => "+880 1512-321654", "address" => "Rajshahi", "amount" => 7500, "trx" => "TRX321654987", "category" => "general", "month" => "09"],
    ["id" => 6, "name" => "Nasrin Akter", "phone" => "+880 1712-654321", "address" => "Barisal", "amount" => 2000, "trx" => "TRX654321789", "category" => "health", "month" => "08"],
    ["id" => 7, "name" => "Mizanur Rahman", "phone" => "+880 1812-147258", "address" => "Sylhet", "amount" => 12000, "trx" => "TRX147258369", "category" => "education", "month" => "07"],
    ["id" => 8, "name" => "Sultana Begum", "phone" => "+880 1912-963852", "address" => "Khulna", "amount" => 4500, "trx" => "TRX963852741", "category" => "food", "month" => "10"],
    ["id" => 9, "name" => "Abdul Jabbar", "phone" => "+880 1612-852963", "address" => "Gazipur", "amount" => 20000, "trx" => "TRX852963147", "category" => "emergency", "month" => "09"],
];

// ✅ Calculate stats
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
            <div class="w-100 d-flex flex-wrap justify-content-between gap-3">
                <div class="d-flex justify-content-between gap-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h1>Zakat Collection List</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Zakat Collection List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <div>
                        <div class="text-muted small mb-1">Total Collection</div>
                        <h3 class="mb-0"><?= $totalDonations ?></h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div>
                        <div class="text-muted small mb-1">Total Amount</div>
                        <h3 class="mb-0">৳ <?= number_format($totalAmount) ?></h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired"><i class="fa-solid fa-calendar-day"></i></div>
                    <div>
                        <div class="text-muted small mb-1">This Month</div>
                        <h3 class="mb-0">৳ <?= number_format($thisMonthAmount) ?></h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft"><i class="fa-solid fa-users"></i></div>
                    <div>
                        <div class="text-muted small mb-1">Total Donors</div>
                        <h3 class="mb-0"><?= $totalDonors ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Filters -->
        <div class="filter-card mt-4">
            <div class="filter-title mb-3">
                <i class="fa-solid fa-filter me-2"></i> Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by donor name, phone or transaction ID...">
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
                                <th>Serial No.</th>
                                <th>Donor Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $d): ?>
                                <tr data-category="<?= $d['category'] ?>" data-month="<?= $d['month'] ?>" data-amount="<?= $d['amount'] ?>">
                                    <td><strong>#<?= str_pad($d['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                    <td><?= htmlspecialchars($d['name']) ?></td>
                                    <td><small><?= htmlspecialchars($d['phone']) ?></small></td>
                                    <td><?= htmlspecialchars($d['address']) ?></td>
                                    <td><strong>৳ <?= number_format($d['amount']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($d['trx']) ?></code></td>
                                    <td>
                                        <a href="zakat-list-invoice.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-success" target="_blank" style="font-size: 0.875rem; padding: 0.25rem 0.5rem;">
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

<!-- ✅ JS Filtering & Sorting -->
<script>
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const monthFilter = document.getElementById("monthFilter");
const amountFilter = document.getElementById("amountFilter");
const sortFilter = document.getElementById("sortFilter");
const tableRows = document.querySelectorAll("#donationTable tbody tr");

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    const month = monthFilter.value;
    const amount = amountFilter.value;

    tableRows.forEach(row => {
        const name = row.children[1].innerText.toLowerCase();
        const phone = row.children[2].innerText.toLowerCase();
        const trx = row.children[5].innerText.toLowerCase();
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
    const rows = Array.from(tbody.querySelectorAll("tr"));

    rows.sort((a, b) => {
        const aAmount = parseInt(a.dataset.amount);
        const bAmount = parseInt(b.dataset.amount);
        const aId = parseInt(a.children[0].innerText.replace("#", ""));
        const bId = parseInt(b.children[0].innerText.replace("#", ""));

        if (sortValue === "highest") return bAmount - aAmount;
        if (sortValue === "lowest") return aAmount - bAmount;
        if (sortValue === "oldest") return aId - bId;
        return bId - aId; // newest default
    });

    tbody.innerHTML = "";
    rows.forEach(r => tbody.appendChild(r));
}

[searchInput, categoryFilter, monthFilter, amountFilter].forEach(el => el.addEventListener("input", filterTable));
sortFilter.addEventListener("change", sortTable);
</script>

<?php require './components/footer.php'; ?>