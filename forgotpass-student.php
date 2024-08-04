<?php
session_start();

$update_successful = false; // Initialize variables
$update_error = '';

// Function to generate a random OTP
function generateOTP($length = 6) {
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

// Check if the form has been submitted to send OTP
if (isset($_POST['send_otp'])) {
    // Generate OTP
    $otp = generateOTP();

    // Store the OTP in a session variable for verification
    $_SESSION['otp'] = $otp;

    // Email details
    $to = "rutiksarode7@gmail.com";
    $subject = "Your OTP for verification";
    $message = "Your OTP is: $otp";
    $headers = "From: rutiksarode94@gmail.com";

    // Send email
    $check = mail($to, $subject, $message, $headers);

    if($check) {
        $otp_sent = true;
        $update_error = ''; // Reset update error if any
    } else {
        $update_error = "Email not sent. Please try again later.";
    }
}

// Check if the form has been submitted to verify OTP
if (isset($_POST['verify_otp'])) {
    // Verify OTP
    if ($_POST['otp'] == $_SESSION['otp']) {
        $otp_verified = true;
        $update_error = ''; // Reset update error if any
    } else {
        $update_error = "Invalid OTP. Please try again.";
    }
}

// Check if the form has been submitted to reset password
if (isset($_POST['new_password'])) {
    // Reset password logic goes here
    // You can retrieve GR number or username from $_POST['gr_no_or_username']
    // Reset password logic...
    $update_successful = true; // Assuming password reset was successful
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            background: url('http://localhost/project3/alumni/img/222.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-top:15px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-bottom: 10px;
            color: red;
        }

        .success {
            margin-bottom: 10px;
            color: green;
        }

        h2 {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>

        <!-- Display success message if password was changed -->
        <?php if ($update_successful): ?>
            <div class="success">Password changed successfully.</div>
            <script>
                // Redirect to student_login.php after 3 seconds
                setTimeout(function() {
                    window.location.href = 'http://localhost/project3/alumni/student_login.php';
                }, 3000);
            </script>
        <?php endif; ?>

        <!-- Display error message if any -->
        <?php if ($update_error): ?>
            <div class="alert"><?php echo $update_error; ?></div>
        <?php endif; ?>

        <!-- Form for submitting GR number or username -->
        <?php if (!isset($otp_sent) || !$otp_sent): ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="gr_no_or_username">GR No or Username:</label>
                    <input type="text" id="gr_no_or_username" name="gr_no_or_username" placeholder="Enter GR number or username" required>
                </div>
                <button type="submit" name="send_otp">Send OTP</button>
                <button type="button" id="back-btn" style="display: <?php echo ($user_exists ? 'none' : 'inline-block'); ?>" onclick="goBack()">Back</button>
                <script>
                    function goBack() {
        window.history.back();
    }
    </script>
            </form>
        <?php endif; ?>

        <!-- Form for entering OTP -->
        <?php if (isset($otp_sent) && $otp_sent && !isset($otp_verified)): ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="otp">Enter OTP:</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" name="verify_otp">Verify OTP</button>
                <button type="button" id="back-btn" style="display: <?php echo ($user_exists ? 'none' : 'inline-block'); ?>" onclick="goBack()">Back</button>
                <script>
                    function goBack() {
        window.history.back();
    }
    </script>
            </form>
        <?php endif; ?>

        <!-- Form for resetting password after OTP verification -->
        <?php if (isset($otp_verified) && $otp_verified): ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new_password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
