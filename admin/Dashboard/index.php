<?php
// Define DB credentials and establish database connection
function connectDB()
{
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'peninhand');

    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}

function getCountByRole($pdo, $role)
{
    $sql = "SELECT COUNT(*) as count FROM user WHERE role = :role";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':role', $role, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getCountResolvedDoubts($pdo)
{
    $sql = "SELECT COUNT(*) as count FROM doubt WHERE feedback = 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getDoubtCount($pdo)
{
    $sql = "SELECT COUNT(*) as count FROM doubt";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getRecentDoubts($pdo)
{
    $sql = "SELECT id, doubt_id, user_id, teacher_id, doubt_category, doubt, doubt_file, 
                  doubt_created_at, answer, answer_file, answer_created_at, 
                  student_view, teacher_view, admin_view, accepted, doubt_submit, feedback
            FROM doubt 
            ORDER BY IFNULL(answer_created_at, doubt_created_at) DESC 
            LIMIT 5";
    $stmt = $pdo->query($sql);
    $doubts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $doubts;
}

function fetchDataForDoubts($dbh)
{
    $query = "SELECT DATE_FORMAT(doubt_created_at, '%Y-%m') AS doubt_month, COUNT(*) AS doubt_count
              FROM doubt
              GROUP BY DATE_FORMAT(doubt_created_at, '%Y-%m')
              ORDER BY doubt_month";

    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['doubt_month']] = $row['doubt_count'];
    }

    return $data;
}

function fetchDataForAnswers($dbh)
{
    $query = "SELECT DATE_FORMAT(answer_created_at, '%Y-%m') AS answer_month, COUNT(*) AS answer_count
              FROM doubt
              WHERE answer_created_at IS NOT NULL
              GROUP BY DATE_FORMAT(answer_created_at, '%Y-%m')
              ORDER BY answer_month";

    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['answer_month']] = $row['answer_count'];
    }

    return $data;
}

function generateChartData($data_doubts, $data_answers)
{
    $combined_data = array();
    foreach ($data_doubts as $month => $doubt_count) {
        $combined_data[$month]['doubt_count'] = $doubt_count;
        $combined_data[$month]['answer_count'] = isset($data_answers[$month]) ? $data_answers[$month] : 0;
    }

    return json_encode($combined_data);
}

// Main code
$dbh = connectDB();
$doubt_count = getCountResolvedDoubts($dbh);
$total_doubt_count = getDoubtCount($dbh);
$teacher_count = getCountByRole($dbh, 2); // Assuming role 2 is for teachers
$student_count = getCountByRole($dbh, 1); // Assuming role 1 is for students
$recent_doubts = getRecentDoubts($dbh);

$data_doubts = fetchDataForDoubts($dbh);
$data_answers = fetchDataForAnswers($dbh);
$json_data = generateChartData($data_doubts, $data_answers);

// Close database connection
$dbh = null;
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

    <link rel="stylesheet" href="vendors/datepicker/date-picker.css">

    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css">

    <link rel="stylesheet" href="vendors/morris/morris.css">

    <link rel="stylesheet" href="vendors/material_icon/material-icons.css">

    <link rel="stylesheet" href="css/metisMenu.css">

    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    .round-card {
        width: 12rem;
        height: 12rem;
        border-radius: 50%;
        text-align: center;
        padding: 2rem;
        overflow: hidden;
    }

    .count-wrapper {
        position: relative;
    }

    .count {
        font-size: 3rem;
        font-weight: bold;
        color: #fff;
    }

    .count-description {
        font-size: 1rem;
        color: #fff;
        margin-top: 1rem;
    }

    @media (max-width: 320px) {
        .round-card {
            width: 8rem;
            height: 8rem;
            padding: 1.5rem;
        }

        .count {
            font-size: 2rem;
        }

        .count-description {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    }

    /* Animation */
    @keyframes count-up {
        from {
            transform: translateY(1rem);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .count {
        animation: count-up 1s ease-out;
    }
</style>
<style>
    .ask-doubt-btn-container {
        text-align: right;
    }

    .ask-doubt-btn {
        background-color: #3498db;
        /* Choose your button color */
        color: #fff;
        /* Choose your text color */
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }
</style>

<style>
    #doubtAnswerChartContainer {
        max-width: 800px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
        padding: 20px;
    }

    #doubtAnswerChartTitle {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    #doubtAnswerChart canvas {
        max-height: 400px;
    }

    /* Hover effect for chart bars */
    #doubtAnswerChart .chart-bar {
        transition: transform 0.3s ease-in-out;
    }

    #doubtAnswerChart .chart-bar:hover {
        transform: scale(1.05);
    }
</style>

