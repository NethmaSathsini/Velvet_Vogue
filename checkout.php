<?php
session_start();
include "config/db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "checkout.php";
    echo "<script>
        alert('Before placing your order, please register or login.');
        window.location.href = 'register.php';
    </script>";
    exit();
}

/* CART TOTAL */
$total = $_SESSION['cart_total'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Velvet Vogue</title>
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

        <!-- LOGO AREA -->
        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- NAVIGATION -->
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>

<div class="container">

<?php
if (!isset($_POST['place_order'])): ?>

    <h2>Checkout</h2>

    <h3>Order Summary</h3>

    <?php if (!empty($_SESSION['cart'])): ?>

        <?php
        $product_ids = [];
        foreach ($_SESSION['cart'] as $item) {
            $product_ids[] = $item['product_id'];
        }
        $product_ids = array_unique($product_ids);
        $ids = implode(",", $product_ids);

        $query = "SELECT * FROM products WHERE id IN ($ids)";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)):
            foreach ($_SESSION['cart'] as $item):
                if ($item['product_id'] == $row['id']): ?>
                    <p>
                        <strong><?php echo $row['name']; ?></strong><br>
                        Size: <?php echo $item['size']; ?> |
                        Color: <?php echo $item['color']; ?> |
                        Qty: <?php echo $item['qty']; ?><br>
                        Price: Rs. <?php echo $row['price']; ?>
                    </p>
                    <hr>
                <?php endif;
            endforeach;
        endwhile; ?>

    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <div class="total-box">
        <strong>Total Amount: Rs. <?php echo $total; ?></strong>
    </div>

    <hr>

    <!-- Checkout Form -->

    <h3>Customer Details</h3>

    <form method="POST">

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="address" placeholder="Delivery Address" required></textarea>

        <h3>Payment Details</h3>

        <select name="payment_method" required>
            <option value="">Select Payment Method</option>
            <option value="Card">Card Payment</option>
            <option value="Cash">Cash on Delivery</option>
        </select>

        <input type="text" name="card_number" placeholder="Card Number (if card payment)">
        <input type="text" name="card_name" placeholder="Card Holder Name">
        <input type="text" name="otp" placeholder="OTP">

        <button type="submit" name="place_order">Place Order</button>
    </form>

<?php else:

    // ✅ INSERT ORDER INTO DATABASE
    $invoice_id = "VV-" . rand(100000, 999999);
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total_amount = $total;

    // Insert into orders table
    $order_query = "INSERT INTO orders (invoice_id, user_id, customer_name, email, address, payment_method, total_amount)
                    VALUES ('$invoice_id', '$user_id', '$name', '$email', '$address', '$payment_method', '$total_amount')";

    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);

        // Insert each cart item into order_items
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $size = $item['size'];
            $color = $item['color'];
            $qty = $item['qty'];

            $product_res = mysqli_query($conn, "SELECT price FROM products WHERE id='$product_id'");
            $product_row = mysqli_fetch_assoc($product_res);
            $price = $product_row['price'];

            $item_query = "INSERT INTO order_items (order_id, product_id, size, color, quantity, price)
                           VALUES ('$order_id', '$product_id', '$size', '$color', '$qty', '$price')";
            mysqli_query($conn, $item_query);
        }

        // Clear cart
        unset($_SESSION['cart']);
        unset($_SESSION['cart_total']);

        echo "<h2 style='color:green;'>Your Order Placed Successfully!</h2>";
        echo "<p><strong>Invoice ID:</strong> $invoice_id</p>";
        echo "<p><strong>Total:</strong> Rs. $total_amount</p>";
        echo "<p>Thank you for shopping with Velvet Vogue!</p>";

    } else {
        echo "<p style='color:red;'>Error placing order: " . mysqli_error($conn) . "</p>";
    }

endif; ?>

</div>

<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
