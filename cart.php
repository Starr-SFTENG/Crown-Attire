
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
  <title>Cart Page</title>
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      margin: 0;
      padding: 0;
    }
    /* Header Styles */
    .header {
      background-color: #000;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 24px;
      font-weight: bold;
    }
    .cart-container {
      display: flex;
      align-items: center;
    }
    .cart-icon {
      margin-right: 5px;
    }
    .cart-count {
      font-size: 16px;
      margin-right: 15px;
      color: gold;
    }
    .dropdown-menu {
      position: relative;
      cursor: pointer;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #000;
      color: #fff;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      padding: 10px;
      border-radius: 5px;
      z-index: 1000;
    }
    .dropdown-content a {
      color: #fff;
      padding: 5px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #333;
    }
    .cart-section {
      max-width: 800px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .cart-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-total {
      font-weight: bold;
      margin-top: 20px;
    }
    .remove-item-btn, .clear-all-btn {
      background-color: red;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 5px;
      margin-left: 10px;
    }
    .checkout-btn {
      background-color: green;
      color: white;
      border: none;
      padding: 10px 15px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <div><i class="fas fa-crown"></i> Crown Attire</div>
    <div class="cart-container">
      <span class="cart-icon">🛒</span>
      <span class="cart-count" id="cartCount">0</span>
      <div class="dropdown-menu" id="dropdownMenu">
        <span>☰</span>
        <div class="dropdown-content" id="dropdownContent">
          <a href="index.php">Home</a>
          <a href="products.php">Products</a>
          <a href="cart.php">Cart</a>
          <a href="checkout.php">Checkout</a>
          <a href="about-us.php">About Us</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Cart Section -->
  <div class="cart-section">
    <h2>Your Cart</h2>
    <div id="cartItems"></div>
    <div class="cart-total" id="cartTotal">Total: $0.00</div>
    <button class="clear-all-btn" id="clearAllBtn">Clear All</button>

    <!-- Checkout Form -->
    <form action="checkout.php" method="post" id="checkoutForm">
    <input type="hidden" name="total" id="totalAmount" value="0">
   
    <button type="submit" class="checkout-btn">Checkout</button>
</form>


  <script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function displayCartItems() {
      const cartItemsContainer = document.getElementById('cartItems');
      cartItemsContainer.innerHTML = "";
      let total = 0;

      cart.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
          <span>${item.name} - ${item.price}</span>
          <button class="remove-item-btn" onclick="removeItem(${index})">Remove Item</button>
        `;
        cartItemsContainer.appendChild(itemElement);
        total += parseFloat(item.price.replace('$', ''));
      });

      document.getElementById('cartTotal').textContent = `Total: $${total.toFixed(2)}`;
      document.getElementById('cartCount').textContent = cart.length;
      document.getElementById('totalAmount').value = total.toFixed(2); // Set hidden input for total
    }

    function removeItem(index) {
      cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(cart));
      displayCartItems();
    }

    document.getElementById('clearAllBtn').onclick = function() {
      cart = [];
      localStorage.setItem('cart', JSON.stringify(cart));
      displayCartItems();
    };

    document.getElementById("dropdownMenu").onclick = function() {
      const content = document.getElementById("dropdownContent");
      content.style.display = content.style.display === 'block' ? 'none' : 'block';
    };

    window.onclick = function(event) {
      if (!event.target.matches('.dropdown-menu') && !event.target.matches('.dropdown-menu span')) {
        closeDropdown();
      }
    };

    function closeDropdown() {
      const content = document.getElementById("dropdownContent");
      content.style.display = 'none';
    }

    displayCartItems();
  </script>
</body>
</html>
