<!DOCTYPE html>
<html>
<head>
    <title>Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        background-image: url('images/jjj.jpg'); 
        background-size: cover;        
        background-position: center;   
        background-repeat: no-repeat;  
        background-attachment: fixed;  
    }
    </style>
</head>

<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <!-- LOGO -->
        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- NAVIGATION -->
        <nav>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>

<!-- WELCOME -->
<div class="container">
    <h2>Welcome to Velvet Vogue!</h2>
    <p>
        Create a WOW effect wherever you go with our range of designs.
        It's the perfect combination of comfort & sleek. Let's explore.
    </p>
</div>

<!-- IMAGE ROW -->
<div class="image-row">
    <img src="images/products/image5.jpg" alt="Fashion">
    <img src="images/products/image2.jpg" alt="Style">
    <img src="images/products/image3.jpg" alt="Trends">
    <img src="images/products/faef88e2567a490059553a367e113acc.jpg" alt="Fashion">
    <img src="images/products/e7eee8840c7086e372aa4cf0599d7436.jpg" alt="Style">
    <img src="images/products/6b87ab96a3ad3006681beb43b5d6b7ba.jpg" alt="Trends">
</div>

<!-- NEW ARRIVALS -->
<div class="section">
    <h2> New Arrivals</h2>

    <div class="card-grid">

        <a href="product_details.php?id=47" style="text-decoration:none;">
            <div class="card">
                <img src="images/products/tashi-emb-maxi-dress-green-uk14-1767268167319.jpg" alt="">
                <h3>Floral Dress</h3>
                <p>Rs. 4,500</p>
            </div>
        </a>

        <a href="product_details.php?id=48" style="text-decoration:none;">
            <div class="card">
                <img src="images/products/d21c657d2bcf001189a164bf6d7ebd64.jpg" alt="">
                <h3>Men Casual Shirt</h3>
                <p>Rs. 3,200</p>
            </div>
        </a>

        <a href="product_details.php?id=49" style="text-decoration:none;">
            <div class="card">
                <img src="images/products/8ced7aef0c2cf7dace45693572eca549.jpg" alt="">
                <h3>Summer Top</h3>
                <p>Rs. 2,800</p>
            </div>
        </a>

    </div>
</div>

<!-- PROMOTIONS -->
<div class="section">
    <h2> Promotions</h2>

    <div class="card-grid">
        <div class="promo">
            🎉 Flat 20% OFF on New Arrivals  
            <br>Use Code: <b>VELVET20</b>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
