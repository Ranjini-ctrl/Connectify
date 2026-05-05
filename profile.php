<?php
session_start();
include "../config/db1.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

/* ================= UPDATE LOGIC ================= */
if (isset($_POST['update'])) {

    $username = trim($_POST['username']);

    // IMAGE
    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];

    // IMAGE UPDATE (with validation)
    if (!empty($image)) {

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            $imageName = time() . "_" . $image;

            move_uploaded_file($temp, "../assets/images/" . $imageName);

            mysqli_query($conn, "UPDATE users SET profile_pic='$imageName' WHERE email='$email'");

        } else {
            echo "<script>alert('Only JPG, JPEG, PNG allowed');</script>";
        }
    }

    // USERNAME UPDATE
    if (!empty($username)) {
        mysqli_query($conn, "UPDATE users SET username='$username' WHERE email='$email'");
    }

    echo "<script>alert('Profile Updated'); window.location='profile.php';</script>";
}

/* ================= FETCH USER ================= */
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom, #190019, #2B124C, #522B5B, #854F6C);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-box {
            background: #FBE4D8;
            padding: 30px;
            width: 320px;
            border-radius: 20px;
            text-align: center;
        }

        .profile-box img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        h2 {
            color: #2B124C;
        }

        p {
            color: #522B5B;
            margin: 8px 0;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            background: #2B124C;
            color: #FBE4D8;
            padding: 8px 15px;
            border-radius: 8px;
        }

        a:hover {
            background: #190019;
        }

        button {
            margin-top: 10px;
            padding: 8px 12px;
            border: none;
            background: #2B124C;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #190019;
        }

        input {
            width: 90%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

<div class="profile-box">

    <!-- PROFILE IMAGE -->
    <img src="../assets/images/<?php echo $user['profile_pic'] ?: 'default.png'; ?>">

    <!-- NAME -->
    <h2><?php echo $user['username']; ?></h2>

    <!-- EMAIL -->
    <p><?php echo $user['email']; ?></p>

    <!-- BACK -->
    <a href="home1.php">⬅ Back</a>

    <br><br>

    <!-- EDIT BUTTON -->
    <button onclick="showEdit()">✏️ Edit Profile</button>

    <!-- EDIT FORM -->
    <div id="editBox" style="display:none; margin-top:15px;">

        <form method="POST" enctype="multipart/form-data">

            <!-- pre-filled name -->
            <input type="text" name="username" value="<?php echo $user['username']; ?>">

            <input type="file" name="image">

            <button type="submit" name="update">Save</button>

        </form>

    </div>

</div>

<script>
function showEdit() {
    document.getElementById("editBox").style.display = "block";
}
</script>

</body>
</html>
