<?php
session_start();
error_reporting(0);
include('../includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $teacherId = $_POST['teacher_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    // Retrieve other form fields (e.g., gender, tech_stack, experience, etc.)

    // Update teacher details in the database
    $sql = "UPDATE teacher SET name = :name, email = :email, contact = :contact WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    // Bind form data to parameters
    $stmt->bindParam(':id', $teacherId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact', $contact);
    // Bind other form fields to parameters
    // Example: $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->execute();

    // Send email notification to the teacher
    sendEmail($email, generateEmailContent($name, $email, $contact));

    // Redirect to a confirmation page or back to the teacher management page
    header("Location: ../manage_teacher.php?id=$teacherId&updated=true");
    exit();
} else {
    // Redirect to an error page or back to the update form
    header("Location: update_teacher.php");
    exit();
}

function generateEmailContent($name, $email, $contact)
{
    // Generate email content
    return "
        <html>
        <head>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
            <h1>Teacher Details Updated by Admin</h1>
            <p>Hello $name,</p>
            <p>Your teacher details have been updated by the admin. Here are your updated details:</p>
            <table>
                <tr>
                    <th>Name</th>
                    <td>$name</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>$email</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>$contact</td>
                </tr>
                <!-- Add more rows for other details if needed -->
            </table>
            <p>Thank you for keeping your information up to date.</p>
            <p>Regards,<br>Pen in Hand Team</p>
            <p>For any query : peninhand.official@gmail.com</p>

            <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

        </body>
        </html>
    ";
}

function sendEmail($recipient, $content)
{
    // Include PHPMailer


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
        $mail->Subject = 'Teacher Details Updated by Admin';

        // Email body
        $mail->isHTML(true);
        $mail->Body = $content;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
