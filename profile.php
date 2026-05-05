<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ✅ FIXED PATH
include __DIR__ . "/config/db.php";

// ❗ Check DB connection
if (!$conn) {
    die("Database connection failed!");
}

// 🔒 Check session
if (!isset($_SESSION['user_id'])) {
    die("Session not found!");
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user safely
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}

$data = $result->fetch_assoc();

// ✅ Default image fallback
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

<script src="../assets/js/theme.js"></script>

</body>
</html>