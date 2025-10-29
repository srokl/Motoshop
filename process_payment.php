<?php
include 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    echo "<div class='container'><p class='error'>No order selected for payment.</p></div>";
    include 'footer.php';
    exit;
}

$userID = $_SESSION['userID'];
$orderID = $_GET['order_id'];

// Fetch the order to ensure it belongs to this user and is 'Pending'
$sql_order = "SELECT o.*, p.productModel, p.BrandName, p.Price
              FROM orders o
              JOIN products p ON o.productID = p.productID
              WHERE o.OrderID = $orderID AND o.userID = $userID";
$result_order = $conn->query($sql_order);

if ($result_order->num_rows == 0) {
    echo "<div class='container'><p class='error'>Order not found.</p></div>";
    include 'footer.php';
    exit;
}

$order = $result_order->fetch_assoc();

// Check if order is already paid or processing
if ($order['OrderStatus'] != 'Pending') {
    echo "<div class='container'>
            <p class='error'>This order is already " . $order['OrderStatus'] . " and cannot be paid again.</p>
            <a href='my_orders.php'>Back to My Orders</a>
          </div>";
    include 'footer.php';
    exit;
}

// Calculate total
$totalAmount = $order['Price'] * $order['OrderQuantity'];
?>

<div class="container">
    <div class="form-container">
        <h2>Confirm Your Payment</h2>
        
        <h3>Order Summary</h3>
        <p><strong>Product:</strong> <?php echo $order['BrandName'] . " " . $order['productModel']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $order['OrderQuantity']; ?></p>
        <p><strong>Delivery Address:</strong> <?php echo $order['OrderAddress']; ?></p>
        <h4 style="color: #0056b3; margin: 20px 0;">
            Total Amount: <?php echo "₱ " . number_format($totalAmount, 2); ?>
        </h4>
        
        <div class="form-group">
            <label for="PaymentMethod">Select Payment Method</label>
            <select name="PaymentMethod" id="PaymentMethod" onchange="showPaymentForm()" required>
                <option value="">-- Select a Payment Method --</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="Credit Card or Debit Card">Credit Card or Debit Card</option>
                <option value="Gcash">Gcash</option>
                <option value="Other Online Banking">Other Online Banking</option>
            </select>
        </div>

        <input type="hidden" id="orderID" value="<?php echo $orderID; ?>">
        <input type="hidden" id="paymentAmount" value="<?php echo $totalAmount; ?>">

        <form action="submit_cod_payment.php" method="POST" id="cod_form" class="payment-form" style="display:none;">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
            <input type="hidden" name="paymentAmount" value="<?php echo $totalAmount; ?>">
            <p>You will pay upon delivery. Click confirm to place your order.</p>
            <button type="submit" class="form-btn">Confirm Order</button>
        </form>

        <form action="submit_card_payment.php" method="POST" id="card_form" class="payment-form" style="display:none;">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
            <input type="hidden" name="paymentAmount" value="<?php echo $totalAmount; ?>">
            <div class="form-group">
                <label for="cardholderName">Cardholder Name</label>
                <input type="text" name="cardholderName" id="cardholderName" required>
            </div>
            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input type="text" name="cardNumber" id="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="csv">CSV</label>
                <input type="text" name="csv" id="csv" required>
            </div>
            <button type="submit" class="form-btn">Submit Payment</button>
        </form>

        <form action="submit_gcash_payment.php" method="POST" id="gcash_form" class="payment-form" style="display:none;">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
            <input type="hidden" name="paymentAmount" value="<?php echo $totalAmount; ?>">
            <div class="form-group">
                <label for="AccountName">Gcash Account Name</label>
                <input type="text" name="AccountName" id="AccountName" required>
            </div>
            <div class="form-group">
                <label for="phonenumber">Gcash Phone Number</label>
                <input type="text" name="phonenumber" id="phonenumber" required>
            </div>
            <button type="submit" class="form-btn">Submit Payment</button>
        </form>

        <form action="submit_banking_payment.php" method="POST" id="banking_form" class="payment-form" style="display:none;">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
            <input type="hidden" name="paymentAmount" value="<?php echo $totalAmount; ?>">
            <div class="form-group">
                <label for="accountname">Bank Account Name</label>
                <input type="text" name="accountname" id="accountname" required>
            </div>
            <div class="form-group">
                <label for="accountnumber">Bank Account Number</label>
                <input type="text" name="accountnumber" id="accountnumber" required>
            </div>
            <button type="submit" class="form-btn">Submit Payment</button>
        </form>

    </div>
</div>

<script>
function showPaymentForm() {
    // Hide all forms first
    document.getElementById('cod_form').style.display = 'none';
    document.getElementById('card_form').style.display = 'none';
    document.getElementById('gcash_form').style.display = 'none';
    document.getElementById('banking_form').style.display = 'none';

    // Get the selected value
    var selectedMethod = document.getElementById('PaymentMethod').value;

    // Show the correct form
    if (selectedMethod == 'Cash on Delivery') {
        document.getElementById('cod_form').style.display = 'block';
    } else if (selectedMethod == 'Credit Card or Debit Card') {
        document.getElementById('card_form').style.display = 'block';
    } else if (selectedMethod == 'Gcash') {
        document.getElementById('gcash_form').style.display = 'block';
    } else if (selectedMethod == 'Other Online Banking') {
        document.getElementById('banking_form').style.display = 'block';
    }
}
</script>

<?php
$conn->close();
include 'footer.php';
?>