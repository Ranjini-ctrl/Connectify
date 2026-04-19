<?php
$conn = new mysqli("localhost","root","","connectify");

// check connection
if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // hash password
  $hashed = password_hash($password, PASSWORD_DEFAULT);

  // check email exists (prepared statement)
  $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){
    $msg = "Email already exists!";
  } else {
    // insert user
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

<!DOCTYPE html>
<html>
<head>
  <title>Signup to Connectify</title>
  <style>
    body {
      color: #f09953;
      font-family: Arial;
      background: #f1dff1;
      text-align: center;
    }
    form {
      margin-top: 80px;
    }
    input {
      padding: 10px;
      margin: 10px;
      width: 250px;
      border: none;
      border-radius: 5px;
    }
    button {
      border-radius: 10px;
      padding: 10px 20px;
      background: #61f8b1;
      border: none;
      cursor: pointer;
    }
    p { color: red; }
  </style>
</head>
<body>

<h2>Signup to Connectify..</h2>

<form method="POST" onsubmit="return validateForm()">
  <input type="text" name="name" id="name" placeholder="Name"><br>
  <input type="email" name="email" id="email" placeholder="Email"><br>
  <input type="password" name="password" id="password" placeholder="Password"><br>
  <input type="password" id="confirm" placeholder="Confirm Password"><br>
  <button type="submit">Signup</button>
</form>

<p id="error"><?php echo $msg; ?></p>

<script>
function validateForm(){
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let pass = document.getElementById("password").value;
  let confirm = document.getElementById("confirm").value;
  let error = document.getElementById("error");

  if(name=="" || email=="" || pass=="" || confirm==""){
    error.innerText = "All fields required!";
    return false;
  }

  if(pass.length < 6){
    error.innerText = "Password must be at least 6 characters";
    return false;
  }

  if(pass !== confirm){
    error.innerText = "Passwords do not match";
    return false;
  }

  return true;
}
</script>

</body>
</html>