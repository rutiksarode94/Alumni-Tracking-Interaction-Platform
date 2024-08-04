<?php
include 'admin/db_connect.php';

// Initialize variables
$user_exists = false;
$password_changed = false;
$update_successful = false;
$update_error = '';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the GR number or username from the form
    $gr_no_or_username = $_POST['gr_no_or_username'];

    // Check if the GR number or username exists in the database
    if(isset($pdo)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE gr_no = :gr_no OR username = :username");
        $stmt->execute(['gr_no' => $gr_no_or_username, 'username' => $gr_no_or_username]);
        $user = $stmt->fetch();

        if ($user) {
            // User exists
            $user_exists = true;

            // Check if the form is submitted for password update
            if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                
                // Validate passwords
                if ($new_password === $confirm_password) {
                    // Hash the new password using MD5
                    $hashed_password = md5($new_password);
                
                    // Update password in the database
                    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE gr_no = :gr_no OR username = :username");
                    $stmt->execute(['password' => $hashed_password, 'gr_no' => $gr_no_or_username, 'username' => $gr_no_or_username]);
                
                    // Check if password update was successful
                    if ($stmt->rowCount() > 0) {
                        $password_changed = true;
                        $update_successful = true;
                    } else {
                        $update_error = "Failed to update password.";
                    }
                } else {
                    $update_error = "Passwords do not match.";
                }
            }    
         }
    }
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
            background: url('http://localhost/MET_ALU/alumni/img/222.jpeg') no-repeat center center fixed;
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
        <?php if ($password_changed): ?>
        <div class="success">Password changed successfully.</div>
        <script>
            // Redirect to alumni_login.php after 3 seconds
            setTimeout(function() {
                window.location.href = 'http://localhost/project3/alumni/alumni_login.php';
            }, 3000);
        </script>
        <?php endif; ?>

        <!-- Display error message if password update failed -->
        <?php if ($update_error): ?>
        <div class="alert"><?php echo $update_error; ?></div>
        <?php endif; ?>

        <!-- Form for submitting GR number or username -->
        <!-- Form for submitting GR number or username -->
<form method="post" action="" id="check-user-form">
    <?php if (!$password_changed): ?> <!-- Only display if password not yet changed -->
        <div class="form-group">
            <label for="gr_no_or_username">GR No or Username:</label>
            <input type="text" id="gr_no_or_username" name="gr_no_or_username" placeholder="Enter GR number or username" required>
        </div>
        <button type="submit" id="check-user-btn">Check User</button>
        <button type="button" id="back-btn" style="display: <?php echo ($user_exists ? 'none' : 'inline-block'); ?>" onclick="goBack()">Back</button>
    <?php endif; ?>
</form>

<!-- Form for entering new password if user exists -->
<?php if ($user_exists): ?>
<div id="new-password-form">
    <h3>Enter New Password:</h3>
    <form id="reset-password-form" method="post" action="">
        <input type="hidden" name="gr_no_or_username" value="<?php echo htmlspecialchars($gr_no_or_username); ?>">
        <div class="form-group">
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new_password" placeholder="New Password" required>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        <button type="submit" id="reset-password-btn">Reset Password</button>
        <button onclick="goToLoginPage()">Back</button> <!-- Back button -->
    </form>
</div>
<?php endif; ?>

<script>
// Hide GR number or username field when new password form is displayed
$(document).ready(function() {
    $('#new-password-form').on('submit', function() {
        $('#gr_no_or_username').prop('disabled', true); // Disable GR number or username field
    });
});
function goToLoginPage() {
    window.location.href = 'http://localhost/project3/alumni/student_login.php';
}
function goBack() {
        window.history.back();
    }
</script>


</body>
</html>
