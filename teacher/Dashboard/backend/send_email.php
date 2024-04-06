<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

// Create a new PHPMailer instance
$mail = new PHPMailer;

try {
    // SMTP Server Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@mybazzar.me';
    $mail->Password = 'Burh@n60400056';

    // Sender and recipient details
    $mail->setFrom('no-reply@mybazzar.me', 'Pen In Hand');
    $mail->addAddress('2022pietadburhanuddin013@poornima.org', 'Paawan');

    // Email content
    $mail->Subject = 'Dummy Email';
    $mail->Body = 'This is a dummy email message sent using PHPMailer with SMTP and testing for the Pen In Hand project.';

    // Send the email
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
