<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    include('admin/db_connect.php');
    ob_start();
        $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
         foreach ($query as $key => $value) {
          if(!is_numeric($key))
            $_SESSION['system'][$key] = $value;
        }
    ob_end_flush();
    include('header.php');
    
    ?>

    <style>
      
    /* Style the label for the radio buttons */
    .modal-body label {
        display: inline-block;
        padding: 10px 10px; /* Adjust padding as needed */
        margin: 3px; /* Adjust margin as needed */
        font-size: 18px;
        background-color: white; /* Background color for unselected state */
        color: black; /* Text color for unselected state */
        border: 2px solid white; /* Border color for unselected state */
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style the label when radio button is checked */
    .modal-body input[type="radio"]:checked + label {
        background-color: white; /* Background color for selected state */
        color: white; /* Text color for selected state */
        border-color: black; /* Border color for selected state */
    }
    	header.masthead {
		  background: url(admin/assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
		  background-repeat: no-repeat;
		  background-size: cover;
		}
    
  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
}
#viewer_modal .modal-dialog {
        width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
}
  #viewer_modal .modal-content {
       background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #viewer_modal img,#viewer_modal video{
    max-height: calc(100%);
    max-width: calc(100%);
  }
  body, footer {
    background: #000000e6 !important;
}
 

a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding:5px
}/*
a.jqte_tool_label.unselectable {
    height: 22px !important;
}*/
.user-initials {
    width: 32px; /* Adjust the size as needed */
    height: 32px; /* Adjust the size as needed */
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: blue; /* Background color for the circle */
    color: white; /* Text color for the initial */
    font-weight: bold;
}


    </style>
    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white toast-right">
        </div>
      </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-1" id="mainNav">
            <div class="container">
            <li class="nav-item">
            <a class="nav-link js-scroll-trigger text-white" href="./">
    <i class="nav-item"></i>
    <?php 
// Check if the user is logged in
if(isset($_SESSION['login_id'])) {
    // If logged in, display "Welcome Back, [User Name]" in blue
    echo '<span style="color: blue; font-weight: bold; font-style: italic; font-size: 20px;">Welcome, ' . $_SESSION['login_name'] . '</span>';
} else {
    // If not logged in, display the system name in white
    echo '<span style="color: white; font-weight: bold; font-style: italic; font-size: 20px;">' . $_SESSION['system']['name'] . '</span>';
}
?>

</a>

</li>



<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./"><i class="fas fa-home"></i> Home</a></li>
     <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=alumni_list"><i class="fas fa-user-graduate"></i> <span class="icon-name">Alumni</span></a></li>
     <li class="nav-item">
    <a class="nav-link js-scroll-trigger" href="#" onclick="checkLogin('index.php?page=gallery')">
        <i class="fas fa-image"></i> <span class="icon-name">Gallery</span>
    </a>
</li>
 <?php if(isset($_SESSION['login_id'])): ?>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=careers"><i class="fas fa-briefcase"></i> <span class="icon-name">Jobs</span></a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum"><i class="fas fa-comments"></i> <span class="icon-name">Chat</span></a></li>
    <?php endif; ?>
    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about"><i class="fas fa-info-circle"></i> <span class="icon-name">About</span></a></li>
    <?php


