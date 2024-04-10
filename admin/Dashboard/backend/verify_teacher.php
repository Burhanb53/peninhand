<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config.php or establish database connection if not already included
include('../includes/config.php');
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the teacher_id is set in the POST data
    if (isset($_POST['teacher_id'])) {
        $teacherId = $_POST['teacher_id'];

        // Update the 'verified' column in the database for the specified teacher_id
        $sql = "UPDATE teacher SET verified = 1 WHERE id = :teacherId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            // Send verification success email to the teacher
            sendVerificationSuccessEmail($teacherId);

            // Redirect back to the teacher list page
            header("Location: ../manage_teacher.php");
            exit();
        } else {
            // Error occurred during the update
            echo "Error updating verification status.";
        }
    } else {
        // teacher_id not set in the POST data
        echo "Invalid request. Missing teacher_id.";
    }
} else {
    // Redirect to an error page or handle unauthorized access
    header("Location: error.php");
    exit();
}

// Function to send verification success email to the teacher
function sendVerificationSuccessEmail($teacherId) {
    global $dbh;

    // Fetch teacher's email based on teacher ID
    $stmt_teacher_email = $dbh->prepare("SELECT email FROM teacher WHERE id = :teacherId");
    $stmt_teacher_email->bindParam(':teacherId', $teacherId);
    $stmt_teacher_email->execute();
    $teacherEmail = $stmt_teacher_email->fetchColumn();

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
        $mail->Subject = 'Your Application Verification';
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
                    .button {
                        display: inline-block;
                        background-color: #007bff;
                        color: #fff;
                        padding: 10px 20px;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    .button:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Dear Teacher,</h2>
                    <p>Congratulations! Your application has been successfully verified. You are now a verified member of our teaching community.</p>
                    <p>You can now access your dashboard and start solving doubts assigned by the admin.</p>
                    <p>Thank you for joining us!</p>
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
?>
