<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file or establish a database connection here
// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user_id is set in the POST data
    if (isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Update the 'verified' column in the database for the specified user_id
        $sql = "UPDATE  subscription_user SET verified = 1 WHERE id = :userId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $dbh->prepare('SELECT user_id FROM subscription_user WHERE id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user_id = $stmt->fetchColumn();

        $sql = "UPDATE user SET role = 1 WHERE user_id = :userId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Execute the update query
        if ($stmt->execute()) {
            // Send email to student for verification
            sendVerificationEmailToStudent($dbh, $userId);

            // Verification successful, redirect back to the user list page
            header("Location: ../manage_student.php");
            exit();
        } else {
            // Error occurred during the update
            echo "Error updating verification status.";
        }
    } else {
        // user_id not set in the POST data
        echo "Invalid request. Missing user_id.";
    }
} else {
    // Redirect to an error page or handle unauthorized access
    header("Location: error.php");
    exit();
}

function sendVerificationEmailToStudent($dbh, $userId)
{
    // Fetch student's email based on user ID
    $stmt_student_email = $dbh->prepare("SELECT email FROM subscription_user WHERE id = :userId");
    $stmt_student_email->bindParam(':userId', $userId);
    $stmt_student_email->execute();
    $student_email = $stmt_student_email->fetchColumn();

    // Create email content
    $email_subject = "Account Verification Successful";
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
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Account Verification Successful</h1>
                <p>Dear User,</p>
                <p>We are pleased to inform you that your account has been successfully verified.</p>
                <p>You now have full access to your dashboard, where you can explore our services and features.</p>
                <p>Thank you for choosing Pen in Hand. We look forward to assisting you in your educational journey.</p>
                <p>Best regards,<br>Pen in Hand Team</p>
                <p>For any query : peninhand.official@gmail.com</p>

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
        $mail->addAddress($student_email);

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
