<?php

$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}


$sql = "SELECT * FROM services";
$result = mysqli_query($connection, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Home Services Provider</title>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('../image/backg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            text-align: center;
            padding: 20px;
        }

        h1 {
            margin: 2rem 0;
        }

    
        .services-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .service-card {
            position: relative;
            width: 300px;
            height: 400px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: scale(1.05);
        }

        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .service-card * {
            position: relative;
            z-index: 2;
        }

        .icon-container i {
            font-size: 3rem;
            color: lightgreen;
        }

        .service-card h3 {
            margin: 10px 0;
            font-size: 24px;
        }

        .service-card p {
            font-size: 14px;
            padding: 0 10px;
        }

        .service-card a {
            margin-top: 10px;
            display: inline-block;
            color: lightgreen;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

       
        .search-container {
            margin-bottom: 30px;
            text-align: center;
        }

        .search-container input {
            padding: 10px;
            width: 50%;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .search-container button {
            padding: 10px 15px;
            background: #ff9800;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .search-container button:hover {
            background: #e68900;
        }

    </style>
</head>
<body>

    <h1>Available Services</h1>

    
    <div class="search-container">
        <form action="service.php" method="GET">
            <input type="text" name="search" placeholder="Search for a service..." required>
            <button type="submit">Search</button>
        </form>
    </div>

   
    <div class="services-container">
        <?php
        
        if (isset($_GET['search'])) {
            $search_query = mysqli_real_escape_string($connection, $_GET['search']);
            $sql = "SELECT * FROM services WHERE service_name LIKE '%$search_query%' OR location LIKE '%$search_query%'";
            $result = mysqli_query($connection, $sql);

            echo "<h2>Search Results for: '$search_query'</h2>";
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               
                $image = !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.jpg';

                echo "
                <div class='service-card' style='background-image: url(\"../image/$image\");'>
                    <div class='icon-container'><i class='fas fa-tools'></i></div>
                    <h3>" . htmlspecialchars($row['service_name']) . "</h3>
                    <p>" . htmlspecialchars($row['description']) . "</p>
                    <p><strong>Price:</strong> Ksh " . number_format($row['price']) . "</p>
                    <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                    <a href='check_login.php?redirect=" . urlencode("book_service.php?service_id=" . $row['service_id'] . "&provider_id=" . $row['provider_id']) . "'>Book Now</a>
            
                    <br>
                    <img src='../image/$image' alt='Service Image' style='width:100px; height:auto;'>
                </div>
            ";
            
            }
        } else {
            echo "<p>No services found.</p>";
        }

        mysqli_close($connection);
        ?>
    </div>

</body>
</html>
