<?php
session_start();
$page_url = "chat.php";

include('../../../includes/config.php');
// Fetch the doubt details based on doubt_id from the URL parameter
if (isset($_GET['doubt_id'])) {
    $doubt_id = $_GET['doubt_id'];

    // Update student_view to 1 for the specified doubt_id
    $sql = "UPDATE doubt SET teacher_view = 1 WHERE doubt_id = :doubt_id and feedback = 0";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);
    $stmt->execute(); // Execute the update query

    $stmt_link = $dbh->prepare("SELECT * FROM video_call WHERE doubt_id = :doubt_id");
    $stmt_link->bindParam(':doubt_id', $doubt_id);
    $stmt_link->execute();
    $video_call_data = $stmt_link->fetch();

    if ($video_call_data !== false) {
        // Row exists for the given doubt_id
        // Proceed with using $video_call_data
        $video_call = $video_call_data; // Assign $video_call_data to $video_call
    } else {
        // No corresponding row found in the table
        $video_call = false; // Set $video_call to false
        // Handle accordingly, such as setting default values or displaying a message
    }


    // Query to fetch doubt details using doubt_id
    $stmt_doubt = $dbh->prepare("SELECT * FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->execute();
    $doubt = $stmt_doubt->fetch();

    $stmt_feedback = $dbh->prepare("SELECT * FROM feedback WHERE doubt_id = :doubt_id");
    $stmt_feedback->bindParam(':doubt_id', $doubt_id);
    $stmt_feedback->execute();
    $feedback = $stmt_feedback->fetch();

    // Check if doubt is found
    if ($doubt) {
        // Fetch profile image based on user_id from subscription_user table
        $stmt_profile = $dbh->prepare("SELECT photo, name FROM subscription_user WHERE user_id = :user_id");
        $stmt_profile->bindParam(':user_id', $doubt['user_id']);
        $stmt_profile->execute();
        $profile_data = $stmt_profile->fetch();
        if ($profile_data) {
            $profile_image_src = "../../../student/Dashboard/uploads/profile/" . $profile_data['photo'];
        } else {
            // Default profile image source if no profile image found
            $profile_image_src = "../img/card.jpg";
        }
        $doubt_description = $doubt['doubt'];
        $doubt_solution = $doubt['answer'];
        // Truncate doubt message if it exceeds 40 characters
        $doubt_message = (strlen($doubt['doubt']) > 40) ? substr($doubt['doubt'], 0, 40) . "..." : $doubt['doubt'];
        $teacher_id = $doubt['teacher_id'];
        // Format the created_at timestamp
        $sent_time = date("F j, Y g:i A", strtotime($doubt['doubt_created_at']));
        $received_time = date("F j, Y g:i A", strtotime($doubt['answer_created_at']));
    } else {
        // Doubt not found
        echo "Doubt not found.";
        exit();
    }
} else {
    // Doubt ID parameter not provided
    echo "Doubt ID not provided.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
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
    <link rel="stylesheet" href="../css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="css/chat.css">




</head>

<body class="crm_body_bg" style="overflow:scroll; height:100vh;">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <di class="chat-page">
            <div class="chat-header">
                <span class="back-icon" onclick="goBack()">&#9665;</span>
                <img src="<?php echo $profile_image_src; ?>" alt="Profile" class="profile-image">
                <div class="profile-info">
                    <h2>
                        <?php echo $doubt['user_id'] ? $profile_data['name'] : 'Student not assigned'; ?>
                    </h2>
                    <p>
                        <?php echo $doubt_message; ?>
                    </p>
                    <p class="date-time">
                        <?php echo $sent_time; ?>
                    </p>
                </div>
                <?php if ($doubt['accepted'] == 0) : ?>
                    <div class="icons">
                        <a href="../backend/doubt_reject.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" onclick="return confirmReject()">
                            <span class="close-icon"><i class="fas fa-times"></i></span>
                        </a>
                        <a href="../backend/doubt_accept.php?doubt_id=<?php echo $doubt['doubt_id']; ?>" onclick="return confirmAccept()">
                            <span class="right-icon"><i class="fas fa-check"></i></span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['accepted'] == 1) : ?>
                    <?php if ($doubt['doubt_submit'] == 0) : ?>
                        <!-- Show a button to End chat -->
                        <a href="../backend/end_chat.php?doubt_id=<?php echo $doubt['doubt_id']; ?>"><button onclick="return confirmEnd()">End Chat</button></a>
                    <?php elseif ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 0) : ?>
                        <!-- Show text in color that waiting for feedback -->
                        <p style="color: blue;">Waiting for feedback</p>
                    <?php elseif ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 1) : ?>
                        <!-- Show "Chat Ended" in red -->
                        <p style="color: red;">Chat Ended</p>
                    <?php endif; ?>
                <?php endif; ?>


            </div>

            <div class="chat-content">
                <!-- Chat messages go here -->
                <?php if ($doubt['doubt']) : ?>
                    <div class="message received">
                        <p>
                            <?php echo $doubt_description ?>
                        </p>
                        <p class="message-time">
                            <?php echo $sent_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['doubt_file']) : ?>
                    <div class="message received">

                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['doubt_file'], PATHINFO_EXTENSION));
                        if ($doubt_media_type === 'pdf' || $doubt_media_type === 'doc' || $doubt_media_type === 'docx') : ?>
                            <!-- Example 2: PDF -->
                            <a href="../../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" style="cursor: pointer;" onclick="zoomMedia(this, '<?php echo $doubt_media_type; ?>')">Click to view <?php echo strtoupper($doubt_media_type); ?></a>
                        <?php elseif ($doubt_media_type === 'mp4') : ?>
                            <!-- Example 3: Video -->
                            <video controls onclick="zoomMedia(this, 'video')">
                                <source src="../../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <!-- Example 1: Image -->
                            <img src="../../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" alt="Image Message" onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $sent_time; ?>
                        </p>
                        <a href="../../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>" class="download-link" download>Download
                            <?php echo ucfirst($doubt_media_type); ?>
                        </a>

                    </div>
                <?php endif; ?>
                <?php if ($doubt['answer']) : ?>
                    <div class="message sent">
                        <p>
                            <?php echo $doubt_solution ?>
                        </p>
                        <p class="message-time">
                            <?php echo $received_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['answer_file']) : ?>
                    <div class="message sent">

                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['answer_file'], PATHINFO_EXTENSION));
                        if ($doubt_media_type === 'pdf' || $doubt_media_type === 'doc' || $doubt_media_type === 'docx') : ?>
                            <!-- Example 2: PDF -->
                            <a href="../uploads/doubt/<?php echo $doubt['answer_file']; ?>" style="cursor: pointer;" onclick="zoomMedia(this, '<?php echo $doubt_media_type; ?>')">Click to view <?php echo strtoupper($doubt_media_type); ?></a>
                        <?php elseif ($doubt_media_type === 'mp4') : ?>
                            <!-- Example 3: Video -->
                            <video controls>
                                <source src="../uploads/doubt/<?php echo $doubt['answer_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <!-- Example 1: Image -->
                            <img src="../uploads/doubt/<?php echo $doubt['answer_file']; ?>" alt="Image Message" onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $received_time; ?>
                        </p>
                        <a href="../uploads/doubt/<?php echo $doubt['answer_file']; ?>" class="download-link" download>Download
                            <?php echo ucfirst($doubt_media_type); ?>
                        </a>

                    </div>
                <?php endif; ?>
                <?php if ($video_call['videocall_link']) : ?>
                    <div class="message video">
                        <h5 style="color: #2F2F2F;">
                            Video Call Link:
                            <button type="button" style="background-color: #2F2F2F;" onclick="joinVideoCall('<?php echo !empty($video_call) ? $video_call['videocall_link'] : ''; ?>')">Join Video Call</button>
                            <br />
                        </h5>
                        <p>
                            <?php echo $video_call['videocall_link']; ?>
                        </p>
                        <br />
                        <h5 style="color: #2F2F2F;">
                            Join Code:
                            <span style="color: white;"><?php echo $video_call['join_code']; ?></span>
                            <button class="copy-btn" style="background-color: #2F2F2F;" onclick="copyToClipboard('<?php echo !empty($video_call) ? $video_call['join_code'] : ''; ?>')">
                                <i class="fas fa-copy"></i>
                            </button>
                            <br />
                        </h5>

                        <p class="message-time">
                            <?php echo $sent_time; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Zoom Modal -->
                <div id="zoomModal" class="modal" onclick="closeZoom()">
                    <span class="close" onclick="closeZoom()">&times;</span>
                    <div id="zoomedContent" class="modal-content"></div>
                    <a id="downloadLink" class="download-link" download>Download Media</a>
                </div>
            </div>

            <?php if ($doubt['accepted'] == 1 && (!($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 1))) : ?>
                <!-- Message input section -->
                <div class="additional-details" id="additionalDetails">
                    <form id="solutionForm" enctype="multipart/form-data" action="../backend/solution.php" method="post">
                        <input type="hidden" name="doubt_id" value="<?php echo $doubt_id; ?>">
                        <div class="form-group">
                            <label for="solution">Solution:</label>
                            <textarea id="solution" name="solution" placeholder="Type your solution..."><?php if ($doubt['answer']) : ?><?php echo $doubt_solution ?><?php endif; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="fileUpload">Upload File:</label>
                            <input type="file" id="fileUpload" name="fileUpload">
                            <?php if ($doubt['answer_file']) : ?>
                                <input type="hidden" name="existingFile" value="<?php echo $doubt['answer_file']; ?>">
                                <?php echo $doubt['answer_file']; ?> <!-- Display the file name -->
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="videoLink">Video Call Link:</label>
                            <input type="text" id="videoLink" name="videoLink" placeholder="Paste video call link..." <?php echo ($video_call !== false && $video_call['videocall_link']) ? 'value="' . $video_call['videocall_link'] . '"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label for="joinCode">Join Code:</label>
                            <input type="text" id="joinCode" name="joinCode" placeholder="Enter join code..." <?php echo ($video_call !== false && $video_call['join_code']) ? 'value="' . $video_call['join_code'] . '"' : ''; ?>>
                        </div>

                        <button type="submit" class="edit-details-button">Submit</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 1) : ?>
                <div class="additional-details" id="additionalDetails">
                    <div style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                        <h2 style="margin-bottom: 5px;">Feedback</h2>
                        <h4 style="color: blue;">(
                            <?php echo $feedback['satisfaction_level'] ?> Star)
                        </h4>
                        <p style="color: #333;">
                            <?php echo $feedback['feedback_text'] ?>
                        </p>
                    </div>
                    <div style="text-align:center; ">
                        <p style="color: #000;">
                            This Chat Has been Ended. You can view feedback given by Student.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            </div>
            <div id="zoomModal" class="modal" onclick="closeZoom()">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="zoomedImage">
                    <a id="downloadLink" class="download-link" download>Download Image</a>
                </div>
            </div>
    </section>
    <?php include('../includes/notes.php'); ?>

    <?php include('../includes/script.php'); ?>
    <script src="js/chat.js"></script>

</body>

</html>