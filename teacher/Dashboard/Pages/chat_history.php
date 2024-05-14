<?php
session_start();
include('../../../includes/config.php');

// Fetch doubts for the current user
$user_id = $_SESSION['user_id'];
$stmt = $dbh->prepare("SELECT * FROM doubt WHERE teacher_id = :user_id");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/chat_history.css">

</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <div class="chat-wrapper">
            <input type="text" class="search-bar" id="searchInput" placeholder="Search...">
            <div id="searchResults" class="chat-container">
                <?php


                // Fetch doubts based on user_id, sorted by created_at timestamp
                $stmt_doubts = $dbh->prepare("SELECT * FROM doubt WHERE teacher_id = :user_id ORDER BY doubt_created_at DESC");
                $stmt_doubts->bindParam(':user_id', $_SESSION['user_id']);
                $stmt_doubts->execute();
                $all_doubts = $stmt_doubts->fetchAll();

                foreach ($all_doubts as $doubt) :
                    $student_view_class = '';
                    switch ($doubt['teacher_view']) {
                        case 0:
                            $student_view_class = 'unread';
                            break;
                        case 1:
                            $student_view_class = 'read';
                            break;
                        case 2:
                            $student_view_class = 'submitted';
                            break;
                        default:
                            // Handle unexpected values
                            break;
                    }
                    $profile_image_src = '';

                    // Fetch profile image based on user_id from subscription_user table
                    $stmt_profile = $dbh->prepare("SELECT photo FROM subscription_user WHERE user_id = :user_id");
                    $stmt_profile->bindParam(':user_id', $doubt['user_id']);
                    $stmt_profile->execute();
                    $profile_data = $stmt_profile->fetch();
                    if ($profile_data) {
                        $profile_image_src = "../../../student/Dashboard/uploads/profile/" . $profile_data['photo'];
                    } else {
                        // Default profile image source if no profile image found
                        $profile_image_src = "../img/card.jpg";
                    }

                    // Truncate doubt message if it exceeds 40 characters
                    $doubt_message = (strlen($doubt['doubt']) > 40) ? substr($doubt['doubt'], 0, 40) . "..." : $doubt['doubt'];

                    // Format the created_at timestamp
                    $sent_time = date("F j, Y g:i A", strtotime($doubt['doubt_created_at']));
                ?>

                    <a href="chat.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" class="chat-card <?php echo $student_view_class; ?>">
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
        </div>


    </section>
    <?php include('../includes/notes.php'); ?>
    <?php include('../includes/script.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/chat_history.js"></script>
</body>

</html>