<?php session_start();
require "dbconnect.inc.php";

$member_id=strtoupper(uniqid("MEM",false));
$member_first_name=$_POST['member_first_name'];
$member_middle_name=$_POST['member_middle_name'];
$member_last_name=$_POST['member_last_name'];
$member_address=$_POST['member_address'];
$member_phone_number=$_POST['member_phone_number'];
$member_birthdate=$_POST['member_birthdate'];
$member_civil_status=$_POST['member_civil_status'];
$member_blood_type=$_POST['member_blood_type'];
$member_weight=$_POST['member_weight'];
$member_height=$_POST['member_height'];
$member_tin=$_POST['member_tin'];
$member_username=$_POST['member_username'];
$member_email=$_POST['member_email'];
$m_pw=$_POST['member_password'];
$member_password=password_hash($m_pw,PASSWORD_DEFAULT);

$countImg=count($_FILES["initialFileUp"]["name"]);
if($countImg>=1){
	for($i=0;$i<$countImg;$i++){
		$target_dir='initialupload/';
		$id=uniqid("",false);
		$filename=$target_dir.$id.basename($_FILES["initialFileUp"]["name"][$i]);
		move_uploaded_file($_FILES["initialFileUp"]["tmp_name"][$i], $filename);
		mysqli_query($conn,"INSERT INTO initial_upload (init_id,member_id,init_filepath) VALUES ('','$member_id','$filename')");
	}
}

$sql_code="
	INSERT INTO initial_official_member_table
	(
	member_id,
	active,
	member_first_name,
	member_middle_name,
	member_last_name,
	member_address,
	member_phone_number,
	member_birthdate,
	member_civil_status,
	member_blood_type,
	member_weight,
	member_height,
	member_tin,
	member_username,
	member_email,
	member_password
	)
	VALUES
	(
	'$member_id',
	'0',
	'$member_first_name',
	'$member_middle_name',
	'$member_last_name',
	'$member_address',
	'$member_phone_number',
	'$member_birthdate',
	'$member_civil_status',
	'$member_blood_type',
	'$member_weight',
	'$member_height',
	'$member_tin',
	'$member_username',
	'$member_email',
	'$member_password'
	)
";
$query=mysqli_query($conn,$sql_code);
header("Location:../x_asBoth.php?initial=success&member_id=$member_id");
exit();