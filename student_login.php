<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        .input-wrapper {
            display: inline-block;
            width: 45%;
            margin: 0 2.5%;
            text-align: right;
        }

        .button {
            margin-top: 15px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: .75rem 1.25rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            margin-bottom: 15px;
        }

        /* Custom font style */
        body {
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            color: #555;
            font-size: 16px;
        }

        .password-wrapper {
            position: relative;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"].password-visible {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        button.btn-info,
        a.btn-secondary {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
        }

        button.btn-info {
            background-color: #007bff;
        }

        a.btn-secondary {
            background-color: #6c757d;
        }

        button.btn-info:hover,
        a.btn-secondary:hover {
            opacity: 0.8;
        }

        small a {
            color: #007bff;
            text-decoration: none;
        }

        small a:hover {
            text-decoration: underline;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('http://localhost/project2/alumni/img/222.jpeg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container-fluid {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .button {
            margin-top: 15px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: .75rem 1.25rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h2>Student Login</h2>
        <form action="" id="login-frm">
            <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input type="email" name="username" required="" class="form-control">
            </div>
            <div class="form-group password-wrapper">
                <label for="" class="control-label">Password</label>
                <input type="password" name="password" required="" class="form-control" id="password">
                <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
            </div>
            <div>
                <button class="button btn btn-info btn-sm">Login</button>
                <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
             </div>
             <p><a href="index.php?page=student_signup" id="new_account">Create New Account</a></p>
             <div>
             <small><a href="forgotpass-student.php" id="forgot-pass">Forgot Password?</a></small>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#login-frm').submit(function (e) {
            e.preventDefault();
            $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');

            if ($(this).find('.alert-danger').length > 0)
                $(this).find('.alert-danger').remove();

            $.ajax({
                url: 'admin/ajax.php?action=login4',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err);
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                },
                success: function (resp) {
                    if (resp == 1) {
                        location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                    } else if (resp == 2) {
                        $('#login-frm').prepend('<div class="alert alert-danger">Your account is not yet verified.</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    } else {
                        $('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordInput.classList.add('password-visible');
                passwordToggle.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                passwordInput.classList.remove('password-visible');
                passwordToggle.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
