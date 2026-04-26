<?php
session_start();
include "db.php";

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
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid email or password!";
    }
}
?>