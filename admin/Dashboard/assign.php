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
    </style>
</head>

<body class="crm_body_bg">
    <?php include ('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
        <?php include ('includes/navbar_index.php'); ?>

        <!-- Display Doubts -->
        <div style="padding-left: 35px;padding-right: 35px" class="container-flex">
            <h1>Assign Teacher</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px;">Doubt ID</th>
                            <th style="width: 10px;">User ID</th>
                            <!-- <th style="width: 10px;">Teacher ID</th> -->
                            <th style="width: 40px;">Doubt Category</th>
                            <th style="width: 80px;">Doubt</th>
                            <th style="width: 10px;">Doubt File</th>
                            <th style="width: 10px;">Created At</th>
                            <th style="width: 5px;">Assign Teacher</th>
                            <!-- <th style="width: 5px;">Answer</th>
                            <th style="width: 5px;">Answer File</th> -->
                            <!-- <th style="width: 5px;">Answer At</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($doubts as $doubt): ?>
                            <tr>
                                <td>
                                    <?php echo $doubt['doubt_id']; ?>
                                </td>
                                <td>
                                    <?php echo $doubt['user_id']; ?>
                                </td>
                                <!-- <td>
                                    <?php echo $doubt['teacher_id'] != null ? $doubt['teacher_id'] : 'Not Assigned'; ?>
                                </td> -->
                                <td>
                                    <?php echo $doubt['doubt_category']; ?>
                                </td>
                                <td style="max-width: 500px; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo $doubt['doubt']; ?>
                                </td>
                                <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                    <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>"
                                        target="_blank">View File</a>
                                </td>
                                <td>
                                    <?php echo $doubt['doubt_created_at']; ?>
                                </td>
                                <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                    <a href="assign_teacher.php?doubt_id=<?php echo $doubt['doubt_id']; ?>"
                                        target="_blank">Assign</a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

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
</body>