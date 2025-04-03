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

// Fetch dashboard statistics
$clients_count = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS count FROM clients"))['count'];
$providers_count = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS count FROM providers"))['count'];
$visitors_count = 1225; // Example static visitor count
$bookings_count = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS count FROM bookings"))['count'];

// Fetch bookings data
$query = "SELECT bookings.*, clients.username AS client_name, services.service_name 
          FROM bookings 
          JOIN clients ON bookings.user_id = clients.user_id 
          JOIN services ON bookings.service_id = services.service_id";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .sidebar { background: #f44336; height: 100vh; padding-top: 20px; position: fixed; width: 200px; }
        .sidebar a { color: white; display: block; padding: 15px; text-decoration: none; }
        .sidebar a:hover { background: #d32f2f; }
        .main-content { margin-left: 220px; padding: 20px; }
        .card-panel { padding: 15px; }
        .chart-container { width: 100%; height: 300px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5 class="white-text center-align">Admin Panel</h5>
        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="admin_booking.php"><i class="fas fa-calendar-check"></i> Manage Bookings</a>
        <a href="manage_clients.php"><i class="fas fa-users"></i> Manage Clients</a>
        <a href="manage_providers.php"><i class="fas fa-user-tie"></i> Manage Providers</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col s3">
                <div class="card-panel red white-text"><h6>Clients</h6><h4><?php echo $clients_count; ?></h4></div>
            </div>
            <div class="col s3">
                <div class="card-panel blue white-text"><h6>Providers</h6><h4><?php echo $providers_count; ?></h4></div>
            </div>
            <div class="col s3">
                <div class="card-panel green white-text"><h6>Visitors</h6><h4><?php echo $visitors_count; ?></h4></div>
            </div>
            <div class="col s3">
                <div class="card-panel orange white-text"><h6>Booked Services</h6><h4><?php echo $bookings_count; ?></h4></div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h5>Graphical Insights</h5>
                    <div class="chart-container">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h5>Manage Bookings</h5>
                    <table class="striped responsive-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                    <td>
                                        <form class="update-form">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                            <select name="status" class="browser-default">
                                                <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                                                <option value="Confirmed" <?php if ($row['status'] == "Confirmed") echo "selected"; ?>>Confirmed</option>
                                                <option value="Cancelled" <?php if ($row['status'] == "Cancelled") echo "selected"; ?>>Cancelled</option>
                                                <option value="Completed" <?php if ($row['status'] == "Completed") echo "selected"; ?>>Completed</option>
                                            </select>
                                            <button type="submit" class="btn blue action-btn">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('dashboardChart').getContext('2d');
            var dashboardChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Clients', 'Providers', 'Visitors', 'Booked Services'],
                    datasets: [{
                        label: 'Count',
                        data: [<?php echo $clients_count; ?>, <?php echo $providers_count; ?>, <?php echo $visitors_count; ?>, <?php echo $bookings_count; ?>],
                        backgroundColor: ['red', 'blue', 'green', 'orange']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</body>
</html>
