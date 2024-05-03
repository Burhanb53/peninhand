<?php
session_start();
include('../../../includes/config.php');
$page_url= "chat.php" ;
// Fetch the doubt details based on doubt_id from the URL parameter
if (isset($_GET['doubt_id'])) {
    $doubt_id = $_GET['doubt_id'];
    // Update student_view to 1 for the specified doubt_id
    $sql = "UPDATE doubt SET student_view = 1 WHERE doubt_id = :doubt_id and feedback = 0";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);
    $stmt->execute(); // Execute the update query

    // Query to fetch doubt details using doubt_id
    $stmt_doubt = $dbh->prepare("SELECT * FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->execute();
    $doubt = $stmt_doubt->fetch();


    $stmt_feedback = $dbh->prepare("SELECT * FROM feedback WHERE doubt_id = :doubt_id");
    $stmt_feedback->bindParam(':doubt_id', $doubt_id);
    $stmt_feedback->execute();
    $feedback = $stmt_feedback->fetch();


    $stmt_video_call = $dbh->prepare("SELECT * FROM video_call WHERE doubt_id = :doubt_id");
    $stmt_video_call->bindParam(':doubt_id', $doubt_id);
    $stmt_video_call->execute();
    $video_call = $stmt_video_call->fetch();

    // Check if doubt is found
    if ($doubt) {
        // Fetch profile image based on user_id from subscription_user table
        $stmt_profile = $dbh->prepare("SELECT photo, name FROM teacher WHERE teacher_id = :teacher_id");
        $stmt_profile->bindParam(':teacher_id', $doubt['teacher_id']);
        $stmt_profile->execute();
        $profile_data = $stmt_profile->fetch();
        if ($profile_data) {
            $profile_image_src = "../../../teacher/Dashboard/uploads/profile/" . $profile_data['photo'];
        } else {
            // Default profile image source if no profile image found
            $profile_image_src = "../img/profile.jpg";
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

    <style>
        /* Global Styles */



        main {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Chat Page Styles */

        .chat-page {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;
        }

        /* Chat Header Styles */

        .chat-header {
            position: sticky;
            top: 0;
            z-index: 50;
            color: #fff;
            padding: 10px;
            display: flex;
            align-items: center;
            /* background-color: #F2F2F2;
    border-radius: 10px;
    margin-bottom: 2px; */
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h2,
        .profile-info p {
            margin: 0;
            font-size: 16px;
        }

        .date-time {
            font-size: 12px;
        }

        /* Chat Content Styles */

        .chat-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            max-width: 800px;
            max-height: 500px;
            background-color: #f2f2f2;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Scrollbar Customization */

        .chat-content::-webkit-scrollbar {
            width: 6px;
        }

        .chat-content::-webkit-scrollbar-thumb {
            background-color: #B9BABA;
            border-radius: 6px;
        }

        .chat-content::-webkit-scrollbar-track {
            background-color: #f5f5f5;
        }

        /* Message Styles */

        .message {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 10px;
            max-width: 70%;
            max-width: 800px;
            word-wrap: break-word;
        }

        .received {
            background-color: #2F2F2F;
            align-self: flex-start;
            font-size: 1rem;
            color: white;
        }

        .received p {
            color: white;
        }

        .message-time {
            font-size: 12px;
            color: #888;
        }

        .message-input {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        /* Message Input Styles */

        .message-input {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        textarea {
            flex-grow: 1;
            resize: vertical;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
        }

        /* Textarea Scrollbar Customization */

        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-thumb {
            background-color: #B9BABA;
            border-radius: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background-color: #f5f5f5;
        }

        /* Button Styles */

        button {
            padding: 8px;
            margin-left: 10px;
            cursor: pointer;
            background-color: #4285f4;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background: #2980b9;
        }

        /* Back Icon Styles */

        .back-icon {
            font-size: 24px;
            color: #000;
            margin-right: 10px;
            cursor: pointer;
        }

        /* Modal Styles */

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            left: 0;
            top: 0;
            align-items: center;
            justify-content: center;
            overflow: auto;
        }

        .modal-content {
            margin: auto;
            margin-top: 150px;
        }

        .modal img {
            width: 400px;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal img:hover {
            transform: scale(1.1);
        }

        .close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }

        .download-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: black;
            text-decoration: none;
            cursor: pointer;
            background-color: #DEDFE2;
        }

        .message img {
            width: 250px;
            height: 250px;
            cursor: pointer;
        }

        .sent {
            background-color: #00A67D;
            align-self: flex-end;
            font-size: 1rem;
        }

        .video {
            background-color: #638BFE;
            align-self: flex-end;
            font-size: 1rem;

        }

        .sent .message-time,
        .video .message-time {
            color: white
        }

        .sent p,
        a,
        .video p,
        a {
            color: white;
        }

        video {
            height: 400px;
        }

        /* Responsive Styles */

        @media (max-width: 600px) {
            .chat-page {
                padding: 0 10px;
                margin-left: 20px;
                margin-right: 20px;
                margin-top: 20px;
            }

            .chat-content {
                max-height: 90vh;
            }

            .modal img {
                width: 100%;
                height: auto;
                max-width: 100%;
                max-height: 100%;
                cursor: pointer;
                transition: transform 0.3s ease;
                margin: auto;
                margin-top: 10%;
            }
        }

        main.cd__main {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            min-width: 1200px;
        }

        .additional-details {
            margin-top: 20px;
            background-color: #F2F2F2;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            /* Adjust the width as needed */
            max-width: 800px;
            /* Set a minimum width */
        }

        form#solutionForm {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        textarea,
        input[type="text"],
        input[type="file"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        textarea {
            resize: vertical;
            max-height: 200px;
            overflow-y: auto;
        }

        button.edit-details-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button.edit-details-button:hover {
            background: #2980b9;
        }

        @media (max-width: 600px) {

            .additional-details {

                /* Adjust the width as needed */
                max-width: 400px;
                /* Set a minimum width */
            }
        }

        .icons {
            display: flex;
            align-items: center;
        }


        .close-icon,
        .right-icon {
            font-size: 20px;
            margin-left: 10px;
            cursor: pointer;
            color: #fff;
            border-radius: 50%;
            padding: 5px 8px;
        }

        .close-icon {
            background-color: red;
            padding: 5px 10px;

        }

        .right-icon {
            background-color: green;
        }

        p {
            font-size: 1rem;

        }

        .add-note-button {
            margin-left: auto;
            /* Pushes the add button to the right */
            padding: 5px;
            border: none;
            background-color: white;
            border-radius: 5px;
            cursor: pointer;

        }

        .add-note-button svg {
            width: 24px;
            height: 24px;
            fill: red;

        }

        .add-note-button:hover {
            background-color: #f5f5f5;
        }
    </style>
    <style>
        .new-note-card {
            width: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }

        .note-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .new-note-content {
            border: none;
            width: 100%;
            height: 200px;
            padding: 10px;
            background-image: repeating-linear-gradient(180deg, transparent, transparent 2px, #F1F1F1 2px, #F1F1F1 8px);
            font-family: Arial, sans-serif;
            font-size: 16px;
            resize: none;
        }

        .note-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .doubt {
            margin-top: 10px;
            width: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }
    </style>


</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <div class="chat-page">
            <div class="chat-header">
                <span class="back-icon" onclick="goBack()">&#9665;</span>
                <img src="<?php echo $profile_image_src; ?>" alt="Profile" class="profile-image">
                <div class="profile-info">
                    <h2>
                        <?php echo $doubt['teacher_id'] ? $profile_data['name'] : 'Teacher not assigned'; ?>
                    </h2>
                    <p>
                        <?php echo $doubt_message; ?>
                    </p>
                    <p class="date-time">
                        <?php echo $sent_time; ?>
                    </p>
                </div>
                <?php if ($doubt['accepted'] == 1) : ?>
                    <?php if ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 0) : ?>
                        <!-- Show text in color that waiting for feedback -->
                        <p style="color: blue;">"Please provide feedback below. Thank you!"</p>
                    <?php elseif ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 1) : ?>
                        <!-- Show "Chat Ended" in red -->
                        <p style="color: red;">Chat Ended</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="chat-content">
                <!-- <div class="message">
                    <div style="display: flex; align-items: center; ">
                        <h4>Add to Notes</h4>
                        <button class="add-note-button" style="margin-left: 10px; " onclick="openNoteCard()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5V19" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 12H19" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="new-note-card" id="noteCard" style="display: none; align-items: center; justify-content: center; margin: auto;">
                        <div class="close-note" style="margin-bottom: 10px; float: inline-end;" onclick="openNoteCard()">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="black" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="black" />
                            </svg>
                        </div>
                        <input type="text" class="note-title" placeholder="Title" required>
                        <textarea class="new-note-content" placeholder="Write your notes here..." required></textarea>
                        <button class="note-button">Add</button>
                    </div>
                </div> -->
                <!-- Chat messages go here -->
                <?php if ($doubt['doubt']) : ?>
                    <div class="message sent">
                        <p>
                            <?php echo $doubt_description ?>
                        </p>
                        <p class="message-time">
                            <?php echo $sent_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['doubt_file']) : ?>
                    <div class="message sent">
                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['doubt_file'], PATHINFO_EXTENSION));
                        if ($doubt_media_type === 'pdf' || $doubt_media_type === 'doc' || $doubt_media_type === 'docx') : ?>
                            <!-- Example 2: PDF -->
                            <a href="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" style="cursor: pointer;" onclick="zoomMedia(this, '<?php echo $doubt_media_type; ?>')">Click to view <?php echo strtoupper($doubt_media_type); ?></a>
                        <?php elseif ($doubt_media_type === 'mp4') : ?>
                            <!-- Example 3: Video -->
                            <video controls onclick="zoomMedia(this, 'video')">
                                <source src="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <!-- Example 1: Image -->
                            <img src="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" alt="Image Message" onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $sent_time; ?>
                        </p>
                        <a href="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" class="download-link" download>Download
                            <?php echo ucfirst($doubt_media_type); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['answer']) : ?>
                    <div class="message received">
                        <p>
                            <?php echo $doubt_solution ?>
                        </p>
                        <p class="message-time">
                            <?php echo $received_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if ($doubt['answer_file']) : ?>
                    <div class="message received">
                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['answer_file'], PATHINFO_EXTENSION));

                        if ($doubt_media_type === 'pdf' || $doubt_media_type === 'doc' || $doubt_media_type === 'docx') : ?>
                            <!-- Example 2: PDF -->
                            <a href="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" style="cursor: pointer;" onclick="zoomMedia(this, '<?php echo $doubt_media_type; ?>')">Click to view <?php echo strtoupper($doubt_media_type); ?></a>
                        <?php elseif ($doubt_media_type === 'mp4') : ?>
                            <!-- Example 3: Video -->
                            <video controls>
                                <source src="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <!-- Example 1: Image -->
                            <img src="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" alt="Image Message" onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $received_time; ?>
                        </p>
                        <a href="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" class="download-link" download>Download
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
                    <form id="solutionForm" enctype="multipart/form-data" action="../backend/edit_doubt.php" method="post">
                        <input type="hidden" name="doubt_id" value="<?php echo $doubt_id; ?>">
                        <div class="form-group">
                            <label for="solution">Doubt:</label>
                            <textarea id="solution" name="doubt" placeholder="Type your solution..."><?php if ($doubt['doubt']) : ?><?php echo $doubt_description ?><?php endif; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="fileUpload">Upload File:</label>
                            <input type="file" id="fileUpload" name="fileUpload">
                            <?php if ($doubt['doubt_file']) : ?>
                                <input type="hidden" name="existingFile" value="<?php echo $doubt['doubt_file']; ?>">
                                <?php echo $doubt['doubt_file']; ?> <!-- Display the file name -->
                            <?php endif; ?>
                        </div>


                        <button type="submit" class="edit-details-button">Submit</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 1) : ?>
                <div class="additional-details" id="additionalDetails">
                    <div style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                        <h2 style="margin-bottom: 5px;">Feedback</h2>
                        <h4 style="color: blue;">(<?php echo $feedback['satisfaction_level'] ?> Star)</h4>
                        <p style="color: #333;">
                            <?php echo $feedback['feedback_text'] ?>
                        </p>
                    </div>
                    <div style="text-align:center; ">
                        <p style="color: #000;">
                            This Chat Has been Ended.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($doubt['doubt_submit'] == 1 && $doubt['feedback'] == 0) : ?>
                <div class="additional-details" id="additionalDetails">
                    <p style="color: blue;">You can end the chat by providing feedback below or continuing with your
                        question.</p><br>
                    <form id="feedbackForm" action="../backend/submit_feedback.php" method="post">
                        <input type="hidden" name="doubt_id" value="<?php echo $doubt_id; ?>">
                        <input type="hidden" name="teacher_id" value="<?php echo $doubt['teacher_id'] ?>">
                        <div class="form-group">
                            <label for="feedback">Feedback:</label>
                            <textarea id="feedback" name="feedback" placeholder="Type your feedback..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>How satisfied are you with the solution provided?</label><br>
                            <input type="radio" id="satisfied1" name="satisfied" value="1">
                            <label for="satisfied1">1 Star</label><br>
                            <input type="radio" id="satisfied2" name="satisfied" value="2">
                            <label for="satisfied2">2 Stars</label><br>
                            <input type="radio" id="satisfied3" name="satisfied" value="3">
                            <label for="satisfied3">3 Stars</label><br>
                            <input type="radio" id="satisfied4" name="satisfied" value="4">
                            <label for="satisfied4">4 Stars</label><br>
                            <input type="radio" id="satisfied5" name="satisfied" value="5">
                            <label for="satisfied5">5 Stars</label><br>
                        </div>
                        <button type="submit" class="edit-details-button">Submit</button>
                    </form>
                </div>
            <?php endif; ?>


        </div>


    </section>
    <?php include('../includes/notes.php'); ?>

    <script>
        function zoomMedia(element, mediaType) {
            var modal = document.getElementById('zoomModal');
            var zoomedContent = document.getElementById('zoomedContent');
            var downloadLink = document.getElementById('downloadLink');

            modal.style.display = 'block';
            zoomedContent.innerHTML = ''; // Clear previous content

            if (mediaType === 'image') {
                const img = document.createElement('img');
                img.src = element.src;
                zoomedContent.appendChild(img);

                // Set the href property of the download link for images
                downloadLink.href = element.src;
                downloadLink.style.display = 'block'; // Show download link for images
            } else if (mediaType === 'pdf' || mediaType === 'doc' || mediaType === 'docx') {
                // Display PDF in a new tab

                // Hide the download link for PDFs
                downloadLink.style.display = 'none';
            } else if (mediaType === 'video') {
                const video = document.createElement('video');
                video.src = element.querySelector('source').src;
                video.controls = true;
                video.width = '100%';
                video.height = 'auto';
                zoomedContent.appendChild(video);

                // Hide the download link for videos
                downloadLink.style.display = 'none';
            }
        }


        function closeZoom() {
            var modal = document.getElementById('zoomModal');
            modal.style.display = 'none';
        }


        function closeZoom() {
            var modal = document.getElementById('zoomModal');
            modal.style.display = 'none';
        }

        function goBack() {
            window.history.back();
        }

        function sendMessage() {
            // Add logic to send a message
        }
    </script>
    <script>
        function copyToClipboard(text) {
            // Create a temporary input element
            var tempInput = document.createElement("input");
            // Set the input element's value to the text to be copied
            tempInput.value = text;
            // Append the input element to the document
            document.body.appendChild(tempInput);
            // Select the text in the input element
            tempInput.select();
            // Copy the selected text to the clipboard
            document.execCommand("copy");
            // Remove the temporary input element from the document
            document.body.removeChild(tempInput);
            // Optionally, provide user feedback or perform other actions
            alert("Copied to clipboard: " + text);
        }
    </script>
    <script>
        function joinVideoCall(text) {
            var videoLink = text;
            // var joinCode = document.getElementById('joinCode').value;

            // Add your logic here to handle the video call link and join code
            // You can redirect or initiate the video call based on the provided information
            var confirmation = confirm('Joining video call:\nVideo Link: ' + videoLink + '\n\nAre you copied join code ? ');

            if (confirmation) {
                var searchUrl = 'https://www.google.com/search?q=' + encodeURIComponent(videoLink);

                // Open the search URL in a new tab
                window.open(searchUrl, '_blank');
            } else {
                // Cancelled
                alert('Video call join cancelled.');
            }
        }

        
    </script>

    <?php include('../includes/script.php'); ?>

</body>

</html>