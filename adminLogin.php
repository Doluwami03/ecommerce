<?php
session_start();
include 'database.php'; // Your database connection script

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminUsername = $_POST['adminUsername'];
    $adminPassword = $_POST['adminPassword'];

    // Check if credentials are empty
    if (!empty($adminUsername) && !empty($adminPassword)) {
        // Prepare the SQL query
        $query = "SELECT * FROM user WHERE username = ? AND status = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $adminUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        // If user exists
        if ($result->num_rows == 1) {
            $adminData = $result->fetch_assoc();
            // Verify the password
            if (password_verify($adminPassword, $adminData['password'])) {
                $_SESSION['admin'] = $adminUsername; // Save admin username in session
                $_SESSION['status'] = $adminData['status'];
                header("Location: adminDashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password.";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: index.php");
        exit();
    }
}

// Display error message if it exists
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>
