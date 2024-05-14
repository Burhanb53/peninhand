<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if teachers data is sent via POST
if (isset($_POST['teachers'])) {
    // Get the selected teachers' data
    $selectedTeachers = $_POST['teachers'];

    // Loop through each selected teacher
    foreach ($selectedTeachers as $teacher) {
        $name = $teacher['name'];
        $email = $teacher['email'];

        // Compose the email content
        $subject = "Frequent Declining of Doubts";
        

        $message = "
            <html>
            <head>
                <title>Subscription Ended</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #f9f9f9;
                    }
                    h1 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                <h1>Dear Teacher,</h1>
                <p>We've noticed that you are declining student doubts more frequently than expected.</p>
                <p>Please ensure timely assistance to students to maintain the quality of education.</p>
                <p>Thank you for your cooperation.</p>
                <p>Sincerely,</p>
                <p>Team Pen In Hand</p>
                </div>
            </body>
            </html>
        ";
        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true); // Passing true enables exceptions

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@mybazzar.me';
            $mail->Password = 'Burh@n60400056';

            // Email setup
            $mail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send the email
            $mail->send();
            echo "Email sent to $name ($email) successfully.<br>";
        } catch (Exception $e) {
            echo "Failed to send email to $name ($email). Error: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No teachers selected.";
}
?>
