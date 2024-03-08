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
<style>
    .form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

.form-container h2 {
    margin-bottom: 20px;
    color: #333;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9; /* Custom background color */
    color: #333; /* Custom text color */
    font-size: 20px;
}

button {
    background-color: #4285f4;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #357ae8;
}
</style>
</head>

<body class="crm_body_bg">
    <?php include('../includes/sidebar.php'); ?>
    <section class="main_content dashboard_part">
        <?php include('../includes/navbar.php'); ?>

        <div class="form-container" style="margin:auto; margin-top: 50px;">
            <h2>Video Call</h2>
            <form id="videoCallForm">
                <label for="videoLink">Video Call Link:</label>
                <input type="text" id="videoLink" name="videoLink" placeholder="Enter video call link" required>

                <label for="joinCode">Join Code:</label>
                <input type="text" id="joinCode" name="joinCode" placeholder="Enter join code" required>

                <button type="button" onclick="joinVideoCall()">Join Video Call</button>
            </form>
        </div>

        <script>
            function joinVideoCall() {
                var videoLink = document.getElementById('videoLink').value;
                var joinCode = document.getElementById('joinCode').value;

                // Add your logic here to handle the video call link and join code
                // You can redirect or initiate the video call based on the provided information
                alert('Joining video call:\nVideo Link: ' + videoLink + '\nJoin Code: ' + joinCode);
            }
        </script>

        <?php include('../includes/footer.php'); ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>