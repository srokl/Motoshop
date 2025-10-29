<?php
include 'header.php'; // New header
$error = '';
$success = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // GET DATA (INSECURELY)
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $phone = $_POST['phoneNo']; // <-- NEW
    $email = $_POST['Email'];
    $pass = $_POST['Password']; // Storing plain text password

    // Updated validation
    if (empty($fname) || empty($lname) || empty($phone) || empty($email) || empty($pass)) {
        $error = "All fields are required.";
    } else {
        // INSECURE SQL query (with phoneNo)
        $sql = "INSERT INTO users (FirstName, LastName, phoneNo, Email, Password) 
                VALUES ('$fname', '$lname', '$phone', '$email', '$pass')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful! You can now <a href='login.php'>log in</a>.";
        } else {
            if ($conn->errno == 1062) {
                $error = "This email is already registered.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
    $conn->close();
}
?>

<div class="form-container-boxed">
    <h2>Create Your Account</h2>
    
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="FirstName">First Name</label>
            <input type="text" name="FirstName" id="FirstName" placeholder="Enter your first name" required>
        </div>
        <div class="form-group">
            <label for="LastName">Last Name</label>
            <input type="text" name="LastName" id="LastName" placeholder="Enter your last name" required>
        </div>
        
        <div class="form-group">
            <label for="phoneNo">Phone Number</label>
            <input type="text" name="phoneNo" id="phoneNo" placeholder="Enter your phone number" required>
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" placeholder="Choose an email" required>
        </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password" placeholder="Create a password" required>
        </div>
        <button type="submit" class="form-btn">Register</button>
    </form>
    
    <a href="login.php" class="form-link">Already have an account? Log in</a>
    <?php endif; ?>
</div>

<?php
include 'footer.php'; // New footer
?>