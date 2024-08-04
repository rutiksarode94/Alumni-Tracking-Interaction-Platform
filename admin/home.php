<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome  ". $_SESSION['login_name']."!"  ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-primary">
                                <a href="index.php?page=alumniusers" style="text-decoration: none; color: inherit;">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                        <h4><b>
                                        <?php
                                            // Fetch the current year
                                            $current_year = date('Y');
                                            
                                            // Construct the SQL query with conditions for user_type and status
                                            $query = "SELECT * FROM alumnus_bio WHERE user_type = 'alumni' AND status = 1";
                                            
                                            // Execute the query
                                            $result = $conn->query($query);
                                            
                                            // Check if the query was successful
                                            if ($result) {
                                                // Output the number of rows returned by the query
                                                echo $result->num_rows;
                                            } else {
                                                // If there was an error in the query, output an error message
                                                echo "Error executing query: " . $conn->error;
                                            }
                                        ?>

                                        </b></h4>
                                        <p><b>Alumni</b></p>
                                    </div>
                                </a>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-info">
                                <a href="index.php?page=student" style="text-decoration: none; color: inherit;">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-users"></i></span>
                                        <h4><b>
                                        <?php
                                            // Fetch the current year
                                            $current_year = date('Y');
                                            
                                            // Construct the SQL query with conditions for user_type and status
                                            $query = "SELECT * FROM alumnus_bio WHERE user_type = 'student' AND status = 1";
                                            
                                            // Execute the query
                                            $result = $conn->query($query);
                                            
                                            // Check if the query was successful
                                            if ($result) {
                                                // Output the number of rows returned by the query
                                                echo $result->num_rows;
                                            } else {
                                                // If there was an error in the query, output an error message
                                                echo "Error executing query: " . $conn->error;
                                            }
                                        ?>

                                        </b></h4>
                                        <p><b>Student</b></p>
                                    </div>
                                </a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-warning">
                                <a href="index.php?page=jobs" style="text-decoration: none; color: inherit;">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-briefcase"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM careers")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Posted jobs</b></p>
                                    </div>
                                </a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-primary">
                                <a href="index.php?page=events" style="text-decoration: none; color: inherit;">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-calendar-day"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM events WHERE date_format(schedule,'%Y-%m%-d') >= '".date('Y-m-d')."'")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Upcoming Events</b></p>
                                    </div>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>	

                    
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>