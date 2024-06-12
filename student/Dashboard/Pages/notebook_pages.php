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
    width: 80%;
    margin: auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}
.chapter {
    background-color: #d2b48c;
    border: 2px solid #8b4513;
    border-radius: 10px;
    margin-bottom: 20px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    position: relative;
}
.chapter-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}
.chapter-header .title {
    font-size: 25px;
    font-weight: bold;
    flex-grow: 1;
    color: #8b4513;
    margin-right: 10px;
}
.chapter-header .buttons {
    display: flex;
    align-items: center;
}
.chapter-header .upload-btn, .chapter-header .toggle-btn {
    background-color: #8b4513;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    margin-left: 10px;
}
.chapter-content {
    display: none;
    margin-top: 10px;
    padding: 15px;
    background-color: #f0e7d8;
    border-radius: 5px;
    color: #8b4513;
}
.chapter-content p {
    font-size: 22px;
    margin-bottom: 10px;
    color: #8b4513;
}
.chapter-content img {
    width: 100px;
    height: auto;
    margin-right: 10px;
    margin-bottom: 10px;
    cursor: pointer;
}
.chapter-content .link {
    display: inline-block;
    padding: 5px 10px;
    background-color: #8b4513;
    color: white;
    border-radius: 5px;
    font-size: 18px;
}
.add-chapter {
    background-color: #d2b48c;
    border: 2px solid #8b4513;
    border-radius: 10px;
    width: 100%;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.add-chapter::before {
    content: '+';
    font-size: 30px;
    color: #8b4513;
}
.title[contenteditable]:focus {
    border-bottom: 2px solid #8b4513;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
}
.modal-content {
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 700px;
}
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover, .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 10px;
    }
    .chapter-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .chapter-header .title {
        font-size: 24px;
        margin-bottom: 10px;
    }
    .chapter-header .buttons {
        width: 100%;
        justify-content: space-between;
    }
    .chapter-header .upload-btn, .chapter-header .toggle-btn {
        width: 48%;
        margin-left: 0;
    }
    .chapter-content p {
        font-size: 20px;
    }
    .chapter-content img {
        width: 80px;
        margin-bottom: 10px;
    }
    .chapter-content .link {
        font-size: 16px;
        padding: 5px;
    }
}

@media (max-width: 480px) {
    .container {
        width: 100%;
        padding: 10px;
    }
    .chapter-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .chapter-header .title {
        font-size: 22px;
        margin-bottom: 10px;
    }
    .chapter-header .buttons {
        width: 100%;
        justify-content: space-between;
    }
    .chapter-header .upload-btn, .chapter-header .toggle-btn {
        width: 48%;
        margin-left: 0;
    }
    .chapter-content p {
        font-size: 18px;
    }
    .chapter-content img {
        width: 70px;
        margin-bottom: 10px;
    }
    .chapter-content .link {
        font-size: 14px;
        padding: 5px;
    }
}
.image-container{
    margin-top:50px;
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
        <h1 style="margin-left: 20px; margin-top:20px; color: #8b4513;">Physics</h1>
        <div class="container">
            <div class="chapter" data-chapter="1">
                <div class="chapter-header" onclick="toggleChapter(this)">
                    <div class="title" contenteditable="true">Chapter - 1</div>
                    <div class="buttons">
                        <button class="upload-btn" onclick="this.nextElementSibling.click()">Upload</button>
                        <button class="toggle-btn">+</button>
                        <input type="file" style="display: none;" onchange="uploadImage(this)">
                    </div>
                </div>
                <div class="chapter-content">
                    <p contenteditable="true">Hello my name is burhanuddin bohra<br>I am a developer</p>
                    <div class="image-container">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <div class="link" contenteditable="true">link</div>
                    </div>
                </div>
            </div>
            <div class="add-chapter" onclick="addChapter()"></div>
        </div>

        <!-- Modal for image zoom -->
        <div id="myModal" class="modal" onclick="closeModal()">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="imgZoom">
        </div>

        <script>
            function toggleChapter(header) {
                const content = header.nextElementSibling;
                const button = header.querySelector('.toggle-btn');
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    button.textContent = '-';
                } else {
                    content.style.display = 'none';
                    button.textContent = '+';
                }
            }

            function addChapter() {
                const container = document.querySelector('.container');
                const newChapterNumber = container.querySelectorAll('.chapter').length + 1;
                const newChapter = document.createElement('div');
                newChapter.className = 'chapter';
                newChapter.setAttribute('data-chapter', newChapterNumber);
                newChapter.innerHTML = `
                <div class="chapter-header" onclick="toggleChapter(this)">
                    <div class="title" contenteditable="true">Chapter - ${newChapterNumber}</div>
                    <div class="buttons">
                        <button class="upload-btn" onclick="this.nextElementSibling.click()">Upload</button>
                        <button class="toggle-btn">+</button>
                        <input type="file" style="display: none;" onchange="uploadImage(this)">
                    </div>
                </div>
                <div class="chapter-content">
                    <p contenteditable="true">New content here...</p>
                    <div class="image-container">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <img src="../img/soccer boy.jpg" alt="Kids with soccer ball" onclick="zoomImage(this)">
                        <div class="link" contenteditable="true">link</div>
                    </div>
                </div>
            `;
                container.insertBefore(newChapter, container.querySelector('.add-chapter'));
            }

            function uploadImage(input) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 100;
                    img.height = 'auto';
                    img.style.marginRight = '5px';
                    img.style.cursor = 'pointer';
                    img.onclick = function() {
                        zoomImage(img);
                    };
                    input.parentNode.nextElementSibling.querySelector('.image-container').appendChild(img);
                };
                reader.readAsDataURL(file);
            }

            function zoomImage(img) {
                const modal = document.getElementById("myModal");
                const modalImg = document.getElementById("imgZoom");
                modal.style.display = "block";
                modalImg.src = img.src;
            }

            function closeModal() {
                const modal = document.getElementById("myModal");
                modal.style.display = "none";
            }

            // Close modal when clicking outside of the image
            document.getElementById("myModal").addEventListener('click', function(event) {
                if (event.target !== document.getElementById("imgZoom")) {
                    closeModal();
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