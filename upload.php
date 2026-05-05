<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ✅ FIXED DB PATH
include __DIR__ . "/config/db.php";

// 🔒 Check login
if (!isset($_SESSION['user_id'])) {
    die("Session not found!");
}

$user_id = $_SESSION['user_id'];

// 📁 File upload check
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

    $file = $_FILES['profile_pic'];

    // 📌 File details
    $filename = time() . "_" . basename($file['name']);
    $tempname = $file['tmp_name'];

    // ✅ FIXED upload path
    $uploadPath = __DIR__ . "/uploads/";
    $folder = $uploadPath . $filename;

    // ✅ Ensure uploads folder exists
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    // ✅ Move file
    if (move_uploaded_file($tempname, $folder)) {

        // 🔍 Get old profile pic
        $result = $conn->query("SELECT profile_pic FROM users WHERE id='$user_id'");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldPic = $row['profile_pic'];

            // 🗑️ Delete old file
            if (!empty($oldPic) && file_exists($uploadPath . $oldPic)) {
                unlink($uploadPath . $oldPic);
            }
        }

        // 💾 Update DB
        $sql = "UPDATE users SET profile_pic='$filename' WHERE id='$user_id'";

        if ($conn->query($sql)) {
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