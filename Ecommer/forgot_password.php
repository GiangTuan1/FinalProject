<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    
    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Add CSS Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .back-button {
            margin-top: 10px;
            background-color: #6c757d;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Forgot Password</h1>

    <?php
    // Database connection
    require 'config.php'; // Assuming config.php contains the database connection

    // Step 1: Display email input form (if no POST request)
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    ?>
        <form method="POST" action="forgot_password.php">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Submit</button>
        </form>
        <button class="back-button" onclick="window.location.href='login.php'">Back to Login page</button>
    <?php
    } else {
        // Step 2: Process when the user submits their email
        $email = $_POST['email'];
        
        // Check if the email exists in the users table
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        
        if ($result->num_rows > 0) {
            // If the email exists, display the password reset form
            ?>
            <form method="POST" action="forgot_password.php">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="submit">Change Password</button>
            </form>
            <button class="back-button" onclick="window.location.href='login.php'">Back to Login page</button>
            <?php
        } else {
            // If the email does not exist, show an error message and redirect back to the email input form
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Email does not exist!',
                    text: 'Please check your email again.',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'forgot_password.php'; // Redirect to the email input form
                });
            </script>";
        }
    }

    // Step 3: Process when the user changes their password (POST contains 'new_password' and 'confirm_password')
    if (isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['email'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $email = $_POST['email'];

        // Check if the new password matches the confirm password
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
            
            // Update the new password in the database
            if ($conn->query("UPDATE users SET password = '$hashed_password' WHERE email = '$email'")) {
                // Show success message and redirect to login page
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Password has been changed successfully!',
                        text: 'You will be redirected to the login page.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = 'login.php';
                    });
                </script>";
            } else {
                // Show error message using SweetAlert2
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred!',
                        text: 'Please try again later.',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        } else {
            // Show error message if passwords do not match
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords do not match!',
                    text: 'Please make sure both passwords are the same.',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'forgot_password.php'; // Redirect to the password reset form
                });
            </script>";
        }
    }
    ?>
</div>

</body>
</html>
