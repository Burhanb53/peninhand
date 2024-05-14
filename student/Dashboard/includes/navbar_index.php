<?php
session_start();
error_reporting(0);
include('../../includes/config.php');
if (!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
    // User doesn't have the required role, redirect to index.php
    header("Location: ../../index.php");
    exit(); // Make sure to exit after the redirect to prevent further execution
} else {
    $user_id = $_SESSION['user_id'];
    $stmt = $dbh->prepare("SELECT COUNT(*) AS notification_count FROM doubt WHERE user_id = :user_id AND student_view = 0");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notification_row = $stmt->fetch(PDO::FETCH_ASSOC);
    $notification_count = $notification_row['notification_count'];

    $stmt = $dbh->prepare("SELECT * FROM subscription_user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt_notifications = $dbh->prepare("SELECT doubt.*, teacher.name AS teacher_name, teacher.photo AS teacher_photo 
                                    FROM doubt 
                                    LEFT JOIN teacher ON doubt.teacher_id = teacher.teacher_id 
                                    WHERE doubt.user_id = :user_id AND doubt.student_view = 0 
                                    ORDER BY doubt.doubt_created_at DESC LIMIT 5");
    $stmt_notifications->bindParam(':user_id', $user_id);
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
                            <a class="bell_notification_clicker" > <img src="img/icon/bell.svg" alt>
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
                                            <div class="notify_thumb">
                                                <?php if (!empty($notification['teacher_photo'])) : ?>
                                                    <a href="Pages/chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>"><img src="../../teacher/Dashboard/uploads/profile/<?php echo $notification['teacher_photo']; ?>" alt></a>
                                                <?php else : ?>
                                                    <a href="Pages/chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>"><img src="img/profile.jpg" alt></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="notify_content">
                                                <a href="Pages/chat.php?doubt_id=<?php echo $notification['doubt_id']; ?>">
                                                    <?php if (!empty($notification['teacher_name'])) : ?>
                                                        <h5>
                                                            <?php echo $notification['teacher_name']; ?>
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
                                        <a href="Pages/chat_history.php" class="btn_1">See More</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="CHATBOX_open">
                                <img src="img/icon/notes.svg" alt />
                            </a>
                        </li>
                    </div>
                    <div class="profile_info">
                        <?php if (!empty($user['photo'])) : ?>
                            <a href="#"><img src="uploads/profile/<?php echo $user['photo']; ?>" alt></a>
                        <?php else : ?>
                            <a href="#"><img src="img/profile.jpg" alt></a>
                        <?php endif; ?>
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <h5>
                                    <?php echo $user['name']; ?>
                                </h5>
                            </div>
                            <div class="profile_info_details">
                                <a href="Pages/profile.php">My Profile </a>
                                <a href="../../auth/logout.php">Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>