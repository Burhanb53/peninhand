<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust the path as needed

session_start();
include('../../../includes/config.php');

if (isset(
    $_POST['name'], $_POST['contact'], $_POST['mother_name'], $_POST['mother_email'],
    $_POST['mother_contact'], $_POST['father_name'], $_POST['father_email'], $_POST['father_contact'],
    $_POST['address'], $_POST['city'], $_POST['state'], $_POST['pin'], $_POST['subscription_id'],
    $_POST['transaction_id'], $_SESSION['user_id'], $_FILES['photo'], $_POST['end_date']
)) {
    // Collect form data
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_SESSION['email']; // Assuming email is stored in session
    $contact = $_POST['contact'];
    $mother_name = $_POST['mother_name'];
    $mother_email = $_POST['mother_email'];
    $mother_contact = $_POST['mother_contact'];
    $father_name = $_POST['father_name'];
    $father_email = $_POST['father_email'];
    $father_contact = $_POST['father_contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $subscription_id = $_POST['subscription_id'];
    $transaction_id = $_POST['transaction_id'];
    $end_date = $_POST['end_date'];

    // File upload handling
    $targetDir = "../uploads/profile/";
    $fileName = basename($_FILES["photo"]["name"]);
    // Generate a unique ID
    $uniqueId = uniqid();
    // Append unique ID to the filename
    $fileName = $uniqueId . '_' . basename($fileName);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'jpeg', 'png');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            // Insert data into the database
            $sql = "INSERT INTO subscription_user (user_id, name, email, contact, photo, mother_name, mother_email, mother_contact, father_name, father_email, father_contact, address, city, state, pin, subscription_id, transaction_id, end_date) 
                    VALUES (:user_id, :name, :email, :contact, :photo, :mother_name, :mother_email, :mother_contact, :father_name, :father_email, :father_contact, :address, :city, :state, :pin, :subscription_id, :transaction_id, :end_date)";
            $stmt = $dbh->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':photo', $fileName);
            $stmt->bindParam(':mother_name', $mother_name);
            $stmt->bindParam(':mother_email', $mother_email);
            $stmt->bindParam(':mother_contact', $mother_contact);
            $stmt->bindParam(':father_name', $father_name);
            $stmt->bindParam(':father_email', $father_email);
            $stmt->bindParam(':father_contact', $father_contact);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':pin', $pin);
            $stmt->bindParam(':subscription_id', $subscription_id);
            $stmt->bindParam(':transaction_id', $transaction_id);
            $stmt->bindParam(':end_date', $end_date);

            if ($stmt->execute()) {
                // Email content for user
                $userMail = new PHPMailer();
                $userMail->isSMTP();
                $userMail->Host = 'smtp.hostinger.com';
                $userMail->Port = 587;
                $userMail->SMTPAuth = true;
                $userMail->Username = 'no-reply@mybazzar.me';
                $userMail->Password = 'Burh@n60400056';
                $userMail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
                $userMail->addAddress($email);
                $userMail->addReplyTo('no-reply@mybazzar.me', 'Pen in Hand');
                $userMail->isHTML(true);
                $userMail->Subject = 'Thank you for your registration';
                $userMail->Body = "<html>
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
                    <p>Dear $name,</p>
                    <p>Thank you for registering with Pen in Hand. Your registration details have been received successfully. We will review your submission and notify you once your account is activated.</p>
                    <table>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>$email</td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td>$contact</td>
                        </tr>
                        <tr>
                            <td>Mother's Name</td>
                            <td>$mother_name</td>
                        </tr>
                        <tr>
                            <td>Mother's Email</td>
                            <td>$mother_email</td>
                        </tr>
                        <tr>
                            <td>Mother's Contact</td>
                            <td>$mother_contact</td>
                        </tr>
                        <tr>
                            <td>Father's Name</td>
                            <td>$father_name</td>
                        </tr>
                        <tr>
                            <td>Father's Email</td>
                            <td>$father_email</td>
                        </tr>
                        <tr>
                            <td>Father's Contact</td>
                            <td>$father_contact</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>$address</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>$city</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>$state</td>
                        </tr>
                        <tr>
                            <td>PIN</td>
                            <td>$pin</td>
                        </tr>
                        <tr>
                            <td>Subscription ID</td>
                            <td>$subscription_id</td>
                        </tr>
                        <tr>
                            <td>Transaction ID</td>
                            <td>$transaction_id</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>$end_date</td>
                        </tr>
                    </table>
                    <p>We appreciate your interest in Pen in Hand.</p>
                    <p>Best regards,<br>Pen in Hand Team</p>
                    <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

                </body>
                </html>";
                $userMail->send();
                
                // Email content for admin
                $adminMail = new PHPMailer();
                $adminMail->isSMTP();
                $adminMail->Host = 'smtp.hostinger.com';
                $adminMail->Port = 587;
                $adminMail->SMTPAuth = true;
                $adminMail->Username = 'no-reply@mybazzar.me';
                $adminMail->Password = 'Burh@n60400056';
                $adminMail->setFrom('no-reply@mybazzar.me', 'Pen in Hand');
                $adminMail->addAddress('peninhand.official@gmail.com');
                $adminMail->addReplyTo('no-reply@mybazzar.me', 'Pen in Hand');
                $adminMail->isHTML(true);
                $adminMail->Subject = 'New Registration - Pen in Hand';
                $adminMail->Body = "<html>
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
                    <p>Hello,</p>
                    <p>A new user has registered with Pen in Hand. Here are the details:</p>
                    <table>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>$email</td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td>$contact</td>
                        </tr>
                        <tr>
                            <td>Mother's Name</td>
                            <td>$mother_name</td>
                        </tr>
                        <tr>
                            <td>Mother's Email</td>
                            <td>$mother_email</td>
                        </tr>
                        <tr>
                            <td>Mother's Contact</td>
                            <td>$mother_contact</td>
                        </tr>
                        <tr>
                            <td>Father's Name</td>
                            <td>$father_name</td>
                        </tr>
                        <tr>
                            <td>Father's Email</td>
                            <td>$father_email</td>
                        </tr>
                        <tr>
                            <td>Father's Contact</td>
                            <td>$father_contact</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>$address</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>$city</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>$state</td>
                        </tr>
                        <tr>
                            <td>PIN</td>
                            <td>$pin</td>
                        </tr>
                        <tr>
                            <td>Subscription ID</td>
                            <td>$subscription_id</td>
                        </tr>
                        <tr>
                            <td>Transaction ID</td>
                            <td>$transaction_id</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>$end_date</td>
                        </tr>
                    </table>
                    <p>Please review and activate the user's account.</p>
                    <p>Regards,<br>Pen in Hand Team</p>
                    <p style=\"font-size: 10px; color: #999; text-align: center;\" >This is an system-generated email. Please do not reply.</p>

                </body>
                </html>";
                $adminMail->send();
                
                header("Location: ../Pages/success_registration.html");
                exit();
            } else {
                handleRegistrationError("Error inserting data. Please try again.");
            }
        } else {
            handleRegistrationError("Error uploading file. Please try again.");
        }
    } else {
        handleRegistrationError("Invalid file format, please upload a JPG, JPEG or PNG file.");
    }
} else {
    handleRegistrationError("All fields are required. Please fill all the fields and try again.");
}

function handleRegistrationError($errorMessage) {
    $_SESSION['registration_message'] = $errorMessage;
    header("Location: ../Pages/error.php");
    exit();
}
?>
