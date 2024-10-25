<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraud Detection System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling for background and alignment */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .bg-img {
            background-image: url('your-background-image-url.jpg'); /* You can add any background image */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 50px;
            border-radius: 10px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .btn-custom {
            width: 150px;
            margin: 20px;
            padding: 15px;
            border-radius: 50px;
            font-size: 16px;
        }
    </style>
</head>
<body class="bg-success">

<div class="bg-img">
    <div class="container text-center">
        <h1>Fraud Detection System</h1>
        <p>Welcome to the system, please choose an option to log in:</p>
        <button class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#adminLoginModal">Admin Login</button>
        <button class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#userLoginModal">User Login</button>
    </div>
</div>

<!-- Admin Login Modal -->
<div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminLoginModalLabel">Admin Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="adminLogin.php" method="POST">
                    <div class="mb-3">
                        <label for="adminUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="adminUsername" name="adminUsername" placeholder="Enter admin username" required>
                    </div>
                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Login Modal -->
<div class="modal fade" id="userLoginModal" tabindex="-1" aria-labelledby="userLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLoginModalLabel">User Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="userLogin.php" method="POST">
                    <div class="mb-3">
                        <label for="userUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="userUsername" name="userUsername" placeholder="Enter user username" required>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
