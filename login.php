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

    // 🔹 Get user by email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        // ✅ Verify password
        if (password_verify($password, $row['password'])) {

            // ⭐ IMPORTANT SESSION VALUES
            $_SESSION['user'] = $row['name'];      // for display
            $_SESSION['user_id'] = $row['id'];     // for DB operations
            $_SESSION['email'] = $row['email'];    // optional

            // 🔹 Update user status
            mysqli_query($conn, "UPDATE users SET status='online' WHERE id='{$row['id']}'");

            // 🔹 Redirect
            header("Location: /Project-Connectify/Connectify/home.php");
            exit();
        } else {
            echo "Wrong password!";
        }

    } else {
        echo "User not found!";
    }
}
?>