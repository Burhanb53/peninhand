<?php
// Start the session
session_start();

?>

<!-- sidebar-information-area-start -->
<div class="sidebar-info side-info">
    <div class="sidebar-logo-wrapper mb-25">
        <div class="row align-items-center">
            <div class="col-xl-6 col-8">
                <div class="sidebar-logo">
                    <a href><img src="assets/img/logo/logo-white.png" alt="logo-img"></a>
                </div>
            </div>
            <div class="col-xl-6 col-4">
                <div class="sidebar-close-wrapper text-end">
                    <button class="sidebar-close side-info-close"><i class="fal fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-menu-wrapper fix">
        <div class="mobile-menu"></div>
    </div>
</div>
<div class="offcanvas-overlay"></div>
<!-- sidebar-information-area-end -->
<!-- <style>
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style> -->
<!-- header area start -->
<header>
    <div class="h3_header-area header-sticky">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-sm-7 col-6">
                    <div class="h3_header-logo">
                        <a href><img style="height: 70px;" src="assets/img/logo/logo_real.png" alt></a>
                    </div>

                </div>
                <div class="col-xl-6 d-none d-xl-block">
                    <div class="h3_header-middle">
                        <nav class="h3_main-menu mobile-menu" id="mobile-menu">
                            <ul>
                                <li>
                                    <a href>Home</a>
                                </li>
                                <li>
                                    <a href="Pages/course.php">Courses</a>
                                </li>
                                <li>
                                    <a href="Pages/price.php">Price</a>
                                </li>
                                <li>
                                    <a href="Pages/about.php">About</a>
                                </li>
                                <li><a href="Pages/contact.php">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-5 col-6">
                    <div class="h3_header-right">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $userRole = $_SESSION['role'];
                        
                            echo '<div class="h3_header-btn d-none d-sm-block">';
                            echo '    <div class="header-btn theme-btn theme-btn-medium theme-btn-3 dropdown">Profile<i class="fa-light fa-arrow-up-right"></i>';
                            echo '        <div class="dropdown-content">';
                            
                            if ($userRole == 0) {
                                echo '            <a href="auth/logout.php">Logout</a>';
                            } elseif ($userRole == 1) {
                                echo '            <a href="student/Dashboard/index.php">Dashboard</a>';
                                echo '            <a href="auth/logout.php">Logout</a>';
                            } elseif ($userRole == 2) {
                                echo '            <a href="teacher/Dashboard/index.php">Dashboard</a>';
                                echo '            <a href="auth/logout.php">Logout</a>';
                            } elseif ($userRole == 3) {
                                echo '            <a href="admin/Dashboard/index.php">Dashboard</a>';
                                echo '            <a href="auth/logout.php">Logout</a>';
                            } elseif ($userRole == 4) {
                                echo '            <a href="parent/Dashboard/index.php">Dashboard</a>';
                                echo '            <a href="auth/logout.php">Logout</a>';
                            }
                        
                            echo '        </div>';
                            echo '    </div>';
                            echo '</div>';
                        } else {
                            // If the session is not started, show the original HTML code
                            echo '<div class="h3_header-btn d-none d-sm-block">';
                            echo '    <a href="pages/sign-in.php" class="header-btn theme-btn theme-btn-medium theme-btn-3">Sign In<i class="fa-light fa-arrow-up-right"></i></a>';
                            echo '</div>';
                        }
                        ?>

                        <div class="header-menu-bar d-xl-none ml-10">
                            <span class="header-menu-bar-icon side-toggle">
                                <i class="fa-light fa-bars"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header area end -->