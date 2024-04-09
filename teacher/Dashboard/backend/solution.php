<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include('../../../includes/config.php');
require '../../../vendor/autoload.php';

// Check if doubt_id is set in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doubt_id'])) {
    $doubt_id = $_POST['doubt_id'];

    // Get form data
    $solution = $_POST['solution'] ?? null;
    $fileUpload = $_FILES['fileUpload'] ?? null;
    $videoLink = $_POST['videoLink'] ?? null;
    $joinCode = $_POST['joinCode'] ?? null;

    // Handle file upload
    $uploadedFileName = null;
    if (!empty ($fileUpload['name'])) {
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $fileUpload['name'];
        // Move the uploaded file to the desired directory
        move_uploaded_file($fileUpload['tmp_name'], '../uploads/doubt/' . $uniqueFilename);
        // Store the unique filename in the database
        $uploadedFileName = $uniqueFilename;
    }

    // Update or insert data into the doubt table
    $sql_doubt = "UPDATE doubt 
                      SET answer = COALESCE(:solution, answer),
                          " . ($uploadedFileName ? "answer_file = :fileUpload," : "") . "
                          answer_created_at = NOW(),
                          student_view = 0
                      WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->bindParam(':solution', $solution);
    if ($uploadedFileName) {
        $stmt_doubt->bindParam(':fileUpload', $uploadedFileName);
    }
    $stmt_doubt->execute();

    // Update or insert data into the video_call table
    if ($videoLink != 'null' && $joinCode != 'null' && $videoLink != '' && $joinCode != '') {
        // Prepare SQL statement
        $sql_video_call = "REPLACE INTO video_call (doubt_id, videocall_link, join_code)
                               VALUES (:doubt_id, :videoLink, :joinCode)";
        
        // Execute SQL statement
        $stmt_video_call = $dbh->prepare($sql_video_call);
        $stmt_video_call->bindParam(':doubt_id', $doubt_id);
        $stmt_video_call->bindParam(':videoLink', $videoLink);
        $stmt_video_call->bindParam(':joinCode', $joinCode);
        $stmt_video_call->execute();
    }

    // Fetch user's email using doubt_id
    $stmt_user_email = $dbh->prepare("SELECT u.email FROM doubt d INNER JOIN user u ON d.user_id = u.user_id WHERE d.doubt_id = ?");
    $stmt_user_email->execute([$doubt_id]);
    $user_email = $stmt_user_email->fetchColumn();

    if ($user_email) {
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
            $mail->addAddress($user_email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Doubt Resolution';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                        margin: 0;
                        padding: 0;
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
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    .solution {
                        background-color: #f9f9f9;
                        padding: 15px;
                        border-radius: 5px;
                        margin-bottom: 20px;
                    }
                    .solution p {
                        margin: 0;
                    }
                    .solution strong {
                        color: #007bff;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Doubt Resolution</h1>
                    <div class='solution'>
                        <p>Hello,</p>
                        <p>Your doubt has been resolved. Here is the solution:</p>
                        <p>" . $solution . "</p>
                        <table>";
        
        // Check if video link is provided and add it to the email body
        if ($videoLink) {
            $mail->Body .= "<tr>
                                <th>Video Link</th>
                                <td>$videoLink</td>
                            </tr>";
        }
        
        // Check if join code is provided and add it to the email body
        if ($joinCode) {
            $mail->Body .= "<tr>
                                <th>Join Code</th>
                                <td>$joinCode</td>
                            </tr>";
        }
        
        $mail->Body .= "</table>
                    </div>
                </div>
                <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>
            </body>
            </html>";
        
        

            // Attach file if uploaded
            if (!empty($uploadedFileName)) {
                $attachmentPath = '../uploads/doubt/' . $uploadedFileName;
                $mail->addAttachment($attachmentPath);
            }

            // Send the email
            $mail->send();

            // Redirect back
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "User email not found.";
    }
} else {
    echo "Doubt ID is not set in the session.";
}
?>
