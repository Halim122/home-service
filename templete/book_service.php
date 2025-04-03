<?php
session_start(); // Start session

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: client_login.php");
    exit();
}

// Database connection
$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$provider_id = isset($_GET['provider_id']) ? $_GET['provider_id'] : '';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .booking-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h3 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-book {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-book:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <h3>Proceed to Payment</h3>

    <form action="mpesa_payment.php" method="POST">
        <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service_id); ?>">
        <input type="hidden" name="provider_id" value="<?php echo htmlspecialchars($provider_id); ?>">
        
        <h3>Enter Payment Details</h3>
        <input type="text" name="phone_number" placeholder="Enter MPesa phone number" required>
        <input type="text" name="amount" placeholder="Enter amount" required>

        <button type="submit" class="btn-book">Pay & Proceed</button>
    </form>

    <a href="homepage.php" class="back-link">← Back to Home</a>
</div>

</body>
</html>
