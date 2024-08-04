<?php 
	include 'admin_class.php';
	$crud = new Action();
	$login = $crud->send_chat();
	echo $login;
?>