<?php
include "config/db.php";

if (!isset($_GET['id'])) {
    echo "Product not found";
    exit;
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
    echo "Product not found";
    exit;
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?> - Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        background-image: url('images/ppp.jpg'); 
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

        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>

<!-- Product Container -->

<div class="details-container">

    <div class="details-image">
        <img src="images/products/<?php echo $product['image']; ?>">
    </div>

    <div class="details-info">
        <h1><?php echo $product['name']; ?></h1>
        <div class="dress_code">Dress Code: <?php echo $product['dress_code']; ?></div>
        <p><?php echo $product['description']; ?></p>

        <div class="price">Rs. <?php echo $product['price']; ?></div>

        <div class="label">Available Sizes:</div>
        <?php foreach (explode(',', $product['sizes']) as $sizes) { ?>
            <span class="badge"><?php echo trim($sizes); ?></span>
        <?php } ?>

        <div class="label">Available Colors:</div>
        <?php foreach (explode(',', $product['colors']) as $colors) { ?>
            <span class="badge"><?php echo trim($colors); ?></span>
        <?php } ?>

    </div>

</div>
<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>
</body>
</html>
