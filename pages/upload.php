<?php
session_start();
include("../config/db.php");

$user = $_SESSION['user'];

if(isset($_FILES['profile_pic'])){
    
    $file = $_FILES['profile_pic'];
    $filename = time() . "_" . $file['name'];
    $tempname = $file['tmp_name'];

    $folder = "../uploads/" . $filename;

    if(move_uploaded_file($tempname, $folder)){

        $sql = "UPDATE users SET profile_pic='$filename' WHERE name='$user'";
        $conn->query($sql);

        header("Location: profile.php");
        exit();
    } else {
        echo "Upload failed!";
    }
}
?>