<?php

 include 'admin/db_connect.php';

session_start();
if($_POST)
{
	$name=$_SESSION['name'];
    $msg=$_POST['msg'];
    
	$sql="INSERT INTO `chat`(`name`, `message`) VALUES ('".$name."', '".$msg."')";

	$query = mysqli_query($conn,$sql);
	if($query)
	{
		header('Location: send_msg.php');
	}
	else
	{
		echo "Something went wrong";
	}
	
	}
?>