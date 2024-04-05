<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Check if teacher ID is provided in the URL
if (isset($_GET['id'])) {
    $teacherId = intval($_GET['id']);

    // Fetch teacher data from the database based on the ID
    $sqlTeacher = "SELECT * FROM teacher WHERE id = :id";
    $stmtTeacher = $dbh->prepare($sqlTeacher);
    $stmtTeacher->bindParam(':id', $teacherId);
    $stmtTeacher->execute();
    $teacherData = $stmtTeacher->fetch(PDO::FETCH_ASSOC);

    // Check if teacher data is found
    if ($teacherData) {
        // Fetch doubts of the student from the doubt table using user_id
        $doubtSql = "SELECT * FROM doubt WHERE teacher_id = :teacher_id";
        $doubtStmt = $dbh->prepare($doubtSql);
        $doubtStmt->bindParam(':teacher_id', $teacherData['teacher_id']); // Use user_id from student data
        $doubtStmt->execute();
        $doubts = $doubtStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">


            <title>Teacher's Information</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
            <style type="text/css">
                body {
                    color: #797979;
                    background: #f1f2f7;
                    font-family: 'Open Sans', sans-serif;
                    padding: 0px !important;
                    margin: 0px !important;
                    font-size: 13px;
                    text-rendering: optimizeLegibility;
                    -webkit-font-smoothing: antialiased;
                    -moz-font-smoothing: antialiased;
                }

                .profile-nav,
                .profile-info {
                    margin-top: 30px;
                }

                .profile-nav .user-heading {
                    background: #fbc02d;
                    color: #fff;
                    border-radius: 4px 4px 0 0;
                    -webkit-border-radius: 4px 4px 0 0;
                    padding: 30px;
                    text-align: center;
                }

                .profile-nav .user-heading.round a {
                    border-radius: 50%;
                    -webkit-border-radius: 50%;
                    border: 10px solid rgba(255, 255, 255, 0.3);
                    display: inline-block;
                }

                .profile-nav .user-heading a img {
                    width: 112px;
                    height: 112px;
                    border-radius: 50%;
                    -webkit-border-radius: 50%;
                }

                .profile-nav .user-heading h1 {
                    font-size: 22px;
                    font-weight: 300;
                    margin-bottom: 5px;
                }

                .profile-nav .user-heading p {
                    font-size: 12px;
                }

                .profile-nav ul {
                    margin-top: 1px;
                }

                .profile-nav ul>li {
                    border-bottom: 1px solid #ebeae6;
                    margin-top: 0;
                    line-height: 30px;
                }

                .profile-nav ul>li:last-child {
                    border-bottom: none;
                }

                .profile-nav ul>li>a {
                    border-radius: 0;
                    -webkit-border-radius: 0;
                    color: #89817f;
                    border-left: 5px solid #fff;
                }

                .profile-nav ul>li>a:hover,
                .profile-nav ul>li>a:focus,
                .profile-nav ul li.active a {
                    background: #f8f7f5 !important;
                    border-left: 5px solid #fbc02d;
                    color: #89817f !important;
                }

                .profile-nav ul>li:last-child>a:last-child {
                    border-radius: 0 0 4px 4px;
                    -webkit-border-radius: 0 0 4px 4px;
                }

                .profile-nav ul>li>a>i {
                    font-size: 16px;
                    padding-right: 10px;
                    color: #bcb3aa;
                }

                .r-activity {
                    margin: 6px 0 0;
                    font-size: 12px;
                }


                .p-text-area,
                .p-text-area:focus {
                    border: none;
                    font-weight: 300;
                    box-shadow: none;
                    color: #c3c3c3;
                    font-size: 16px;
                }

                .profile-info .panel-footer {
                    background-color: #f8f7f5;
                    border-top: 1px solid #e7ebee;
                }

                .profile-info .panel-footer ul li a {
                    color: #7a7a7a;
                }

                .bio-graph-heading {
                    background: #fbc02d;
                    color: #fff;
                    text-align: center;
                    font-style: italic;
                    padding: 40px 110px;
                    border-radius: 4px 4px 0 0;
                    -webkit-border-radius: 4px 4px 0 0;
                    font-size: 16px;
                    font-weight: 300;
                }

                .bio-graph-info {
                    color: #89817e;
                }

                .bio-graph-info h1 {
                    font-size: 22px;
                    font-weight: 300;
                    margin: 0 0 20px;
                }

                .bio-row {
                    width: 50%;
                    float: left;
                    margin-bottom: 10px;
                    padding: 0 15px;
                }

                .bio-row p span {
                    width: 100px;
                    display: inline-block;
                }

                .bio-chart,
                .bio-desk {
                    float: left;
                }

                .bio-chart {
                    width: 40%;
                }

                .bio-desk {
                    width: 60%;
                }

                .bio-desk h4 {
                    font-size: 15px;
                    font-weight: 400;
                }

                .bio-desk h4.terques {
                    color: #4CC5CD;
                }

                .bio-desk h4.red {
                    color: #e26b7f;
                }

                .bio-desk h4.green {
                    color: #97be4b;
                }

                .bio-desk h4.purple {
                    color: #caa3da;
                }

                .file-pos {
                    margin: 6px 0 10px 0;
                }

                .profile-activity h5 {
                    font-weight: 300;
                    margin-top: 0;
                    color: #c3c3c3;
                }

                .summary-head {
                    background: #ee7272;
                    color: #fff;
                    text-align: center;
                    border-bottom: 1px solid #ee7272;
                }

                .summary-head h4 {
                    font-weight: 300;
                    text-transform: uppercase;
                    margin-bottom: 5px;
                }

                .summary-head p {
                    color: rgba(255, 255, 255, 0.6);
                }

                ul.summary-list {
                    display: inline-block;
                    padding-left: 0;
                    width: 100%;
                    margin-bottom: 0;
                }

                ul.summary-list>li {
                    display: inline-block;
                    width: 19.5%;
                    text-align: center;
                }

                ul.summary-list>li>a>i {
                    display: block;
                    font-size: 18px;
                    padding-bottom: 5px;
                }

                ul.summary-list>li>a {
                    padding: 10px 0;
                    display: inline-block;
                    color: #818181;
                }

                ul.summary-list>li {
                    border-right: 1px solid #eaeaea;
                }

                ul.summary-list>li:last-child {
                    border-right: none;
                }

                .activity {
                    width: 100%;
                    float: left;
                    margin-bottom: 10px;
                }

                .activity.alt {
                    width: 100%;
                    float: right;
                    margin-bottom: 10px;
                }

                .activity span {
                    float: left;
                }

                .activity.alt span {
                    float: right;
                }

                .activity span,
                .activity.alt span {
                    width: 45px;
                    height: 45px;
                    line-height: 45px;
                    border-radius: 50%;
                    -webkit-border-radius: 50%;
                    background: #eee;
                    text-align: center;
                    color: #fff;
                    font-size: 16px;
                }

                .activity.terques span {
                    background: #8dd7d6;
                }

                .activity.terques h4 {
                    color: #8dd7d6;
                }

                .activity.purple span {
                    background: #b984dc;
                }

                .activity.purple h4 {
                    color: #b984dc;
                }

                .activity.blue span {
                    background: #90b4e6;
                }

                .activity.blue h4 {
                    color: #90b4e6;
                }

                .activity.green span {
                    background: #aec785;
                }

                .activity.green h4 {
                    color: #aec785;
                }

                .activity h4 {
                    margin-top: 0;
                    font-size: 16px;
                }

                .activity p {
                    margin-bottom: 0;
                    font-size: 13px;
                }

                .activity .activity-desk i,
                .activity.alt .activity-desk i {
                    float: left;
                    font-size: 18px;
                    margin-right: 10px;
                    color: #bebebe;
                }

                .activity .activity-desk {
                    margin-left: 70px;
                    position: relative;
                }

                .activity.alt .activity-desk {
                    margin-right: 70px;
                    position: relative;
                }

                .activity.alt .activity-desk .panel {
                    float: right;
                    position: relative;
                }

                .activity-desk .panel {
                    background: #F4F4F4;
                    display: inline-block;
                }


                .activity .activity-desk .arrow {
                    border-right: 8px solid #F4F4F4 !important;
                }

                .activity .activity-desk .arrow {
                    border-bottom: 8px solid transparent;
                    border-top: 8px solid transparent;
                    display: block;
                    height: 0;
                    left: -7px;
                    position: absolute;
                    top: 13px;
                    width: 0;
                }

                .activity-desk .arrow-alt {
                    border-left: 8px solid #F4F4F4 !important;
                }

                .activity-desk .arrow-alt {
                    border-bottom: 8px solid transparent;
                    border-top: 8px solid transparent;
                    display: block;
                    height: 0;
                    right: -7px;
                    position: absolute;
                    top: 13px;
                    width: 0;
                }

                .activity-desk .album {
                    display: inline-block;
                    margin-top: 10px;
                }

                .activity-desk .album a {
                    margin-right: 10px;
                }

                .activity-desk .album a:last-child {
                    margin-right: 0px;
                }
            </style>
        </head>

        <body>
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
            <div class="container bootstrap snippets bootdey">
                <div class="row">
                    <div class="profile-nav col-md-3">
                        <div class="panel">
                            <div class="user-heading round">
                                <a href="#">
                                    <img src="../../teacher/Dashboard/uploads/profile/<?php echo $teacherData['photo']; ?>"
                                        alt="Teacher Photo">

                                </a>
                                <h1>
                                    <?php echo $teacherData['name']; ?>
                                </h1>

                            </div>
                            <ul class="nav nav-pills nav-stacked">
                                <!-- <li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li> -->
                                <li><a href="#"> <i class="fa fa-calendar"></i> Recent Activity <span
                                            class="label label-warning pull-right r-activity">9</span></a></li>
                                <li><a href="#"> <i class="fa fa-edit"></i> Edit profile</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="profile-info col-md-9">
                        <!-- <div class="panel">
                            <form>
                                <textarea placeholder="Whats in your mind today?" rows="2"
                                    class="form-control input-lg p-text-area"></textarea>
                            </form>
                            <footer class="panel-footer">
                                <button class="btn btn-warning pull-right">Post</button>
                                <ul class="nav nav-pills">
                                    <li>
                                        <a href="#"><i class="fa fa-map-marker"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-camera"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class=" fa fa-film"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-microphone"></i></a>
                                    </li>
                                </ul>
                            </footer>
                        </div> -->
                        <div class="panel">
                            <div class="bio-graph-heading">
                                Teacher Profile Information
                            </div>
                            <div class="panel-body bio-graph-info">
                                <h1>Teacher Information <span>ID </span>:
                                            <?php echo $teacherData['teacher_id']; ?></h1>
                                <div class="row">
                                    
                                    <div class="bio-row">
                                        <p><span>Name </span>:
                                            <?php echo $teacherData['name']; ?>
                                        </p>
                                    </div>
                                    <!-- <div class="bio-row">
                                <p><span>Last Name </span><p><?php echo $teacherData['name']; ?></p>
                            </div> -->
                                    <div class="bio-row">
                                        <p><span>Gender </span>:
                                            <?php echo $teacherData['gender']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Age </span>:
                                            <?php echo $teacherData['age']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>State </span>:
                                            <?php echo $teacherData['state']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Tech Stack</span>:
                                            <?php echo $teacherData['tech_stack']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Experience </span>:
                                            <?php echo $teacherData['experience']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Email </span>:
                                            <?php echo $teacherData['email']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Mobile </span>:
                                            <?php echo $teacherData['contact']; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Joined </span>:
                                            <?php echo date('Y-m-d', strtotime($teacherData['created_at'])); ?>
                                        </p>
                                    </div>

                                    <div class="bio-row">
                                        <p><span>Status </span>:
                                            <?php echo $teacherData['active'] == 1 ? 'Active' : 'Not Active'; ?>
                                        </p>
                                    </div>
                                    <div class="bio-row">
                                        <p><span>Resume</span>: <a
                                                href="../../teacher/Dashboard/uploads/resume/<?php echo $teacherData['resume']; ?>"
                                                target="_blank">View Resume</a></p>
                                    </div>
                                    <div class="bio-row">
                                        <p>
                                            <span>Verification</span>:
                                            <?php
                                            if ($teacherData['verified'] == 0) {
                                                // echo "Not Verified";
                                                echo '<a href="update_verified.php?id=' . $teacherData['id'] . '&status=1">Verify</a>';
                                            } else {
                                                // echo "Verified";
                                                echo '<a href="update_verified.php?id=' . $teacherData['id'] . '&status=0">Unverify</a>';
                                            }
                                            ?>
                                        </p>

                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Display Doubts -->
            <div style="padding-left: 35px;padding-right: 35px" class="container-flex">
                                        <h1>Doubts</h1>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;">Doubt ID</th>
                                                        <th style="width: 50px;">Student ID</th>
                                                        <th style="width: 40px;">Doubt Category</th>
                                                        <th style="width: 80px;">Doubt</th>
                                                        <th style="width: 10px;">Doubt File</th>
                                                        <th style="width: 50px;">Created At</th>
                                                        <th style="width: 2px;">Answered</th>
                                                        <th style="width: 5px;">Answered at</th>
                                                        <th style="width: 5px;">Answer</th>
                                                        <th style="width: 5px;">Answer File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($doubts as $doubt): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $doubt['doubt_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['user_id'] != null ? $doubt['user_id'] : 'Not Assigned'; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['doubt_category']; ?>
                                                            </td>
                                                            <td style="max-width: 30px; overflow: hidden; text-overflow: ellipsis;">
                                                                <?php echo $doubt['doubt']; ?>
                                                            </td>
                                                            <td style="max-width: 10px; overflow: hidden; text-overflow: ellipsis;">
                                                                <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['doubt_file']; ?>"
                                                                    target="_blank">View File</a>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['doubt_created_at']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['answer'] != null ? 'Yes' : 'No'; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['answer_created_at']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $doubt['answer']; ?>
                                                            </td>
                                                            <td>
                                                            <a href="../../student/Dashboard/uploads/doubt/<?php echo $doubt['answer_file']; ?>"
                                                                    target="_blank">View File</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
            <script type="text/javascript">

            </script>
        </body>

        </html>
        <?php
    } else {
        echo "Teacher not found.";
    }
} else {
    echo "Teacher ID not provided.";
}
?>