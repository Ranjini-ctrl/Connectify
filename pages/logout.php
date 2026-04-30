<?php
session_start();
include "../config/db.php"; // adjust path if needed

// Check if session exists
if (isset($_SESSION['user'])) {
    $email = $_SESSION['user'];

    // Update user status to offline
    mysqli_query($conn, "UPDATE users SET status='offline' WHERE email='$email'");
}

// Destroy session
$_SESSION = [];
session_destroy();

// Redirect to login page
header("Location: index.html");
exit();
?>