<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

//  Include DB correctly
include __DIR__ . "/config/db.php";

//  Check DB connection
if (!$conn) {
    die("Database connection failed!");
}

// If user is logged in
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    // 🔄 Update status to offline
    $sql = "UPDATE users SET status='offline' WHERE id='$user_id'";

    if (!mysqli_query($conn, $sql)) {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

//  Destroy session
$_SESSION = [];
session_destroy();

//  Redirect to login page
header("Location: index.php");
exit();
?>