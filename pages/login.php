<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // run query
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // verify password (since you used password_hash in signup)
        if (password_verify($password, $row['password'])) {

            $_SESSION['user'] = $email;

            mysqli_query($conn, "UPDATE users SET status='online' WHERE email='$email'");

            header("Location: home.php");
            exit();

        } else {
            echo "Invalid password!";
        }

    } else {
        echo "User not found!";
    }
}
?>