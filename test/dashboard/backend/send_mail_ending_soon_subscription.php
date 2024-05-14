<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// CSS styles for the email
$cssStyles = "
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
h1 {
    color: #333;
}
p {
    color: #666;
}
    .disclaimer {
        font-size: 12px;
        color: #999;
    }
</style>
";

// Get the current date in MySQL format (YYYY-MM-DD)
$currentDate = date("Y-m-d");

// SQL query to select the rows with the maximum end_date for each email
$sql = "SELECT email, name, MAX(end_date) AS latest_end_date
        FROM subscription_user
        GROUP BY email";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$maxDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through each row with the maximum end_date for each email
foreach ($maxDates as $maxDate) {
    $email = $maxDate['email'];
    $name = $maxDate['name'];
    $latestEndDate = $maxDate['latest_end_date'];

    // Calculate the difference in days between the latest end_date and the current date
    $difference = strtotime($latestEndDate) - strtotime($currentDate);
    $remainingDays = floor($difference / (60 * 60 * 24));

    // Check if the difference is between 0 and 10 days
    if ($remainingDays >= 0 && $remainingDays <= 10) {
        // Compose the email subject and message
        $subject = "Subscription Ending Soon";
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
                    <h1>Dear $name,</h1>
                    <p>Your subscription is going to end in <h3>$remainingDays day(s) on $latestEndDate.</h3> Please renew your subscription to continue accessing our services.</p>
                    <p>Best regards,<br>Pen in Hand</p>
                    <p>This is a computer-generated email. Please do not reply.</p>
                </div>
            </body>
            </html>
        
        ";

        // Send the email using PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';
        $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
        $mail->addAddress($email, $name); // Add recipient's email and name
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
}
