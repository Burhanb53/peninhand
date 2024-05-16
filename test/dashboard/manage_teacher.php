<?php
session_start();
error_reporting(0);
include ('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
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
                                <th>Resume</th>
                                <th>Active</th>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $counter = 1; // Initialize the counter variable ?>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; ?>
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
                                    <td>
                                        <a href="../../teacher/Dashboard/uploads/resume/<?php echo $teacher['resume']; ?>" target="_blank">View Resume</a>
                                    </td>

                                    <td>
                                        <?php echo $teacher['active'] == 1 ? 'Active' : 'Not Active'; ?>
                                    </td>
                                    <td>
                                        <?php echo $teacher['verified'] == 1 ? 'Verified' : 'Not Verified'; ?>
                                        <!-- Show status -->
                                    </td>
                                    <td>
                                        <?php if ($teacher['verified'] == 0): ?>
                                            <form method="POST" action="backend/verify_teacher.php">
                                                <input type="hidden" name="teacher_id" value="<?php echo $teacher['id']; ?>">
                                                <button type="submit" class="btn btn-primary">Verify</button>
                                            </form>
                                        <?php else: ?>
                                            <!-- Update icon with a link to update_teacher.php -->
                                            <a href="backend/update_teacher.php?id=<?php echo $teacher['id']; ?>" title="Update">
                                                <?php if ($teacher['active'] == 1): ?>
                                                    <i style="padding-right: 5px;" class="fas fa-times text-danger"></i>
                                                <?php else: ?>
                                                    <i style="padding-right: 5px; color: #28a745;" class="fas fa-check"></i>
                                                <?php endif; ?>
                                            </a>
                                            <!-- Placeholder for another action icon -->
                                            <a href="view_teacher.php?id=<?php echo $teacher['id']; ?>" title="View Details">
                                                <i style="color: #000;" class="fas fa-info-circle"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
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
        function printTable() {
            var printContents = document.getElementById("dataTable");
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