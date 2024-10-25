<?php
require "database.php";
session_start();
if (!isset($_SESSION['status']) || !isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $userName = $_SESSION['userName'];
    $card_number = $_POST['cardNumber'];
    $cvv = $_POST['cvv'];
    $exp_date = $_POST['expDate'];
    // Query to fetch user details based on username
    $sql = "SELECT * FROM carddetails WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($card_number = $row['card_number'] && $cvv = $row['cvv'] && $exp_date = $row['expiry_date']) {

            header("Location: otpVerify.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "User not found.";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>
    <div class="container mt-5">
        <h2 class="text-center">Login to Bank</h2>
        <div class="row justify-content-center">
            <div class="card col-md-4 p-1">
                <div class="card-body d-flex justify-content-center align-items-center 100vh">
                    <div class="col-md-6">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label for="username">Card Number</label>
                                <input type="text" class="form-control" id="username" name="cardNumber" placeholder="Enter your card number" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">CVV Number</label>
                                <input type="password" class="form-control" id="password" name="cvv" placeholder="Enter your cvv" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">Expiry Date</label>
                                <input type="date" class="form-control" id="username" name="expDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>