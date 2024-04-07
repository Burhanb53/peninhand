<?php
session_start();
include('../includes/config.php');

// Include the Composer autoloader file
require '../vendor/autoload.php';

// Use statements for PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';
$redirectUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Create a PDO instance
        $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the email is already registered
        $checkQuery = $dbh->prepare("SELECT user_id FROM user WHERE email = :email");
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {
            // User is already registered
            $_SESSION['registration_message'] = "User with this email is already registered. Please sign in.";
            $redirectUrl = "../Pages/sign-in.php";
        } else {
            // Generate a random 6-digit user_id
            $user_id = mt_rand(100000, 999999);

            // Insert user data into the database
            $insertQuery = $dbh->prepare("INSERT INTO user (user_id, email, password) VALUES (:user_id, :email, :password)");
            $insertQuery->bindParam(':user_id', $user_id);
            $insertQuery->bindParam(':email', $email);
            $insertQuery->bindParam(':password', $password);
            $insertQuery->execute();

            // Registration successful
            $_SESSION['registration_message'] = "Congratulations! You have successfully registered.";
            $redirectUrl = "../Pages/sign-in.php";

            // Create a new PHPMailer instance
            $mail = new PHPMailer();

            // SMTP Server Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@mybazzar.me';
            $mail->Password = 'Burh@n60400056';

            // Sender and recipient details
            $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
            $mail->addAddress($email);
            $mail->addReplyTo('no-reply@mybazzar.me', 'Pen in Hand');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Pen in Hand!';
            $mail->Body = '
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #E2C3E8;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 50px auto;
                            padding: 20px;
                            background-color: #fff;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        h1 {
                            color: #333;
                            text-align: center;
                        }
                        p {
                            color: #666;
                            font-size: 16px;
                            line-height: 1.6;
                            margin-bottom: 20px;
                        }
                        .btn {
                            display: inline-block;
                            padding: 10px 20px;
                            background-color: #007bff;
                            color: #fff;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Welcome to Pen in Hand!</h1>
                        <p>Dear User,</p>
                        <p>Thank you for registering on our website. We are excited to have you on board!</p>
                        <p>Please click the button below to sign in and start exploring our website:</p>
                        <p style="text-align: center;"><a href="http://www.example.com/sign-in" class="btn">Sign In</a></p>
                        <p>Best regards,<br>Pen in Hand Team</p>
                        <p style="font-size: 10px; color: #999; text-align: center;">This is an system-generated email. Please do not reply.</p>
                    </div>
                </body>
                </html>
            ';

            // Send the email
            $mail->send();
        }
    } catch (PDOException $e) {
        $_SESSION['registration_message'] = "Error: Failed to register user.";
        $redirectUrl = "../Pages/sign-up.php";
    } catch (Exception $e) {
        $_SESSION['registration_message'] = "Error: Failed to send registration confirmation email.";
        $redirectUrl = "../Pages/sign-up.php";
    } finally {
        // Close the database connection
        $dbh = null;
    }

    // Redirect after displaying the message
    header("Location: $redirectUrl");
    exit();
}
