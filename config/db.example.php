<?php

$host = "localhost";
$user = "root";
$pass = "YOUR_DATABASE_PASSWORD";
$db   = "velvet_vogue";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed");
}

?>