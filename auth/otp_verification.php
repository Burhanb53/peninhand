<?php
session_start();
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve entered OTP digits
    $otpDigits = [];
    for ($i = 1; $i <= 6; $i++) {
        $digit = $_POST['digit' . $i];
        if (!empty($digit)) {
            $otpDigits[] = $digit;
        }
    }

    // Concatenate OTP digits
    $otp = implode('', $otpDigits);
    $email = $_SESSION['forgot_password_email'];
    try {
        // Establish database connection
        $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        

        // Retrieve OTP from the database
        $query = $dbh->prepare("SELECT otp FROM otp WHERE email = :email AND otp = :otp AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
        $query->bindParam(':email', $email);
        $query->bindParam(':otp', $otp);
        $query->execute();

        if ($query->rowCount() > 0) {
            
            header("Location: ../Pages/reset_password.php");
            exit();
        } else {
            $_SESSION['otp_error'] = "Invalid OTP. Please try again.";
            header("Location: ../Pages/otp_verification.php"); // Redirect back to OTP page
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
