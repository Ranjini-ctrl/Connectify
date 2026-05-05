<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/db1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $email;

        mysqli_query($conn, "UPDATE users SET status='online' WHERE email='$email'");

        header("Location: ../pages/home1.php");
        exit();
    } else {
        echo "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connectify Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
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

        .login-box {
            background: #FBE4D8;
            padding: 40px;
            width: 320px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        h2 {
            color: #2B124C;
            margin-bottom: 10px;
        }

        p {
            color: #854F6C;
            font-size: 14px;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 10px;
            background: #DFB6B2;
            color: #190019;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            background: #ffffff;
        }

        ::placeholder {
            color: #522B5B;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 10px;
            background: #2B124C;
            color: #FBE4D8;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #190019;
        }

        .login-box {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Connectify</h2>
    <p>Login to continue</p>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
<div style="position: relative;">
        <input type="password" id="password" name="password" placeholder="Enter Password" required>

        <span onclick="togglePassword()" 
          style="position: absolute; right: 10px; top: 12px; cursor: pointer;">
        👁️
        </span>
</div>
        <button type="submit">Login</button>
    </form>
</div>
<script>
function togglePassword() {
    let pass = document.getElementById("password");

    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}
</script>
</body>
</html>
