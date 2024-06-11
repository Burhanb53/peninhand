<?php
session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
// Include config.php or establish database connection if not already included
include('../../../includes/config.php');

// Fetch max end date for the current user's subscription
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$stmt = $dbh->prepare("SELECT MAX(end_date) AS max_end_date FROM subscription_user WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$subscription = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the current date
$current_date = date('Y-m-d');

// Compare max end date with current date
$subscription_valid = strtotime($subscription['max_end_date']) >= strtotime($current_date);
// Fetch unique doubt categories from the doubt table
$stmt = $dbh->prepare("SELECT DISTINCT doubt_category FROM doubt");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch tech_stack data from the doubt table
$stmt = $dbh->prepare("SELECT tech_stack FROM teacher");
$stmt->execute();
$tech_stack_result = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Separate tech_stack data into individual categories
$tech_stack_categories = [];
foreach ($tech_stack_result as $tech_stack) {
    $categories = explode(',', $tech_stack);
    $tech_stack_categories = array_merge($tech_stack_categories, $categories);
}

// Remove duplicates and empty values
$tech_stack_categories = array_unique(array_filter($tech_stack_categories));

// Combine both doubt categories and tech_stack categories
$availableCategories = array_merge($result, $tech_stack_categories);
$availableCategories = array_unique($availableCategories);

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
<link rel="stylesheet" href="css/ask_doubt.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;

    }

    .container {
        background-color: #fff;
        border: 2px solid #000;
        border-radius: 20px;
        padding: 20px;
        width: 700px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input[type="text"],
    textarea {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        background-color: #ccc;
        color: #333;
        font-size: 20px;
    }

    textarea {
        height: 150px;
        resize: none;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .upload-group {
        position: relative;
    }

    input[type="file"] {
        display: none;
    }

    label[for="upload"] {
        display: inline-block;
        cursor: pointer;
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 20px;
        background-color: #ccc;
        font-size: 20px;
        color: #333;
        margin-left: 15px;
    }

    button {
        padding: 10px 20px;
        background-color: #ccc;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 20px;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        margin-right: 15px;
    }

    button i,
    label[for="upload"] i {
        margin-right: 5px;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .container {
            width: 90%;
            padding: 15px;
        }

        input[type="text"],
        textarea,
        label[for="upload"],
        button {
            font-size: 18px;
            padding: 8px 16px;
        }

        textarea {
            height: 120px;
        }
    }

    @media (max-width: 480px) {
        .container {
            width: 95%;
            padding: 10px;
            margin-top: 100px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        input[type="text"],
        textarea,
        label[for="upload"],
        button {
            font-size: 16px;
            padding: 8px 14px;
        }

        textarea {
            height: 100px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 10px;
        }

        label[for="upload"],
        button {
            width: 100%;
            margin: 0;
        }

        button {
            justify-content: center;
        }
    }

    #loader-container {
        display: none;
        position: fixed;
        z-index: 9000;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
    }

    #loader {
        position: absolute;
        top: 50%;
        left: 45%;
        transform: translate(-50%, -50%);
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    /* Center loader in mobile view */
    @media only screen and (max-width: 768px) {
        #loader-container {
            display: none;
            position: fixed;
            z-index: 9000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #loader {
            position: absolute;
            transform: none;
            left: 35%;

        }
    }


    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #notification {
        display: none;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 8px 16px;
        z-index: 9999;
        width: auto;
        border-radius: 4px;
    }
