<?php
// Include database connection
include('../../../includes/config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $tech_stack = $_POST['tech_stack'];
    $experience = $_POST['experience'];
    
    // Check if a resume file is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        // Define upload directory
        $uploadDir = "../uploads/resume/";

        // Generate unique filename
        $resumeName = uniqid() . '_' . basename($_FILES['resume']['name']);
        $resumePath = $uploadDir . $resumeName;

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath)) {
            // Prepare and execute SQL query to update the user details with resume
            $sql = "UPDATE teacher SET 
                    name = :name, 
                    email = :email, 
                    contact = :contact, 
                    age = :age, 
                    gender = :gender, 
                    tech_stack = :tech_stack, 
                    experience = :experience, 
                    resume = :resume, 
                    address = :address, 
                    city = :city, 
                    state = :state, 
                    pin = :pin 
                    WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':tech_stack', $tech_stack);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':resume', $resumeName); // Store filename in database
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':pin', $pin);

            if ($stmt->execute()) {
                // Redirect back to the previous page after updating using JavaScript
                echo '<script>window.history.go(-2);</script>';
                exit();
            } else {
                echo "Error updating profile.";
            }
        } else {
            echo "Error uploading resume.";
        }
    } else {
        // Prepare and execute SQL query to update the user details without resume
        $sql = "UPDATE teacher SET 
                name = :name, 
                email = :email, 
                contact = :contact, 
                age = :age, 
                gender = :gender, 
                tech_stack = :tech_stack, 
                experience = :experience, 
                address = :address, 
                city = :city, 
                state = :state, 
                pin = :pin 
                WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':tech_stack', $tech_stack);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':pin', $pin);

        if ($stmt->execute()) {
            // Redirect back to the previous page after updating using JavaScript
            echo '<script>window.history.go(-2);</script>';
            exit();
        } else {
            echo "Error updating profile.";
        }
    }
}
?>
