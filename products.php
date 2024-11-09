<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    
  <title>Product Page</title>
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

    /* Cart icon and count styles */
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

    /* Dropdown menu styles */
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
      z-index: 1000; /* Ensure dropdown is on top */
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

    /* Layout Styles */
    .content {
      display: flex;
      max-width: 1200px;
      margin: 20px auto;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #fff;
      padding: 20px;
      margin-right: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar h3 {
      font-size: 18px;
      margin-bottom: 15px;
      color: #333;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      padding: 5px 0;
      color: #666;
    }

    /* Product Grid */
    .product-grid {
      flex: 1;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 20px;
    }

    /* Product Card Styles */
    .product-card {
      background-color: #fff;
      padding: 15px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }

    .product-name {
      font-size: 18px;
      margin: 10px 0;
      color: #333;
    }

    .product-price {
      color: #777;
      font-size: 16px;
    }

    .product-card button {
      margin-top: 10px;
      padding: 10px 15px;
      font-size: 14px;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .add-to-cart-btn {
      background-color: gold;
      margin-right: 10px;
    }

    .wishlist-btn {
      background-color: #000;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination button {
      background-color: #000;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      margin: 0 5px;
      transition: background-color 0.3s;
    }

    .pagination button:hover {
      background-color: #333;
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
          <a href="about-us.php">About Us</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <!-- Sidebar -->
    <div class="sidebar">
      <h3>Categories</h3>
      <ul>
        <li>All</li>
        <li>Popular</li>
        <li>Accessories</li>
        <li>New Arrivals</li>
        <li>Trending</li>
      </ul>
      
      <h3>Tags</h3>
      <ul>
        <li>Classic</li>
        <li>Tees</li>
        <li>Leather coat</li>
        <li>Winter</li>
        <li>Summer</li>
        <li>Modern</li>
      </ul>
      
      <h3>Filter By Color</h3>
      <ul>
        <li>Red</li>
        <li>Orange</li>
        <li>Green</li>
        <li>Blue</li>
      </ul>
      
      <h3>Filter By Size</h3>
      <ul>
        <li>XL</li>
        <li>L</li>
        <li>M</li>
        <li>S</li>
      </ul>
    </div>

    <!-- Product Grid -->
    <div class="product-grid" id="productGrid"></div>
  </div>

  <!-- Pagination -->
  <div class="pagination">
    <button onclick="previousPage()">Previous</button>
    <button onclick="nextPage()">Next</button>
  </div>

  <script>
    // Sample product data (at least 18 items for multiple pages)
    const products = [
      { name: "3pierce", price: "$120.00", img: "Images/3pc.jpg" },
      { name: "2 pierce classic", price: "$140.00", img: "Images/2 classic.jpg" },
      { name: "2 pierce blue", price: "$100.00", img: "Images/bck.jpg" },
      { name: "Blue scotch 2 pierce", price: "$120.00", img: "Images/blue scotch.jpg" },
      { name: "Brown scotch 2 pierc", price: "$120.00", img: "Images/brown.png" },
      { name: "Double Breast scotch", price: "$120.00", img: "Images/double.jpg" },
      { name: "2 pierce tan", price: "$112.00", img: "Images/iop.jpg" },
      { name: "2 pierce Brown", price: "$112.00", img: "Images/tde.jpg" },
      { name: "2 pierce tan", price: "$112.00", img: "Images/iop1.png" },
      { name: "luxury girl Business Attire", price: "$120.00", img: "Images/luxury business attire.jpg" },
      { name: "Green Business Suit", price: "$112.00", img: "Images/Green Business Suit.jpg" },
      { name: "Black Crown Attire", price: "$112.00", img: "Images/Black Crown Attire.jpg" },
      { name: "Pink Crown Attire", price: "$112.00", img: "Images/Pink Crown Attire.jpg" },
      { name: "Boss in Pink Crown Attire ", price: "$120.00", img: "Images/Boss in Pink Crown Attire.jpg" },
      { name: "Navy Blue Crown Attire", price: "$122.00", img: "Images/Navy Blue Crown Attire.jpg" },
      { name: "Padresh Lady Hand Bag", price: "$100.00", img: "Images/Padresh Ladie Hand Bag.jpg" },
      { name: "Pink Handbag for Lady", price: "$130.00", img: "Images/Pink Handbag for Lady.jpg" },
      { name: "Cream luxury handbag set ", price: "$150.00", img: "Images/Cream luxury handbag set.jpg" },
    ];

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let currentPage = 1;
    const itemsPerPage = 9; // 9 products per page

    function displayProducts() {
      const grid = document.getElementById("productGrid");
      grid.innerHTML = ""; // Clear previous products
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const paginatedProducts = products.slice(startIndex, endIndex);

      paginatedProducts.forEach((product) => {
        const card = document.createElement("div");
        card.className = "product-card";
        card.innerHTML = `
          <img src="${product.img}" alt="${product.name}">
          <div class="product-name">${product.name}</div>
          <div class="product-price">${product.price}</div>
          <button class="add-to-cart-btn" onclick="addToCart('${product.name}', '${product.price}')">Add to Cart</button>
          <button class="wishlist-btn">Wishlist</button>
        `;
        grid.appendChild(card);
      });

      // Update cart count in header
      document.getElementById('cartCount').textContent = cart.length;
    }

    function addToCart(name, price) {
      cart.push({ name, price });
      localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
      document.getElementById('cartCount').textContent = cart.length;
      alert(`${name} has been added to your cart!`);
    }

    function previousPage() {
      if (currentPage > 1) {
        currentPage--;
        displayProducts();
      }
    }

    function nextPage() {
      if (currentPage < Math.ceil(products.length / itemsPerPage)) {
        currentPage++;
        displayProducts();
      }
    }

    // Dropdown Menu Functionality
    document.getElementById("dropdownMenu").onclick = function() {
      const content = document.getElementById("dropdownContent");
      content.style.display = content.style.display === 'block' ? 'none' : 'block';
    };

    // Close dropdown if clicked outside
    window.onclick = function(event) {
      if (!event.target.matches('.dropdown-menu') && !event.target.matches('.dropdown-menu span')) {
        closeDropdown();
      }
    };

    function closeDropdown() {
      const content = document.getElementById("dropdownContent");
      content.style.display = 'none';
    }

    // Initialize the first view
    displayProducts();
  </script>
</body>
</html>