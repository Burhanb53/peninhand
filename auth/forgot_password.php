<?php
session_start();
include('../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library
require '../vendor/autoload.php'; // Adjust the path as needed

// Database connection
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['error'] = "Failed to connect to the database.";
    header("Location: ../Pages/forgot_password.php");
    exit();
}

// Function to generate OTP
function generateOTP($length = 6) {
    return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}
// Generate OTP
$otp = generateOTP();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $checkQuery = $dbh->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $checkQuery->bindParam(':email', $email);
    $checkQuery->execute();
    $emailExists = (bool)$checkQuery->fetchColumn();

    if (!$emailExists) {
        // Email does not exist in the user table
        $_SESSION['error'] = "Email address not found.";
        header("Location: ../Pages/forgot_password.php");
        exit();
    }
    // Check if email exists in the user table
    try {
        $checkQuery = $dbh->prepare("SELECT COUNT(*) FROM otp WHERE email = :email");
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();
        $existingRecords = $checkQuery->fetchColumn();

        if ($existingRecords > 0) {
            // Update the existing record
            $updateQuery = $dbh->prepare("UPDATE otp SET otp = :otp, created_at = NOW() WHERE email = :email");
            $updateQuery->bindParam(':email', $email);
            $updateQuery->bindParam(':otp', $otp);
            $updateQuery->execute();
        } else {
            // Insert a new record
            $insertQuery = $dbh->prepare("INSERT INTO otp (email, otp, created_at) VALUES (:email, :otp, NOW())");
            $insertQuery->bindParam(':email', $email);
            $insertQuery->bindParam(':otp', $otp);
            $insertQuery->execute();
        }

        

        // Send OTP to the user's email address using PHPMailer
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
        $mail->Subject = 'Forgot Password OTP';
        $mail->Body = "<html>
                        <head>
                            <title>Forgot Password OTP</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f4f4f4;
                                    margin: 0;
                                    padding: 0;
                                }
                                .container {
                                    max-width: 600px;
                                    margin: 20px auto;
                                    padding: 20px;
                                    background-color: #fff;
                                    border-radius: 5px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                }
                                h1 {
                                    color: #007bff;
                                    text-align: center;
                                }
                                p {
                                    color: #555;
                                    font-size: 16px;
                                    line-height: 1.6;
                                    margin-bottom: 20px;
                                }
                                .otp {
                                    font-size: 24px;
                                    font-weight: bold;
                                    color: #007bff;
                                    text-align: center;
                                    margin-top: 20px;
                                    margin-bottom: 30px;
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
                            <div class='container'>
                                <h1>Forgot Password OTP</h1>
                                <p>Dear User,</p>
                                <p>You have requested to reset your password. Please use the OTP below to proceed:</p>
                                <div class='otp'>$otp</div>
                                <p>If you didn't request this, you can safely ignore this email.</p>
                                <p>Best regards,<br>Pen in Hand Team</p>
                                <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

                            </div>
                        </body>
                    </html>";

        if (!$mail->send()) {
            $_SESSION['error'] = "Failed to send OTP. Please try again.";
            header("Location: ../Pages/forgot_password.php");
            exit();
        }

        // Store email in session for verification
        $_SESSION['forgot_password_email'] = $email;

        // Redirect to OTP verification page
        header("Location: ../Pages/otp_verification.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to send OTP. Please try again.";
        header("Location: ../Pages/forgot_password.php");
        exit();
    }
}
?>
