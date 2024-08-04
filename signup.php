<?php 
include 'admin/db_connect.php'; 
?>

<style>
    .required-star {
        color: red;
    }
    
    body {
        background-color: #000;
        color: #fff;
    }

    .masthead {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    .masthead:before {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    img#cimg {
        max-height: 10vh;
        max-width: 6vw;
    }

    .card {
        background-color: #333;
        color: black;
    }

    .form-control {
        background-color: #555;
        color: gray;
        margin-bottom: 10px;
    }

    .datepickerY, .select2, .custom-select {
        background-color: #555;
        color: gray;
        margin-bottom: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        color: black;
    }

    #msg {
        color: #fff;
    }

    /* Add shadow to the field labels */
    label.control-label {
        text-shadow: 1px 1px 2px #001;
        color: #fff; /* Set the text color to white or any contrasting color */
        padding: 5px; /* Add padding for better appearance */
        border-radius: 5px; /* Optional: Add border-radius for rounded corners */
        display: inline-block; /* Ensure proper display for inline-block elements */
        margin-bottom: 5px; /* Add margin for spacing between labels */
    }
    #create_account {
        display: none;
    }
    .user-type-row {
        background-color: #555;
        padding: 10px;
        margin-bottom: 10px;
    }
    .modal-content {
        background-color: white;
        color: black;
    }

    /* Modal title color */
    .modal-title {
        color: black;
    }

    /* Modal body text color */
    .modal-body {
        color: black;
    }

    /* OK button color */
    #btnOk {
        background-color: #007bff;
        color: #fff;
    }


</style>
<!-- Instructions Modal -->
<div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-labelledby="instructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionsModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your instructions here -->
                <p>* field with * are rquired fields.</p>
                <p>* Please enter valid general register number which must be Capital letter followed by 11 digit number.</p>
                <p>* Please enter Valid name which must be verify with your general register number.</p>
                <p>* If you are doing any job then provide job role, company name and location where you.</p>
                <p>* Make sure to read and understand the instructions before proceeding.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnOk">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    // Initially hide the form
    $('#create_account').hide();

    // Show instructions modal on page load
    $('#instructionsModal').modal('show');

    // Event handler for the OK button in the instructions modal
    $('#btnOk').click(function() {
        // Hide the modal
        $('#instructionsModal').modal('hide');
        // Show the user type selection
        $('.user-type-row').show();
    });

    // Event handler for user type selection
    $('input[name="user_type"]').change(function() {
        // Show the form when user selects a user type
        $('#create_account').hide();
    });
});

</script>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Create Account</h3>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="col-md-12">
                         <div style="height:auto; overflow-y: auto;">
                    <div class="row user-type-row">
                        <div class="col-md-12 text-center">
                            <!-- Add GR number field above user type selection -->
                            <div class="row">
    <div class="col-md-6">
        <label for="gr_no" class="control-label">General Register Number<span class="required-star">*</span></label>
        <input type="text" class="form-control" id="gr_no" name="gr_no_check" placeholder="Enter GR number" pattern="[A-Z]\d{11}" title="GR number must start with a capital letter followed by 11 digits" required>
        <div id="gr_no_message"></div> <!-- This will display the message if GR number does not exist -->
    </div>
</div>


