<?php
session_start();
include "config/db.php"; // ✅ FIXED PATH

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($name) || empty($email) || empty($password)) {
      $error = "All fields are required!";
  } else {

      $hashed = password_hash($password, PASSWORD_DEFAULT);

      // ✅ Check email exists
      $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $error = "Email already exists!";
      } else {

          $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
          $stmt->bind_param("sss", $name, $email, $hashed);

          if ($stmt->execute()) {
              header("Location: login.php"); // ✅ FIXED (.php)
              exit();
          } else {
              $error = "Error occurred!";
          }
      }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - Connectify</title>

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

        .signup-box {
            background: #FBE4D8;
            padding: 30px;
            width: 350px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            text-align: center;
        }

        h2 {
            color: #2B124C;
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            outline: none;
            background: #DFB6B2;
        }

        button {
            width: 95%;
            padding: 10px;
            margin-top: 15px;
            background: #2B124C;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #190019;
        }

        .link {
            margin-top: 15px;
            display: block;
            color: #522B5B;
            text-decoration: none;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="signup-box">
    <h2>Create Account</h2>

    <!-- ✅ Show error -->
    <?php if (!empty($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <!-- ✅ No need action -->
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Sign Up</button>
    </form>

    <!-- ✅ FIXED -->
    <a class="link" href="login.php">Already have an account? Login</a>
</div>

</body>
</html>