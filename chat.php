<?php
session_start();
include __DIR__ . "/config/db.php";

// 🔒 Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 👤 Current + other user
$current_user = $_SESSION['user_id'];
$other_user = $_GET['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connectify Chat</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="chat-box">
    <h3>Connectify Chat 💬</h3>

    <!-- 💬 Messages -->
    <div id="messages"></div>

    <!-- ⌨️ Typing indicator -->
    <p id="typingStatus" style="color: gray;"></p>

    <!-- 📝 Input -->
    <input type="text" id="messageBox" placeholder="Type a message...">
</div>

<script>
// ================= TYPING FEATURE =================
const input = document.getElementById("messageBox");
let typingTimeout;

// ✍️ Send typing status
input.addEventListener("input", () => {

    sendTyping(1);

    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => {
        sendTyping(0);
    }, 1500);
});

function sendTyping(status) {
    fetch("typing.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "typing=" + status
    });
}

// 👀 Check other user typing
function checkTyping() {
    fetch("check_typing.php?user_id=<?php echo $other_user; ?>")
    .then(res => res.text())
    .then(data => {
        document.getElementById("typingStatus").innerText = data;
    });
}

// 🔄 Run every second
setInterval(checkTyping, 1000);
</script>

</body>
</html>