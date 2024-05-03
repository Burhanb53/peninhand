<?php
session_start();
include('../../../includes/config.php');

// Fetch doubts for the current user
$user_id = $_SESSION['user_id'];
$stmt = $dbh->prepare("SELECT doubt_id, teacher_id FROM doubt WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$doubts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-9aIt2nRpD7/jqTGc8z5p92T6OqN7lKgN8f5dGPI8uZI7TzI7aTS1PbN2C7QyU5s" crossorigin="anonymous">
<link rel="stylesheet" href="css/video_call.css">
</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>
        <div class="videocall">
            <div class="form-container">
                <h2>Video Call</h2>
                <form id="videoCallForm">
                    <label for="videoLink">Video Call Link:</label>
                    <input type="text" id="videoLink" name="videoLink" placeholder="Enter video call link" required>

                    <!-- <label for="joinCode">Join Code:</label>
                    <input type="text" id="joinCode" name="joinCode" placeholder="Enter join code" required> -->
                    <p style="color:red;">Don't forgot to copy JOIN CODE before joining call</p>
                    <button type="button" onclick="joinVideoCall()">Join Video Call</button>
                </form>
            </div>
            <div class="table">
                <div style="display:flex; ">
                    <h2 style="margin-right: 20px;">Video Call Links</h2>
                </div>
                <div class="call-links">
                    <?php
                    if (count($doubts) > 0) {
                        // Display the table header
                        echo "<table>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Sr. No</th>";
                        echo "<th>Teacher Name</th>";
                        echo "<th>Video Call Link</th>";
                        echo "<th>Join Code</th>";
                        echo "<th>Date and Time</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Loop through each doubt and display corresponding video call data
                        $sr_no = 1;
                        foreach ($doubts as $doubt) {
                            // Fetch video call data if available
                            $video_call_data = null;
                            $stmt_video_call = $dbh->prepare("SELECT videocall_link, join_code, created_at FROM video_call WHERE doubt_id = :doubt_id");
                            $stmt_video_call->bindParam(':doubt_id', $doubt['doubt_id']);
                            $stmt_video_call->execute();
                            $video_call_data = $stmt_video_call->fetch(PDO::FETCH_ASSOC);

                            // Fetch teacher name
                            $teacher_name = '';
                            if ($doubt['teacher_id']) {
                                $stmt_teacher = $dbh->prepare("SELECT name FROM teacher WHERE teacher_id = :teacher_id");
                                $stmt_teacher->bindParam(':teacher_id', $doubt['teacher_id']);
                                $stmt_teacher->execute();
                                $teacher = $stmt_teacher->fetch(PDO::FETCH_ASSOC);
                                if ($teacher) {
                                    $teacher_name = $teacher['name'];
                                }
                            }

                            // Convert date format to 12-hour format
                            $created_at = $video_call_data ? date("d-m-Y h:i A", strtotime($video_call_data['created_at'])) : '';
                            if (!empty($video_call_data) && !empty($video_call_data['videocall_link']) && !empty($video_call_data['join_code'])) {
                                echo "<tr>";
                                echo "<td>{$sr_no}</td>";
                                echo "<td>{$teacher_name}</td>";
                                echo "<td>" . (!empty($video_call_data) ? $video_call_data['videocall_link'] : '') . "<button class=\"copy-btn\" onclick=\"copyToClipboard('" . (!empty($video_call_data) ? $video_call_data['videocall_link'] : '') . "')\"><i class=\"fas fa-copy\"></i></button></td>";
                                echo "<td>" . (!empty($video_call_data) ? $video_call_data['join_code'] : '') . "<button class=\"copy-btn\" onclick=\"copyToClipboard('" . (!empty($video_call_data) ? $video_call_data['join_code'] : '') . "')\"><i class=\"fas fa-copy\"></i></button></td>";
                                echo "<td>{$created_at}</td>";
                                echo "</tr>";


                                $sr_no++;
                            }
                        }
                        // Close the table
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        // If no doubts are found
                        echo "No doubts found.";
                    }
                    ?>
                </div>
            </div>
        </div>

        <script>
           function joinVideoCall() {
                var videoLink = document.getElementById('videoLink').value;
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

        <?php include('../includes/footer.php'); ?>
    </section>
    <?php include('../includes/notes.php'); ?>

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php include('../includes/script.php'); ?>

</body>

</html>