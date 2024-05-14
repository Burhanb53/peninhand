<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if the ID and status parameters are provided in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    // Sanitize the input
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $status = filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT);

    // Update the 'verified' column in the database
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=peninhand', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE teacher SET verified = :status WHERE id = :id');
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch teacherId from teacher table
        $stmt = $pdo->prepare('SELECT teacher_id FROM teacher WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $teacherId = $stmt->fetchColumn();

        // Update the 'role' column in the 'user' table based on status
        if ($status == 0) {
            $role = 0;
        } elseif ($status == 1) {
            $role = 2;
        }

        $sql = "UPDATE user SET role = :role WHERE user_id = :teacherId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
        $stmt->execute();


        // Send email notification to the teacher
        sendVerificationStatusEmail($id, $status);

        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Redirect to an error page or handle the case when parameters are missing
    header('Location: error.php');
    exit();
}

// Function to send verification status email to the teacher
function sendVerificationStatusEmail($teacherId, $status)
{
    global $dbh;

    // Fetch teacher's email based on teacher ID
    $stmt_teacher_email = $dbh->prepare("SELECT email FROM teacher WHERE id = :teacherId");
    $stmt_teacher_email->bindParam(':teacherId', $teacherId);
    $stmt_teacher_email->execute();
    $teacherEmail = $stmt_teacher_email->fetchColumn();

    // Determine the email subject and message based on the verification status
    $subject = ($status == 1) ? 'Your Account has been Verified' : 'Your Account Verification has been Cancelled';
    $message = ($status == 1) ? 'Congratulations! Your account has been successfully verified.' : 'We regret to inform you that your account verification has been cancelled. If you have any questions or concerns, please feel free to contact us.';

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
        $mail->addAddress($teacherEmail); // Teacher's email address

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                    }
                    .container {
                        max-width: 600px;
                        margin: 20px auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #007bff;
                    }
                    p {
                        font-size: 16px;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>$subject</h2>
                    <p>$message</p>
                    <p>Regards,<br>Pen in Hand</p>
                    <p>For any query : peninhand.official@gmail.com</p>

                    <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>
                </div>
            </body>
            </html>
        ";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
