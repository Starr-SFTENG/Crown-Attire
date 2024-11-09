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
$paypalUrl = 'https://api-m.sandbox.paypal.com'; 
$clientId = 'AXkSFKbIHa6NvHAbms4SZ9kmaT-7VClTgoIM2TNHRayjasrUSylI4sIa1sXqd9JjCPMCk1lepWDLzll5'; 
$clientSecret = 'EF410JFo-QJOHNbV0r1ndoX3-vfR322AhlStmWgzX7CAdLLZN8tyOt756xjD7LrQmmZllM-lc4Xh0bLQ';

// Check if total is set
if (isset($_POST['total'])) {
    $total = $_POST['total'];
    $_SESSION['total'] = $total; // Store total in session for later use
} else {
    header('Location: checkout.php?error=1');
    exit();
}

// Handle form submission for user details and payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'], $_POST['userEmail'])) {
    $userName = htmlspecialchars($_POST['userName']);
    $userEmail = htmlspecialchars($_POST['userEmail']);
    
    // Validate user inputs
    if (empty($userName) || empty($userEmail)) {
        $_SESSION['message'] = "Please fill in all required fields.";
        header('Location: payment.php');
        exit();
    }

    // Create PayPal payment
    $paymentResponse = createPayPalPayment($total, $paypalUrl, $clientId, $clientSecret, $userName, $userEmail);

    if (isset($paymentResponse['links'])) {
        foreach ($paymentResponse['links'] as $link) {
            if ($link['rel'] === 'approval_url') {
                // Redirect user to PayPal for approval
                header("Location: " . $link['href']);
                exit();
            }
        }
    }

    $_SESSION['message'] = "Error creating PayPal payment.";
    header('Location: checkout.php?error=1');
    exit();
}

// Function to create PayPal payment
function createPayPalPayment($total, $paypalUrl, $clientId, $clientSecret, $userName, $userEmail) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$paypalUrl/v1/payments/payment");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$clientId:$clientSecret")
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $paymentData = [
        "intent" => "sale",
        "redirect_urls" => [
            "return_url" => "http://localhost/Crown Attire/Database/success.php",
            "cancel_url" => "http://localhost/Crown Attire/Database/checkout.php?cancel=true"
        ],
        "payer" => [
            "payment_method" => "paypal"
        ],
        "transactions" => [[
            "amount" => [
                "total" => number_format($total, 2, '.', ''),
                "currency" => "USD"
            ],
            "description" => "Transaction for " . $userName . " (" . $userEmail . ")"
        ]]
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Display the payment form if the total is set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <h1>Payment Details</h1>
    <p>Total Amount: $<?php echo htmlspecialchars($_SESSION['total']); ?></p>
    <form action="payment.php" method="post">
        <input type="hidden" name="total" value="<?php echo htmlspecialchars($_SESSION['total']); ?>">
        <label for="userName">Name:</label>
        <input type="text" id="userName" name="userName" required>
        <br>
        <label for="userEmail">Email:</label>
        <input type="email" id="userEmail" name="userEmail" required>
        <br>
        <button type="submit">Proceed to PayPal</button>
    </form>
</body>
</html>
