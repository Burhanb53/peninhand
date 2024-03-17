<?php
session_start();
error_reporting(0);
include('../includes/config.php');
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
                            <h2 class="breadcrumb-title">Pricing</h2>
                            <div class="breadcrumb-list">
                                <a href>Home</a>
                                <span>Pricing</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->

        <!-- price area start -->
        <section class="innerPage_price-area pt-120 pb-90">
            <div class="container">
                <div class="row">
                    <?php

                    // SQL query to fetch all data from subscription_plan table
                    $sql = "SELECT * FROM subscription_plan";
                    $result = $dbh->query($sql);

                    // Check if there are any rows returned
                    if ($result->rowCount() > 0) {
                        // Output data of each row
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="h2_price-item mb-30">
                                    <div class="h2_price-item-title">
                                        <h5>
                                            <?php echo $row["plan_name"]; ?>
                                        </h5>
                                    </div>
                                    <div class="h2_price-amount">
                                        <del>$74.00</del>
                                        <div class="h2_price-amount-info">
                                            <h2>$
                                                <?php echo $row["price"]; ?>
                                            </h2>
                                            <p>
                                                <span>Per</span>
                                                <span>
                                                    <?php echo $row["duration"]; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="h2_price-middle-info">
                                        <p class="h2_price-middle-info-1">Discounted Price For USA</p>
                                        <p class="h2_price-middle-info-2">Per User, billed annually</p>
                                    </div>
                                    <div class="h2_price-button">
                                        <!-- Assuming you want to enroll for this plan -->
                                        <a href="../student/Dashboard/Pages/subscription_form.php?subscription_id=<?php echo $row["subscription_id"]; ?>">Enroll Now</a>
                                    </div>
                                    <div class="h2_price-content">
                                        <div class="h2_price-content-top">
                                            <!-- You can add logic here for displaying plan details -->
                                            <a href="#">Choose
                                                <?php echo $row["duration"]; ?> - year plan
                                            </a><span>Save 12%</span>
                                        </div>
                                        <div class="h2_price-content-list">
                                            <ul>
                                                <li>
                                                    <?php echo $row["description"]; ?>
                                                </li>
                                                <!-- Additional details from the plan could be added here -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "0 results";
                    }

                    // Close connection (if required)
                    $dbh = null;
                    ?>
                </div>
            </div>
        </section>
        <!-- price area end -->

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