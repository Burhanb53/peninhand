<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config_index.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if ID parameter is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from subscription_user table
    $stmt = $pdo->prepare("SELECT * FROM subscription_user WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //delete user from subscription_user table
    $stmt = $pdo->prepare("DELETE FROM subscription_user WHERE id = ?");
    $stmt->execute([$userId]);

    

    // Check if user exists
    if($user) {
        // Extract user details
        $email = $user['email'];

        // Compose the email content
        $subject = "Subscription Denied";
        $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Subscription Denied</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 10px;
                    overflow: hidden;
                }
                .card {
                    padding: 20px;
                    border-bottom: 1px solid #e0e0e0;
                }
                h2,h4 {
                    color: #333333;
                    margin-top: 0;
                }
                p {
                    color: #666666;
                }
                .footer {
                    background-color: #f2f2f2;
                    padding: 20px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="card">
                    <h2>Subscription Denied</h2>
                    <p>Your subscription request has been denied by the admin. For further details, please contact support.</p>
                </div>
                <div class="footer">
                    <p>Best regards,<br>Pen in Hand</p>
                    <p>Thank you for your interest. For any queries, please contact support@peninhandeducation.com</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';

        // Email setup
        $mail->setFrom('no-reply@mybazzar.me', 'Pen In Hand');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        if($mail->send()) {
            echo '<script>window.history.go(-2);</script>';
            exit();
        } else {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'User not found';
    }
} else {
    echo 'User ID not provided';
}

?>
