<?php
// Database connection
require "database.php";

session_start();

// Simulate user ID (replace with actual authentication logic)
$user_id = $_SESSION['userId'] ?? 1; // Replace with actual user authentication logic

$product_id = $_GET['product_id'];

// Delete the product from the cart
$sql = "DELETE FROM cart WHERE uid = $user_id AND pid = $product_id";

if ($conn->query($sql) === TRUE) {
    echo "Product removed from cart successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

// Redirect back to the cart page
header('Location: cart.php');
?>
