<?php
session_start();
session_destroy(); // Destroy session
header("Location: client_login.php"); // Redirect to login page
exit();
?>
