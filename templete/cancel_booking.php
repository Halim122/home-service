<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    $query = "UPDATE bookings SET status='Cancelled' WHERE booking_id='$booking_id' AND status='Pending'";
    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Booking cancelled successfully!'); window.location='client_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error cancelling booking.'); window.location='client_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='client_dashboard.php';</script>";
}

mysqli_close($connection);
?>
