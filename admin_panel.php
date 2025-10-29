<?php
include 'header.php';

// Ensure admin is logged in
if (!isset($_SESSION['adminID'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<div class="container">
    <h2>Admin Panel</h2>
    
    <a href="view_contacts.php" class="form-btn" 
       style="text-decoration: none; margin-bottom: 25px; background: #28a745; display: inline-block; width: auto;">
       View Contact Messages
    </a>

    <h3>All Customer Orders</h3>
    <?php
    if (isset($_GET['status_success'])) {
        echo "<p class='success'>Order status updated successfully!</p>";
    }
    ?>
    <div class="table-responsive"> <table class="order-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Address</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Payment Method</th> 
                <th>Order Date</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_orders = "SELECT o.OrderID, u.FirstName, u.LastName, u.Email, o.OrderAddress, 
                                  p.productModel, o.OrderQuantity, o.PaymentMethod, o.OrderDate, o.OrderStatus
                    FROM orders o
                    LEFT JOIN users u ON o.userID = u.userID
                    LEFT JOIN products p ON o.productID = p.productID
                    ORDER BY o.OrderDate DESC";
            
            $result_orders = $conn->query($sql_orders);

            if ($result_orders) {
                if ($result_orders->num_rows > 0) {
                    while ($row = $result_orders->fetch_assoc()) {
                        $status_class = "status-" . str_replace(' ', '-', $row['OrderStatus']);
                        echo "<tr>";
                        echo "<td>" . $row['OrderID'] . "</td>";
                        echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['OrderAddress'] . "</td>";
                        echo "<td>" . $row['productModel'] . "</td>";
                        echo "<td>" . $row['OrderQuantity'] . "</td>";
                        echo "<td>" . ($row['PaymentMethod'] ? htmlspecialchars($row['PaymentMethod']) : 'N/A') . "</td>";
                        echo "<td>" . $row['OrderDate'] . "</td>";
                        echo "<td class='" . $status_class . "'>" . $row['OrderStatus'] . "</td>";
                        
                        // --- Editable Status Form ---
                        echo "<td>
                                <form action='update_status.php' method='POST' class='status-form'>
                                    <input type='hidden' name='OrderID' value='" . $row['OrderID'] . "'>
                                    <select name='OrderStatus'>
                                        <option value='Pending' " . ($row['OrderStatus'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                        <option value='Processing' " . ($row['OrderStatus'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                                        <option value='On Delivery' " . ($row['OrderStatus'] == 'On Delivery' ? 'selected' : '') . ">On Delivery</option>
                                        <option value='Delivered' " . ($row['OrderStatus'] == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                                    </select>
                                    <button type='submit'>Save</button>
                                </form>
                              </td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No orders found.</td></tr>";
                }
            } else {
                echo "Error: " . $conn->error;
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">

    <h3>Product Management</h3>
    <a href="add_product.php" class="form-btn" style="text-decoration: none; margin-bottom: 15px;">Add New Product</a>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_products = "SELECT * FROM products ORDER BY productID ASC";
            $result_products = $conn->query($sql_products);

            if ($result_products->num_rows > 0) {
                while ($row = $result_products->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['productID'] . "</td>";
                    echo "<td>" . $row['productimage'] . "</td>";
                    echo "<td>" . $row['BrandName'] . "</td>";
                    echo "<td>" . $row['productModel'] . "</td>";
                    echo "<td>" . "₱ " . number_format($row['Price'], 2) . "</td>";
                    echo "<td>" . substr($row['productDescription'], 0, 50) . "...</td>";
                    echo "<td>";
                    echo "<a href='edit_product.php?product_id=" . $row['productID'] . "' style='color:blue;'>Edit</a> | ";
                    echo "<a href='delete_product.php?product_id=" . $row['productID'] . "' 
                           onclick='return confirm(\"Are you sure you want to delete this product AND all associated orders?\");' 
                           style='color:red;'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found. (Have you imported your .sql file?)</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">

    <h3>Payments History</h3>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>User Email</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_payments = "SELECT pay.paymentID, pay.OrderID, u.Email, pay.paymentMethod, pay.paymentAmount, pay.paymentStatus, pay.paymentDate
                             FROM payments pay
                             JOIN orders o ON pay.OrderID = o.OrderID
                             JOIN users u ON o.userID = u.userID
                             ORDER BY pay.paymentDate DESC
                             LIMIT 50";
            $result_payments = $conn->query($sql_payments);

            if ($result_payments->num_rows > 0) {
                while ($row = $result_payments->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['paymentID'] . "</td>";
                    echo "<td>" . $row['OrderID'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['paymentMethod'] . "</td>";
                    echo "<td>" . "₱ " . number_format($row['paymentAmount'], 2) . "</td>";
                    echo "<td>" . $row['paymentStatus'] . "</td>";
                    echo "<td>" . $row['paymentDate'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No payment history found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">
    <h3>Credit Card Payment Details</h3>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Cardholder Name</th>
                <th>Card Number</th>
                <th>CSV</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_card = "SELECT * FROM cardpayment";
            $result_card = $conn->query($sql_card);
            if ($result_card && $result_card->num_rows > 0) {
                while ($row = $result_card->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['paymentID'] . "</td>";
                    echo "<td>" . $row['cardholderName'] . "</td>";
                    echo "<td>" . $row['cardNumber'] . "</td>";
                    echo "<td>" . $row['csv'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No card payments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">
    <h3>Gcash Payment Details</h3>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Account Name</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_gcash = "SELECT * FROM gcashpayment";
            $result_gcash = $conn->query($sql_gcash);
            if ($result_gcash && $result_gcash->num_rows > 0) {
                while ($row = $result_gcash->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['paymentID'] . "</td>";
                    echo "<td>" . $row['AccountName'] . "</td>";
                    echo "<td>" . $row['phonenumber'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No Gcash payments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">
    <h3>Online Banking Payment Details</h3>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Account Name</th>
                <th>Account Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_banking = "SELECT * FROM otheronlinebanking";
            $result_banking = $conn->query($sql_banking);
            if ($result_banking && $result_banking->num_rows > 0) {
                while ($row = $result_banking->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['paymentID'] . "</td>";
                    echo "<td>" . $row['accountname'] . "</td>";
                    echo "<td>" . $row['accountnumber'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No online banking payments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <hr style="margin: 30px 0;">
    <h3>User Login History</h3>
    <div class="table-responsive"> 
    <table class="order-table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Login Date</th>
                <th>Login Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_logins = "SELECT * FROM login ORDER BY loginDate DESC, loginTime DESC LIMIT 50";
            $result_logins = $conn->query($sql_logins);

            if ($result_logins->num_rows > 0) {
                while ($row = $result_logins->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['loginDate'] . "</td>";
                    echo "<td>" . $row['loginTime'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No login history found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    </div>

<?php
$conn->close();
include 'footer.php';
?>