<?php 
include('db_connect.php');

if (isset($_GET['id'])) {
    $user = $conn->query("SELECT * FROM users WHERE id =" . $_GET['id']);
    foreach ($user->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}

if ($_POST) {
    $data = array();
    parse_str($_POST['data'], $data);
    $id = intval($data['id']); // Convert id to integer
    $name = mysqli_real_escape_string($conn, $data['name']);
    $username = mysqli_real_escape_string($conn, $data['username']);
    $contact = mysqli_real_escape_string($conn, $data['contact']);
    $batch = mysqli_real_escape_string($conn, $data['batch']);
    $password = $data['password']; // Password won't be hashed yet
    $gr_no = mysqli_real_escape_string($conn, $data['gr_no']);
    $type = intval($data['type']); // Convert type to integer for comparison
    $user_type = isset($data['user_type']) ? mysqli_real_escape_string($conn, $data['user_type']) : ''; // User type if type = 3

    // Check if password meets the requirements
    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/', $password)) {
        echo json_encode(array('status' => 6, 'message' => 'Password must be 8 or more characters containing at least one uppercase letter, one number, and one symbol.'));
        exit;
    }

    // Validate contact number length
    if (strlen($contact) !== 10) {
        echo json_encode(array('status' => 7, 'message' => 'Contact number must be exactly 10 digits.'));
        exit;
    }

    // Update user data
    $query = "UPDATE users SET name = '$name', contact = '$contact', batch = '$batch', type = $type";
    if (!empty($password)) {
        $password = md5($password); // Hash the password for security
        $query .= ", password = '$password'";
    }
    if ($type == 3 && !empty($user_type)) {
        $query .= ", user_type = '$user_type'";
    }
    if (!empty($gr_no)) {
        // Check if the new GR No. already exists for another user
        $existing_user = $conn->query("SELECT * FROM users WHERE gr_no = '$gr_no' AND id != $id");
        if ($existing_user->num_rows > 0) {
            echo json_encode(array('status' => 4, 'message' => 'GR No. already exists.'));
            exit;
        }
        $query .= ", gr_no = '$gr_no'";
    }
    if (!empty($username)) {
        // Check if the new username already exists for another user
        $existing_user = $conn->query("SELECT * FROM users WHERE username = '$username' AND id != $id");
        if ($existing_user->num_rows > 0) {
            echo json_encode(array('status' => 3, 'message' => 'Email already exists.'));
            exit;
        }
        $query .= ", username = '$username'";
    }

    $query .= " WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo json_encode(array('status' => 1, 'message' => 'Account successfully updated.'));
    } else {
        echo json_encode(array('status' => 2, 'message' => 'Failed to update account.'));
    }
    exit;
}
?>

<div class="container">
    <h2>Edit User</h2>
    <div id="msg"></div>
    
    <form action="" id="manage-user" method="post">    
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : ''; ?>">
        <div class="form-group">
            <label for="gr_no">GR No.</label>
            <input type="text" name="gr_no" id="gr_no" class="form-control" value="<?php echo isset($meta['gr_no']) ? $meta['gr_no'] : ''; ?>" required placeholder='N01032000023'>
            <small class="text-muted">Gr.No. must start with a capital letter followed by 11 digits.</small>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Email</label>
            <input type="email" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact']) ? $meta['contact'] : ''; ?>" required>
        </div>
		<div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="custom-select" required>
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : ''; ?>>Admin</option>
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : ''; ?>>Staff</option>
                <option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : ''; ?>>User</option>
            </select>
        </div>
        <div class="form-group">
            <label for="batch">Batch</label>
            <input type="text" class="form-control datepickerY" name="batch" value="<?php echo isset($meta['batch']) ? $meta['batch'] : ''; ?>" required>
        </div>
		
        <div class="form-group" id="user-type-field" style="display: none;">
            <label for="user_type">User(Alumni/Student)</label>
            <select name="user_type" id="user_type" class="form-control">
                <option value="" selected>Please select user type</option>
                <option value="Alumni">Alumni</option>
                <option value="Student">Student</option>
            </select>
        </div>
		
        <div class="form-group" id="college-field">
            <label for="college">College Name/Company Name</label>
            <input type="text" name="connected_to" id="college" class="form-control" value="MET College" disabled>
        </div>
        <div class="form-group" id="job-role-field">
            <label for="job_role">Job Role</label>
            <input type="text" name="job_title" id="job_role" class="form-control" value="Teacher" disabled>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="">
            <?php if (!isset($meta['id'])): ?>
            <small class="text-muted">Password must be more than 8 characters and contain at least one uppercase letter, one number, and one symbol.</small>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
    $('.datepickerY').datepicker({
        format: " yyyy", 
        viewMode: "years", 
        minViewMode: "years"
    });

    $('#type').change(function() {
        if ($(this).val() === '3') {
            $('#user-type-field').show();
        } else {
            $('#user-type-field').hide();
        }
    });

    $(document).ready(function(){
        $('#type').change(function() {
            if ($(this).val() === '3') {
                $('#user-type-field').show();
                $('#college-field input').prop('disabled', false);
                $('#job-role-field input').prop('disabled', false);
            } else {
                $('#user-type-field').hide();
                $('#college-field input').prop('disabled', true);
                $('#job-role-field input').prop('disabled', true);

                // Set default values for Admin (1) and Staff (2)
                if ($(this).val() === '1' || $(this).val() === '2') {
                    $('#college').val('MET College');
                    $('#job_role').val('Teacher');
                }
            }
        });

        // Check batch year to set default user type
        function checkBatchYear() {
            var currentYear = new Date().getFullYear();
            var batchYear = parseInt($('#batch').val().split(" ")[0]); // Extract year from batch value

            if (batchYear >= currentYear) {
                $('#user_type').val('Student');
            } else {
                $('#user_type').val('Alumni');
            }
        }

        // Batch change event to update user type
        $('#batch').change(function() {
            checkBatchYear();
        });

        // Form submission
        $('#manage-user').submit(function(e){
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url:'<?php echo $_SERVER['PHP_SELF']; ?>',
                method:'POST',
                data:{data:data},
                success:function(resp){
                    resp = JSON.parse(resp);
                    if(resp.status == 1){
                        // Show success message as a pop-up
                        alert(resp.message);
                        // Reload the page after the user clicks "OK"
                        location.reload();
                    }else{
                        $('#msg').html('<div class="alert alert-danger">'+resp.message+'</div>');
                    }
                }
            });
        });
    });
</script>
