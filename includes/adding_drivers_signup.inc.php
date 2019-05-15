<?php 
session_start();
require "dbconnect.inc.php";

$driver_id=strtoupper(uniqid("DR",false));
$member_id=$_POST['member_id'];
$driver_name=$_POST['driver_name'];
$driver_birthdate=$_POST['driver_birthdate'];
$driver_civil_status=$_POST['driver_civil_status'];
$driver_weight=$_POST['driver_weight'];
$driver_height=$_POST['driver_height'];
$driver_blood_type=$_POST['driver_blood_type'];
$driver_tin=$_POST['driver_tin'];
$driver_licence=$_POST['driver_licence'];
$driver_email=$_POST['driver_email'];
$d_pw=$_POST['driver_password'];
$driver_password=password_hash($d_pw, PASSWORD_DEFAULT);
$driver_contact=$_POST['driver_contact'];

$driver_emergency_name=$_POST['driver_emergency_name'];
$driver_emergency_address=$_POST['driver_emergency_address'];
$driver_emergency_contact=$_POST['driver_emergency_contact'];
$driver_emergency_relationship=$_POST['driver_emergency_relationship'];

$sqlQuery="
INSERT INTO initial_official_authorized_driver_table
(
driver_id,
member_id,
driver_name,
driver_birthdate,
driver_civil_status,
driver_weight,
driver_height,
driver_blood_type,
driver_tin,
driver_licence,
driver_email,
driver_password,
driver_contact
)
VALUES
(
'$driver_id',
'$member_id',
'$driver_name',
'$driver_birthdate',
'$driver_civil_status',
'$driver_weight',
'$driver_height',
'$driver_blood_type',
'$driver_tin',
'$driver_licence',
'$driver_email',
'$driver_password',
'$driver_contact'
)
";
mysqli_query($conn,$sqlQuery);

mysqli_query($conn,"
INSERT INTO initial_official_authorized_driver_emergency_contact_table
(
driver_id,
member_id,
driver_emergency_name,
driver_emergency_address,
driver_emergency_contact,
driver_emergency_relationship
)
VALUES
(
'$driver_id',
'$member_id',
'$driver_emergency_name',
'$driver_emergency_address',
'$driver_emergency_contact',
'$driver_emergency_relationship'
)");

$countImg=count($_FILES["driverFilup"]["name"]);
if($countImg>=2){
	for($i=0;$i<$countImg;$i++){
		$target_dir='driveruploadsx/';
		$id=uniqid("",false);
		$filename=$target_dir.$id.basename($_FILES["driverFilup"]["name"][$i]);
		move_uploaded_file($_FILES["driverFilup"]["tmp_name"][$i], $filename);
		mysqli_query($conn,"INSERT INTO initial_upload_three (init_id,member_id,driver_id,init_filepath) VALUES ('','$member_id','$driver_id','$filename')");
	}
}

header("Location:../adding_drivers_signup.php?member_id=$member_id");