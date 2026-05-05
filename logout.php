<?php
session_start();
include "../config/db1.php";

// check if user logged in
if (isset($_SESSION['user'])) {

    $email = $_SESSION['user'];

    // update status to offline
    mysqli_query($conn, "UPDATE users SET status='offline' WHERE email='$email'");
}

// destroy session
session_unset();
session_destroy();

// redirect to login page
header("Location: ../index.html");
exit();
?>
