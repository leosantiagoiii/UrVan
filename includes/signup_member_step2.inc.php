<?php session_start();
if(!isset($_POST['step2submit'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}
elseif( isset($_POST['step2submit']) ){

	require "dbconnect.inc.php";

	$member_appointment_number=$_POST['member_appointment_number'];
	$member_appointment_emergency_name=$_POST['emergencyName'];
	$member_appointment_emergency_address=$_POST['emergencyAddress'];
	$member_appointment_emergency_phone=$_POST['emergencyPhone'];
	$member_appointment_emergency_relationship=$_POST['emergencyRelationship'];

	$sql="INSERT INTO member_appointment_emergency_table (
			member_appointment_number,
			member_appointment_emergency_name,
			member_appointment_emergency_address,
			member_appointment_emergency_phone,
			member_appointment_emergency_relationship
		) VALUES (
			'$member_appointment_number',
			'$member_appointment_emergency_name',
			'$member_appointment_emergency_address',
			'$member_appointment_emergency_phone',
			'$member_appointment_emergency_relationship'
		)";
	$query=mysqli_query($conn,$sql);
	header("Location:../signup_member3.php?member_appointment_number=$member_appointment_number&appointmentreq_steptwo=approved");
	exit();

}
else{
	header("Location:../signup_member.php?membership=error");
	exit();
}