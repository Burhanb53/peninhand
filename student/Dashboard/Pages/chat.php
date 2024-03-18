<?php
session_start();
include ('../../../includes/config.php');
// Fetch the doubt details based on doubt_id from the URL parameter
if (isset ($_GET['doubt_id'])) {
    $doubt_id = $_GET['doubt_id'];
    // Update student_view to 1 for the specified doubt_id
    $sql = "UPDATE doubt SET student_view = 1 WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);
    $stmt->execute(); // Execute the update query

    // Query to fetch doubt details using doubt_id
    $stmt_doubt = $dbh->prepare("SELECT * FROM doubt WHERE doubt_id = :doubt_id");
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->execute();
    $doubt = $stmt_doubt->fetch();

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
        body {
            overflow: hidden;
        }

        .chat-page {
            max-height: 80vh;
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;
        }

        .chat-header {
            position: sticky;
            top: 0;
            z-index: 100;
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

        .chat-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            max-width: 800px;
            background-color: #f2f2f2;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-height: 60vh;
        }

        /* Customize scrollbar */
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

        /* End of scrollbar customization */

        .message {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 10px;
            max-width: 70%;
            max-width: 800px;
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

        textarea {
            flex-grow: 1;
            resize: none;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 8px;
            margin-left: 10px;
            cursor: pointer;
            background-color: #4285f4;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .back-icon {
            font-size: 24px;
            color: #000;
            margin-right: 10px;
            cursor: pointer;
        }

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
            margin-top: 100px;
            margin-top: 150px;
        }

        .modal img {
            width: 400px;
            /* Set the width to 100% to fit perfectly in the container */
            height: auto;
            /* Maintain aspect ratio */
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

        .sent .message-time {
            color: white
        }

        .sent p,
        a {
            color: white;
        }

        video {
            height: 400px;
        }

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

        p {
            font-size: 1rem;

        }
    </style>

</head>

<body class="crm_body_bg">
    <?php include ('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include ('../includes/navbar.php'); ?>

        <div class="chat-page">
            <div class="chat-header">
                <span class="back-icon" onclick="goBack()">&#9665;</span>
                <img src="<?php echo $profile_image_src; ?>" alt="Profile" class="profile-image">
                <div class="profile-info">
                    <h2>
                        <?php echo $doubt['teacher_id'] ?  $profile_data['name'] : 'Teacher not assigned'; ?>
                    </h2>
                    <p>
                        <?php echo $doubt_message; ?>
                    </p>
                    <p class="date-time">
                        <?php echo $sent_time; ?>
                    </p>
                </div>
            </div>

            <div class="chat-content">
                <!-- Chat messages go here -->
                <?php if ($doubt['doubt']): ?>
                    <div class="message sent">
                        <p>
                            <?php echo $doubt_description ?>
                        </p>
                        <p class="message-time">
                            <?php echo $sent_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="message sent">
                    <?php if ($doubt['doubt_file']): ?>
                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['doubt_file'], PATHINFO_EXTENSION));
                        if ($doubt_media_type === 'pdf'): ?>
                            <!-- Example 2: PDF -->
                            <a href="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" style="cursor: pointer;"
                                onclick="zoomMedia(this, 'pdf')">Click to view PDF</a>
                        <?php elseif ($doubt_media_type === 'mp4'): ?>
                            <!-- Example 3: Video -->
                            <video controls onclick="zoomMedia(this, 'video')">
                                <source src="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else: ?>
                            <!-- Example 1: Image -->
                            <img src="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" alt="Image Message"
                                onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $sent_time; ?>
                        </p>
                        <a href="../uploads/doubt/<?php echo $doubt['doubt_file']; ?>" class="download-link"
                            download>Download
                            <?php echo ucfirst($doubt_media_type); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ($doubt['answer']): ?>
                    <div class="message received">
                        <p>
                            <?php echo $doubt_solution ?>
                        </p>
                        <p class="message-time">
                            <?php echo $received_time; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="message received">
                    <?php if ($doubt['answer_file']): ?>
                        <?php
                        $doubt_media_type = strtolower(pathinfo($doubt['answer_file'], PATHINFO_EXTENSION));
                        if ($doubt_media_type === 'pdf'): ?>
                            <!-- Example 2: PDF -->
                            <a href="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" style="cursor: pointer;"
                                onclick="zoomMedia(this, 'pdf')">Click to view PDF</a>
                        <?php elseif ($doubt_media_type === 'mp4'): ?>
                            <!-- Example 3: Video -->
                            <video controls>
                                <source src="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else: ?>
                            <!-- Example 1: Image -->
                            <img src="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" alt="Image Message"
                                onclick="zoomMedia(this, 'image')">
                        <?php endif; ?>
                        <p class="message-time">Sent on
                            <?php echo $received_time; ?>
                        </p>
                        <a href="../../../teacher/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>" class="download-link"
                            download>Download
                            <?php echo ucfirst($doubt_media_type); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <!-- Zoom Modal -->
                <div id="zoomModal" class="modal" onclick="closeZoom()">
                    <span class="close" onclick="closeZoom()">&times;</span>
                    <div id="zoomedContent" class="modal-content"></div>
                    <a id="downloadLink" class="download-link" download>Download Media</a>
                </div>
            </div>


        </div>

    </section>

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
            } else if (mediaType === 'pdf') {
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

</body>

</html>