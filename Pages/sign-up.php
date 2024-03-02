<?php

session_start();

// Check if the registration message is set
if (isset($_SESSION['registration_message'])) {
    $registrationMessage = $_SESSION['registration_message'];
    unset($_SESSION['registration_message']); // Clear the message from the session
} else {
    $registrationMessage = ''; // No message, or it has already been displayed
}

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
        <!-- <section class="breadcrumb-area bg-default" data-background="../assets/img/breadcrumb/breadcrumb-bg.jpg">
            <img src="../assets/img/breadcrumb/shape-1.png" alt class="breadcrumb-shape">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-content">
                            <h2 class="breadcrumb-title">Sign Up</h2>
                            <div class="breadcrumb-list">
                                <a href="../index.html">Home</a>
                                <span>Sign Up</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- breadcrumb area end -->

        <!-- sign up area start -->
        <div class="account-area pt-120 pb-120" style="margin-top:-120px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-10">
                        <div class="account-wrap">
                            <div class="account-top sign-up">
                                <div class="account-top-current">
                                    <span>Sign Up</span>
                                </div>
                                <div class="account-top-link">
                                    <a href="sign-in.php">Sign In</a>
                                </div>
                            </div>
                            <div class="account-main">
                                <h3 class="account-title">Sign up using E-mail</h3>
                                <form action="../auth/signup.php" class="account-form" method="post"
                                    onsubmit="return validateForm()">

                                    <div class="account-form-item mb-20">
                                        <div class="account-form-label">
                                            <label>Your Email</label>
                                        </div>
                                        <div class="card-content">
                                            <p class="error-message">
                                                <?php echo $registrationMessage; ?>
                                            </p>
                                        </div>
                                        <div class="account-form-input">
                                            <input type="email" name="email" id="email" placeholder="Enter Your Email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="account-form-item mb-15">
                                        <div class="account-form-label">
                                            <label>Your Password</label>
                                        </div>
                                        <div class="account-form-input account-form-input-pass">
                                            <input type="password" id="passwordInput" name="password"
                                                placeholder="*********" pattern=".{8,}" required>

                                            <span id="togglePassword"><i class="fa-thin fa-eye"></i></span>

                                            <div id="passwordInfo">
                                                <p id="passwordLength">Password Length: 0</p>
                                                <p id="passwordMessage">Minimum length: 8 characters</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="account-form-condition">
                                        <label class="condition_label">Remember Me
                                            <input type="checkbox">
                                            <span class="check_mark"></span>
                                        </label>
                                    </div>
                                    <div class="account-form-button">
                                        <button type="submit" class="account-btn" id="signupButton" disabled>Sign
                                            Up</button>
                                    </div>
                                </form>



                                <div class="account-break">
                                    <span>OR</span>
                                </div>
                                <div class="account-bottom">
                                    <div class="account-option">
                                        <a href="#" class="account-option-account">
                                            <img src="../assets/img/bg/google.png" alt>
                                            <span>Google</span>
                                        </a>
                                    </div>
                                    <div class="account-bottom-text">
                                        <p>Already have an account ? <a href="sign-in.php">Sign In for here</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sign up area end -->

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
    <script>
        const passwordInput = document.getElementById('passwordInput');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon
            const eyeIcon = togglePassword.querySelector('i');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("passwordInput").value;

            if (email.trim() === "" || password.trim().length < 8) {
                alert("Please fill in both email and password (minimum 8 characters) before submitting.");
                return false;
            }

            return true;
        }

        document.getElementById("email").addEventListener("input", toggleSignupButton);
        document.getElementById("passwordInput").addEventListener("input", toggleSignupButton);
        document.getElementById("passwordInput").addEventListener("input", updatePasswordInfo);

        function toggleSignupButton() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("passwordInput").value;
            var signupButton = document.getElementById("signupButton");

            signupButton.disabled = email.trim() === "" || password.trim().length < 8;
        }

        function updatePasswordInfo() {
            var password = document.getElementById("passwordInput").value;
            var passwordLength = document.getElementById("passwordLength");
            var passwordMessage = document.getElementById("passwordMessage");

            passwordLength.textContent = "Password Length: " + password.length;

            if (password.length >= 8) {
                passwordMessage.style.color = "green";
                passwordMessage.textContent = "Password meets the minimum length requirement.";
            } else {
                passwordMessage.style.color = "red";
                passwordMessage.textContent = "Minimum length: 8 characters";
            }
        }
    </script>
</body>

</html>