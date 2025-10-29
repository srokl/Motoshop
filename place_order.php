<?php
include 'header.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

// Check if product_id is provided
if (!isset($_GET['product_id'])) {
    echo "<div class='container'><p class='error'>No product selected.</p></div>";
    include 'footer.php';
    exit;
}

$productID = $_GET['product_id'];

// --- UPDATED SQL ---
// Fetch product details, including Price, image, and description
$sql = "SELECT productModel, BrandName, Price, productimage, productDescription 
        FROM products 
        WHERE productID = $productID";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='container'><p class='error'>Product not found.</p></div>";
    include 'footer.php';
    exit;
}

$product = $result->fetch_assoc();
?>

<div class="container">
    <div class="form-container">
        
        <h2 style="text-align: center;">Place Your Order</h2>
        
        <img src="images/<?php echo htmlspecialchars($product['productimage']); ?>" 
             alt="<?php echo htmlspecialchars($product['productModel']); ?>" 
             style="width: 100%; max-width: 400px; margin: 20px auto; display: block; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">

        <h3 style="text-align: center; margin-top: 0;"><?php echo $product['BrandName'] . " " . $product['productModel']; ?></h3>
        <h4 style="color: #0056b3; margin-bottom: 20px; text-align: center;">
            Price: <?php echo "₱ " . number_format($product['Price'], 2); ?>
        </h4>
        
        <?php if (!empty($product['productDescription'])): ?>
            <p style="text-align: left; font-size: 1rem; color: #555; margin-bottom: 25px; padding: 15px; background: #f9f9f9; border-radius: 6px; border: 1px solid #eee;">
                <?php echo nl2br(htmlspecialchars($product['productDescription'])); ?>
            </p>
        <?php endif; ?>
        
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

        <form action="order.php" method="POST">
            <input type="hidden" name="productID" value="<?php echo $productID; ?>">
            
            <div class="form-group">
                <label for="OrderQuantity">Quantity</label>
                <input type="number" name="OrderQuantity" id="OrderQuantity" value="1" min="1" required>
            </div>

            <div class="form-group">
                <label for="OrderAddress">Delivery Address</label>
                <input type="text" name="OrderAddress" id="OrderAddress" placeholder="Enter your full delivery address" required>
            </div>
            
            <button type="submit" class="form-btn">Proceed to Payment</button>
        </form>
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>