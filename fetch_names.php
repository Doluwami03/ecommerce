<?php
require"database.php";

// Fetch product names
$sql = "SELECT sn, Pname FROM productlist"; // Adjust this query as needed
$result = $conn->query($sql);
$names = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $names[] = $row; // Store each row in an array
    }
}

// Return names as JSON
header('Content-Type: application/json');
echo json_encode($names);


?>
