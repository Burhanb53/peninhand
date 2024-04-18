<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Fetch data from the 'doubt' table where teacher_id is NULL
$sql = "SELECT * FROM doubt WHERE teacher_id IS NULL";
$result = $dbh->query($sql);
$doubts = $result->fetchAll(PDO::FETCH_ASSOC);
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

    <link rel="stylesheet" href="vendors/datepicker/date-picker.css">

    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css">

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
    <?php include ('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
    <?php include ('includes/navbar_index.php'); ?>

    <div class="main_content_iner ">
        <div class="container-fluid p-2">
            <h1>Active Doubts</h1>
            <div class="box_right d-flex lms_block">
                <div class="serach_field_2">
                    <div class="search_inner">
                        <form id="searchForm">
                            <div class="search_field">
                                <input id="searchInput" type="text" placeholder="Search...">
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
                            <th>Doubt ID</th>
                            <th>User ID</th>
                            <th>Doubt Category</th>
                            <th>Doubt</th>
                            <th>Doubt File</th>
                            <th>Created At</th>
                            <th>Assign Teacher</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($doubts)) : ?>
                            <tr>
                                <td colspan="7" class="text-center">No Active Doubts Available</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($doubts as $doubt) : ?>
                                <tr>
                                    <td><?php echo $doubt['doubt_id']; ?></td>
                                    <td><?php echo $doubt['user_id']; ?></td>
                                    <td><?php echo $doubt['doubt_category']; ?></td>
                                    <td style="max-width: 500px; overflow: hidden; text-overflow: ellipsis;"><?php echo $doubt['doubt']; ?></td>
                                    <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                        <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" target="_blank">View File</a>
                                    </td>
                                    <td><?php echo $doubt['doubt_created_at']; ?></td>
                                    <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                        <a href="assign_teacher.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" >Assign</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

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

            <script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
            <script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
            <script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
            <script src="vendors/datatable/js/buttons.flash.min.js"></script>
            <script src="vendors/datatable/js/jszip.min.js"></script>
            <script src="vendors/datatable/js/pdfmake.min.js"></script>
            <script src="vendors/datatable/js/vfs_fonts.js"></script>
            <script src="vendors/datatable/js/buttons.html5.min.js"></script>
            <script src="vendors/datatable/js/buttons.print.min.js"></script>

            <script src="vendors/datepicker/datepicker.js"></script>
            <script src="vendors/datepicker/datepicker.en.js"></script>
            <script src="vendors/datepicker/datepicker.custom.js"></script>
            <script src="js/chart.min.js"></script>

            <script src="vendors/progressbar/jquery.barfiller.js"></script>

            <script src="vendors/tagsinput/tagsinput.js"></script>

            <script src="vendors/text_editor/summernote-bs4.js"></script>
            <script src="vendors/am_chart/amcharts.js"></script>
            <script src="vendors/apex_chart/apexcharts.js"></script>
            <script src="vendors/apex_chart/apex_realestate.js"></script>

            <script src="vendors/chart_am/core.js"></script>
            <script src="vendors/chart_am/charts.js"></script>
            <script src="vendors/chart_am/animated.js"></script>
            <script src="vendors/chart_am/kelly.js"></script>
            <script src="vendors/chart_am/chart-custom.js"></script>

            <script src="js/custom.js"></script>
            <script src="vendors/apex_chart/bar_active_1.js"></script>
            <script src="vendors/apex_chart/apex_chart_list.js"></script>

