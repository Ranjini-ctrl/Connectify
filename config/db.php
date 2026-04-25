<?php
$conn = new mysqli("localhost", "root", "", "connectify");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>