<?php
// Database connection details
$host = 'localhost';    // or your server hostname
$dbname = 'ecommerce'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Now you can safely run queries using $conn
?>

