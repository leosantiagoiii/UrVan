<?php session_start();
require "dbconnect.inc.php";
if(!isset($_POST['return']) || !isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	$tour_id = $_POST['tour_id'];
	$sql=mysqli_query($conn,"INSERT INTO tours_and_packages_table
		SELECT * FROM tours_and_packages_archive_table
		WHERE tour_id='$tour_id'");
	$sql=mysqli_query($conn,"DELETE FROM tours_and_packages_archive_table
		WHERE tour_id='$tour_id'");
	header("Location:../business_dashboard/arch_tou.php?return=success");
	exit();
}