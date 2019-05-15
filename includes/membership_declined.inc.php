<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}elseif(!isset($_POST['yesbutton'])){
	header("Location:../business_dashboard/admin_membership_requests.php");
}else{
	require "dbconnect.inc.php";
	$member_appointment_number=$_POST['member_appointment_number'];
	$sql="UPDATE member_appointment_details_table SET member_appointment_approval='DECLINED' WHERE member_appointment_number=$member_appointment_number";
	$res=mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_requests.php?membership=declined");
	exit();
}