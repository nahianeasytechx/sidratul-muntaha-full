<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Zakat Collection List';
?>
<?php require './components/header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="donation-list">
        <!-- Page Header -->
        <div class="page-header">
            <div class="w-100 d-flex flex-wrap justify-content-between  gap-3">
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

        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">Total Collection</div>
                        <h3 class="mb-0">245</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon active">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">Total Amount</div>
                        <h3 class="mb-0">৳ 2,45,000</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon expired">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">This Month</div>
                        <h3 class="mb-0">৳ 45,000</h3>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon draft">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">Total Donors</div>
                        <h3 class="mb-0">180</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-title mb-3">
                <i class="fa-solid fa-filter me-2"></i>
                Filters & Search
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-box">
                        <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                        <input type="text" class="form-control" placeholder="Search by donor name, phone or transaction ID..." id="searchInput">
                    </div>
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

        <!-- Donations Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header">
                            <tr>
                                <th style="width: 80px;">Serial No.</th>
                                <th style="width: 200px;">Donor Name</th>
                                <th style="width: 160px;">Phone</th>
                                <th style="width: 140px;">Amount</th>
                                <th style="width: 180px;">Transaction ID</th>
   
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#001</strong></td>
                                <td>Md. Rahim Uddin</td>
                                <td><small>+880 1712-345678</small></td>
                                <td><strong>৳ 5,000</strong></td>
                                <td><code>TRX123456789</code></td>
                            </tr>
                            <!-- Repeat similar structure for other rows -->



                        <tbody>
                            <tr>
                                <td><strong>#001</strong></td>
                                <td>Md. Rahim Uddin</td>
                                <td><small>+880 1712-345678</small></td>
                                <td><strong>৳ 5,000</strong></td>
                                <td><code>TRX123456789</code></td>
                            </tr>
                            <tr>
                                <td><strong>#002</strong></td>
                                <td>Fatima Khatun</td>
                                <td><small>+880 1812-987654</small></td>
                                <td><strong>৳ 10,000</strong></td>
                                <td><code>TRX987654321</code></td>
                            </tr>
                            <tr>
                                <td><strong>#003</strong></td>
                                <td>Kamal Hossain</td>
                                <td><small>+880 1912-456789</small></td>
                                <td><strong>৳ 15,000</strong></td>
                                <td><code>TRX456789123</code></td>

                            </tr>
                            <tr>
                                <td><strong>#004</strong></td>
                                <td>Ayesha Siddika</td>
                                <td><small>+880 1612-789456</small></td>
                                <td><strong>৳ 3,000</strong></td>
                                <td><code>TRX789456123</code></td>
                            </tr>
                            <tr>
                                <td><strong>#005</strong></td>
                                <td>Ibrahim Khan</td>
                                <td><small>+880 1512-321654</small></td>
                                <td><strong>৳ 7,500</strong></td>
                                <td><code>TRX321654987</code></td>
                            </tr>
                            <tr>
                                <td><strong>#006</strong></td>
                                <td>Nasrin Akter</td>
                                <td><small>+880 1712-654321</small></td>
                                <td><strong>৳ 2,000</strong></td>
                                <td><code>TRX654321789</code></td>
                            </tr>
                            <tr>
                                <td><strong>#007</strong></td>
                                <td>Mizanur Rahman</td>
                                <td><small>+880 1812-147258</small></td>
                                <td><strong>৳ 12,000</strong></td>
                                <td><code>TRX147258369</code></td>
                            </tr>
                            <tr>
                                <td><strong>#008</strong></td>
                                <td>Sultana Begum</td>
                                <td><small>+880 1912-963852</small></td>
                                <td><strong>৳ 4,500</strong></td>
                                <td><code>TRX963852741</code></td>
                            </tr>
                            <tr>
                                <td><strong>#009</strong></td>
                                <td>Abdul Jabbar</td>
                                <td><small>+880 1612-852963</small></td>
                                <td><strong>৳ 20,000</strong></td>
                                <td><code>TRX852963147</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
    function viewDonation(id) {
        window.location.href = 'view-donation.php?id=' + id;
    }

    function editDonation(id) {
        window.location.href = 'edit-donation.php?id=' + id;
    }

    function deleteDonation(id) {
        if (confirm('Are you sure you want to delete this donation record?')) {
            alert('Donation #' + id + ' deleted successfully!');
        }
    }
</script>


<?php require './components/footer.php'; ?>