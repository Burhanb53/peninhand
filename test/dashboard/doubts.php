<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Fetch records where teacher_id is null
$sqlNull = "SELECT * FROM doubt WHERE teacher_id IS NULL";
$stmtNull = $dbh->query($sqlNull);
$doubtsNull = $stmtNull->fetchAll(PDO::FETCH_ASSOC);

// Fetch remaining records
$sqlRemaining = "SELECT * FROM doubt WHERE teacher_id IS NOT NULL";
$stmtRemaining = $dbh->query($sqlRemaining);
$doubtsRemaining = $stmtRemaining->fetchAll(PDO::FETCH_ASSOC);

// Combine the results
$doubts = array_merge($doubtsNull, $doubtsRemaining);


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
        .round-card {
            width: 12rem;
            height: 12rem;
            border-radius: 50%;
            text-align: center;
            padding: 2rem;
            overflow: hidden;
        }

        .count-wrapper {
            position: relative;
        }

        .count {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }

        .count-description {
            font-size: 1rem;
            color: #fff;
            margin-top: 1rem;
        }

        @media (max-width: 320px) {
            .round-card {
                width: 8rem;
                height: 8rem;
                padding: 1.5rem;
            }

            .count {
                font-size: 2rem;
            }

            .count-description {
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }
        }

        /* Animation */
        @keyframes count-up {
            from {
                transform: translateY(1rem);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .count {
            animation: count-up 1s ease-out;
        }
    </style>
    <style>
        .ask-doubt-btn-container {
            text-align: right;
        }

        .ask-doubt-btn {
            background-color: #3498db;
            /* Choose your button color */
            color: #fff;
            /* Choose your text color */
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .not-assigned {
            color: red;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
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

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">data table</h3>
                                <div class="table-data__tool">

                                    <div class="table-data__tool-right">
                                        <button onclick="printTable()" class="btn btn-primary">Print Table</button>

                                    </div>
                                </div>

                                <div style="overflow-x: auto;">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Doubt ID</th>
                                                <th>User ID</th>
                                                <th>Teacher ID</th>
                                                <th>Doubt Category</th>
                                                <th>Doubt</th>
                                                <th>Doubt File</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Answer</th>
                                                <th>Answer File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1; // Initialize the counter variable 
                                            ?>
                                            <?php foreach ($doubts as $doubt): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $counter; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $doubt['doubt_id']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $doubt['user_id']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $teacherId = $doubt['teacher_id'];
                                                        if ($teacherId !== null) {
                                                            echo $teacherId;
                                                        } else {
                                                            echo '<span class="not-assigned">Not Assigned</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $doubt['doubt_category']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $doubt['doubt']; ?>
                                                    </td>
                                                    <td>
                                                        <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>"
                                                            target="_blank">View File</a>
                                                    </td>
                                                    <td>
                                                        <?php $timestamp = strtotime($doubt['doubt_created_at']);
                                                        $date = date('d F Y', $timestamp);
                                                        $time = date('h:i A', $timestamp); ?>
                                                        <?php echo $date; ?>     <?php echo $time; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($doubt['teacher_id'] !== null): ?>
                                                            Doubt Accepted:
                                                            <?php echo $doubt['accepted'] == 1 ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                                        <?php else: ?>
                                                            <a href="assign_teacher.php?doubt_id=<?php echo $doubt['doubt_id']; ?>"
                                                                class="btn btn-primary">Assign Teacher</a>
                                                        <?php endif; ?>

                                                        <?php if ($doubt['accepted'] == 1): ?>
                                                            <br>Answer :
                                                            <?php echo $doubt['answer'] != null ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                                            <br>Feedback :
                                                            <?php echo $doubt['feedback'] == 1 ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($doubt['answer'] != null): ?>
                                                            <!-- <?php echo $doubt['answer']; ?> -->
                                                            <i class="fa fa-info-circle"
                                                                onclick="showAnswerAlert('<?php echo $doubt['answer']; ?>')"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-times-circle" style="color: red;"
                                                                onclick="showNotAnsweredAlert()"></i>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($doubt['answer_file'] !== null): ?>
                                                            <a href="../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>"
                                                                target="_blank">View File</a>
                                                        <?php endif; ?>
                                                    </td>

                                                    <!-- <td>
                                                                <?php echo $doubt['answer_created_at']; ?>
                                                            </td> -->
                                                </tr>
                                                <?php $counter++; // Increment the counter variable ?>
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
        function showAnswerAlert(answer) {
            alert("Answer: " + answer);
        }
        function showNotAnsweredAlert() {
            alert("Not answered");
        }
        function showDoubtAlert(doubt) {
            alert("Doubt: " + doubt);
        }

        function showNotAnsweredAlert() {
            alert("Not answered");
        }
        function printTable() {
            var printContents = document.querySelector(".table-data__tool-right").parentNode.nextSibling;
            var originalContents = document.body.innerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>All Teacher</title></head><body>');
            // printWindow.document.write('<h1>Table Contents</h1>');
            printWindow.document.write(printContents.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
            document.body.innerHTML = originalContents;
        }

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