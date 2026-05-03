<?php
session_start();
include("../config/db.php");

// 🔒 Check login session
if (!isset($_SESSION['user_id'])) {
    die("Session not found!");
}

$user_id = $_SESSION['user_id'];

// 📁 Check file upload
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

    $file = $_FILES['profile_pic'];

    // 📌 File details
    $filename = time() . "_" . basename($file['name']);
    $tempname = $file['tmp_name'];
    $folder = "../uploads/" . $filename;

    // ✅ Move file to uploads folder
    if (move_uploaded_file($tempname, $folder)) {

        // 🔍 Get old profile picture
        $result = $conn->query("SELECT profile_pic FROM users WHERE id='$user_id'");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldPic = $row['profile_pic'];

            // 🗑️ Delete old image if exists
            if (!empty($oldPic) && file_exists("../uploads/" . $oldPic)) {
                unlink("../uploads/" . $oldPic);
            }
        }

        // 💾 Update new image in DB
        $sql = "UPDATE users SET profile_pic='$filename' WHERE id='$user_id'";

        if ($conn->query($sql)) {
            // 🔁 Redirect after success
            header("Location: profile.php?upload=success");
            exit();
        } else {
            echo "❌ Database Error: " . $conn->error;
        }

    } else {
        echo "❌ Failed to upload file!";
    }

} else {
    echo "❌ No file selected or file error!";
}
?>