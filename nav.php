<?php include "database.php";

if (!isset($_SESSION['status'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
};

$status = $_SESSION['status'];

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Fraud Detection On Card</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-around" id="navbarSupportedContent">
            <?php if ($status == 1): ?>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminDashboard.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="updatestock.php">Update Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productDetails.php">View Product Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="newOrder.php">View New Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">View Previous Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            <?php elseif ($status == 0): ?>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="userProducts.php">Product Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="newOrder.php">View Transaction Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cardDetails.php">Card Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>