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
$service_id = $_POST['service_id'];
$provider_id = $_POST['provider_id'];

// Check if payment is completed
$check_payment = "SELECT status FROM payments WHERE user_id='$user_id' AND service_id='$service_id' AND status='Paid'";
$result = mysqli_query($connection, $check_payment);
if (mysqli_num_rows($result) > 0) {
    // Proceed with booking
    $query = "INSERT INTO bookings (user_id, service_id, provider_id, status) VALUES ('$user_id', '$service_id', '$provider_id', 'Pending')";
    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Service booked successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error booking service.'); window.location='dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Payment not completed. Please pay first.'); window.location='book_service.php';</script>";
}

mysqli_close($connection);
?>
