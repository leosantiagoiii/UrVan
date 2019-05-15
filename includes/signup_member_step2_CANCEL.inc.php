<?php session_start();
if(!isset($_POST['step2cancel'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}else{
	require "dbconnect.inc.php";
	$member_appointment_number=$_POST['member_appointment_number'];
	$sql="DELETE FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	header("Location:../index.php?cancellation=success");
	exit();
}