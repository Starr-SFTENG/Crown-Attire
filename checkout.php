<?php

session_start();

// Check if there is a total amount and package posted from cart.php
$total = isset($_POST['total']) ? $_POST['total'] : 0; // Retrieve total from POST
$package = isset($_POST['package']) ? $_POST['package'] : ''; // Retrieve package from POST

// Store the total and package in session for further use if necessary
$_SESSION['total'] = $total; // Store total in session
$_SESSION['package'] = $package; // Store package in session

// Display any message if an error occurred
if (isset($_SESSION['message'])) {
    echo "<p style='color:red;'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Basic styling for checkout page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .checkout-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .checkout-container h2 {
            text-align: center;
            color: #333;
        }
        .checkout-details, .checkout-actions {
            margin: 20px 0;
            font-size: 18px;
        }
        .btn-checkout {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background-color: green;
            color: #fff;
            text-align: center;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-checkout:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <div class="checkout-details">
            <p>Package: <?php echo htmlspecialchars($package); ?></p>
            <p>Total Amount: $<?php echo number_format($total, 2); ?></p>
        </div>

        <!-- Form to send total and package to payment.php -->
        <form action="process_paypal_payment.php" method="post">
            <input type="hidden" name="total" value="<?php echo number_format($total, 2); ?>">
            <button type="submit" class="btn-checkout">Proceed to Payment</button>
            <a href="cart.php" style="color:#ff0000">cancel</a>
        </form>
    </div>
</body>
</html>
