<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Zakat Calculator'; // Set the page title

// Zakat Calculation Logic
$zakat_result = null;
$total_assets = 0;
$total_liabilities = 0;
$zakatable_amount = 0;
$zakat_due = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_zakat'])) {
    // Get all asset values
    $nisab = floatval($_POST['nisab'] ?? 0);
    $gold_value = floatval($_POST['gold_value'] ?? 0);
    $silver_value = floatval($_POST['silver_value'] ?? 0);
    $cash = floatval($_POST['cash'] ?? 0);
    $deposited = floatval($_POST['deposited'] ?? 0);
    $loans_given = floatval($_POST['loans_given'] ?? 0);
    $business_investments = floatval($_POST['business_investments'] ?? 0);
    $stock_value = floatval($_POST['stock_value'] ?? 0);

    // Get all liability values
    $borrowed_money = floatval($_POST['borrowed_money'] ?? 0);
    $wages_due = floatval($_POST['wages_due'] ?? 0);
    $taxes_rent = floatval($_POST['taxes_rent'] ?? 0);

    // Calculate totals
    $total_assets = $gold_value + $silver_value + $cash + $deposited + $loans_given + $business_investments + $stock_value;
    $total_liabilities = $borrowed_money + $wages_due + $taxes_rent;

    // Calculate zakatable amount (assets - liabilities)
    $zakatable_amount = $total_assets - $total_liabilities;

    // Check if zakatable amount exceeds nisab
    if ($zakatable_amount >= $nisab && $nisab > 0) {
        // Zakat is 2.5% of zakatable amount
        $zakat_due = $zakatable_amount * 0.025;
        $zakat_result = 'payable';
    } else {
        $zakat_result = 'not_payable';
    }
}
?>
<?php require './components/header.php'; ?>



