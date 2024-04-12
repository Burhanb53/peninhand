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
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css">
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
</head>

<body class="crm_body_bg">

    <?php include ('includes/sidebar_index.php'); ?>


    <section class="main_content dashboard_part">
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <h1>Manage Students</h1>
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
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Mother Name</th>
                                <th>Father Namge</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Subscription</th>
                                <th>End Date</th>
                                <th>Transaction ID</th>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $counter = 1; // Initialize the counter variable ?>
                            <?php foreach ($users as $user): ?>
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
                                        <?php
                                        $subscription_id = $user['subscription_id'];
                                        switch ($subscription_id) {
                                            case 1:
                                                echo '1 month';
                                                break;
                                            case 2:
                                                echo '2 months';
                                                break;
                                            case 3:
                                                echo '3 months';
                                                break;
                                            default:
                                                echo 'Unknown subscription';
                                                break;
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $user['end_date']; ?>
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
                                        <?php if ($user['verified'] == 0): ?>
                                            <form method="POST" action="backend/verify_student.php">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-primary">Verify</button>
                                            </form>
                                        <?php else: ?>
                                            <!-- Update icon with a link to update_user.php -->
                                            <!-- <a href="update_student.php?id=<?php echo $user['id']; ?>"
                                                            title="Update">
                                                            <?php if ($user['subscription_id'] != 0): ?>
                                                                <i style="padding-right: 5px;" class="fas fa-times"></i>
                                                            <?php else: ?>
                                                                <i style="padding-right: 5px;" class="fas fa-check"></i>
                                                            <?php endif; ?>
                                                        </a> -->
                                            <!-- Placeholder for another action icon -->
                                            <a href="view_student.php?id=<?php echo $user['id']; ?>" title="View Details">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $counter++; // Increment the counter variable ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        </div>
        </div>
        </div>

        <!-- <div class="footer_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer_iner text-center">
                            <p>2020 © Influence - Designed by <a href="#"> <i class="ti-heart"></i> </a><a href="#">
                                    Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
</body>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#dataTable tbody tr');

            input.addEventListener('input', function () {
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
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Add your search logic here, such as updating the table based on the search term
            });

        });

    </script>

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

<script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatable/js/buttons.flash.min.js"></script>
<script src="vendors/datatable/js/jszip.min.js"></script>
<script src="vendors/datatable/js/pdfmake.min.js"></script>
<script src="vendors/datatable/js/vfs_fonts.js"></script>
<script src="vendors/datatable/js/buttons.html5.min.js"></script>
<script src="vendors/datatable/js/buttons.print.min.js"></script>
<script src="js/chart.min.js"></script>

<script src="vendors/progressbar/jquery.barfiller.js"></script>

<script src="vendors/tagsinput/tagsinput.js"></script>

<script src="vendors/text_editor/summernote-bs4.js"></script>
<script src="vendors/apex_chart/apexcharts.js"></script>
<script src="js/custom.js"></script>


</html>