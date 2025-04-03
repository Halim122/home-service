<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_GET['redirect']; // Save intended page
    header("Location: client_login.php"); // Redirect to login
    exit();
}

// If already logged in, redirect to the booking page
header("Location: " . $_GET['redirect']);
exit();
?>
