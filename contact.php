<?php
include 'header.php'; // New header
$error = '';
$success = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // GET DATA (INSECURELY)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } else {
        // INSECURE SQL query to insert the message
        // This matches your 'contact' table structure
        $sql = "INSERT INTO contact (name, email, message) 
                VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            $success = "Thank you for your message! We will get back to you soon.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
    $conn->close();
}
?>

<div class="form-container-boxed">
    <h2 class="section-title">Get in Touch</h2>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if (!$success): // Hide form on success ?>
    <form action="contact.php" method="POST">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required />
        </div>
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required />
        </div>
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="form-btn">Send Message</button>
    </form>
    <?php endif; ?>
</div>

<?php
include 'footer.php'; // New footer
?>