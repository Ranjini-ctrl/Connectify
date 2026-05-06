<?php
session_start();

// ✅ DB connection
include __DIR__ . "/config/db.php";

// ✅ Check DB
if (!$conn) {
    die("Database connection failed!");
}

// ✅ If user logged in → update status
if (isset($_SESSION['user'])) {

    $email = $_SESSION['user'];

    mysqli_query($conn, "UPDATE users SET status='offline' WHERE email='$email'");
}

// ✅ Destroy session
session_unset();
session_destroy();

// ✅ Redirect to login page
header("Location: index.php");
exit();
?>