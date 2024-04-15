<?php
// Check if the card type is set in the POST data
if (isset($_POST['cardType'])) {
    // Get the card type from the POST data
    $cardType = $_POST['cardType'];

    // Redirect to different pages based on the card type
    switch ($cardType) {
        case 'ended-subscription':
            header("Location: send_mail_ended_subscription.php");
            break;
        case 'ending-subscription':
            header("Location: send_mail_ending_soon_subscription.php");
            break;
        case 'no-subscription':
            header("Location: send_mail_no_subscription.php");
            break;
        case 'declining-doubts':
            header("Location: send_mail_declining_doubts.php");
            break;
        case 'monthly-report-student':
            header("Location: send_mail_monthly_report_student.php");
            break;
        case 'monthly-report-teacher':
            header("Location: send_mail_monthly_report_teacher.php");
            break;
        default:
            // Invalid card type
            header("HTTP/1.1 400 Bad Request");
            exit("Invalid card type.");
    }
} else {
    // Card type not provided in the POST data
    header("HTTP/1.1 400 Bad Request");
    exit("Card type not provided.");
}
?>
