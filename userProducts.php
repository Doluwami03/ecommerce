<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
};

// Database connection
require "database.php";

// Query to fetch products
$sql = "SELECT * FROM productlist WHERE quantity > 0";

$category_id = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($category_id)) {
    $sql .= " AND category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>

    <div class="row justify-content-end mt-4">
        <div class="col-md-4">
            <form method="GET" class="d-flex align-items-end">
                <div class="flex-grow-1 me-1">
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Laptop">Laptop</option>

                    </select>
                </div>
                <div class="col-md-6 align-self-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Loop through and display each product
                while ($row = $result->fetch_assoc()) {
                    echo '
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="images/' . $row["image"] . '" class="card-img-top" style="height : 250px" alt="' . $row["p_name"] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $row["p_name"] . '</h5>
                            <p class="card-text">Price: ₦' . number_format($row["cost"], 2) . '</p>
                            <a href="product_details.php?id=' . $row["sn"] . '" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                ';
                }
            } else {
                echo '<p>No products found</p>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn->close();
?>