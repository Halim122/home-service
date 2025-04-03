<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: client_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $service_id = $_POST['service_id'];
    $provider_id = $_POST['provider_id'];
    $price = $_POST['price'];

    if ($payment_method === "mpesa") {
        // M-Pesa API integration (not working now)
        echo "<p>M-Pesa is currently unavailable. Please try PayPal.</p>";
        echo "<a href='process_payment.php?payment_method=paypal&service_id=$service_id&provider_id=$provider_id&price=$price'>Pay with PayPal</a>";
    } elseif ($payment_method === "paypal") {
        header("Location: paypal_payment.php?service_id=$service_id&provider_id=$provider_id&price=$price");
        exit();
    } else {
        echo "Invalid Payment Method!";
    }
}
?>
