<?php session_start();
$member_appointment_driver_name=$_POST['member_appointment_driver_name'];
$member_appointment_driver_birthdate=$_POST['member_appointment_driver_birthdate'];
$member_appointment_driver_civil_status=$_POST['member_appointment_driver_civil_status'];
$member_appointment_driver_weight=$_POST['member_appointment_driver_weight'];
$member_appointment_driver_height=$_POST['member_appointment_driver_height'];
$member_appointment_driver_blood=$_POST['member_appointment_driver_blood'];
$member_appointment_driver_tin=$_POST['member_appointment_driver_tin'];
$member_appointment_drivers_licence=$_POST['member_appointment_drivers_licence'];
$member_appointment_driver_contact=$_POST['member_appointment_driver_contact'];
$member_appointment_number=$_POST['member_appointment_number'];
$mem_app_driv_email=$_POST['mem_app_driv_email'];
if(!isset($_POST['addDriv'])){
	header("Location:../index.php?request=error");
	exit();
}
else{
	require "dbconnect.inc.php";
	$sql="INSERT INTO 
	member_appointment_driver_details_table 
	(member_appointment_driver_number,
	member_appointment_number,
	member_appointment_driver_name,
	member_appointment_driver_birthdate,
	member_appointment_driver_civil_status,
	member_appointment_driver_weight,
	member_appointment_driver_height,
	member_appointment_driver_blood,
	member_appointment_driver_tin,
	member_appointment_drivers_licence,
	member_appointment_driver_contact,
	mem_app_driv_email) 
	VALUES
	('',
	'$member_appointment_number',
	'$member_appointment_driver_name',
	'$member_appointment_driver_birthdate',
	'$member_appointment_driver_civil_status',
	'$member_appointment_driver_weight',
	'$member_appointment_driver_height',
	'$member_appointment_driver_blood',
	'$member_appointment_driver_tin',
	'$member_appointment_drivers_licence',
	'$member_appointment_driver_contact',
	'$mem_app_driv_email')";
	mysqli_query($conn,$sql);
	$last_id=mysqli_insert_id($conn);
	$sql="INSERT INTO member_appointment_driver_emergency_table
	(
	member_appointment_driver_emergency_number,
	member_appointment_driver_number,
	member_appointment_number
	)
	VALUES
	(
	'',
	'$last_id',
	'$member_appointment_number'
	)";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_viewdetails.php?member_appointment_number=$member_appointment_number");
	exit();
}