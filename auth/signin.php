<?php
session_start();

// Include your database configuration file
include('../includes/config.php');

$redirectUrl = "../Pages/sign-in.php"; // Default redirect URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Create a PDO instance
        $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

        // Set the PDO error mode to exception
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the user exists
        $checkUserQuery = $dbh->prepare("SELECT user_id, email, password, role FROM user WHERE email = :email");
        $checkUserQuery->bindParam(':email', $email);
        $checkUserQuery->execute();

        if ($checkUserQuery->rowCount() > 0) {
            // User exists, fetch user data
            $userData = $checkUserQuery->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $userData['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $userData['user_id'];
                $_SESSION['email'] = $userData['email'];
                $_SESSION['role'] = $userData['role'];

                // Redirect based on the user's role
                switch ($userData['role']) {
                    case 0:
                        header("Location: ../index.php");
                        exit();
                    case 1:
                        header("Location: ../student/dashboard.php");
                        exit();
                    case 2:
                        header("Location: ../teacher/dashboard.php");
                        exit();
                    case 3:
                        header("Location: ../admin/dashboard.php");
                        exit();
                    default:
                        // Handle any other roles as needed
                        break;
                }
            } else {
                // Password is incorrect
                $errorMessage = "Incorrect password.";
                $_SESSION['registration_message'] = "Incorrect password.";
            }
        } else {
            // User does not exist
            $errorMessage = "User does not exist.";
            $_SESSION['registration_message'] = "User does not exist.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $dbh = null;
    }

    // Redirect with error message
    header("Location: $redirectUrl");
    exit();
}
?>
