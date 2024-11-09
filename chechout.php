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