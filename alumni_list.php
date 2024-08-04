<?php 
include 'admin/db_connect.php'; 
session_start(); // Start the session
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.alumni-list{
cursor: pointer;
border: unset;
flex-direction: inherit;
}
.alumni-img {
    width: calc(30%);
    max-height: 30vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.alumni-list .card-body{
    width: calc(70%);
}
.alumni-img img {
    border-radius: 100%;
    max-height: calc(100%);
    max-width: calc(100%);
}
span.hightlight{
    background: yellow;
}
.carousel,.carousel-inner,.carousel-item{
   min-height: calc(100%)
}
header.masthead,header.masthead:before {
        min-height: 50vh !important;
        height: 50vh !important
    }
.row-items{
    position: relative;
}
.card-left{
    left:0;
}
.card-right{
    right:0;
}
.rtl{
    direction: rtl ;
}
.alumni-text{
    justify-content: center;
    align-items: center ;
}
.masthead{
        min-height: 23vh !important;
        height: 23vh !important;
    }
     .masthead:before{
        min-height: 23vh !important;
        height: 23vh !important;
    }
.alumni-list p {
    margin:unset;
}
</style>

<?php if(isset($_SESSION['login_id'])): ?>
    <!-- Header section -->
    <header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Alumni List</h3>
                <hr class="divider my-4" />
                <!-- Buttons for filtering alumni and students -->
                <button class="btn btn-primary filter-btn" data-filter="alumni">Alumni</button>
                <button class="btn btn-primary filter-btn" data-filter="student">Student</button>
            </div>
        </div>
    </div>
</header>


    <!-- Alumni list section -->
    <div class="container">
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <div class="row">
                <div class="col-md-8">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="filter-field"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search" id="searchInput" aria-label="Search" aria-describedby="filter-field">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-block btn-sm" id="searchButton">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3 pt-2">
    <!-- Alumni list content -->
    <div class="row-items d-flex flex-wrap justify-content-between">
        <?php
        $fpath = 'admin/assets/uploads/';
        $alumni = $conn->query("SELECT a.*, c.course, CONCAT(a.firstname,' ',a.middlename,' ',a.lastname) as name 
        FROM alumnus_bio a 
        INNER JOIN courses c ON c.id = a.course_id 
        WHERE a.status = 1  -- Add this condition to filter verified alumni
        ORDER BY name ASC"); // Sort by name in ascending order
        while($row = $alumni->fetch_assoc()):
        ?>
        <div class="col-md-4 item" style="flex: 0 0 auto;">
            <!-- Wrap each card with anchor tag to redirect to alumni-details page -->
            <a href="index.php?page=alumni-details&gr_no=<?php echo $row['gr_no'] ?>" class="card alumni-list" data-id="<?php echo $row['gr_no'] ?>" data-usertype="<?php echo $row['user_type'] ?>">
                <div class="alumni-img" card-img-top>
                <?php if (empty($row['avatar'])): ?>
                    <img src="http://localhost/project3/alumni/admin/assets/uploads/1602730260_avatar.jpg" class="img-fluid" style="width: 100%; height: auto;" > <!-- Replace icon_user.png with your preferred default icon for users -->
                <?php else: ?>
                    <?php
                    // Construct the file path based on the gr_no
                    $avatar_path = 'admin/assets/uploads/' . $row['gr_no'] . '.' . pathinfo($row['avatar'], PATHINFO_EXTENSION);
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
                <div class="card-body">
                    <div class="row align-items-center h-100">
                        <div class="">
                            <div>
                                <p class="filter-txt"><b><?php echo $row['name'] ?></b></p>
                                <hr class="divider w-100" style="max-width: calc(100%)">
                                <p class="filter-txt">Gr.No.: <b><?php echo $row['gr_no'] ?></b></p>
                                <p class="filter-txt">Email: <b><?php echo $row['email'] ?></b></p>
                                <p class="filter-txt">Course: <b><?php echo $row['course'] ?></b></p>
                                <p class="filter-txt">Batch: <b><?php echo $row['batch'] ?></b></p>
                                <p class="filter-txt">Location: <b><?php echo $row['location'] ?></b></p>
                                <p class="filter-txt">User Type: <b><?php echo $row['user_type'] ?></b></p>
                                <?php if (!empty($row['connected_to'])): ?>
                                    <p class="filter-txt">Company Name: <b><?php echo $row['connected_to'] ?></b></p>
                                <?php endif; ?>
                                <?php if (!empty($row['job_title'])): ?>
                                    <p class="filter-txt">Job Role: <b><?php echo $row['job_title'] ?></b></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <br>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php else: ?>
    <!-- If the user is not logged in, show an alert message -->
    <script>
        alert('You need to login to view alumni details.');
        window.history.back(); // Go back to the previous page
    </script>
<?php endif; ?>

<!-- JavaScript code to handle search functionality -->
<script>
    $(document).ready(function(){
        $('#searchButton').click(function(){
            filterAlumni($('#searchInput').val().toLowerCase());
        });

        $('#searchInput').keyup(function(){
            filterAlumni($(this).val().toLowerCase());
        });

        function filterAlumni(keyword) {
            $('.alumni-list').each(function(){
                var alumniData = $(this).text().toLowerCase();
                if(alumniData.includes(keyword)){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }
    });
    $(document).ready(function(){
        $('.filter-btn').click(function(){
            var filterType = $(this).data('filter');
            filterUsers(filterType);
        });

        function filterUsers(userType) {
            $('.alumni-list').each(function(){
                var userTypeData = $(this).data('usertype');
                if(userTypeData === userType){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }
    });
</script>
