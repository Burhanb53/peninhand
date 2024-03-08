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
        body{
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
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
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
            background-color: #e6f7ff;
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
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <div class="chat-wrapper">
            <input type="text" class="search-bar" placeholder="Search...">

            <div class="chat-container">
                <!-- Example chat history -->
                <div class="chat-card unread">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card unread">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card unread">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card read">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card read">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card read">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card read">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>
                <div class="chat-card read">
                    <img src="../img/card.jpg" alt="Profile 1" class="profile-image">
                    <div class="message-content">
                        <p class="message-text">Short description of the message goes here...</p>
                        <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                    </div>
                </div>

                <!-- Add more chat cards here -->

            </div>
        </div>


    </section>

</body>

</html>