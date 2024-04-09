<?php
session_start();
include ('../../../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

// Check if doubt_id is set in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doubt_id = $_POST['doubt_id'];

    // Get form data
    $doubt = $_POST['doubt'] ?? null;
    $fileUpload = $_FILES['fileUpload'] ?? null;

    // Handle file upload
    $uploadedFileName = null;
    if (!empty ($fileUpload)) {
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $fileUpload['name'];
        // Move the uploaded file to the desired directory
        move_uploaded_file($fileUpload['tmp_name'], '../uploads/doubt/' . $uniqueFilename);
        // Store the unique filename in the database
        $uploadedFileName = $uniqueFilename;
    }

    // Update or insert data into the doubt table
    $sql_doubt = "UPDATE doubt 
                      SET doubt = COALESCE(:doubt, doubt),
                          " . ($uploadedFileName ? "doubt_file = :fileUpload," : "") . "
                          doubt_created_at = NOW(),
                          teacher_view = 0
                      WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->bindParam(':doubt', $doubt);
    if ($uploadedFileName) {
        $stmt_doubt->bindParam(':fileUpload', $uploadedFileName);
    }
    $stmt_doubt->execute();

    // Send email notifications
    
    $user_email = $_SESSION['email'];

    // Fetch admin email
    $admin_email = "peninhand.official@gmail.com";

    // Fetch teacher email
    $stmt_teacher = $dbh->prepare("SELECT t.email FROM doubt d INNER JOIN teacher t ON d.teacher_id = t.teacher_id WHERE d.doubt_id = ?");
    $stmt_teacher->execute([$doubt_id]);
    $teacher_email = $stmt_teacher->fetchColumn();

    // Email content for user
    $user_subject = "Doubt Updated";
    $user_body = "Your doubt with ID: $doubt_id has been updated. Please check your account for details.";

    // Email content for admin
    $admin_subject = "Doubt Updated - ID: $doubt_id";
    $admin_body = "A doubt with ID: $doubt_id has been updated. Please review.";

    // Email content for teacher
    $teacher_subject = "Doubt Update Notification";
    $teacher_body = "<html>
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
        .doubt-details {
            margin-bottom: 20px;
        }
        .doubt-details strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Doubt Update Notification</h1>
        <p>Dear Teacher,</p>
        <p>A doubt with the following details has been updated:</p>
        <div class='doubt-details'>
            <p><strong>Doubt ID:</strong> $doubt_id</p>
            <p><strong>Doubt:</strong> $doubt</p>
            <p><strong>Doubt File:</strong> $uploadedFileName</p>
        </div>
        <p>Regards,<br>Pen in Hand Team</p>
        <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

    </div>
</body>
</html>";

    // File path of the attachment
    $attachmentPath = '../uploads/doubt/' . $uploadedFileName;


    // Send email to teacher with attachment
    if (!empty($teacher_email) && !empty($uploadedFileName)) {
        sendEmailWithAttachment($teacher_email, $teacher_subject, $teacher_body, $attachmentPath);
    }

    // Redirect back
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    echo "Doubt ID is not set in the session.";
}

function sendEmailWithAttachment($recipient, $subject, $body, $attachmentPath)
{
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
        $mail->addAddress($recipient);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!empty($attachmentPath)) {
            // Attach file
            $mail->addAttachment($attachmentPath);
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
