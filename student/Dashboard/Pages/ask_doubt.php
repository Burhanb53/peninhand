<?php
session_start();

$message = isset ($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message from the session

error_reporting(0);
include ('includes/config.php');
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
<!-- Add these links in the head section of your HTML -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">





<style>
    .form-container {
        width: 100%;
        max-width: 80%;
        margin: 0 auto;
        /* Center the form horizontally */
    }


    .card {
        background-color: #F7ECF9;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .card-header {
        background-color: #2D1967;
        color: #fff;
        text-align: center;
        padding: 15px;
    }

    .card-body {
        padding: 20px;
        font-size: 20px;
    }

    .form-group {
        margin-bottom: 20px;

    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    textarea,
    input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 5px;

    }

    button {
        background-color: #2D1967;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float: right;
    }

    button:hover {
        background-color: #2980b9;
    }

    #filePreview {
        margin-top: 10px;
        max-width: 100%;
        overflow: hidden;
    }

    #filePreview img {
        width: 100%;
        border-radius: 5px;
        margin-top: 5px;
    }

    #filePreview a {
        color: #3498db;
        text-decoration: none;
    }

    .notification {
        display: none;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        padding: 20px;
        background-color: #333;
        color: #fff;
        border-radius: 5px;
    }
</style>
</head>

<body class="crm_body_bg">
    <?php include ('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include ('../includes/navbar.php'); ?>
        <div class="notification" id="notificationCard"></div>
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h3 style="color:white;">Ask Doubt</h3>
                </div>
                <div class="card-body">
                    <div class="card-content">
                        <p
                            style="color: <?php echo ($message === "Doubt submitted successfully.") ? "green" : "red"; ?>">
                            <?php echo $message; ?>
                        </p>
                    </div>
                    <form action="../backend/submit_doubt.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="doubt_Category">Question Category:</label>
                                <input type="text"  name="doubt_category" class="question-category" required>
                        </div>
                        <div class="form-group">
                            <label for="doubt">Description:</label>
                            <textarea id="doubt" name="doubt" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload File:</label>
                            <input type="file" id="file" name="file" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png">
                            <div id="filePreview"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Ask Doubt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <?php include ('../includes/footer.php'); ?>
    </section>
    <script>
        document.getElementById('file').addEventListener('change', function (event) {
            const fileInput = event.target;
            const filePreview = document.getElementById('filePreview');

            while (filePreview.firstChild) {
                filePreview.removeChild(filePreview.firstChild);
            }

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    filePreview.appendChild(img);
                } else {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(file);
                    link.textContent = file.name;
                    link.target = '_blank';
                    filePreview.appendChild(link);
                }
            }
        });



    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <?php include('../includes/script.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        // Initialize jQuery UI Autocomplete on the question category input field
        $(function () {
            var availableCategories = ["Physics", "Economics", "Maths", "Engg. Maths"]; // Add your available categories here

            $(".question-category").autocomplete({
                source: availableCategories
            });
        });
    </script>

</body>

</html>