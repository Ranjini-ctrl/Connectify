<?php
session_start();
include __DIR__ . "/config/db.php";

if (!isset($_SESSION['user_id'])) exit();

$sender = $_SESSION['user_id'];

// ✅ FIX: check if values exist
$receiver = isset($_POST['receiver']) ? $_POST['receiver'] : '';
$message  = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!empty($message) && !empty($receiver)) {

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender, $receiver, $message);
    $stmt->execute();
}
?>