<?php
include 'admin/db_connect.php';
?>


<style>
    .masthead{
        min-height: 23vh !important;
        height: 23vh !important;
    }
     .masthead:before{
        min-height: 23vh !important;
        height: 23vh !important;
    }
    img#cimg{
        max-height: 10vh;
        max-width: 6vw;
    }
    .alert {
    color: white; /* Text color */
    background-color: red; /* Background color */
    border-color: red; /* Border color */
}

</style>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Manage Account</h3>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>
<div class="container mt-3 pt-2">
    <div class="col-lg-12">
        <div class="card mb-5">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <form action="" id="update_account">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo !empty($_SESSION['bio']['firstname']) ? $_SESSION['bio']['firstname'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" value="<?php echo !empty($_SESSION['bio']['middlename']) ? $_SESSION['bio']['middlename'] : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo !empty($_SESSION['bio']['lastname']) ? $_SESSION['bio']['lastname'] : ''; ?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Gender</label>
                                    <select class="custom-select" name="gender" required>
                                        <option value="Male" <?php echo isset($_SESSION['bio']['gender']) && $_SESSION['bio']['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo isset($_SESSION['bio']['gender']) && $_SESSION['bio']['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Batch</label>
                                    <input type="input" class="form-control datepickerY" name="batch" value="<?php echo !empty($_SESSION['bio']['batch']) ? $_SESSION['bio']['batch'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Course Graduated</label>
                                    <select class="custom-select select2" name="course_id" required>
                                        <option></option>
                                        <?php 
                                        $course = $conn->query("SELECT * FROM courses order by course asc");
                                        while($row=$course->fetch_assoc()):
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"  <?php echo isset($_SESSION['bio']['course_id']) && $_SESSION['bio']['course_id'] == $row['id'] ? 'selected' : ''; ?>><?php echo $row['course'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
    <div class="col-md-4">
        <label for="" class="control-label">Location</label>
        <input type="text" class="form-control" name="location" value="<?php echo !empty($_SESSION['bio']['location']) ? $_SESSION['bio']['location'] : ''; ?>">
    </div>
    <div class="col-md-4">
        <label for="" class="control-label">Job Title</label>
        <input type="text" class="form-control" name="job_title" value="<?php echo !empty($_SESSION['bio']['job_title']) ? $_SESSION['bio']['job_title'] : ''; ?>">
    </div>
    <div class="col-md-4">
        <label for="" class="control-label">Company/College Name</label>
        <input type="text" class="form-control" name="connected_to" value="<?php echo !empty($_SESSION['bio']['connected_to']) ? $_SESSION['bio']['job_title'] : ''; ?>">
    </div>
</div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Contact</label>
                                    <input type="text" class="form-control" name="contact" value="<?php echo !empty($_SESSION['bio']['contact']) ? $_SESSION['bio']['contact'] : ''; ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="" class="control-label">Image</label>
                                    <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                                    <img src="admin/assets/uploads/<?php echo !empty($_SESSION['bio']['avatar']) ? $_SESSION['bio']['avatar'] : ''; ?>" alt="" id="cimg">
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email"  value="<?php echo !empty($_SESSION['bio']['email']) ? $_SESSION['bio']['email'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <small><i>Leave this blank if you dont want to change your password</i></small>
                                </div>
                            </div>
                            <div id="msg"></div>
                            <hr class="divider">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary">Update Account</button>
                                    <a href="index.php" class="btn btn-secondary btn-sm">Back</a> <!-- Back button -->

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.datepickerY').datepicker({
        format: " yyyy", 
        viewMode: "years", 
        minViewMode: "years"
    })
    $('.select2').select2({
        placeholder:"Please Select Here",
        width:"100%"
    })
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#update_account').submit(function(e){
    e.preventDefault(); // Prevent default form submission
    start_load(); // Start loading indicator
    $.ajax({
        url: 'admin/ajax.php?action=update_account',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        timeout: 10000, // Set timeout to 10 seconds
        success: function(resp) {
    if(resp == "not_allowed") {
        // User not allowed to update account
        $('#msg').html('<div class="alert alert-danger">You are not allowed to update your account. Please contact the admin.</div>');
    } else if(resp == "user_not_found") {
        // User not found
        $('#msg').html('<div class="alert alert-danger">User not found.</div>');
    } else if(resp == "email_exist") {
        // Email already exists
        $('#msg').html('<div class="alert alert-danger">The email you provided already exists. Please choose a different email.</div>');
    } else if(resp == "success") {
        // Data updated successfully
       
        alert('Your data has been updated successfully.');
        // Example: Redirect to home page after 3 seconds
        setTimeout(function() {
            window.location.href = 'index.php?page=home';
        }, 1000);
    }
    end_load(); // End loading indicator
},
        error: function(xhr, status, error) {
            // Handle timeout or other errors
            console.log("Error: ", error);
            $('#msg').html('<div class="alert alert-danger">Request timed out or encountered an error.</div>');
            end_load(); // End loading indicator
        }
    });
});


</script>
