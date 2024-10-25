<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
};

// Database connection
require "database.php";


$product_id = $_GET['id'];
$sql = "SELECT * FROM productlist WHERE sn = $product_id";  
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>

    <div class="container my-5">
        <?php if ($product) { ?>
            <div class="row">
                <div class="col-md-6">
                    <img src="images/<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['p_name']; ?>">
                </div>
                <div class="col-md-6">
                    <h1><?php echo $product['p_name']; ?></h1>
                    <p><?php echo $product['description']; ?></p>
                    <h4>Price: ₦<?php echo number_format($product['cost'], 2); ?></h4>
                    <p>Available Stock: <?php echo $product['quantity']; ?></p>

                    <!-- Quantity selection form -->
                    <form action="addToCart.php" method="post">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="<?php echo $product['quantity']; ?>" value="1">
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product['sn']; ?>">
                        <button type="submit" class="btn btn-success">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <p>Product not found</p>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>