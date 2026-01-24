<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Donation Invoice';

// DON'T include header.php - create minimal setup instead
session_start();
require_once '../components/functions.php';

// Check if user is logged in (optional for invoice)
// Uncomment if you want to protect the invoice page
// protectPage();

// Get donation ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid donation ID');
}

$donation_id = $_GET['id'];
$donation = getDonationById($donation_id);

if (!$donation) {
    die('Donation not found');
}

// Organization info
$organization_name = "Sidratul Muntaha Foundation";
$organization_registration = "S-14117/2024";
$organization_address = "Dhaka, Bangladesh";
$organization_phone = "+880 1234-567890";
$organization_email = "info@sidratulmuntaha.org";
$organization_website = "www.sidratulmuntaha.org";

// Format dates
$invoice_date = date('F d, Y', strtotime($donation['created_at']));
$payment_date = date('F d, Y', strtotime($donation['created_at']));

// Generate invoice number
$invoice_number = 'INV-' . date('Ymd') . '-' . str_pad($donation['id'], 4, '0', STR_PAD_LEFT);

// Status badge
$status_badge_class = '';
$status_text = '';
switch($donation['payment_status']) {
    case 'completed':
        $status_badge_class = 'badge-success';
        $status_text = 'Paid';
        break;
    case 'pending':
        $status_badge_class = 'badge-warning';
        $status_text = 'Pending';
        break;
    case 'failed':
        $status_badge_class = 'badge-danger';
        $status_text = 'Failed';
        break;
    case 'cancelled':
        $status_badge_class = 'badge-secondary';
        $status_text = 'Cancelled';
        break;
    default:
        $status_badge_class = 'badge-info';
        $status_text = ucfirst($donation['payment_status']);
}

