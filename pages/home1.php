<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

// get all users
$query = mysqli_query($conn, "SELECT username, status FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(
                to bottom,
                #190019,
                #2B124C,
                #522B5B,
                #854F6C
            );
        }

        .home-box {
            background: #FBE4D8;
            padding: 30px;
            width: 350px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 420px;
        }

        h2 {
            color: #2B124C;
        }

        p {
            color: #522B5B;
        }

        h3 {
            margin-top: 10px;
            color: #2B124C;
        }

        .user {
            margin-top: 8px;
            padding: 10px;
            background: #DFB6B2;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 🔥 Status dot */
        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
        }

        .online {
            background: green;
        }

        .offline {
            background: gray;
        }

        .logout-btn {
            text-align: center;
        }

        .logout-btn a {
            text-decoration: none;
            color: white;
            background: #2B124C;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .logout-btn a:hover {
            background: #190019;
        }
    </style>
</head>

<body>

<div class="home-box">

    <div>
        <h2>Welcome to Connectify 🎉</h2>

        <p>Hello, <?php echo $_SESSION['user']; ?> 👋</p>

        <h3>Users</h3>

        <?php
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
            <div class="user">
                <span><?php echo $row['username']; ?></span>

                <span class="status-dot <?php echo $row['status']; ?>"></span>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Logout at bottom -->
    <div class="logout-btn">
        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>