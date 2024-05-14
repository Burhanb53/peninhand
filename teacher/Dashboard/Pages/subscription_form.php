<?php
session_start();
error_reporting(0);
include ('../../../includes/config.php');
if (!isset ($_SESSION['role'])) {
    // User doesn't have the required role, redirect to index.php
    $_SESSION['registration_message'] = "Please Sign In before accessing this page.";
    header("Location: ../../../Pages/sign-in.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CodeHim">
    <title>Profile Page</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Demo CSS (No need to include it into your project) -->
    <link rel="stylesheet" href="./css/demo.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="css/subscription_form.css">

</head>

<body>

    <!--$%adsense%$-->
    <div class="main-container">
        <div class="section section-left">
            <h2>Personal Details</h2>
            <form action="../backend/subscription_form.php" method="post" enctype="multipart/form-data">


                <div class="form-group">
                    <input type="hidden" name="subscription_id" value="<?php echo $_GET['subscription_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <label for="photo">Upload Profile:
                        <i class="fas fa-camera"></i> <!-- Your icon, replace with the appropriate icon class -->
                    </label>
                    <input type="file" id="fileInput" name="photo" accept=".jpg, .jpeg, .png" style="display: none;"
                        required>
                    <label for="fileInput" class="file-label">
                        <div id="filePreview" class="upload-photo">
                            <img src="../img/card.jpg" alt="Uploaded Photo" id="previewImage" style="display: none;">
                        </div>
                    </label>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <!-- Populate email field with session email -->
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="contact">Contact:</label>
                    <input type="tel" id="contact" name="contact" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="text" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

        </div>

        <div class="section section-right">
            <h2>Experience Details</h2>
            <div class="form-group">
                <label for="tech_stack">Tech Stack:<p style="color: #A05350;"> [ Seprate multiple option with comma(,) ]
                    </p></label>
                <input type="text" id="tech_stack" name="tech_stack" required>
            </div>
            <div class="form-group">
                <label for="experience">Experience:</label>
                <textarea id="experience" name="experience" required style="width: 100%;"></textarea>
            </div>
            <div class="form-group">
                <label for="resume">Resume: <p style="color: #A05350;"> [ only .pdf ]
                    </p></label>
                <input type="file" id="resume" name="resume" accept=".pdf" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label for="pin">Pin:</label>
                <input type="text" id="pin" name="pin" required>
            </div>

            <!-- Submit button for payment details form -->
            <div class="submit-container">
                <button type="submit" class="submit-button">Submit Details</button>
            </div>
            </form>
        </div>
    </div>

    <!-- Script JS -->
    <script src="./js/script.js"></script>
    <!--$%analytics%$-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('fileInput');
            const filePreview = document.getElementById('filePreview');

            // Trigger change event on file input to show the dummy image
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        });

        document.getElementById('fileInput').addEventListener('change', function (event) {
            const fileInput = event.target;
            const filePreview = document.getElementById('filePreview');

            // Clear previous previews
            while (filePreview.firstChild) {
                filePreview.removeChild(filePreview.firstChild);
            }

            // Check if any file is selected
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];

                // Check if the file is an image
                if (file.type.startsWith('image/')) {
                    // Display image preview
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.alt = 'Uploaded Image';
                    img.classList.add('preview-image'); // Add class for styling
                    filePreview.appendChild(img);
                }
            } else {
                // Display the dummy image if no file is selected
                const dummyImage = document.createElement('img');
                dummyImage.src = '../img/card.jpg';
                dummyImage.alt = 'Dummy Image';
                dummyImage.classList.add('preview-image'); // Add class for styling
                filePreview.appendChild(dummyImage);
            }
        });
    </script>




</body>

</html>