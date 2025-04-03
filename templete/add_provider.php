<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $service_id = intval($_POST['service']); // Get selected service ID

    // Insert into providers table, referencing the services table
    $query = "INSERT INTO providers (provider_name, email, phone, service_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $service_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect to provider management page
        header("Location: manage_providers.php");
        exit();
    } else {
        die("Query preparation failed: " . mysqli_error($connection));
    }
}

// Fetch services from the database
$services_query = "SELECT id, service_name FROM services";
$services_result = mysqli_query($connection, $services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Provider</title>
</head>
<body>
    <h2>Add New Provider</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br><br>

        <label for="service">Service:</label>
        <select name="service" required>
            <option value="">Select a Service</option>
            <?php
            if (mysqli_num_rows($services_result) > 0) {
                while ($row = mysqli_fetch_assoc($services_result)) {
                    echo "<option value='{$row['id']}'>{$row['service_name']}</option>";
                }
            } else {
                echo "<option value=''>No services available</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Add Provider">
    </form>
    <br>
    <a href="admin_dashboard.php">Back to Provider Management</a>
</body>
</html>
