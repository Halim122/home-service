<?php
require 'db_config.php'; // Database connection
require 'vendor/autoload.php'; // Load Africa's Talking SDK

use AfricasTalking\SDK\AfricasTalking;

// Your Africa's Talking API credentials
$username = "sandbox"; // Change to your Africa's Talking username
$apiKey = "1CtkNns11"; // Get this from Africa's Talking dashboard

// Initialize Africa's Talking
$AT = new AfricasTalking($username, $apiKey);

// Get SMS service
$sms = $AT->sms();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mpesa_code = $_POST['mpesa_code'];
    $user_phone = $_POST['user_phone']; // Collect user phone number

    if (!empty($mpesa_code) && !empty($user_phone)) {
        // Save to the database
        $sql = "INSERT INTO payments (mpesa_code, phone, status) VALUES ('$mpesa_code', '$user_phone', 'pending')";

        if ($conn->query($sql) === TRUE) {
            // Send an SMS Notification
            $message = "Your payment of KES 500 via M-Pesa (Code: $mpesa_code) has been received. We will confirm shortly.";
            
            try {
                $sms->send([
                    'to'      => $user_phone,
                    'message' => $message,
                    'from'    => "your_short_code" // Optional: Use Africa's Talking sender ID
                ]);
                echo "Payment recorded! Confirmation SMS sent.";
            } catch (Exception $e) {
                echo "Payment recorded, but SMS failed: " . $e->getMessage();
            }
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please enter a valid M-Pesa transaction code and phone number.";
    }
}
?>
