<?php
include 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    echo "<div class='container'><p class='error'>No order selected.</p></div>";
    include 'footer.php';
    exit;
}

$userID = $_SESSION['userID'];
$orderID = $_GET['order_id'];

// Fetch the order to ensure it belongs to this user and is 'Pending'
$sql_order = "SELECT * FROM orders WHERE OrderID = $orderID AND userID = $userID";
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

// Fetch product price to calculate total
$sql_product = "SELECT Price FROM products WHERE productID = " . $order['productID'];
$result_product = $conn->query($sql_product);
$product = $result_product->fetch_assoc();

$paymentAmount = $product['Price'] * $order['OrderQuantity'];
$paymentMethod = $order['PaymentMethod'];

// 1. Insert into payments table
$sql_insert_payment = "INSERT INTO payments (OrderID, paymentMethod, paymentAmount, paymentStatus)
                       VALUES ($orderID, '$paymentMethod', $paymentAmount, 'Paid')";

if ($conn->query($sql_insert_payment) === TRUE) {
    
    // 2. Update order status to 'Processing'
    $sql_update_order = "UPDATE orders SET OrderStatus = 'Processing' WHERE OrderID = $orderID";
    
    if ($conn->query($sql_update_order) === TRUE) {
        // Success! Redirect to my_orders.php with a success message
        header('Location: my_orders.php?payment=success');
        exit;
    } else {
        echo "Error updating order status: " . $conn->error;
    }

} else {
    echo "Error processing payment: " . $conn->error;
}

$conn->close();
include 'footer.php';
?>