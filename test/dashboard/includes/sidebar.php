<?php
// Get the current page URL
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if a menu item should be active
function is_active($page_name) {
    global $current_page;
    if ($page_name === $current_page) {
        return 'active';
    } else {
        return '';
    }
}

// Function to check if a submenu item should be active
function is_submenu_active($page_names) {
    global $current_page;
    if (in_array($current_page, $page_names)) {
        return 'active';
    } else {
        return '';
    }
}
?>

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="images/icon/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="<?= is_active('index.php') ?>">
                    <a href="index.php">
                        <i class="fa fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="has-sub <?= is_submenu_active(['all_teacher.php', 'assign.php', 'manage_teacher.php']) ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-users"></i>Teachers</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="all_teacher.php" class="<?= is_active('all_teacher.php') ?>">All Teachers</a>
                        </li>
                        <li>
                            <a href="assign.php" class="<?= is_active('assign.php') ?>">Assign</a>
                        </li>
                        <li>
                            <a href="manage_teacher.php" class="<?= is_active('manage_teacher.php') ?>">Manage</a>
                        </li>
                    </ul>
                </li>
                <li class="has-sub <?= is_submenu_active(['all_student.php', 'manage_student.php', 'doubts.php']) ?>">
                    <a class="js-arrow" href="#">
                        <i class="fa fa-graduation-cap"></i>Students</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="all_student.php" class="<?= is_active('all_student.php') ?>">All Students</a>
                        </li>
                        <li>
                            <a href="manage_student.php" class="<?= is_active('manage_student.php') ?>">Manage</a>
                        </li>
                        <li>
                            <a href="doubts.php" class="<?= is_active('doubts.php') ?>">Doubts</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= is_active('manage_subscription.php') ?>">
                    <a href="manage_subscription.php">
                        <i class="fa fa-chart-line"></i>Subscriptions</a>
                </li>
                <li class="<?= is_active('manage_mail.php') ?>">
                    <a href="manage_mail.php">
                        <i class="fa fa-envelope"></i>Mails</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
