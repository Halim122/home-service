<?php
session_start();
$error_message = "";


error_reporting(E_ALL);
ini_set('display_errors', 1);


$connection = mysqli_connect("localhost", "root", "", "homeservice");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

   
    $query = "SELECT id, password FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die("Database error: " . mysqli_error($connection)); 
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $admin_id, $stored_password);
        mysqli_stmt_fetch($stmt);

      
        if ($password === $stored_password) {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $username;

            
            mysqli_stmt_close($stmt);
            mysqli_close($connection);

            
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "Username not found!";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Home Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            color: #333;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
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

        .error {
            color: #e74c3c;
            font-size: 1rem;
            margin-top: 10px;
        }

        .login-container a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: 600;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Admin Login</h1>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>

        
        <?php if (!empty($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <a href="forgot_password.php">Forgot Password?</a>
    </div>

</body>
</html>
