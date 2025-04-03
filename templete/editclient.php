<?php

// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if client ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch client details
    $query = "SELECT * FROM clients WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $client = mysqli_fetch_assoc($result);

    if (!$client) {
        die("Client not found.");
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Update client information
    $query = "UPDATE clients SET username = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $phone, $address, $id);
    mysqli_stmt_execute($stmt);

    // Redirect to manage clients page
    header("Location: manage_clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
</head>
<body>
    <h2>Edit Client</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $client['user_id']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($client['username']); ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($client['email']); ?>" required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($client['phone']); ?>" required><br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($client['address']); ?>" required><br><br>
        <input type="submit" value="Update Client">
    </form>
    <br>
    <a href="admin_dashboard.php">Back to Clients</a>
</body>
</html>
