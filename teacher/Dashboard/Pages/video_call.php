<?php
session_start();
include('../../../includes/config.php');

// Fetch doubts for the current user
$teacher_id = $_SESSION['user_id'];
$stmt = $dbh->prepare("SELECT doubt_id, user_id FROM doubt WHERE teacher_id = :teacher_id");
$stmt->bindParam(':teacher_id', $teacher_id);
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
<style>
    .videocall {
        display: flex;
        ;
        justify-content: center;
        align-items: center;
        max-width: 1200px;
        margin: auto;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
        margin-right: 10px;
        margin-top: 20px;
    }

    .form-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: #555;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        color: #333;
        font-size: 20px;
    }

    button {
        background-color: #4285f4;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #357ae8;
    }

    .call-links {
        flex-grow: 1;
        max-height: 400px;
        overflow-y: scroll;


    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-size: 15px;
    }

    td {
        background-color: #F9F9F9;
        word-wrap: break-word;
    }

    th {
        background-color: #FFFFFF;
        color: black;

    }

    .copy-btn {
        padding: 8px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px;
        float: inline-end;
    }

    @media (max-width: 990px) {
        .videocall {
            flex-direction: column;
            margin: auto 10px;
        }

        .form-container {
            margin-bottom: 20px;
        }

    }



    .call-links button:hover {
        background-color: #357ae8;
    }

    .call-links::-webkit-scrollbar {
        width: 8px;
        /* Set the width of the scrollbar */
    }

    .call-links::-webkit-scrollbar-thumb {
        background-color: #B9BABA;
        /* Set the color of the scrollbar thumb */
        border-radius: 6px;
        /* Set the border radius of the scrollbar thumb */
    }

    .call-links::-webkit-scrollbar-track {
        background-color: #f5f5f5;
        /* Set the color of the scrollbar track */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-9aIt2nRpD7/jqTGc8z5p92T6OqN7lKgN8f5dGPI8uZI7TzI7aTS1PbN2C7QyU5s" crossorigin="anonymous">

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
            <div class="table" style="flex: 1;">
                <div style="display:flex; ">
                    <h2 style="margin-right: 20px;">Video Call Links</h2>
                    <button type="button" onclick="joinVideoCall()" style="border-radius: 10px; ">Create Link</button>
                </div>
                <div class="call-links">
                    <?php
                    if (count($doubts) > 0) {
                        // Display the table header
                        echo "<table>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Sr. No</th>";
                        echo "<th>Student Name</th>";
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
                            $student_name = '';
                            if ($doubt['user_id']) {
                                $stmt_student = $dbh->prepare("SELECT name FROM subscription_user WHERE user_id = :user_id");
                                $stmt_student->bindParam(':user_id', $doubt['user_id']);
                                $stmt_student->execute();
                                $student = $stmt_student->fetch(PDO::FETCH_ASSOC);
                                if ($student) {
                                    $student_name = $student['name'];
                                }
                            }

                            // Convert date format to 12-hour format
                            $created_at = $video_call_data ? date("d-m-Y h:i A", strtotime($video_call_data['created_at'])) : '';
                            if (!empty($video_call_data) && !empty($video_call_data['videocall_link']) && !empty($video_call_data['join_code'])) {
                                echo "<tr>";
                                echo "<td>{$sr_no}</td>";
                                echo "<td>{$student_name}</td>";
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
    var confirmation = confirm('Are you sure you want to compose an email?');

    if (confirmation) {
        // Make an AJAX request to the backend script to send the email
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../backend/send_email.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Email sent successfully!');
            }
        };
        xhr.send();
    } else {
        // Cancelled
        alert('Email composition cancelled.');
    }
}

        </script>

        <?php include('../includes/footer.php'); ?>
    </section>
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