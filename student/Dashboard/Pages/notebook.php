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

    .container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
.card, .placeholder {
    background-color: #d2b48c;
    border: 2px solid #8b4513;
    border-radius: 10px;
    width: 250px;
    height: 250px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 10px;
}
.card img {
    width: 80%;
    height: auto;
    border-radius: 10px;
}
.card .title-arrow {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0 15px; 
    margin-top: 10px;
}
.card .title {
    font-family: Arial, sans-serif;
    font-size: 20px;
    color: #4b3832;
    margin-left: 15px; 
}
.card .arrow {
    width: 30px;
    height: 30px;
    background-color: #8b4513;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 18px;
    cursor: pointer;
    margin-left: 15px;
}
.placeholder::before {
    content: '+';
    font-family: 'Arial', sans-serif;
    font-size: 50px;
    color: #8b4513;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }
    .card, .placeholder {
        width: 90%;
        height: auto;
        padding: 20px;
    }
    .card .title-arrow {
        justify-content: space-between;
        flex-direction: row;
        align-items: center;
    }
    .card .title {
        font-size: 18px;
        margin-left: 15px; 
    }
    .card .arrow {
        width: 25px;
        height: 25px;
        font-size: 16px;
        margin-left: 15px; 
    }
}

@media (max-width: 480px) {
    .card .title {
        font-size: 18px;
        margin-left: 15px; 
    }
    .card .arrow {
        width: 25px;
        height: 25px;
        font-size: 16px;
        margin-left: 15px;
    }
    .placeholder::before {
        font-size: 40px;
    }
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
        <h1 style="margin-left: 20px; margin-top:20px; color: #8b4513;">Note Books</h1>
        
        <div class="container">
        <a href="notebook_pages.php"  rel="noopener noreferrer">
                <div class="card">
                    <img src="../img/soccer boy.jpg" alt="Kids with soccer ball">
                    <div class="title-arrow">
                        <div class="title">Physics</div>
                        <div class="arrow">&#10132;</div>
                    </div>
                </div>
            </a>
        <div class="placeholder" onclick="addCard()"></div>
    </div>

    </section>
    <?php include('../includes/notes.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <?php include('../includes/script.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
        function addCard() {
            const container = document.querySelector('.container');
            const newCard = document.createElement('div');
            newCard.className = 'card';
            newCard.innerHTML = `
                <img src="../img/soccer boy.jpg" alt="Kids with soccer ball">
                <div class="title-arrow">
                    <div class="title" contenteditable="true">New Title</div>
                    <div class="arrow">&#10132;</div>
                </div>
            `;
            container.insertBefore(newCard, container.querySelector('.placeholder'));
        }
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