<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->
<div class="home">
    <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/courses.jpg" data-speed="0.8"></div>
    <div class="home_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content text-center">
                        <div data-aos="fade-up" class="home_title">Zakat Calculator</div>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li>Zakat Calculator</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="zakat-calculator">
    <div class="container">
        <div class="calculator-container">
            <div class="text-center">
                <h2 class="section_title"><b>Calculate Your Zakat</b></h2>
                <div class="currency-badge">Currency: BDT (৳)</div>
            </div>

            <form method="POST" action="" id="zakatForm">
                <!-- Calculation Basis -->
                <div class="form-group">
                    <label for="calculation_basis">Select Calculation Basis</label>
                    <select name="calculation_basis" id="calculation_basis" class="form-select">
                        <option value="gold" <?php echo (!isset($_POST['calculation_basis']) || $_POST['calculation_basis'] == 'gold') ? 'selected' : ''; ?>>Gold</option>
                        <option value="silver" <?php echo (isset($_POST['calculation_basis']) && $_POST['calculation_basis'] == 'silver') ? 'selected' : ''; ?>>Silver</option>
                    </select>
                </div>

                <!-- Nisab Value -->
                <div class="form-group">
                    <label for="nisab">Nisab (update according to present time):</label>
                    <input type="number" name="nisab" id="nisab" class="form-control" step="0.01" value="<?php echo isset($_POST['nisab']) ? htmlspecialchars($_POST['nisab']) : '69566.34'; ?>" required>
                    <div class="info-text">Current Nisab value in BDT (Update this based on current gold/silver prices)</div>
                </div>

                <!-- Assets Section -->
                <h3 class="section-title">Assets</h3>

                <div class="form-group">
                    <label for="gold_value">Value of gold</label>
                    <input type="number" name="gold_value" id="gold_value" class="form-control" step="0.01" value="<?php echo isset($_POST['gold_value']) ? htmlspecialchars($_POST['gold_value']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="silver_value">Value of silver</label>
                    <input type="number" name="silver_value" id="silver_value" class="form-control" step="0.01" value="<?php echo isset($_POST['silver_value']) ? htmlspecialchars($_POST['silver_value']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="cash">Cash</label>
                    <input type="number" name="cash" id="cash" class="form-control" step="0.01" value="<?php echo isset($_POST['cash']) ? htmlspecialchars($_POST['cash']) : '0'; ?>">
                    <div class="info-text">In hand and in bank accounts</div>
                </div>

                <div class="form-group">
                    <label for="deposited">Deposited for some future purpose. e.g. Hajj</label>
                    <input type="number" name="deposited" id="deposited" class="form-control" step="0.01" value="<?php echo isset($_POST['deposited']) ? htmlspecialchars($_POST['deposited']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="loans_given">Given out in loans</label>
                    <input type="number" name="loans_given" id="loans_given" class="form-control" step="0.01" value="<?php echo isset($_POST['loans_given']) ? htmlspecialchars($_POST['loans_given']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="business_investments">Business investments, shares, saving certificates, pensions funded by money in one's possession</label>
                    <input type="number" name="business_investments" id="business_investments" class="form-control" step="0.01" value="<?php echo isset($_POST['business_investments']) ? htmlspecialchars($_POST['business_investments']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="stock_value">Value of stock (Trade goods)</label>
                    <input type="number" name="stock_value" id="stock_value" class="form-control" step="0.01" value="<?php echo isset($_POST['stock_value']) ? htmlspecialchars($_POST['stock_value']) : '0'; ?>">
                </div>

                <!-- Liabilities Section -->
                <h3 class="section-title">Liabilities</h3>

                <div class="form-group">
                    <label for="borrowed_money">Borrowed money, goods bought on credit</label>
                    <input type="number" name="borrowed_money" id="borrowed_money" class="form-control" step="0.01" value="<?php echo isset($_POST['borrowed_money']) ? htmlspecialchars($_POST['borrowed_money']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="wages_due">Wages due to employees</label>
                    <input type="number" name="wages_due" id="wages_due" class="form-control" step="0.01" value="<?php echo isset($_POST['wages_due']) ? htmlspecialchars($_POST['wages_due']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <label for="taxes_rent">Taxes, rent, utility bills due immediately</label>
                    <input type="number" name="taxes_rent" id="taxes_rent" class="form-control" step="0.01" value="<?php echo isset($_POST['taxes_rent']) ? htmlspecialchars($_POST['taxes_rent']) : '0'; ?>">
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="submit" name="calculate_zakat" id="calculateBtn" class="btn-calculate">Calculate</button>
                    <button type="reset" class="btn-reset" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'; return false;">Reset</button>
                </div>
            </form>

            <!-- Results -->
            <?php if ($zakat_result !== null): ?>
                <div id="resultSection" class="result-box <?php echo $zakat_result === 'not_payable' ? 'not-payable' : ''; ?>">
                    <div class="result-title">
                        <?php if ($zakat_result === 'payable'): ?>
                            ✓ Zakat is Payable
                        <?php else: ?>
                            Zakat is Not Payable
                        <?php endif; ?>
                    </div>

                    <div class="result-item">
                        <span class="result-label">Total Assets:</span>
                        <span class="result-value">৳ <?php echo number_format($total_assets, 2); ?></span>
                    </div>

                    <div class="result-item">
                        <span class="result-label">Total Liabilities:</span>
                        <span class="result-value">৳ <?php echo number_format($total_liabilities, 2); ?></span>
                    </div>

                    <div class="result-item">
                        <span class="result-label">Zakatable Amount:</span>
                        <span class="result-value">৳ <?php echo number_format($zakatable_amount, 2); ?></span>
                    </div>

                    <div class="result-item">
                        <span class="result-label">Nisab Threshold:</span>
                        <span class="result-value">৳ <?php echo number_format($nisab, 2); ?></span>
                    </div>

                    <?php if ($zakat_result === 'payable'): ?>
                        <div class="result-item">
                            <span class="result-label">Zakat Due (2.5%):</span>
                            <span class="result-value" style="color: #02BD61; font-size: 22px;">৳ <?php echo number_format($zakat_due, 2); ?></span>
                        </div>
                    <?php else: ?>
                        <div style="margin-top: 15px; color: #856404;">
                            Your zakatable amount (৳ <?php echo number_format($zakatable_amount, 2); ?>) is below the Nisab threshold (৳ <?php echo number_format($nisab, 2); ?>). Zakat is not obligatory at this time.
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Information Note -->
            <div style="margin-top: 30px; padding: 20px; background: #02BD61; border-radius: 8px; border-left: 4px solid #06CC6B;">
                <h4 style="color: #fff; margin-bottom: 10px; font-size: 16px;">📌 Important Notes:</h4>
                <ul style="color: #fff; font-size: 14px; line-height: 1.8;">
                    <li>Zakat is 2.5% of your zakatable wealth</li>
                    <li>Your wealth must exceed the Nisab threshold for one lunar year</li>
                    <li>Update the Nisab value based on current gold (87.48g) or silver (612.36g) prices</li>
                    <li>Consult with a qualified Islamic scholar for specific rulings</li>
                </ul>
            </div>
            
        </div>

        <br><br>

        <div class="calculator-container">
            <div class="text-center">
                <h2 class="section_title"><b>Pay Your Zakat</b></h2>
                <div class="currency-badge">Currency: BDT (৳)</div>
            </div>
            <!-- Liabilities Section -->
            <h3 class="section-title">Pay Your Zakat Amount</h3>
            <div class="form-group">
                <label for="pay_zakat_amount">Enter Amount</label>
                <input type="number" name="pay_zakat_amount" id="pay_zakat_amount" class="form-control" step="0.01" placeholder="Enter your zakat amount">
            </div>
            <div class="button-group" style="margin:40px 0 10px 0;">
                <a href="" class="btn-calculate text-decoration-none text-white text-center">Pay Zakat Now</a>
            </div>
        </div>

    </div>
