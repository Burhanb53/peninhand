<?php
// Include database connection
include ('../../../includes/config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $mother_name = $_POST['mother_name'];
    $mother_email = $_POST['mother_email'];
    $mother_contact = $_POST['mother_contact'];
    $father_name = $_POST['father_name'];
    $father_email = $_POST['father_email'];
    $father_contact = $_POST['father_contact'];

    // Prepare and execute SQL query to update the user details
    $sql = "UPDATE subscription_user SET 
            name = :name, 
            email = :email, 
            contact = :contact, 
            address = :address, 
            city = :city, 
            state = :state, 
            pin = :pin, 
            mother_name = :mother_name, 
            mother_email = :mother_email, 
            mother_contact = :mother_contact, 
            father_name = :father_name, 
            father_email = :father_email, 
            father_contact = :father_contact 
            WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':pin', $pin);
    $stmt->bindParam(':mother_name', $mother_name);
    $stmt->bindParam(':mother_email', $mother_email);
    $stmt->bindParam(':mother_contact', $mother_contact);
    $stmt->bindParam(':father_name', $father_name);
    $stmt->bindParam(':father_email', $father_email);
    $stmt->bindParam(':father_contact', $father_contact);
    
    if ($stmt->execute()) {
        // Redirect back to the previous page after updating using JavaScript
        echo '<script>window.history.go(-2);</script>';
        exit();
    } else {
        echo "Error updating profile.";
    }
}
?>
