<?php
session_start();
include('../../../includes/config.php');

// Check if all required fields are set
if (isset(
    $_POST['name'], $_POST['contact'], $_POST['mother_name'], $_POST['mother_email'],
    $_POST['mother_contact'], $_POST['father_name'], $_POST['father_email'], $_POST['father_contact'],
    $_POST['address'], $_POST['city'], $_POST['state'], $_POST['pin'], $_POST['subscription_id'],
    $_POST['transaction_id'], $_SESSION['user_id'], $_FILES['photo'], $_POST['end_date']
)) {
    // Include your database connection file

    // Collect form data
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_SESSION['email']; // Assuming email is stored in session
    $contact = $_POST['contact'];
    $mother_name = $_POST['mother_name'];
    $mother_email = $_POST['mother_email'];
    $mother_contact = $_POST['mother_contact'];
    $father_name = $_POST['father_name'];
    $father_email = $_POST['father_email'];
    $father_contact = $_POST['father_contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $subscription_id = $_POST['subscription_id'];
    $transaction_id = $_POST['transaction_id'];
    $end_date = $_POST['end_date'];

    // File upload handling
    $targetDir = "../uploads/profile/";
    $fileName = basename($_FILES["photo"]["name"]);
    // Generate a unique ID
    $uniqueId = uniqid();

    // Append unique ID to the filename
    $fileName = $uniqueId . '_' . basename($fileName);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'jpeg', 'png');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            // Insert data into the database
            $sql = "INSERT INTO subscription_user (user_id, name, email, contact, photo, mother_name, mother_email, mother_contact, father_name, father_email, father_contact, address, city, state, pin, subscription_id, transaction_id, end_date) 
                    VALUES (:user_id, :name, :email, :contact, :photo, :mother_name, :mother_email, :mother_contact, :father_name, :father_email, :father_contact, :address, :city, :state, :pin, :subscription_id, :transaction_id, :end_date)";
            $stmt = $dbh->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':photo', $fileName);
            $stmt->bindParam(':mother_name', $mother_name);
            $stmt->bindParam(':mother_email', $mother_email);
            $stmt->bindParam(':mother_contact', $mother_contact);
            $stmt->bindParam(':father_name', $father_name);
            $stmt->bindParam(':father_email', $father_email);
            $stmt->bindParam(':father_contact', $father_contact);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':pin', $pin);
            $stmt->bindParam(':subscription_id', $subscription_id);
            $stmt->bindParam(':transaction_id', $transaction_id);
            $stmt->bindParam(':end_date', $end_date);
            // Execute the query
            if ($stmt->execute()) {
                header("Location: ../Pages/success_registration.html");
                exit();
            } else {
                $errorMessage = "Error inserting data. Please try again.";
                $_SESSION['registration_message'] = "Error inserting data.";
                header("Location: ../Pages/error.php");
                exit();
            }
        } else {
            $errorMessage = "Error uploading file. Please try again.";
            $_SESSION['registration_message'] = "Error uploading file.";
            header("Location: ../Pages/error.php");
            exit();
        }
    } else {
        $errorMessage = "Invalid file format, please upload a JPG, JPEG or PNG file.";
        $_SESSION['registration_message'] = "Invalid file format.";
        header("Location: ../Pages/error.php");
        exit();
    }
} else {
    $errorMessage = "All fields are required. Please fill all the fields and try again.";
    $_SESSION['registration_message'] = "All fields are required.";
    header("Location: ../Pages/error.php");
    exit();
}
?>
