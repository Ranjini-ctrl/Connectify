<?php
session_start();
include("../config/db.php");

// Check session
if (!isset($_SESSION['user'])) {
    echo "Session not found!";
    exit();
}

$user = $_SESSION['user'];

if(isset($_FILES['profile_pic'])){

    $file = $_FILES['profile_pic'];

    // 🔹 File info
    $filename = time() . "_" . $file['name'];
    $tempname = $file['tmp_name'];

    // 🔹 Upload path
    $folder = "../uploads/" . $filename;

    // 🔹 Move file to uploads folder
    if(move_uploaded_file($tempname, $folder)){

        // 🔹 Save filename in DB
        $sql = "UPDATE users SET profile_pic='$filename' WHERE name='$user'";

        if($conn->query($sql)){
            echo "✅ File uploaded + DB updated";

            // Redirect after success
            header("Location: profile.php");
            exit();

        } else {
            echo "❌ DB Error: " . $conn->error;
        }

    } else {
        echo "❌ Upload failed";
    }
}
?>