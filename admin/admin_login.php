<?php
session_start();

/* ADMIN CREDENTIALS */
$admin_username = "admin";
$admin_password = "admin123";

$error = "";

if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['role'] = "admin";
        header("Location: add_product.php");
        exit();
    } else {
        $error = "Invalid admin username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        /* ADMIN page background image */
        background-image: url('../images/eee.jpg');
        background-size: cover;        /* cover whole screen */
        background-position: center;   /* center image */
        background-repeat: no-repeat;  /* no repeat */
        background-attachment: fixed;  /* fixed on scroll */
    }
    </style>

</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-container">

        <!-- LOGO AREA -->
        <div class="logo-area">
            <img src="../images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- NAVIGATION -->
        <nav>
            <a href="../index.php">Home</a>
            <a href="../products.php">Products</a>
        </nav>

    </div>
</header>

<div class="container">
    <h2 style="text-align:center;">Admin Login</h2>

    <?php if ($error) { ?>
        <p style="color:red; text-align:center;">
            <?= $error ?>
        </p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Admin Password" required>
        <button name="admin_login">Login</button>
    </form>
</div>

<footer>
    © 2026 Velvet Vogue. All Rights Reserved.
</footer>

<script src="../js/script.js"></script>

</body>
</html>
