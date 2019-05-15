<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}elseif(!isset($_POST['completedeny'])){
	header("Location:../business_dashboard/admin_membership_requests.php");
}else{
	require "dbconnect.inc.php";
	$member_appointment_number=$_POST['member_appointment_number'];
	$sql="DELETE FROM member_appointment_details_table WHERE member_appointment_number=$member_appointment_number";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_emergency_table WHERE member_appointment_number=$member_appointment_number";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_driver_details_table WHERE member_appointment_number=$member_appointment_number";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_number=$member_appointment_number";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_requests.php?membership=deleted");
	exit();
}