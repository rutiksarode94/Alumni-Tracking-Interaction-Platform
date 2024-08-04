<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color:white;
            margin-top: 10px;
            padding: 0;
        }
        .container {
            max-width: auto;
            margin: 2px auto;
            background-color: black;
            color:white;
            padding: 20px;
            border-radius: 8px;
           
        }
        h2 {
            color: white;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
          
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        p.success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Contact Us</h2>
    <div class="contact-info">
        <p>MET League of Colleges | Bhujbal Knowledge City<br>
        Adgaon | Govardhan, Nashik - 422 003 |422 222<br>
        Maharashtra, India<br>
        Mobile: +91 09881100099<br>
        Adgaon Campus Tel: 0253-2303611<br>
        Govardhan Campus Tel: 0253-2200300 , 2200302<br>
        For Hostel Inquiry: +91 9372341038<br>
        Email: enquiries@bkc.met.edu</p>
    </div>
    <h2>Any Message send from here!!!</h2>
    <?php

include('admin/db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert the message into the contact_messages table
    $insertSql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);

    // Bind parameters and execute the statement
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Redirect to the home page after successful submission
    header('Location: index.php?success=true');
    exit();
}
?>



    <form action="" method="post">
        <label for="name">Your Name:</label>
        <input type="text" name="name" required>

        <label for="email">Your Email:</label>
        <input type="email" name="email" required>

        <label for="message">Your Message:</label>
        <textarea name="message" rows="4" required></textarea>

        <button type="submit">Send Message</button>
        <a href="index.php" class="btn btn-secondary btn-sm">Back</a> <!-- Back button -->

    </form>
</div>

</body>
</html>
