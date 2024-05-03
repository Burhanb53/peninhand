<?php
session_start();
include ('../../../includes/config.php');
// Fetch the doubt details based on doubt_id from the URL parameter
if (isset ($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare("SELECT * FROM subscription_user WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    // Fetch all rows from the result set as an array
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store all values in a variable
    $userData = array();

    foreach ($user as $userInfo) {
        $id = $userInfo['id'];
        $user_id = $userInfo['user_id'];
        $name = $userInfo['name'];
        $email = $userInfo['email'];
        $contact = $userInfo['contact'];
        $photo = $userInfo['photo'];
        $mother_name = $userInfo['mother_name'];
        $mother_email = $userInfo['mother_email'];
        $mother_contact = $userInfo['mother_contact'];
        $father_name = $userInfo['father_name'];
        $father_email = $userInfo['father_email'];
        $father_contact = $userInfo['father_contact'];
        $address = $userInfo['address'];
        $city = $userInfo['city'];
        $state = $userInfo['state'];
        $pin = $userInfo['pin'];
        $subscription_id = $userInfo['subscription_id'];
        $transaction_id = $userInfo['transaction_id'];
        $created_at = $userInfo['created_at'];
        $end_date = $userInfo['end_date'];

        // Now you can use these variables as needed
    }

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
    <link rel="stylesheet" href="css/edit_profile.css">

</head>

<body>
    <?php include ('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include ('../includes/navbar.php'); ?>
        <!--$%adsense%$-->
        <main class="cd__main">
            <!-- Start DEMO HTML (Use the following code into your project)-->

            <div class="additional-details" id="additionalDetails">
                <form action="../backend/edit_profile.php" method="post" enctype="multipart/form-data">

                    <h2>Personal Details</h2>
                    <ul>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <li data-label="Name"><input type="text" name="name" value="<?php echo $name ?>"
                                class="styled-input">
                        </li>
                        <li data-label="Email"><input type="email" name="email" value="<?php echo $email ?>"
                                class="styled-input"></li>
                        <li data-label="Contact"><input type="tel" name="contact" value="<?php echo $contact ?>"
                                class="styled-input">
                        </li>
                        <li data-label="Address"><input type="text" name="address" value="<?php echo $address ?>"
                                class="styled-input">
                        </li>
                        <li data-label="City"><input type="text" name="city" value="<?php echo $city ?>"
                                class="styled-input">
                        </li>
                        <li data-label="State"><input type="text" name="state" value="<?php echo $state ?>"
                                class="styled-input">
                        </li>
                        <li data-label="Pin"><input type="text" name="pin" value="<?php echo $pin ?>"
                                class="styled-input">
                        </li>
                    </ul>

                    <h2>Parent Details</h2>
                    <ul>
                        <li data-label="Mother Name"><input type="text" name="mother_name"
                                value="<?php echo $mother_name ?>" class="styled-input"></li>
                        <li data-label="Mother Email"><input type="email" name="mother_email"
                                value="<?php echo $mother_email ?>" class="styled-input"></li>
                        <li data-label="Mother Contact"><input type="tel" name="mother_contact"
                                value="<?php echo $mother_contact ?>" class="styled-input"></li>
                        <li data-label="Father Name"><input type="text" name="father_name"
                                value="<?php echo $father_name ?>" class="styled-input"></li>
                        <li data-label="Father Email"><input type="email" name="father_email"
                                value="<?php echo $father_email ?>" class="styled-input"></li>
                        <li data-label="Father Contact"><input type="tel" name="father_contact"
                                value="<?php echo $father_contact ?>" class="styled-input"></li>
                    </ul>

                    <button type="submit" class="edit-details-button">Confirm Details</button></a>
                </form>
            </div>
            <!-- END EDMO HTML (Happy Coding!)-->
        </main>
        <?php include ('../includes/footer.php'); ?>
    </section>
    <?php include('../includes/notes.php'); ?>

    <!-- Script JS -->
    <script src="./js/script.js"></script>
    <!--$%analytics%$-->
    <?php include('../includes/script.php'); ?>

</body>

</html>