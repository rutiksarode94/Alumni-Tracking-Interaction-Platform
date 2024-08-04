<?php
include('admin/db_connect.php');

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'save_comment') {
    // Retrieve comment and image_id from the POST data
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $image_id = isset($_POST['image_id']) ? $_POST['image_id'] : '';

    // Validate comment and image_id (e.g., check for empty values)

    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (comment, image_id) VALUES (?, ?)");
    $stmt->bind_param("si", $comment, $image_id);
    $result = $stmt->execute();

    if ($result) {
        echo '1'; // Return '1' indicating success
    } else {
        echo '0'; // Return '0' indicating error
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .reactions .like-btn.liked {
    background-color: #dc3545; /* Change to red color */
    color: #fff;
}
.row::after {
    content: "";
    clear: both;
    display: table;
}
        /* Custom CSS styles for enhanced design */
        .gallery-img {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            margin-bottom: 10px;
        }

        .gallery-img img {
            width: 100%;
            height: auto;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        .gallery-description {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 10px;
        }

        .comments {
            margin-top: 10px;
        }

        .comments div {
            margin-bottom: 5px;
        }

        .reactions .like-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reactions .like-btn:hover {
            background-color: #0056b3;
        }
/* Custom CSS styles for enhanced design */
.gallery-img {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    margin-bottom: 10px;
    width: 100%; /* Set width to 100% */
    height: 400px; /* Set height to your desired value */
}

.gallery-img img {
    width: 100%; /* Ensure image fills its container */
    height: 100%; /* Ensure image fills its container */
    object-fit: cover; /* Preserve aspect ratio and cover the container */
}

.gallery-img:hover {
    transform: scale(1.05);
}

.gallery-description {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    padding: 10px;
}

.comments {
    margin-top: 10px;
}

.comments div {
    margin-bottom: 5px;
}

.reactions .like-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.reactions .like-btn:hover {
    background-color: #0056b3;
}

/* Adjust margin-top for the container */
.gallery-container {
    margin-top: 100px; /* Adjust as needed */
}

        /* Adjust margin-top for the container */
        .gallery-container {
            margin-top: 100px; /* Adjust as needed */
        }
    </style>
</head>
<body>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Gallery</h3>
                <hr class="divider my-4" />
                <div class="row col-md-12 mb-2 justify-content-center">
    <button class="btn btn-primary btn-block col-sm-4" type="button" id="new_image"><i class="fa fa-plus"></i> Post a New Image</button>
</div>

<script>
    document.getElementById("new_image").addEventListener("click", function() {
        window.location.href = "index.php?page=manage_gallery";
    });
</script>   
            </div>
            
        </div>
    </div>
</header>
<div class="container mt-3 pt-2">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="filter-field"><i class="fa fa-search"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Filter" id="filter" aria-label="Filter" aria-describedby="filter-field">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btn-block btn-sm" id="search">Search</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-6 gallery-container"> <!-- Add class to adjust margin-top -->
    <div class="row">
        <?php
        $rtl = 'rtl';
        $ci = 0;
        $img = array();
        $fpath = 'admin/assets/uploads/gallery';
        $files = is_dir($fpath) ? scandir($fpath) : array();
        foreach ($files as $val) {
            if (!in_array($val, array('.', '..'))) {
                $n = explode('_', $val);
                $img[$n[0]] = $val;
            }
        }
        $gallery = $conn->query("SELECT * from gallery order by id desc");
        while ($row = $gallery->fetch_assoc()) :
            $ci++;
            if ($ci < 3) {
                $rtl = '';
            } else {
                $rtl = 'rtl';
            }
            if ($ci == 4) {
                $ci = 0;
            }
            ?>
            <div class="col-md-6">
                <div class="card gallery-list <?php echo $rtl ?>" data-id="<?php echo $row['id'] ?>">
                <div class="gallery-img" card-img-top>
                    <h5>Posted by: <?php echo $row['name']; ?></h5>
                        <img src="<?php echo isset($img[$row['id']]) && is_file($fpath . '/' . $img[$row['id']]) ? $fpath . '/' . $img[$row['id']] : '' ?>" alt="">
                        <div class="gallery-description">
                            <?php echo ucwords($row['about']) ?>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <!-- Reaction Section -->
                        <div class="reactions mt-2">
                            <button class="btn btn-sm btn-primary like-btn" data-id="<?php echo $row['id']; ?>">
                                <i class="far fa-heart"></i> <!-- Empty heart icon -->
                                Like
                            </button>
                            <button class="btn btn-sm btn-primary comment-btn" data-id="<?php echo $row['id']; ?>">
                                <i class="far fa-comment"></i> <!-- Comment icon -->
                                Comment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Comment Modal -->
<!-- Comment Modal -->
<div id="commentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="commentForm">
                    <div class="form-group">
                        <label for="comment">Your Comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="image_id" id="comment_image_id">
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
                <!-- Comment Section -->
                <?php
                    // Inside the while loop for displaying images
                    $gallery = $conn->query("SELECT * from gallery order by id desc");
                    while ($row = $gallery->fetch_assoc()) :
                        // Other code remains unchanged

                        // Display container for comments associated with this image
                        echo '<div id="comments_' . $row['id'] . '" class="comments" style="display: none;">';
                        
                        // Fetch and display existing comments for this image in descending order of creation time
                        $comments = $conn->query("SELECT * FROM comments WHERE image_id = '{$row['id']}' ORDER BY created_at DESC");
                        while ($comment_row = $comments->fetch_assoc()) {
                            echo '<div class="row">';
                            echo '<div class="col-md-5"><strong>' . $comment_row['name'] . ':</strong></div>';
                            echo '<div class="col-md-9">' . $comment_row['comment'] . '</div>';
                            echo '</div>';
                        }
                        
                        echo '</div>'; // Close comments container
                    endwhile;
                    ?>
            </div>
        </div>
    </div>
</div>



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
           function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	$('#manage-gallery').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=save_gallery1',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_gallery').click(function(){
		start_load()
		var cat = $('#manage-gallery')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='about']").val($(this).attr('data-about'))
		cat.find("img").attr('src',$(this).attr('data-src'))
		end_load()
	})
	$('.delete_gallery').click(function(){
		_conf("Are you sure to delete this data?","delete_gallery",[$(this).attr('data-id')])
	})
	function delete_gallery($id){
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=delete_gallery1',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}

$(document).ready(function() {
    $(document).ready(function() {
    // Function to handle liking an image
    $('.like-btn').click(function() {
        var imageId = $(this).closest('.card').data('id');
        var likeBtn = $(this);

        // Check if the like button is currently liked
        var isLiked = likeBtn.hasClass('liked');

        // Update the like button's appearance immediately
        if (!isLiked) {
            likeBtn.addClass('liked');
        } else {
            likeBtn.removeClass('liked');
        }

        // Update the like state in local storage
        localStorage.setItem('like_' + imageId, isLiked ? '0' : '1');

        // Send AJAX request to like or unlike the image
        $.ajax({
            url: 'admin/ajax.php?action=save_gallery',
            type: 'POST',
            data: { image_id: imageId, action: isLiked ? 'unlike' : 'like' },
            success: function(response) {
                if (response !== 'error') {
                    // Update the like count displayed on the UI if needed
                    // Optionally, you can update the like count here based on the response from the server
                } else {
                    console.error('Failed to update like status:', response);
                    alert('Failed to update like status');
                    
                    // Revert the like button's appearance if there was an error
                    if (!isLiked) {
                        likeBtn.removeClass('liked');
                    } else {
                        likeBtn.addClass('liked');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating like status:', error);
                alert('Failed to update like status');
                
                // Revert the like button's appearance if there was an error
                if (!isLiked) {
                    likeBtn.removeClass('liked');
                } else {
                    likeBtn.addClass('liked');
                }
            }
        });
    });
    $(document).ready( function () {
        $('table').DataTable();
    });

    // Function to maintain the like button state across page refreshes
    $('.like-btn').each(function() {
        var imageId = $(this).closest('.card').data('id');
        var isLiked = localStorage.getItem('like_' + imageId);

        if (isLiked === '1') {
            // If the image is liked, immediately fill the like button with red color
            $(this).addClass('liked');
        }
    });
});

    // Function to handle search button click
    $('#search').click(function() {
        var searchText = $('#filter').val().toLowerCase();
        $('.gallery-list').each(function() {
            var postedBy = $(this).find('.gallery-img h5').text().toLowerCase();
            var description = $(this).find('.gallery-description').text().toLowerCase();
            if (postedBy.indexOf(searchText) > -1 || description.indexOf(searchText) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
$(document).ready(function() {
    // Function to handle showing the comment modal and setting the image_id
    $('.comment-btn').click(function() {
        var imageId = $(this).closest('.card').data('id');
        $('#comment_image_id').val(imageId); // Set the image_id in the hidden input field
        
        // Hide all comment sections
        $('.comments').hide();
        
        // Show the comment section related to the clicked image
        $('#comments_' + imageId).show();
        
        // Show the comment modal
        $('#commentModal').modal('show'); 
        
        // Optionally, you can also trigger a PHP script to fetch existing comments
        // using PHP instead of AJAX
        // Fetch existing comments for this image from the database and display them using PHP
        // This will be handled when the comment modal is rendered
        
    });
});

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
                
                // Append the new comment to the "Existing Comments" section dynamically
                var commentText = $('#comment').val();
                var commentHtml = '<div class="row">' +
                    '<div class="col-md-5">' +
                    '<strong>' + user_name + ':</strong>' +
                    '</div>' +
                    '<div class="col-md-7">' + commentText + '</div>' +
                    '</div>';
                $('#existingComments').append(commentHtml); // Append the comment to the existing comments section
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

</script>
</body>
</html>
