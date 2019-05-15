<?php session_start();
if(!isset($_POST['step3addmore'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}else{
	require "dbconnect.inc.php";

	$member_appointment_driver_name=$_POST['member_appointment_driver_name'];
	$member_appointment_driver_birthdate=$_POST['member_appointment_driver_birthdate'];
	$member_appointment_driver_civil_status=$_POST['member_appointment_driver_civil_status'];
	$member_appointment_driver_weight=$_POST['member_appointment_driver_weight'];
	$member_appointment_driver_height=$_POST['member_appointment_driver_height'];
	$member_appointment_driver_blood=$_POST['member_appointment_driver_blood'];
	$member_appointment_driver_tin=$_POST['member_appointment_driver_tin'];
	$member_appointment_driver_contact=$_POST['member_appointment_driver_contact'];

	$member_appointment_driver_emergency_name=$_POST['member_appointment_driver_emergency_name'];
	$member_appointment_driver_emergency_address=$_POST['member_appointment_driver_emergency_address'];
	$member_appointment_driver_emergency_contact=$_POST['member_appointment_driver_emergency_contact'];
	$member_appointment_driver_emergency_relationship=$_POST['member_appointment_driver_emergency_relationship'];
	$member_appointment_number=$_POST['member_appointment_number'];

	$sql="INSERT INTO member_appointment_driver_details_table (
			member_appointment_driver_number,
			member_appointment_number,
			member_appointment_driver_name,
			member_appointment_driver_birthdate,
			member_appointment_driver_civil_status,
			member_appointment_driver_weight,
			member_appointment_driver_height,
			member_appointment_driver_blood,
			member_appointment_driver_tin,
			member_appointment_driver_contact
		) VALUES (
			'',
			'$member_appointment_number',
			'$member_appointment_driver_name',
			'$member_appointment_driver_birthdate',
			'$member_appointment_driver_civil_status',
			'$member_appointment_driver_weight',
			'$member_appointment_driver_height',
			'$member_appointment_driver_blood',
			'$member_appointment_driver_tin',
			'$member_appointment_driver_contact'
		)";
	$query=mysqli_query($conn,$sql);

	$sql="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_driver_tin='$member_appointment_driver_tin'";
	$query=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($query))
	{
		$member_appointment_driver_number=$row['member_appointment_driver_number'];
	}

	$sql="INSERT INTO member_appointment_driver_emergency_table (
			member_appointment_driver_emergency_number,
			member_appointment_driver_number,
			member_appointment_number,
			member_appointment_driver_emergency_name,
			member_appointment_driver_emergency_address,
			member_appointment_driver_emergency_contact,
			member_appointment_driver_emergency_relationship
		) VALUES (
			'',
			'$member_appointment_driver_number',
			'$member_appointment_number',
			'$member_appointment_driver_emergency_name',
			'$member_appointment_driver_emergency_address',
			'$member_appointment_driver_emergency_contact',
			'$member_appointment_driver_emergency_relationship'
		)";
	$query=mysqli_query($conn,$sql);
	header("Location:../signup_member3.php?member_appointment_number=$member_appointment_number&appointmentreq_steptwo=approved");
	exit();
}