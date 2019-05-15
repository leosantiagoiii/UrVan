<?php session_start();
require "dbconnect.inc.php";
if(!isset($_GET['optim'])){
	header("Location../index.php?entry=error");
	exit();
}
else{
	if($_GET['optim']=="yes"){
		$major_id=$_GET['major_id'];
		mysqli_query($conn,"UPDATE booking_majordetails SET optimise='true' WHERE major_id='$major_id'");
		header("Location:../reservations.php");
	}
	elseif($_GET['optim']=="no"){
		$major_id=$_GET['major_id'];
		mysqli_query($conn,"UPDATE booking_majordetails SET optimise=NULL WHERE major_id='$major_id'");
		header("Location:../reservations.php");
	}
}