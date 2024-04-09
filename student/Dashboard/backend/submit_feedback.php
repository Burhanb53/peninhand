<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
session_start();
include ('../../../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $doubt_id = $_POST['doubt_id'];
    $teacher_id = $_POST['teacher_id'];
    $satisfaction_level = $_POST['satisfied'];
    $feedback_text = $_POST['feedback'];

    // Prepare and execute SQL query to insert feedback into the database
    $sql_feedback = "INSERT INTO feedback (doubt_id, teacher_id, satisfaction_level, feedback_text) VALUES (:doubt_id, :teacher_id, :satisfaction_level, :feedback_text)";
    $stmt_feedback = $dbh->prepare($sql_feedback);
    $stmt_feedback->bindParam(':doubt_id', $doubt_id);
    $stmt_feedback->bindParam(':teacher_id', $teacher_id);
    $stmt_feedback->bindParam(':satisfaction_level', $satisfaction_level);
    $stmt_feedback->bindParam(':feedback_text', $feedback_text);
    $stmt_feedback->execute();

    // Prepare and execute SQL query to update the doubt table
    $sql_doubt = "UPDATE doubt SET teacher_view = 2, student_view = 2, feedback = 1 WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->execute();

    // Send email to teacher for feedback
    sendFeedbackEmailToTeacher($dbh, $teacher_id, $doubt_id, $satisfaction_level, $feedback_text);

    // Redirect to previous page using JavaScript
    echo '<script>window.history.back();</script>';
    exit;
}

function sendFeedbackEmailToTeacher($dbh, $teacher_id, $doubt_id, $satisfaction_level, $feedback_text)
{
    // Fetch teacher's email based on teacher ID
    $stmt_teacher_email = $dbh->prepare("SELECT email FROM teacher WHERE teacher_id = :teacher_id");
    $stmt_teacher_email->bindParam(':teacher_id', $teacher_id);
    $stmt_teacher_email->execute();
    $teacher_email = $stmt_teacher_email->fetchColumn();

    // Fetch doubt details
    $stmt_doubt_details = $dbh->prepare("SELECT * FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_doubt_details->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt_details->execute();
    $doubt_details = $stmt_doubt_details->fetch(PDO::FETCH_ASSOC);

    // Create email content
    $email_subject = "Feedback Received for Doubt ID: $doubt_id";
    $email_body = "
        <html>
        <head>
            <style>
                /* Your CSS styles here */
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
                .feedback-details {
                    margin-bottom: 20px;
                }
                .feedback-details strong {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Feedback Received</h1>
                <p>Dear Teacher,</p>
                <p>A feedback has been received for the doubt with ID: <strong>$doubt_id</strong>.</p>
                <div class='feedback-details'>
                    <p><strong>Doubt ID:</strong> $doubt_id</p>
                    <p><strong>Satisfaction Level:</strong> $satisfaction_level</p>
                    <p><strong>Feedback Text:</strong> $feedback_text</p>
                </div>
                <p>Please review and take any necessary action.</p>
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
        $mail->addAddress($teacher_email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $email_subject;
        $mail->Body = $email_body;

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        // Handle any exceptions
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
