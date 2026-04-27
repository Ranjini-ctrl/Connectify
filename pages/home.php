<?php
session_start();
include "config/db.php";

// Check login
if (!isset($_SESSION['user'])) {
    header("Location: pages/login.php");
    exit();
}

// Fetch users
$query = mysqli_query($conn, "SELECT username, status FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connectify</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom,#190019,#2B124C,#522B5B,#854F6C);
        }

        /* NAVBAR */
        nav {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            background: #2c3e50;
            color: white;
        }

        /* MAIN BOX */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
        }

        .home-box {
            background: #FBE4D8;
            padding: 25px;
            width: 350px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        h2 { color: #2B124C; }
        p { color: #522B5B; }

        .user {
            margin-top: 8px;
            padding: 10px;
            background: #DFB6B2;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
        }

        .online { background: green; }
        .offline { background: gray; }

        /* Dropdown */
        .menu {
            display: none;
            position: absolute;
            right: 10px;
            top: 50px;
            background: white;
            color: black;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }

        .menu a:hover {
            background: #eee;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <h2>Connectify</h2>

    <div style="position:relative;">
        <button onclick="toggleMenu()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
            ⚙️
        </button>

        <div id="menu" class="menu">
            <a href="profile.php">Profile</a>
            <a href="#" onclick="logoutUser()" style="color:red;">Logout</a>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">
    <div class="home-box">
        <h2>Welcome 🎉</h2>
        <p>Hello, <?php echo $_SESSION['user']; ?> 👋</p>

        <h3>Users</h3>

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="user">
                <span><?php echo $row['username']; ?></span>
                <span class="status-dot <?php echo $row['status']; ?>"></span>
            </div>
        <?php } ?>
    </div>
</div>

<script>
// Toggle dropdown
function toggleMenu() {
    let menu = document.getElementById("menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// Logout
function logoutUser() {
    if (confirm("Logout?")) {
        window.location.href = "pages/logout.php"; // simple and reliable
    }
}

// Close menu
window.onclick = function(e) {
    if (!e.target.closest("button")) {
        document.getElementById("menu").style.display = "none";
    }
}
</script>

</body>
</html>