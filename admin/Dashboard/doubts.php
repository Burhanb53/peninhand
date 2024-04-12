<?php
session_start();
error_reporting(0);
include('includes/config.php');

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

<body class="crm_body_bg">
    <?php include('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
        <?php include('includes/navbar_index.php'); ?>

        <!-- Display Doubts -->
        <div style="padding-left: 35px;padding-right: 35px" class="container-flex">
            <h1>All Doubts</h1>
            <div class="form-group">
                <label for="filter">Filter by:</label>
                <select class="form-control" id="filter">
                    <option value="all">All</option>
                    <option value="accepted">Accepted</option>
                    <option value="not_accepted">Not Accepted</option>
                    <option value="answered">Answered</option>
                    <option value="not_answered">Not Answered</option>
                    <option value="feedback_given">Feedback Given</option>
                    <option value="no_feedback">No Feedback</option>
                </select>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px;">Sr. No.</th>
                            <th style="width: 10px;">Doubt ID</th>
                            <th style="width: 10px;">User ID</th>
                            <th style="width: 10px;">Teacher ID</th>
                            <th style="width: 40px;">Doubt Category</th>
                            <th style="width: 80px;">Doubt</th>
                            <th style="width: 10px;">Doubt File</th>
                            <th style="width: 10px;">Created At</th>
                            <th style="width: 5px;">Status</th>
                            <th style="width: 5px;">Answer</th>
                            <th style="width: 5px;">Answer File</th>
                            <!-- <th style="width: 5px;">Answer At</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; // Initialize the counter variable 
                        ?>
                        <?php foreach ($doubts as $doubt) : ?>
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
                                <td style="max-width: 500px; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo $doubt['doubt']; ?>
                                </td>
                                <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                    <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" target="_blank">View File</a>
                                </td>
                                <td>
                                    <?php $timestamp = strtotime($doubt['doubt_created_at']);
                                    $date = date('d F Y', $timestamp);
                                    $time = date('h:i A', $timestamp); ?>
                                    <?php echo $date; ?> <?php echo $time; ?>
                                </td>
                                <td>
                                    <?php if ($doubt['teacher_id'] !== null) : ?>
                                        Doubt Accepted:
                                        <?php echo $doubt['accepted'] == 1 ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                    <?php else : ?>
                                        <a href="assign_teacher.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" class="btn btn-primary">Assign Teacher</a>
                                    <?php endif; ?>

                                    <?php if ($doubt['accepted'] == 1) : ?>
                                        <br>Answer :
                                        <?php echo $doubt['answer'] != null ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                        <br>Feedback :
                                        <?php echo $doubt['feedback'] == 1 ? '<span class="green">Yes</span>' : '<span class="red">No</span>'; ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php echo $doubt['answer']; ?>
                                </td>
                                <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                    <?php if ($doubt['answer_file'] !== null) : ?>
                                        <a href="../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" target="_blank">View File</a>
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
        <script>
            $(document).ready(function() {
                $('#filter').change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'all') {
                        // Show all rows
                        $('tbody tr').show();
                    } else if (selectedOption === 'accepted') {
                        // Show rows with accepted doubts
                        $('tbody tr').hide();
                        $('tbody tr:has(.green)').show();
                    } else if (selectedOption === 'not_accepted') {
                        // Show rows with doubts not accepted
                        $('tbody tr').hide();
                        $('tbody tr:has(.red)').show();
                    } else if (selectedOption === 'answered') {
                        // Show rows with answered doubts
                        $('tbody tr').hide();
                        $('tbody tr:has(.green)').show();
                    } else if (selectedOption === 'not_answered') {
                        // Show rows with doubts not answered
                        $('tbody tr').hide();
                        $('tbody tr:has(.red)').show();
                    } else if (selectedOption === 'feedback_given') {
                        // Show rows with feedback given
                        $('tbody tr').hide();
                        $('tbody tr:has(.green)').show();
                    } else if (selectedOption === 'no_feedback') {
                        // Show rows with no feedback
                        $('tbody tr').hide();
                        $('tbody tr:has(.red)').show();
                    }
                });
            });
        </script>

</body>