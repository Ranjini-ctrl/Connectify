<?php
session_start();
include "db.php";

$email = $_SESSION['user'];

// update status to offline
mysqli_query($conn, "UPDATE users SET status='offline' WHERE email='$email'");

session_destroy();

header("Location: login.html");
exit();
?>