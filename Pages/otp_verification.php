<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            /* Adjust width as needed */
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        input[type="text"] {
            width: calc(100% / 6);
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            text-align: center;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Enter OTP</h2>
        <?php if (isset($_SESSION['otp_error'])) : ?>
            <div style="color: red;"><?php echo $_SESSION['otp_error']; ?></div>
            <?php unset($_SESSION['otp_error']); ?> <!-- Clear the error message -->
        <?php endif; ?>
        <form id="otpForm" method="post" action="../auth/otp_verification.php">
            <div class="form-group">
                <input type="text" id="digit1" maxlength="1" name="digit1" required>
                <input type="text" id="digit2" maxlength="1" name="digit2" required>
                <input type="text" id="digit3" maxlength="1" name="digit3" required>
                <input type="text" id="digit4" maxlength="1" name="digit4" required>
                <input type="text" id="digit5" maxlength="1" name="digit5" required>
                <input type="text" id="digit6" maxlength="1" name="digit6" required>
            </div>
            <input type="submit" value="Verify OTP">
        </form>
    </div>

    <script>
        // Function to automatically move cursor to the next input field
        function moveCursor(input, nextInput) {
            if (input.value.length === 1) {
                nextInput.focus();
            }
        }

        // Function to handle backspace key
        function handleBackspace(input, prevInput) {
            if (input.value.length === 0) {
                prevInput.focus();
            }
        }

        // Get all input fields
        var inputs = document.querySelectorAll('input[type="text"]');

        // Add event listeners to each input field
        inputs.forEach(function(input, index) {
            if (index < inputs.length - 1) {
                input.addEventListener('input', function() {
                    moveCursor(this, inputs[index + 1]);
                });
            }

            if (index > 0) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        handleBackspace(this, inputs[index - 1]);
                    }
                });
            }
        });
    </script>
</body>

</html>