<?php 
include 'db_connect.php'; 
?>

<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
	</div>
	</div>
	
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Gr. No.</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Type</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$type = array("","Admin","Staff","Users");
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 <td class="text-center"><?php echo $i++ ?></td>
					<td>
				 		<?php echo ucwords($row['gr_no']) ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
				 		<?php 
				 			if($row['type'] == '3') {
				 				$user_type_query = $conn->query("SELECT user_type FROM users WHERE gr_no = '".$row['gr_no']."'");
				 				$user_type_row = $user_type_query->fetch_assoc();
				 				if($user_type_row) {
				 					echo $user_type_row['user_type'];
				 				} else {
				 					echo "Unknown"; // If user_type is not found
				 				}
				 			} else {
				 				echo $type[$row['type']];
				 			}
				 		?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable();
$('#new_user').click(function(){
	uni_modal('New User','manage_register.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('#save_user').submit(function(e){
    e.preventDefault(); // Prevent default form submission
    start_load(); // Show loading indicator
    // Send AJAX request to save new user data
    $.ajax({
        url: 'ajax.php?action=save_user', // URL to the PHP script that handles adding new user
        method: 'POST',
        data: $(this).serialize(), // Serialize form data
        success: function(resp) {
            if(resp == 1) {
                alert_toast("User added successfully.", 'success'); // Show success message
                setTimeout(function(){
                    location.reload(); // Reload the page after 1.5 seconds
                }, 1500);
            } else {
                alert_toast("Failed to add user. Please try again.", 'error'); // Show error message
                end_load(); // Hide loading indicator
            }
        },
        error: function(xhr, status, error) {
            console.log("Error: ", error); // Log any errors to the console
            alert_toast("An error occurred. Please try again later.", 'error'); // Show generic error message
            end_load(); // Hide loading indicator
        }
    });
});
</script>
