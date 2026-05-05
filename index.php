<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ✅ If already logged in → redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connectify</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-align: center;
        }

        .container {
            margin-top: 120px;
        }

        h1 {
            font-size: 50px;
            margin-bottom: 10px;
        }

        h2 {
            font-weight: normal;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 25px;
            margin: 10px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            background: white;
            color: #333;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ddd;
        }

        .about {
            margin-top: 100px;
            font-size: 14px;
            opacity: 0.8;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Connectify</h1>
    <h2>Connect. Chat. Stay safe.</h2>

    <!-- ✅ Navigation -->
    <a href="signup.php" class="btn">Sign Up</a>
    <a href="login.php" class="btn">Login</a>
</div>

<div class="about">
    <p>Connectify helps users communicate easily with safety and smart features.</p>
</div>

</body>
</html>