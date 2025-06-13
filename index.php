<?php session_start(); ?>
<?php
include 'includes/db.php';

// Fetch 7 newest available products
$home_products = mysqli_query($conn, "SELECT * FROM products WHERE status = 'available' ORDER BY created_at DESC LIMIT 7");
?>



<?php
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Afrilink | Home</title>
  <link rel="stylesheet" href="assets/css/styles.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>
<body>


<!-- Header -->
<section id="header">
  <a href="index.php">
    <img src="img/logo.png" class="logo" alt="Afrilink Logo">
  </a>

  <div class="nav-left">
    <ul id="navbar-left">
      <li><a href="sell.php">Sell on AfriLink</a></li>
      <li><a href="my_account.php">My Account</a></li>
    </ul>
  </div>

  <!-- Mobile Toggle Icon -->
  <div id="mobile">
    <i id="menu-icon" class="fas fa-bars"></i>
    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
  </div>

  <!-- Desktop & Mobile Nav Menu -->
  <div class="nav-right">
    <?php if (isset($_SESSION['user_id'])): ?>
      <p style="margin-right: 20px; color:rgb(196, 58, 141); font-weight: bold;">
         Hi, <?php echo explode(' ', $_SESSION['full_name'])[0]; ?>!
      </p>
    <?php endif; ?>

    <ul id="navbar">
      <li><a class="active" href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="blog.php">Blog</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>

      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="logout.php">Logout</a></li>
        <?php if ($_SESSION['role'] === 'seller' || $_SESSION['role'] === 'both'): ?>
          <li><a href="dashboard.php">Dashboard</a></li>
        <?php endif; ?>
      <?php else: ?>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>

      <li>
        <a href="cart.php"><i class="far fa-shopping-bag"></i>
            (<?php echo $cart_count; ?>)
        </a>
      </li>
    </ul>
  </div>
</section>



  <section id="search-area">
    <form method="GET" action="shop.php" class="search-form">
      <input type="text" name="search" placeholder="Search products..." />
      <button type="submit">🔍 Search</button>
    </form>
  </section>
  

  <!-- Hero -->

  <section id="hero">
    <div class="hero-text">
        <h1>AfriLink Marketplace</h1>
        <p>Connecting buyers and sellers across South Africa</p>
        <a href="shop.php"><button>Shop Now</button></a>
        
    </div>
  </section>

  


  <!-- Features -->
  <section id="feature" class="section-p1">
    <div class="fe-box"><img src="img/products/freeship.jpeg"><h6>Free Shipping</h6></div>
    <div class="fe-box"><img src="img/products/onlineshop.jpeg"><h6>Online Order</h6></div>
    <div class="fe-box"><img src="img/products/save.jpeg"><h6>Save Money</h6></div>
    <div class="fe-box"><img src="img/products/sale.jpeg"><h6>Promotions</h6></div>
    <div class="fe-box"><img src="img/products/sell.jpeg"><h6>Happy Sell</h6></div>
    <div class="fe-box"><img src="img/products/support.jpeg"><h6>Support</h6></div>
  </section>



  

  <section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Hand-picked just for you</p>
    <div class="grid">
        <?php while ($p = mysqli_fetch_assoc($home_products)): ?>
          <?php
              $product_id = $p['id'];
              $rating_query = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM reviews WHERE product_id = $product_id");
              $rating_row = mysqli_fetch_assoc($rating_query);
              $avg_rating = round($rating_row['avg_rating']);
          ?>

        <div class="product">
            <img src="uploads/<?php echo $p['image']; ?>" alt="Product Image">
            <h4><?php echo $p['title']; ?></h4>
            <p><?php echo $p['category']; ?></p>

            <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php echo $i <= $avg_rating ? '⭐' : '☆'; ?>
                <?php endfor; ?>
            </div>


            <div class="price">R<?php echo number_format($p['price'], 2); ?></div>
            <a class="btn" href="product.php?id=<?php echo $p['id']; ?>">View</a>
        </div>
        <?php endwhile; ?>
    </div>
   </section>



   <div style="text-align: center; margin-top: -30px;">
      <a href="shop.php" class="btn" style="background-color: #088178; color: #fff; padding: 12px 25px; border-radius: 6px; text-decoration: none;">🔍 View All Products</a>
   </div>


  <!-- Banner -->
  <section id="banner" class="section-m1">
    <h4>AfriLink more DEALS</h4>
    <h2>Up to <span>70% Off</span> - All t-shirts & accessories</h2>
    <button class="normal">Explore More</button>
  </section>

  <!-- New Arrivals -->
  <section id="product1" class="section-p1">
    <h2>New Arrivals</h2>
    <p>Summer Collection New Modern Design</p>
  </section>

