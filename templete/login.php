<?php
session_start();
$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_name = trim($_POST['provider_name']);
    $password = trim($_POST['password']);

  
    $connection = mysqli_connect("localhost", "root", "", "homeservice");

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    
    $query = "SELECT password FROM providers WHERE provider_name = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $provider_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $stored_password);
        mysqli_stmt_fetch($stmt);

 
        if ($password === $stored_password) {
            $_SESSION['provider_username'] = $provider_name;
            header("Location: /homeservice/templete/provider_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "Invalid provider_name!";
    }

   
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: blueviolet;
            background: url('../image/backg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        .input-box {
            margin-bottom: 15px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .text a {
            color: #007bff;
            text-decoration: none;
        }

        .text a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Service Provider Login</h1>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="provider_name" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-box">
                <input type="submit" value="Login">
            </div>
            <div class="text">
                <h2>Don't have an account? <a href="provider_register.php">Register now</a></h2>
            </div>

            <?php if (!empty($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>
        </form>
    </div>
</body>
</html>