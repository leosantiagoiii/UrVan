<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['memberid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(!isset($_POST['savechange'])){
		header("Location:../business_dashboard/Member_dashboard/index.php?error");
		exit();
	}
	else{
		$member_first_name=$_POST['member_first_name'];
		$member_last_name=$_POST['member_last_name'];
		$member_address=$_POST['member_address'];
		$member_phone_number=$_POST['member_phone_number'];
		$member_birthdate=$_POST['member_birthdate'];
		$member_civil_status=$_POST['member_civil_status'];
	
		$update="
			UPDATE official_member_table
			SET
			
			member_first_name='$member_first_name',
			member_last_name='$member_last_name',
			member_address='$member_address',
			member_phone_number='$member_phone_number',
			member_birthdate='$member_birthdate',
			member_civil_status='$member_civil_status'
			WHERE member_id='$_SESSION[memberid]'
			";
		mysqli_query($conn,$update);
		header("Location:../business_dashboard/Member_dashboard/index.php?editing=success");
		exit();
	}
}