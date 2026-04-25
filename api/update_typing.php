<?php
session_start();
include("../config/db.php");

$user_id = $_SESSION['user_id']; 
$typing = $_POST['typing'];

$conn->query("UPDATE users SET is_typing='$typing' WHERE id='$user_id'");
?>