<?php
session_start();
require "dbconnect.inc.php";
if(isset($_GET['savech'])){
	$driver_name=$_GET['driver_name'];
	$driver_birthdate=$_GET['driver_birthdate'];
	$driver_civil_status=$_GET['driver_civil_status'];
	$driver_weight=$_GET['driver_weight'];
	$driver_height=$_GET['driver_height'];
	$driver_blood_type=$_GET['driver_blood_type'];
	$driver_contact=$_GET['driver_contact'];

	$driver_emergency_name=$_GET['driver_emergency_name'];
	$driver_emergency_contact=$_GET['driver_emergency_contact'];
	$driver_emergency_address=$_GET['driver_emergency_address'];
	$driver_emergency_relationship=$_GET['driver_emergency_relationship'];

	$driver_id=$_GET['driver_id'];
	$member_id=$_GET['member_id'];

	mysqli_query($conn,"UPDATE official_authorized_driver_table SET driver_name='$driver_name', driver_birthdate='$driver_birthdate', driver_civil_status='$driver_civil_status', driver_weight='$driver_weight', driver_height='$driver_height', driver_blood_type='$driver_blood_type', driver_contact='$driver_contact' WHERE driver_id='$driver_id'");

	$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_emergency_contact_table WHERE driver_id='$driver_id'");
	$count=mysqli_num_rows($sql);
	
	if($count>=1){
		mysqli_query($conn,"UPDATE official_authorized_driver_emergency_contact_table SET  driver_emergency_name='$driver_emergency_name', driver_emergency_contact='$driver_emergency_contact', driver_emergency_address='$driver_emergency_address', driver_emergency_relationship='$driver_emergency_relationship' WHERE driver_id='$driver_id'");
	}
	else{
		mysqli_query($conn,"INSERT INTO official_authorized_driver_emergency_contact_table (driver_id,member_id,driver_emergency_name,driver_emergency_address,driver_emergency_contact,driver_emergency_relationship) VALUES ('$driver_id','$member_id','$driver_emergency_name','$driver_emergency_address','$driver_emergency_contact','$driver_emergency_relationship')");
	}

	header("Location:../business_dashboard/edit_driver.php?saved=changes&driver_id=$driver_id&member_id=$member_id");
	exit();

}