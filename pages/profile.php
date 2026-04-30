<?php
session_start();
include("../config/db.php");

$user = $_SESSION['user'];

$sql = "SELECT * FROM users WHERE name='$user'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>

<h2>Welcome, <?php echo $user; ?></h2>

<img src="../uploads/<?php echo $data['profile_pic'] ?? 'default.png'; ?>" width="120">

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic" required>
    <button type="submit">Upload</button>
</form>

<br><br>

<button onclick="toggleTheme()">Toggle Theme</button>

<script src="../assets/js/theme.js"></script>

</body>
</html>