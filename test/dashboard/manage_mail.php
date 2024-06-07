<?php
session_start();
error_reporting(0);
include ('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card {
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            display: flex;
            justify-content: space-between;
            /* Align items to the start and end of the container */
        }

        .syntax {
            flex-grow: 1;
            
            /* Allow the syntax section to grow and take up remaining space */
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: white;
        }

        .send-mail-btn,
        .send-btn {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-color: #007bff;
        }

        /* Modal container */
        .modal {
            display: none;
            /* Hide the modal by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            /* Semi-transparent black background */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            /* White background */
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
            max-width: 600px;
            /* Limit modal width */
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Form styling */
        #teacherSelectionForm {
            margin-top: 20px;
        }

        h3 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        /* Button styling */
        button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Darker green */
        }


        /* Style for select element */
        #teacher {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 16px;
            color: #333;
        }

        /* Style for send button */
        #sendButton {
            margin-top: 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #sendButton:hover {
            background-color: #45a049;
            /* Darker green */
        }

        .teacher-option {
            display: block !important;
            margin-bottom: 10px !important;
            font-size: 16px !important;
            color: #333 !important;
        }

        .teacher-option input[type="checkbox"] {
            margin-right: 5px !important;
        }
    </style>
    <style>
        /* Loader CSS */
        #loader-container {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Buffering message CSS */
        #buffering-message {
            display: none;
            position: fixed;
            z-index: 9998;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body >
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php include ('includes/navbar.php'); ?>
        <?php include ('includes/sidebar.php'); ?>
        <!-- END HEADER MOBILE-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <section>

                            <div>
                                <!-- Scenario: Mail Student Whose Subscription is Ended -->
                                <div class="card ended-subscription">
                                    <div class="content">
                                        <!-- Syntax for Subscription Ended Mail -->
                                        <div class="syntax">
                                            <h2>Mail Student Whose Subscription is Ended</h2>
                                            <p>Your subscription has ended. Please renew your subscription to continue
                                                accessing our
                                                services.</p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-mail-btn">Send Mail</button>
                                    </div>
                                </div>

                                <!-- Scenario: Mail Subscription Going to End in Under 10 Days -->
                                <div class="card ending-subscription">
                                    <div class="content">
                                        <!-- Syntax for Subscription Ending Soon Mail -->
                                        <div class="syntax">
                                            <h2>Mail Subscription Going to End</h2>
                                            <p>Your subscription is going to end in under 10 days. Renew your
                                                subscription now to avoid
                                                interruption.</p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-mail-btn">Send Mail</button>
                                    </div>
                                </div>

                                <!-- Scenario: Mail Users Who Don't Have Subscription -->
                                <div class="card no-subscription">
                                    <div class="content">
                                        <!-- Syntax for No Subscription Mail -->
                                        <div class="syntax">
                                            <h2>Mail Users Without Subscription</h2>
                                            <p>You are currently not subscribed to our services. Subscribe now to enjoy
                                                exclusive benefits.
                                            </p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-mail-btn">Send Mail</button>
                                    </div>
                                </div>

                                <!-- Scenario: Mail Teachers Frequently Declining Doubts -->
                                <div class="card frequent-declining">
                                    <div class="content">
                                        <!-- Syntax for Frequent Declining Doubts Mail -->
                                        <div class="syntax">
                                            <h2>Mail Teachers Frequently Declining Doubts</h2>
                                            <p>Your response rate to student doubts is lower than expected. Please
                                                ensure timely assistance
                                                to students.</p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-btn" onclick="showTeacherSelection()">Send Mail</button>
                                    </div>
                                </div>

                                <!-- Scenario: Send Monthly Report to Students -->
                                <div class="card monthly-report-student">
                                    <div class="content">
                                        <!-- Syntax for Monthly Report to Students -->
                                        <div class="syntax">
                                            <h2>Send Monthly Report to Students</h2>
                                            <p>Here is your monthly report summarizing your academic progress and
                                                performance. Review it for
                                                insights.</p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-mail-btn">Send Mail</button>
                                    </div>
                                </div>

                                <!-- Scenario: Send Monthly Report to Teachers -->
                                <div class="card monthly-report-teacher">
                                    <div class="content">
                                        <!-- Syntax for Monthly Report to Teachers -->
                                        <div class="syntax">
                                            <h2>Send Monthly Report to Teachers</h2>
                                            <p>Here is the monthly report summarizing your teaching activities and
                                                student interactions.
                                                Review it for insights.</p>
                                        </div>
                                        <!-- Send Mail Button -->
                                        <button class="send-mail-btn">Send Mail</button>
                                    </div>
                                </div>


                            </div>

                            <!-- Teacher Selection Modal -->
                            <div id="teacherSelectionModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeTeacherSelectionModal()">&times;</span>
                                    <form id="teacherSelectionForm">
                                        <!-- Teacher options will be added here dynamically -->
                                    </form>
                                    <button type="button" onclick="senddecliningEmails()">Send Emails</button>
                                </div>
                            </div>

                            <div id="loader-container">
                                <div id="loader"></div>
                            </div>

                            <!-- <div id="buffering-message">
    <p>Sending...</p>
