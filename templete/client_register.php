<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    if (empty($username) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        echo "All fields are required!";
    } else {
        
        $query = "INSERT INTO clients (username, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);

        if (!$stmt) {
            die("MySQL Prepare Error: " . mysqli_error($connection));
        }

        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $password, $phone, $address);

        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful! <a href='client_login.php'>Login here</a>";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            background: url('../image/backg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success {
            color: green;
            margin-top: 15px;
        }

        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register as a Client</h2>
        <form method="POST" action="client_register.php">
    <label>Full Name:</label>
    <input type="text" name="username" placeholder="Enter your full name" required><br>

    <label>Email Address:</label>
    <input type="email" name="email" placeholder="Enter your email" required><br>

    <label>Password:</label>
    <input type="password" name="password" placeholder="Enter a password" required><br>

    <label>Phone Number:</label>
    <input type="text" name="phone" placeholder="Enter your phone number" required><br>

    <label>Address:</label>
    <input type="text" name="address" placeholder="Enter your address" required><br>

    <input type="submit" value="Register">
</form>

    </div>
</body>
</html>