</style>
</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>
        <div class="notification" id="notificationCard"></div>
        <div id="notification"></div>

        <div id="loader-container">
            <div id="loader"></div>
        </div>
        <div class="container">
            <h1>Ask Doubt</h1>
            <?php if ($_SESSION['message'] != null) : ?>
                <div class="message-container">
                    <div class="card-content <?php echo ($message === "Doubt submitted successfully.") ? "success" : "error"; ?>">
                        <p style="color: white; font-size: 20px;"><i class="fa fa-exclamation-circle" aria-hidden="true" style="padding-right: 5px;"></i><?php echo $message; ?></p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        var cardContent = document.querySelector('.card-content');
                        cardContent.classList.add('invisible');
                    }, 3000); // 2000 milliseconds = 2 seconds
                </script>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>


            <form id="doubtForm" action="../backend/submit_doubt.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="doubt_category" placeholder="Write a topic or subject name" required>
                </div>
                <div class="form-group">
                    <textarea id="doubt" name="doubt" placeholder="Description" required></textarea>
                </div>
                <div class="form-group action-buttons">
                    <div class="upload-group">
                        <input type="file" id="upload" name="file">
                        <label for="upload">
                            <i class="fas fa-folder-open"></i> Upload
                        </label>
                    </div>
                    <?php if ($subscription_valid) : ?>
                        <button type="submit" class="submit-btn"><i class="fas fa-arrow-right"></i> Submit</button>
                    <?php else : ?>
                        <button type="button" class="submit-btn" disabled style="background-color: red; color: white;" title="Your Subscription is expired">Subscription Expired</button>
                    <?php endif; ?>
                </div>
            </form>
            <div id="filePreview"></div>
        </div>

        <script>
            document.getElementById('upload').addEventListener('change', function(event) {
                const fileInput = event.target;
                const filePreview = document.getElementById('filePreview');

                while (filePreview.firstChild) {
                    filePreview.removeChild(filePreview.firstChild);
                }

                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const filePreviewContainer = document.createElement('div');

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        filePreviewContainer.appendChild(img);
                    } else {
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(file);
                        link.textContent = file.name;
                        link.target = '_blank';
                        filePreviewContainer.appendChild(link);
                    }

                    filePreview.appendChild(filePreviewContainer);
                }
            });
        </script>


    </section>
    <?php include('../includes/notes.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <?php include('../includes/script.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="js/ask_doubt.js"></script>
    <script>
        $(function() {
            // Fetch unique doubt categories from the doubt table
            var doubtCategories = <?php echo json_encode($result); ?>;

            // Fetch tech_stack data from the doubt table
            var techStackData = <?php echo json_encode($tech_stack_result); ?>;

            // Separate tech_stack data into individual categories
            var techStackCategories = [];
            techStackData.forEach(function(techStack) {
                var categories = techStack.split(',');
                techStackCategories = techStackCategories.concat(categories);
            });

            // Remove duplicates and empty values
            techStackCategories = techStackCategories.filter(function(category) {
                return category.trim() !== '';
            });
            techStackCategories = Array.from(new Set(techStackCategories));

            // Combine both doubt categories and tech_stack categories
            var availableCategories = doubtCategories.concat(techStackCategories);
            availableCategories = Array.from(new Set(availableCategories));

            // Initialize jQuery UI Autocomplete on the question category input field
            $(".question-category").autocomplete({
                source: availableCategories
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#submitBtn").click(function() {
                // Show loader
                $("#loader-container").show();

                // Show top notification
                $("#notification").text("Submitting form...").show();

                // Serialize form data
                var formData = new FormData($("#doubtForm")[0]);

                // Send AJAX request
                $.ajax({
                    url: $("#doubtForm").attr('action'),
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Hide loader
                        $("#loader-container").hide();
                        // Hide top notification after 3 seconds
                        $("#notification").text("Form submitted successfully.").delay(3000).fadeOut();
                        // Handle success response here
                        console.log(response);
                        window.location.reload();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Hide loader
                        $("#loader-container").hide();
                        // Show error notification
                        $("#notification").text("Error: " + xhr.responseText).show();
                        // Hide top notification after 5 seconds
                        setTimeout(function() {
                            $("#notification").fadeOut();
                        }, 5000);
                        window.location.reload();
                    }
                });
            });
        });
    </script>

</body>

</html>