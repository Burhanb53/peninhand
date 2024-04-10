<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('../includes/config.php');

// Load Composer's autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if the teacher ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the teacher ID
    $teacherId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch teacher data from the database based on the ID
    $sql = "SELECT * FROM teacher WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $teacherId);
    $stmt->execute();
    $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if teacher data is found
    if ($teacherData) {
        // Toggle the active status
        $activeStatus = $teacherData['active'] == 1 ? 0 : 1;
        $updateSql = "UPDATE teacher SET active = :active WHERE id = :id";
        $updateStmt = $dbh->prepare($updateSql);
        $updateStmt->bindParam(':active', $activeStatus);
        $updateStmt->bindParam(':id', $teacherId);
        $updateStmt->execute();

        // Determine the email content based on the active status
        $emailContent = $activeStatus == 1 ? generateActiveEmailContent() : generateInactiveEmailContent();

        // Send email notification to the teacher
        sendEmail($teacherData['email'], $emailContent);

        // Redirect back to the teacher management page after updating
        header("Location: ../manage_teacher.php?id=$teacherId");
        exit();
    } else {
        echo "Teacher not found.";
    }
} else {
    echo "Teacher ID not provided.";
}

function generateActiveEmailContent()
{
    // Generate email content for active status
    return "
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
                    background-color: #ffffff;
                    border-radius: 10px;
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
                <h1>Account Status Update</h1>
                <p>Hello,</p>
                <p>Your account has been activated. You can now receive doubts for solving.</p>
                <p>Thank you for your cooperation.</p>
                <p>Regards,<br>Pen in Hand Team</p>
                <p>For any query : peninhand.official@gmail.com</p>

                <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

            </div>
        </body>
        </html>
    ";
}

function generateInactiveEmailContent()
{
    // Generate email content for inactive status
    return "
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
                    background-color: #ffffff;
                    border-radius: 10px;
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
                <h1>Account Status Update</h1>
                <p>Hello,</p>
                <p>Your account has been deactivated. You are currently unable to receive doubts for solving.</p>
                <p>Please contact the administration for further assistance.</p>
                <p>Regards,<br>Pen in Hand Team</p>
                <p>For any query : peninhand.official@gmail.com</p>

                <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

            </div>
        </body>
        </html>
    ";
}

function sendEmail($recipient, $content)
{
    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';

        // Email setup
        $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
        $mail->addAddress($recipient);
        $mail->Subject = 'Account Status Update';

        // Email body
        $mail->isHTML(true);
        $mail->Body = $content;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>
