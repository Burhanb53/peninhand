<?php
session_start();
include('../../../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if doubt_id is set in the GET parameters
if(isset($_GET['doubt_id'])){
    $doubt_id = $_GET['doubt_id'];

    // Update the doubt record to set teacher_id to NULL
    $sql = "UPDATE doubt SET teacher_id = NULL WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Send email to admin for rejecting doubt
        sendRejectionEmailToAdmin($dbh, $doubt_id);

        // Redirect to chat history page
        header("Location: ../Pages/chat_history.php");
        exit(); // Stop further execution
    } else {
        // Redirect to an error page or perform any other action
        header("Location: ../Pages/chat_history.php");
        exit(); // Stop further execution
    }
}

function sendRejectionEmailToAdmin($dbh, $doubt_id)
{
    // Fetch teacher ID associated with the doubt
    $stmt_teacher_id = $dbh->prepare("SELECT teacher_id FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_teacher_id->bindParam(':doubt_id', $doubt_id);
    $stmt_teacher_id->execute();
    $teacher_id = $stmt_teacher_id->fetchColumn();

    // Fetch teacher's name based on teacher ID
    $stmt_teacher_name = $dbh->prepare("SELECT name FROM teacher WHERE teacher_id = :teacher_id");
    $stmt_teacher_name->bindParam(':teacher_id', $teacher_id);
    $stmt_teacher_name->execute();
    $teacher_name = $stmt_teacher_name->fetchColumn();

    // Create the HTML email template with inline CSS styles
    $email_body = "
        <html>
        <head>
            <style>
                /* CSS styles */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
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
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Doubt Rejection Notification</h1>
                <p>Hello Admin,</p>
                <p>The doubt with ID: <strong>$doubt_id</strong> has been rejected and is now unassigned.</p>
                <p>This doubt was previously assigned to Teacher: <strong>$teacher_name</strong> (ID: $teacher_id).</p>
                <p>Please take appropriate action.</p>
                <p>Regards,<br>Pen in Hand Team</p>
                <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

            </div>
        </body>
        </html>
    ";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';

        //Recipients
        $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
        $mail->addAddress('peninhand.official@gmail.com'); // Admin's email address

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Doubt Rejection Notification';
        $mail->Body = $email_body;

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
