<?php

// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if client ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete client
    $query = "DELETE FROM clients WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Redirect to manage clients page
    header("Location: admi_dashboard.php");
    exit();
}
?>
