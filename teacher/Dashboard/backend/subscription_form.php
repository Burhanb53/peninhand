<?php
session_start();
include('../../../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

if (isset(
    $_POST['name'], $_POST['email'], $_POST['contact'], $_POST['age'], $_POST['gender'],
    $_POST['address'], $_POST['city'], $_POST['state'], $_POST['pin'],  $_FILES['photo'], $_FILES['resume'], $_POST['experience'], $_POST['tech_stack']
)) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $experience = $_POST['experience'];
    $tech_stack = $_POST['tech_stack'];

    // Check if user is already registered
    $stmt_check = $dbh->prepare("SELECT * FROM teacher WHERE teacher_id = :user_id");
    $stmt_check->bindParam(':user_id', $user_id);
    $stmt_check->execute();
    $user_exists = $stmt_check->fetch();

    if ($user_exists) {
        $errorMessage = "You are already registered.";
        $_SESSION['registration_message'] = $errorMessage;
        header("Location: ../Pages/error.php");
        exit();
    }

    $targetDirPhoto = "../uploads/profile/";
    $fileNamePhoto = basename($_FILES["photo"]["name"]);
    $uniqueId = uniqid();
    // Append unique ID to the filename
    $fileNamePhoto = $uniqueId . '_' . basename($fileNamePhoto);
    $targetFilePathPhoto = $targetDirPhoto . $fileNamePhoto;
    $fileTypePhoto = pathinfo($targetFilePathPhoto, PATHINFO_EXTENSION);

    $targetDirResume = "../uploads/resume/";
    $fileNameResume = basename($_FILES["resume"]["name"]);
    $uniqueId = uniqid();
    // Append unique ID to the filename
    $fileNameResume = $uniqueId . '_' . basename($fileNameResume);
    $targetFilePathResume = $targetDirResume . $fileNameResume;
    $fileTypeResume = pathinfo($targetFilePathResume, PATHINFO_EXTENSION);

    $allowImageTypes = array('jpg', 'jpeg', 'png');
    $allowResumeTypes = array('pdf');

    if (in_array($fileTypePhoto, $allowImageTypes) && in_array($fileTypeResume, $allowResumeTypes)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePathPhoto) && move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePathResume)) {
            $sql = "INSERT INTO teacher (teacher_id, name, email, contact, photo, age, gender, resume, tech_stack, experience, address, city, state, pin) 
                    VALUES (:user_id, :name, :email, :contact, :photo, :age, :gender, :resume, :tech_stack, :experience, :address, :city, :state, :pin)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':photo', $fileNamePhoto);
            $stmt->bindParam(':resume', $fileNameResume);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':tech_stack', $tech_stack);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':pin', $pin);

            if ($stmt->execute()) {
                // Send verification email to admin
                sendVerificationEmailToAdmin($name, $email, $contact, $age, $gender, $address, $city, $state, $pin, $experience, $tech_stack, $targetFilePathResume);

                header("Location: ../Pages/success_registration.html");
                exit();
            } else {
                $errorMessage = "Error inserting data. Please try again.";
            }
        } else {
            $errorMessage = "Error uploading file. Please try again.";
        }
    } else {
        $errorMessage = "Invalid file format, please upload a JPG, JPEG or PNG file for photo and a PDF file for resume.";
    }
    $_SESSION['registration_message'] = $errorMessage;
    header("Location: ../Pages/error.php");
    exit();
} else {
    $errorMessage = "All fields are required. Please fill all the fields and try again.";
    $_SESSION['registration_message'] = $errorMessage;
    header("Location: ../Pages/error.php");
    exit();
}

function sendVerificationEmailToAdmin($name, $email, $contact, $age, $gender, $address, $city, $state, $pin, $experience, $tech_stack, $resumeFilePath)
{
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
        $mail->addAddress('peninhand.official@gmail.com');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'New Teacher Registration - Verification Required';
        $mail->Body ="<html>
        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                    margin-bottom: 20px;
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
        <p>Hello Admin,</p>
        <p>A new teacher has registered and is waiting for verification. Below are the details:</p>
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
            <tr>
                <th>Age</th>
                <td>$age</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>$gender</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>$address, $city, $state, $pin</td>
            </tr>
            <tr>
                <th>Experience</th>
                <td>$experience</td>
            </tr>
            <tr>
                <th>Tech Stack</th>
                <td>$tech_stack</td>
            </tr>
        </table>
        <p>Please take necessary actions to verify the teacher account.</p>
        <p>Regards,<br>Pen in Hand Team</p>
        <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

        </body>
        </html>";

        // Attach the resume file
        $mail->addAttachment($resumeFilePath);

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        // Log any errors if needed
    }
}

?>
