<?php
include 'header.php'; // New header

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}
$userID = $_SESSION['userID'];
?>

<div class="container">
    <h2 class="section-title">My Orders</h2>

    <?php
    if (isset($_GET['payment']) && $_GET['payment'] == 'success') {
        echo "<p class='success'>Payment successful! Your order is now processing.</p>";
    }
    if (isset($_GET['payment']) && $_GET['payment'] == 'success_cod') {
        echo "<p class'success'>Order placed successfully! Please prepare your payment for delivery.</p>";
    }
    ?>
    
    <div class="table-responsive">
        <table class="order-table"> <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // UPDATED SQL: Added o.OrderID to the SELECT statement
                $sql = "SELECT o.OrderID, p.productModel, p.BrandName, o.OrderDate, o.OrderQuantity, o.PaymentMethod, o.OrderStatus
                        FROM orders o
                        JOIN products p ON o.productID = p.productID
                        WHERE o.userID = $userID
                        ORDER BY o.OrderID DESC"; // Changed to order by ID descending
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        // NEW ROW CELL
                        echo "<td>" . htmlspecialchars($row['OrderID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['productModel']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['BrandName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['OrderDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['OrderQuantity']) . "</td>";
                        echo "<td>" . ($row['PaymentMethod'] ? htmlspecialchars($row['PaymentMethod']) : 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['OrderStatus']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // UPDATED COLSPAN from 6 to 7
                    echo "<tr><td colspan='7'>You have not placed any orders yet.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'footer.php'; // New footer
?>