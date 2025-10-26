<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Zakat Invoice';
?>
<?php require './components/header.php'; ?>

<style>
    .invoice-container {
        max-width: 900px;
        margin: 5px auto;
        background: #fff;
        padding: 40px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #0F2920;
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
        background: #0F2920;
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
        border-top: 2px solid #0F2920;
        border-bottom: 2px solid #0F2920;
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

    .print-btn {
        background: #0F2920;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        margin: 20px 0;
        transition: all 0.3s;
    }

    .print-btn:hover {
        background: #1a4538;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(15, 41, 32, 0.3);
    }

    .invoice-type-badge {
        display: inline-block;
        padding: 8px 20px;
        background: #0F2920;
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

    .islamic-quote {
        background: #e8f5e9;
        padding: 15px;
        border-left: 4px solid #0F2920;
        margin: 20px 0;
        font-style: italic;
        color: #0F2920;
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
        }

        .print-btn {
            display: none !important;
        }

        .payment-info {
            display: none !important;
        }

        .invoice-container {
            max-width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none;
            border-radius: 0;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .invoice-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .invoice-title h1 {
            font-size: 28px;
        }

        .invoice-logo img {
            max-width: 120px;
        }

        .invoice-details {
            margin-bottom: 25px;
            gap: 20px;
        }

        .detail-section h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .detail-section p {
            margin: 5px 0;
            font-size: 13px;
        }

        .invoice-table {
            margin-bottom: 20px;
            font-size: 13px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px 10px;
        }

        .invoice-summary {
            margin-bottom: 20px;
        }

        .summary-box {
            padding: 15px;
            font-size: 14px;
        }

        .summary-row {
            padding: 6px 0;
        }

        .summary-row.total {
            font-size: 16px;
            padding-top: 10px;
        }

        .invoice-footer {
            padding-top: 20px;
            font-size: 12px;
        }

        .invoice-footer p {
            margin: 3px 0;
        }

        .islamic-quote {
            padding: 10px;
            margin: 15px 0;
            font-size: 12px;
        }

        header, footer, nav {
            display: none !important;
        }

        .invoice-header,
        .invoice-details,
        .invoice-table,
        .invoice-summary,
        .invoice-footer {
            page-break-inside: avoid;
        }
    }

    @media(max-width: 768px) {
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

        .invoice-table {
            font-size: 14px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px;
        }

        .summary-box {
            width: 100%;
        }
    }
</style>

<div class="content-wrapper">
    <div class="invoice-container">
    <div class="invoice-header">
        <div class="invoice-logo">
            <img src="images/sidratul logo.png" alt="Sidratul Muntaha Foundation">
        </div>
        <div class="invoice-title">
            <h1>INVOICE</h1>
            <p>Invoice #: ZK-2024-001</p>
            <p>Date: October 26, 2025</p>
            <span class="invoice-type-badge">ZAKAT LIST</span>
        </div>
    </div>

    <div class="invoice-details">
        <div class="detail-section">
            <h3>From:</h3>
            <p><strong>Organization:</strong> Sidratul Muntaha Foundation</p>
            <p><strong>Registration:</strong> S-14117/2024</p>
            <p><strong>Address:</strong> Dhaka, Bangladesh</p>
            <p><strong>Email:</strong> info@sidratulmuntaha.org</p>
            <p><strong>Phone:</strong> +880 1XXX-XXXXXX</p>
        </div>
        <div class="detail-section">
            <h3>To:</h3>
            <p><strong>Donor Name:</strong> Fatima Rahman</p>
            <p><strong>Phone:</strong> +880 1812-345678</p>
            <p><strong>Address:</strong> Dhaka, Bangladesh</p>
            <p><strong>Status:</strong> <span class="badge badge-success">Paid</span></p>
        </div>
    </div>

    <div class="payment-info">
        <p><strong>Payment Method:</strong> Nagad</p>
        <p><strong>Transaction ID:</strong> NGD987654321</p>
        <p><strong>Payment Date:</strong> October 26, 2025</p>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Zakat Category</th>
                <th>Description</th>
                <th>Amount (BDT)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Zakat on Cash</td>
                <td>2.5% of savings above nisab</td>
                <td>15,000</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Zakat on Gold</td>
                <td>2.5% of gold value</td>
                <td>8,500</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Zakat on Business</td>
                <td>2.5% of business assets</td>
                <td>7,000</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="summary-box">
            <div class="summary-row">
                <span>Total Zakat:</span>
                <span>30,500 BDT</span>
            </div>
            <div class="summary-row">
                <span>Processing Fee:</span>
                <span>0 BDT</span>
            </div>
            <div class="summary-row total">
                <span>Total Amount:</span>
                <span>30,500 BDT</span>
            </div>
        </div>
    </div>

    <div class="islamic-quote">
        "Take from their wealth a charity to cleanse them and purify them" - (Quran 9:103)
    </div>

    <div class="invoice-footer">
        <p>Jazakallah Khair for fulfilling your Zakat obligation!</p>
        <p>May Allah purify your wealth and multiply your blessings.</p>
    </div>

    <div style="text-align: center;">
        <button class="print-btn" onclick="window.print()">
            <i class="fa fa-print"></i> Print Invoice
        </button>
    </div>
</div>
</div>

<?php require './components/footer.php'; ?>