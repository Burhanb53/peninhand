<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed



// Fetch email from the user table where role is 0 (assuming 'role' column contains role information)
$sql = "SELECT email FROM user WHERE role = 0";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compose the email subject and message
$subject = "No Subscription";
$message = "
<html>
            <head>
                <title>Subscription Ended</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #f9f9f9;
                    }
                    h1,h3 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                </style>
            </head>
            <body>
            <div class='container'>
                <h1>Dear User,</h1>
                    <p>You are currently not subscribed to our services. Subscribe now to enjoy exclusive benefits.</p>
                    <p>Best regards,<br>Pen in Hand</p>
                    <p class='disclaimer'>This is a computer-generated email. Please do not reply.</p>
                </div>
            </body>
            </html>

";

// Send email using PHPMailer for each user
foreach ($users as $user) {
    $email = $user['email'];

    // Send the email using PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@mybazzar.me';
    $mail->Password = 'Burh@n60400056';
    $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
    $mail->addAddress($email, 'User'); // Add recipient's email and name
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
        // Email sent successfully
        echo "Mail sent successfully to $name ($email)!<br>";
    } else {
        // Failed to send email
        echo "Failed to send email to $name ($email)!<br>";
        echo "Error: " . $mail->ErrorInfo . "<br>";
    }
}
