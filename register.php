<?php
include_once __DIR__ . "/config/db.php";

$error = "";
$success = "";

/*input validation+duplicate email check+password encryption+Insert Query*/

if (isset($_POST['register'])) {

    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($fullname == "" || $email == "" || $password == "") {
        $error = "All fields are required";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered";
        } 
        
        else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Registration successful! Please login.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
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

        <!-- Logo Image -->
        <div class="logo-area">
            <img src="images/logo.png" alt="Velvet Vogue Logo" class="site-logo">
            <span class="logo-text">Velvet Vogue</span>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="login.php">Login</a>
            <a href="login.php">Logout</a>
            <a href="support.php">Contact</a>
        </nav>

    </div>
</header>


<!-- MAIN CONTENT -->
<div class="container">

    <h2>Customer Registration</h2>

    <?php if ($error != "") { ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($success != "") { ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php } ?>

    <form method="POST">
        <label>Full Name</label><br>
        <input type="text" name="fullname" required><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br>

        <button type="submit" name="register">Register</button>
    </form>

    <p style="text-align:center; margin-top:15px;">
        Already have an account?
        <a href="login.php" style="color:#ff69b4;font-weight:bold;">Login</a>
    </p>

</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

<script src="../js/script.js"></script>

</body>
</html>
