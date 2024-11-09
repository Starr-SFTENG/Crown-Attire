<?php
session_start();

// Database connection details
$host = 'localhost';
$dbname = 'crowndb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// PayPal API configuration
$paypalUrl = 'https://api-m.sandbox.paypal.com'; // Sandbox environment
$clientId = 'AeQoObZYOY7u2APCkjQptcHE3YUbOrf1apwD0f2eZKfIbLI0aIFE6hA0EKlEy7L1QUMi5C8Oe0E5sayv';
$clientSecret = 'EGdE9sBRek56L6B3nCSzp-9ZJPmWFU8Bj_erbeSGUWilaHHZPZP6iS8-o7Y623Q-t-C5n_zP4xrkZXCH';

// Check if package and total are set from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['total'])) {
        $_SESSION['message'] = "Invalid request. Missing package or total.";
        header('Location: checkout.php?error=1');
        exit();
    }

    // Retrieve and sanitize the package and total
    $total = floatval($_POST['total']); // Ensure total is a float
   // Sanitize the package name

    // Store package and total in session for later use (in success.php)
    $_SESSION['total'] = $total;

    // Create the PayPal payment
    $paymentResponse = createPayPalPayment($total, $package, $paypalUrl, $clientId, $clientSecret);

    // Check if payment was created successfully
    if (isset($paymentResponse['links'])) {
        foreach ($paymentResponse['links'] as $link) {
            if ($link['rel'] === 'approval_url') {
                // Redirect user to PayPal for payment approval
                header("Location: " . $link['href']);
                exit();
            }
        }
    }

    // Error occurred during payment creation
    $_SESSION['message'] = "Error creating PayPal payment.";
    header('Location: checkout.php?error=1');
    exit();
} else {
    // Invalid request method
    $_SESSION['message'] = "Invalid request method.";
    header('Location: checkout.php?error=1');
    exit();
}

// Function to create PayPal payment
function createPayPalPayment($total, $package, $paypalUrl, $clientId, $clientSecret) {
    // Get access token from PayPal
    $accessToken = getPayPalAccessToken($paypalUrl, $clientId, $clientSecret);
    if (!$accessToken) {
        return null; // Return if token generation failed
    }

    // Prepare payment data
    $paymentData = [
        "intent" => "sale",
        "redirect_urls" => [
            "return_url" => "http://localhost/Crown%20Attire/Database/success.php", // Adjust return URL
            "cancel_url" => "http://localhost/Crown%20Attire/Database/checkout.php?cancel=true" // Adjust cancel URL
        ],
        "payer" => [
            "payment_method" => "paypal"
        ],
        "transactions" => [[
            "amount" => [
                "total" => number_format($total, 2, '.', ''), // Format total to 2 decimal places
                "currency" => "USD"
            ],
            "description" => "Subscription for " . $package
        ]]
    ];

    // Initialize cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$paypalUrl/v1/payments/payment");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));

    // Execute cURL request and get response
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true); // Decode JSON response and return
}

// Function to get PayPal access token
function getPayPalAccessToken($paypalUrl, $clientId, $clientSecret) {
    // Prepare request for access token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$paypalUrl/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Accept-Language: en_US'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$clientSecret");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    // Execute request and get response
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse response and extract access token
    $result = json_decode($response, true);
    return isset($result['access_token']) ? $result['access_token'] : null;
}
?>