<script>
$(document).ready(function() {
    // Initially hide the form
    $('#create_account').hide();

    // Show instructions modal on page load
    $('#instructionsModal').modal('show');

    // Event handler for the OK button in the instructions modal
    $('#btnOk').click(function() {
        // Hide the modal
        $('#instructionsModal').modal('hide');
        // Show the user type selection
        $('.user-type-row').show();
    });

    // Event handler for GR number input
    $('#gr_no').blur(function() {
        var grNo = $(this).val();
        // Send AJAX request to check if GR number exists
        $.ajax({
            url: 'admin/ajax.php?action=check_gr_no',
            method: 'POST',
            data: { gr_no: grNo },
            success: function(response) {
                if (response === 'exists') {
                    // If GR number exists, show the create account form
                    $('#gr_no_message').html('');
                    $('#create_account').show();

                    // Fetch user data based on the GR number
                    $.ajax({
                        url: 'admin/ajax.php?action=fetch_user_data',
                        method: 'POST',
                        data: { gr_no: grNo },
                        success: function(userData) {
                            // Parse the JSON response containing user data
                            var user = JSON.parse(userData);

                            // Populate form fields with user data
                            $('input[name="gr_no"]').val(user.gr_no);
                            $('input[name="firstname"]').val(user.firstname);
                            $('input[name="middlename"]').val(user.middlename);
                            $('input[name="lastname"]').val(user.lastname);
                            $('select[name="gender"]').val(user.gender).change();
                            $('input[name="batch"]').val(user.batch);
                            $('input[name="branch"]').val(user.branch);
                            $('textarea[name="connected_to"]').val(user.connected_to);
                            $('input[name="job_title"]').val(user.job_title);
                            $('input[name="location"]').val(user.location);
                            $('input[name="contact"]').val(user.contact);
                            $('select[name="current_year"]').val(user.current_year).change();
                            $('select[name="user_type"]').val(user.user_type).change();

                            // Display the user image
                            $('#cimg').attr('src', 'admin/assets/uploads/' + user.img);

                            // Set email field as readonly if the email is already filled
                            if (user.email) {
                                $('input[name="email"]').val(user.email).prop('readonly', true);
                            }

                            // Auto-select the user type based on user data
                            if (user.user_type) {
                                $('input[name="user_type"][value="' + user.user_type + '"]').prop('checked', true);
                                updateBatchDatepicker(user.user_type);
                            }
                        },
                    });
                } else {
                    // If GR number does not exist, hide the create account form
                    $('#create_account').hide();
                    $('#gr_no_message').html('<div class="alert alert-danger">Your GR number does not exist.</div>');
                }
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(xhr.responseText);
            }
        });
    });
});
</script>


                            <label for="" class="control-label">Select User Type:<span class="required-star">*</span></label>
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="alumniRadio" value="alumni" checked>
                                    <label class="form-check-label" for="alumniRadio">Alumni</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="studentRadio" value="student" disabled >
                                    <label class="form-check-label" for="studentRadio">Student</label>
                                </div>
                            </div>
                        </div>
                    </div>
                        <form action="" id="create_account">
                            <div class="row">
                            <div class="col-md-6">
                                <label for="" class="control-label">General Register Number<span class="required-star">*</span></label>
                                <input type="text" class="form-control" name="gr_no" pattern="[A-Z]\d{11}" title="GR number must start with an uppercase letter followed by 11 digits" placeholder="N01032000023" required readonly>
                            </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">First Name<span class="required-star">*</span></label>
                                    <input type="text" class="form-control" name="firstname" required readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Father's Name<span class="required-star">*</span></label>
                                    <input type="text" class="form-control" name="middlename" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Last Name<span class="required-star">*</span></label>
                                    <input type="text" class="form-control" name="lastname" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                <label for="" class="control-label">Gender<span class="required-star">*</span></label>
                                    <select class="custom-select" name="gender" required readonly>
                                        <option value="" disabled selected>Select your gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Batch<span class="required-star">*</span></label>
                                    <input type="input" class="form-control datepickerY" name="batch" required readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Branch<span class="required-star">*</span></label>
                                    <select class="custom-select select" name="course_id" required>
                                        <option value="" disabled selected>Select your Branch</option>
                                        <?php 
                                        $course = $conn->query("SELECT * FROM courses order by course asc");
                                        while($row=$course->fetch_assoc()):
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['course'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Company Name</label>
                                    <textarea name="connected_to" id="" cols="30" rows="1" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Job Role</label>
                                    <input type="text" class="form-control" name="job_title" >
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Location<span class="required-star">*</span></label>
                                    <input type="text" class="form-control" name="location" required>
                                </div>
                            </div>

                            <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Contact<span class="required-star">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+91</span>
                                            </div>
                                            <input type="text" class="form-control" name="contact" pattern="\d{10}" title="Contact number must be 10 digits" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Current Year<span class="required-star">*</span></label>
                                        <select class="custom-select" name="current_year" >
                                            <option selected>Alumni</option>
                                            <option selected>FE</option>
                                            <option selected>SE</option>
                                            <option selected>TE</option>
                                            <option selected>BE</option>
                                        </select>
                                    </div>
                                 </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Image<span class="required-star">*</span></label>
                                    <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Email<span class="required-star">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Password<span class="required-star">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <div id="passwordMessage" style="display:none;"></div> <!-- This will display the password strength message -->
                                </div>
                            </div>

                            <div id="msg"></div>
                            <hr class="divider">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary">Create Account</button>
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
    });

    $('.select').select({
        placeholder:"Please Select Here",
        width:"100%"
    });
    var previousUserType = '';

    $('input[name="user_type"]').change(function() {
    var currentUserType = $(this).val();

    if (currentUserType === 'alumni' || currentUserType === 'student') {
        $('#create_account').show();
        updateBatchDatepicker(currentUserType);
        
        // Add an "Alumni" option and select it by default for alumni user type
        if (currentUserType === 'alumni') {
            $('select[name="current_year"]').html('<option value="Alumni" selected>Alumni</option>');
        } else {
            // For other user types, revert to the default options
            $('select[name="current_year"]').html('<option disabled selected>Select your current year</option><option value="FE">FE</option><option value="SE">SE</option><option value="TE">TE</option><option value="BE">BE</option>');
        }
    } else {
        $('#create_account').hide();
    }

    if (currentUserType !== previousUserType) {
        if (previousUserType !== '') {
            // Reload the page using JavaScript
            location.reload(true);
        }
    }

    previousUserType = currentUserType;
});

