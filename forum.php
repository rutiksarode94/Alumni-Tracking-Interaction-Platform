<?php
include 'admin/db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <!-- Include your CSS stylesheets here -->
    <style>
        /* Add your styles as needed */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 1px;
            background-color: #f8f9fa; /* Change background color to a lighter shade */
        }

        header.masthead {
            background-color: #007bff;
            color: white; /* Change text color to white */
            padding: 0.5rem;
        }

        header.masthead h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        header.masthead hr.divider {
            background-color: white; /* Change divider color to white */
            height: 1px;
        }

        .container {
            margin-top: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            color:white;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th, .table td {
            padding: 1rem; /* Increase padding for better spacing */
            border-bottom: 1px solid #dee2e6;
            text-align: center; /* Center-align table content */
        }

        .btn-success {
            background-color: #28a745;
            color: white; /* Change button text color to white */
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
                <h2 class="text-white">Messages</h2>
                <hr class="divider my-4" />
                <button class="btn btn-primary filter-btn" data-filter="alumni">Alumni</button>
                <button class="btn btn-primary filter-btn" data-filter="student">Student</button>
                <!-- Additional Admin-specific buttons can be added here -->
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <!-- Add search container -->
    <div id="search-container" class="input-group mb-3">
        <input type="text" class="form-control" id="search-input" placeholder="Search alumni...">
    </div>

    <!-- Alumni Table -->
    <table class="table" id="alumni_table">
        <thead>
        <tr>
            <th>Gr.No</th>
            <th>Name</th>
            <th>Batch</th>
            <th>Company Name</th>
            <th>Job Role</th>
            <th>User Type</th>
            <th>Send Message</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch alumni data
        $alumni_query = $conn->query("SELECT * FROM alumnus_bio WHERE status=1");

        // Fetch staff data with type=2
        $staff_query = $conn->query("SELECT * FROM users WHERE type=2");

        // Merge alumni and staff data into a single array
        $users = array();
        while ($alumni = $alumni_query->fetch_assoc()) {
            // Check if user_type is set, if not, set it to 'none'
            $alumni['user_type'] = isset($alumni['user_type']) && $alumni['user_type'] !== '' ? $alumni['user_type'] : 'none';
    
            // Add the alumni data to the users array
            $users[] = $alumni;
        }
        while ($staff = $staff_query->fetch_assoc()) {
            // Set default values for batch, company name, and job role for staff members
            $staff['batch'] = $staff['batch'];
            $staff['connected_to'] = 'MET College';
            $staff['job_title'] = 'Teacher';
            $staff['user_type'] = 'Staff'; // Add user type for staff
            $users[] = $staff;
        }

        // Sort the merged array by gr_no
        usort($users, function($a, $b) {
            return $a['gr_no'] <=> $b['gr_no'];
        });

        // Display the merged and sorted users
        foreach ($users as $user) {
            // Check if the user is logged in and skip displaying their row
            if(isset($_SESSION['user']) && $user['gr_no'] == $_SESSION['user']['gr_no']) {
                continue; // Skip this row
            }
            // Check if the user type matches the filter
            if(isset($_GET['filter']) && $_GET['filter'] === 'alumni' && $user['user_type'] !== 'Alumni') {
                continue; // Skip if user type is not alumni
            }
            if(isset($_GET['filter']) && $_GET['filter'] === 'student' && $user['user_type'] !== 'Student') {
                continue; // Skip if user type is not student
            }
            echo '<tr>';
            echo '<td>' . $user['gr_no'] . '</td>';
            // Check if the user is staff or alumni to determine the name column
            if(isset($user['type']) && $user['type'] == 2) {
                // Display staff name from users table
                echo '<td>' . (isset($user['name']) ? $user['name'] : '') . '</td>';
            } else {
                // Display alumni name from alumnus_bio table
                echo '<td>' . (isset($user['firstname']) ? $user['firstname'] : '') . ' ' . (isset($user['middlename']) ? $user['middlename'] : '') . ' ' . (isset($user['lastname']) ? $user['lastname'] : '') . '</td>';
            }
            echo '<td>' . (isset($user['batch']) ? $user['batch'] : '') . '</td>';
            echo '<td>' . (isset($user['connected_to']) && $user['connected_to'] !== '' ? $user['connected_to'] : 'Student') . '</td>';
            echo '<td>' . (isset($user['job_title']) && $user['job_title'] !== '' ? $user['job_title'] : 'None') . '</td>';
            echo '<td>' . (isset($user['user_type']) ? $user['user_type'] : '') . '</td>';
            echo '<td><button class="btn btn-success send_message" data-id="' . $user['gr_no'] . '">Send Message</button></td>';
            echo '</tr>';
        }

        ?>

        </tbody>
    </table>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the search input element
        var searchInput = document.getElementById('search-input');

        // Add an event listener for input changes
        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toUpperCase();
            var tableRows = document.getElementById('alumni_table').getElementsByTagName('tr');

            // Loop through all table rows
            for (var i = 0; i < tableRows.length; i++) {
                var display = false;
                // Loop through all table data cells in the row
                for (var j = 0; j < tableRows[i].cells.length; j++) {
                    var tableData = tableRows[i].cells[j];
                    // If tableData exists and matches the search input, set display to true
                    if (tableData) {
                        var textValue = tableData.textContent || tableData.innerText;
                        if (textValue.toUpperCase().indexOf(filter) > -1) {
                            display = true;
                            break; // No need to check further once a match is found
                        }
                    }
                }
                // Display or hide the row based on the result of the search
                tableRows[i].style.display = display ? '' : 'none';
            }
        });
    });
    $(document).ready(function() {
        $('.filter-btn').click(function() {
            var filterType = $(this).data('filter');
            $('#alumni_table tbody tr').each(function() {
                var userType = $(this).find('td:eq(5)').text().trim(); // 6th column is the user type
                if (filterType === 'alumni' && userType === 'Alumni') {
                    $(this).show();
                } else if (filterType === 'student' && userType === 'Student') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Function to handle the "Send Message" button click
        $('.send_message').click(function() {
            var alumniId = $(this).data('id');
            // Redirect to send_msg.php page with alumni ID as parameter
            window.location.href = 'send_msg.php?gr_no=' + alumniId;
        });
    });
</script>
</body>
</html>
