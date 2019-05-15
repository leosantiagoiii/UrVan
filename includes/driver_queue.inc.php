<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['addit'])){
	$driver_pk=$_GET['driver_pk'];
	$type=$_GET['type_acct'];
	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$driver_pk','$type')");
	header("Location:../business_dashboard/driver_queue.php?insert=success");
	exit();
}
if(isset($_GET['remove_queue'])){
	$driver_pk=$_GET['driver_pk'];
	mysqli_query($conn,"DELETE FROM driver_queue WHERE driver_pk='$driver_pk'");
	header("Location:../business_dashboard/driver_queue.php?delete=success");
	exit();
}