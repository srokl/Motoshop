<?php
include 'header.php'; // New header

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['userID'];
$error = '';
$success = '';

// Fetch user's current complete details (including password for verification)
$sql_fetch = "SELECT FirstName, LastName, phoneNo, Email, Password FROM users WHERE userID = $userID";
$result = $conn->query($sql_fetch);
$user = $result->fetch_assoc();

// Check if form is submitted (for updating)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- 1. Get Personal Details ---
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $phone = $_POST['phoneNo'];
    $email = $_POST['Email'];

    // --- 2. Get Password Fields ---
    $currentPass = $_POST['CurrentPassword'];
    $newPass = $_POST['NewPassword'];
    $confirmPass = $_POST['ConfirmPassword'];
    
    $password_sql_part = ""; // This will be empty if password isn't being changed

    // --- 3. Validate Personal Details ---
    if (empty($fname) || empty($lname) || empty($phone) || empty($email)) {
        $error = "All personal detail fields (Name, Phone, Email) are required.";
    }

    // --- 4. Validate Password Change (if user is trying to change it) ---
    if (!empty($currentPass) || !empty($newPass) || !empty($confirmPass)) {
        
        // Check if all three fields are filled
        if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
            $error = "To change your password, you must fill all three password fields.";
        }
        // Check if the 'Current Password' is correct
        else if ($currentPass != $user['Password']) {
            $error = "Your 'Current Password' is incorrect.";
        }
        // Check if the 'New' and 'Confirm' passwords match
        else if ($newPass != $confirmPass) {
            $error = "Your 'New Password' and 'Confirm Password' fields do not match.";
        }
        // All password checks passed
        else {
            // Prepare the SQL fragment to update the password
            $password_sql_part = ", Password = '$newPass'";
        }
    }

    // --- 5. If no errors so far, proceed with database update ---
    if (empty($error)) {
        
        // Construct the final query
        $sql_update = "UPDATE users SET
                            FirstName = '$fname',
                            LastName = '$lname',
                            phoneNo = '$phone',
                            Email = '$email'
                            $password_sql_part 
                       WHERE userID = $userID";

        if ($conn->query($sql_update) === TRUE) {
            $success = "Your settings have been updated successfully!";
            $_SESSION['FirstName'] = $fname; // Update session name
            
            // Re-fetch the user data to display the newly updated info in the form
            $result = $conn->query($sql_fetch);
            $user = $result->fetch_assoc();

        } else {
            // Check for a duplicate email error
            if ($conn->errno == 1062) {
                $error = "That email address is already in use by another account.";
            } else {
                $error = "Error updating settings: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<div class="form-container-boxed">
    <h2>My Settings</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="user_settings.php" method="POST">
        
        <h3>Personal Details</h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Update your personal information.</p>

        <div class="form-group">
            <label for="FirstName">First Name</label>
            <input type="text" name="FirstName" id="FirstName" value="<?php echo htmlspecialchars($user['FirstName']); ?>" required>
        </div>
        <div class="form-group">
            <label for="LastName">Last Name</label>
            <input type="text" name="LastName" id="LastName" value="<?php echo htmlspecialchars($user['LastName']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phoneNo">Phone Number</label>
            <input type="text" name="phoneNo" id="phoneNo" value="<?php echo htmlspecialchars($user['phoneNo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

        <h3>Change Password</h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Leave all three fields blank to keep your current password.</p>

        <div class="form-group">
            <label for="CurrentPassword">Current Password</label>
            <input type="password" name="CurrentPassword" id="CurrentPassword" placeholder="Enter your current password">
        </div>
        <div class="form-group">
            <label for="NewPassword">New Password</label>
            <input type="password" name="NewPassword" id="NewPassword" placeholder="Enter a new password">
        </div>
        <div class="form-group">
            <label for="ConfirmPassword">Confirm New Password</label>
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirm your new password">
        </div>
        
        <button type="submit" class="form-btn">Update Settings</button>
    </form>
</div>

<?php
include 'footer.php'; // New footer
?>