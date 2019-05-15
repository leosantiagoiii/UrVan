<?php session_start();
require 'dbconnect.inc.php';
if(isset($_SESSION['memberapprovalacctid'])){
	if(isset($_POST['saveauthdriv'])){

		$member_appointment_driver_number=$_POST['member_appointment_driver_number'];

		$member_appointment_driver_name=$_POST['member_appointment_driver_name'];
		$member_appointment_driver_birthdate=$_POST['member_appointment_driver_birthdate'];
		$member_appointment_driver_civil_status=$_POST['member_appointment_driver_civil_status'];
		$member_appointment_driver_weight=$_POST['member_appointment_driver_weight'];
		$member_appointment_driver_height=$_POST['member_appointment_driver_height'];
		$member_appointment_driver_blood=$_POST['member_appointment_driver_blood'];
		$member_appointment_driver_tin=$_POST['member_appointment_driver_tin'];
		$member_appointment_driver_contact=$_POST['member_appointment_driver_contact'];
		$member_appointment_drivers_licence=$_POST['member_appointment_drivers_licence'];

		$member_appointment_driver_emergency_name=$_POST['member_appointment_driver_emergency_name'];
		$member_appointment_driver_emergency_address=$_POST['member_appointment_driver_emergency_address'];
		$member_appointment_driver_emergency_contact=$_POST['member_appointment_driver_emergency_contact'];
		$member_appointment_driver_emergency_relationship=$_POST['member_appointment_driver_emergency_relationship'];

		$sql="UPDATE member_appointment_driver_details_table
			SET
			member_appointment_driver_name='$member_appointment_driver_name',
			member_appointment_driver_birthdate='$member_appointment_driver_birthdate',
			member_appointment_driver_civil_status='$member_appointment_driver_civil_status',
			member_appointment_driver_weight='$member_appointment_driver_weight',
			member_appointment_driver_height='$member_appointment_driver_height',
			member_appointment_driver_blood='$member_appointment_driver_blood',
			member_appointment_driver_tin='$member_appointment_driver_tin',
			member_appointment_driver_contact='$member_appointment_driver_contact',
			member_appointment_drivers_licence='$member_appointment_drivers_licence'
			WHERE
			member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);

		$sql="UPDATE member_appointment_driver_emergency_table
			SET
			member_appointment_driver_emergency_name='$member_appointment_driver_emergency_name',
			member_appointment_driver_emergency_address='$member_appointment_driver_emergency_address',
			member_appointment_driver_emergency_contact='$member_appointment_driver_emergency_contact',
			member_appointment_driver_emergency_relationship='$member_appointment_driver_emergency_relationship'
			WHERE
			member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);

		header("Location:../signup_member_approval_auth_driv.php?member_appointment_driver_number=$member_appointment_driver_number");
		exit();
	}
	else{
		echo 'forbidden';
	}
}