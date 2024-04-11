<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../../vendor/autoload.php'; // Adjust the path as needed
require_once '../../../includes/config.php'; // Include the database configuration file

session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../Pages/sign-in.php"); // Change to your login page
    exit();
}

$redirectUrl = "../Pages/ask_doubt.php"; // Default redirect URL

// Prepare and bind the SQL statement
$stmt = $dbh->prepare("INSERT INTO doubt (doubt_id, user_id, doubt_category, doubt, doubt_file) VALUES (?, ?, ?, ?, ?)");
$stmt->bindParam(1, $doubt_id);
$stmt->bindParam(2, $_SESSION['user_id']);
$stmt->bindParam(3, $_POST['doubt_category']);

// Bind the doubt parameter
if (!empty($_POST['doubt'])) {
    $stmt->bindParam(4, $_POST['doubt']);
} else {
    $doubt = null;
    $stmt->bindParam(4, $doubt, PDO::PARAM_NULL);
}

// Generate a random 6-digit doubt_id
$doubt_id = mt_rand(100000, 999999);

// Initialize doubt_file variable
$doubt_file_name = null;
$doubt_file_path = null;

// File upload handling
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    // Define the target directory
    $target_dir = "../uploads/doubt/"; // Change to your desired directory

    // Generate a unique file name to avoid overwriting existing files
    $unique_id = uniqid();
    $target_file = $target_dir . $unique_id . '_' . basename($file_name);

    // Move uploaded file to desired directory
    if (move_uploaded_file($file_tmp, $target_file)) {
        $doubt_file_name = $unique_id . '_' . basename($file_name); // Set doubt_file_name to the uploaded file name
        $doubt_file_path = $target_file;
    }
}

// Bind the doubt_file parameter
$stmt->bindParam(5, $doubt_file_name);

// Execute the statement
if ($stmt->execute()) {
    $message = "Doubt submitted successfully.";
    $_SESSION['message'] = "Doubt submitted successfully.";

    // Send email notification
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
    $mail->addAddress($_SESSION['email']); // Assuming email is stored in session
    $mail->addReplyTo('no-reply@mybazzar.me', 'Pen in Hand');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Doubt Submission Confirmation';
    $mail->Body = "<html>
                    <head>
                        <title>Doubt Submission Confirmation</title>
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
                            .notice {
                                font-size: 12px;
                                color: #999;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Doubt Submission Confirmation</h1>
                            <p>Dear User,</p>
                            <p>Your doubt has been submitted successfully. A teacher will be assigned shortly to solve your doubt.</p>
                            <div class='details'>
                                <p><strong>Doubt Category:</strong> {$_POST['doubt_category']}</p>
                                <p><strong>Doubt:</strong> {$_POST['doubt']}</p>
                                <p><strong>Doubt File:</strong> $doubt_file_name</p>
                            </div>
                            <p>If you have any further questions, feel free to contact us.</p>
                            <p>Best regards,<br>Pen in Hand Team</p>
                            <p class='notice'>This is an system-generated email. Please do not reply.</p>
                        </div>
                    </body>
                </html>";

    // Attach the doubt file
    if ($doubt_file_path !== null) {
        $mail->addAttachment($doubt_file_path);
    }

    $mail->send(); 
    
    // Send email notification to admin
    $adminMail = new PHPMailer();

    // SMTP Server Configuration for admin email
    $adminMail->isSMTP();
    $adminMail->Host = 'smtp.hostinger.com';
    $adminMail->Port = 587;
    $adminMail->SMTPAuth = true;
    $adminMail->Username = 'no-reply@mybazzar.me';
    $adminMail->Password = 'Burh@n60400056';

    // Sender and recipient details for admin email
    $adminMail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
    $adminMail->addAddress('peninhand.official@gmail.com');
    $adminMail->addReplyTo('no-reply@mybazzar.me', 'Pen in Hand');

    // Email content for admin
    $adminMail->isHTML(true);
    $adminMail->Subject = 'New Doubt Submission - Pen in Hand';
    $adminMail->Body = "<html>
                        <head>
                            <title>New Doubt Submission - Pen in Hand</title>
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
                            .notice {
                                font-size: 12px;
                                color: #999;
                                text-align: center;
                            }
                        </style>
                        </head>
                        <body>
                            <p>Hello Admin,</p>
                            <p>A new doubt has been submitted by a user. Please assign a teacher to solve the doubt.</p>
                            <div class='details'>
                                <p><strong>User ID:</strong> {$_SESSION['user_id']}</p>
                                <p><strong>Doubt Category:</strong> {$_POST['doubt_category']}</p>
                                <p><strong>Doubt:</strong> {$_POST['doubt']}</p>
                                <p><strong>Doubt File:</strong> $doubt_file_name</p>
                            </div>
                            <p>Best regards,<br>Pen in Hand Team</p>
                            <p class='notice'>This is an system-generated email. Please do not reply.</p>
                        </body>
                    </html>";

    // Attach the doubt file
    if ($doubt_file_path !== null) {
        $adminMail->addAttachment($doubt_file_path);
    }

    // Send the email to admin
    $adminMail->send();
} else {
    $message = "Error occurred while submitting doubt. Please try again.";
    $_SESSION['message'] = "Error occurred while submitting doubt. Please try again.";
}

// Close statement and connection
$stmt = null;
$dbh = null;

// Redirect with error message
header("Location: $redirectUrl");
exit();
