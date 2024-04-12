<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if doubt_id is set in the URL
if (isset($_GET['doubt_id'])) {
    $doubt_id = $_GET['doubt_id'];

    // Fetch the specific doubt details from your database based on doubt_id
    // This is assuming you have a 'doubt' table in your database
    $sql = "SELECT * FROM doubt WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);
    $stmt->execute();
    $doubt = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the doubt is found and proceed with the assignment form
    if ($doubt) {
        // Fetch the list of teachers from your database
        $sql = "SELECT * FROM teacher";
        $result = $dbh->query($sql);
        $teachers = $result->fetchAll(PDO::FETCH_ASSOC);

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_button'])) {
            $teacher_id = $_POST['teacher_id'];

            // Process the assignment here (e.g., update the database)
            // Redirect to assign.php after processing
            header('Location: assign.php');
            exit;
        }
    }
} else {
    // Redirect or handle the case where doubt_id is not provided in the URL
    header('Location: error_page.php');
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php'; // Adjust the path as needed

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve assigned teacher ID from the form
    $assigned_teacher_id = $_POST['teacher_id'];

    // Update the 'teacher_id' for the corresponding doubt in the 'doubt' table
    $updateSql = "UPDATE doubt SET teacher_id = :assigned_teacher_id WHERE doubt_id = :doubt_id";
    $updateStmt = $dbh->prepare($updateSql);
    $updateStmt->bindParam(':assigned_teacher_id', $assigned_teacher_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':doubt_id', $doubt_id, PDO::PARAM_INT); // Assuming $doubt_id is defined elsewhere
    $updateStmt->execute();

    // Call function to send email notification to the assigned teacher
    sendEmailToTeacher($dbh, $assigned_teacher_id, $doubt_id);

    // Redirect back to assign.php or wherever you want after updating the assignment
    header('Location: assign.php');
    exit;
}

// Function to send email to teacher
function sendEmailToTeacher($pdo, $teacher_id, $doubt_id)
{
    // Fetch teacher email from teacher table
    $stmt = $pdo->prepare("SELECT email FROM teacher WHERE teacher_id = :teacher_id");
    $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
    $stmt->execute();
    $teacherEmail = $stmt->fetchColumn();

    if ($teacherEmail) {
        // Fetch doubt data
        $stmt = $pdo->prepare("SELECT * FROM doubt WHERE doubt_id = :doubt_id");
        $stmt->bindParam(':doubt_id', $doubt_id, PDO::PARAM_INT);
        $stmt->execute();
        $doubtData = $stmt->fetch(PDO::FETCH_ASSOC);

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
                                <style>
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
                                    <p><strong>Doubt:</strong> {$doubtData['doubt']}</p>
                                    <p>Please login to your account to view and solve the doubt.</p>
                                    <p>Thank you for your cooperation.</p>
                                    <p>Best regards,<br>Pen in Hand Team</p>
                                    <p>For any query : peninhand.official@gmail.com</p>
                                    <p style=\"font-size: 10px; color: #999; text-align: center;\">This is a system-generated email. Please do not reply.</p>
                                </body>
                            </html>";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            // Log or handle the exception
            echo "Error: {$e->getMessage()}";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Directory</title>
    <link rel="icon" href="img/logo.png" type="image/png">

    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css">
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css">
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css">
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css">
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css">
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css">
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css">
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
    <style>
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="submit"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<body class="crm_body_bg">
    <?php include('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
        <div class="main_content_iner ">
            <div class="container-fluid p-0">

                <h1>Assign Teacher</h1>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <form id="searchForm">
                                <div class="search_field">
                                    <input id="searchInput" type="text" placeholder="Search Name ...">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <!-- Table Headings -->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Teacher ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Tech Stack</th>
                                <th>Experience</th>
                                <th>Active</th>
                                <!-- <th>Verified</th> -->
                                <th>Assign</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($teachers as $teacher) : ?>
                                <?php if ($teacher['active'] == 1) : ?>
                                    <tr>
                                        <td>
                                            <?php echo $teacher['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['teacher_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['gender']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['contact']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['city']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['state']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['tech_stack']; ?>
                                        </td>
                                        <td>
                                            <?php echo $teacher['experience']; ?>
                                        </td>
                                        <td class="stunning-text">
                                            <?php echo $teacher['active'] == 1 ? 'Yes' : 'No'; ?>
                                        </td>
                                        <td>
                                            <form id="assignForm" method="POST">
                                                <input type="hidden" name="doubt_id" value="<?php echo $doubt_id; ?>">
                                                <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">
                                                <button type="submit">Assign</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('assignForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the teacher_id and doubt_id from the form inputs
            var teacherId = document.querySelector('input[name="teacher_id"]').value;
            var doubtId = document.querySelector('input[name="doubt_id"]').value;

            // Show the popup message
            alert('Teacher Assigned Successfully\nTeacher ID: ' + teacherId + '\nDoubt ID: ' + doubtId);

            // Submit the form programmatically
            this.submit();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#dataTable tbody tr');

            input.addEventListener('input', function() {
                const searchTerm = input.value.trim().toLowerCase();

                tableRows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    const found = cells.some(cell => {
                        const cellText = cell.textContent.trim().toLowerCase();
                        const regex = new RegExp(searchTerm, 'gi');
                        const highlightedText = cellText.replace(regex, '<span style="background-color: yellow;">$&</span>');
                        cell.innerHTML = highlightedText;
                        return cellText.includes(searchTerm);
                    });

                    if (found) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Add your search logic here, such as updating the table based on the search term
            });

        });
    </script>


</body>

<script src="js/jquery1-3.4.1.min.js"></script>

<script src="js/popper1.min.js"></script>

<script src="js/bootstrap1.min.js"></script>

<script src="js/metisMenu.js"></script>

<script src="vendors/count_up/jquery.waypoints.min.js"></script>

<script src="vendors/chartlist/Chart.min.js"></script>

<script src="vendors/count_up/jquery.counterup.min.js"></script>

<script src="vendors/swiper_slider/js/swiper.min.js"></script>

<script src="vendors/niceselect/js/jquery.nice-select.min.js"></script>

<script src="vendors/owl_carousel/js/owl.carousel.min.js"></script>

<script src="vendors/gijgo/gijgo.min.js"></script>
<script src="js/chart.min.js"></script>

<script src="vendors/progressbar/jquery.barfiller.js"></script>

<script src="vendors/tagsinput/tagsinput.js"></script>

<script src="vendors/text_editor/summernote-bs4.js"></script>
<script src="vendors/apex_chart/apexcharts.js"></script>
<script src="js/custom.js"></script>


</html>