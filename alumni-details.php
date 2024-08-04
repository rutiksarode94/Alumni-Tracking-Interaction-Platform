<?php

// Check if the user is logged in
if (!isset($_SESSION['login_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Prevent further execution
}

// Include database connection
include 'admin/db_connect.php';

// Check if the gr_no parameter is provided in the URL
if (isset($_GET['gr_no']) && !empty($_GET['gr_no'])) {
    // Get the gr_no from the URL
    $gr_no = $_GET['gr_no'];
    
    // Fetch user data from the database based on the provided gr_no
    $user_query = $conn->query("SELECT ab.*, u.username, u.contact, u.location, u.connected_to, u.job_title, c.course
                                FROM alumnus_bio ab
                                INNER JOIN users u ON ab.gr_no = u.gr_no
                                INNER JOIN courses c ON ab.course_id = c.id
                                WHERE ab.gr_no = '$gr_no'");
    $user_data = $user_query->fetch_assoc(); // Fetch user data as an associative array

    // Check if user data is fetched successfully
    if (!$user_data) {
        // Handle the case where user data is not found
        echo "<script>alert('User data not found!'); window.history.back();</script>";
        exit();
    }
} else {
    // Handle the case where gr_no parameter is not provided
    echo "<script>alert('GR Number is required!'); window.history.back();</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <style>
    .container {
        margin-top: 20px; /* Increase the top margin to 20px */
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .left-column p,
    .right-column p {
        margin: 5px 0; /* Add some vertical margin for spacing */
        text-align: justify; /* Justify text */
    }

    .field-name {
        width: 100px; /* Fixed width for the field names */
        display: inline-block;
    }

    .colon {
        margin-right: 5px; /* Add margin to the right of the colon */
    }

    .close-button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .button-container {
   
   
    width: 100%;
}

</style>
</head>
<body>

<!-- Your HTML content here -->
<div class="container mt-5">
    <!-- Display user details -->
    <div class="d-flex flex-column align-items-center bg-white p-5 rounded">
        <div class="profile-image-container mb-8" style="border-radius: 50%; width: 150px; height: 150px; overflow: hidden;">
        <?php if (empty($user_data['avatar'])): ?>
            <img src="http://localhost/project3/alumni/admin/assets/uploads/1602730260_avatar.jpg" class="img-fluid" style="width: 100%; height: auto;" > <!-- Replace with default avatar image -->
        <?php else: ?>
            <?php
            // Construct the file path based on the gr_no
            $avatar_path = 'admin/assets/uploads/' . $user_data['gr_no'] . '.' . pathinfo($user_data['avatar'], PATHINFO_EXTENSION);
            // Check if the file exists
            if (file_exists($avatar_path)) {
                // Display the profile photo if the file exists
                ?>
                <img src="<?php echo $avatar_path ?>" class="img-fluid" alt="Avatar" style="width: 100%; height: auto;">
            <?php } else { ?>
                <!-- Display default profile photo if the file does not exist -->
                <img src="http://localhost/project3/alumni/admin/assets/uploads/1602730260_avatar.jpg" class="img-fluid" style="width: 100%; height: auto;" >
            <?php } ?>
        <?php endif; ?>
        </div>
        <h1 class="profile-name"><?php echo $user_data['firstname'] . ' ' . $user_data['middlename'] . ' ' . $user_data['lastname'] ?></h1>
    </div>

    <div class="profile-details mt-2 bg-white p-5 rounded">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-5 left-column">
                <!-- Display user details -->
                <p><strong class="field-name">Gr.No.</strong><span class="colon">:</span><?php echo $user_data['gr_no'] ?></p>
                <p><strong class="field-name">Email</strong><span class="colon">:</span><?php echo $user_data['username'] ?></p>
                <p><strong class="field-name">Gender</strong><span class="colon">:</span><?php echo $user_data['gender'] ?></p>
                <p><strong class="field-name">User Type</strong><span class="colon">:</span><?php echo $user_data['user_type'] ?></p>
                <p><strong class="field-name">Batch</strong><span class="colon">:</span><?php echo $user_data['batch'] ?></p>
                <p><strong class="field-name">Current Year</strong><span class="colon">:</span><?php echo $user_data['current_year'] ?></p>
             </div>
            <!-- Right Column -->
            <div class="col-md-7 right-column">
                <!-- Display user details -->
                <p><strong class="field-name">Mobile No.</strong><span class="colon">:</span><?php echo $user_data['contact'] ?></p>
                <p><strong class="field-name">Location</strong><span class="colon">:</span><?php echo $user_data['location'] ?></p>
                <p><strong class="field-name">Branch</strong><span class="colon">:</span><?php echo $user_data['course'] ?></p> <!-- Display course name -->
                <p><strong class="field-name">Company Name</strong><span class="colon">:</span><?php echo $user_data['connected_to'] ?></p>
                <p><strong class="field-name">Job Role</strong><span class="colon">:</span><?php echo $user_data['job_title'] ?></p>
            </div>
        </div>
        <hr class="divider my-5" />
        <div class="row justify-content-center mt-3">
    <div class="send-msg-button-container mr-3">
        <a href="send_msg.php?gr_no=<?php echo $user_data['gr_no']; ?>" class="btn btn-primary">Send Message</a>
        <button type="button" class="btn btn-secondary" onclick="goBack()">Close</button>
    </div>
</div>

</div>

</div>

    </div>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
