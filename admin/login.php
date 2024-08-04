<?php 
include('./header.php');
 // Start the session to access session variables

// Check if $_SESSION['system']['name'] is set before echoing it
$system_name = isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : 'Alumni Tracking & Interaction Platform Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $system_name; ?></title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background: url('http://localhost/project3/alumni/img/222.jpeg') no-repeat center center fixed;
        background-size: cover;
    }
    main#main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .card {
        width: 25%;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
    }
    #login-form label {
        display: block;
        margin-bottom: 5px;
    }
    #login-form input[type="text"],
    #login-form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .forgot-password-link {
    display: flex;
    justify-content: center;
}

    #login-form button {
        width: 100%;
        background-color: #007bff;
        color: black;
        border: none;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    #login-form button:hover {
        background-color: #0056b3;
    }
</style>
<body>
<main id="main">
    <div class="card">
        <div class="card-body">
        <h2>Admin Login</h2>
            <form id="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="forgot-password-link">
            <small><a href="forgot-pass.php" id="forgot-pass">Forgot Password?</a></small>
        </div>
    </div>
</main>
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
<script>
    $('#login-form').submit(function(e){
        e.preventDefault();
        $('#login-form button').attr('disabled', true).html('Logging in...');
        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response == 1) {
                        // Store gr_no and name in session
                        sessionStorage.setItem('gr_no', response.gr_no);
                        sessionStorage.setItem('name', response.name);

                        // Redirect to home page or perform any other action
                        window.location.href = 'index.php?page=home';
                    } else {
                    // Display error message or handle unsuccessful login
                    $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
                    $('#login-form button').removeAttr('disabled').html('Login');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while processing your request. Please try again.');
                $('#login-form button').removeAttr('disabled').html('Login');
            }
        });
    });
</script>
</body>
</html>
