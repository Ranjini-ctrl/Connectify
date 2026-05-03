<?php
session_start();
include("../config/db.php");

// 🔒 Check session
if (!isset($_SESSION['user_id'])) {
    die("Session not found!");
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user using ID (FIXED)
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// ✅ Set profile image
$profilePic = !empty($data['profile_pic']) ? $data['profile_pic'] : "default.png";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>

<h2>Welcome, <?php echo $data['name']; ?></h2>

<!-- ✅ SHOW IMAGE -->
<img src="../uploads/<?php echo $profilePic; ?>" width="120" height="120">

<!-- ✅ Upload Form -->
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic" accept="image/*" required>
    <button type="submit">Upload</button>
</form>

<br><br>

<button onclick="toggleTheme()">Toggle Theme</button>

<script src="../assets/js/theme.js"></script>

</body>
</html>