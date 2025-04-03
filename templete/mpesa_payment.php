<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: client_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Pesa Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            text-align: center;
            padding: 20px;
        }
        .payment-container {
            background-color: white;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #28a745;
        }
        .payment-instructions p {
            text-align: left;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h3>Make Payment via M-Pesa</h3>
    <div class="payment-instructions">
        <p><strong>Go to M-Pesa on your phone</strong></p>
        <p>1. Select <b>Lipa na M-Pesa</b></p>
        <p>2. Select <b>Send Money</b></p>
        <p>3. Enter Phone Number: <b>0712345678</b></p>
        <p>4. Enter Amount: <b>KES </b></p>
        <p>5. Enter your M-Pesa PIN and Confirm</p>
        <p>6. After payment, enter the transaction code below:</p>

        <form action="confirm_payment.php" method="POST">
            <div class="form-group">
                <label>Transaction Code:</label>
                <input type="text" name="mpesa_code" required>
            </div>
            <button type="submit">Confirm Payment</button>
        </form>
    </div>
</div>

</body>
</html>
