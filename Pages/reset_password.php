<?php
require_once "../includes/config.php";
session_start();

// Initialize the error_message variable
$error_message = "";

// Ensure that the email session variable is set
if (!isset($_SESSION['forgot_password_email'])) {
    // Redirect the user if the email session variable is not set
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['forgot_password_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate and ensure both passwords match
    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        // Hash the new password before updating the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        try {
            $update_sql = "UPDATE user SET password = ? WHERE email = ?";
            $stmt = $dbh->prepare($update_sql);
            $stmt->execute([$hashed_password, $email]);

            // Check if the password was successfully updated
            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = "Password updated successfully. Please sign in with your new password.";
                header("Location: ../Pages/sign-in.php"); // Redirect to the login page or a success page
                exit;
            } else {
                $error_message = "Error updating password.";
            }
        } catch (PDOException $e) {
            $error_message = "Error updating password: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Include your CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .login-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .password-input {
            position: relative;
        }

        .eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .eye::before {
            content: '👁️';
            /* Unicode eye symbol */
            font-size: 20px;
        }

        .eye:hover::before {
            content: '👁️‍🗨️';
            /* Unicode eye in speech bubble symbol */
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .submit-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="modal-content">
        <div class="login-form">
            <h4 style="text-align:center">Reset Password</h4>
            <?php if (!empty($error_message)) : ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="new_password">New Password (Minimum 8 characters.):</label>
                    <div class="password-input">
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                        <span class="eye" toggle="#new_password"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <div class="password-input">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        <span class="eye" toggle="#confirm_password"></span>
                    </div>
                </div>
                <button type="submit" class="submit-button">Reset Password</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(".eye").click(function() {
            var input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>

</html>