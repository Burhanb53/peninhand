<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Check if doubt_id is set in the URL
if (isset($_GET['doubt_id'])) {
    $doubt_id = $_GET['doubt_id'];

    // Fetch the specific doubt details from your database based on doubt_id
    // This is assuming you have a 'doubt' table in your database
    $sql = "SELECT * FROM doubt WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);
    $stmt->execute();
    $doubt = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the doubt is found and proceed with the assignment form
    if ($doubt) {
        // Fetch the list of teachers from your database
        $sql = "SELECT * FROM teacher";
        $result = $dbh->query($sql);
        $teachers = $result->fetchAll(PDO::FETCH_ASSOC);

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_button'])) {
            $teacher_id = $_POST['teacher_id'];

            // Process the assignment here (e.g., update the database)
            // Redirect to assign.php after processing
            header('Location: assign.php');
            exit;
        }
    }
} else {
    // Redirect or handle the case where doubt_id is not provided in the URL
    header('Location: error_page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Directory</title>
    <link rel="icon" href="img/logo.png" type="image/png">

    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css">
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css">
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css">
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css">
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css">
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css">
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css">
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS"> 
    <style>
        
        .lms_table_active button {
            padding: 8px 16px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .lms_table_active button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body class="crm_body_bg">
    <?php include ('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">

                </div>
                <h1>Assign Teacher</h1>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="QA_table mb_30 table-container">
                            <table class="table lms_table_active" style="table-layout: fixed; width: 100%;">
                                <col style="width: 10px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <col style="width: 20px;">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Teacher ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">City</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Tech Stack</th>
                                        <th scope="col">Experience</th>
                                        <th scope="col">Active</th>
                                        <!-- <th scope="col">Assign</th> -->
                                    </tr>
                                </thead>
                                <tbody>
        <?php foreach ($teachers as $teacher): ?>
            <?php if ($teacher['active'] == 1): ?>
                <tr>
                    <td><?php echo $teacher['id']; ?></td>
                    <td><?php echo $teacher['teacher_id']; ?></td>
                    <td><?php echo $teacher['name']; ?></td>
                    <td><?php echo $teacher['gender']; ?></td>
                    <td><?php echo $teacher['contact']; ?></td>
                    <td><?php echo $teacher['city']; ?></td>
                    <td><?php echo $teacher['state']; ?></td>
                    <td><?php echo $teacher['tech_stack']; ?></td>
                    <td><?php echo $teacher['experience']; ?></td>
                    <td class="stunning-text"><?php echo $teacher['active'] == 1 ? 'Active' : 'Not Active'; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="doubt_id" value="<?php echo $doubt_id; ?>">
                            <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">
                            <!-- <input type="text" name="teacher_name"> -->
                            <button type="submit">Assign</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.lms_table_active tbody tr');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const searchTerm = input.value.toLowerCase();

            tableRows.forEach(row => {
                let found = false;
                row.querySelectorAll('td').forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.getElementById('searchButton').addEventListener('click', function () {
            form.dispatchEvent(new Event('submit'));
        });
    });

</script>


<script src="js/jquery1-3.4.1.min.js"></script>

<script src="js/popper1.min.js"></script>

<script src="js/bootstrap1.min.js"></script>

<script src="js/metisMenu.js"></script>

<script src="vendors/count_up/jquery.waypoints.min.js"></script>

<script src="vendors/chartlist/Chart.min.js"></script>

<script src="vendors/count_up/jquery.counterup.min.js"></script>

<script src="vendors/swiper_slider/js/swiper.min.js"></script>

<script src="vendors/niceselect/js/jquery.nice-select.min.js"></script>

<script src="vendors/owl_carousel/js/owl.carousel.min.js"></script>

<script src="vendors/gijgo/gijgo.min.js"></script>

<script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatable/js/buttons.flash.min.js"></script>
<script src="vendors/datatable/js/jszip.min.js"></script>
<script src="vendors/datatable/js/pdfmake.min.js"></script>
<script src="vendors/datatable/js/vfs_fonts.js"></script>
<script src="vendors/datatable/js/buttons.html5.min.js"></script>
<script src="vendors/datatable/js/buttons.print.min.js"></script>
<script src="js/chart.min.js"></script>

<script src="vendors/progressbar/jquery.barfiller.js"></script>

<script src="vendors/tagsinput/tagsinput.js"></script>

<script src="vendors/text_editor/summernote-bs4.js"></script>
<script src="vendors/apex_chart/apexcharts.js"></script>
<script src="js/custom.js"></script>


</html>

<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assigned_teacher_id = $_POST['teacher_id'];

    // Update the 'teacher_id' for the corresponding doubt in the 'doubt' table
    $updateSql = "UPDATE doubt SET teacher_id = :assigned_teacher_id WHERE doubt_id = :doubt_id";
    $updateStmt = $dbh->prepare($updateSql);
    $updateStmt->bindParam(':assigned_teacher_id', $assigned_teacher_id);
    $updateStmt->bindParam(':doubt_id', $doubt_id);
    $updateStmt->execute();

    // Redirect back to assign.php or wherever you want after updating the assignment
    header('Location: assign.php');
    exit;
}
?>