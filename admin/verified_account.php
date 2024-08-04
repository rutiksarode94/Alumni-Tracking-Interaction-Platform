<?php
include('db_connect.php');

// // Check if the current date is April 5th at 1:20 PM
// $currentDate = date('Y-m-d H:i:s');
// $targetDate = date('Y-04-05 13:20:00'); // April 5th at 1:20 PM

// // Check if the current date matches the target date
// if ($currentDate >= $targetDate) {
//     // Get the current year
//     $currentYear = date('Y');

//     // Update user_type from 'student' to 'alumni' for records where batch is the current year
//     $updateQuery = "UPDATE alumnus_bio SET user_type = 'alumni' WHERE batch = '$currentYear' AND user_type = 'student'";
//     $conn->query($updateQuery);
// }
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
                <!-- Right-aligned buttons -->
                <div class="text-right mt-md-0 mt-2">
                <a href="index.php" class="btn btn-primary btn-sm mr-2">Home</a>
                    <a href="index.php?page=alumniusers" class="btn btn-primary btn-sm mr-2">Alumni</a>
                    <a href="index.php?page=student" class="btn btn-primary btn-sm mr-2">Student</a></div>
                    <a href="index.php?page=verified_account" class="btn btn-primary btn-sm mr-2">Verified Accounts</a>
                    <a href="index.php?page=unverified_account" class="btn btn-primary btn-sm mr-2">Unverified Accounts</a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Verified Account</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Sr.No.</th>
                                    <th class="">Profile Photo</th>
                                    <th class="">Gr.No</th>
                                    <th class="">Name</th>
                                    <th class="">Batch</th>
                                    <th class="">Course</th>
                                    <th class="">User Type</th>
                                    <th class="">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                    $i = 1;
                                    $alumni = $conn->query("SELECT a.*, c.course, CONCAT(a.firstname,' ',a.middlename,' ',a.lastname) as name, a.batch 
                                                            FROM alumnus_bio a 
                                                            INNER JOIN courses c ON c.id = a.course_id 
                                                            WHERE a.status = 1 
                                                            ORDER BY a.date_created DESC");
                                    
                                    // Loop through the fetched alumni data
                                    while($row = $alumni->fetch_assoc()):
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="text-center">
                                    <div class="avatar" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                                    <?php if (empty($row['avatar'])): ?>
                                        <img src="http://localhost/project3/alumni/admin/assets/uploads/1602730260_avatar.jpg" class="img-fluid" style="width: 100%; height: auto;" > <!-- Replace icon_user.png with your preferred default icon for users -->
                                    <?php else: ?>
                                        <?php
                                        // Construct the file path based on the gr_no
                                        $avatar_path = 'assets/uploads/' . $row['gr_no'] . '.' . pathinfo($row['avatar'], PATHINFO_EXTENSION);
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
                                </td>

                                    <td class=""><?php echo ucwords($row['gr_no']) ?></td>
                                    <td class=""><?php echo ucwords($row['name']) ?></td>
                                    <td class=""><?php echo $row['batch'] ?></td>
                                    <td class=""><?php echo $row['course'] ?></td>
                                    <td class=""><?php echo $row['user_type'] ?></td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 1): ?>
                                            <span class="badge badge-primary">Verified</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Not Verified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton_<?php echo $row['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_<?php echo $row['id'] ?>">
        <a class="dropdown-item view_user" href="view_alumni.php?id=<?php echo $row['id'] ?>">Validate</a>
           <div class="dropdown-divider"></div>
            <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
        </div>
    </div>
</td>

                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>  
</div>
<style>
    
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
    }

    img {
        max-width: 100px;
        max-height: 100px;
    }

    .avatar {
        display: flex;
        border-radius: 100%;
        width: 100px;
        height: 100px;
        align-items: center;
        justify-content: center;
        border: 3px solid;
        padding: 5px;
    }

    .avatar img {
        max-width: calc(100%);
        max-height: calc(100%);
        border-radius: 100%;
    }

    /* Additional CSS */
    .button-container {
        display: flex;
        justify-content: center;
    }

</style>
<script>
    function goBack() {
        window.history.back();
    }
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('.view_alumni').click(function(){
		window.location.href = 'view_alumni.php?id=' + $(this).attr('data-id');
	});

    $('.delete_user').click(function(){
    _conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')]);
});

function delete_user($id){
    start_load();
    $.ajax({
        url: 'ajax.php?action=delete_alumni',
        method: 'POST',
        data: {id: $id},
        success: function(resp){
            if(resp == 1){
                alert_toast("Data successfully deleted", 'success');
                // After successful deletion, remove the corresponding row from the table
                $('tr[data-id="' + $id + '"]').remove(); // Remove the row with data-id equals to the deleted user's ID
                setTimeout(function(){
                    location.reload(); // Reload the page after a short delay
                }, 1000); // Adjust the delay time as needed
            } else {
                alert_toast("Error deleting data", 'error');
            }
        }
    });
}


</script>
