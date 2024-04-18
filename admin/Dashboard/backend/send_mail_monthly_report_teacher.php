<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../../../vendor/autoload.php'; // Adjust the path as needed


// Get today's date
$today = date('Y-m-d');

// Determine the start and end dates based on today's date
if (date('d', strtotime($today)) < 15) {
    // If today's date is before the 15th, fetch data from the previous month
    $startDate = date('Y-m-01', strtotime('first day of previous month'));
    $endDate = date('Y-m-t', strtotime('last day of previous month'));
} else {
    // If today's date is on or after the 15th, fetch data from the current month
    $startDate = date('Y-m-01');
    $endDate = date('Y-m-t');
}

// Fetch unique user IDs and corresponding emails from the subscription_user table
// Replace the database connection details with your own
$dbHost = 'localhost';
$dbName = 'peninhand';
$dbUser = 'root';
$dbPass = '';

try {
    $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch unique user IDs and corresponding emails
    $stmt = $dbh->prepare("SELECT DISTINCT teacher_id, email FROM teacher WHERE verified = 1");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through each user
    foreach ($users as $user) {
        $userId = $user['teacher_id'];
        $email = $user['email'];

        // Fetch total doubts count for the user within the specified month
        $stmt = $dbh->prepare("SELECT COUNT(*) AS total_doubts FROM doubt WHERE teacher_id = :teacher_id AND answer_created_at BETWEEN :start_date AND :end_date");
        $stmt->bindParam(':teacher_id', $userId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        $doubtCount = $stmt->fetch(PDO::FETCH_ASSOC)['total_doubts'];

        // Fetch unique doubt categories and their counts for the user within the specified month
        $stmt = $dbh->prepare("SELECT doubt_category, COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id AND answer_created_at BETWEEN :start_date AND :end_date GROUP BY doubt_category");
        $stmt->bindParam(':teacher_id', $userId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        $categoryDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch average satisfaction level for each doubt category
        $stmt = $dbh->prepare("SELECT d.doubt_category, ROUND(AVG(f.satisfaction_level)) AS average_satisfaction
            FROM doubt d
            INNER JOIN feedback f ON d.doubt_id = f.doubt_id
            WHERE d.teacher_id = :teacher_id AND d.answer_created_at BETWEEN :start_date AND :end_date
            GROUP BY d.doubt_category");
        $stmt->bindParam(':teacher_id', $userId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        $satisfactionLevels = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Compose the email content
        $subject = "Monthly Report for Teacher";
        $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Monthly Report for Teacher</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 10px;
                    overflow: hidden;
                }
                .card {
                    padding: 20px;
                    border-bottom: 1px solid #e0e0e0;
                }
                h2,h4 {
                    color: #333333;
                    margin-top: 0;
                }
                p {
                    color: #666666;
                }
                .footer {
                    background-color: #f2f2f2;
                    padding: 20px;
                    text-align: center;
                }
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
            <div class="container">
                <h2>Monthly Report</h2>
                <div class="card">
                    <h2>Total Doubts</h2>
                    <p>Total doubts Solves in the previous month: <h4>' . $doubtCount . '</h4></p>
                </div>
                <div class="card">
                    <h2>Doubt Categories</h2>
                    <p>Doubt categories and their counts in the previous month:</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Doubt Category</th>
                                <th>No. of Doubts</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($categoryDetails as $category) {
                                $message .= '<tr>
                                    <td>' . $category['doubt_category'] . '</td>
                                    <td>' . $category['doubt_count'] . '</td>
                                </tr>';
                            }
                        $message .= '</tbody>
                    </table>
                </div>
                <div class="card">
                    <h2>Feedback Details</h2>
                    <p>Feedback satisfaction levels for doubt categories in the previous month:</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Doubt Category</th>
                                <th>Average Satisfaction Level</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($satisfactionLevels as $level) {
                                $message .= '<tr>
                                    <td>' . $level['doubt_category'] . '</td>
                                    <td>' . $level['average_satisfaction'] . ' Star(s)</td>
                                </tr>';
                            }
                        $message .= '</tbody>
                    </table>
                </div>
                <div class="footer">
                    <p>Here is the monthly report summarizing your teaching activities and student interactions. Review it for insights.</p>
                    <p>Regards,</p>
                    <p>Pen In Hand Team</p>
                    <p>Thank you for using our service. For any queries, please contact us at support@peninhand.com</p>
                    <p>This is a computer-generated email. Please do not reply.</p>
                </div>

            </div>
        </body>
        </html>
        ';


        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@mybazzar.me';
        $mail->Password = 'Burh@n60400056';

        // Email setup
        $mail->setFrom('no-reply@mybazzar.me', 'Pen In Hand');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        echo "Email sent to $email successfully.<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$dbh = null;
?>
