<?php
session_start();
error_reporting(0);
include ('includes/config.php');

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
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Tables</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
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

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php include ('includes/navbar.php'); ?>
        <?php include ('includes/sidebar.php'); ?>
        <!-- END HEADER MOBILE-->


        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search"
                                    placeholder="Search for datas &amp; reports..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-comment-more"></i>
                                        <span class="quantity">1</span>
                                        <div class="mess-dropdown js-dropdown">
                                            <div class="mess__title">
                                                <p>You have 2 news message</p>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                                </div>
                                                <div class="content">
                                                    <h6>Michelle Moreno</h6>
                                                    <p>Have sent a photo</p>
                                                    <span class="time">3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
                                                </div>
                                                <div class="content">
                                                    <h6>Diane Myers</h6>
                                                    <p>You are now connected on message</p>
                                                    <span class="time">Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="mess__footer">
                                                <a href="#">View all messages</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">1</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="#">See all emails</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">john doe</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">john doe</a>
                                                    </h5>
                                                    <span class="email">johndoe@example.com</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="#">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">data table</h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <div class="rs-select2--light rs-select2--md">
                                            <select class="js-select2" name="property">
                                                <option selected="selected">All Properties</option>
                                                <option value="">Option 1</option>
                                                <option value="">Option 2</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <div class="rs-select2--light rs-select2--sm">
                                            <select class="js-select2" name="time">
                                                <option selected="selected">Today</option>
                                                <option value="">3 Days</option>
                                                <option value="">1 Week</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <button class="au-btn-filter">
                                            <i class="zmdi zmdi-filter-list"></i>filters</button>
                                    </div>
                                    <div class="table-data__tool-right">
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>add item</button>
                                        <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                            <select class="js-select2" name="type">
                                                <option selected="selected">Export</option>
                                                <option value="">Option 1</option>
                                                <option value="">Option 2</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
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
                                            <?php foreach ($teachers as $teacher): ?>
                                                <?php if ($teacher['active'] == 1): ?>
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
                                                                <input type="hidden" name="doubt_id"
                                                                    value="<?php echo $doubt_id; ?>">
                                                                <input type="hidden" name="teacher_id"
                                                                    value="<?php echo $teacher['teacher_id']; ?>">
                                                                <button type="submit">Assign</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
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
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const dataTable = document.getElementById("dataTable");

            searchInput.addEventListener("input", function () {
                const searchValue = searchInput.value.trim().toLowerCase();
                const rows = dataTable.getElementsByTagName("tr");

                for (let i = 1; i < rows.length; i++) { // Start loop from index 1 to skip header row
                    const row = rows[i];
                    const cells = row.getElementsByTagName("td");
                    let found = false;

                    for (let cell of cells) {
                        if (cell.textContent.toLowerCase().includes(searchValue)) {
                            found = true;
                            break;
                        }
                    }

                    if (searchValue === "") {
                        row.style.display = ""; // Show the row if search is empty
                        row.style.backgroundColor = ""; // Remove background color
                    } else if (found) {
                        row.style.display = ""; // Show the row if it matches search
                        // row.style.backgroundColor = "yellow"; // Highlight matching rows
                    } else {
                        row.style.display = "none"; // Hide rows that don't match search
                    }
                }
            });
        });
    </script>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->