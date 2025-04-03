<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if provider ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fix: Correct column name from `id` → `provider_id`
    $query = "DELETE FROM providers WHERE provider_id = ?";
    $stmt = mysqli_prepare($connection, $query);

    // Check if statement prepared successfully
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die("Query preparation failed: " . mysqli_error($connection));
    }

    // Redirect after deletion
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error: Provider ID not provided.";
}
?>
