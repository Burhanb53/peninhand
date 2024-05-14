<?php
// if (session_status() === PHP_SESSION_NONE) {
//     // Start the session
//     session_start();
// }
error_reporting(0);
include('../../../includes/config.php');

?>
<div class="container-fluid g-0">

    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div style="margin-left: auto;" class="header_right d-flex justify-content-between align-items-center">
                    <div class="header_notification_warp d-flex align-items-center">
                        
                        <li style="margin-right: 10px;">
                            <h3>Admin Dashboard</h3>
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

                            <div class="profile_info_details">
                                <a href="../../auth/logout.php">Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>