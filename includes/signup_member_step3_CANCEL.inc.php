<?php session_start();
if(!isset($_POST['step3cancel'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}else{
	require "dbconnect.inc.php";
	$member_appointment_number=$_POST['member_appointment_number'];
	$sql="DELETE FROM
			member_appointment_details_table
		WHERE 
			member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$sql="DELETE FROM member_appointment_emergency_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$query="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
	$res=mysqli_query($conn,$query);
	while($row=mysqli_fetch_assoc($res)){
		$member_appointment_driver_number_2=$row['member_appointment_driver_number'];
		$queryz="DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$member_appointment_driver_number_2";
		mysqli_query($conn,$queryz);
	}
	$sql="DELETE FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	header("Location: ../index.php?cancellation=success");
	exit();
}