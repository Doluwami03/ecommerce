<?php
// Database connection


session_start();
require "database.php";


// Simulate user ID (or you could use session ID for guests)
$user_id = $_SESSION['userId'] ?? 1; // Replace with actual user authentication logic

// Fetch product details from the form
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Check if the product is already in the cart
$sql = "SELECT * FROM cart WHERE uid = $user_id AND pid = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If the product is already in the cart, update the quantity
    $sql = "UPDATE cart SET qty = quantity + $quantity WHERE uid = $user_id AND pid = $product_id";

} else {
    // If the product is not in the cart, insert a new row
    $sql = "INSERT INTO cart (uid, pid, qty) VALUES ($user_id, $product_id, $quantity)";
}

if ($conn->query($sql) === TRUE) {
    echo "Product added to cart successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

// Redirect back to cart page
header('Location: cart.php');
?>
