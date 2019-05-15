<?php
session_start();
if(!isset($_POST['savechanges'])){
	header("Location:../signup_member_approval.php?login=errorclick");
	exit();
}else{

	require "dbconnect.inc.php";

	$member_appointment_number=$_POST['member_appointment_number'];

	$member_appointment_first_name=$_POST['member_appointment_first_name'];
	$member_appointment_middle_name=$_POST['member_appointment_middle_name'];
	$member_appointment_last_name=$_POST['member_appointment_last_name'];

	$member_appointment_address=$_POST['member_appointment_address'];
	$member_appointment_phone_number=$_POST['member_appointment_phone_number'];
	$member_appointment_birthdate=$_POST['member_appointment_birthdate'];
	$member_appointment_civil_status=$_POST['member_appointment_civil_status'];
	$member_appointment_blood_type=$_POST['member_appointment_blood_type'];
	$member_appointment_weight=$_POST['member_appointment_weight'];
	$member_appointment_height=$_POST['member_appointment_height'];
	$member_appointment_tin=$_POST['member_appointment_tin'];
	$member_appointment_datemeet=$_POST['member_appointment_datemeet'];
	$member_appointment_timemeet=$_POST['member_appointment_timemeet'];
	$member_appointment_username=$_POST['member_appointment_username'];
	$member_appointment_password=$_POST['member_appointment_password'];
	$member_appointment_drivers_licence=$_POST['member_appointment_drivers_licence'];

	$mem_email=$_POST['mem_email'];

	$member_appointment_datemeet_before=$_POST['member_appointment_datemeet_before'];
	$member_appointment_timemeet_before=$_POST['member_appointment_timemeet_before'];

	$member_appointment_emergency_name=$_POST['member_appointment_emergency_name'];
	$member_appointment_emergency_address=$_POST['member_appointment_emergency_address'];
	$member_appointment_emergency_phone=$_POST['member_appointment_emergency_phone'];
	$member_appointment_emergency_relationship=$_POST['member_appointment_emergency_relationship'];

	if($member_appointment_datemeet_before!=$member_appointment_datemeet||$member_appointment_timemeet_before!=$member_appointment_timemeet){
		$sql="
			UPDATE
				member_appointment_details_table 
			SET 
				member_appointment_first_name='$member_appointment_first_name',
				member_appointment_middle_name='$member_appointment_middle_name',
				member_appointment_last_name='$member_appointment_last_name',
				member_appointment_tin='$member_appointment_tin',
				member_appointment_address='$member_appointment_address',
				member_appointment_phone_number='$member_appointment_phone_number',
				member_appointment_birthdate='$member_appointment_birthdate',
				member_appointment_civil_status='$member_appointment_civil_status',
				member_appointment_blood_type='$member_appointment_blood_type',
				member_appointment_weight='$member_appointment_weight',
				member_appointment_height='$member_appointment_height',
				member_appointment_password='$member_appointment_password',
				member_appointment_datemeet='$member_appointment_datemeet',
				member_appointment_timemeet='$member_appointment_timemeet',
				member_appointment_approval='PENDING',
				member_appointment_drivers_licence='$member_appointment_drivers_licence',
				mem_email='$mem_email'
			WHERE 
				member_appointment_number='$_SESSION[memberapprovalacctid]'";
		mysqli_query($conn,$sql);
		$sql="UPDATE member_appointment_emergency_table SET
		member_appointment_emergency_name='$member_appointment_emergency_name',
		member_appointment_emergency_address='$member_appointment_emergency_address',
		member_appointment_emergency_phone='$member_appointment_emergency_phone',
		member_appointment_emergency_relationship='$member_appointment_emergency_relationship'
		WHERE member_appointment_number='$member_appointment_number'";
		mysqli_query($conn,$sql);
	}
	else{
		$sql="
			UPDATE
				member_appointment_details_table 
			SET 
				member_appointment_first_name='$member_appointment_first_name',
				member_appointment_middle_name='$member_appointment_middle_name',
				member_appointment_last_name='$member_appointment_last_name',
				member_appointment_tin='$member_appointment_tin',
				member_appointment_address='$member_appointment_address',
				member_appointment_phone_number='$member_appointment_phone_number',
				member_appointment_birthdate='$member_appointment_birthdate',
				member_appointment_civil_status='$member_appointment_civil_status',
				member_appointment_blood_type='$member_appointment_blood_type',
				member_appointment_weight='$member_appointment_weight',
				member_appointment_height='$member_appointment_height',
				member_appointment_password='$member_appointment_password',
				member_appointment_drivers_licence='$member_appointment_drivers_licence',
				mem_email='$mem_email'
			WHERE 
				member_appointment_number='$_SESSION[memberapprovalacctid]'
		";
		mysqli_query($conn,$sql);
		$sql="UPDATE member_appointment_emergency_table SET
		member_appointment_emergency_name='$member_appointment_emergency_name',
		member_appointment_emergency_address='$member_appointment_emergency_address',
		member_appointment_emergency_phone='$member_appointment_emergency_phone',
		member_appointment_emergency_relationship='$member_appointment_emergency_relationship'
		WHERE member_appointment_number='$member_appointment_number'";
		mysqli_query($conn,$sql);
	}
	header("Location:../signup_member_approval.php?savedchanges=yes");
	exit();
}