</div>
<div class="container mx-auto">
    <div class="section_title">
        <h2>
            Simplifying your Zakat calculation
        </h2>
    </div>
    <p>Calculating your Zakat isn’t as difficult as you may think. We find that breaking your assets down into different categories makes the Zakat calculation process really simple.

        We have broken down the calculation process into Zakatable assets (gold, silver, cash, savings, business assets etc.) and deductible liabilities (money you owe, other outgoings due) so you can calculate the Zakat you owe easily.

        The amount of Zakat you need to pay will be determined once you have calculated the value of your net assets. You then need to see whether your net assets are equal to, or exceed, the nisab threshold.


        You will determine the amount of zakat to pay once you calculate the value of your net assets. Once this is done, you can see whether your net assets are equal to, or exceed, the nisab threshold.</p>
    <div class="section_title">
        <h2>
            Using the Zakat Calculator
        </h2>
    </div>
    <p>Enter all assets that have been in your possession over a lunar year into the Zakat Calculator. This will then give you the total amount of zakat owed.</p>

    <p>The nisab is the minimum amount of wealth a Muslim must possess before they become eligible to pay zakat. This amount is often referred to as the nisab threshold.


        Gold and silver are the two values used to calculate the nisab threshold. For 2025, the current nisab value in terms of gold and silver is 87.48 grams of gold and 612.36 grams of silver</p>
    <div class="section_title">
        <h2>
            How is Zakat calculated in 2025?
        </h2>
    </div>
<p>You can calculate your zakat in 2025 by using Islamic Relief’s quick and easy-to-use Zakat Calculator. 


Eligible Muslims pay zakat once a year, and it is due as soon as one lunar (Islamic) year has passed since meeting or exceeding the nisab (certain amount of wealth). 


We have broken down the calculation process into zakatable assets (gold, silver, cash, savings, business assets etc.) and Deductible liabilities (money you owe, other outgoings due) so you can calculate the zakat you owe easily.


The amount of zakat you need to pay will be determined once you have calculated the value of your net assets. You then need to see whether your net assets are equal to, or exceed, the nisab threshold.</p>
    <div class="section_title">
        <h2>
         How to calculate Zakat on cash?
        </h2>
    </div>
    <p>Calculating Zakat on cash is very straightforward. 

First, total how much cash you own from the past year, including all cash in your bank account, cash at home, and cash which is owed to you. 

Then take away any cash which you own to others/ in debt, as well as any cash outgoings due, to work out how much cash you own. 

If this value is above the nisab threshold, you must pay Zakat. This is calculated by multiplying the net cash you own by 2.5%. 

*Please note that you must calculate the Zakat due on cash alongside your other assets (this includes gold and silver, investments, shares and business assets).

You can efficiently calculate how much Zakat you owe using our Zakat calculator. </p>
    <div class="section_title">
        <h2>
       How to calculate debts and liabilities with regards to paying Zakat?
        </h2>
    </div>
    <p>Some debts and liabilities can be deducted from the total value of your Zakatable assets when calculating how much Zakat you must pay from the last year. These include: 

Debts which must be paid off within 12 months.
Up to 12 months worth of instalments of longer-term debts.
Arrears and/or overdue payments.
However, not all debts and liabilities can be deducted from the total value of your Zakatable assets from the past year. These include: 

Expenses and bills which are not yet due.
Debts that are not payable at all in the next 12 months.
Interest payments. As interest or riba is haram, if a person has interest due on debt this can’t be taken off the Zakat amount. 
For mortgages and student loans, alongside other long-term debts, only the amounts which are overdue or due imminently should be deducted when calculating Zakat. 

Zakat must also be paid on debts owed to you, that you believe will be paid- such as the repayment of loans given to family and friends. </p>
</div>
<script>
    // Smooth scroll to results after page reload
    document.addEventListener('DOMContentLoaded', function() {
        const resultSection = document.getElementById('resultSection');

        // If results exist, scroll to them smoothly after a brief delay
        if (resultSection) {
            setTimeout(function() {
                resultSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 300);
        }

        // Add loading animation to calculate button
        const form = document.getElementById('zakatForm');
        const calculateBtn = document.getElementById('calculateBtn');

        form.addEventListener('submit', function() {
            calculateBtn.classList.add('calculating');
            calculateBtn.textContent = 'Calculating...';
        });
    });
</script>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/footer.php'; ?>