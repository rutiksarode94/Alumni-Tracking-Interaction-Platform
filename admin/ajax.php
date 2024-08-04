<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'login3'){
	$login = $crud->login3();
	if($login)
		echo $login;
}
if($action == 'login4'){
	$login = $crud->login4();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'logout3'){
	$logout = $crud->logout3();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'get_comments'){
	$save = $crud->get_comments();
	if($save)
		echo $save;
}
if($action == 'like_image'){
	$save = $crud->like_image();
	if($save)
		echo $save;
}
if($action == 'save_user2'){
	$save = $crud->save_user2();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'delete_alumni'){
	$save = $crud->delete_alumni();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'student_signup'){
	$save = $crud->student_signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}

if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_course"){
	$save = $crud->save_course();
	if($save)
		echo $save;
}

if($action == "delete_course"){
	$delete = $crud->delete_course();
	if($delete)
		echo $delete;
}
if($action == "update_alumni_acc"){
	$save = $crud->update_alumni_acc();
	if($save)
		echo $save;
}
if($action == "save_gallery"){
	$save = $crud->save_gallery();
	if($save)
		echo $save;
}
if($action == "save_gallery1"){
	$save = $crud->save_gallery1();
	if($save)
		echo $save;
}
if($action == "save_like"){
	$save = $crud->save_like();
	if($save)
		echo $save;
}
if($action == "save_reaction"){
	$save = $crud->save_reaction();
	if($save)
		echo $save;
}
if($action == "delete_gallery"){
	$save = $crud->delete_gallery();
	if($save)
		echo $save;
}
if($action == "delete_gallery1"){
	$save = $crud->delete_gallery1();
	if($save)
		echo $save;
}

if($action == "save_career"){
	$save = $crud->save_career();
	if($save)
		echo $save;
}
if($action == "delete_career"){
	$save = $crud->delete_career();
	if($save)
		echo $save;
}
if($action == "save_forum"){
	$save = $crud->save_forum();
	if($save)
		echo $save;
}

if($action == "delete_forum"){
	$save = $crud->delete_forum();
	if($save)
		echo $save;
}

if($action == "update_password"){
    $result = $crud->update_password();
    echo $result;
}

if ($action == 'verify_user') {
    // Call the verify_user method in the Action class
    $result = $crud->verify_user();
    // Output the result as JSON
    echo json_encode($result);
}
if($action == "save_comment"){
	$save = $crud->save_comment();
	if($save)
		echo $save;
}
if($action == "delete_comment"){
	$save = $crud->delete_comment();
	if($save)
		echo $save;

}

if($action == "save_event"){
	$save = $crud->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save = $crud->delete_event();
	if($save)
		echo $save;
}	
if($action == "participate"){
	$save = $crud->participate();
	if($save)
		echo $save;
}
if($action == "likes"){
	$save = $crud->likes();
	if($save)
		echo $save;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}
include 'db_connect2.php';

// Check if the action parameter is set
if (isset($_GET['action']) && !empty($_GET['action'])) {
    // Handle the check_gr_no action
    if ($_GET['action'] == 'check_gr_no') {
        // Check if the gr_no parameter is set
        if (isset($_POST['gr_no']) && !empty($_POST['gr_no'])) {
            // Retrieve the GR number from the POST data
            $grNo = $_POST['gr_no'];

            // Prepare the SQL query to check if the GR number exists in the database
            $stmt = $conn2->prepare("SELECT * FROM student WHERE gr_no = ?");
            $stmt->bind_param("s", $grNo);
            $stmt->execute();

            // Get the result set
            $result = $stmt->get_result();

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // GR number exists, so echo 'exists'
                echo 'exists';
            } else {
                // GR number does not exist, so echo 'not exists'
                echo 'not exists';
            }
        } else {
            // Handle the case where gr_no parameter is not set
            echo 'error: gr_no parameter is missing';
        }
    }
}
if (isset($_GET['action']) && !empty($_GET['action'])) {
    // Handle the fetch_user_data action
    if ($_GET['action'] == 'fetch_user_data') {
        // Check if the gr_no parameter is set
        if (isset($_POST['gr_no']) && !empty($_POST['gr_no'])) {
            // Retrieve the GR number from the POST data
            $gr_no = $_POST['gr_no'];

            // Call the fetch_user_data method in the Action class
            $user_data = $crud->fetch_user_data($gr_no);

            // Output the user data as JSON
            echo $user_data;
        } else {
            // Handle the case where gr_no parameter is not set
            echo json_encode(['error' => 'gr_no parameter is missing']);
        }
    }
}

ob_end_flush();
?>
