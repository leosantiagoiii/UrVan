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
$member_appointment_driver_number=$_POST['member_appointment_driver_number'];
require "dbconnect.inc.php";
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}
else{
	if(isset($_POST['savechanges'])){
		$mem_app_driv_email=$_POST['mem_app_driv_email'];
		$sql="UPDATE member_appointment_driver_details_table SET 
		member_appointment_driver_name='$member_appointment_driver_name',
		member_appointment_driver_birthdate='$member_appointment_driver_birthdate',
		member_appointment_driver_civil_status='$member_appointment_driver_civil_status',
		member_appointment_driver_weight='$member_appointment_driver_weight',
		member_appointment_driver_height='$member_appointment_driver_height',
		member_appointment_driver_blood='$member_appointment_driver_blood',
		member_appointment_driver_tin='$member_appointment_driver_tin',
		member_appointment_drivers_licence='$member_appointment_drivers_licence',
		member_appointment_driver_contact='$member_appointment_driver_contact',
		mem_app_driv_email='$mem_app_driv_email'
		WHERE
		member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);
		header("Location:../business_dashboard/admin_driver_edit.php?mem_id=$member_appointment_number&member_appointment_driver_number=$member_appointment_driver_number");
		exit();
	}
	elseif(isset($_POST['removechanges'])){
		//change to archive ha
		$sql="DELETE FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);
		$sql="DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);
		header("Location:../business_dashboard/admin_membership_viewdetails.php?member_appointment_number=$member_appointment_number&driver=deleted");
		exit();
	}
	elseif(isset($_POST['removechanges_1'])){
		//change to archive ha
		$sql="DELETE FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);
		$sql="DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
		mysqli_query($conn,$sql);
		header("Location:../business_dashboard/admin_membership_viewdetails.php?member_appointment_number=$member_appointment_number");
		exit();
	}
	else{
		header("Location:../index.php?request=error");
		exit();
	}
}