<?php
// Include the file containing the login2() function and necessary configurations
include 'db_connect.php'; // Adjust the path as per your file structure

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Call the login2() function to process staff login
    $login_result = login();

    // Check the login result
    if ($login_result == 1) {
        // Staff login successful, redirect to staff dashboard or homepage
        header("Location: staff_dashboard.php"); // Adjust the redirection URL
        exit();
    } elseif ($login_result == 2) {
        // Staff account not approved, display appropriate message
        $error_message = "Your staff account is not approved. Please contact the administrator.";
    } else {
        // Invalid credentials, display appropriate message
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <!-- Add your CSS stylesheets and any other necessary meta tags -->
</head>
<body>

    <h2>Staff Login</h2>

    <?php if(isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit" name="submit">Login</button>
        </div>
    </form>

    <!-- Add any additional HTML content as needed -->

</body>
</html>
