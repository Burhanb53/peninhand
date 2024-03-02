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
                                <h2 class="breadcrumb-title">Contact Us</h2>
                                <div class="breadcrumb-list">
                                    <a href>Home</a>
                                    <span>Contact Us</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb area end -->

            <!-- contact area start -->
            <section class="contact-area pt-120 pb-120">
                <div class="container">
                    <div class="contact-wrap">
                        <div class="row">
                            <div class="col-xl-8 col-md-8">
                                <div class="contact-content pr-80 mb-20">
                                    <h3 class="contact-title mb-25">Send Me Message</h3>
                                    <form action="#" class="contact-form">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6">
                                                <div class="contact-form-input mb-30">
                                                    <input type="text" placeholder="Your Name">
                                                    <span class="inner-icon"><i class="fa-thin fa-user"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6">
                                                <div class="contact-form-input mb-30">
                                                    <input type="email" placeholder="Email Address">
                                                    <span class="inner-icon"><i class="fa-thin fa-envelope"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6">
                                                <div class="contact-form-input mb-30">
                                                    <input type="text" placeholder="Your Number">
                                                    <span class="inner-icon"><i class="fa-thin fa-phone-volume"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6 ">
                                                <div class="contact-form-input">
                                                    <span class="inner-icon inner-icon-select"><i class="fa-thin fa-circle-exclamation"></i></span>
                                                    <select name="select" class="contact-form-list has-nice-select mb-30">
                                                        <option value="1">Select Subject</option>
                                                        <option value="2">Art & Design</option>
                                                        <option value="3">Graphic Design</option>
                                                        <option value="4">Web Design</option>
                                                        <option value="5">UX/UI Design</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="contact-form-input mb-50 contact-form-textarea">
                                                    <textarea name="message" cols="30" rows="10" placeholder="Feel free to get in touch!"></textarea>
                                                    <span class="inner-icon"><i class="fa-thin fa-pen"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="contact-form-submit mb-30">
                                                    <div class="contact-form-btn">
                                                        <a href="#" class="theme-btn contact-btn">Send Message</a>
                                                    </div>
                                                    <div class="contact-form-condition">
                                                        <label class="condition_label">I agree that my data is collected and stored.
                                                            <input type="checkbox">
                                                            <span class="check_mark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="contact-info ml-50 mb-20">
                                    <h3 class="contact-title mb-40">Get In Touch</h3>
                                    <div class="contact-info-item">
                                        <span><i class="fa-thin fa-location-dot"></i>Address</span>
                                        <p>Hilton Conference Centre</p>
                                    </div>
                                    <div class="contact-info-item">
                                        <span><i class="fa-thin fa-mobile-notch"></i>Phone</span>
                                        <a href="tel:+123548645850">+123 548 6458 50</a>
                                    </div>
                                    <div class="contact-info-item">
                                        <span><i class="fa-thin fa-envelope"></i>Email</span>
                                        <a href="mailto:example@gmail.com">Example@gmail.com</a>
                                    </div>
                                    <div class="contact-social">
                                        <span>Social Media</span>
                                        <ul>
                                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d147120.012062842!2d13.706000467398074!3d51.075159941942076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1senveto!5e0!3m2!1sen!2sbd!4v1680961754336!5m2!1sen!2sbd" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
            <!-- contact area end -->

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