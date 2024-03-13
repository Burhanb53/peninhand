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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2%;
            padding: 2%;
            background-color: #FFFFFF;
        }

        .main-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            min-width: 80%;
            border-radius: 10px;
            background-color: #F5F7F9;
        }

        .section {
            flex: 0 0 48%;
        }

        .upload-photo {
            text-align: center;
            position: relative;
        }

        .upload-photo input[type="file"] {
            display: none;
        }

        .camera-icon {
            position: absolute;
            top: 5px;
            right: -20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        .camera-icon i {
            color: #fff;
        }

        .upload-photo label {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
        }

        .upload-photo img {
            max-width: 150px;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
            cursor: pointer;
        }

        form {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .qr-code {
            text-align: center;
        }

        .qr-code img {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
        }

        .upi-transaction input {
            width: calc(100% - 20px);
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .section {
                flex: 1 1 100%;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .main-container {
                display: flex;
                justify-content: space-between;
                padding: 20px;
                width: 100%;
                

            }
        }

        .submit-container {
            float: left;
            margin-top: 20px;
            /* Adjust as needed */
        }

        .submit-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-button:hover {
            background: #2980b9;
        }
    </style>

</head>

<body>

    <!--$%adsense%$-->
    <div class="main-container">
        <div class="section section-left">
            <h2>Personal Details</h2>
            <div class="upload-photo">
                <input type="file" id="profile-photo" accept="image/*">
                <img src="../img/card.jpg" alt="Profile Photo" id="profile-photo-preview" >
                <label for="profile-photo"><i class="fas fa-camera"></i></label>
            </div>

            <form id="personal-details-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="contact">Contact:</label>
                    <input type="tel" id="contact" name="contact">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city">
                </div>
                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state">
                </div>
                <div class="form-group">
                    <label for="pin">Pin:</label>
                    <input type="text" id="pin" name="pin">
                </div>
            </form>
        </div>
        <div class="section section-right">
            <h2>Parent Details</h2>
            <form id="parent-details-form">
                <div class="form-group">
                    <label for="mother-name">Mother Name:</label>
                    <input type="text" id="mother-name" name="mother_name">
                </div>
                <div class="form-group">
                    <label for="mother-email">Mother Email:</label>
                    <input type="email" id="mother-email" name="mother_email">
                </div>
                <div class="form-group">
                    <label for="mother-contact">Mother Contact:</label>
                    <input type="tel" id="mother-contact" name="mother_contact">
                </div>
                <div class="form-group">
                    <label for="father-name">Father Name:</label>
                    <input type="text" id="father-name" name="father_name">
                </div>
                <div class="form-group">
                    <label for="father-email">Father Email:</label>
                    <input type="email" id="father-email" name="father_email">
                </div>
                <div class="form-group">
                    <label for="father-contact">Father Contact:</label>
                    <input type="tel" id="father-contact" name="father_contact">
                </div>
            </form>
            <div class="qr-code">
                <!-- QR Code image will be displayed dynamically -->
                <img src="../img/QR.jpg" alt="QR Code" id="qr-code">
            </div>
            <div class="upi-transaction">
                <!-- UPI Transaction ID field -->
                <input type="text" id="upi-transaction-id" placeholder="Enter UPI Transaction ID">
            </div>
            <div class="submit-container">
                <button type="submit" class="submit-button">Submit Details</button>
            </div>

        </div>

    </div>

    <!-- Script JS -->
    <script src="./js/script.js"></script>
    <!--$%analytics%$-->
    <script>
        // JavaScript for handling profile photo upload
        const profilePhotoInput = document.getElementById('profile-photo');
        const profilePhotoPreview = document.getElementById('profile-photo-preview');

        profilePhotoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                profilePhotoPreview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        });

    </script>
</body>

</html>