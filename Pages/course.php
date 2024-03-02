<?php
session_start();
error_reporting(0);
include('config.php');
?>


<!Doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>School University & Online Education Template | Eduan - eLearning Education</title>
        <meta name="description" content>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/animate.min.css">
        <link rel="stylesheet" href="../assets/css/magnific-popup.css">
        <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="../assets/css/odometer.min.css">
        <link rel="stylesheet" href="../assets/css/nice-select.css">
        <link rel="stylesheet" href="../assets/css/meanmenu.css">
        <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
        <link rel="stylesheet" href="../assets/css/main.css">
    </head>
     
    <body>
    <?php include('../includes/navbar.php'); ?>

        <main>
            <!-- breadcrumb area start -->
            <section class="breadcrumb-area bg-default" data-background="../assets/img/breadcrumb/breadcrumb-bg.jpg">
                <img src="../assets/img/breadcrumb/shape-1.png" alt class="breadcrumb-shape">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb-content">
                                <h2 class="breadcrumb-title">Course Archive</h2>
                                <div class="breadcrumb-list">
                                    <a href>Home</a>
                                    <span>Course</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb area end -->

            <!-- course area start -->
            <section class="innerPage_course-area pt-120 pb-90">
                <div class="container">
                    <div class="innerPage_course-top mb-30">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-xl-4 col-md-4">
                                <div class="innerPage_course-left mb-20">
                                    <p>Showing 1-8 of 24 results</p>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-8">
                                <div class="innerPage_course-right mb-20">
                                    <div class="innerPage_course-category">
                                        <select name="select" class="innerPage_course-category-list has-nice-select">
                                            <option value="1">Art & Design</option>
                                            <option value="2">Graphic Design</option>
                                            <option value="3">Web Design</option>
                                            <option value="4">UX/UI Design</option>
                                        </select>
                                    </div>
                                    <div class="innerPage_course-search">
                                        <form action="#">
                                            <input type="text" placeholder="Search Item">
                                            <button type="submit" class="innerPage_course-search-btn"><i class="fa-thin fa-magnifying-glass"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/1.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">Introduction to Psychology Subject</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>23 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>45 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-1.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Eric Wid get</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$140</del>$96.00</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/2.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">Complete Angular Developer in 2023</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>54 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>72 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-2.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Hanson Deck</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$120</del>$70.00</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/3.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">The Science of Well-being for Teens</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>67 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>24 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-3.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Max Conversion</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$150</del>$99.00</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/4.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">AWS Machine Learning Engineer</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>57 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>98 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-4.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Ravi O'Leigh</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$159</del>$98.00</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/5.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">Introduction User Experience Design</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>58 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>50 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-5.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Valentino Morose</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$135</del>$69.00</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="h2_course-item mb-30">
                                <div class="h2_course-item-img">
                                    <a href="course-details.html"><img src="../assets/img/course/2/6.jpg" alt></a>
                                </div>
                                <div class="h2_course-content">
                                    <div class="h2_course-content-top">
                                        <div class="h2_course-rating">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                            </ul>
                                            <span>(03 Reviews)</span>
                                        </div>
                                        <div class="h2_course-save">
                                            <a href="#"><i class="fa-thin fa-bookmark"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="h2_course-content-title"><a href="course-details.html">Spoken English for Career Develop</a></h5>
                                    <div class="h2_course-content-info">
                                        <span><i class="fa-thin fa-book-blank"></i>35 Lessons</span>
                                        <span><i class="fa-thin fa-user-group"></i>24 Students</span>
                                    </div>
                                    <p class="h2_course-content-text">
                                        Through a combination of lectures, readings and discussions students.
                                    </p>
                                    <div class="h2_course-content-author">
                                        <div class="h2_course-author-img">
                                            <img src="../assets/img/course/2/author-6.jpg" alt>
                                        </div>
                                        <div class="h2_course-author-info">
                                            <span>By <a href="#">Dylan Meringue</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="h2_course-content-bottom">
                                    <div class="h2_course-bottom-price">
                                        <span><del>$230</del>$173</span>
                                    </div>
                                    <div class="h2_course-bottom-btn">
                                        <a href="course-details.html">More Details<i class="fa-light fa-arrow-right"></i><i class="fa-light fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-area mt-20 mb-30">
                                <ul>
                                    <li><a href="#">01</a></li>
                                    <li><a href="#">02</a></li>
                                    <li><a href="#">03</a></li>
                                    <li><a href="#">04</a></li>
                                    <li><a href="#"><i class="fa-light fa-angle-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- course area end -->

                        <!-- cta area start -->
                        <div class="cta-area h3_cta-area">
                            <div class="container">
                                <div class="cta-wrapper">
                                    <div class="row align-items-center">
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="cta-content mb-30 mb-lg-0">
                                                <h2 class="cta-title">Are you Ready to Start your
                                                    Online Course?</h2>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6">
                                            <div class="cta-button">
                                                <a href="sign-up.php" class="cta-btn"><i class="fa fa-user"></i>Sign Up</a>
                                                <a href="sign-in.php" class="cta-btn"><i class="fa fa-sign-in"></i>Sign In</a>
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- cta area end -->
                    </main>
            
                    <!-- footer area start -->
<?php include('../includes/footer.php'); ?>

		<!-- JS here -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/swiper-bundle.min.js"></script>
        <script src="../assets/js/jquery.meanmenu.min.js"></script>
        <script src="../assets/js/wow.min.js"></script>
        <script src="../assets/js/jquery.nice-select.min.js"></script>
        <script src="../assets/js/jquery.scrollUp.min.js"></script>
        <script src="../assets/js/jquery.magnific-popup.min.js"></script>
        <script src="../assets/js/odometer.min.js"></script>
        <script src="../assets/js/appear.min.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>
</html>