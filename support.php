<?php

$servername = "localhost";
$username = "root";    
$password = "";        
$dbname = "velvet_vogue"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission
if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_form (name, email, message)
            VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $success = "Your message has been sent successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
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

        <!-- Logo Image -->
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
            <a href="login.php">Logout</a>
        </nav>

    </div>
</header>

<div class="contact-form">
    <h2>Contact Us</h2>

    <?php if(isset($success)) { echo "<p class='success'>$success</p>"; } ?>
    <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST" action="">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Message</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>

    <!-- Separate Contact Details Box -->
<div class="contact-details-box">
    <h3>Contact Details</h3>
    <p><strong>Email:</strong> contact@velvetvogue.com</p>
    <p><strong>WhatsApp:</strong> +94 123 456 789</p>
    <p><strong>Facebook:</strong> <a href="https://www.facebook.com/velvetvogue" target="_blank">Velvet Vogue</a></p>
    <p><strong>Instagram:</strong> <a href="https://www.instagram.com/velvetvogue" target="_blank">@velvetvogue</a></p>
    <p><strong>TikTok:</strong> <a href="https://www.tiktok.com/@velvetvogue" target="_blank">@velvetvogue</a></p>
</div>
</div>

<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
