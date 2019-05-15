<?php session_start();
require "dbconnect.inc.php";
$id=$_POST['mem_id'];
$email=$_POST['email'];
if(!isset($_SESSION['adminid'])){
	header();
	exit();
}
else{
	if(isset($_POST['pay'])){
		mysqli_query($conn,"INSERT INTO official_member_member_payment (id,member_id,amount) VALUES ('','$id','500')");
		header("Location:../business_dashboard/membership_fee.php?action=paid");
		exit();	
		// email
	}
	elseif(isset($_POST['unpay'])){
		mysqli_query($conn,"DELETE FROM official_member_member_payment WHERE member_id='$id'");
		header("Location:../business_dashboard/membership_fee.php?action=revokepay");
		exit();	
		// email
	}
	else{
		header();
		exit();	
	}
}