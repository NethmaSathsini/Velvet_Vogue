<?php
include "config/db.php";

/*FILTER LOGIC*/
$where = [];

if (!empty($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $where[] = "category = '$category'";
}

$sql = "SELECT * FROM products";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products - Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        background-image: url('images/eee.jpg'); 
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

        <!-- Logo area -->
        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>


<h2>Our Products</h2>

<form method="GET" class="filter-box">
    <select name="category">
        <option value="">Category</option>
        <option value="Men" <?php if(isset($_GET['category']) && $_GET['category']=="Men") echo "selected"; ?>>Men</option>
        <option value="Women" <?php if(isset($_GET['category']) && $_GET['category']=="Women") echo "selected"; ?>>Women</option>
    </select>
    <button type="submit">Filter</button>
</form>

<!-- Product listing container -->

<div class="products-container">
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

<!-- Single product card -->
    <div class="product-card">

        <a href="product_details.php?id=<?php echo $row['id']; ?>">
            <img src="images/products/<?php echo $row['image']; ?>" alt="Product">
        </a>

        <h3>
            <a href="product_details.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;color:#ff69b4;">
                <?php echo $row['name']; ?>
            </a>
        </h3>

        <p class="price">Rs. <?php echo $row['price']; ?></p>

        <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

            <select name="size" required>
                <option value="">Select Size</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
            </select>

            <select name="color" required>
                <option value="">Select Color</option>
                <option value="Black">Black</option>
                <option value="Pink">Pink</option>
                <option value="White">White</option>
            </select>

            <button class="add-cart-btn">Add to Cart</button>
        </form>

    </div>
<?php
    }
} else {
    echo "<p>No products found</p>";
}
?>
</div>

<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
