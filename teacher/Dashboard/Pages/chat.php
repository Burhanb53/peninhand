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
        }

        .received {
            background-color: #e6f7ff;
            align-self: flex-start;
        }

        .sent {
            background-color: #d4e6f1;
            align-self: flex-end;
        }

        .message-time {
            font-size: 12px;
            color: #888;
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

        /* Download Link Styles */

        .download-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: black;
            text-decoration: none;
            cursor: pointer;
            background-color: #DEDFE2;
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
    </style>



</head>

<body class="crm_body_bg" style="overflow:scroll; height:100vh;">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <div class="chat-page">
            <div class="chat-header">
                <span class="back-icon" onclick="goBack()">&#9665;</span>
                <img src="../img/card.jpg" alt="Profile Image" class="profile-image">
                <div class="profile-info">
                    <h2>John Doe</h2>
                    <p>Short description about John Doe</p>
                    <p class="date-time">March 8, 2024 12:45 PM</p>
                </div>
                <div class="icons">
                    <a href="#"><span class="close-icon"><i class="fas fa-times"></i></span></a>
                    <a href="#"><span class="right-icon"><i class="fas fa-check"></i></span></a>
                </div>
            </div>

            <div class="chat-content">
                <!-- Chat messages go here -->
                <div class="message received">
                    <p>Hello! How are you doing?</p>
                    <p class="message-time">Sent on March 8, 2024 10:30 AM</p>
                </div>

                <div class="message sent">
                    <!-- Example 1: Image -->
                    <img style="width: 200px; height: auto;" src="../img/card.jpg" alt="Image Message"
                        onclick="zoomMedia(this, 'image')">
                    <p class="message-time">Sent on March 8, 2024 10:35 AM</p>
                    <a href="../img/card.jpg" class="download-link" download>Download Image</a>
                </div>

                <div class="message sent">
                    <!-- Example 2: PDF -->
                    <a style="cursor: pointer;" onclick="zoomMedia(this, 'pdf')">Click to view PDF</a>
                    <p class="message-time">Sent on March 8, 2024 10:35 AM</p>
                    <a href="../img/mefa_1.pdf" class="download-link" download>Download PDF</a>
                </div>

                <div class="message sent">
                    <!-- Example 3: Video -->
                    <video style="width: 200px; height: auto;" controls onclick="zoomMedia(this, 'video')">
                        <source src="../img/trial.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p class="message-time">Sent on March 8, 2024 10:35 AM</p>
                    <a href="../img/trial.mp4" class="download-link" download>Download Video</a>
                </div>


                <!-- Zoom Modal -->
                <div id="zoomModal" class="modal" onclick="closeZoom()">
                    <span class="close" onclick="closeZoom()">&times;</span>
                    <div id="zoomedContent" class="modal-content"></div>
                    <a id="downloadLink" class="download-link" download>Download Media</a>
                </div>
            </div>

            <!-- Message input section -->
            <div class="additional-details" id="additionalDetails">
                <form id="solutionForm">
                    <div class="form-group">
                        <label for="solution">Solution:</label>
                        <textarea id="solution" name="solution" placeholder="Type your solution..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fileUpload">Upload File:</label>
                        <input type="file" id="fileUpload" name="fileUpload">
                    </div>

                    <div class="form-group">
                        <label for="videoLink">Video Call Link:</label>
                        <input type="text" id="videoLink" name="videoLink" placeholder="Paste video call link...">
                    </div>

                    <div class="form-group">
                        <label for="joinCode">Join Code:</label>
                        <input type="text" id="joinCode" name="joinCode" placeholder="Enter join code...">
                    </div>

                    <button type="submit" class="edit-details-button">Submit</button>
                </form>
            </div>
        </div>
        <div id="zoomModal" class="modal" onclick="closeZoom()">
            <span class="close">&times;</span>
            <div class="modal-content">
                <img id="zoomedImage">
                <a id="downloadLink" class="download-link" download>Download Image</a>
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
                downloadLink.download = 'image_download.jpg';
                downloadLink.style.display = 'block'; // Show download link for images
            } else if (mediaType === 'pdf') {
                // Display PDF in a new tab
                window.open('../img/mefa_1.pdf', '_blank');

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