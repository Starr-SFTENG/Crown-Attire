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

// PayPal API credentials (ensure these are correct for sandbox)
$paypalUrl = 'https://api-m.sandbox.paypal.com';
$clientId = 'AeQoObZYOY7u2APCkjQptcHE3YUbOrf1apwD0f2eZKfIbLI0aIFE6hA0EKlEy7L1QUMi5C8Oe0E5sayv';
$clientSecret = 'EGdE9sBRek56L6B3nCSzp-9ZJPmWFU8Bj_erbeSGUWilaHHZPZP6iS8-o7Y623Q-t-C5n_zP4xrkZXCH';

// Check if the payment is successful
if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    // Execute the PayPal payment
    if (executePayPalPayment($paymentId, $payerId, $paypalUrl, $clientId, $clientSecret)) {
        // Payment executed successfully, now process the subscription
        
        // Get the total amount and package from the session
        $total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
        $userId = $_SESSION['PROFILE']['id']; // Assuming the user's ID is stored in the session after login.

        // Calculate subscription dates
        $startDate = date('Y-m-d'); // Today's date as the start date
        $expiryDate = date('Y-m-d', strtotime('+1 year')); // Set expiry date as 1 year from today

        // Insert subscription into the database
        $stmt = $pdo->prepare("
            INSERT INTO subscriptions (user_id, plan_name, price, start_date, expiry_date, status, created_at, updated_at) 
            VALUES (:user_id, :plan_name, :price, :start_date, :expiry_date, 'active', NOW(), NOW())
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':price' => $total,
            ':start_date' => $startDate,
            ':expiry_date' => $expiryDate
        ]);

        // Confirm the insertion and display the success message
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Payment Successful - SentriTech</title>
            <style>
  
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 50px auto;
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #4CAF50;
                text-align: center;
            }
            p {
                font-size: 16px;
                line-height: 1.6;
            }
            .details {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background: #f9f9f9;
            }
            .back-link {
                display: inline-block;
                margin-top: 20px;
                text-align: center;
                background: #4CAF50;
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
            }
            .back-link:hover {
                background: #45a049;
            }
  
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Payment Successful!</h1>
                <p>Your payment was processed successfully and your subscription has been activated.</p>
                <div class='details'>
                    <p><strong>Payment ID:</strong> " . htmlspecialchars($paymentId) . "</p>
                    <p><strong>Amount Charged:</strong> $" . htmlspecialchars($total) . "</p>
                    <p><strong>Start Date:</strong> " . $startDate . "</p>
                    <p><strong>Expiry Date:</strong> " . $expiryDate . "</p>
                    <p><strong>Status:</strong> Active</p>
                </div>
                <a class='back-link' href='portal-dashboard.php'>Go to Dashboard</a>
            </div>
        </body>
        </html>
        ";

        // Optionally, clear session variables if no longer needed
        unset($_SESSION['total']);
    } else {
        echo "<h1>Payment execution failed. Please contact support.</h1>";
    }
} else {
    echo "<h1>Payment failed or cancelled.</h1>";
}

// Function to execute PayPal payment
function executePayPalPayment($paymentId, $payerId, $paypalUrl, $clientId, $clientSecret) {
    // Get PayPal access token
    $accessToken = getPayPalAccessToken($paypalUrl, $clientId, $clientSecret);
    if (!$accessToken) {
        return false;
    }

    // Make the request to execute the payment
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$paypalUrl/v1/payments/payment/$paymentId/execute");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['payer_id' => $payerId]));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Check if the payment was successfully executed
    return isset($result['state']) && $result['state'] === 'approved';
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
