<?php
session_start();
include('../includes/config.php');

$message = '';
$redirectUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Create a PDO instance
        $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the email is already registered
        $checkQuery = $dbh->prepare("SELECT user_id FROM user WHERE email = :email");
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {
            // User is already registered
            $_SESSION['registration_message'] = "User with this email is already registered. Please sign in.";
            $redirectUrl = "../Pages/sign-in.php";
        } else {
            // Generate a random 6-digit user_id
            $user_id = mt_rand(100000, 999999);

            // Insert user data into the database
            $insertQuery = $dbh->prepare("INSERT INTO user (user_id, email, password) VALUES (:user_id, :email, :password)");
            $insertQuery->bindParam(':user_id', $user_id);
            $insertQuery->bindParam(':email', $email);
            $insertQuery->bindParam(':password', $password);
            $insertQuery->execute();

            // Registration successful
            $_SESSION['registration_message'] = "Congratulations! You have successfully registered.";
            $redirectUrl = "../Pages/sign-in.php";
        }
    } catch (PDOException $e) {
        $_SESSION['registration_message'] = "Error: Failed to register user.";
        $redirectUrl = "../Pages/sign-up.php";
    } finally {
        // Close the database connection
        $dbh = null;
    }

    // Redirect after displaying the message
    header("Location: $redirectUrl");
    exit();
}
?>