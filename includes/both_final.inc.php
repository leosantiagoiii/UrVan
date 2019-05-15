<?php
session_start();
require "dbconnect.inc.php";

$member_id=$_POST['member_id'];
$member_drivers_licence=$_POST['member_drivers_licence'];
$member_emergency_name=$_POST['member_emergency_name'];
$member_emergency_address=$_POST['member_emergency_address'];
$member_emergency_phone=$_POST['member_emergency_phone'];
$member_emergency_relationship=$_POST['member_emergency_relationship'];

$countImg=count($_FILES["secondaryFillup"]["name"]);
if($countImg>=1){
	for($i=0;$i<$countImg;$i++){
		$target_dir='secondaryupload/';
		$id=uniqid("",false);
		$filename=$target_dir.$id.basename($_FILES["secondaryFillup"]["name"][$i]);
		move_uploaded_file($_FILES["secondaryFillup"]["tmp_name"][$i], $filename);
		mysqli_query($conn,"INSERT INTO initial_upload_two (init_id,member_id,init_filepath) VALUES ('','$member_id','$filename')");
	}
}

mysqli_query($conn,"UPDATE initial_official_member_table SET member_drivers_licence='$member_drivers_licence' WHERE member_id='$member_id'");

mysqli_query($conn,"INSERT INTO initial_official_member_emergency_contact_table
	(
	member_id,
	member_emergency_name,
	member_emergency_address,
	member_emergency_phone,
	member_emergency_relationship
	)
	VALUES
	(
	'$member_id',
	'$member_emergency_name',
	'$member_emergency_address',
	'$member_emergency_phone',
	'$member_emergency_relationship'
	)");

header("Location:../adding_drivers_signup.php?member_id=$member_id");