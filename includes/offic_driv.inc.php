<?php session_start();
require "dbconnect.inc.php";
if($_POST['oldPw']!='' || $_POST['newPw']!=''){
	$driver_id=$_POST['driver_id'];
	$oldPw=$_POST['oldPw'];
	$newPw=$_POST['newPw'];
	$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$driver_id'");
	if($row=mysqli_fetch_assoc($sql)){
		$verify=password_verify($oldPw, $row['driver_password']);
		if($verify==false){
			header("Location:../driv_settings.php?pw_change=didnt%match");
			exit();
		}
		else{
			$encrypt=password_hash($newPw, PASSWORD_DEFAULT);
			mysqli_query($conn,"UPDATE official_authorized_driver_table SET driver_password='$encrypt' WHERE driver_id='$driver_id'");
		}
	}
}
if(isset($_POST['driName'])){
	$driver_id=$_POST['driver_id'];
	$driName=$_POST['driName'];
	mysqli_query($conn,"UPDATE official_authorized_driver_table SET driver_name='$driName' WHERE driver_id='$driver_id'");
}
header("Location:../driv_settings.php?settings=updated");
exit();