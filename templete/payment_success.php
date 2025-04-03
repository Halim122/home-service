<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: client_login.php");
    exit();
}

$service_id = $_GET['service_id'];
$provider_id = $_GET['provider_id'];

// Connect to DB and mark payment as completed
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "INSERT INTO payments (user_id, service_id, provider_id, payment_status) VALUES (?, ?, ?, 'Completed')";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "iii", $_SESSION['user_id'], $service_id, $provider_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($connection);

echo "<h3>Payment Successful! Your booking is confirmed.</h3>";
?>
