<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // get user by email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // ✅ verify hashed password
        if (password_verify($password, $row['password'])) {

            $_SESSION['user'] = $email;

            mysqli_query($conn, "UPDATE users SET status='online' WHERE email='$email'");

            header("Location: home.php");
            exit();

        } else {
            echo "Wrong password!";
        }

    } else {
        echo "User not found!";
    }
}
?>