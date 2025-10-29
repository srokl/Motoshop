<?php
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $orderID = $_POST['orderID'];
    $paymentMethod = $_POST['PaymentMethod'];
    $paymentAmount = $_POST['paymentAmount'];
    $userID = $_SESSION['userID'];

    // 1. Insert into payments table
    $sql_insert_payment = "INSERT INTO payments (OrderID, paymentMethod, paymentAmount, paymentStatus)
                           VALUES ($orderID, '$paymentMethod', $paymentAmount, 'Paid')";

    if ($conn->query($sql_insert_payment) === TRUE) {
        
        // 2. Update order status to 'Processing' and add PaymentMethod
        $sql_update_order = "UPDATE orders SET 
                                OrderStatus = 'Processing',
                                PaymentMethod = '$paymentMethod'
                             WHERE OrderID = $orderID AND userID = $userID";
        
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

} else {
    // Redirect if not a POST request
    header('Location: index.php');
}

$conn->close();
?>