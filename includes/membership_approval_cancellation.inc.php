<?php session_start();

if(!isset($_POST['CancelRequest'])){
	header("Location:../signup_member_approval.php?login=errorclick");
	exit();
}else{
	require "dbconnect.inc.php";

	$member_appointment_number=$_POST['member_appointment_number'];

	$sql="DELETE FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_emergency_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	session_unset();
	session_destroy();
	header("Location: ../index.php?logout=success");
}