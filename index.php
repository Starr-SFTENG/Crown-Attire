<?php

include 'functions.php'; // Ensure this path is correct
//$userId = $_SESSION['PROFILE']['id'];

//$id = $_GET['id'] ?? $_SESSION['PROFILE']['id'];

// Check if the user is logged in
if (!isset($_SESSION['PROFILE']['id'])) {
    // Redirect to login page if user_id is not set
    header("Location: signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Attire</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <script>
        // Function to handle redirection to signup page
        function redirectToSignup() {
            window.location.href = "signup.php"; // Redirect to signup page
        }

        // Function to prevent default actions and redirect if not logged in
        function handleButtonClick(event) {
            event.preventDefault(); // Prevent the default button action
            if (!<?php echo json_encode($is_logged_in); ?>) {
                redirectToSignup(); // Redirect to signup if not logged in
            } else {
                // Handle logged-in actions, e.g., add to cart, etc.
            }
        }
    </script>
</head>
<body>

    <!-- Main Container -->
    <div class="container">
        <!-- Overlay for darkening background -->
        <div class="overlay">
            <!-- <img src="backoverlay.jpg" alt="overlay-image"> -->
        </div>
        
        <!-- Header Logo and Title -->
        <div class="header">
            <img src="Images/logo.png" alt="Logo"> <!-- Replace with your logo URL -->
            <span>Crown Attire</span>
        </div>

        <!-- Navbar -->
        <div class="navbar">
            <a href="#">Search</a>
            <a href="#">❤ (0)</a>
            <a href="#">🛒 (0)</a>
            <a href="#">Get Pro</a>
        </div>

        <!-- Content -->
        <div class="content">
            <h1>Build Your Own Style.</h1>
            <p>Rehaussez votre garde-robe avec un look qui combine l’artisanat traditionnel et le flair moderne.</p>
            
            <!-- Buttons -->
            <div class="buttons">
                <button class="button button-primary" onclick="handleButtonClick(event)">Shop Now</button>
                <button class="button button-secondary" onclick="handleButtonClick(event)">Get it Now</button>
            </div>
        </div>
    </div>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #0f0f0f;
            color: white;
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: top 0.3s;
        }

        .logo h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .menu-icon {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Nav Links Styling */
        .nav-links ul {
            list-style: none;
            display: flex;
            gap: 1rem;
        }

        .nav-links ul li {
            padding: 8px 0;
        }

        .nav-links ul li a {
            text-decoration: none;
            color: white;
            padding: 8px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .nav-links ul li a:hover {
            background-color: #575757;
        }

        /* Responsive for Mobile */
        @media (max-width: 768px) {
            .menu-icon {
                display: block;
            }
            .nav-links {
                display: none;
            }
            .nav-links ul {
                flex-direction: column;
                background-color: #333;
                width: 100%;
            }
            .nav-links ul li {
                text-align: center;
                padding: 10px 0;
            }
            .nav-links.active {
                display: block;
            }
        }
    </style>

    <header class="navbar" id="navbar">
        <div class="logo">
            <h1><i class="fas fa-crown"></i>Crown Attire</h1>
        </div>
        <div class="menu-icon" onclick="toggleMenu()">
            <span>&#9776;</span>
        </div>
        <nav class="nav-links" id="navLinks">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="products.php" onclick="handleButtonClick(event)">Product</a></li>
                <li><a href="cart.php" onclick="handleButtonClick(event)">Cart</a></li>
                <li><a href="about-us.php">About</a></li>
                <li id="checkout-link"><a href="#checkout">Checkout</a></li>
                <li><a href="signup.php" class="signup-button">Sign Up</a></li>
            </ul>
            <i class="fas fa-account"></i>
        </nav>
    </header>

    <script>
        // Show navbar when scrolled down by 4%
        window.onscroll = function() {
            const navbar = document.getElementById("navbar");
            if (document.documentElement.scrollTop > window.innerHeight * 0.04) {
                navbar.style.display = "block";
            } else {
                navbar.style.display = "none";
            }
        };

        // Toggle the dropdown menu
        function toggleMenu() {
            const navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("active");
        }

        // Conditionally display 'Checkout' link based on 'showCheckout' variable
        const showCheckout = window.location.pathname.includes("/account"); // Example condition based on URL
        const checkoutLink = document.getElementById("checkout-link");
        if (!showCheckout) {
            checkoutLink.style.display = "none";
        }
    </script>

    <div class="services-section">
        <div class="service">
            <div class="service-icon"><i class="fas fa-shipping-fast"></i></div>
            <div class="service-title">Quick Delivery</div>
            <div class="service-description">Inside City delivery within 5 days</div>
        </div>
        <div class="service">
            <div class="service-icon"><i class="fas fa-store"></i></div>
            <div class="service-title">Pick Up In Store</div>
            <div class="service-description">We have an option of pick up in store.</div>
        </div>
        <div class="service">
            <div class="service-icon"><i class="fas fa-gift"></i></div>
            <div class="service-title">Special Packaging</div>
            <div class="service-description">Our packaging is best for products.</div>
        </div>
    </div>

    <!-- Trending Section -->
    <div class="trending-section">
        <div class="trending-title">What's Trending</div>
        <div class="trending-subtitle">These are the products that are trending now.</div>
    </div>

    <!-- Get it Now Button -->
    <a href="#" class="get-it-now-button" onclick="handleButtonClick(event)">
        <i class="fas fa-shopping-cart"></i> <span>Get it Now</span>
    </a>

    <div class="carousel-container">
        <!-- Product 1 -->
        <div class="product-card">
            <img src="Images/mch.jpg" alt="Scotch-Blazer">
            <div class="product-info">
                <h3>Scotch Blazer</h3>
                <div class="product-actions">
                    <button class="add-to-cart" onclick="handleButtonClick(event)"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    <button class="wishlist"><i class="fas fa-heart"></i></button>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="Images/luxury business attire.jpg" alt="2-Pierce-suit">
            <div class="product-info">
                <h3>2 Pierce suit Luxury</h3>
                <div class="product-actions">
                    <button class="add-to-cart" onclick="handleButtonClick(event)"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    <button class="wishlist"><i class="fas fa-heart"></i></button>
                </div>
            </div>
        </div>
        
        <!-- Product 3 -->
        <div class="product-card">
            <img src="Images/3pc.jpg" alt="Oversized-Luxury-Jacket">
            <div class="product-info">
                <h3>Oversized Luxury Jacket</h3>
                <div class="product-actions">
                    <button class="add-to-cart" onclick="handleButtonClick(event)"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    <button class="wishlist"><i class="fas fa-heart"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="header-section">
        <a href="#" class="shop-all-button">Shop All</a>
    </div>

    <!-- Video Container -->
    <div class="video-container">
        <video src="video/promo.mp4" autoplay muted loop></video>
    </div>


    <style>
  .testimonial-section {
    background-color: #fff;
    padding: 60px 40px;
    margin-top: 50px;
    margin: 30px auto;
    width: 80%; /* Adjust width as needed */
    max-width: 600px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    font-family: Arial, sans-serif;
}

/* Quote icon styling */
.quote-icon {
    font-size: 40px;
    color: #000;
    margin-bottom: 20px;
}

/* Blockquote styling */
#testimonial-text {
    font-style: italic;
    font-size: 20px;
    color: #333;
    margin: 20px 0;
    line-height: 1.6;
}

/* Stars styling */
.stars {
    color: #FFD700; /* Gold color */
    font-size: 18px;
    margin: 10px 0 20px;
}

/* Author styling */
#testimonial-author {
    font-weight: bold;
    font-size: 16px;
    color: #333;
    margin-top: 10px;
}

/* Arrow styling */
.arrow {
    font-size: 24px;
    color: #333;
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.arrow-left {
    left: -30px; /* Adjust position */
}

.arrow-right {
    right: -30px; /* Adjust position */
}

/* Hover effects */
.arrow:hover {
    color: #000;
}
    </style>
       <div class="testimonial-section">
        <div class="quote-icon">
            <i class="fas fa-quote-left"></i>
        </div>
        <blockquote id="testimonial-text">
            "Tempus oncu enim pellen tesque este pretium in neque, elit morbi sagittis lorem habi mattis Pellen tesque pretium feugiat vel morbi suspen dise sagittis lorem habi tasse morbi sagittis loreus oncu enim cursus."
        </blockquote>
        <div class="stars" id="testimonial-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <div class="author" id="testimonial-author">Emma Chamberlin</div>
        <div class="arrow arrow-left" onclick="previousTestimonial()">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="arrow arrow-right" onclick="nextTestimonial()">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>


<script>
    // Array of testimonials
    const testimonials = [
        {
            text: "Tempus oncu enim pellen tesque este pretium in neque, elit morbi sagittis lorem habi mattis Pellen tesque pretium feugiat vel morbi suspen dise sagittis lorem habi tasse morbi sagittis loreus oncu enim cursus.",
            author: "Emma Chamberlin",
            stars: 4.5
        },
        {
            text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam interdum metus sed nulla posuere, et aliquet nulla convallis.",
            author: "John Doe",
            stars: 5
        },
        {
            text: "Suspendisse potenti. Pellentesque et lacus nec lorem luctus euismod. Fusce ut nisi id velit facilisis dapibus.",
            author: "Sarah Lee",
            stars: 4
        }
    ];

    let currentIndex = 0;

    function displayTestimonial(index) {
        // Display the text
        document.getElementById("testimonial-text").textContent = testimonials[index].text;
        
        // Display the author
        document.getElementById("testimonial-author").textContent = testimonials[index].author;
        
        // Display the stars
        const starsContainer = document.getElementById("testimonial-stars");
        starsContainer.innerHTML = ""; // Clear previous stars
        
        // Add full and half stars based on rating
        let fullStars = Math.floor(testimonials[index].stars);
        let halfStar = testimonials[index].stars % 1 >= 0.5;
        
        for (let i = 0; i < fullStars; i++) {
            starsContainer.innerHTML += '<i class="fas fa-star"></i>';
        }
        
        if (halfStar) {
            starsContainer.innerHTML += '<i class="fas fa-star-half-alt"></i>';
        }
    }

    function nextTestimonial() {
        currentIndex = (currentIndex + 1) % testimonials.length;
        displayTestimonial(currentIndex);
    }

    function previousTestimonial() {
        currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
        displayTestimonial(currentIndex);
    }

    // Initial display
    displayTestimonial(currentIndex);
</script>


<section class="banner">
    <h1>New Arrivals</h1>
    <p>These are the products that are new.</p>
</section>

<!-- Product Images with Navigation Arrows -->
<section class="products">
    <div class="product active">
        <div class="product-container">
            <img src="Images/Black Crown Attire.jpg" alt="2pierce">
        </div>
        <p>Black Crown Attire</p>
    </div>
    <div class="product">
        <div class="product-container">
            <img src="Images/blue scotch.jpg" alt="blue scotch">
        </div>
        <p>Blue scotch</p>
    </div>
    <div class="product">
        <div class="product-container">
            <img src="Images/double.jpg" alt="Hoodie 3">
        </div>
        <p>Well Tailored Double Breast</p>
    </div>
    <div class="product">
        <div class="product-container">
            <img src="Images/3pc.jpg" alt="3pierce">
        </div>
        <p>Tan 3 Pierce</p>
    </div>
    <div class="product">
        <div class="product-container">
            <img src="Images/brown.png" alt="Hoodie 3">
        </div>
        <p>3 Pirce Brown</p>
    </div>
    
    <!-- Navigation Arrows -->
    <!-- <div class="arrow left-arrow" onclick="showPreviousProduct()">&#8249;</div>
    <div class="arrow right-arrow" onclick="showNextProduct()">&#8250;</div> -->
    <div class="arrow left-arrow">

        <div class="arrow-container">
        
        <i class="fas fa-arrow-left"></i>
        
        </div>
        
        </div>
        
        <div class="arrow right-arrow">
        
        <div class="arrow-container">
        
        <i class="fas fa-arrow-right"></i>
        
        </div>
        
        </div>
</section>

<!-- Call-to-Action Button -->
<button class="cta-button" onclick="handleButtonClick(event)">Get it Now</button>

<!-- JavaScript -->
<script>
    
    let currentProductIndex = 0;
const products = document.querySelectorAll('.product');

function showPreviousProduct() {
    products[currentProductIndex].classList.remove('active');
    currentProductIndex = (currentProductIndex - 1 + products.length) % products.length;
    products[currentProductIndex].classList.add('active');
}

function showNextProduct() {
    products[currentProductIndex].classList.remove('active');
    currentProductIndex = (currentProductIndex + 1) % products.length;
    products[currentProductIndex].classList.add('active');
}

// Add click event listeners to the arrows
document.querySelector('.left-arrow').addEventListener('click', showPreviousProduct);
document.querySelector('.right-arrow').addEventListener('click', showNextProduct);
</script>

<style>
/* Styling for the banner section */
.banner {
    background-color: #f9f9f9;
    text-align: center;
    padding: 20px;
}

/* Styling for the products section */
.products {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.product {
    display: none;
    text-align: center;
}

.product.active {
    display: block;
}

.product-container {
    width: 300px; /* Adjust width as needed */
    height: 300px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 10px;
}

.product img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Keeps images nicely centered and scaled */
}

/* Styling for the call-to-action button */
.cta-button {
    background-color: #ff6600;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 10px;
}

/* Styling for navigation arrows */
.arrow {
font-size: 24px;
cursor: pointer;
position: absolute;
top: 50%;
transform: translateY(-50%);
color: #333;
user-select: none;
}

.arrow-container {
width: 40px;
height: 40px;
background-color: #000;
border-radius: 50%;
display: flex;
justify-content: center;
align-items: center;
color: #fff;
}

.left-arrow {
left: 10px;
}

.right-arrow {
right: 10px;
}
</style>

<div class="brands-section">
    <div class="brand">STYLEKICK.</div>
    <div class="brand">NOREMON HANKS</div>
    <div class="brand">FashionMax</div>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h2><span><i class="fas fa-crown"></i></span>Crown Attire</h2>
            <p>"Stay updated with the latest trends in formal wear. Sign up to receive exclusive offers, style tips, and early access to new collections from Crown Attire. Enter your email below."</p>
            <form action="#" method="post">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">➤</button>
            </form>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-behance"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Blogs</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Help & Info</h3>
            <ul>
                <li><a href="#">Track Your Order</a></li>
                <li><a href="#">Returns Policies</a></li>
                <li><a href="#">Shipping + Delivery</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQs</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Do you have any queries or suggestions? <a href="mailto:yourinfo@gmail.com"><i class="fas fa-envelope">crownware@gmail.com</i></a></p>
            <p>If you need support, just give us a call: <a href="tel:+551112223344"><i class="fas fa-phone">+263 77 485 7725</i></a></p>
        </div>
    </div>
      </div>
    </div>
    <div class="payments">
        <h3>Payment options:</h3>
        <div class="payment-icons">
          <i class="fab fa-cc-visa"></i>
          <i class="fab fa-cc-mastercard"></i>
          <i class="fab fa-cc-paypal"></i>
        </div>
  </footer>
</body>
</html>


    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 Crown Attire. All rights reserved.</p>
    </footer>
</body>
</html>
