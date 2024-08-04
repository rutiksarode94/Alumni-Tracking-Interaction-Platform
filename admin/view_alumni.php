<?php
include 'db_connect.php';


if(isset($_GET['id'])){
    $qry = $conn->query("SELECT a.*,c.course,Concat(a.firstname,' ',a.middlename,' ',a.lastname) as name from alumnus_bio a inner join courses c on c.id = a.course_id where a.id= ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k=$val;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container-field {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 30px;
            margin-bottom: 20px;
            width: 80%; /* Adjust as needed */
            max-width: 700px; /* Set a maximum width */
            margin: 30px auto; /* Center the container */
        }
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            width: 120px; /* Adjust as needed */
            height: 120px; /* Adjust as needed */
            border: 3px solid #007bff;
            margin-bottom: 20px;
            overflow: hidden;
            margin: 0 auto;
        }
        .avatar img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .badge-primary,
        .badge-secondary {
            font-size: 14px;
            padding: 8px 12px;
            margin-left: 20px;
        }
        .btn {
            font-size: 14px;
            padding: 8px 20px;
        }
        .modal-footer {
            justify-content: center;
        }
        .modal-footer .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-field">
        <div class="col-lg-12">
            <div>
                <center>
                    <h2>Profile</h2>
                    <h3><strong>Name:</strong> <?php echo $name ?></h3>
                    <div class="avatar" style="width: 3cm; height: 3cm; border-radius: 50%; overflow: hidden;">
                    <?php
                        // Construct the avatar image path
                        $avatar_path = 'assets/uploads/' . $gr_no . '.jpg'; // Assuming the avatar images are JPEG files

                        // Check if the file exists, if not, use the default image path
                        if (!file_exists($avatar_path)) {
                            $avatar_path = 'http://localhost/project3/alumni/admin/assets/uploads/1602730260_avatar.jpg';
                        }
                        ?>

                        <!-- Display the avatar -->
                        <div class="avatar" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden;">
                            <img src="<?php echo $avatar_path ?>" class="img-fluid" alt="Avatar" style="width: 100%; height: auto;">
                        </div>



                    </div>
                </center>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Gr.No.:</strong> <?php echo $gr_no ?></p>
                    <p><strong>Email:</strong> <?php echo $email ?></p>
                    <p><strong>Batch:</strong> <?php echo $batch ?></p>
                    <p><strong>Course:</strong> <?php echo $course ?></p>
                    <?php if (!empty($current_year)): ?>
                        <p><strong>Current Year:</strong> <?php echo $current_year ?></p>
                    <?php endif; ?>
                    <p><strong>Gender:</strong> <?php echo $gender ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>User Type:</strong> <?php echo $user_type ?></p>
                    <p><strong>Account Status:</strong> <?php echo $status == 1 ? '<span class="badge badge-primary">Verified</span>' : '<span class="badge badge-secondary">Unverified</span>' ?></p>
                    <p><strong>Location:</strong> <?php echo $location ?></p>
                    <p><strong>Contact:</strong> <?php echo $contact ?></p>
                    <p><strong>Date  created:</strong> <?php echo $date_created ?></p>
                    <?php if (!empty($job_title) || !empty($company_name)): ?>
                        <?php if (!empty($job_title)): ?>
                            <p><strong>Job Title:</strong> <?php echo $job_title ?></p>
                        <?php endif; ?>
                        <?php if (!empty($company_name)): ?>
                            <p><strong>Company Name:</strong> <?php echo $company_name ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job_title) && !empty($company_name)): ?>
                            <p><strong>Job Title:</strong> <?php echo $job_title ?></p>
                            <p><strong>Company Name:</strong> <?php echo $company_name ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
            // Display the verification message
            if (isset($verification_message)) {
                echo $verification_message;
            }
            ?>
            <div class="modal-footer display" style="position: absolute;  left: 50%; transform: translateX(-50%);">
                <div class="row">
                    <div class="col-lg-12">
                    <button class="btn btn-success send_message" data-id="' . $alumni['id'] . '">Send Message</button>
                 <button class="btn float-right btn-secondary close_modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $('.close_modal').click(function(){
            window.history.back();
        });
        $(document).ready(function() {
            // Function to handle the "Send Message" button click
            $('.send_message').click(function() {
                var alumniId = $(this).data('id');
                // Redirect to send_msg.php with the alumni ID as a parameter
                window.location.href = 'send_msg.php?alumni_id=' + alumniId;
            });
        });

    </script>
</body>
</html>
