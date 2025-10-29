<?php
// This page processes the order and redirects
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_SESSION['userID'];
    $productID = $_POST['productID'];
    $quantity = $_POST['OrderQuantity'];
    $orderAddress = $_POST['OrderAddress']; // Get Order Address
    
    $orderDate = date('Y-m-d'); // Current date
    $orderStatus = 'Pending'; // Default status

    // Simple validation
    if (empty($productID) || empty($quantity) || $quantity < 1 || empty($orderAddress)) {
        echo "Invalid order data. Please fill out all fields.";
        exit;
    }

    // INSECURE SQL query to insert the order (Address is now text)
    // PaymentMethod is NOT inserted here
    $sql = "INSERT INTO orders (userID, productID, OrderQuantity, OrderDate, OrderAddress, OrderStatus)
            VALUES ($userID, $productID, $quantity, '$orderDate', '$orderAddress', '$orderStatus')";

    if ($conn->query($sql) === TRUE) {
        // Get the ID of the order we just created
        $newOrderID = $conn->insert_id;
        
        // Order placed successfully, redirect to the NEW payment page
        header('Location: process_payment.php?order_id=' . $newOrderID);
        exit;
    } else {
        echo "Error placing order: " . $conn->error;
    }
} else {
    // No form data posted
    header('Location: index.php');
}

$conn->close();
?>