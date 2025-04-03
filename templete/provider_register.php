<?php
session_start();


$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_name = trim($_POST['provider_name']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

   
    if (empty($provider_name) || empty($password) || empty($email) || empty($phone)) {
        $error_message = "All fields are required!";
    } else {
       
        $query = "SELECT * FROM providers WHERE provider_name = ?";
        $stmt = mysqli_prepare($connection, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $provider_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $error_message = "Username already exists. Choose another.";
            } else {
               
                $hashed_password = $password;  


               
                $insert_query = "INSERT INTO providers (provider_name, password, email, phone) VALUES (?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($connection, $insert_query);

                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, "ssss", $provider_name, $hashed_password, $email, $phone);
                    if (mysqli_stmt_execute($stmt_insert)) {
                        $success_message = "Registration successful! <a href='login.php'>Login here</a>";
                    } else {
                        $error_message = "Registration failed: " . mysqli_error($connection);
                    }
                    mysqli_stmt_close($stmt_insert);
                } else {
                    $error_message = "Database error: " . mysqli_error($connection);
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Database error: " . mysqli_error($connection);
        }
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center;            background: url('../image/backg.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: #333; }
        .wrapper { max-width: 400px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .input-box { margin-bottom: 15px; }
        input { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { background-color: #007bff; color: white; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register as a Service Provider</h2>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="provider_name" placeholder="Choose a Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Choose a Password" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" placeholder="Enter Phone Number" required>
            </div>
            <div class="input-box">
                <input type="submit" value="Register">
            </div>
            <?php if (isset($error_message)) echo "<div class='error'>$error_message</div>"; ?>
            <?php if (isset($success_message)) echo "<div class='success'>$success_message</div>"; ?>
        </form>
    </div>
</body>
</html>
