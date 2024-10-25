<?php session_start();
if (!isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
};?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Product Details</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>

</head>

<body>
    <?php include "nav.php" ?>
    <div>
        <div class="container d-flex justify-content-center align-items-center">

            <h1 class="display-3 m-4">Update Product Details</h1>
        </div>
        <div class="container d-flex justify-content-center align-items-center">
        <table id=customers>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Cost</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            require_once "database.php";
            $sql = "SELECT * FROM productlist";  // Replace 'products' with your table name
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['p_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td> <a href="#"> Edit</a></td>
                        <td> <a href="#"> Delete</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>

    </div>
    </div>
    </div>
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-Yvpc+RXy8+5yUq9XqUyq+4o+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+4+X+
                <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>