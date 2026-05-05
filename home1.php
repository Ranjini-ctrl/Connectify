<?php
session_start();
include "../config/db1.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($res);

$query = mysqli_query($conn, "SELECT username, status, profile_pic FROM users");
?>
<!DOCTYPE html>
<html>
<head>
<title>Connectify</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #111;
}

/* HEADER */
.header {
    background: #2B124C;
    color: white;
    padding: 15px;
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* USER LIST */
.users {
    padding: 10px;
}

.user {
    display: flex;
    align-items: center;
    background: #1e1e1e;
    margin-bottom: 10px;
    padding: 12px;
    border-radius: 10px;
    color: white;
    cursor: pointer;
    gap: 10px;
}

/* PROFILE CIRCLE */
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

/* NAME */
.name {
    flex: 1;
}

/* STATUS DOT */
.status {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.online { background: green; }
.offline { background: gray; }

/* FOOTER */
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    text-align: center;
    padding: 10px;
}
</style>

</head>

<body>

<div class="header">
    <span>Connectify 💬</span>

    <a href="/connectify/pages/profile.php">
        <img src="../assets/images/<?php echo $user['profile_pic']; ?>" 
            style="width:30px; height:30px; border-radius:50%;">
    </a>
</div>

<div class="users">
<?php while ($row = mysqli_fetch_assoc($query)) { ?>

    <div class="user" onclick="openChat('<?php echo $row['username']; ?>')">

        <img src="../assets/images/<?php echo $row['profile_pic']; ?>" class="avatar">
        <div class="name">
            <?php echo $row['username']; ?>
        </div>

        <div class="status <?php echo $row['status']; ?>"></div>

    </div>

<?php } ?>
</div>

<div class="footer">
    <a href="logout.php" style="color:white;">Logout</a>
</div>

<script>
function openChat(user) {
    window.location.href = "chat.php?user=" + user;
}
</script>

</body>
</html>
