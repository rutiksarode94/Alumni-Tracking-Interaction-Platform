<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}
	function login(){
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			$user_data = $qry->fetch_array();
			foreach ($user_data as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// Add gr_no and name to session
			$_SESSION['login_gr_no'] = $user_data['gr_no'];
			$_SESSION['login_name'] = $user_data['name'];
			
			if($_SESSION['login_type'] != 1){
				// If the user is not an admin, clear session and return 2 (non-admin user)
				session_unset();
				session_destroy();
				return 2;
			}
			return 1;
		} else {
			// If login fails, clear session and return 3 (incorrect username or password)
			session_unset();
			session_destroy();
			return 3;
		}
	}
	
	
	function login2() {
		extract($_POST);
		if(isset($email))
			$username = $email;
		$qry = $this->db->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".md5($password)."' ");
		if($qry->num_rows > 0) {
			$user_data = $qry->fetch_array();
			// Check if user type is student
			if ($user_data['user_type'] === 'alumni') {
				foreach ($user_data as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				// Set login_name in session
				$_SESSION['login_name'] = $user_data['name']; // Assuming the name is stored in $user_data['name']
	
				if($_SESSION['login_alumnus_id'] > 0) {
					$bio = $this->db->query("SELECT * FROM alumnus_bio WHERE id = ".$_SESSION['login_alumnus_id']);
					if($bio->num_rows > 0) {
						foreach ($bio->fetch_array() as $key => $value) {
							if($key != 'password' && !is_numeric($key))
								$_SESSION['bio'][$key] = $value;
						}
					}
				}
				if($_SESSION['bio']['status'] != 1) {
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2;
					exit;
				}
				return 1; // Login successful
			} else {
				return "You are not a student."; // User is not a student
			}
		} else {
			return "Incorrect username or password.";
		}
	}

function login3() {
    extract($_POST);
    if(isset($email))
        $username = $email;
    $qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' and type = 2");
    if($qry->num_rows > 0) {
        $user_data = $qry->fetch_array();
        foreach ($user_data as $key => $value) {
            if($key != 'password' && !is_numeric($key))
                $_SESSION['login_'.$key] = $value;
        }
        // Set login_name in session
        $_SESSION['login_name'] = $user_data['name']; // Assuming the name is stored in $user_data['name']

        // Add additional logic for staff login if needed

        return 1;
    } else {
        return 3; // Invalid credentials
    }
}
function login4() {
    extract($_POST);
    if(isset($email))
        $username = $email;
    $qry = $this->db->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".md5($password)."' ");
    if($qry->num_rows > 0) {
        $user_data = $qry->fetch_array();
        // Check if user type is student
        if ($user_data['user_type'] === 'student') {
            foreach ($user_data as $key => $value) {
                if($key != 'password' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            // Set login_name in session
            $_SESSION['login_name'] = $user_data['name']; // Assuming the name is stored in $user_data['name']

            if($_SESSION['login_alumnus_id'] > 0) {
                $bio = $this->db->query("SELECT * FROM alumnus_bio WHERE id = ".$_SESSION['login_alumnus_id']);
                if($bio->num_rows > 0) {
                    foreach ($bio->fetch_array() as $key => $value) {
                        if($key != 'password' && !is_numeric($key))
                            $_SESSION['bio'][$key] = $value;
                    }
                }
            }
            if($_SESSION['bio']['status'] != 1) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2;
                exit;
            }
            return 1; // Login successful
        } else {
            return "You are not a student."; // User is not a student
        }
    } else {
        return "Incorrect username or password.";
    }
}

	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if($type == 1)
			$establishment_id = 0;
		$data .= ", establishment_id = '$establishment_id' ";
		$data .= ", job_title = '$job_title' ";
		$data .= ", location = '$location' ";
		$data .= ", contact = '$contact' ";
		$data .= ", current_year = '$current_year' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users WHERE id = $id");
		if($delete){
			return 1; // Return success status
		} else {
			return 0; // Return failure status
		}
	}
	function delete_alumni(){
		extract($_POST);
		
		// First, delete from the alumnus_bio table
		$delete_bio = $this->db->query("DELETE FROM alumnus_bio WHERE id = $id");
	
		// Then, if deletion from alumnus_bio table was successful, proceed to delete from the users table
		if($delete_bio){
			$delete_user = $this->db->query("DELETE FROM users WHERE alumnus_id = $id");
			
			if($delete_user){
				return 1; // Return success status
			} else {
				return 0; // Return failure status for deletion from users table
			}
		} else {
			return 0; // Return failure status for deletion from alumnus_bio table
		}
	}
	
	function signup(){
		extract($_POST);
		$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
		$data = " name = '$firstname $lastname' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", gr_no = '$gr_no' ";
		$data .= ", job_title = '$job_title' ";
		$data .= ", location = '$location' ";
		$data .= ", contact = '$contact' ";
		$data .= ", current_year = '$current_year' ";
		$data .= ", user_type = '$user_type' "; // Store user_type in users table
		$data .= ", batch = '$batch' ";
		$data .= ", gender = '$gender' ";
		$data .= ", connected_to = '$connected_to' ";
		$data .= ", course_id = '$course_id' ";
	
		// Check if email already exists
		$chk_email = $this->db->query("SELECT * FROM users WHERE username = '$email' ")->num_rows;
		if($chk_email > 0){
			return json_encode(array("status" => "error", "message" => "Email already exists"));
			exit;
		}
	
		// Check if GR number already exists
		$chk_gr_no = $this->db->query("SELECT * FROM users WHERE gr_no = '$gr_no' ")->num_rows;
		if($chk_gr_no > 0){
			return json_encode(array("status" => "error", "message" => "Gr no already exists"));
			exit;
		}
		// Insert user data into users table
		$save = $this->db->query("INSERT INTO users SET ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password' || $k == 'gr_no' || $k == 'job_title' || $k == 'location' || $k == 'contact' || $k == 'current_year')
					continue;
	
				if(empty($data) && !is_numeric($k))
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
	
			// Handle file upload and store file path in database
			if(isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK){
				// Specify the directory path where you want to store the images
				$upload_dir = 'assets/uploads/';
				// Generate a unique file name based on gr_no and original file extension
				$fname = $gr_no . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				// Move the uploaded file to the specified directory
				$move = move_uploaded_file($_FILES['img']['tmp_name'], $upload_dir . $fname);
				if($move){
					// Store file path in database
					$data .= ", avatar = '$upload_dir$fname'";
				} else {
					return json_encode(array("status" => "error", "message" => "Error uploading image"));
				}
			}
	
	
			// Update user data with image path
			$update_user = $this->db->query("UPDATE users SET avatar = '$fname' WHERE id = $uid");
	
			// Insert data into alumnus_bio table
			$data .= ", job_title = '$job_title' ";
			$data .= ", location = '$location' ";
			$data .= ", contact = '$contact' ";
			$data .= ", current_year = '$current_year' ";
			$data .= ", gr_no = '$gr_no' ";
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio SET $data ");
	
			if($save_alumni){
				$aid = $this->db->insert_id;
				$data_alumnus = '';
				$data_alumnus .= ", job_title = '$job_title' ";
				$data_alumnus .= ", location = '$location' ";
				$data_alumnus .= ", contact = '$contact' ";
				$data_alumnus .= ", current_year = '$current_year' ";
				$data_alumnus .= ", gr_no = '$gr_no' ";
				$data_alumnus .= ", user_type = '$user_type' "; // Store user_type in alumnus_bio table
				$this->db->query("UPDATE users SET alumnus_id = $aid WHERE id = $uid ");
	
				// Send email notification
				$email_subject = "Signup Confirmation";
				$email_message = "Dear $firstname $lastname, <br><br>";
				$email_message .= "Thank you for signing up!<br><br>";
				$email_message .= "Your account has been created successfully.<br><br>";
				$email_message .= "You can login now.<br><br>";
				$email_message .= "Best regards,<br><br>";
				$email_message .= "Your Website Team";
	
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: rutiksarode94@gmail.com\r\n";
	
				// Send email
				$email_result = mail($email, $email_subject, $email_message, $headers);
	
				// Check if email is sent successfully
				if ($email_result) {
					// Automatically verify the account
					$verification_status = 1; // 1 for verified
					$update_verification = $this->db->query("UPDATE alumnus_bio SET status = $verification_status WHERE id = $aid");
	
					if ($update_verification) {
						// Email sent successfully, return success response
						return json_encode(array("status" => "success", "message" => "Account created successfully. Email sent. Account verified."));
					} else {
						// Email sent successfully but failed to update verification status, return error response
						return json_encode(array("status" => "error", "message" => "Failed to update account verification status."));
					}
				} else {
					// Email sending failed, return error response
					return json_encode(array("status" => "error", "message" => "Failed to send email"));
				}
			} else {
				return json_encode(array("status" => "error", "message" => "Alumni bio save error"));
			}
		} else {
			return json_encode(array("status" => "error", "message" => "User save error"));
		}
		return json_encode(array("status" => "error", "message" => "Unknown error"));
	}
	

	function student_signup(){
		extract($_POST);
		$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
		$data = " name = '$firstname $lastname' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", gr_no = '$gr_no' ";
		$data .= ", job_title = '$job_title' ";
		$data .= ", location = '$location' ";
		$data .= ", contact = '$contact' ";
		$data .= ", current_year = '$current_year' ";
		$data .= ", user_type = '$user_type' "; // Store user_type in users table
		$data .= ", batch = '$batch' ";
		$data .= ", gender = '$gender' ";
		$data .= ", connected_to = '$connected_to' ";
		$data .= ", course_id = '$course_id' ";
	
		// Check if email already exists
		$chk_email = $this->db->query("SELECT * FROM users WHERE username = '$email' ")->num_rows;
		if($chk_email > 0){
			return json_encode(array("status" => "error", "message" => "Email already exists"));
			exit;
		}
	
		// Check if GR number already exists
		$chk_gr_no = $this->db->query("SELECT * FROM users WHERE gr_no = '$gr_no' ")->num_rows;
		if($chk_gr_no > 0){
			return json_encode(array("status" => "error", "message" => "Gr no already exists"));
			exit;
		}
		// Insert user data into users table
		$save = $this->db->query("INSERT INTO users SET ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password' || $k == 'gr_no' || $k == 'job_title' || $k == 'location' || $k == 'contact' || $k == 'current_year')
					continue;
	
				if(empty($data) && !is_numeric($k))
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
	
			// Handle file upload and store file path in database
			if(isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK){
				// Specify the directory path where you want to store the images
				$upload_dir = 'assets/uploads/';
				// Generate a unique file name based on gr_no and original file extension
				$fname = $gr_no . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				// Move the uploaded file to the specified directory
				$move = move_uploaded_file($_FILES['img']['tmp_name'], $upload_dir . $fname);
				if($move){
					// Store file path in database
					$data .= ", avatar = '$upload_dir$fname'";
				} else {
					return json_encode(array("status" => "error", "message" => "Error uploading image"));
				}
			}
	
	
			// Update user data with image path
			$update_user = $this->db->query("UPDATE users SET avatar = '$fname' WHERE id = $uid");
	
			// Insert data into alumnus_bio table
			$data .= ", job_title = '$job_title' ";
			$data .= ", location = '$location' ";
			$data .= ", contact = '$contact' ";
			$data .= ", current_year = '$current_year' ";
			$data .= ", gr_no = '$gr_no' ";
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio SET $data ");
	
			if($save_alumni){
				$aid = $this->db->insert_id;
				$data_alumnus = '';
				$data_alumnus .= ", job_title = '$job_title' ";
				$data_alumnus .= ", location = '$location' ";
				$data_alumnus .= ", contact = '$contact' ";
				$data_alumnus .= ", current_year = '$current_year' ";
				$data_alumnus .= ", gr_no = '$gr_no' ";
				$data_alumnus .= ", user_type = '$user_type' "; // Store user_type in alumnus_bio table
				$this->db->query("UPDATE users SET alumnus_id = $aid WHERE id = $uid ");
	
				// Send email notification
				$email_subject = "Signup Confirmation";
				$email_message = "Dear $firstname $lastname, <br><br>";
				$email_message .= "Thank you for signing up!<br><br>";
				$email_message .= "Your account has been created successfully.<br><br>";
				$email_message .= "You can login now.<br><br>";
				$email_message .= "Best regards,<br><br>";
				$email_message .= "Your Website Team";
	
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: rutiksarode94@gmail.com\r\n";
	
				// Send email
				$email_result = mail($email, $email_subject, $email_message, $headers);
	
				// Check if email is sent successfully
				if ($email_result) {
					// Automatically verify the account
					$verification_status = 1; // 1 for verified
					$update_verification = $this->db->query("UPDATE alumnus_bio SET status = $verification_status WHERE id = $aid");
	
					if ($update_verification) {
						// Email sent successfully, return success response
						return json_encode(array("status" => "success", "message" => "Account created successfully. Email sent. Account verified."));
					} else {
						// Email sent successfully but failed to update verification status, return error response
						return json_encode(array("status" => "error", "message" => "Failed to update account verification status."));
					}
				} else {
					// Email sending failed, return error response
					return json_encode(array("status" => "error", "message" => "Failed to send email"));
				}
			} else {
				return json_encode(array("status" => "error", "message" => "Alumni bio save error"));
			}
		} else {
			return json_encode(array("status" => "error", "message" => "User save error"));
		}
		return json_encode(array("status" => "error", "message" => "Unknown error"));
	}

	
	function check_gr_no($grNo) {
    include 'db_connect2.php';

    // Check if the database connection is available
    if (!$conn2) {
        // Handle the case where the database connection is not available
        return false;
    }

    // Prepare the SQL query
    $query = "SELECT * FROM student WHERE gr_no = ?";

    // Prepare and execute the statement
    $stmt = $conn2->prepare($query);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        // Handle the case where the statement preparation failed
        return false;
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("s", $grNo);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // GR number exists and user is alumni
        return true;
    } else {
        // GR number does not exist or user is not alumni
        return false;
    }
}

	
	function fetch_user_data($gr_no) {
		// Assuming $conn2 is your database connection
		include 'db_connect2.php';
		// Prepare the SQL query to fetch user data
		$stmt = $conn2->prepare("SELECT * FROM student WHERE gr_no = ?");
		$stmt->bind_param("s", $gr_no);
		$stmt->execute();
		$result = $stmt->get_result();
	
		// Check if any rows were returned
		if ($result->num_rows > 0) {
			// Fetch user data as an associative array
			$user_data = $result->fetch_assoc();
			// Encode user data as JSON and return
			return json_encode($user_data);
		} else {
			// If no user found, return empty JSON object
			return json_encode([]);
		}
	}	
	
	function update_account() {
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", location = '$location' ";
		$data .= ", job_title = '$job_title' ";
		$data .= ", contact = '$contact' ";
		

    if (!empty($password))
        $data .= ", password = '".md5($password)."' ";

    $chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;

    if ($chk > 0) {
        // Email already exists in the database
        return 'email_exist';
        exit;
    }

	$save = $this->db->query("UPDATE users SET $data WHERE id = '{$_SESSION['login_id']}' ");

    if ($save) {
        // Update session with new email if it has been changed
        $_SESSION['bio']['email'] = $email;

        $data = '';

        foreach($_POST as $k => $v) {
            if($k == 'password')
                continue;

            if(empty($data) && !is_numeric($k))
                $data = " $k = '$v' ";
            else
                $data .= ", $k = '$v' ";
        }

        if ($_FILES['img']['tmp_name'] != '') {
            $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
            $move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/'. $fname);
            $data .= ", avatar = '$fname' ";
        }

        $save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");

        if ($data) {
            // Perform login
            $login = $this->login2();

            // Return success message
            return 'success';
        }
    }
}

	
function save_settings(){
    extract($_POST);
    $data = " name = '".str_replace("'","&#x2019;",$name)."' ";
    $data .= ", email = '$email' ";
    $data .= ", contact = '$contact' ";
    $data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
    if($_FILES['img']['tmp_name'] != ''){
        $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
        $move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
        $data .= ", cover_img = '$fname' ";
    }
    
    // Check if password change is requested
    if (!empty($new_password) && !empty($confirm_password)) {
        if ($new_password == $confirm_password) {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $data .= ", admin_password = '$hashedPassword' ";
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Passwords do not match.'));
            exit;
        }
    }

    // Update the system name specifically
    $data .= ", name = '".str_replace("'","&#x2019;",$system_name)."' ";

    // Check if system settings already exist
    $chk = $this->db->query("SELECT * FROM system_settings");
    if($chk->num_rows > 0){
        // If system settings exist, update them
        $save = $this->db->query("UPDATE system_settings set ".$data);
    } else {
        // If system settings don't exist, insert them
        $save = $this->db->query("INSERT INTO system_settings set ".$data);
    }

    if($save){
        // Update session settings after saving
        $query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
        foreach ($query as $key => $value) {
            if(!is_numeric($key))
                $_SESSION['settings'][$key] = $value;
        }
        echo json_encode(array('status' => 'success', 'message' => 'Settings updated successfully.'));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update settings.'));
        exit;
    }
}



	
	function save_course(){
		extract($_POST);
		$data = " course = '$course' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO courses set $data");
			}else{
				$save = $this->db->query("UPDATE courses set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_course(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM courses where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_gallery() {
		// Check if the required parameters are set
		if (!isset($_POST['image_id']) || !isset($_POST['action'])) {
			return json_encode(['error' => 'Invalid request']);
		}
	
		// Extract POST data
		$imageId = $_POST['image_id'];
		$action = $_POST['action'];
	
		// Establish database connection
		include 'db_connect.php';
	
		// Perform action based on like or unlike
		if ($action == 'like') {
			// Increment the like count by 1
			$query = "UPDATE gallery SET likes = likes + 1 WHERE id = $imageId";
		} elseif ($action == 'unlike') {
			// Decrement the like count by 1, ensuring it never goes below 0
			$query = "UPDATE gallery SET likes = CASE WHEN likes > 0 THEN likes - 1 ELSE 0 END WHERE id = $imageId";
		} else {
			// If action is not defined or invalid, return error
			return json_encode(['error' => 'Invalid action']);
		}
	
		// Execute the query
		$result = $conn->query($query);
	
		// Check if the query was successful
		if ($result) {
			// Return the updated like count
			$updatedCountQuery = "SELECT likes FROM gallery WHERE id = $imageId";
			$updatedCountResult = $conn->query($updatedCountQuery);
			if ($updatedCountResult && $updatedCountResult->num_rows > 0) {
				$row = $updatedCountResult->fetch_assoc();
				$likeCount = $row['likes'];
				return json_encode(['success' => true, 'likeCount' => $likeCount]);
			} else {
				return json_encode(['error' => 'Failed to fetch updated like count']);
			}
		} else {
			return json_encode(['error' => 'Failed to update like status']);
		}
	}
	
	function delete_gallery(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM gallery where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_comment(){
		extract($_POST);
		
		// Sanitize and prepare the comment data
		$comment = htmlentities(str_replace(["'", "\r\n", "\n", "\r"], ["&#x2019;", "", "", ""], $comment));
		$image_id = intval($image_id);
		$gr_no = $_SESSION['login_gr_no']; // Access the GR number from the session
		$name = $_SESSION['login_name']; // Access the name from the session
		
		// Insert or update the comment based on whether an ID is provided
		if(empty($id)){
			// Insert new comment
			$save = $this->db->query("INSERT INTO comments (comment, image_id, gr_no, name) VALUES ('$comment', '$image_id', '$gr_no', '$name')");
		} else {
			// Update existing comment
			$save = $this->db->query("UPDATE comments SET comment = '$comment' WHERE image_id = '$image_id'");
		}
		
		if($save){
			return 1; // Return success indicator
		} else {
			return 0; // Return failure indicator
		}
	}
	

	function delete_comment(){
		// Check if comment_id and gr_no are set
		if(isset($_POST['comment_id']) && isset($_SESSION['login_gr_no'])){
			// Extract comment_id and gr_no
			$comment_id = $_POST['comment_id'];
			$gr_no = $_SESSION['login_gr_no'];
			
			// Include database connection
			include 'db_connect.php';
	
			// Prepare the delete statement
			$stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND gr_no = ?");
			
			// Bind the comment_id and gr_no parameters
			$stmt->bind_param("is", $comment_id, $gr_no);
			
			// Execute the delete statement
			if($stmt->execute()){
				// Return success if the delete operation was successful
				echo '1';
			} else {
				// Return failure if there was an error
				echo '0';
			}
			
			// Close the statement
			$stmt->close();
		}
	}
	
	function save_event(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", schedule = '$schedule' ";
		$data .= ", content = '".htmlentities(str_replace("'","&#x2019;",$content))."' ";
		if($_FILES['banner']['tmp_name'] != ''){
						$_FILES['banner']['name'] = str_replace(array("(",")"," "), '', $_FILES['banner']['name']);
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['banner']['name'];
						$move = move_uploaded_file($_FILES['banner']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", banner = '$fname' ";

		}
		if(empty($id)){

			$save = $this->db->query("INSERT INTO events set ".$data);
		}else{
			$save = $this->db->query("UPDATE events set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_event(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM events where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function participate(){
		extract($_POST);
		$data = " event_id = '$event_id' ";
		$data .= ", user_id = '{$_SESSION['login_id']}' ";
		$commit = $this->db->query("INSERT INTO event_commits set $data ");
		if($commit)
			return 1;

	}
	function save_gallery1(){
		extract($_POST);
		// Retrieve name and gr_no from session
		$name = $_SESSION['login_name'] ?? '';
		$gr_no = $_SESSION['login_gr_no'] ?? '';
	
		$img = array();
		$fpath = 'assets/uploads/gallery';
		$files= is_dir($fpath) ? scandir($fpath) : array();
		foreach($files as $val){
			if(!in_array($val, array('.','..'))){
				$n = explode('_',$val);
				$img[$n[0]] = $val;
			}
		}
		if(empty($id)){
			// Insert into gallery table with about, name, and gr_no
			$save = $this->db->query("INSERT INTO gallery (about, name, gr_no) VALUES ('$about', '$name', '$gr_no')");
			if($save){
				$id = $this->db->insert_id;
				$folder = "assets/uploads/gallery/";
				$file = explode('.',$_FILES['img']['name']);
				$file = end($file);
				if(is_file($folder.$id.'_img'.'.'.$file))
					unlink($folder.$id.'_img'.'.'.$file);
				if(isset($img[$id]))
					unlink($folder.$img[$id]);
				if($_FILES['img']['tmp_name'] != ''){
					$fname = $id.'_img'.'.'.$file;
					$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/gallery/'. $fname);
				}
			}
		}else{
			// Update gallery table with about
			$save = $this->db->query("UPDATE gallery set about = '$about' where id=".$id);
			if($save){
				if($_FILES['img']['tmp_name'] != ''){
					$folder = "assets/uploads/gallery/";
					$file = explode('.',$_FILES['img']['name']);
					$file = end($file);
					if(is_file($folder.$id.'_img'.'.'.$file))
						unlink($folder.$id.'_img'.'.'.$file);
					if(isset($img[$id]))
						unlink($folder.$img[$id]);
					$fname = $id.'_img'.'.'.$file;
					$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/gallery/'. $fname);
				}
			}
		}
		if($save)
			return 1;
	}
	
	function delete_gallery1(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM gallery where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function save_career(){
		extract($_POST);
		$data = " company = '$company' ";
		$data .= ", job_title = '$title' ";
		$data .= ", location = '$location' ";
		$data .= ", description = '".htmlentities(str_replace("'","&#x2019;",$description))."' ";

		if(empty($id)){
			// echo "INSERT INTO careers set ".$data;
		$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO careers set ".$data);
		}else{
			$save = $this->db->query("UPDATE careers set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_career(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM careers where id = ".$id);
		if($delete){
			return 1;
		}
	}

	
	function send_notification($message)
	{
		$bio = $this->db->query("SELECT `id` FROM `users`");
		if($bio->num_rows > 0){
			$ret_arr = [];
			foreach($bio as $key => $val) {
				if($_SESSION['login_id'] != $val['id']) {
					$data = " user_id = '{$val['id']}' ";
					$data .= ", message = '{$message}' ";
					$data .= ", timestamp = '".date('Y-m-d H:i:s')."' ";
					$commit = $this->db->query("INSERT INTO notifications set $data ");
				}
			}
			return 1;
		} else {
			return 1;
		}
	}

	function send_chat(){
		extract($_POST);
		if(isset($_SESSION["bio"])) {
			$sender_gr_no = $_SESSION['login_gr_no'];
		} else {
			$sender_id = 0;
			$bio = $this->db->query("SELECT `gr_no` FROM alumnus_bio where parent_id = ".$_SESSION['login_gr_no']);
			if($bio->num_rows > 0){
				$row = $bio->fetch_row();
				$sender_id = $row[0];
			}
		}
		$data = " sender_gr_no = '{$sender_gr_no}' ";
		$data .= ", receiver_gr_no = '{$receiver_gr_no}' ";
		$data .= ", message = '{$message}' ";
		$data .= ", created_at = '".date('Y-m-d H:i:s')."' ";
		$commit = $this->db->query("INSERT INTO chat set $data ");
		if($commit)
			return 1;

	}
	function get_chats($receiver_gr_no)
	{
		if(isset($_SESSION["bio"])) {
			$sender_gr_no = $_SESSION['login_gr_no'];
		} else {
			$sender_id = 0;
			$bio = $this->db->query("SELECT `gr_no` FROM alumnus_bio where parent_id = ".$_SESSION['login_gr_no']);
			if($bio->num_rows > 0){
				$row = $bio->fetch_row();
				$sender_id = $row[0];
			}
		}
		$bio = $this->db->query("SELECT * FROM `chat` WHERE (`sender_gr_no` = '".$sender_gr_no."' AND `receiver_gr_no` = '".$receiver_gr_no."') OR (`sender_gr_no` = '".$receiver_gr_no."' AND `receiver_gr_no` = '".$sender_gr_no."')");
		if($bio->num_rows > 0){
			$ret_arr = [];
			foreach ($bio as $key => $value) {
				$ret_arr[] = $value;
			}
			return $ret_arr;
		} else {
			return [];
		}
	}


	function likes($id) {
		// Include your database connection code here
	
		// Sanitize the input
		$id = intval($id);
	
		// Fetch the like count for the specified image_id from the database
		$query = "SELECT likes FROM gallery WHERE id = ?";
		$stmt = $this->db->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($likes);
		$stmt->fetch();
		$stmt->close();
	
		// Return the like count
		return $likes;
	}
	
		function check_user($gr_no_or_username) {
			// Retrieve email from POST request
			$email = isset($_POST['email']) ? $_POST['email'] : '';
		
			// Validate input
			if (empty($gr_no_or_username) || empty($email)) {
				return ['success' => false, 'error' => 'missing_input'];
			}
		
			// Prepare a query to check if the user with the given GR number or username exists and matches the provided email
			$query = "SELECT COUNT(*) as count FROM users WHERE (gr_no = :gr_no_or_username OR username = :gr_no_or_username) AND email = :email";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':gr_no_or_username', $gr_no_or_username);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
			// Check if the user exists and matches the provided email
			if ($result['count'] > 0) {
				// User found
				return ['success' => true];
			} else {
				// Check if the user exists but does not match the provided email
				$query = "SELECT COUNT(*) as count FROM users WHERE gr_no = :gr_no_or_username OR username = :gr_no_or_username";
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':gr_no_or_username', $gr_no_or_username);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
				if ($result['count'] > 0) {
					// User found but email does not match
					return ['success' => false, 'error' => 'email_mismatch'];
				} else {
					// User not found
					return ['success' => false, 'error' => 'user_not_found'];
				}
			}
		}
}	
		
	
	
	
	
	




?>