<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: client_login.php");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$service_id = $_GET['service_id'];
$provider_id = $_GET['provider_id'];

// Check if payment was made
$payment_check = "SELECT * FROM payments WHERE user_id='$user_id' AND service_id='$service_id' AND provider_id='$provider_id' AND status='Paid'";
$result = mysqli_query($connection, $payment_check);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('You must complete the payment before booking.'); window.location='book_service.php';</script>";
    exit();
}

// Insert into bookings table if payment is verified
$booking_query = "INSERT INTO bookings (user_id, service_id, provider_id, status) VALUES ('$user_id', '$service_id', '$provider_id', 'Pending')";

if (mysqli_query($connection, $booking_query)) {
    echo "<script>alert('Service booked successfully!'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('Error booking service.'); window.location='dashboard.php';</script>";
}

mysqli_close($connection);
?>
