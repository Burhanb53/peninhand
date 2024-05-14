<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Get the current date in MySQL format (YYYY-MM-DD)
$currentDate = date("Y-m-d");

// SQL query to select the rows with the maximum end_date for each email
$sql = "SELECT email, MAX(end_date) AS latest_end_date
        FROM subscription_user
        GROUP BY email";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$maxDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch name and email for rows where end_date is less than current date
$users = array();
foreach ($maxDates as $row) {
    $email = $row['email'];
    $latestEndDate = $row['latest_end_date'];

    // Select name and email for rows where end_date is less than current date
    $sql = "SELECT name, email
            FROM subscription_user
            WHERE email = :email AND end_date = :latestEndDate AND end_date < :currentDate";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':latestEndDate', $latestEndDate, PDO::PARAM_STR);
    $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Add result to the users array
    if ($result) {
        $users[] = $result;
    }
}



// Check if any users found
if ($users) {
    // Include PHPMailer library

    // Loop through each user and send mail
    foreach ($users as $user) {
        // Prepare email content
        $to = $user['email'];
        $subject = "Subscription Ended";
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
                    h1 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Dear {$user['name']},</h1>
                    <p>Your subscription has ended. Please renew your subscription to continue accessing our services.</p>
                    <p>This is a computer-generated email. Please do not reply.</p>
                </div>
            </body>
            </html>
        ";

        // Send email using PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';
        $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        if ($mail->send()) {
            echo "Mail sent successfully!<br>";
        } else {
            echo "Error occurred while sending mail " . $mail->ErrorInfo . "<br>";
        }
    }
} else {
    echo "No users found with subscription ended.<br>";
}