// Donor info
$donor_name = htmlspecialchars($donation['name']);
$donor_email = !empty($donation['email']) ? htmlspecialchars($donation['email']) : 'Not provided';
$donor_phone = !empty($donation['contact']) ? htmlspecialchars($donation['contact']) : 'Not provided';
$donor_address = !empty($donation['address']) ? htmlspecialchars($donation['address']) : 'Not provided';
$category_name = !empty($donation['category_name']) ? htmlspecialchars($donation['category_name']) : 'General Donation';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Invoice - <?= $invoice_number ?></title>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #008E48;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-logo img {
            max-width: 150px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            color: #0F2920;
            font-size: 36px;
            margin: 0;
            font-weight: 700;
        }

        .invoice-title p {
            color: #666;
            margin: 5px 0 0 0;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .detail-section h3 {
            color: #0F2920;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .detail-section p {
            margin: 8px 0;
            color: #444;
            line-height: 1.6;
        }

        .detail-section strong {
            color: #0F2920;
            display: inline-block;
            min-width: 120px;
        }

        .invoice-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .invoice-table thead {
            background: #008E48;
            color: #fff;
        }

        .invoice-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .invoice-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .invoice-table tbody tr:hover {
            background: #f9f9f9;
        }

        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .summary-box {
            width: 350px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-row.total {
            border-top: 2px solid #008E48;
            border-bottom: 2px solid #008E48;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 20px;
            font-weight: 700;
            color: #0F2920;
        }

        .invoice-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 2px solid #e0e0e0;
            color: #666;
        }

        .invoice-footer p {
            margin: 5px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-secondary {
            background: #e2e3e5;
            color: #383d41;
        }

        .action-buttons {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #008E48;
            color: #fff;
        }

        .btn-primary:hover {
            background: #006d38;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 142, 72, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .invoice-type-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #008E48;
            color: #fff;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 10px;
        }

        .payment-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payment-info p {
            margin: 5px 0;
            color: #444;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0, 142, 72, 0.1);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .qr-code img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .terms-conditions {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 12px;
            color: #666;
        }

        .terms-conditions h5 {
            color: #0F2920;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                margin: 0;
                padding: 0;
                background: white !important;
            }

            .action-buttons {
                display: none !important;
            }

            .invoice-container {
                max-width: 100%;
                margin: 0;
                padding: 20px;
                box-shadow: none;
                border-radius: 0;
            }

            .watermark {
                display: block !important;
            }
        }

        @media(max-width: 768px) {
            body {
                padding: 10px;
            }

            .invoice-container {
                padding: 20px;
            }

            .invoice-header {
                flex-direction: column;
                text-align: center;
            }

            .invoice-title {
                text-align: center;
                margin-top: 20px;
            }

            .invoice-details {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .summary-box {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">PAID</div>
    
    <!-- Action Buttons (hidden when printing) -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fa fa-print"></i> Print Receipt
        </button>
        <a href="donation-list.php" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
        <a href="view-donation-fund.php?id=<?= $donation['id'] ?>" class="btn btn-secondary">
            <i class="fa fa-eye"></i> View Details
        </a>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-logo">
                <img src="../images/sidratulnewLogo1__1_-removebg-preview.png" alt="Sidratul Muntaha Foundation">
            </div>
            <div class="invoice-title">
                <h1>DONATION RECEIPT</h1>
                <p>Invoice #: <?= $invoice_number ?></p>
                <p>Date: <?= $invoice_date ?></p>
                <span class="invoice-type-badge">TAX DEDUCTIBLE</span>
            </div>
        </div>

        <div class="invoice-details">
            <div class="detail-section">
                <h3>Organization:</h3>
                <p><strong>Name:</strong> <?= $organization_name ?></p>
                <p><strong>Registration:</strong> <?= $organization_registration ?></p>
                <p><strong>Address:</strong> <?= $organization_address ?></p>
                <p><strong>Email:</strong> <?= $organization_email ?></p>
                <p><strong>Phone:</strong> <?= $organization_phone ?></p>
                <p><strong>Website:</strong> <?= $organization_website ?></p>
            </div>
            <div class="detail-section">
                <h3>Donor Information:</h3>
                <p><strong>Name:</strong> <?= $donor_name ?></p>
                <?php if (!empty($donation['behalf_of'])): ?>
                <p><strong>On behalf of:</strong> <?= htmlspecialchars($donation['behalf_of']) ?></p>
                <?php endif; ?>
                <p><strong>Email:</strong> <?= $donor_email ?></p>
                <p><strong>Phone:</strong> <?= $donor_phone ?></p>
                <p><strong>Address:</strong> <?= $donor_address ?></p>
                <p><strong>Status:</strong> <span class="badge <?= $status_badge_class ?>"><?= $status_text ?></span></p>
            </div>
        </div>

        <div class="payment-info">
            <p><strong>Payment Method:</strong> <?= ucfirst($donation['payment_method']) ?></p>
            <p><strong>Transaction ID:</strong> <?= htmlspecialchars($donation['transaction_id']) ?></p>
            <p><strong>Payment Date:</strong> <?= $payment_date ?></p>
            <?php if (!empty($donation['notes'])): ?>
            <p><strong>Notes:</strong> <?= htmlspecialchars($donation['notes']) ?></p>
            <?php endif; ?>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Amount (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <strong>Donation to <?= $category_name ?></strong><br>
                        <small>Donation ID: <?= $donation['id'] ?></small>
                    </td>
                    <td><?= $category_name ?></td>
                    <td>৳<?= number_format($donation['amount'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="invoice-summary">
            <div class="summary-box">
                <div class="summary-row">
                    <span>Donation Amount:</span>
                    <span>৳<?= number_format($donation['amount'], 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Processing Fee:</span>
                    <span>৳0.00</span>
                </div>
                <div class="summary-row">
                    <span>Tax Deductible:</span>
                    <span>৳<?= number_format($donation['amount'], 2) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total Amount:</span>
                    <span>৳<?= number_format($donation['amount'], 2) ?></span>
                </div>
            </div>
        </div>

        <!-- Optional QR Code for verification -->
        <div class="qr-code">
            <div id="qrcode"></div>
            <p><small>Scan to verify this receipt online</small></p>
        </div>

        <!-- Terms and Conditions -->
        <div class="terms-conditions">
            <h5>Terms & Conditions:</h5>
            <p>1. This receipt is issued for the donation received by Sidratul Muntaha Foundation.</p>
            <p>2. The amount donated is tax-deductible as per applicable laws.</p>
            <p>3. This is an official receipt for your records.</p>
            <p>4. For any queries, please contact: <?= $organization_email ?></p>
        </div>

        <div class="invoice-footer">
            <p><strong>Thank you for your generous donation!</strong></p>
            <p>May Allah accept your donation and bless you abundantly.</p>
            <p><em>"The example of those who spend their wealth in the way of Allah is like a seed which grows seven spikes; in each spike is a hundred grains. And Allah multiplies His reward for whom He wills."</em></p>
            <p><small>(Surah Al-Baqarah 2:261)</small></p>
        </div>
    </div>

    <!-- Include QR Code Generator -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script>
    // Generate QR Code
    document.addEventListener('DOMContentLoaded', function() {
        const qr = qrcode(4, 'L');
        const verificationUrl = window.location.origin + '/verify-donation.php?id=<?= $donation['id'] ?>&code=<?= md5($donation['transaction_id']) ?>';
        qr.addData(verificationUrl);
        qr.make();
        
        const qrCodeElement = document.getElementById('qrcode');
        qrCodeElement.innerHTML = qr.createImgTag(4);
        
        // Auto-print if print parameter is present
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            setTimeout(() => {
                window.print();
            }, 1000);
        }
    });
    
    // Add watermark based on status
    document.addEventListener('DOMContentLoaded', function() {
        const watermark = document.querySelector('.watermark');
        const status = '<?= $donation['payment_status'] ?>';
        
        if (status === 'completed') {
            watermark.textContent = 'PAID';
            watermark.style.color = 'rgba(0, 142, 72, 0.1)';
        } else if (status === 'pending') {
            watermark.textContent = 'PENDING';
            watermark.style.color = 'rgba(255, 193, 7, 0.1)';
        } else if (status === 'failed') {
            watermark.textContent = 'UNPAID';
            watermark.style.color = 'rgba(220, 53, 69, 0.1)';
        } else {
            watermark.textContent = 'RECEIPT';
            watermark.style.color = 'rgba(108, 117, 125, 0.1)';
        }
    });
    </script>
</body>
</html>