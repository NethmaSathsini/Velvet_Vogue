<?php
session_start();
include "config/db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: checkout.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Velvet Vogue</title>
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
            <a href="products.php">Products</a>
            <a href="register.php">Register</a>
            <a href="login.php">Logout</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>

<!-- MAIN CONTENT -->
<div class="container">

    <h2 id="loginTitle">Customer Login</h2>

    <form method="POST">
        <label>Email</label><br>
        <input type="email" name="email" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br>

        <button type="submit" name="login">Login</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error-message'>$error</p>";
    }
    ?>

</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

<!-- Secret Admin Redirect Script -->
<script>
let clickCount = 0;
document.getElementById("loginTitle").addEventListener("click", function () {
    clickCount++;
    if (clickCount === 6) {
        window.location.href = "admin/admin_login.php";
    }
});
</script>

<script src="../js/script.js"></script>

</body>
</html>
