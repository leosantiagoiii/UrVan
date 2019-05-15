<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['major_id'])){
	$major_id=$_GET['major_id'];
	$main_id=$_GET['id'];
	$getType=mysqli_query($conn,"SELECT * FROM driver_queue WHERE main_id='$main_id'");
	$getType_=mysqli_fetch_assoc($getType);
	$type=$getType_['type'];
	$start_date=$getType_['start_date'];
	$end_date=$getType_['end_date'];
	$driver_pk=$getType_['driver_pk'];
	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$driver_pk','$type')");
	mysqli_query($conn,"DELETE FROM driver_queue WHERE main_id='$main_id'");
	$algo_driver_query=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status IS NULL ORDER BY main_id ASC LIMIT 1");
	$algo_driver_query_=mysqli_fetch_assoc($algo_driver_query);
	$new_main_id=$algo_driver_query_['main_id'];
	mysqli_query($conn,"UPDATE driver_queue SET status='$major_id',start_date='$start_date',end_date='$end_date' WHERE main_id='$new_main_id'");
	header("Location:../business_dashboard/driver_queue.php");
}
