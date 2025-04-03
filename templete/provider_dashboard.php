<?php
session_start();


if (!isset($_SESSION['provider_username'])) {
    header("Location:login.php");
    exit();
}

$provider_username = $_SESSION['provider_username'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    
    if (empty($service_name) || empty($description) || empty($price) || empty($location)) {
        $error_message = "All fields are required!";
    } else {
      
        $connection = mysqli_connect("localhost", "root", "", "homeservice");

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

       
        $query = "INSERT INTO services (provider_username, service_name, description, price, location) 
                  VALUES ('$provider_username', '$service_name', '$description', '$price', '$location')";

        if (mysqli_query($connection, $query)) {
            $success_message = "Service posted successfully!";
        } else {
            $error_message = "Failed to post service.";
        }

    
        mysqli_close($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Your Service</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            background: url('../image/backg.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: #333;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 500px;
            margin: 50px auto;
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

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            height: 150px;
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

        .error, .success {
            color: red;
            font-size: 1rem;
            margin-top: 10px;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Post Your Service</h1>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="service_name" placeholder="Service Name" required>
            </div>
            <div class="input-box">
                <textarea name="description" placeholder="Service Description" required></textarea>
            </div>
            <div class="input-box">
                <input type="text" name="price" placeholder="Price" required>
            </div>
            <div class="input-box">
                <input type="text" name="location" placeholder="Location" required>
            </div>
            <div class="input-box">
                <input type="submit" value="Post Service">
            </div>

            <?php if (isset($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>
            <?php if (isset($success_message)) { echo "<div class='success'>$success_message</div>"; } ?>
        </form>
    </div>
</body>
</html>
