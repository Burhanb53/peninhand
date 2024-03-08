<?php
// Function to determine if a menu item is active
function isMenuItemActive($menuItemPath)
{
    $currentPath = $_SERVER['PHP_SELF'];
    return (strpos($currentPath, $menuItemPath) !== false) ? 'mm-active' : '';
}
?>


<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a href="#"><img src="../img/logo.png" alt></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li class="<?php echo isMenuItemActive('/index.php'); ?>">
            <a href="../index.php" aria-expanded="false">
                <img src="../img/menu-icon/dashboard.svg" alt>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="<?php echo isMenuItemActive('/ask_doubt.php'); ?>">
            <a href="ask_doubt.php" aria-expanded="false">
                <img src="../img/menu-icon/16.svg" alt>
                <span>Ask Doubt</span>
            </a>
        </li>

        <li class="<?php echo isMenuItemActive('/chat_history.php'); ?>">
            <a href="chat_history.php" aria-expanded="false">
                <img src="../img/menu-icon/14.svg" alt>
                <span>Chat</span>
            </a>
        </li>
        </li>

        <li class="<?php echo isMenuItemActive('/video_call.php'); ?>">
            <a href="video_call.php" aria-expanded="false">
                <img src="../img/menu-icon/15.svg" alt>
                <span>Video Call</span>
            </a>
        </li>
    </ul>
</nav>

