<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 🔒 Session check
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// ✅ Single DB connection (use ONE file only)
include __DIR__ . "/config/db.php";

// ❗ Check DB
if (!$conn) {
    die("Database connection failed!");
}

// ✅ Logged-in user
$email = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($res);

// ✅ Fetch all users
$query = mysqli_query($conn, "SELECT username, name, status, profile_pic FROM users");

if (!$query) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Connectify</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: linear-gradient(to bottom,#190019,#2B124C,#522B5B,#854F6C);
}

/* DARK MODE */
body.dark-mode {
    background: #121212;
    color: white;
}

/* HEADER */
.header {
    background: #2B124C;
    color: white;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* RIGHT CONTROLS */
.controls {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
}

/* MENU */
.menu {
    display: none;
    position: absolute;
    right: 0;
    top: 40px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

body.dark-mode .menu {
    background: #2a2a2a;
}

.menu a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: black;
}

body.dark-mode .menu a {
    color: white;
}

/* USERS LIST */
.users {
    padding: 15px;
}

.user {
    display: flex;
    align-items: center;
    background: #FBE4D8;
    margin-bottom: 10px;
    padding: 12px;
    border-radius: 10px;
    cursor: pointer;
    gap: 10px;
}

body.dark-mode .user {
    background: #1e1e1e;
}

/* PROFILE IMAGE */
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

/* NAME */
.name {
    flex: 1;
}

/* STATUS */
.status {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.online { background: green; }
.offline { background: gray; }

</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <span>Connectify 💬</span>

    <div class="controls">
        <button id="themeToggle">🌙</button>
        <button onclick="toggleMenu()">⚙️</button>

        <!-- Profile -->
        <a href="profile.php">
            <img src="../assets/images/<?php echo $user['profile_pic']; ?>" 
            style="width:30px;height:30px;border-radius:50%;">
        </a>

        <!-- MENU -->
        <div id="menu" class="menu">
            <a href="profile.php">Profile</a>
            <a href="#" onclick="logoutUser()" style="color:red;">Logout</a>
        </div>
    </div>
</div>

<!-- USERS -->
<div class="users">

<?php while ($row = mysqli_fetch_assoc($query)) { ?>

    <div class="user" onclick="openChat('<?php echo $row['username']; ?>')">

        <img src="../assets/images/<?php echo $row['profile_pic']; ?>" class="avatar">

        <div class="name">
            <?php echo $row['username'] ?: $row['name']; ?>
        </div>

        <div class="status <?php echo $row['status']; ?>"></div>

    </div>

<?php } ?>

</div>

<script>
// MENU
function toggleMenu() {
    let menu = document.getElementById("menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// LOGOUT
function logoutUser() {
    if (confirm("Logout?")) {
        window.location.href = "logout.php";
    }
}

// CLOSE MENU
window.onclick = function(e) {
    if (!e.target.closest(".controls")) {
        document.getElementById("menu").style.display = "none";
    }
}

// CHAT
function openChat(user) {
    window.location.href = "chat.php?user=" + user;
}

// THEME
const toggleBtn = document.getElementById("themeToggle");

window.onload = () => {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
        toggleBtn.textContent = "☀️";
    }
};

toggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        toggleBtn.textContent = "☀️";
    } else {
        localStorage.setItem("theme", "light");
        toggleBtn.textContent = "🌙";
    }
});
</script>

</body>
</html>