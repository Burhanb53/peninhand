<?php
session_start();
include ('../../../includes/config.php');

// Fetch doubts for the current user
$user_id = $_SESSION['user_id'];
$stmt = $dbh->prepare("SELECT * FROM doubt WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$doubts = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Dashboard</title>
    <link rel="icon" href="../img/logo.png" type="image/png">

    <link rel="stylesheet" href="../css/bootstrap1.min.css">

    <link rel="stylesheet" href="../vendors/themefy_icon/themify-icons.css">

    <link rel="stylesheet" href="../vendors/swiper_slider/css/swiper.min.css">

    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css">

    <link rel="stylesheet" href="../vendors/niceselect/css/nice-select.css">

    <link rel="stylesheet" href="../vendors/owl_carousel/css/owl.carousel.css">

    <link rel="stylesheet" href="../vendors/gijgo/gijgo.min.css">

    <link rel="stylesheet" href="../vendors/font_awesome/css/all.min.css">
    <link rel="stylesheet" href="../vendors/tagsinput/tagsinput.css">

    <link rel="stylesheet" href="../vendors/datepicker/date-picker.css">

    <link rel="stylesheet" href="../vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../vendors/datatable/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="../vendors/text_editor/summernote-bs4.css">

    <link rel="stylesheet" href="../vendors/morris/morris.css">

    <link rel="stylesheet" href="../vendors/material_icon/material-icons.css">

    <link rel="stylesheet" href="../css/metisMenu.css">

    <link rel="stylesheet" href="../css/style1.css">
    <style>
        body {
            overflow: hidden;
        }

        .chat-wrapper {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            margin: 0 auto;
            /* Center the chat container horizontally */
            margin-bottom: 50px;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 15px;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 1;
        }

        .chat-container {
            max-height: 500px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
            padding-right: 20px;
            /* Add padding to compensate for the scrollbar width */
        }

        /* Customize scrollbar */
        .chat-container::-webkit-scrollbar {
            width: 12px;
            /* Set the width of the scrollbar */
        }

        .chat-container::-webkit-scrollbar-thumb {
            background-color: #B9BABA;
            /* Set the color of the scrollbar thumb */
            border-radius: 6px;
            /* Set the border radius of the scrollbar thumb */
        }

        .chat-container::-webkit-scrollbar-track {
            background-color: #f5f5f5;
            /* Set the color of the scrollbar track */
        }

        /* End of scrollbar customization */

        .chat-card {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            margin-left: 5px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease;
        }

        .chat-card:hover {
            transform: scale(1.05);
            /* Adjust the scale factor as needed */
        }


        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .message-content {
            flex-grow: 1;
        }

        .message-text {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .message-time {
            font-size: 12px;
            color: #888;
        }

        .unread {
            background-color: #82bfe0;
        }
        
        .unread .message-time{
            color: #fff;
        }

        .read {
            background-color: #f2f2f2;
        }

        @media (max-width: 600px) {
            .chat-wrapper {
                padding: 0 10px;
            }

            .chat-wrapper {

                margin-left: 20px;
                margin-right: 20px;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body class="crm_body_bg">
    <?php include ('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include ('../includes/navbar.php'); ?>

        <div class="chat-wrapper">
            <input type="text" class="search-bar" id="searchInput" placeholder="Search...">
            <div id="searchResults" class="chat-container">
                <?php


                // Fetch doubts based on user_id, sorted by created_at timestamp
                $stmt_doubts = $dbh->prepare("SELECT * FROM doubt WHERE user_id = :user_id ORDER BY doubt_created_at DESC");
                $stmt_doubts->bindParam(':user_id', $_SESSION['user_id']);
                $stmt_doubts->execute();
                $all_doubts = $stmt_doubts->fetchAll();

                foreach ($all_doubts as $doubt):
                    $student_view_class = ($doubt['student_view'] == 0) ? 'unread' : 'read';
                    $profile_image_src = '';

                    // Fetch profile image based on user_id from subscription_user table
                    $stmt_profile = $dbh->prepare("SELECT photo FROM teacher WHERE teacher_id = :teacher_id");
                    $stmt_profile->bindParam(':teacher_id', $doubt['teacher_id']);
                    $stmt_profile->execute();
                    $profile_data = $stmt_profile->fetch();
                    if ($profile_data) {
                        $profile_image_src = "../../../teacher/Dashboard/uploads/profile/" . $profile_data['photo'];
                    } else {
                        // Default profile image source if no profile image found
                        $profile_image_src = "../img/profile.jpg";
                    }

                    // Truncate doubt message if it exceeds 40 characters
                    $doubt_message = (strlen($doubt['doubt']) > 40) ? substr($doubt['doubt'], 0, 40) . "..." : $doubt['doubt'];

                    // Format the created_at timestamp
                    $sent_time = date("F j, Y g:i A", strtotime($doubt['doubt_created_at']));
                    ?>

                    <a href="chat.php?doubt_id=<?php echo $doubt['doubt_id']; ?>"
                        class="chat-card <?php echo $student_view_class; ?>">
                        <img src="<?php echo $profile_image_src; ?>" alt="Profile" class="profile-image">
                        <div class="message-content">
                            <p class="message-text">
                                <?php echo $doubt_message; ?>
                            </p>
                            <p class="message-time">Sent on
                                <?php echo $sent_time; ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var searchInput = document.getElementById("searchInput");

                    searchInput.addEventListener("input", function () {
                        var query = this.value.toLowerCase().trim();
                        var chatCards = document.querySelectorAll("#searchResults .chat-card");

                        chatCards.forEach(function (card) {
                            var messageText = card.querySelector(".message-text").textContent.toLowerCase();

                            if (messageText.includes(query)) {
                                card.style.display = "block";
                            } else {
                                card.style.display = "none";
                            }
                        });
                    });
                });
            </script>


        </div>


    </section>

</body>

</html>