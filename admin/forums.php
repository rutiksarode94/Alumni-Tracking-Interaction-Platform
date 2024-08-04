<?php 
include 'db_connect.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include your custom CSS stylesheets here -->
    <style>
        /* Add your styles as needed */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        header.masthead {
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
        }

        header.masthead h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        header.masthead hr.divider {
            background-color: #fff;
            height: 2px;
        }

        .container {
            margin-top: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
        }

        .table th, .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            border: 1px solid #28a745;
        }

        body {
            margin-bottom: 2rem;
        }

        /* Add styles for search bar */
        #search-container {
            margin-bottom: 1rem;
        }

        #search-input {
            width: 200px;
        }

        #search-btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <header class="masthead">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end mb-4 page-title">
                    <h3 class="text-white">Admin Chat</h3>
                    <hr class="divider my-4" />
                    <!-- Additional Admin-specific buttons can be added here -->
                    <button class="btn btn-primary filter-btn" data-filter="alumni">Alumni</button>
                    <button class="btn btn-primary filter-btn" data-filter="student">Student</button>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-3 pt-2">
        <!-- Add search container -->
        <div id="search-container" class="input-group mb-3">
            <input type="text" class="form-control" id="search-input" placeholder="Search...">
            <div class="input-group-append">
                <button class="btn btn-primary" id="search-btn">Search</button>
            </div>
        </div>

        <!-- Alumni Table -->
        <table class="table" id="alumni_table">
            <thead>
                <tr>
                    <th>Gr.No.</th>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Company Name</th>
                    <th>Send Message</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $alumni_query = $conn->query("SELECT * FROM alumnus_bio where status=1");
            while ($alumni = $alumni_query->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $alumni['gr_no'] . '</td>';
                echo '<td>' . $alumni['firstname'] . ' ' . $alumni['middlename'] . ' ' . $alumni['lastname'] . '</td>';
  
                // Check if 'batch' key exists before accessing it
                echo '<td>' . (isset($alumni['batch']) ? $alumni['batch'] : '') . '</td>';
                
                // Check if 'currently_connected_to' key exists before accessing it
                echo '<td>' . (isset($alumni['connected_to']) ? $alumni['connected_to'] : '') . '</td>';
                
                echo '<td><button class="btn btn-success send_message" data-id="' . $alumni['id'] . '">Send Message</button></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle the "Send Message" button click
            $('.send_message').click(function() {
                var alumniId = $(this).data('id');
                // Redirect to send_msg.php with the alumni ID as a parameter
                window.location.href = 'send_msg.php?alumni_id=' + alumniId;
            });

            // Function to handle the alumni search
            $('#search-btn').click(function() {
                var searchTerm = $('#search-input').val().toLowerCase();
                $('#alumni_table tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Function to handle filter buttons
            $('.filter-btn').click(function() {
                var filterType = $(this).data('filter');
                $('#alumni_table tbody tr').each(function() {
                    var batch = parseInt($(this).find('td:eq(2)').text());
                    if (filterType === 'alumni' && batch < new Date().getFullYear()) {
                        $(this).show();
                    } else if (filterType === 'student' && batch >= new Date().getFullYear()) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