<body class="crm_body_bg">


    <?php include ('includes/sidebar_index.php'); ?>

    <section class="main_content dashboard_part">

        <?php include ('includes/navbar_index.php'); ?>

        <div class="main_content_iner">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3>Admin Dashboard</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="#">Dashboard</a> <i class="fas fa-caret-right"></i> Performance
                                            Book</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container text-center">
                        <!-- Card 1: No. of Teachers -->
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-12 d-inline-block align-top">
                            <div class="round-card box_shadow position-relative mb_30 blue_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $teacher_count ?>">
                                        <?php echo $teacher_count ?>
                                    </div>
                                    <p class="count-description">Teachers</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: No. of Students -->
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-12 d-inline-block align-top" style="margin-left: 5%;">
                            <div class="round-card box_shadow position-relative mb_30 orange_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $student_count ?>">
                                        <?php echo $student_count ?>
                                    </div>
                                    <p class="count-description">Students</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: No. of Resolved Doubts -->
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-12 d-inline-block align-top" style="margin-left: 5%;">
                            <div class="round-card box_shadow position-relative mb_30 green_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $doubt_count ?>">
                                        <?php echo $total_doubt_count ?>
                                    </div>
                                    <p class="count-description">Doubts Asked</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-12 d-inline-block align-top" style="margin-left: 5%;">
                            <div class="round-card box_shadow position-relative mb_30 green_bg">
                                <div class="count-wrapper">
                                    <div class="count" data-count="<?php echo $doubt_count ?>">
                                        <?php echo $doubt_count ?>
                                    </div>
                                    <p class="count-description">Resolved Doubts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main_content_iner ">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3> Directory Dashboard</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href>Dashboard</a> <i class="fas fa-caret-right"></i> Address Book</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-8">
                        <div class="white_box mb_30">
                            <div class="box_header">
                                <div class="main-title">
                                    <h3 class="mb_25">Monthly Doubts stats</h3>
                                </div>
                            </div>
                            <div id="doubtAnswerChartContainer">
                                <div id="doubtAnswerChartTitle"></div>
                                <canvas id="doubtAnswerChart"></canvas>
                            </div>
                            <!-- <div id="line-column-chart2"></div> -->
                            <div class="card_footer_white">
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <div class="d-inline-flex">
                                            <h5 class="me-2">$12,253</h5>
                                            <div class="text-success">
                                                <i class="fas fa-caret-up font-size-14 line-height-2 me-2"> </i>2.2
                                                %
                                            </div>
                                        </div>
                                        <p class="text-muted text-truncate mb-0">This month</p>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <div class="mt-4 mt-sm-0">
                                            <p class="mb-2 text-muted text-truncate"><i
                                                    class="fas fa-circle text-primary me-2 font-size-10 me-1"></i>
                                                This
                                                Year :</p>
                                            <div class="d-inline-flex align-items-center">
                                                <h5 class="mb-0 me-2">$ 34,254</h5>
                                                <div class="text-success">
                                                    <i class="fas fa-caret-up font-size-14 line-height-2 me-2">
                                                    </i>2.1
                                                    %
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <div class="mt-4 mt-sm-0">
                                            <p class="mb-2 text-muted text-truncate"><i
                                                    class="fas fa-circle text-success font-size-10 me-1"></i>
                                                Previous
                                                Year :</p>
                                            <div class="d-inline-flex align-items-center">
                                                <h5 class="mb-0">$ 32,695</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="list_counter_wrapper white_box mb_30 p-0 card_height_100">
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2 ">50</span> + </h3>
                                <p>Total categories</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2">100</span> + </h3>
                                <p>Total Listing</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2">20</span> + </h3>
                                <p>Claimed Listing</p>
                            </div>
                            <div class="single_list_counter">
                                <h3 class="deep_blue_2"><span class="counter deep_blue_2">10</span> + </h3>
                                <p>Reported Listing </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Users according to packages</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Package name</th>
                                            <th scope="col">No. of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Free package</td>
                                            <td>2556</td>
                                        </tr>
                                        <tr>
                                            <td>Free package</td>
                                            <td>2556</td>
                                        </tr>
                                        <tr>
                                            <td>Free package</td>
                                            <td>2556</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="white_box mb_30 card_height_100">
                            <div class="box_header ">
                                <div class="main-title">
                                    <h3 class="mb_25">Overview</h3>
                                </div>
                            </div>
                            <div class="activity_progressbar">
                                <div class="single_progressbar d-flex">
                                    <h6>Active Listings</h6>
                                    <div id="bar1" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="95"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Claimed Listings</h6>
                                    <div id="bar2" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="75"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Reported Listings</h6>
                                    <div id="bar3" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="55"></span>
                                    </div>
                                </div>
                                <div class="single_progressbar d-flex">
                                    <h6>Pending Listings</h6>
                                    <div id="bar4" class="barfiller">
                                        <div class="tipWrap">
                                            <span class="tip"></span>
                                        </div>
                                        <span class="fill" data-percentage="25"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Web Visitor and trafic</h3>
                                </div>
                            </div>
                            <div id="home-chart-03" style="height: 280px; position: relative;"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100 blud_card">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0 text_white">2400 + New Users</h3>
                                </div>
                            </div>
                            <div class="content_user">
                                <p>At vero eos et accusamus et iusto odio
                                    dignissimos ducimus</p>
                                <a href="#" class="btn_2">Learn more</a>
                                <img src="img/users_img.png" alt>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Listings according to Category</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Package name</th>
                                            <th scope="col">No. of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Restaurant</td>
                                            <td>2556</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td>25506</td>
                                        </tr>
                                        <tr>
                                            <td>Apartment</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Salon</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Automobile</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Spa</td>
                                            <td>25536</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Claimed Listings</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Package name</th>
                                            <th scope="col">No. of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Restaurant</td>
                                            <td>2556</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td>25506</td>
                                        </tr>
                                        <tr>
                                            <td>Apartment</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Salon</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Automobile</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Spa</td>
                                            <td>25536</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Reported Listings</h3>
                                </div>
                            </div>
                            <div class="QA_table ">

                                <table class="table lms_table_active2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Package name</th>
                                            <th scope="col">No. of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Restaurant</td>
                                            <td>2556</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td>25506</td>
                                        </tr>
                                        <tr>
                                            <td>Apartment</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Salon</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Automobile</td>
                                            <td>25536</td>
                                        </tr>
                                        <tr>
                                            <td>Spa</td>
                                            <td>25536</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="white_box card_height_100">
                            <div class="box_header">
                                <div class="main-title">
                                    <h3 class="m-0">Recent Activity</h3>
                                </div>
                            </div>
                            <div class="Activity_timeline">
                                <ul>
                                    <li>
                                        <div class="activity_bell"></div>
                                        <div class="timeLine_inner d-flex align-items-center">
                                            <div class="activity_wrap">
                                                <h6>5 min ago</h6>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                                                    scelerisque
                                                </p>
                                            </div>
                                            <div class="notification_read_btn mb_10">
                                                <a href="#" class="notification_btn">Read</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity_bell"></div>
                                        <div class="timeLine_inner d-flex align-items-center">
                                            <div class="activity_wrap">
                                                <h6>5 min ago</h6>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                                                    scelerisque
                                                </p>
                                            </div>
                                            <div class="notification_read_btn mb_10">
                                                <a href="#" class="notification_btn">Read</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity_bell"></div>
                                        <div class="timeLine_inner d-flex align-items-center">
                                            <div class="activity_wrap">
                                                <h6>5 min ago</h6>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                                                    scelerisque
                                                </p>
                                            </div>
                                            <div class="notification_read_btn mb_10">
                                                <a href="#" class="notification_btn">Read</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity_bell"></div>
                                        <div class="timeLine_inner d-flex align-items-center">
                                            <div class="activity_wrap">
                                                <h6>5 min ago</h6>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                                                    scelerisque
                                                </p>
                                            </div>
                                            <div class="notification_read_btn mb_10">
                                                <a href="#" class="notification_btn">Read</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="white_box QA_section card_height_100">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Device</h3>
                                </div>
                            </div>
                            <div id="bar-chart-6" class></div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="white_box">
                            <div class="box_header">
                                <div class="main-title">
                                    <h3 class="m-0">Browser</h3>
                                </div>
                            </div>
                            <div class="casnvas_box">
                                <canvas height="210" width="210" id="canvasDoughnut"></canvas>
                            </div>
                            <div class="legend_style legend_style_grid mt_10px">
                                <li class="d-block"> <span style="background-color: #525CE5;"></span>Chrome</li>
                                <li class="d-block"> <span style="background-color: #9C52FD;"></span> Mojila</li>
                                <li class="d-block"> <span style="background-color: #3B76EF"></span> Safari</li>
                                <li class="d-block"> <span style="background-color:#00BFBF;"></span> Opera</li>
                                <li class="d-block"> <span style="background-color:#FFA70B;"></span> Microsoft Edg
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include ('includes/footer.php'); ?>
    </section>
    <?php include('includes/notes.php'); ?>




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

    <script src="vendors/datepicker/datepicker.js"></script>
    <script src="vendors/datepicker/datepicker.en.js"></script>
    <script src="vendors/datepicker/datepicker.custom.js"></script>
    <script src="js/chart.min.js"></script>

    <script src="vendors/progressbar/jquery.barfiller.js"></script>

    <script src="vendors/tagsinput/tagsinput.js"></script>

    <script src="vendors/text_editor/summernote-bs4.js"></script>
    <script src="vendors/am_chart/amcharts.js"></script>
    <script src="vendors/apex_chart/apexcharts.js"></script>
    <script src="vendors/apex_chart/apex_realestate.js"></script>

    <script src="vendors/chart_am/core.js"></script>
    <script src="vendors/chart_am/charts.js"></script>
    <script src="vendors/chart_am/animated.js"></script>
    <script src="vendors/chart_am/kelly.js"></script>
    <script src="vendors/chart_am/chart-custom.js"></script>

    <script src="js/custom.js"></script>
    <script src="vendors/apex_chart/bar_active_1.js"></script>
    <script src="vendors/apex_chart/apex_chart_list.js"></script>
</body>


</html>