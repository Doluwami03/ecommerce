<?php
require "database.php";
session_start();
if (!isset($_SESSION['status']) || !isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_type = mysqli_real_escape_string($conn, $_POST['fav_language']);
    $userName = $_SESSION['userName'];

    // Query to fetch user details based on username
    $sql = "SELECT * FROM carddetails WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($card_type = $row['card_type']) {

            header("Location:creditCardNumber.php");
            exit ();
        }
        else{
            $error = "Invalid Card Type";
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
    <title>Credit Card Type</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>
    <div class="container mt-5">
        <h2 class="text-center">Card Type</h2>
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
                            <label for="name" class="me-3">Card Type: </label> <br>

                                <label for="Debit">Debit Card</label>
                                <input type="radio" id="Debit" name="fav_language" value="Debit Card" class="me-3" required> <br>

                                <label for="Credit">Credit Card</label>
                                <input type="radio" id="Credit" name="fav_language" value="Credit Card" required> <br>

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