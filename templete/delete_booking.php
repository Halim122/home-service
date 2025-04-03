<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['booking_id'])) {
        $booking_id = $_POST['booking_id'];

        $query = "DELETE FROM bookings WHERE booking_id=?";
        $stmt = mysqli_prepare($connection, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $booking_id);
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to admin dashboard after successful deletion
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Error deleting booking.'); window.location='admin_booking.php';</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Database error: Unable to delete booking.'); window.location='admin_booking.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location='admin_booking.php';</script>";
    }
}
?>
