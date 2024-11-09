<?php 
    require 'functions.php';

    if(!is_logged_in()) {
        redirect('login.php');
    }

    $id = $_GET['id'] ?? $_SESSION['PROFILE']['id'];
    $row = db_query("SELECT * FROM users WHERE id = :id LIMIT 1", ['id' => $id]);

    if($row) {
        $row = $row[0];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Crown Attire</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles */
        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            z-index: 1000;
            background-color: white;
            border: 1px solid #ddd;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-dropdown.show {
            display: block;
        }
        .dropdown-item {
            padding: 10px;
            text-decoration: none;
            color: black;
        }
        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
        .account-icon {
            cursor: pointer;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Crown Attire</a>
        <div class="ml-auto">
            <span class="account-icon" id="accountIcon"><i class="fas fa-user-circle fa-2x"></i></span>
            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-item"><?= esc($row['firstname']) ?> <?= esc($row['lastname']) ?></div>
                <div class="dropdown-item"><a href="profile-edit.php">Edit Profile</a></div>
                <div class="dropdown-item"><a href="profile-delete.php">Delete Account</a></div>
                <div class="dropdown-item"><a href="logout.php">Logout</a></div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Welcome to Crown Attire</h2>
        <p class="text-center">Explore our latest products and offers!</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Latest News</h5>
                        <p class="card-text">Stay updated with the latest fashion trends and news!</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">Check out our newest collections and exclusive deals.</p>
                        <a href="products.php" class="btn btn-primary">View Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart</h5>
                        <p class="card-text">View items in your cart and proceed to checkout.</p>
                        <a href="cart.php" class="btn btn-primary">Go to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="about.php" class="btn btn-secondary">About Us</a>
        </div>
    </div>

    <script>
        const accountIcon = document.getElementById('accountIcon');
        const profileDropdown = document.getElementById('profileDropdown');

        accountIcon.addEventListener('click', () => {
            profileDropdown.classList.toggle('show');
        });

        window.addEventListener('click', (event) => {
            if (!accountIcon.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.remove('show');
            }
        });
    </script>

</body>
</html>
