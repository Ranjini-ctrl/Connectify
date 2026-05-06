<?php
session_start();
include __DIR__ . "/config/db.php";

if (!isset($_SESSION['user_id'])) exit();

$current = $_SESSION['user_id'];

// ✅ FIX: use GET (not POST)
$other = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

if ($other == 0) exit();

// ✅ Fetch messages
$query = mysqli_query($conn, "
    SELECT * FROM messages
    WHERE (sender_id='$current' AND receiver_id='$other')
       OR (sender_id='$other' AND receiver_id='$current')
    ORDER BY created_at ASC
");

while ($row = mysqli_fetch_assoc($query)) {

    if ($row['sender_id'] == $current) {
        echo "<div style='text-align:right;color:lightgreen;margin:5px;'>You: " 
             . htmlspecialchars($row['message']) . "</div>";
    } else {
        echo "<div style='text-align:left;color:white;margin:5px;'>"
             . htmlspecialchars($row['message']) . "</div>";
    }
}
?>