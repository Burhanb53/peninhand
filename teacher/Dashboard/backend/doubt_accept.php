<?php
session_start();
include('../../../includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if doubt_id is set in the URL
if(isset($_GET['doubt_id'])){
    $doubt_id = $_GET['doubt_id'];

    // Update doubt status to accepted
    $sql = "UPDATE doubt SET accepted = 1 WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);

    if ($stmt->execute()) {
        // Fetch user ID associated with the doubt
        $sql = "SELECT user_id FROM doubt WHERE doubt_id = :doubt_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':doubt_id', $doubt_id);
        $stmt->execute();
        $user_id = $stmt->fetchColumn();

        // Fetch user email using user ID
        $sql = "SELECT email FROM subscription_user WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $email = $stmt->fetchColumn();

        if ($email) {
            // Compose and send email
            sendAssignmentNotification($email);
        } else {
            // Handle case where email is not found
            // Redirect to an error page or perform any other action
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit(); // Stop further execution
        }
    } else {
        // Redirect to an error page or perform any other action
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(); // Stop further execution
    }
}

// Function to send assignment notification email
function sendAssignmentNotification($studentEmail)
{
    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';

        // Email setup
        $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
        $mail->addAddress($studentEmail);
        $mail->Subject = 'Teacher Assigned to Your Doubt - Pen in Hand';

        // Email content
        $mail->isHTML(true);
        $mail->Body = "
        <html>
            <head>
                <title>Teacher Assigned to Your Doubt - Pen in Hand</title>
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
                    .details {
                        font-size: 14px;
                        margin-bottom: 20px;
                    }
                    .footer {
                        font-size: 10px;
                        color: #999;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Teacher Assigned to Your Doubt - Pen in Hand</h1>
                    <p>Hello,</p>
                    <p>We are pleased to inform you that a teacher has been assigned to your doubt.</p>
                    <p>Please login to your account to view the updated status.</p>
                    <p>Thank you for your patience.</p>
                    <p>Best regards,<br>Pen in Hand Team</p>
                    <p class='footer'>This is a system-generated email. Please do not reply.</p>
                </div>
            </body>
        </html>
    ";

        // Send email
        $mail->send();

        // Redirect to a success page or perform any other action
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(); // Stop further execution
    } catch (Exception $e) {
        // Log or handle the exception
        echo "Error: {$e->getMessage()}";
    }
}
?>
