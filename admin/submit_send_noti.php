<?php 
	include 'admin_class.php';

	$crud = new Action();
	$login = $crud->send_notification($_POST["message"]);
	
	header("Location: ../send_notification.php?page=send_noti");
?>