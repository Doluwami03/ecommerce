<?php
// Database connection details
require "database.php";

// Get product ID from the request
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch quantity for the selected product
$sql = "SELECT quantity FROM productlist WHERE sn = $productId"; // Adjust table and column names as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Return quantity as JSON
    echo json_encode(['quantity' => $row['quantity']]);
} else {
    // If no product found, return zero or handle error
    echo json_encode(['quantity' => 0]);
}


?>
