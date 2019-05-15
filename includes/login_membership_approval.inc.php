<?php session_start();
if(!isset($_POST['loginbutton'])){
	header("Location:../signup_member_approval.php?login=error");
	exit();
}
else{
	require "dbconnect.inc.php";
	$member_appointment_username=$_POST['member_appointment_username'];
	$member_appointment_password=$_POST['member_appointment_password'];
	$sql="SELECT * FROM member_appointment_details_table WHERE
		member_appointment_username LIKE '{$member_appointment_username}'
		AND
		member_appointment_password LIKE '{$member_appointment_password}'
		LIMIT 1";
	$result=mysqli_query($conn,$sql);
	if(!mysqli_num_rows($result)==1){
		header("Location:../signup_member_approval.php?error=wrongusernameorpassword");
		exit();
	}
	else{
		while($row=mysqli_fetch_assoc($result)){
			$_SESSION['memberapprovalacctid']=$row['member_appointment_number'];
			header("Location:../signup_member_approval.php?login=success");
			exit();
		}
	}
}