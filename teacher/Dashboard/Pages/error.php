<?php
session_start();

$registrationMessage = isset ($_SESSION['registration_message']) ? $_SESSION['registration_message'] : '';
unset($_SESSION['registration_message']); // Clear the message from the session

error_reporting(0);
include ('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .error-container {
      text-align: center;
    }

    .error-message {
      font-size: 24px;
      font-weight: bold;
      color: #dc3545;
      /* Red color */
    }
  </style>
</head>

<body>
  <div class="error-container">
    <p class="error-message">An error occurred. Please try again later.</p>
    <p class="error-message">
      <?php echo $registrationMessage; ?>
    </p>
  </div>
  <script>
    setTimeout(function () {
      window.location.href = "../../../Pages/price.php"; // Redirect after 5 seconds
    }, 3000);
  </script>
</body>

</html>