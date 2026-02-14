<?php
session_start();
include "../config/db.php";

/*increase Dress Code*/
$codeQuery = mysqli_query($conn, "SELECT dress_code FROM products ORDER BY id DESC LIMIT 1");
if ($codeQuery && mysqli_num_rows($codeQuery) > 0) {
    $row = mysqli_fetch_assoc($codeQuery);
    $lastCode = $row['dress_code'] ?? '';
    $number = 0;
    if ($lastCode !== '') {
        $number = (int) substr($lastCode, 2);
    }
    $number++;
    $nextDressCode = "VV" . str_pad($number, 3, "0", STR_PAD_LEFT);
} else {
    $nextDressCode = "VV001";
}

/*Add Product*/
if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $sizes = $_POST['sizes'];
    $colors = $_POST['colors'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "../images/products/" . $image_name;

    if (!file_exists("../images/products")) {
        mkdir("../images/products", 0777, true);
    }

    move_uploaded_file($image_tmp, $image_path);

    $query = "INSERT INTO products 
        (dress_code, name, description, price, category, sizes, colors, image) 
        VALUES 
        ('$nextDressCode', '$name', '$description', '$price', '$category', '$sizes', '$colors', '$image_name')";

    if (mysqli_query($conn, $query)) {
        $message = "Product added successfully!";
    } else {
        $message = "Error adding product: " . mysqli_error($conn);
    }
}

/*Update Product*/
if (isset($_POST['update_product'])) {

    $product_id = $_POST['product_id'];

    // get existing product
    $oldQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");
    $oldData = mysqli_fetch_assoc($oldQuery);

    // use new value or keep old value
    $name = !empty($_POST['name']) ? $_POST['name'] : $oldData['name'];
    $description = !empty($_POST['description']) ? $_POST['description'] : $oldData['description'];
    $price = !empty($_POST['price']) ? $_POST['price'] : $oldData['price'];
    $category = !empty($_POST['category']) ? $_POST['category'] : $oldData['category'];
    $sizes = !empty($_POST['sizes']) ? $_POST['sizes'] : $oldData['sizes'];
    $colors = !empty($_POST['colors']) ? $_POST['colors'] : $oldData['colors'];
    $image_name = $oldData['image'];

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "../images/products/" . $image_name;
        move_uploaded_file($image_tmp, $image_path);
    }

    $query = "UPDATE products SET
        name='$name',
        description='$description',
        price='$price',
        category='$category',
        sizes='$sizes',
        colors='$colors',
        image='$image_name'
        WHERE id='$product_id'";

    mysqli_query($conn, $query);

    $message = "Product updated successfully!";
}

/*Delete Product*/
if (isset($_POST['delete_product'])) {

    $product_id = $_POST['product_id'];
    mysqli_query($conn, "DELETE FROM products WHERE id='$product_id'");
    $message = "Product deleted successfully!";
}

/*Get all products*/
$allProductsQuery = mysqli_query($conn, "SELECT id, dress_code, name FROM products ORDER BY id DESC");
$products = [];
if ($allProductsQuery && mysqli_num_rows($allProductsQuery) > 0) {
    while ($row = mysqli_fetch_assoc($allProductsQuery)) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Products</title>
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
            <a href="admin_login.php">Logout</a>
        </nav>

    </div>
</header>

<div class="container">

    <h2>Admin Panel – Manage Products</h2>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    <!-- Add Product -->
    <form method="POST" enctype="multipart/form-data">
        <h3>Add Product</h3>

        <label>Dress Code (Auto)</label><br>
        <input type="text" name="dress_code" value="<?= $nextDressCode ?>" readonly><br>

        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        <input type="text" name="category" placeholder="Category" required>

        <input type="text" name="sizes" placeholder="Sizes (S, M, L, XL)" required>
        <input type="text" name="colors" placeholder="Colors (Red, Blue, Black)" required>

        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <hr>

    <!-- Update Product -->
    <form method="POST" enctype="multipart/form-data">
        <h3>Update Product</h3>

        <label>Select Product (Dress Code)</label><br>
        <select name="product_id" required>
            <option value="">--Select Product--</option>
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['dress_code'] ?> - <?= $p['name'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="text" name="name" placeholder="New Name">
        <textarea name="description" placeholder="New Description"></textarea>
        <input type="number" name="price" step="0.01" placeholder="New Price">
        <input type="text" name="category" placeholder="New Category">

        <input type="text" name="sizes" placeholder="Sizes (S, M, L, XL)">
        <input type="text" name="colors" placeholder="Colors (Red, Blue, Black)">

        <input type="file" name="image" accept="image/*">

        <button type="submit" name="update_product">Update Product</button>
    </form>

    <hr>

    <!-- Delete Product -->
    <form method="POST">
        <h3>Delete Product</h3>

        <label>Select Product (Dress Code)</label><br>
        <select name="product_id" required>
            <option value="">--Select Product--</option>
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['dress_code'] ?> - <?= $p['name'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit" name="delete_product">Delete Product</button>
    </form>

</div>

<footer>
    <p>© 2026 Velvet Vogue. All rights reserved.</p>
</footer>

</body>
</html>
