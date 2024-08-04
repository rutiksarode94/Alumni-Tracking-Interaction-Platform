<!-- PHP and HTML code -->
<?php include('db_connect.php');?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-4">
                <form action="" id="manage-course">
                    <div class="card">
                        <div class="card-header">
                            Course Form
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label">Course</label>
                                <input type="text" class="form-control" name="course">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-course').get(0).reset()"> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b>course List</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Course</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $i = 1;
                                $course = $conn->query("SELECT * FROM courses ORDER BY course ASC");
                                while($row = $course->fetch_assoc()):
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                        <?php echo $row['course'] ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit_course" type="button" data-id="<?php echo $row['id'] ?>" data-course="<?php echo $row['course'] ?>" >Edit</button>
                                        <button class="btn btn-sm btn-danger delete_course" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
					<!-- Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Course successfully added.
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>  
</div>
<style>
    td{
        vertical-align: middle !important;
    }
	
    /* Custom CSS for Success Modal */
    #successModal .modal-dialog {
        max-width: 400px; /* Adjust the width as needed */
    }
    #successModal .modal-content {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    #successModal .modal-header {
        border-bottom: none;
    }
    #successModal .modal-body {
        padding: 20px;
        text-align: center;
    }
    #successModal .modal-title {
        font-weight: bold;
        font-size: 20px;
    }
    #successModal .close {
        color: #000;
        opacity: 1;
    }
    #successModal .close:hover {
        color: #000;
        opacity: 0.75;
    }
    #successModal .modal-header h5 {
        color: #000;
    }
    #successModal .modal-header {
        border-radius: 10px 10px 0 0;
        background-color: #28a745; /* Green color */
        color: #fff; /* White text */
    }
    #successModal .modal-body p {
        font-size: 16px;
        color: #000; /* Black text */
    }

</style>
<script>
  // JavaScript code
$('#manage-course').submit(function(e){
    e.preventDefault();
    var courseName = $('[name="course"]').val().trim();
    if(courseName == '') {
        alert('Please enter a valid course name.');
        return false;
    }

    // Check if the course already exists
    var courseExists = false;
    $('tbody tr').each(function(){
        var existingCourse = $(this).find('td:eq(1)').text().trim();
        if(existingCourse.toLowerCase() === courseName.toLowerCase()){
            courseExists = true;
            return false; // Exit the loop if course exists
        }
    });

    if(courseExists){
        alert('Course already exists.');
        return false;
    }

    start_load();
    $.ajax({
        url:'ajax.php?action=save_course',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp == 1){
                // Show the success modal upon successful addition of the course
                $('#successModal').modal('show');
                setTimeout(function(){
                    location.reload();
                },1500);
            } else if(resp == 2){
                alert_toast("Data successfully updated", 'success');
                setTimeout(function(){
                    location.reload();
                },1500);
            }
        }
    });
});
$('.edit_course').click(function(){
		start_load()
		var cat = $('#manage-course')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='course']").val($(this).attr('data-course'))
		end_load()
	})


    // Add event listener for delete buttons
    $('.delete_course').click(function(){
        var id = $(this).attr('data-id');
        delete_course(id);
    });

    // Function to handle delete action
    function delete_course(id){
        var confirmation = confirm("Are you sure you want to delete this course?");
        if(confirmation){
            $.ajax({
                url:'ajax.php?action=delete_course',
                method:'POST',
                data:{id:id},
                success:function(resp){
                    if(resp==1){
                        alert_toast("Data successfully deleted", 'success');
                        setTimeout(function(){
                            location.reload();
                        },1500);
                    }
                }
            });
        }
    }
</script>
