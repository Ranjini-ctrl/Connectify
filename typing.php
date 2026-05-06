<?php
session_start();
include __DIR__ . "/config/db.php";

// 🔒 check login
if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$typing = $_POST['typing'] ?? 0;

// update typing status
mysqli_query($conn, "UPDATE users SET is_typing='$typing' WHERE id='$user_id'");
?>