<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 🔒 Session check
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// ✅ FIXED PATH (change if needed)
include __DIR__ . "/config/db.php";

// ❗ Check DB connection
if (!$conn) {
    die("Database connection failed!");
}

// ✅ Fetch users
$query = mysqli_query($conn, "SELECT name, status FROM users");

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
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom,#190019,#2B124C,#522B5B,#854F6C);
            color: black;
        }

        body.dark-mode {
            background: #121212;
            color: white;
        }

        nav {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            background: #2c3e50;
            color: white;
        }

        body.dark-mode nav {
            background: #1f1f1f;
        }

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
        }

        body.dark-mode .home-box {
            background: #1e1e1e;
        }

        .user {
            margin-top: 8px;
            padding: 10px;
            background: #DFB6B2;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
        }

        body.dark-mode .user {
            background: #2a2a2a;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
        }

        .online { background: green; }
        .offline { background: gray; }

        .menu {
            display: none;
            position: absolute;
            right: 10px;
            top: 50px;
            background: white;
            border-radius: 8px;
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
    </style>
</head>

<body>

<nav>
    <h2>Connectify</h2>

    <div style="display:flex; align-items:center; gap:10px; position:relative;">
        <button id="themeToggle">🌙</button>
        <button onclick="toggleMenu()">⚙️</button>

        <div id="menu" class="menu">
            <a href="profile.php">Profile</a>
            <a href="#" onclick="logoutUser()" style="color:red;">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="home-box">
        <h2>Welcome 🎉</h2>
        <p>Hello, <?php echo $_SESSION['user']; ?> 👋</p>

        <h3>Users</h3>

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="user">
                <span><?php echo $row['name']; ?></span>
                <span class="status-dot <?php echo $row['status']; ?>"></span>
            </div>
        <?php } ?>
    </div>
</div>

<script>
function toggleMenu() {
    let menu = document.getElementById("menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

function logoutUser() {
    if (confirm("Logout?")) {
        window.location.href = "logout.php";
    }
}

window.onclick = function(e) {
    if (!e.target.closest("button")) {
        document.getElementById("menu").style.display = "none";
    }
}

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