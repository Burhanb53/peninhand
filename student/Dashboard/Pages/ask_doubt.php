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
</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>
        <div class="notification" id="notificationCard"></div>
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h3 style="color:white;">Ask Doubt</h3>
                </div>
                <div class="card-body">
                    <?php if ($_SESSION['message'] != null ) : ?>
                        <div class="message-container">
                            <div class="card-content <?php echo ($message === "Doubt submitted successfully.") ? "success" : "error"; ?>">
                                <p style="color: white; font-size: 20px;"><i class="fa fa-exclamation-circle" aria-hidden="true" style="padding-right: 5px;"></i><?php echo $message; ?></p>
                            </div>
                        </div>
                        
                        <?php unset($_SESSION['message']); ?> 
                    <?php endif; ?>


                    <form action="../backend/submit_doubt.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="doubt_Category">Question Category:</label>
                            <input type="text" name="doubt_category" class="question-category" required>
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
                            <?php if ($subscription_valid) : ?>
                                <button type="submit" class="submit-btn">Ask Doubt</button>
                            <?php else : ?>
                                <button type="button" class="submit-btn" disabled style="background-color: red; color: white;" title="Your Subscription is expired">Subscription Expired</button>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>



        <?php include('../includes/footer.php'); ?>
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


</body>

</html>