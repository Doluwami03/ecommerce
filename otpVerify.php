<?php
session_start();
if (!isset($_SESSION['status']) || !isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

require 'database.php'; // Assuming database connection is set up here

// Load Composer's autoloader for PHPMailer


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to generate OTP
$length = 6;
$otp = rand(pow(10, $length - 1), pow(10, $length) - 1); // Generate random 6-digit number


// Function to get user's IP address
function getUserIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to send OTP email using PHPMailer
function sendOTPEmail($toEmail, $otp)
{
    $mail = new PHPMailer(true);
    $user_ip = getUserIP();

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'toby20557@gmail.com'; // Your Gmail address
        $mail->Password = 'aafp wals xvyd xvwg'; // Your Gmail password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('toby20557@gmail.com', 'David');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: <b>{$otp}</b> <br/> Accessed from IP address: {$user_ip}<br/><br/> If you did not request this OTP, please ignore this email.";

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        throw new Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}



$userName = $_SESSION['userName'];
$sql = "SELECT * FROM carddetails WHERE userName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Handle form submission to request OTP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_otp'])) {
    $email = $row['email']; // Using email from database

    // Generate OTP
    $otp = rand(100000, 999999); // 6-digit OTP

    // Save OTP and expiration time (e.g., 10 minutes) in session
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiration'] = time() + (10 * 60); // OTP valid for 10 minutes

    // Send OTP to email using PHPMailer
    try {
        if (sendOTPEmail($email, $otp)) {
            echo "OTP has been sent to your email: " . $email;
        } else {
            throw new Exception("Failed to send OTP");
        }
    } catch (Exception $e) {
        error_log("Error sending OTP: " . $e->getMessage());
        echo "Error sending OTP: " . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request OTP</title>
</head>

<body>
    <h2>Request OTP</h2>
    <form method="POST">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email">
        <button type="submit" name="request_otp">Request OTP</button>
    </form>
</body>

</html>