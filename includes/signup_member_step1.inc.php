<?php 
session_start();
if(!isset($_POST['next1button'])){
	'forbidden';
	header("Location:../signup_member.php?signup=error");
	exit();
}else{

	require "dbconnect.inc.php";

	$member_first_name=$_POST['member-first-name'];
	$member_last_name=$_POST['member-last-name'];
	$member_middle_name=$_POST['member-middle-name'];
	$member_home_address=$_POST['member-home-address'];
	$member_phone_number=$_POST['member-phone-number'];
	$member_birthdate=$_POST['member-birthdate'];
	$member_civil_status=$_POST['member-civil-status'];
	$member_blood_type=$_POST['member-blood-type'];
	$member_weight=$_POST['member-weight'];
	$member_height=$_POST['member-height'];
	$member_tin=$_POST['member-tin'];

	$query="INSERT INTO member_appointment_details_table (
			member_appointment_number,
			member_appointment_first_name,
			member_appointment_middle_name,
			member_appointment_last_name,
			member_appointment_address,
			member_appointment_phone_number,
			member_appointment_birthdate,
			member_appointment_civil_status,
			member_appointment_blood_type,
			member_appointment_weight,
			member_appointment_height,
			member_appointment_tin
		) 
		VALUES (
			'',
			'$member_first_name',
			'$member_middle_name',
			'$member_last_name',
			'$member_home_address',
			'$member_phone_number',
			'$member_birthdate',
			'$member_civil_status',
			'$member_blood_type',
			'$member_weight',
			'$member_height',
			'$member_tin'
		)";
	mysqli_query($conn,$query);
	$sql="SELECT member_appointment_number, member_appointment_tin 
		FROM member_appointment_details_table 
		WHERE member_appointment_tin='$member_tin'";
	$query=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($query)){
		$member_appointment_number=$row['member_appointment_number'];
	}
	header("Location:../signup_member2.php?member_appointment_number=$member_appointment_number&appointmentreq_stepone=approved");
	exit();
}