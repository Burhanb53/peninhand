<?php
session_start();
error_reporting(0);
$page_url = "index.php";
include('../../includes/config.php');
if (!(isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
    // User doesn't have the required role, redirect to index.php
    header("Location: ../../index.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
} else {
    $teacher_id = $_SESSION['user_id'];
    $video_call_count = 0;
    $doubt_count = 0;
    $answer_count = 0;

    // Fetch all doubt_ids from the doubt table for the user
    $stmt_doubt_ids = $dbh->prepare("SELECT doubt_id FROM doubt WHERE teacher_id = :teacher_id");
    $stmt_doubt_ids->bindParam(':teacher_id', $teacher_id);
    $stmt_doubt_ids->execute();
    $doubt_ids = $stmt_doubt_ids->fetchAll(PDO::FETCH_COLUMN);

    // Initialize video call count
    $video_call_count = 0;

    // Loop through each doubt_id and count rows from video_call table
    foreach ($doubt_ids as $doubt_id) {
        $stmt_video_call_count = $dbh->prepare("SELECT COUNT(*) AS video_call_count FROM video_call WHERE doubt_id = :doubt_id");
        $stmt_video_call_count->bindParam(':doubt_id', $doubt_id);
        $stmt_video_call_count->execute();
        $video_call_row = $stmt_video_call_count->fetch(PDO::FETCH_ASSOC);
        $video_call_count += $video_call_row['video_call_count'];
    }

    // Count rows from doubt table
    $stmt_doubt = $dbh->prepare("SELECT COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id");
    $stmt_doubt->bindParam(':teacher_id', $teacher_id);
    $stmt_doubt->execute();
    $doubt_row = $stmt_doubt->fetch(PDO::FETCH_ASSOC);
    $doubt_count = $doubt_row['doubt_count'];

    // Count rows from doubt table where feedback = 1
    $stmt_feedback = $dbh->prepare("SELECT COUNT(*) AS feedback_count FROM doubt WHERE teacher_id = :teacher_id AND doubt_submit = 1 AND feedback = 1");
    $stmt_feedback->bindParam(':teacher_id', $teacher_id);
    $stmt_feedback->execute();
    $feedback_row = $stmt_feedback->fetch(PDO::FETCH_ASSOC);
    $feedback_count = $feedback_row['feedback_count'];

    $stmt_answer = $dbh->prepare("SELECT COUNT(*) AS answer_count FROM doubt WHERE teacher_id = :teacher_id AND feedback = 1");
    $stmt_answer->bindParam(':teacher_id', $teacher_id);
    $stmt_answer->execute();
    $answer_row = $stmt_answer->fetch(PDO::FETCH_ASSOC);
    $answer_count = $answer_row['answer_count'];

    $pending_answer = $doubt_count - $answer_count;

    $stmt = $dbh->prepare("SELECT * FROM doubt WHERE teacher_id = :teacher_id ORDER BY answer_created_at DESC LIMIT 4"); // Limiting to 4 latest doubts
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();
    $doubts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_category = $dbh->prepare("SELECT COUNT(DISTINCT doubt_category) AS category_count FROM doubt WHERE teacher_id = :teacher_id");
    $stmt_category->bindParam(':teacher_id', $teacher_id);
    $stmt_category->execute();
    $doubt_category = $stmt_category->fetch(PDO::FETCH_ASSOC);
    $category_count = isset($doubt_category['category_count']) ? intval($doubt_category['category_count']) : 0;

    $stmt_doubt_category = $dbh->prepare("SELECT doubt_category, COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id GROUP BY doubt_category");
    $stmt_doubt_category->bindParam(':teacher_id', $teacher_id);
    $stmt_doubt_category->execute();
    $unique_doubt_category = $stmt_doubt_category->fetchAll(PDO::FETCH_ASSOC);
}

function time_elapsed_string($datetime)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    } elseif ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    } elseif ($diff->d > 0) {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    } elseif ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    } elseif ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'Just now';
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
</head>
<style>
    .gtco-testimonials {
        position: relative;
        margin-top: 30px;

        h2 {
            font-size: 30px;
            text-align: center;
            color: #333333;
            margin-bottom: 50px;
        }

        .owl-stage-outer {
            padding: 30px 0;
        }

        .owl-nav {
            display: none;
        }

        .owl-dots {
            text-align: center;

            span {
                position: relative;
                height: 10px;
                width: 10px;
                border-radius: 50%;
                display: block;
                background: #fff;
                border: 2px solid #01b0f8;
                margin: 0 5px;
            }

            .active {
                box-shadow: none;

                span {
                    background: #01b0f8;
                    box-shadow: none;
                    height: 12px;
                    width: 12px;
                    margin-bottom: -1px;
                }
            }
        }

        .card {
            background: #fff;
            box-shadow: 0 8px 30px -7px #c9dff0;
            margin: 0 20px;
            padding: 0 10px;
            border-radius: 20px;
            border: 0;

            .card-img-top {
                max-width: 100px;
                border-radius: 50%;
                margin: 15px auto 0;
                box-shadow: 0 8px 20px -4px #95abbb;
                width: 100px;
                height: 100px;
            }

            h5 {
                color: #01b0f8;
                font-size: 21px;
                line-height: 1.3;

                span {
                    font-size: 18px;
                    color: #666666;
                }
            }

            p {
                font-size: 18px;
                color: #555;
                padding-bottom: 15px;
            }
        }

        .active {
            opacity: 0.5;
            transition: all 0.3s;
        }

        .center {
            opacity: 1;

            h5 {
                font-size: 24px;

                span {
                    font-size: 20px;
                }
            }

            .card-img-top {
                max-width: 100%;
                height: 120px;
                width: 120px;
            }
        }
    }

    @media (max-width: 767px) {
        .gtco-testimonials {
            margin-top: 20px;
        }
    }

    .owl-carousel {
        .owl-nav button {

            &.owl-next,
            &.owl-prev {
                outline: 0;
            }
        }

        button.owl-dot {
            outline: 0;
        }
    }
