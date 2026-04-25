<?php
session_start();

// Remove all session variables
$_SESSION = [];

// Destroy session
session_destroy();

echo "Logout success";
?>