</div> -->

                    </div>
                </div>
            </div>
        </div>


        </section>
        <?php include ('includes/notes.php'); ?>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cards = document.querySelectorAll(".card");
                const colors = ["#FF6F61", "#6B5B95", "#88B04B", "#92A8D1", "#955251", "#B565A7", "#009B77", "#DD4124", "#D65076"];

                cards.forEach((card, index) => {
                    const color = colors[index % colors.length]; // Assign color from the array based on index
                    card.style.backgroundColor = color; // Set background color of the card
                });
            });
        </script>
</div>
</div>
</div>



</body>


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
<script src="js/chart.min.js"></script>

<script src="vendors/progressbar/jquery.barfiller.js"></script>

<script src="vendors/tagsinput/tagsinput.js"></script>

<script src="vendors/text_editor/summernote-bs4.js"></script>
<script src="vendors/apex_chart/apexcharts.js"></script>
<script src="js/custom.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all "Send Mail" buttons
        var sendMailBtns = document.querySelectorAll('.send-mail-btn');

        // Loop through each button
        sendMailBtns.forEach(function (btn) {
            // Add click event listener
            btn.addEventListener('click', function () {
                // Get the parent card's class
                var cardClass = btn.closest('.card').classList[1]; // Assumes each card has only one additional class

                // Show loader and buffering message
                showLoader();
                showBufferingMessage();

                // AJAX request to send mail
                $.ajax({
                    type: "POST",
                    url: "backend/send_mail.php", // Replace with actual URL for sending mail
                    data: {
                        cardType: cardClass
                    },
                    success: function (response) {
                        // Hide loader and buffering message
                        hideLoader();
                        hideBufferingMessage();

                        // Show success message or handle response
                        alert("Mail sent successfully!");
                    },
                    error: function (xhr, status, error) {
                        // Hide loader and buffering message
                        hideLoader();
                        hideBufferingMessage();

                        // Show error message or handle error
                        alert("Error occurred while sending mail!");
                    }
                });
            });
        });
    });

    // Function to show loader
    function showLoader() {
        $("#loader-container").show();
    }

    // Function to hide loader
    function hideLoader() {
        $("#loader-container").hide();
    }

    // Function to show buffering message
    function showBufferingMessage() {
        $("#buffering-message").show();
    }

    // Function to hide buffering message
    function hideBufferingMessage() {
        $("#buffering-message").hide();
    }
</script>
<script>
    // Function to show the teacher selection modal
    function showTeacherSelection() {
        var modal = document.getElementById('teacherSelectionModal');
        modal.style.display = 'block';

        // Make an AJAX call to fetch the list of teachers
        $.ajax({
            type: 'GET',
            url: 'backend/fetch_teachers.php',
            success: function (response) {
                // Parse the JSON response
                var teachers = JSON.parse(response);

                // Get the form element by its ID
                var form = document.getElementById('teacherSelectionForm');

                // Clear previous options from the form
                form.innerHTML = '';

                // Add a heading to the form
                var heading = document.createElement('h3');
                heading.textContent = 'Select Teachers:';
                form.appendChild(heading);

                // Loop through each teacher in the response and create an option element for each one
                teachers.forEach(function (teacher) {
                    // Create a checkbox element for the teacher
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'teachers[]';
                    checkbox.value = teacher.email;

                    // Create a label for the checkbox
                    var label = document.createElement('label');
                    label.textContent = teacher.name + ' (' + teacher.email + ')';

                    // Add inline CSS styles to the label
                    label.style.display = 'block';
                    label.style.marginBottom = '10px';

                    // Create a span for spacing between checkbox and label text
                    var span = document.createElement('span');
                    span.textContent = '\u00A0';

                    // Append the checkbox, span, and label to the form
                    label.appendChild(checkbox);
                    label.appendChild(span);
                    form.appendChild(label);
                });

            },
            error: function (xhr, status, error) {
                console.error('Error fetching teachers:', error);
            }
        });
    }

    // Function to close the teacher selection modal
    function closeTeacherSelectionModal() {
        var modal = document.getElementById('teacherSelectionModal');
        modal.style.display = 'none';
    }

    // Function to send doubt emails to selected teachers
    // Function to send doubt emails to selected teachers
    function senddecliningEmails() {
        // Get the selected teachers from the form and their corresponding emails
        var form = document.getElementById('teacherSelectionForm');
        var selectedTeachers = [];
        var checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');
        checkboxes.forEach(function (checkbox) {
            selectedTeachers.push({
                name: checkbox.getAttribute('data-name'),
                email: checkbox.value
            });
        });
        // Show loader and buffering message
        showLoader();
        showBufferingMessage();
        $.ajax({
            type: 'POST',
            url: 'backend/send_declining_doubts_emails.php',
            data: {
                teachers: selectedTeachers
            },
            success: function (response) {
                // Handle success response
                // Hide loader and buffering message
                hideLoader();
                hideBufferingMessage();
                // Show success message or handle response
                alert("Mail sent successfully!");
            },
            error: function (xhr, status, error) {
                // Hide loader and buffering message
                hideLoader();
                hideBufferingMessage();
                // Show error message or handle error
                alert("Error occurred while sending mail!");
            }
        });

        // Close the modal after sending emails
        closeTeacherSelectionModal();
    }
</script>

<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="js/main.js"></script>

</body>

</html>
<!-- end document-->

</html>