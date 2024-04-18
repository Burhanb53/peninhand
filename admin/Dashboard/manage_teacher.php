<?php
session_start();
error_reporting(0);
include ('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style> -->
</head>

<body class="crm_body_bg">

    <?php include ('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
    <?php include ('includes/navbar_index.php'); ?>

        <div class="main_content_iner ">
            <div class="container-fluid p-2">
                <h1>Manage Teacher</h1>
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