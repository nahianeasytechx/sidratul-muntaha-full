<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Scholarship Application List';
require './components/header.php';

// ✅ Scholarship Application Data (replace with DB data later)
$applications = [
    ["id" => 1, "name" => "Md. Rahim Uddin", "phone" => "+880 1712-345678", "email" => "rahim.uddin@email.com", "address" => "Mirpur, Dhaka", "institution" => "Dhaka College", "type" => "college", "status" => "pending", "applied_date" => "2024-10-15"],
    ["id" => 2, "name" => "Fatima Khatun", "phone" => "+880 1812-987654", "email" => "fatima.k@email.com", "address" => "Banani, Dhaka", "institution" => "Dhaka University", "type" => "university", "status" => "processed", "applied_date" => "2024-10-12"],
    ["id" => 3, "name" => "Kamal Hossain", "phone" => "+880 1912-456789", "email" => "kamal.h@email.com", "address" => "Chittagong", "institution" => "Jamia Islamia Madrasa", "type" => "hifz", "status" => "processed", "applied_date" => "2024-09-28"],
    ["id" => 4, "name" => "Ayesha Siddika", "phone" => "+880 1612-789456", "email" => "ayesha.s@email.com", "address" => "Uttara, Dhaka", "institution" => "Uttara High School", "type" => "school", "status" => "rejected", "applied_date" => "2024-08-20"],
    ["id" => 5, "name" => "Ibrahim Khan", "phone" => "+880 1512-321654", "email" => "ibrahim.k@email.com", "address" => "Rajshahi", "institution" => "Islamic Foundation", "type" => "program", "status" => "pending", "applied_date" => "2024-09-15"],
    ["id" => 6, "name" => "Nasrin Akter", "phone" => "+880 1712-654321", "email" => "nasrin.a@email.com", "address" => "Barisal", "institution" => "Barisal Cadet College", "type" => "college", "status" => "processed", "applied_date" => "2024-08-10"],
    ["id" => 7, "name" => "Mizanur Rahman", "phone" => "+880 1812-147258", "email" => "mizan.r@email.com", "address" => "Sylhet", "institution" => "Sylhet Engineering College", "type" => "university", "status" => "pending", "applied_date" => "2024-07-25"],
    ["id" => 8, "name" => "Sultana Begum", "phone" => "+880 1912-963852", "email" => "sultana.b@email.com", "address" => "Khulna", "institution" => "Darul Quran Madrasa", "type" => "hifz", "status" => "processed", "applied_date" => "2024-10-05"],
    ["id" => 9, "name" => "Abdul Jabbar", "phone" => "+880 1612-852963", "email" => "abdul.j@email.com", "address" => "Gazipur", "institution" => "Gazipur High School", "type" => "school", "status" => "rejected", "applied_date" => "2024-09-18"],
    ["id" => 10, "name" => "Rahima Sultana", "phone" => "+880 1712-456123", "email" => "rahima.s@email.com", "address" => "Dhanmondi, Dhaka", "institution" => "Islamic Studies Program", "type" => "program", "status" => "pending", "applied_date" => "2024-10-20"],
];

