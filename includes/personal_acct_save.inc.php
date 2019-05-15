<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(!isset($_POST['savechang'])){
		header("Location:../client_profile.php?error");
		exit();
	}
	else{
		$client_id=$_POST['client_id'];
		$client_nickname=$_POST['client_nickname'];
		$client_first_name=$_POST['client_first_name'];
		$client_last_name=$_POST['client_last_name'];
		$client_home_address=$_POST['client_home_address'];
		$client_phone_number=$_POST['client_phone_number'];
		$client_username=$_POST['client_username'];
		$update="
			UPDATE clients_table
			SET
			client_nickname='$client_nickname',
			client_first_name='$client_first_name',
			client_last_name='$client_last_name',
			client_home_address='$client_home_address',
			client_phone_number='$client_phone_number',
			client_username='$client_username'
			WHERE client_id='$client_id'
			";
		mysqli_query($conn,$update);

		header("Location:../client_profile.php?editing=success");
		exit();
	}
}