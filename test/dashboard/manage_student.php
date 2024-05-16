<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Fetch data from the 'user' table
$sql = "SELECT * FROM subscription_user";
$result = $dbh->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);
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
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Mother Name</th>
                                <th>Father Namge</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Subscription</th>
                                <th>Subscription Date</th>
                                <th>End Date</th>
                                <th>Transaction ID</th>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $counter = 1; // Initialize the counter variable 
                            ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['user_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['contact']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['mother_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['father_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['city']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['state']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['subscription_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($user['end_date'])); ?>
                                    </td>

                                    <td>
                                        <?php echo $user['transaction_id']; ?>
                                    </td>

                                    <!-- <td>
                                                    <?php echo $user['active'] == 1 ? 'Active' : 'Not Active'; ?>
                                                </td> -->
                                    <td>
                                        <?php echo $user['verified'] == 1 ? 'Verified' : 'Not Verified'; ?>
                                        <!-- Show status -->
                                    </td>
                                    <td>
                                        <?php if ($user['verified'] == 0) : ?>
                                            <form method="POST" action="backend/verify_student.php">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-primary">Verify</button>
                                            </form>
                                            <a href="view_student.php?id=<?php echo $user['id']; ?>" title="View Details">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="#" onclick="confirmDelete(<?php echo $user['id']; ?>)" title="Delete Student">
                                                <i class="fas fa-trash-alt" style="color: red; padding-left: 5px;"></i>
                                            </a>
                                        <?php else : ?>
                                            <!-- Update icon with a link to update_user.php -->
                                            <!-- <a href="update_student.php?id=<?php echo $user['id']; ?>"
                                                            title="Update">
                                                            <?php if ($user['subscription_id'] != 0) : ?>
                                                                <i style="padding-right: 5px;" class="fas fa-times"></i>
                                                            <?php else : ?>
                                                                <i style="padding-right: 5px;" class="fas fa-check"></i>
                                                            <?php endif; ?>
                                                        </a> -->
                                            <!-- Placeholder for another action icon -->
                                            <a href="view_student.php?id=<?php echo $user['id']; ?>" title="View Details">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="#" onclick="confirmDelete(<?php echo $user['id']; ?>)" title="Delete Student">
                                                <i class="fas fa-trash-alt" style="color: red; padding-left: 5px;"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $counter++; // Increment the counter variable 
                                ?>
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