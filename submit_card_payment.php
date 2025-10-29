<?php
include 'db.php';

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $orderID = $_POST['orderID'];
    $paymentAmount = $_POST['paymentAmount'];
    $paymentMethod = 'Credit Card or Debit Card';
    $userID = $_SESSION['userID'];

    // Get card details
    $cardholderName = $_POST['cardholderName'];
    $cardNumber = $_POST['cardNumber'];
    $csv = $_POST['csv'];

    // 1. Insert into main payments table
    $sql_insert_payment = "INSERT INTO payments (OrderID, paymentMethod, paymentAmount, paymentStatus)
                           VALUES ($orderID, '$paymentMethod', $paymentAmount, 'Paid')";

    if ($conn->query($sql_insert_payment) === TRUE) {
        $paymentID = $conn->insert_id; // Get the new paymentID

        // 2. Insert into cardpayment table
        $sql_card_details = "INSERT INTO cardpayment (paymentID, cardholderName, cardNumber, csv)
                             VALUES ($paymentID, '$cardholderName', '$cardNumber', '$csv')";
        
        if ($conn->query($sql_card_details) === TRUE) {
            // 3. Update order status to 'Processing'
            $sql_update_order = "UPDATE orders SET 
                                    OrderStatus = 'Processing',
                                    PaymentMethod = '$paymentMethod'
                                 WHERE OrderID = $orderID AND userID = $userID";
            
            if ($conn->query($sql_update_order) === TRUE) {
                header('Location: my_orders.php?payment=success');
                exit;
            } else {
                echo "Error updating order status: " . $conn->error;
            }
        } else {
            echo "Error saving card details: " . $conn->error;
        }
    } else {
        echo "Error processing payment: " . $conn->error;
    }

} else {
    header('Location: index.php');
}

$conn->close();
?>