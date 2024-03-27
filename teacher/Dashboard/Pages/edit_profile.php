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
        .additional-details {
            margin-left: auto;
            margin-right: 10px;
            max-width: 800px;
            align-content: center;
            justify-content: center;
            margin: auto;
        }

        .additional-details li {
            border: 2px solid #ddd;
            padding: 15px;
            margin: 30px;
            border-radius: 5rem;
            background: #fff;
            color: #333;
            transition: background 0.3s ease;
            width: calc(100% - 32px);
            font-size: 20px;
            position: relative;
        }

        .additional-details li::before {
            content: attr(data-label);
            position: absolute;
            top: -20px;
            left: 20%;
            transform: translateX(-50%);
            background: #fff;
            padding: 5px 10px;
            font-size: 16px;
            color: #555;
            border: 2px solid #ddd;
            border-radius: 5rem;
        }

        .additional-details li:hover {
            background: #f0f0f0;
        }

        .details {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            align-items: flex-start;
            justify-content: center;
            margin: auto;
            padding: 20px;
            transition: box-shadow 0.3s ease;
            margin: 10px auto;
        }

        .details:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .edit-details-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
            align-self: flex-end;
            margin-left: 20px;
        }

        .edit-details-button:hover {
            background: #2980b9;
        }

        h2 {
            margin-left: 20px;
        }

        @media (max-width: 990px) {
            .details {
                max-width: 420px;
            }

            .additional-details li::before {
                left: 20%;
                font-size: 15px;
            }
        }
    </style>

</head>

<body>
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>
        <!--$%adsense%$-->
        <main class="cd__main">
            <!-- Start DEMO HTML (Use the following code into your project)-->

            <div class="additional-details" id="additionalDetails">
                <h2>Personal Details</h2>
                <ul>
                    <li data-label="Name">Samantha Jones</li>
                    <li data-label="Email">samantha@example.com</li>
                    <li data-label="Contact">+1234567890</li>
                    <li data-label="Address">New York, United States, 12345</li>
                </ul>

                <h2>Parent Details</h2>
                <ul>
                    <li data-label="Mother Name">Mary Jones</li>
                    <li data-label="Mother Email">mary@example.com</li>
                    <li data-label="Mother Contact">+1234567890</li>
                    <li data-label="Father Name">John Jones</li>
                    <li data-label="Father Email">john@example.com</li>
                    <li data-label="Father Contact">+1234567890</li>
                </ul>

                <button class="edit-details-button">Confirm Details</button>
            </div>
            <!-- END EDMO HTML (Happy Coding!)-->
        </main>
        <?php include('../includes/footer.php'); ?>
    </section>

    <!-- Script JS -->
    <script src="./js/script.js"></script>
    <!--$%analytics%$-->
    <?php include('../includes/script.php'); ?>

</body>

</html>