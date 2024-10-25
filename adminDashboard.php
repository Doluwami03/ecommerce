<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
};
require "database.php";
if (isset($_POST['submit'])) {


    extract($_POST);
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "images/" . $file_name;
    if (move_uploaded_file($tempname, $folder)) {
        ' <h2 class="alert alert-success" role = "alert" > file uploaded </h2>';
    } else {
        ' <h2 class="alert alert-danger" role = "alert" > file not uploaded <h2>';
    }

    $name = $_POST['name'];
    $category = $_POST['category'];
    $cost = $_POST['cost'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

$sql = "INSERT INTO productlist (p_name, category, cost, description, quantity, image) 
        VALUES ('$name', '$category', '$cost', '$description', '$quantity', '$file_name')";

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
    <title>Dashboard</title>
</head>

<body>
    <?php include "nav.php" ?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card col-md-6">
            <div class="card-body">
                <h1 class="display-4 text-center mb-4">ADD PRODUCT</h1>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input class="form-control" id="name" name="name" type="text" placeholder="Enter the product name" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option>Electronics</option>
                            <option>Mobile</option>
                            <option>Laptop</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input class="form-control" id="cost" name="cost" type="number" placeholder="Enter the product cost" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" id="description" name="description" type="text" placeholder="Enter the product description" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input class="form-control" id="quantity" name="quantity" type="number" placeholder="Enter the product quantity" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" placeholder="Upload product image">
                    </div>

                    <button class="btn btn-info mt-3 d-flex " type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

   
</body>

</html>