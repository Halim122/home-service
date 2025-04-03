<?php

// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Insert client data
    $query = "INSERT INTO clients (username, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $address);
    mysqli_stmt_execute($stmt);

    // Redirect after successful addition
    header("Location: manage_clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
</head>
<body>
    <h2>Add New Client</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" required><br><br>
        <input type="submit" value="Add Client">
    </form>
    <br>
    <a href="manage_clients.php">Back to Client Management</a>
</body>
</html>
