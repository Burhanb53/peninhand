<?php
session_start();
error_reporting(0);

// Database connection parameters
$host = 'localhost';
$dbname = 'peninhand';
$username = 'root';
$password = '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed
try {
    // Create a new PDO instance for database connection with username and password
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO attributes if needed
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if doubt_id and teacher_id are provided in the URL
    if (isset($_GET['doubt_id']) && isset($_GET['teacher_id'])) {
        // Sanitize and store the parameters
        $doubt_id = htmlspecialchars($_GET['doubt_id']);
        $teacher_id = htmlspecialchars($_GET['teacher_id']);

        // Prepare and execute the SQL query to update the teacher_id for the specified doubt_id
        $stmt = $pdo->prepare("UPDATE doubt SET teacher_id = :teacher_id WHERE id = :doubt_id");
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':doubt_id', $doubt_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch data from doubt table based on doubt_id
        $stmt = $pdo->prepare("SELECT * FROM doubt WHERE id = :doubt_id");
        $stmt->bindParam(':doubt_id', $doubt_id, PDO::PARAM_INT);
        $stmt->execute();
        $doubtData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($doubtData) {
            // Send email to the teacher
            sendEmailToTeacher($pdo, $teacher_id, $doubtData);
        } else {
            // Redirect to an error page if doubt data is not found
            header('Location: error_page.php');
            exit();
        }
    } else {
        // Redirect to an error page if doubt_id or teacher_id is not provided
        header('Location: error_page.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
    die();
}

function sendEmailToTeacher($pdo, $teacher_id, $doubtData)
{
    // Fetch teacher email from teacher table
    $stmt = $pdo->prepare("SELECT email FROM teacher WHERE id = :teacher_id");
    $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
    $stmt->execute();
    $teacherEmail = $stmt->fetchColumn();

    if ($teacherEmail) {
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
            $mail->addAddress($teacherEmail);
            $mail->Subject = 'New Doubt Assigned - Pen in Hand';
            
            // Email content
            $mail->isHTML(true);
            $mail->Body = "<html>
                                <head>
                                    <title>New Doubt Assigned - Pen in Hand</title>
                                    <style><style>
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
                                </style>
        
                                </head>
                                <body>
                                    <p>Hello Teacher,</p>
                                    <p>A new doubt has been assigned to you:</p>
                                    <p><strong>Doubt Category:</strong> {$doubtData['doubt_category']}</p>
                                    <p><strong>Doubt:</strong> {$doubtData['doubt']}</p>";
            if (!empty($doubtData['doubt_file'])) {
                $mail->Body .= "<p><strong>Doubt File:</strong> {$doubtData['doubt_file']}</p>";
                // Attach doubt file
                $mail->addAttachment($doubtData['doubt_file']);
            }
            $mail->Body .= "<p>Please login to your account to view and solve the doubt.</p>
                                    <p>Thank you for your cooperation.</p>
                                    <p>Best regards,<br>Pen in Hand Team</p>
                                    <p>For any query : peninhand.official@gmail.com</p>
                                    <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

                                </body>
                            </html>";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    }
}
?>
