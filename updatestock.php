<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
};
require "database.php";
$sql = "SELECT sn, p_name FROM productlist"; // Assuming 'id' is the primary key
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Store each row in an array
    }
}



if (isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $purchased = $_POST['purchased'];
    $productSelect = $_POST['productSelect'];
    $new = $quantity + $purchased;

    $sql = "UPDATE productlist SET quantity = $new WHERE sn = '$productSelect'";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Update Stock</title>
</head>

<body>



    <?php include "nav.php" ?>
    <div m-5>

        <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="card col-md-6">
                    <div class="card-body">
                    <h1 class="display-4 text-center mb-4">UPDATE STOCK</h1>
                        <form method="post">
                            <label for="name">Product Name</label>
                            <select class="form-control" id="productSelect" name="productSelect" required>
                                <option value="">Select a product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['sn']; ?>"><?php echo $product['p_name']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="form-group">
                                <label for="quantity">Quantity Available</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" readonly>
                            </div>

                            <label for="purchased">Purchased</label>
                            <input class="form-control" id="purchased" name="purchased" type="number" placeholder="Enter the purchased quantity">

                            <button class="btn btn-info mt-3" type="submit" name="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productSelect').on('change', function() {
                var productId = $(this).val(); // Get selected product ID

                $.ajax({
                    url: 'fetch_quantity.php', // Path to your PHP file
                    type: 'GET', // The method to use (GET/POST)
                    data: {
                        id: productId
                    }, // Data to send (the selected product ID)
                    dataType: 'json', // Expected response type (JSON)
                    success: function(response) {
                        console.log(response.quantity);
                        // Ensure that the response is a valid object before accessing its properties
                        if (response && !response.error) {
                            $('#quantity').val(response.quantity); // Set the quantity in the input
                        } else {
                            alert(response.error || "Unknown error occurred.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching quantity:', status, error);
                    }
                });
            });
        });
    </script>
</body>

</html>