if (isset($_SESSION['login_id'])) {
    // Fetch and display notifications for the logged-in user
    $user_id = $_SESSION['login_id'];
    $notification_query = $conn->query("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY timestamp DESC");

    echo '<li class="nav-item dropdown">';
    echo '<a href="#" class="nav-link js-scroll-trigger dropdown-toggle" id="notificationsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"></i> <span class="icon-name">Notifications</span> <span class="badge badge-danger">' . $notification_query->num_rows . '</span></a>';
    echo '<div class="dropdown-menu" aria-labelledby="notificationsDropdown">';

    while ($notification = $notification_query->fetch_assoc()) {
        echo '<a class="dropdown-item" href="check_notifications.php"><i class="fas fa-bell"></i> ' . $notification['message'] . '</a>';
    }

    echo '</div>';
    echo '</li>';
}
?>


    <?php if(!isset($_SESSION['login_id'])): ?>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#" id="login"><i class="fas fa-sign-in-alt"></i> <span class="icon-name">Login</span></a></li>
    <?php else: ?>
      <li class="nav-item">
    <div class="dropdown mr-4">
        <a href="#" class="nav-link js-scroll-trigger dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if(isset($_SESSION['login_name'])): ?>
                <div class="user-initials"><?php echo strtoupper(substr($_SESSION['login_name'], 0, 1)); ?></div>
            <?php else: ?>
                User
            <?php endif; ?>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
        <a class="dropdown-item" href="index.php?page=view_profile"><i class="fas fa-user"></i> View Profile</a>
            <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i class="fas fa-cog"></i> <span class="icon-name">Manage Account</span></a>
            <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fas fa-power-off"></i> <span class="icon-name">Logout</span></a>
        </div>
    </div>
</li>

    <?php endif; ?>
</ul>

                </div>
            </div>
        </nav>
       
        <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>
       

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-righ t"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  <div id="preloader"></div>
        <footer class=" py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0 text-white">Contact us</h2>
                        <hr class="divider my-4" />
                    </div>
                </div>
                <div class="row">
                <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                    <i class="fas fa-phone fa-3x mb-3 text-muted" style="transform: rotate(90deg);"></i>
                    <a class="d-block" href="contactus.php">Contact</a>
                </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!-->
                        <a class="d-block" href="mailto:<?php echo $_SESSION['system']['email'] ?>">Mail</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="container"><div class="small text-center text-muted">Copyright © 2024 - <?php echo $_SESSION['system']['name'] ?> | <a href="https://metbhujbalknowledgecity.ac.in/" target="_blank">METBKCIOE</a></div></div>
           </footer>
        
       <?php include('footer.php') ?>
    </body>
    <script type="text/javascript">
      $('#login').click(function(){
        $('#login_option_modal').modal('show'); // Show the login option modal
      });

      // When the user selects an option and clicks "Proceed", redirect to the respective login page
      $('#login_option_modal .btn-proceed').click(function() {
        var loginOption = $("input[name='login_option']:checked").val();
        if (loginOption == 'alumni') {
          window.location.href = 'alumni_login.php';
        } else if (loginOption == 'staff') {
          window.location.href = 'staff_login.php';
        }
      });
    </script>
    
    <!-- Login Option Modal -->
    <div class="modal fade" id="login_option_modal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label><input type="radio" name="login_option" value="alumni"> Alumni</label>
            </div>
            <div class="form-group">
              <label><input type="radio" name="login_option" value="student"> Student</label>
            </div>
            <div class="form-group">
              <label><input type="radio" name="login_option" value="staff"> Staff</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-proceed">Login</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
          </div>
        </div>
      </div>
    </div>
<!-- Add this JavaScript code after your modal HTML code -->
<script>
    $(document).ready(function() {
        // Add a click event listener to the "Proceed" button
        $('.btn-proceed').click(function() {
            // Get the value of the selected radio button
            var loginOption = $('input[name="login_option"]:checked').val();

            // Check which option is selected and redirect accordingly
            if (loginOption === "alumni") {
                // Redirect to alumni_login.php
                window.location.href = 'alumni_login.php';
            } else if (loginOption === "staff") {
                // Redirect to staff_login.php
                window.location.href = 'staff_login.php';
            }
            else if (loginOption === "student") {
                // Redirect to student_login.php
                window.location.href = 'student_login.php';
            } else {
                // Show an alert if no option is selected
                alert('Please select a login option.');
            }
        });
    });
    function checkLogin(url) {
        // Check if the user is logged in
        <?php if(isset($_SESSION['login_id'])): ?>
            // If logged in, redirect to the gallery page
            window.location.href = url;
        <?php else: ?>
            // If not logged in, display an alert message
            alert('You need to login first.');
        <?php endif; ?>
    }
</script>

</html>