function updateBatchDatepicker(userType) {
    var batchDatepicker = $('.datepickerY');

    // Clear existing options
    batchDatepicker.datepicker('destroy');

    // Set the appropriate date range based on user type
    if (userType === 'student') {
        // For students, show future years
        batchDatepicker.datepicker({
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
            startDate: new Date() // Start from the current year
        });
    } else if (userType === 'alumni') {
        // For alumni, show years from 2006 to the current year
        batchDatepicker.datepicker({
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
            startDate: '2006',
            endDate: new Date()
        });
    }
}

// Initial update of batch datepicker based on user type
var initialUserType = $('input[name="user_type"]:checked').val();
updateBatchDatepicker(initialUserType);

function displayImg(input, _this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cimg').attr('admin/assets/uploads', e.target.result);
        };

        reader.onerror = function (e) {
            console.error('Error reading file:', e.target.error);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        console.error('No file selected or file input not supported.');
    }
}


$('#create_account').submit(function (e) {
    e.preventDefault();
    start_load();
    $('#msg').html('');

    // Validate contact number length
    var contactNumber = $('input[name="contact"]').val();
    if (contactNumber.length !== 10) {
        $('#msg').html('<div class="alert alert-danger">Please enter a valid 10-digit mobile number</div>');
        end_load();
        return; // Stop form submission if validation fails
    }
    
    var currentYear = $('select[name="current_year"]').val();
    if (!currentYear) {
        // If Current Year is not selected, show an alert next to the field
        $('select[name="current_year"]').after('<div class="alert alert-danger small">Please select a Current Year</div>');
        end_load();
        return; // Stop form submission if validation fails
    }
    
    // Check if an image is selected
    var imgInput = $('input[name="img"]');
    if (imgInput[0].files.length === 0) {
        // If no image is selected, show an alert next to the image field
        $('input[name="img"]').after('<div class="alert alert-danger">Please choose the image</div>');
        end_load();
        return; // Stop form submission if no image is selected
    }
    
    // Create FormData object and append form data
    var formData = new FormData($(this)[0]);
    var userType = $('input[name="user_type"]:checked').val();
    formData.append('user_type', userType); // Append selected user type to form data

    // Send AJAX request
    $.ajax({
        url: 'admin/ajax.php?action=signup',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function (resp) {
            var response = JSON.parse(resp);
            if (response.status === 'success') {
                alert('Signup successful! you will receive mail for successfully creating account.');
                location.replace('index.php');
            } else if (response.status === 'error') {
                // Clear existing alert messages
                $('#msg').html('');
                
                if (response.message === 'Email already exists') {
                    $('#msg').html('<div class="alert alert-danger">Email already exists</div>');
                } else if (response.message === 'Gr no already exists') {
                    // Display Gr no exists alert next to the Gr no field
                    $('input[name="gr_no"]').after('<div class="alert alert-danger">Gr no already exists</div>');
                    
                } else {
                    $('#msg').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
                end_load();
            }
        },
        error: function (xhr, status, error) {
            // Handle errors, you can log them to console for debugging
            console.error(xhr.responseText);
            $('#msg').html('<div class="alert alert-danger">Error occurred while processing your request.</div>');
            end_load();
        }
    });
});

document.getElementById("password").addEventListener("input", function() {
    var password = document.getElementById("password").value;
    var strength = 0;

    // Minimum length check
    if (password.length >= 8) {
        strength++;
    }
    // Uppercase letter check
    if (password.match(/[A-Z]/)) {
        strength++;
    }
    // Number check
    if (password.match(/[0-9]/)) {
        strength++;
    }
    // Symbol check
    if (password.match(/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/)) {
        strength++;
    }

    // Display strength message based on strength level
    var message = "";
    switch (strength) {
        case 0:
        case 1:
            message = "Password must be at least 8 characters long and contain uppercase letters, numbers, and symbols.";
            break;
        case 2:
            message = "Weak password";
            break;
        case 3:
            message = "Moderate password";
            break;
        case 4:
            message = "Strong password";
            break;
    }

    // Display message
    document.getElementById("passwordMessage").innerHTML = message;
    if (strength >= 2) {
        document.getElementById("passwordMessage").style.color = "green";
    } else {
        document.getElementById("passwordMessage").style.color = "red";
    }
    document.getElementById("passwordMessage").style.display = "block";
});


</script>
