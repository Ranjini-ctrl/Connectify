<?php
session_start();
include("../config/db.php");

$msg = "";

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
    $msg = "Email already exists!";
  } else {
    $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if($stmt->execute()){
      echo "<script>
              alert('Signup Successful!');
              window.location='login.php';
            </script>";
      exit;
    } else {
      $msg = "Error occurred!";
    }
  }
}
?>