<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: client_login.php");
    exit();
}


$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];


$query = "SELECT bookings.*, services.service_name, services.price, services.image, providers.provider_name 
          FROM bookings 
          JOIN services ON bookings.service_id = services.service_id 
          JOIN providers ON bookings.provider_id = providers.provider_id 
          WHERE bookings.user_id = '$user_id' 
          ORDER BY bookings.booking_id DESC";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - My Bookings</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f9;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background: #007bff;
            color: white;
        }

        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .pending { background: #ffc107; color: black; }
        .confirmed { background: #28a745; color: white; }
        .completed { background: #17a2b8; color: white; }
        .cancelled { background: #dc3545; color: white; }

        .cancel-btn {
            padding: 8px 12px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #a71d2a;
        }

        .logout-btn {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            background: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: #0056b3;
        }

    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>My Bookings</h2>

        <table>
            <tr>
                <th>Service</th>
                <th>Provider</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['provider_name']); ?></td>
                    <td>Ksh <?php echo number_format($row['price']); ?></td>
                    <td>
                        <span class="status 
                            <?php 
                                echo ($row['status'] == 'Pending') ? 'pending' : 
                                     (($row['status'] == 'Confirmed') ? 'confirmed' : 
                                     (($row['status'] == 'Completed') ? 'completed' : 'cancelled'));
                            ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <a href="cancel_booking.php?booking_id=<?php echo $row['booking_id']; ?>" class="cancel-btn">Cancel</a>
                        <?php } else { ?>
                            <span style="color: gray;">N/A</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>

<?php mysqli_close($connection); ?>
