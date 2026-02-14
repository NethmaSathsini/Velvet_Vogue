<?php
session_start();
include "config/db.php";

/*ADD TO CART (WITH SIZE & COLOR)*/
if (isset($_POST['product_id'], $_POST['size'], $_POST['color']) && !isset($_POST['action'])) {

    $id = (int)$_POST['product_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    $cart_key = $id . "_" . $size . "_" . $color;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['qty'] += 1;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'product_id' => $id,
            'size' => $size,
            'color' => $color,
            'qty' => 1
        ];
    }
}

/*UPDATE QUANTITY*/
if (isset($_POST['action'], $_POST['cart_key'])) {

    $cart_key = $_POST['cart_key'];

    if ($_POST['action'] === 'increase') {
        $_SESSION['cart'][$cart_key]['qty'] += 1;
    }

    if ($_POST['action'] === 'decrease') {
        $_SESSION['cart'][$cart_key]['qty'] -= 1;

        if ($_SESSION['cart'][$cart_key]['qty'] <= 0) {
            unset($_SESSION['cart'][$cart_key]);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart - Velvet Vogue</title>
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

        <!-- LOGO AREA -->
        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- NAVIGATION -->
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>

<!-- Cart Container -->

<div class="cart-container">
    <h2 style="color:#ff69b4;">Shopping Cart</h2>

<?php
if (!empty($_SESSION['cart'])) {

    $total = 0;

    echo "<table>";
    echo "<tr>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>";

    foreach ($_SESSION['cart'] as $cart_key => $item) {

        $id = $item['product_id'];
        $qty = $item['qty'];

        $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        $product = mysqli_fetch_assoc($result);

        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
?>

<tr>
    <td><?php echo $product['name']; ?></td>
    <td><?php echo $item['size']; ?></td>
    <td><?php echo $item['color']; ?></td>
    <td>Rs. <?php echo $product['price']; ?></td>

    <td>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="cart_key" value="<?php echo $cart_key; ?>">
            <input type="hidden" name="action" value="decrease">
            <button class="qty-btn">−</button>
        </form>

        <?php echo $qty; ?>

        <form method="POST" style="display:inline;">
            <input type="hidden" name="cart_key" value="<?php echo $cart_key; ?>">
            <input type="hidden" name="action" value="increase">
            <button class="qty-btn">+</button>
        </form>
    </td>

    <td>Rs. <?php echo $subtotal; ?></td>
</tr>

<?php
    }

    echo "</table>";
    echo "<p class='total'>Total: Rs. $total</p>";

    $_SESSION['cart_total'] = $total;

    echo "<a href='register.php' class='checkout-btn'>Proceed to Checkout</a>";

} else {
    echo "<p style='text-align:center;'>Your cart is empty.</p>";
}
?>

</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
