<?php
session_start();
include ("../config/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $hashed = password_hash($password, PASSWORD_DEFAULT);

  // check email
  $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){
    echo "Email already exists!";
  } else {
    $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if($stmt->execute()){
        header("Location: login.html"); // ✅ FIXED
        exit();
    } else {
        echo "Error occurred!";
    }
  }
}
?>