<?php
session_start();
error_reporting(0);
$page_url = "index.php";
include('../../includes/config.php');
if (!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
    // User doesn't have the required role, redirect to index.php
    header("Location: ../../index.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
} else {
    $user_id = $_SESSION['user_id'];
    $video_call_count = 0;
    $doubt_count = 0;
    $answer_count = 0;

    // Fetch all doubt_ids from the doubt table for the user
    $stmt_doubt_ids = $dbh->prepare("SELECT doubt_id FROM doubt WHERE user_id = :user_id");
    $stmt_doubt_ids->bindParam(':user_id', $user_id);
    $stmt_doubt_ids->execute();
    $doubt_ids = $stmt_doubt_ids->fetchAll(PDO::FETCH_COLUMN);

    // Initialize video call count
    $video_call_count = 0;

    // Loop through each doubt_id and count rows from video_call table
    foreach ($doubt_ids as $doubt_id) {
        $stmt_video_call_count = $dbh->prepare("SELECT COUNT(*) AS video_call_count FROM video_call WHERE doubt_id = :doubt_id AND attend = 1");
        $stmt_video_call_count->bindParam(':doubt_id', $doubt_id);
        $stmt_video_call_count->execute();
        $video_call_row = $stmt_video_call_count->fetch(PDO::FETCH_ASSOC);
        $video_call_count += $video_call_row['video_call_count'];
    }

    // Count rows from doubt table
    $stmt_doubt = $dbh->prepare("SELECT COUNT(*) AS doubt_count FROM doubt WHERE user_id = :user_id");
    $stmt_doubt->bindParam(':user_id', $user_id);
    $stmt_doubt->execute();
    $doubt_row = $stmt_doubt->fetch(PDO::FETCH_ASSOC);
    $doubt_count = $doubt_row['doubt_count'];

    // Count rows from doubt table where feedback = 1
    $stmt_answer = $dbh->prepare("SELECT COUNT(*) AS answer_count FROM doubt WHERE user_id = :user_id AND feedback = 1");
    $stmt_answer->bindParam(':user_id', $user_id);
    $stmt_answer->execute();
    $answer_row = $stmt_answer->fetch(PDO::FETCH_ASSOC);
    $answer_count = $answer_row['answer_count'];


    $stmt = $dbh->prepare("SELECT end_date FROM subscription_user WHERE user_id = :user_id ORDER BY end_date DESC LIMIT 1");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $end_date_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($end_date_row) {
        $end_date = strtotime($end_date_row['end_date']);
        $formatted_end_date = date("d F, Y", $end_date);
        $remaining_days = ceil(($end_date - time()) / (60 * 60 * 24)); // Calculate remaining days

    } else {
        echo "No end date found for user.";
    }

    $stmt = $dbh->prepare("SELECT * FROM doubt WHERE user_id = :user_id ORDER BY doubt_created_at DESC LIMIT 4"); // Limiting to 4 latest doubts
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $doubts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function time_elapsed_string($datetime)
{
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 2592000) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}


?>


<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Dashboard</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/mathlive/dist/mathlive-static.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



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

        .outer-container {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;

        }

        .centered-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .question-box {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 90%;
            width: 900px;
            height: 100px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            border: none;
            outline: none;
            padding: 10px;
            border-radius: 5px;
            flex-grow: 1;
            font-size: 16px;
            color: #333;
            border: 2px solid orange;
            border-radius: 5px;
            height: 100%;
            margin-right: 20px;
        }

        input[type="text"]::placeholder {
            color: #999;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: 10px;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #999;
        }

        .icon-button.arrow {
            font-size: 18px;
            color: white;
            background-color: #999;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #image-container {
            margin: 20px;
        }

        @media (max-width: 768px) {
            .question-box {
                /* flex-direction: column; */
                height: auto;
            }

            .icons {
                margin-left: 0;
                margin-top: 10px;
            }

            .icon-button {
                font-size: 24px;
            }

            .icon-button.arrow {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .question-box {
                width: 100%;
            }

            input[type="text"] {
                font-size: 14px;
            }

            .icon-button {
                font-size: 20px;
            }

            .icon-button.arrow {
                width: 40px;
                height: 40px;
            }
        }
    </style>
    <style>
        #loader-container {
            display: none;
            position: fixed;
            z-index: 9000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #loader {
            position: absolute;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        /* Center loader in mobile view */
        @media only screen and (max-width: 768px) {
            #loader-container {
                display: none;
                position: fixed;
                z-index: 9000;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.5);
            }

            #loader {
                position: absolute;
                transform: none;
                left: 35%;

            }
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 8px 16px;
            z-index: 9999;
            width: auto;
            border-radius: 4px;
        }
    </style>

