//for secure home page
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
//homepage
<!-- NAVBAR -->
<nav style="display:flex; justify-content:space-between; padding:10px; background:#2c3e50; color:white;">
    <h2>Connectify</h2>

    <!-- Settings Dropdown -->
    <div style="position:relative;">
        <button onclick="toggleMenu()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
            ⚙️
        </button>

        <!-- Dropdown Menu -->
        <div id="settingsMenu" style="display:none; position:absolute; right:0; background:white; color:black; min-width:150px; box-shadow:0 2px 8px rgba(0,0,0,0.2); border-radius:5px;">
            <a href="profile.html" style="display:block; padding:10px; text-decoration:none; color:black;">Profile</a>
            <a href="#" onclick="logoutUser()" style="display:block; padding:10px; text-decoration:none; color:red;">Logout</a>
        </div>
    </div>
</nav>

<script>
// Toggle dropdown
function toggleMenu() {
    let menu = document.getElementById("settingsMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// Logout function
function logoutUser() {
    if (confirm("Are you sure you want to logout?")) {
        fetch('logout.php', { method: 'POST' })
        .then(() => {
            window.location.href = "login.php";
        });
    }
}

// Close menu when clicking outside
window.onclick = function(e) {
    if (!e.target.matches('button')) {
        document.getElementById("settingsMenu").style.display = "none";
    }
}
</script>