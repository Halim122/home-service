<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "homeservice");

if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    $stmt = $connection->prepare("UPDATE bookings SET status=?, payment_status=? WHERE booking_id=?");
    $stmt->bind_param("ssi", $status, $payment_status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location='admin_booking.php';</script>";
    } else {
        echo "<script>alert('Error updating booking.');</script>";
    }
    $stmt->close();
}

$query = "SELECT bookings.*, clients.username AS client_name, services.service_name 
          FROM bookings 
          JOIN clients ON bookings.user_id = clients.user_id 
          JOIN services ON bookings.service_id = services.service_id";

$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007BFF; color: white; }
        .update-btn, .delete-btn { padding: 5px 10px; border: none; cursor: pointer; }
        .update-btn { background-color: green; color: white; }
        .delete-btn { background-color: red; color: white; }
    </style>
</head>
<body>
    <h2>Manage Bookings</h2>
    <table>
        <tr>
            <th>Client</th>
            <th>Service</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Action</th>
            
        </tr>
        
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['client_name']); ?></td>
            <td><?= htmlspecialchars($row['service_name']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['booking_id']; ?>">
                    <select name="status">
                        <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Confirmed" <?= $row['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Cancelled" <?= $row['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
            </td>
            <td>
                    <select name="payment_status">
                        <option value="Pending" <?= $row['payment_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Paid" <?= $row['payment_status'] == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                        <option value="Failed" <?= $row['payment_status'] == 'Failed' ? 'selected' : ''; ?>>Failed</option>
                    </select>
                    <button type="submit" name="update" class="update-btn">Update</button>
                </form>
            </td>
            <td>
                <form method="POST" action="delete_booking.php" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                    <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $connection->close(); ?>
