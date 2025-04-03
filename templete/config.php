<?php
$connection = mysqli_connect("localhost", "root", "", "homeservice");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "homeservice";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

