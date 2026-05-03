<?php
session_start();
include("../config/db.php");

// Check session
if (!isset($_SESSION['user'])) {
    die("Session not found!");
}

$user_id = $_SESSION['user_id'];

if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){

    $file = $_FILES['profile_pic'];

    // Generate unique filename
    $filename = time() . "_" . basename($file['name']);
    $tempname = $file['tmp_name'];

    $folder = "../uploads/" . $filename;

    // 🔹 Move uploaded file
    if(move_uploaded_file($tempname, $folder)){

        // 🔹 (Optional) Get old image and delete it
        $getOld = $conn->query("SELECT profile_pic FROM users WHERE id='$user_id'");
        if($getOld && $getOld->num_rows > 0){
            $row = $getOld->fetch_assoc();
            $oldPic = $row['profile_pic'];

            if($oldPic && file_exists("../uploads/".$oldPic)){
                unlink("../uploads/".$oldPic); // delete old image
            }
        }

        // 🔹 Update DB
        $sql = "UPDATE users SET profile_pic='$filename' WHERE id='$user_id'";

        if($conn->query($sql)){
            // ✅ Redirect without echo
            header("Location: profile.php?success=1");
            exit();
        } else {
            echo "DB Error: " . $conn->error;
        }

    } else {
        echo "Upload failed";
    }
}
?>