<?php
include __DIR__ . "/config/db.php";

$other_user_id = $_GET['user_id'] ?? 0;

$result = mysqli_query($conn, "SELECT name, is_typing FROM users WHERE id='$other_user_id'");
$row = mysqli_fetch_assoc($result);

if ($row && $row['is_typing'] == 1) {
    echo $row['name'] . " is typing...";
} else {
    echo "";
}
?>