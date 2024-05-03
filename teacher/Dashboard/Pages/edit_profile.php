<?php
session_start();
include('../../../includes/config.php');
// Fetch the doubt details based on doubt_id from the URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare("SELECT * FROM teacher WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    // Fetch all rows from the result set as an array
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store all values in a variable
    $userData = array();

    foreach ($user as $userInfo) {
        $id = $userInfo['id'];
        $photo = $userInfo['photo'];
        $name = $userInfo['name'];
        $email = $userInfo['email'];
        $contact = $userInfo['contact'];
        $age = $userInfo['age'];
        $gender = $userInfo['gender'];
        $tech_stack = $userInfo['tech_stack'];
        $experience = $userInfo['experience'];
        $resume = $userInfo['resume'];
        $address = $userInfo['address'];
        $city = $userInfo['city'];
        $state = $userInfo['state'];
        $pin = $userInfo['pin'];
        $active = $userInfo['active'];

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
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>
        <!--$%adsense%$-->
        <main class="cd__main">
            <!-- Start DEMO HTML (Use the following code into your project)-->

            <div class="additional-details" id="additionalDetails">
                <form action="../backend/edit_profile.php" method="post" enctype="multipart/form-data">

                    <h2>Personal Details</h2>
                    <ul>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <li data-label="Name"><input type="text" name="name" value="<?php echo $name ?>" class="styled-input">
                        </li>
                        <li data-label="Email"><input type="email" name="email" value="<?php echo $email ?>" class="styled-input">
                        </li>
                        <li data-label="Contact"><input type="tel" name="contact" value="<?php echo $contact ?>" class="styled-input">
                        </li>
                        <li data-label="Age"><input type="text" name="age" value="<?php echo $age ?>" class="styled-input">
                        </li>
                        <li data-label="Gender"><input type="text" name="gender" value="<?php echo $gender ?>" class="styled-input">
                        </li>
                        <li data-label="Address"><input type="text" name="address" value="<?php echo $address ?>" class="styled-input">
                        </li>
                        <li data-label="City"><input type="text" name="city" value="<?php echo $city ?>" class="styled-input">
                        </li>
                        <li data-label="State"><input type="text" name="state" value="<?php echo $state ?>" class="styled-input">
                        </li>
                        <li data-label="Pin"><input type="text" name="pin" value="<?php echo $pin ?>" class="styled-input">
                        </li>
                    </ul>

                    <h2>Professional Details</h2>
                    <ul>
                        <li data-label="Tech Stack"><input type="text" name="tech_stack" value="<?php echo $tech_stack?>" class="styled-input"></li>
                        <li data-label="Experience"><input type="text" name="experience" value="<?php echo $experience ?>" class="styled-input"></li>
                        <li data-label="Resume"><input type="file" name="resume" value="<?php echo $resume ?>" class="styled-input">
                        <p><?php echo $resume ?></p>
                    </li>
                        
                    </ul>

                    <button type="submit" class="edit-details-button">Confirm Details</button></a>
                </form>
            </div>
            <!-- END EDMO HTML (Happy Coding!)-->
        </main>
        <?php include('../includes/footer.php'); ?>
    </section>
    <?php include('../includes/notes.php'); ?>

    <!-- Script JS -->
    <script src="./js/script.js"></script>
    <!--$%analytics%$-->
    <?php include('../includes/script.php'); ?>

</body>

</html>