</style>

<body class="crm_body_bg">


    <?php include('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">

        <?php include('includes/navbar_index.php'); ?>

        <div class="main_content_iner ">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3> Teacher Dashboard</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href>Dashboard</a> <i class="fas fa-caret-right"></i> Address Book</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="white_box card_height_100">
                            <div class="box_header">
                                <div class="main-title" style="display: inline-flex;">
                                    <h3 class="m-0">Recent Doubts</h3>
                                </div>

                            </div>
                            <div class="Activity_timeline">
                                <ul>
                                    <?php foreach ($doubts as $doubt) : ?>
                                        <li>
                                            <div class="activity_bell"></div>
                                            <div class="timeLine_inner d-flex align-items-center">
                                                <div class="activity_wrap">
                                                    <h6>
                                                        <?php echo time_elapsed_string($doubt['answer_created_at']); ?>
                                                    </h6>
                                                    <p>
                                                        <?php echo substr($doubt['doubt'], 0, 60); ?>...
                                                    </p> <!-- Displaying the first 40 characters of the doubt -->
                                                </div>
                                                <div class="notification_read_btn mb_10" style="margin-left: auto;">
                                                    <a href="Pages/chat.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" class="notification_btn">Read</a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="list_counter_wrapper white_box mb_30 p-0 card_height_100">
                            <div class="single_list_counter">

                                <h3 class="deep_blue_2"><span class="counter deep_blue_2 "><?php echo $category_count; ?></span> + </h3>
                                <p>Total categories</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2"><?php echo $doubt_count; ?></span> + </h3>
                                <p>Total Doubt</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2"><?php echo $answer_count; ?></span> + </h3>
                                <p>Total Answer</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2"><?php echo $video_call_count; ?></span> + </h3>
                                <p>Video Call</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Users according to Doubt Category</h3>
                                </div>
                            </div>
                            <div class="QA_table">
                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Doubt Category</th>
                                            <th scope="col">No. of doubts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($unique_doubt_category as $row) : ?>
                                            <tr>
                                                <td><?php echo $row['doubt_category']; ?></td>
                                                <td><?php echo $row['doubt_count']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="white_box mb_30 card_height_100">
                            <div class="box_header ">
                                <div class="main-title">
                                    <h3 class="mb_25">Overview</h3>
                                </div>
                            </div>
                            <div class="activity_progressbar">
                                <div class="single_progressbar d-flex">
                                    <h6>Active Doubt</h6>
                                    <div id="bar1" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="<?php echo ROUND($pending_answer * 100 / $doubt_count); ?>"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Answered Doubt</h6>
                                    <div id="bar2" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="<?php echo ROUND($answer_count * 100 / $doubt_count); ?>"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Feedback</h6>
                                    <div id="bar3" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="<?php echo ROUND($feedback_count * 100 / $doubt_count); ?>"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Video Call</h6>
                                    <div id="bar4" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="<?php echo ROUND($video_call_count * 100 / $doubt_count); ?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                    // Prepare and execute SQL query to fetch doubt categories and their counts
                    $stmt = $dbh->prepare("SELECT doubt_category, COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id AND feedback = 0 GROUP BY doubt_category");
                    $stmt->bindParam(':teacher_id', $teacher_id);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $stmt = $dbh->prepare("SELECT doubt_category, COUNT(*) AS doubt_count FROM doubt WHERE teacher_id = :teacher_id AND feedback = 1 GROUP BY doubt_category");
                    $stmt->bindParam(':teacher_id', $teacher_id);
                    $stmt->execute();
                    $result_answered = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $stmt = $dbh->prepare("SELECT d.doubt_category, ROUND(AVG(f.satisfaction_level)) AS average_satisfaction
                        FROM doubt d
                        INNER JOIN feedback f ON d.doubt_id = f.doubt_id
                        GROUP BY d.doubt_category");
                    $stmt->execute();
                    $satisfaction_level = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Listings according to Active Doubt</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Doubt Category</th>
                                            <th scope="col">No. of doubts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $row) : ?>
                                            <tr>
                                                <td><?php echo $row['doubt_category']; ?></td>
                                                <td> : <?php echo $row['doubt_count']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Listings according to Answered Doubt</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Doubt Category</th>
                                            <th scope="col">No. of doubts</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result_answered as $row) : ?>
                                            <tr>
                                                <td><?php echo $row['doubt_category']; ?></td>
                                                <td> : <?php echo $row['doubt_count']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Listings according to Feedback</h3>
                                </div>
                            </div>
                            <div class="QA_table ">
                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Doubt Category</th>
                                            <th scope="col">Average Satisfaction Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($satisfaction_level as $row) : ?>
                                            <tr>
                                                <td><?php echo $row['doubt_category']; ?></td>
                                                <td> : <?php echo $row['average_satisfaction']; ?> Star</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <?php
                    // Fetch data from the database
                    $stmt = $dbh->prepare("SELECT f.*, d.doubt_category, d.doubt_id, d.user_id, s.name AS student_name, s.photo AS student_photo
                        FROM feedback f
                        INNER JOIN doubt d ON f.doubt_id = d.doubt_id
                        INNER JOIN subscription_user s ON d.user_id = s.user_id
                        WHERE d.teacher_id = :teacher_id");
                    $stmt->bindParam(':teacher_id', $teacher_id);
                    $stmt->execute();
                    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <div class="gtco-testimonials">
                        <h2>Student's Feedback</h2>
                        <div class="owl-carousel owl-carousel1 owl-theme">
                            <?php foreach ($feedbacks as $feedback) : ?>
                                <div>
                                    <a href="chat.php?doubt_id=<?php echo $doubt['doubt_id']; ?>">
                                        <div class="card text-center">
                                            <a href="Pages/chat.php?doubt_id=<?php echo $feedback['doubt_id']; ?>">
                                                <img class="card-img-top" src="../../student/Dashboard/uploads/profile/<?php echo $feedback['student_photo']; ?>" alt="Student Photo">
                                            </a>
                                            <div class="card-body">
                                                <h5><?php echo $feedback['student_name']; ?><br />
                                                    <span><?php echo $feedback['doubt_category']; ?> (<?php echo $feedback['satisfaction_level']; ?> Star)</span>
                                                </h5>
                                                <p class="card-text"><?php echo $feedback['feedback_text']; ?></p>
                                                <p><?php echo date('d/m/Y h:i:s A', strtotime($feedback['submission_date'])); ?></p>
                                            </div>
                                        </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>





                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>

    </section>
    <?php include('includes/notes.php'); ?>






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
        (function() {
            "use strict";

            var carousels = function() {
                $(".owl-carousel1").owlCarousel({
                    loop: true,
                    center: true,
                    margin: 0,
                    responsiveClass: true,
                    nav: false,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false
                        },
                        680: {
                            items: 2,
                            nav: false,
                            loop: false
                        },
                        1000: {
                            items: 3,
                            nav: true
                        }
                    }
                });
            };

            (function($) {
                carousels();
            })(jQuery);
        })();
    </script>
</body>

</html>