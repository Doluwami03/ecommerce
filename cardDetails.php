<?php
require "database.php";
session_start();

if (!isset($_SESSION['status']) || !isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

$uis = $_SESSION['userId']; // User ID
$username = $_SESSION['userName'];
$card_type = $card_number = $cvv = $expiry_date = $phone = $email = $limit = "";

// Check if the user already has card details in the database
$sql = "SELECT * FROM carddetails WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uis);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User exists, fetch their data
    $row = $result->fetch_assoc();
    $card_type = $row['card_type'];
    $card_number = $row['card_number'];
    $cvv = $row['cvv'];
    $expiry_date = $row['expiry_date'];
    $phone = $row['phone'];
    $email = $row['email'];
    $limit = $row['spending_limit'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize it
    $card_type = mysqli_real_escape_string($conn, $_POST['fav_language']);
    $card_number = mysqli_real_escape_string($conn, $_POST['cardNumber']);
    $cvv = mysqli_real_escape_string($conn, $_POST['CVV']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiryDate']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $limit = mysqli_real_escape_string($conn, $_POST['limit']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password if it's updated
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if ($result->num_rows > 0) {
        // If user already exists, update the record
        $sql_update = "UPDATE carddetails SET card_type=?, card_number=?, cvv=?, expiry_date=?, phone=?, email=?, spending_limit=?";
        
        if (!empty($password)) {
            $sql_update .= ", password=?";
        }

        $sql_update .= " WHERE uid=?";

        $stmt = $conn->prepare($sql_update);
        if (!empty($password)) {
            $stmt->bind_param("ssssssssi", $card_type, $card_number, $cvv, $expiry_date, $phone, $email, $limit, $hashed_password, $uis);
        } else {
            $stmt->bind_param("sssssssi", $card_type, $card_number, $cvv, $expiry_date, $phone, $email, $limit, $uis);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Record updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        }
    } else {
        // Insert new record if the user doesn't exist
        $sql_insert = "INSERT INTO carddetails (card_type, card_number, cvv, expiry_date, phone, email, spending_limit, password, uid , userName) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '$username')";

        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("ssssssssi", $card_type, $card_number, $cvv, $expiry_date, $phone, $email, $limit, $hashed_password, $uis);

        if ($stmt->execute()) {
            echo "<script>alert('New record created successfully!');</script>";
        } else {
            echo "<script>alert('Error creating record: " . $conn->error . "');</script>";
        }
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
    <title>Card Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "nav.php" ?>
    <div class="container mt-5">
        <h2 class="text-center">Card Registration</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST">
                    <div class="form-group mb-2">
                        <label for="name" class="me-3">Card Type: </label>
                        <span>
                            <label for="Debit">Debit Card</label>
                            <input type="radio" id="Debit" name="fav_language" value="Debit Card" class="me-3" required
                                <?php echo ($card_type == "Debit Card") ? "checked" : ""; ?>>
                        </span>
                        <span>
                            <label for="Credit">Credit Card</label>
                            <input type="radio" id="Credit" name="fav_language" value="Credit Card" required
                                <?php echo ($card_type == "Credit Card") ? "checked" : ""; ?>>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control mb-2" id="cardNumber" name="cardNumber" placeholder="Enter your card number" required minlength="13" maxlength="19"
                            value="<?php echo htmlspecialchars($card_number); ?>">
                    </div>
                    <div class="form-group">
                        <label for="CVV">CVV</label>
                        <input type="password" class="form-control mb-2" id="CVV" name="CVV" placeholder="Enter your CVV" required minlength="3" maxlength="3"
                            value="<?php echo htmlspecialchars($cvv); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Expiry">Expiry</label>
                        <input type="date" class="form-control mb-2" id="Expiry" name="expiryDate" placeholder="Enter your expiry date" required
                            value="<?php echo htmlspecialchars($expiry_date); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control mb-2" id="phone" name="phone" placeholder="Enter your phone number" required
                            value="<?php echo htmlspecialchars($phone); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control mb-2" id="email" name="email" placeholder="Enter your email address" required
                            value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="form-group">
                        <label for="limit">Amount Limit</label>
                        <input type="number" class="form-control mb-2" id="limit" name="limit" placeholder="Enter your spending limit" required
                            value="<?php echo htmlspecialchars($limit); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Enter your password">
                    </div>
                    <?php if ($result->num_rows > 0) { ?>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Update</button>
                    <?php } else { ?>
                        <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to Access Card Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="loginEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                        </div>
                        <div class="text-danger" id="loginError" style="display:none;"></div>
                        <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show login modal if no card details
            <?php if ($result->num_rows === 0) { ?>
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            <?php } ?>

            // Handle login
            document.getElementById('loginBtn').addEventListener('click', function () {
                var email = document.getElementById('loginEmail').value;
                var password = document.getElementById('loginPassword').value;

                // AJAX request to validate login
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "login.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Close modal and refresh page
                            window.location.reload();
                        } else {
                            document.getElementById('loginError').innerText = response.message;
                            document.getElementById('loginError').style.display = 'block';
                        }
                    }
                };
                xhr.send("email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password));
            });
        });
    </script>
</body>

</html>
