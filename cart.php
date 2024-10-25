<?php
// Database connection
require "database.php";
session_start();

// Simulate user ID (replace with actual authentication logic)
$user_id = $_SESSION['userId'] ?? 1; // Replace with actual user authentication logic

// Fetch the cart items for the user
$sql = "SELECT cart.qty,  cart.pid, productlist.p_name, productlist.cost 
        FROM cart 
        JOIN productlist ON cart.pid = productlist.sn 
        WHERE cart.uid = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>

    <div class="container my-5">
        <h2>Your Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $item_total = $row['cost'] * $row['qty'];
                        $total += $item_total;
                        echo '
                    <tr>
                        <td>' . $row["p_name"] . '</td>
                        <td>₦' . number_format($row["cost"], 2) . '</td>
                        <td>' . $row["qty"] . '</td>
                        <td>₦' . number_format($item_total, 2) . '</td>
                        <td><a href="removeFromCart.php?product_id=' . $row["pid"] . '" class="btn btn-danger">Remove</a></td>
                    </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Your cart is empty.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="text-center">
            <h4 class="mb-4">Total: ₦<?php echo number_format($total, 2); ?></h4>
            <?php
            if ($result->num_rows > 0) { ?>
                <a href="bankLogin.php" class="btn btn-success">Proceed to Checkout</a>
            <?php } ?>
        </div>

        <!-- Bootstrap JS -->
        <script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn->close();
?>