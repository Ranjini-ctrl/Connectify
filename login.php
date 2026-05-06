<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ✅ FIXED PATH
include "config/db.php";

// ✅ Check DB
if (!$conn) {
    die("Database connection failed!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "All fields are required!";
    } else {

        // ✅ Fetch user
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {

            $user = mysqli_fetch_assoc($result);

            // ✅ Password verify
            if (password_verify($password, $user['password'])) {

                $_SESSION['user'] = $email;

                // ✅ Update status
                mysqli_query($conn, "UPDATE users SET status='online' WHERE email='$email'");

                header("Location: home.php");
                exit();

            } else {
                $error = "Invalid password!";
            }

        } else {
            $error = "User not found!";
        }
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
            background: linear-gradient(to bottom,#190019,#2B124C,#522B5B,#854F6C);
        }

        .login-box {
            background: #FBE4D8;
            padding: 40px;
            width: 320px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            animation: fadeIn 0.6s ease;
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
            font-size: 14px;
        }

        input:focus {
            background: #ffffff;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 10px;
            background: #2B124C;
            color: #FBE4D8;
            cursor: pointer;
        }

        button:hover {
            background: #190019;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 10px;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-eye {
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Connectify</h2>
    <p>Login to continue</p>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>

        <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <span class="toggle-eye" onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit">Login</button>

        <?php if (!empty($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
    </form>
</div>

<script>
function togglePassword() {
    let pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}
</script>

</body>
</html>