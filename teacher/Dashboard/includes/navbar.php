<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
}error_reporting(0);
include('../../../includes/config.php');
if (!(isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
    // User doesn't have the required role, redirect to index.php
    header("Location: ../../../index.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
} else {
    $teacher_id = $_SESSION['user_id'];
    $stmt = $dbh->prepare("SELECT COUNT(*) AS notification_count FROM doubt WHERE teacher_id = :teacher_id AND teacher_view = 0");
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();
    $notification_row = $stmt->fetch(PDO::FETCH_ASSOC);
    $notification_count = $notification_row['notification_count'];

    $stmt = $dbh->prepare("SELECT * FROM teacher WHERE teacher_id = :teacher_id");
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt_notifications = $dbh->prepare("SELECT doubt.*, subscription_user.name AS student_name, subscription_user.photo AS student_photo 
                                    FROM doubt 
                                    LEFT JOIN subscription_user ON doubt.user_id = subscription_user.user_id 
                                    WHERE doubt.teacher_id = :teacher_id AND doubt.teacher_view = 0 
                                    ORDER BY doubt.doubt_created_at DESC LIMIT 5");
    $stmt_notifications->bindParam(':teacher_id', $teacher_id);
    $stmt_notifications->execute();
    $notifications = $stmt_notifications->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="container-fluid g-0">

    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div style="margin-left: 925px" class="header_right d-flex justify-content-between align-items-center">
                    <div class="header_notification_warp d-flex align-items-center">

                        <li>
                            <a class="bell_notification_clicker" href="#"> <img src="../img/icon/bell.svg" alt>
                                <span>
                                    <?php echo $notification_count; ?>
                                </span>
                            </a>
                            <div class="Menu_NOtification_Wrap">
                                <div class="notification_Header">
                                    <h4>Notifications</h4>
                                </div>
                                <div class="Notification_body">
                                    <?php foreach ($notifications as $notification) : ?>
                                        <div class="single_notify d-flex align-items-center">
                                            <div class="notify_thumb" >
                                                <?php if (!empty($notification['student_photo'])) : ?>
                                                        <a href="chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>"><img src="../../../student/Dashboard/uploads/profile/<?php echo $notification['student_photo']; ?>" alt></a>
                                                <?php else : ?>
                                                    <a href="chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>"><img src="../img/profile.jpg" alt></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="notify_content">
                                                <a href="chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>">
                                                    <?php if (!empty($notification['student_name'])) : ?>
                                                        <h5>
                                                            <?php echo $notification['student_name']; ?>
                                                        </h5>
                                                        <p>
                                                            <?php echo substr($notification['doubt'], 0, 40); ?>...
                                                        </p> <!-- Displaying the first 40 characters of the doubt -->
                                                    <?php else : ?>
                                                        <h5>
                                                            Teacher not available
                                                        </h5>
                                                        <p>
                                                            <?php echo substr($notification['doubt'], 0, 40); ?>...
                                                        </p> <!-- Displaying the first 40 characters of the doubt -->
                                                    <?php endif; ?>
                                                </a>


                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="nofity_footer">
                                    <div class="submit_button text-center pt_20">
                                        <a href="chat_history.php" class="btn_1">See More</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                    <div class="profile_info">
                        <?php if (!empty($user['photo'])) : ?>
                            <a href="#"><img src="../uploads/profile/<?php echo $user['photo']; ?>" alt></a>
                        <?php else : ?>
                            <a href="#"><img src="../img/profile.jpg" alt></a>
                        <?php endif; ?>
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <h5>
                                    <?php echo $user['name']; ?>
                                </h5>
                            </div>
                            <div class="profile_info_details">
                                <a href="profile.php">My Profile </a>
                                <a href="../../../auth/logout.php">Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>