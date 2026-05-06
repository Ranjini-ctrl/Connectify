<?php
session_start();
include __DIR__ . "/config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION['user_id'];
$other_user = $_GET['user_id'] ?? 0;

if ($other_user == 0) {
    die("Invalid user!");
}

// get other user
$res = mysqli_query($conn, "SELECT name, profile_pic FROM users WHERE id='$other_user'");
$chatUser = mysqli_fetch_assoc($res);

if (!$chatUser) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Chat</title>

<style>
body { margin:0; font-family:Arial; background:#111; color:white; }

.chat-box {
    max-width:500px;
    margin:auto;
    height:100vh;
    display:flex;
    flex-direction:column;
}

.header {
    background:#2B124C;
    padding:10px;
    display:flex;
    align-items:center;
    gap:10px;
}

.header img {
    width:35px;
    height:35px;
    border-radius:50%;
}

#messages {
    flex:1;
    padding:10px;
    overflow-y:auto;
}

.input-box {
    display:flex;
    padding:10px;
    background:#1e1e1e;
}

.input-box input {
    flex:1;
    padding:10px;
    border:none;
    border-radius:6px;
}

.input-box button {
    margin-left:10px;
    padding:10px;
    background:#2B124C;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

#typingStatus {
    font-size:12px;
    color:gray;
    padding-left:10px;
}
</style>
</head>

<body>

<div class="chat-box">

<div class="header">
    <img src="uploads/<?php echo $chatUser['profile_pic'] ?: 'default.png'; ?>">
    <span><?php echo $chatUser['name']; ?></span>
</div>

<div id="messages"></div>

<p id="typingStatus"></p>

<div class="input-box">
    <input type="text" id="messageBox" placeholder="Type a message...">
    <button onclick="sendMessage()">Send</button>
</div>

</div>

<script>
const input = document.getElementById("messageBox");
const messagesDiv = document.getElementById("messages");

let typingTimeout;

// typing
input.addEventListener("input", () => {

    sendTyping(1);

    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => {
        sendTyping(0);
    }, 1500);
});

function sendTyping(status) {
    fetch("typing.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"typing=" + status
    });
}

// check typing
function checkTyping() {
    fetch("check_typing.php?user_id=<?php echo $other_user; ?>")
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("typingStatus").innerText = data;
    });
}

setInterval(checkTyping, 1000);

// send message
function sendMessage() {
    let msg = input.value.trim();
    if (msg === "") return;

    fetch("send_message.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"message=" + encodeURIComponent(msg) +
             "&receiver=<?php echo $other_user; ?>"
    });

    input.value = "";
    sendTyping(0);
}

// load messages
function loadMessages() {
    fetch("fetch_messages.php?user_id=<?php echo $other_user; ?>")
    .then(res=>res.text())
    .then(data=>{
        messagesDiv.innerHTML = data;
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    });
}

setInterval(loadMessages, 1000);
</script>

</body>
</html>