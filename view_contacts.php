<?php
include 'header.php';

// Ensure admin is logged in
if (!isset($_SESSION['adminID'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<div class="container">
    <h2 class="section-title">Contact Form Messages</h2>
    
    <div class="table-responsive">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all messages from the contact table
                $sql_messages = "SELECT * FROM contact ORDER BY name ASC";
                $result_messages = $conn->query($sql_messages);

                if ($result_messages->num_rows > 0) {
                    while ($row = $result_messages->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        // Use nl2br to respect line breaks in the message
                        echo "<td style='white-space: pre-wrap;'>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No contact messages found.</td></tr>";
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