// ✅ Statistics
$totalApplications = count($applications);
$processedCount = count(array_filter($applications, fn($a) => $a['status'] === 'processed'));
$pendingCount = count(array_filter($applications, fn($a) => $a['status'] === 'pending'));
$rejectedCount = count(array_filter($applications, fn($a) => $a['status'] === 'rejected'));
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

    /* Gradient Variants - Success Green Theme */
    .stats-gradient-primary {
        --gradient-start: #10b981;
        --gradient-end: #059669;
    }

    .stats-gradient-success {
        --gradient-start: #10b981;
        --gradient-end: #059669;
    }

    .stats-gradient-warning {
        --gradient-start: #f59e0b;
        --gradient-end: #d97706;
    }

    .stats-gradient-danger {
        --gradient-start: #ef4444;
        --gradient-end: #dc2626;
    }

    /* Page Header Styling - Success Green Theme */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.4);
        transition: all 0.3s ease;
    }

    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(5, 150, 105, 0.5);
        color: white;
        background: linear-gradient(135deg, #047857, #065f46);
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
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
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

    .bg-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .action-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* User Avatar & ID Badge - Success Green */
    .user-id-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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
                        <h1><i class="fa-solid fa-graduation-cap me-2"></i>Scholarship Application List</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Scholarship Applications</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <a class="btn btn-add-new" href="add-scholarship-application.php">
                    <i class="fa-solid fa-plus me-2"></i>Add New Application
                </a>
            </div>
        </div>

        <!--  Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                    <div class="stats-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Applications</h6>
                        <h2 class="stats-value"><?= $totalApplications ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                    <div class="stats-icon">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Processed</h6>
                        <h2 class="stats-value"><?= $processedCount ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-warning">
                    <div class="stats-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Pending</h6>
                        <h2 class="stats-value"><?= $pendingCount ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                    <div class="stats-icon">
                        <i class="fa-solid fa-times-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Rejected</h6>
                        <h2 class="stats-value"><?= $rejectedCount ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Filters -->
        <div class="filter-card">
            <div class="filter-title mb-3">
              Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="searchInput" placeholder=" Search by name, phone, email...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="hifz">Hifz</option>
                        <option value="program">Program</option>
                        <option value="school">School</option>
                        <option value="college">College</option>
                        <option value="university">University</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processed">Processed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="institutionFilter" placeholder=" Filter by institution...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortFilter">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Application Table -->
        <div class="table-container mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="applicationTable">
                    <thead class="table-header">
                        <tr class="bg-success">
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Institution</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th colspan="5">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr data-type="<?= $app['type'] ?>" data-status="<?= $app['status'] ?>" data-name="<?= strtolower($app['name']) ?>" data-institution="<?= strtolower($app['institution']) ?>">
                                <td>
                                    <div>
                                        <?= $app['id'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong style="color: #2c3e50;"><?= htmlspecialchars($app['name']) ?></strong>
                                    </div>
                                </td>
                                <td><small style="color: #64748b;"><?= htmlspecialchars($app['phone']) ?></small></td>
                                <td><small style="color: #64748b;"><?= htmlspecialchars($app['email']) ?></small></td>
                                <td><small style="color: #64748b;"><?= htmlspecialchars($app['address']) ?></small></td>
                                <td><small style="color: #64748b;"><?= htmlspecialchars($app['institution']) ?></small></td>
                                <td>
                                    <span class="badge bg-<?=
                                                            $app['type'] === 'hifz' ? 'success' : ($app['type'] === 'program' ? 'info' : ($app['type'] === 'school' ? 'primary' : ($app['type'] === 'college' ? 'warning text-dark' : 'secondary')))
                                                            ?>">
                                        <i class="fa-solid fa-tag me-1"></i>
                                        <?= ucfirst($app['type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?=
                                                            $app['status'] === 'processed' ? 'success' : ($app['status'] === 'pending' ? 'warning text-dark' : 'danger')
                                                            ?>">
                                        <i class="fa-solid fa-<?=
                                                                $app['status'] === 'processed' ? 'check-circle' : ($app['status'] === 'pending' ? 'clock' : 'times-circle')
                                                                ?> me-1"></i>
                                        <?= ucfirst($app['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small style="color: #64748b;">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        <?= date('M d, Y', strtotime($app['applied_date'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                <td>
                                    <a href="view-application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-info d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit-scholarship-application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <?php  ?>
                                <td>
                                    <button onclick="deleteApplication(<?= $app['id'] ?>)" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center p-0" style="height: 32px; width: 32px; min-width: 32px;" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
            </div>
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
    const typeFilter = document.getElementById("typeFilter");
    const statusFilter = document.getElementById("statusFilter");
    const institutionFilter = document.getElementById("institutionFilter");
    const sortFilter = document.getElementById("sortFilter");
    const rows = document.querySelectorAll("#applicationTable tbody tr");

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const type = typeFilter.value;
        const status = statusFilter.value;
        const institution = institutionFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.children[1].innerText.toLowerCase();
            const phone = row.children[2].innerText.toLowerCase();
            const email = row.children[3].innerText.toLowerCase();
            const rowType = row.dataset.type;
            const rowStatus = row.dataset.status;
            const rowInstitution = row.dataset.institution;
            let visible = true;

            if (search && !name.includes(search) && !phone.includes(search) && !email.includes(search)) visible = false;
            if (type !== "all" && rowType !== type) visible = false;
            if (status !== "all" && rowStatus !== status) visible = false;
            if (institution && !rowInstitution.includes(institution)) visible = false;

            row.style.display = visible ? "" : "none";
        });
    }

    function sortTable() {
        const sortValue = sortFilter.value;
        const tbody = document.querySelector("#applicationTable tbody");
        const rowsArr = Array.from(tbody.querySelectorAll("tr"));

        rowsArr.sort((a, b) => {
            const aId = parseInt(a.children[0].innerText.trim());
            const bId = parseInt(b.children[0].innerText.trim());
            const aName = a.dataset.name;
            const bName = b.dataset.name;

            if (sortValue === "oldest") return aId - bId;
            if (sortValue === "name-asc") return aName.localeCompare(bName);
            if (sortValue === "name-desc") return bName.localeCompare(aName);
            return bId - aId; // newest
        });

        tbody.innerHTML = "";
        rowsArr.forEach(r => tbody.appendChild(r));
    }

    [searchInput, typeFilter, statusFilter, institutionFilter].forEach(el => el.addEventListener("input", filterTable));
    sortFilter.addEventListener("change", sortTable);

    function updateStatus(id, newStatus) {
        const statusText = newStatus === 'processed' ? 'approve' : 'reject';
        if (confirm(`Are you sure you want to ${statusText} application #${id}?`)) {
            alert(`Application #${id} has been ${newStatus}!`);
            // Here you would make an AJAX call to update the database
            location.reload(); // Reload to show updated status
        }
    }

    function deleteApplication(id) {
        if (confirm(`Are you sure you want to delete application #${id}? This action cannot be undone.`)) {
            alert(`Application #${id} deleted successfully!`);
            // Here you would make an AJAX call to delete from database
            location.reload();
        }
    }
</script>

<?php require './components/footer.php'; ?>