<?php
$more_products = mysqli_query($conn, "SELECT * FROM products WHERE status = 'available' ORDER BY RAND() LIMIT 7");
?>

<section id="more-products" class="section-p1">
  <div class="grid">
    <?php while ($mp = mysqli_fetch_assoc($more_products)): ?>
      <div class="product">
        <img src="uploads/<?php echo $mp['image']; ?>" alt="Product Image">
        <h4><?php echo $mp['title']; ?></h4>
        <p><?php echo $mp['category']; ?></p>
        <div class="price">R<?php echo number_format($mp['price'], 2); ?></div>
        <a class="btn" href="product.php?id=<?php echo $mp['id']; ?>">View</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>


  <!-- Small Banners -->
  <section id="sm-banner" class="section-p1">
    <div class="banner-box">
      <h4>crazy deals</h4>
      <h2>buy 1 get 1 free</h2>
      <span>The best classic dress is on sale at AfriLink</span>
      <button class="white">Learn More</button>
    </div>
    <div class="banner-box banner-box2">
      <h4>spring/summer</h4>
      <h2>upcoming season</h2>
      <span>The best classic dress is on sale at cara</span>
      <button class="white">Collection</button>
    </div>
  </section>

  <!-- Banner 3 -->
  <section id="banner3">
    <div class="banner-box"><h2>SEASONAL SALE</h2><h3>Winter Collection -50% OFF</h3></div>
    <div class="banner-box banner-box2"><h2>NEW FOOTWEAR COLLECTION</h2><h3>Spring / Summer 2025</h3></div>
    <div class="banner-box banner-box3"><h2>T-SHIRTS</h2><h3>New Trendy Prints</h3></div>
  </section>

  <!-- Newsletter -->
  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Sign Up For Newsletters</h4>
      <p>Get Email updates about our latest shop and <span>special offers.</span></p>
    </div>
    <div class="form">
      <input type="text" placeholder="Your email address" />
      <button class="normal">Sign Up</button>
    </div>
  </section>

  <!-- Footer -->
  <footer class="section-p1">
    <div class="col">
      <img class="logo" src="img/logo.png" alt="">
      <h4>Contact</h4>
      <p><strong>Address:</strong> 382 Rivonia Road, Sandton</p>
      <p><strong>Phone:</strong> 011 446 3584</p>
      <p><strong>Hours:</strong> 09:00 - 17:00, Mon - Sat</p>
      <div class="follow">
        <h4>Follow us</h4>
        <div class="icon">
          <i class="fab fa-facebook-f"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-pinterest"></i>
          <i class="fab fa-youtube"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <h4>About</h4>
      <a href="#">About us</a>
      <a href="#">Delivery Information</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Conditions</a>
      <a href="#">Contact Us</a>
    </div>
    <div class="col">
      <h4>My Account</h4>
      <a href="#">Sign In</a>
      <a href="#">View Cart</a>
      <a href="#">My Wishlist</a>
      <a href="#">Track My Order</a>
      <a href="#">Help</a>
    </div>
    <div class="col install">
      <h4>Install App</h4>
      <p>From App Store or Google Play</p>
      <div class="row">
        <img src="img/features/app.jpg" alt="">
        <img src="img/features/play.jpg" alt="">
      </div>
      <p>Secured Payment Gateways</p>
      <img src="img/pay/pay.png" alt="">
    </div>
    <div class="copyright">
      <p>&copy; 2025, AfriTech etc - HTML CSS E-commerce</p>
    </div>
  </footer>
<!--navbar-->
<li><a href="blog.php">Blog</a></li>
<a href="cart.php">🛒 Cart (<?php echo $cart_count; ?>)</a>
  <script src="script.js"></script>

  <script src="assets/css/script.js"></script>


</body>
</html>
