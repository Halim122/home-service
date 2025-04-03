<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all providers
$query = "SELECT provider_id, provider_name, email, phone FROM providers";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Providers</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        button { padding: 5px 10px; background-color: red; color: white; border: none; cursor: pointer; }
        button:hover { background-color: darkred; }
    </style>
</head>
<body>

<h2>Manage Providers</h2>

<a href="add_provider.php">
    <button style="background-color: green; color: white; padding: 10px;">Add New Provider</button>
</a>
<br><br>

<table>
    <tr>
        <th>Provider ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo isset($row['provider_id']) ? htmlspecialchars($row['provider_id']) : 'N/A'; ?></td>
            <td><?php echo isset($row['provider_name']) ? htmlspecialchars($row['provider_name']) : 'N/A'; ?></td>
            <td><?php echo isset($row['email']) ? htmlspecialchars($row['email']) : 'N/A'; ?></td>
            <td><?php echo isset($row['phone']) ? htmlspecialchars($row['phone']) : 'N/A'; ?></td>
            <td>
                <a href="edit_provider.php?id=<?php echo $row['provider_id']; ?>">Edit</a> | 
                <a href="delete_provider.php?id=<?php echo $row['provider_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
