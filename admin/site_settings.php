<?php
include 'db_connect.php';

// Function to verify password
function verifyPassword($password, $hashedPassword) {
    // You can use password_verify() function if passwords are hashed using password_hash()
    // Example: return password_verify($password, $hashedPassword);

    // For illustration purposes, assuming plain text comparison
    return $password === $hashedPassword;
}

// Check if the edit profile form is submitted
// Check if the edit profile form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_profile'])) {
    // Get the new name and email from the form
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];

    // Update the admin details in the database
    $updateQuery = $conn->prepare("UPDATE users SET admin_name = ?, admin_email = ?");
    $updateQuery->bind_param("ss", $newName, $newEmail);
    if ($updateQuery->execute()) {
        // Show success message
        echo "<script>alert('Profile updated successfully.'); window.location.reload();</script>";
        exit; // Exit to prevent further execution
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
}

// Check if the change password form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Get the current password, new password, and confirm password from the form
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Fetch current password from the database (assuming user is authenticated and you have the user's ID)
    // Replace '123' with the actual user ID
    $stmt = $conn->prepare("SELECT admin_password FROM users WHERE id = ?");
    $stmt->bind_param("i", $Id);
    $Id = 1;
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "<script>alert('Error retrieving current password. Please try again.');</script>";
        exit;
    }
    $row = $result->fetch_assoc();
    $hashedPasswordFromDatabase = $row['admin_password'];

    // Check if the current password matches the one stored in the database
    if (!verifyPassword($currentPassword, $hashedPasswordFromDatabase)) {
        echo "<script>alert('Current password is incorrect.');</script>";
        exit;
    } else if ($newPassword != $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match.');</script>";
    } else {
        // Update the password in the database
        $updatePasswordQuery = $conn->prepare("UPDATE users SET admin_password = ? WHERE user_id = ?");
        $updatePasswordQuery->bind_param("si", $newPassword, $userId);
        if ($updatePasswordQuery->execute()) {
            // Show success message
            echo "<script>alert('Password changed successfully.'); window.location.reload();</script>";
            exit; // Exit to prevent further execution
        } else {
            echo "<script>alert('Error changing password. Please try again.');</script>";
        }
    }
}

$qry = $conn->query("SELECT * FROM system_settings LIMIT 1");
if ($qry->num_rows > 0) {
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
}

// Dummy admin details (replace with actual admin details retrieval logic)
// Dummy admin details (replace with actual admin details retrieval logic)
$adminDetails = array(
    'admin_name' => 'Admin',
    'admin_email' => 'admin@gmail.com'
);

?>


<div class="container-fluid">

    <div class="card col-lg-12">
        <div class="card-body">
            <!-- Display Admin Details -->
           <!-- Display Admin Details -->
                <h3>Admin Details</h3>
                <p><strong>Name:</strong> <?php echo isset($adminDetails['admin_name']) ? $adminDetails['admin_name'] : ''; ?></p>
                <p><strong>Email:</strong> <?php echo isset($adminDetails['admin_email']) ? $adminDetails['admin_email'] : ''; ?></p>

            <!-- Form to Edit Profile -->
           <!-- System Name and Email -->
<!-- Form to Edit Profile -->
<h3>Edit Profile</h3>
<form action="" id="edit-profile-form">
    <div class="form-group">
        <label for="new_name">New Name</label>
        <input type="text" class="form-control" id="new_name" name="new_name" required>
    </div>
    <div class="form-group">
        <label for="new_email">New Email</label>
        <input type="email" class="form-control" id="new_email" name="new_email" required>
    </div>
    <button type="submit" class="btn btn-primary" name="edit_profile">Save Changes</button>
</form>


            <!-- Form to Change Password -->
            <h3>Change Password</h3>
            <form action="" id="change-password-form">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <!-- Add fields for new password and confirm password as needed -->
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div id="password-mismatch-alert"></div>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>

            <!-- Help Section -->
            <h3>Help Section</h3>
            <!-- Add content for the help section -->

            <!-- System Name and Email -->
            <h3>System Settings</h3>
            <p><strong>System Name:</strong> <?php echo isset($meta['name']) ? $meta['name'] : ''; ?></p>
            <p><strong>Email:</strong> <?php echo isset($meta['email']) ? $meta['email'] : ''; ?></p>

        </div>
    </div>

    <style>
        img#cimg {
            max-height: 10vh;
            max-width: 6vw;
        }
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   <script>
   $(document).ready(function() {
    $('#edit-profile-form').submit(function(e) {
        e.preventDefault();
        var newName = $('#new_name').val();
        var newEmail = $('#new_email').val();
        $.ajax({
            type: 'POST',
            url: 'ajax.php?action=save_settings',
            data: {
                edit_profile: true,
                new_name: newName,
                new_email: newEmail
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    alert(response.message);
                    window.location.reload();
                } else {
                    console.error(response.message);
                    alert('Error updating profile. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error updating profile. Please try again.');
            }
        });
    });
});

    $('#change-password-form').submit(function(e) {
        e.preventDefault();
        // Get new password and confirm password values
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        // Check if new password matches confirm password
        if (newPassword !== confirmPassword) {
            // Display red alert message
            $('#password-mismatch-alert').html('<div class="alert alert-danger" role="alert">New password and confirm password do not match.</div>');
        } else {
            // Reset any previous alert
            $('#password-mismatch-alert').html('');

            // Implement logic to change admin password
            // Continue with the rest of the logic here
            // ...
        }
    });

    $('#system-name-form').submit(function(e) {
        e.preventDefault();
        var systemName = $('#system_name').val();
        $.ajax({
            type: 'POST',
            url: 'ajax.php?action=save_settings', // Update with your server-side script handling AJAX requests
            data: {
                action: 'update_system_name',
                system_name: systemName
            },
            success: function(response) {
                // Assuming the response is the updated system name
                $('#system-name').text(response);
                alert('System name updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error updating system name.');
            }
        });
    });
});
</script>

</script>

