<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Prevent further execution
}

// Include database connection
include 'admin/db_connect.php';

// Fetch user data from the database
$user_id = $_SESSION['login_id'];
$user_query = $conn->query("SELECT u.*, c.course 
                            FROM users u
                            LEFT JOIN courses c ON u.course_id = c.id
                            WHERE u.id = $user_id");
$user_data = $user_query->fetch_assoc(); // Fetch user data as an associative array

// Check if user data is fetched successfully
if (!$user_data) {
    // Handle the case where user data is not found
    echo "User data not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Set background color */
            color: #212529; /* Set text color */
            font-family: Arial, sans-serif; /* Set font family */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            color: #fff;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            color: #fff;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .profile-image-container {
            cursor: pointer;
        }

        .profile-name {
            font-size: 24px; /* Adjust the font size of the name */
            margin-top: 10px; /* Adjust the spacing between the image and the name */
            color: #000; /* Set the text color to black */
        }

        .profile-details {
            text-align: left;
            color: #000; /* Set the text color to black */
        }

        .image-container {
            display: flex;
            color: #000; /* Set the text color to black */
            flex-direction: column;
            align-items: center;
        }

        .change-photo-input {
            margin-top: 20px;
            background-color: #007bff; /* Button background color */
            color: #fff; /* Button text color */
            padding: 10px 20px; /* Padding around button text */
            border: none; /* Remove button border */
            border-radius: 5px; /* Apply border radius */
            cursor: pointer; /* Show pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth transition for background color change */
        }

        .change-photo-input:hover {
            background-color: #0056b3; /* Darker background color on hover */
        }
    </style>
</head>
<body>

<div class="container mt-5 style="width: 50%;">
    <div class="d-flex flex-column align-items-center bg-white p-4 rounded">
    <div class="profile-image-container mb-3" style="border-radius: 50%; width: 150px; height: 150px; overflow: hidden;">
    <?php if (!empty($user_data['avatar'])): ?>
        <img class="profile-image" src="admin/assets/uploads/<?php echo $user_data['avatar'] ?>" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
    <?php else: ?>
        <img class="profile-image" src="http://localhost/project3/alumni/img/account.png" alt="Default Image" style="width: 100%; height: 100%;">
    <?php endif; ?>
</div>

        <h1 class="profile-name"><?php echo $user_data['name'] ?></h1>
    </div>

    <div class="profile-details bg-white p-4 rounded">
        <div class="row">
            <div class="col-md-6 left-column">
               
        <p><strong>Gr.No.:</strong> <?php echo $user_data['gr_no'] ?></p>
        <p><strong>Email:</strong> <?php echo $user_data['username'] ?></p>
        <p><strong>Mobile No.:</strong> <?php echo $user_data['contact'] ?></p>
        <p><strong>Branch:</strong> <?php echo $user_data['course'] ?></p>
                    
        </div>
            <div class="col-md-6 right-column">
              
        <p><strong>Batch:</strong> <?php echo $user_data['batch'] ?></p>
        <p><strong>Company Name:</strong> <?php echo $user_data['connected_to'] ?></p>
        <p><strong>Job Role:</strong> <?php echo $user_data['job_title'] ?></p>
        <p><strong>Location:</strong> <?php echo $user_data['location'] ?></p>
    </div>
    </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
    <div>
        <p style="color: white;">If you want to update your account, <a href="index.php?page=my_account">click here</a>.</p>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">
    <div>
        <p><a href="admin/ajax.php?action=logout2">Logout</a></p>
    </div>
</div>

</div>

<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <div class="image-container">
        <img class="modal-content" id="modalImage">
        <div class="change-photo-heading">Change Profile Photo</div>
        <div class="change-photo-link" id="changePhotoLink">Change Profile Photo</div>
        <button onclick="redirectToMyAccount()" class="change-photo-input" style="margin-top: 10px;">Click here</button>
    </div>
</div>

</body>
<script>
    $(document).ready(function () {
    // When the user clicks on the profile image
    $(".profile-image-container").click(function () {
        // Show the modal
        $("#imageModal").css("display", "block");
        // Set the modal image source to the profile image source
        $("#modalImage").attr("src", $(this).find(".profile-image").attr("src"));
        // Resize the image to 2cm
        $("#modalImage").css({"width": "10cm", "height": "10cm"});
        // Apply blur effect to the main content
        $(".profile-container").addClass("blur");

        // Hide the "Change Profile Photo" text
        $("#changePhotoLink").hide();
        // Show the file input
        $("#changePhotoInput").show();
    });

    // When the user clicks on the close button or outside the modal
    $(".close, #imageModal").click(function () {
        // Hide the modal
        $("#imageModal").css("display", "none");
        // Remove blur effect from the main content
        $(".profile-container").removeClass("blur");

        // Show the "Change Profile Photo" text
        $("#changePhotoLink").show();
        // Hide the file input
        $("#changePhotoInput").hide();
    });

    // When the user clicks on the "Change Profile Photo" link
    $("#changePhotoLink").click(function () {
        // Trigger click on the hidden file input
        $("#changePhotoInput").trigger("click");
    });

    // When the user selects a file using the file input
    $("#changePhotoInput").change(function (e) {
        // Prevent the click event propagation to avoid closing the modal
        e.stopPropagation();
        // You can add code here to handle the file change event
    });
});

    function redirectToMyAccount() {
        window.location.href = "index.php?page=my_account";
    }

</script>


</html>
