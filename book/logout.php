<?php 
session_start();
include("connection.php");

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page or login page
header('Location: index.php');
exit();
?>
