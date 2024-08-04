<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Comment Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for enhanced design */
        .gallery-img {
            position: relative;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            height: 300px; /* Fixed height for the image */
        }

        .gallery-img img {
            width: 100%;
            height: 100%; /* Fill the container */
            object-fit: cover;
        }

        .comment-form {
            margin-bottom: 20px;
        }

        .comments {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Fetch and display image and user name -->
                <?php
                // Include database connection file
                include 'admin/db_connect.php';

                // Get image_id from URL parameter
                $image_id = isset($_GET['image_id']) ? $_GET['image_id'] : 0;

                // Query to fetch image path and user name based on image_id from gallery table
                $query = "SELECT id AS image_path, name, gr_no FROM gallery WHERE id = '$image_id'";
                $result = mysqli_query($conn, $query);

                if ($row = mysqli_fetch_assoc($result)) {
                    $image_path = $row['image_path'];
                    $name = $row['name'];
                ?>
                <!-- Display image and user name -->
                <div class="gallery-img mb-3">
                    <div class="user-name">
                        <h4><?php echo $name; ?></h4>
                    </div>
                    <img src="<?php echo 'admin/assets/uploads/gallery/' . $image_path; ?>" alt="Gallery Image">
                </div>
                <?php } else {
                    echo "<p>Image not found</p>";
                }
                ?>

                <!-- Comment form -->
                <div class="comment-form">
                    <form id="commentForm">
                        <div class="form-group">
                            <label for="comment">Your Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="2" required></textarea>
                        </div>
                        <input type="hidden" name="image_id" id="image_id" value="<?php echo $image_id; ?>">
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                </div>

                <!-- Existing comments section -->
                <div class="comments" id="comments">
                    <!-- Display existing comments here -->
                    <?php
                            // Fetch comments for each image from the database and display them
                            $comments = $conn->query("SELECT * FROM comments WHERE image_id = {$row['id']} ORDER BY id DESC");
                            while ($comment = $comments->fetch_assoc()) :
                            ?>
                            <div><?php echo $comment['comment']; ?></div>
                            <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JavaScript -->
  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Load existing comments on page load
            loadComments();

            // Handle form submission
            $('.comment-btn').click(function() {
    var imageId = $(this).closest('.card').data('id');
    $('#comment_image_id').val(imageId); // Set the image_id in the hidden input field
    $('#commentModal').modal('show'); // Show the comment modal
});

// Function to handle posting a comment
// Function to handle posting a comment
$('#commentForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize(); // Serialize the form data
    var imageId = $('#comment_image_id').val(); // Get the image_id associated with the comment

    // Send AJAX request to save comment
    $.ajax({
        url: 'admin/ajax.php?action=save_comment', // Adjust the URL according to your file structure
        type: 'POST',
        data: { comment: formData, image_id: imageId }, // Pass the image_id along with the comment data
        success: function(response) {
            response = response.trim(); // Trim whitespace
            if (response === '1') { // Check if the response is '1' indicating success
                alert('Comment posted successfully');
                $('#commentModal').modal('hide'); // Hide the comment modal
                // Optionally, you can refresh the page or update the comments section dynamically
                // as per your requirement
            } else {
                console.error('Failed to post comment:', response);
                alert('Failed to post comment');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error posting comment:', error);
            alert('Failed to post comment');
        }
    });

        });
    });
    </script>
</body>
</html>
