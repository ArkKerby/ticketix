<?php
session_start();

// Update user status to offline in database
if (isset($_SESSION['user_id'])) {
    $conn = new mysqli("localhost", "root", "", "ticketix");
    
    if (!$conn->connect_error) {
        $update_query = "UPDATE user_account SET user_status = 'offline' WHERE acc_id = " . $_SESSION['user_id'];
        $conn->query($update_query);
        $conn->close();
    }
}

// Destroy the session
session_destroy();

// Redirect to homepage
header("Location: TICKETIX NI CLAIRE.php");
exit();
?>
