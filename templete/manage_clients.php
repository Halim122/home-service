<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all clients
$query = "SELECT * FROM clients";
$result = mysqli_query($connection, $query);

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        button { padding: 5px 10px; background-color: green; color: white; border: none; cursor: pointer; }
        button:hover { background-color: darkgreen; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; font-weight: bold; color: blue; }
        nav a:hover { color: darkblue; }
    </style>
</head>
<body>

<!-- Navigation -->
<nav>
    <a href="admin_dashboard.php">Dashboard</a> |
    <a href="manage_clients.php">Manage Clients</a> |
    <a href="manage_providers.php">Manage Service Providers</a> |
    <a href="logout.php">Logout</a>
</nav>

<h2>Manage Clients</h2>

<!-- Button to add new client -->
<a href="addclient.php">
    <button>Add Client</button>
</a>

<table>
    <tr>
        <th>Client ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo isset($row['user_id']) ? htmlspecialchars($row['user_id']) : 'N/A'; ?></td>
            <td><?php echo isset($row['username']) ? htmlspecialchars($row['username']) : 'N/A'; ?></td>
            <td><?php echo isset($row['email']) ? htmlspecialchars($row['email']) : 'N/A'; ?></td>
            <td><?php echo isset($row['phone']) ? htmlspecialchars($row['phone']) : 'N/A'; ?></td>
            <td><?php echo isset($row['address']) ? htmlspecialchars($row['address']) : 'N/A'; ?></td>
            <td>
                <a href="editclient.php?id=<?php echo $row['user_id']; ?>">Edit</a> | 
                <a href="delete.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
