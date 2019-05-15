<?php
session_start();
require "dbconnect.inc.php";

if(isset($_POST['sve'])){
	$driver_id=$_POST['driver_id'];
	$member_id=$_POST['member_id'];

	$driver_name=$_POST['driver_name'];
	$driver_birthdate=$_POST['driver_birthdate'];
	$driver_civil_status=$_POST['driver_civil_status'];
	$driver_blood_type=$_POST['driver_blood_type'];
	$driver_weight=$_POST['driver_weight'];
	$driver_height=$_POST['driver_height'];
	$driver_tin=$_POST['driver_tin'];
	$driver_licence=$_POST['driver_licence'];
	$driver_email=$_POST['driver_email'];
		$driver_password=$_POST['driver_password'];
	$driver_password=password_hash($driver_password,PASSWORD_DEFAULT);
	$driver_contact=$_POST['driver_contact'];

	$driver_emergency_name=$_POST['driver_emergency_name'];
	$driver_emergency_address=$_POST['driver_emergency_address'];
	$driver_emergency_contact=$_POST['driver_emergency_contact'];
	$driver_emergency_relationship=$_POST['driver_emergency_relationship'];

	mysqli_query($conn,"INSERT INTO official_authorized_driver_table 
		(driver_id,
		member_id,
		driver_name,
		driver_birthdate,
		driver_civil_status,
		driver_blood_type,
		driver_weight,
		driver_height,
		driver_tin,
		driver_licence,
		driver_email,
		driver_password,
		driver_contact
		) VALUES 
		('$driver_id',
		'$member_id',
		'$driver_name',
		'$driver_birthdate',
		'$driver_civil_status',
		'$driver_blood_type',
		'$driver_weight',
		'$driver_height',
		'$driver_tin',
		'$driver_licence',
		'$driver_email',
		'$driver_password',
		'$driver_contact')");

	mysqli_query($conn,"INSERT INTO official_authorized_driver_emergency_contact_table
		(driver_id,
		member_id,
		driver_emergency_name,
		driver_emergency_address,
		driver_emergency_contact,
		driver_emergency_relationship)
		VALUES
		('$driver_id',
		'$member_id',
		'$driver_emergency_name',
		'$driver_emergency_address',
		'$driver_emergency_contact',
		'$driver_emergency_relationship')");

	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$driver_id','AUTH_DRIV')");

	header("Location:../business_dashboard/add_driv.php?driver=added&member_id=$member_id");
	exit();

}