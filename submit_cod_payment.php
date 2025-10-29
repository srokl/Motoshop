<?php
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $orderID = $_POST['orderID'];
    $paymentAmount = $_POST['paymentAmount'];
    $paymentMethod = 'Cash on Delivery';
    $userID = $_SESSION['userID'];

    // 1. Insert into main payments table
    $sql_insert_payment = "INSERT INTO payments (OrderID, paymentMethod, paymentAmount, paymentStatus)
                           VALUES ($orderID, '$paymentMethod', $paymentAmount, 'Unpaid (COD)')";

    if ($conn->query($sql_insert_payment) === TRUE) {
        
        // 2. Update order status to 'Pending' and set PaymentMethod
        $sql_update_order = "UPDATE orders SET 
                                OrderStatus = 'Pending',
                                PaymentMethod = '$paymentMethod'
                             WHERE OrderID = $orderID AND userID = $userID";
        
        if ($conn->query($sql_update_order) === TRUE) {
            // Success!
            header('Location: my_orders.php?payment=success_cod');
            exit;
        } else {
            echo "Error updating order status: " . $conn->error;
        }

    } else {
        echo "Error processing payment: " . $conn->error;
    }

} else {
    header('Location: index.php');
}

$conn->close();
?>