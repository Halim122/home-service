<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if provider ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch provider details and their service
    $query = "SELECT p.provider_id, p.provider_name, p.email, p.phone, 
                     s.service_id, s.service_name, s.description, s.price, s.location, s.category
              FROM providers p
              LEFT JOIN services s ON p.provider_id = s.provider_id
              WHERE p.provider_id = ?";

    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $provider = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$provider) {
            die("Provider not found.");
        }
    } else {
        die("Query preparation failed: " . mysqli_error($connection));
    }
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $location = trim($_POST['location']);
    $category = trim($_POST['category']);

    // Update provider details
    $query = "UPDATE providers SET provider_name = ?, email = ?, phone = ? WHERE provider_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die("Provider update failed: " . mysqli_error($connection));
    }

    // Update provider's service
    $query = "UPDATE services SET service_name = ?, description = ?, price = ?, location = ?, category = ? 
              WHERE provider_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdssi", $service_name, $description, $price, $location, $category, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect after update
        header("Location: manage_providers.php");
        exit();
    } else {
        die("Service update failed: " . mysqli_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Provider</title>
</head>
<body>
    <h2>Edit Provider</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($provider['provider_id']); ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($provider['provider_name']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($provider['email']); ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($provider['phone']); ?>" required><br><br>

        <h3>Service Details</h3>
        <label for="service_name">Service Name:</label>
        <input type="text" name="service_name" value="<?= htmlspecialchars($provider['service_name']); ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" required><?= htmlspecialchars($provider['description']); ?></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($provider['price']); ?>" required><br><br>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($provider['location']); ?>" required><br><br>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($provider['category']); ?>" required><br><br>

        <input type="submit" value="Update Provider">
    </form>
    <br>
    <a href="admin_dashboard.php">Back to Provider Management</a>
</body>
</html>
