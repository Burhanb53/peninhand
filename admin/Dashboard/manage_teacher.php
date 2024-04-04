<?php
session_start();
error_reporting(0);
include ('includes/config.php');

$sql = "SELECT * FROM teacher";
$result = $dbh->query($sql);
$teachers = $result->fetchAll(PDO::FETCH_ASSOC);
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
</head>

<body class="crm_body_bg">

    <?php include ('includes/sidebar_index.php'); ?>


    <section class="main_content dashboard_part">


        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">

                    <div class="col-12">
                        <div class="QA_section">
                            <div class="white_box_tittle list_header">
                                <h4>Manage Teachers</h4>
                                <div class="box_right d-flex lms_block">
                                    <div class="serach_field_2">
                                        <div class="search_inner">
                                            <form id="searchForm">
                                                <div class="search_field">
                                                    <input id="searchInput" type="text" placeholder="Search Name ...">
                                                </div>
                                                <button type="submit"> <i class="ti-search"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="add_button ms-2">
                                        <button id="searchButton" class="btn_1">Search</button>
                                    </div>
                                </div>
                            </div>

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
                                            <th scope="col">Status</th> <!-- New column for icons -->
                                            <th scope="col">Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($teachers as $teacher): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $teacher['id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['teacher_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['gender']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['contact']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['city']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['state']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['tech_stack']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['experience']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $teacher['active'] == 1 ? 'Active' : 'Not Active'; ?>
                                                </td>
                                                <td>
                                                    <?php echo $teacher['verified'] == 1 ? 'Verified' : 'Not Verified'; ?>
                                                    <!-- Show status -->
                                                </td>
                                                <td>
                                                    <?php if ($teacher['verified'] == 0): ?>
                                                        <form method="POST" action="verify_teacher.php">
                                                            <input type="hidden" name="teacher_id"
                                                                value="<?php echo $teacher['id']; ?>">
                                                            <button type="submit" class="btn btn-primary">Verify</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <!-- Update icon with a link to update_teacher.php -->
                                                        <a href="update_teacher.php?id=<?php echo $teacher['id']; ?>"
                                                            title="Update">
                                                            <?php if ($teacher['active'] == 1): ?>
                                                                <i style="padding-right: 5px;" class="fas fa-times"></i>
                                                            <?php else: ?>
                                                                <i style="padding-right: 5px;" class="fas fa-check"></i>
                                                            <?php endif; ?>
                                                        </a>
                                                        <!-- Placeholder for another action icon -->
                                                        <a href="view_teacher.php?id=<?php echo $teacher['id']; ?>"
                                                            title="View Details">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>



                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="footer_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer_iner text-center">
                            <p>2020 © Influence - Designed by <a href="#"> <i class="ti-heart"></i> </a><a href="#">
                                    Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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