</head>

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
                                        <h3>Student Dashboard</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href>Dashboard</a> <i class="fas fa-caret-right"></i>Performance Book</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="notification"></div>

                    <div id="loader-container">
                        <div id="loader"></div>
                    </div>
                    <div class="outer-container">
                        <div class="centered-box">
                            <form id="questionForm" action="backend/submit_doubt.php" method="post" enctype="multipart/form-data">
                                <div class="question-box">
                                    <input type="text" name="doubt_category" value="General Doubt" hidden>
                                    <input type="text" id="doubt" name="doubt" placeholder="What's your question?" required>
                                    <div class="icons">
                                        <label for="upload" class="icon-button">
                                            <i class="fas fa-image"></i>
                                            <input type="file" id="upload" name="file" style="display: none;">
                                        </label>
                                        <button type="button" class="icon-button arrow">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div id="image-container"></div>
                        </div>
                    </div>
                    <!-- <div class="container text-center">
                        <div class="col-lg-3 col-md-3 col-sm-6 mb-12 d-inline-block align-top">
                            <div class="round-card box_shadow position-relative mb_30 blue_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $doubt_count ?>">0</div>
                                    <p class="count-description">Questions Asked</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 mb-12 d-inline-block align-top">
                            <div class="round-card box_shadow position-relative mb_30 orange_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $answer_count ?>">0</div>
                                    <p class="count-description">Answers Received</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 mb-12 d-inline-block align-top">
                            <div class="round-card box_shadow position-relative mb_30 green_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $video_call_count ?>">0</div>
                                    <p class="count-description">Video Calls Attended</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100 blud_card">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0 text_white" style="font-size:1.5rem;">Subscription Details</h3>
                                </div>
                            </div>
                            <div class="content_user">
                                <p style="font-size:1.5rem;">Remaining Days:
                                    <?php echo $remaining_days ?>
                                </p>
                                <p style="font-size:1.5rem;">End Date:
                                    <?php echo $formatted_end_date ?>
                                </p>
                                <a href="../../Pages/price.php" class="btn_2" style="font-size:1rem;">Renew
                                    Subscription</a>
                                <img src="img/users_img.png" alt>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="white_box card_height_100">
                            <div class="box_header">
                                <div class="main-title" style="display: inline-flex;">
                                    <h3 class="m-0">Recent Doubts</h3>
                                </div>
                                <div class="ask-doubt-btn-container" style="display: inline-flex;">
                                    <a href="Pages/ask_doubt.php">
                                        <button class="ask-doubt-btn">Ask Doubt</button>
                                    </a>
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
                                                        <?php echo time_elapsed_string($doubt['doubt_created_at']); ?>
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
        // Counter Animation
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.count');
            const speed = 100; // The lower the slower

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText;

                    // Lower inc to slow and higher to slow
                    const inc = target / speed;

                    // Check if target is reached
                    if (count < target) {
                        // Add inc to count and output in counter
                        counter.innerText = Math.ceil(count + inc);
                        // Call function every ms
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });
    </script>
    <script>
    document.getElementById("upload").addEventListener("change", function (event) {
        const fileInput = event.target;
        const imageContainer = document.getElementById("image-container");

        while (imageContainer.firstChild) {
            imageContainer.removeChild(imageContainer.firstChild);
        }

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const filePreviewContainer = document.createElement("div");

            if (file.type.startsWith("image/")) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                imageContainer.appendChild(img);
            } else {
                const fileLink = document.createElement("a");
                fileLink.href = URL.createObjectURL(file);
                fileLink.textContent = file.name;
                fileLink.target = "_blank";
                filePreviewContainer.appendChild(fileLink);
                imageContainer.appendChild(filePreviewContainer);
            }
        }
    });
</script>

    <script>
        $(document).ready(function() {
            $(".arrow").click(function() {
                // Show loader
                $("#loader-container").show();

                // Show top notification
                $("#notification").text("Submitting question...").show();

                // Serialize form data
                var formData = new FormData($("#questionForm")[0]);

                // Send AJAX request
                $.ajax({
                    url: $("#questionForm").attr('action'),
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Hide loader
                        $("#loader-container").hide();
                        // Hide top notification after 3 seconds
                        $("#notification").text("Question submitted successfully.").delay(3000).fadeOut();
                        // Handle success response here
                        console.log(response);
                        window.location.reload();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Hide loader
                        $("#loader-container").hide();
                        // Show error notification
                        $("#notification").text("Error: " + xhr.responseText).show();
                        // Hide top notification after 5 seconds
                        setTimeout(function() {
                            $("#notification").fadeOut();
                        }, 5000);
                        //reload page_url
                        window.location.reload();
                    }
                });
            });
        });
    </script>

</body>

</html>