<?php
session_start();
include('../../../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if doubt_id is provided in the request
if(isset($_GET['doubt_id'])) {
    // Get the doubt_id from the request
    $doubt_id = $_GET['doubt_id'];

    try {
        // Prepare the SQL statement to update doubt_submit to 1
        $sql = "UPDATE doubt SET doubt_submit = 1 , student_view = 0 WHERE doubt_id = :doubt_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':doubt_id', $doubt_id);
        
        // Execute the update query
        $stmt->execute();

        // Send email to the student for chat ending and feedback request
        sendChatEndFeedbackEmail($dbh, $doubt_id);

        // Redirect back to the previous page using JavaScript
        echo '<script>window.history.back();</script>';
        exit();
    } catch(PDOException $e) {
        // Handle any errors that occur during the update process
        echo "Error updating doubt submit: " . $e->getMessage();
    }
} else {
    // If doubt_id is not provided in the request, display an error message or redirect to an error page
    echo "Error: doubt_id not provided";
}

function sendChatEndFeedbackEmail($dbh, $doubt_id) {
    // Fetch user_id associated with the doubt
    $stmt_user_id = $dbh->prepare("SELECT user_id FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_user_id->bindParam(':doubt_id', $doubt_id);
    $stmt_user_id->execute();
    $user_id = $stmt_user_id->fetchColumn();

    // Fetch user's email based on user ID
    $stmt_user_email = $dbh->prepare("SELECT email FROM user WHERE user_id = :user_id");
    $stmt_user_email->bindParam(':user_id', $user_id);
    $stmt_user_email->execute();
    $user_email = $stmt_user_email->fetchColumn();

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
                <h1>Chat Session Ended</h1>
                <p>Hello,</p>
                <p>The chat session for your doubt (ID: <strong>$doubt_id</strong>) has ended from the teacher's side.</p>
                <p>We would appreciate it if you could provide feedback on your chat experience.</p>
                <p>You can still modify your doubt if you are not satisfied with the answer.</p>
                <p>Please take a moment to share your feedback with us.</p>
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
        $mail->addAddress($user_email); // Student's email address

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Chat Session Ended - Feedback Request';
        $mail->Body = $email_body;

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
