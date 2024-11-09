redesign this index page which has account to reveal the user profile and details when an account font awesome icon at the top right corner is clicked and add some other cool features found in a dashboard page eg settings and latest news and other cool features ,also create a link to products ,cart and about us and index page being the home page

<?php
require 'functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Your Website</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/styles.css"> <!-- Add your custom styles if needed -->
    <style>
        .navbar {
            margin-bottom: 20px;
        }
        .dropdown-menu {
            min-width: 200px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Your Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Account
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="profile-edit.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Welcome to Your Website</h1>
        <p class="text-center">Discover amazing products and features!</p>

        <div class="row mt-4">
            <div class="col-md-8">
                <h2>Latest News</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">News Title 1</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">News Title 2</h5>
                        <p class="card-text">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h2>Quick Links</h2>
                <ul class="list-group">
                    <li class="list-group-item"><a href="products.php">Products</a></li>
                    <li class="list-group-item"><a href="cart.php">Cart</a></li>
                    <li class="list-group-item"><a href="about.php">About Us</a></li>
                    <li class="list-group-item"><a href="settings.php">Settings</a></li>
                    <li class="list-group-item"><a href="profile.php">View Profile</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>








// Switch between Stripe and PayPal payment methods
        function switchPaymentMethod(method) {
            const paymentForm = document.getElementById('payment-form');
            const creditCardSection = document.getElementById('credit-card-section');
            const paymentMethodField = document.getElementById('payment-method');
            const cardInputs = document.querySelectorAll('#credit-card-section input');

            // Check which method is selected and update form and display accordingly
            if (method === 'paypal') {
                paymentForm.action = 'process_paypal_payment.php';  // Set form action to PayPal handler
                creditCardSection.style.display = 'none';  // Hide credit card fields
                cardInputs.forEach(input => input.disabled = true); // Disable card inputs
                paymentMethodField.value = 'paypal';  // Set hidden payment method to PayPal
            } else {
                paymentForm.action = 'process_stripe_payment.php';  // Set form action to Stripe handler
                creditCardSection.style.display = 'block';  // Show credit card fields
                cardInputs.forEach(input => input.disabled = false); // Enable card inputs
                paymentMethodField.value = 'stripe';  // Set hidden payment method to Stripe
            }

            // Toggle button active states
            document.getElementById('stripe-method').classList.toggle('active', method === 'stripe');
            document.getElementById('paypal-method').classList.toggle('active', method === 'paypal');
        }