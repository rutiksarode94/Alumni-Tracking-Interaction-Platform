<?php
// Include database connection or any necessary files
include 'admin/db_connect.php';

// Start session (if needed)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Alumni Tracking and Interaction Platform</title>
   
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1;
    background-color: black;
    margin: 30;
    padding: 0;
}

.container {
    max-width: 960px;
    margin: 10;
    padding: 0 15px;
}

.section-title {
    text-align: center;
    color: #333;
}

.section-content {
    margin-top: 30px;
}

/* About Section */
#about {
    padding: 50px 0;
}

#about .section-content {
    background: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#about ul {
    list-style-type: none;
    padding-left: 0;
}

#about ul li {
    margin-bottom: 10px;
}

#about ul li strong {
    color: black;
}

/* Footer */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

footer p {
    margin: 0;
}

/* Header */
header {
    background-color: #333;
    color: black;
    padding: 10px ;
    text-align: center;
}

header h1 {
    margin: 10;
}

header nav ul {
    list-style-type: none;
    padding: 20;
}

header nav ul li {
    display: inline;
    margin-right: 20px;
}

header nav ul li a {
    color: #fff;
    text-decoration: none;
}

header nav ul li a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .container {
        padding:  10px;
    }

    #about .section-content {
        padding: 20px;
    }
}

    </style>
</head>
<body>
   
    <?php include 'header.php'; ?>

   
    <section id="about">
        <div class="container">
            <h2 class="section-title">About Us</h2>
            <div class="section-content">
                <p>Welcome to our Alumni Tracking and Interaction Platform! Our platform is designed to connect alumni with their alma mater and fellow graduates, facilitating networking, mentorship, and collaboration opportunities. Here's what you can expect from our platform:</p>
                <ul>
                    <li><strong>Alumni Profiles:</strong> Create and manage your alumni profile, showcasing your education, professional experience, and skills.</li>
                    <li><strong>Networking:</strong> Connect with fellow alumni based on shared interests, industries, or geographic locations.</li>
                    <li><strong>Events:</strong> Stay updated on alumni events, reunions, workshops, and professional development opportunities.</li>
                    <li><strong>Job Opportunities:</strong> Explore job listings and career opportunities shared by alumni and partner organizations.</li>
                    <li><strong>Mentorship:</strong> Offer mentorship to current students or seek guidance from experienced alumni in your field.</li>
                    <li><strong>News and Updates:</strong> Receive updates on alumni achievements, institution news, and relevant industry trends.</li>
                </ul>
                <p>Our platform aims to foster a vibrant community of alumni committed to lifelong learning, professional growth, and giving back to their alma mater. Join us today and become part of our global alumni network!</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>

    <!-- Include your JavaScript files here -->
    <script src="js/script.js"></script>
</body>
</html>
