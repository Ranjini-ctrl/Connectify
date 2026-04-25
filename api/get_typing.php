<?php
include("../config/db.php");

$other_user_id = 2; // dynamic later

$result = $conn->query("SELECT username, is_typing FROM users WHERE id='$other_user_id'");
$row = $result->fetch_assoc();

if ($row['is_typing'] == 1) {
    echo $row['username'] . " is Typing...";
} else {
    echo "";
}
?>
