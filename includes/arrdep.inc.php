<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['arrival_btn'])){
	$dateTimeArrival=$_GET['dateTimeArrival'];
	$comm_id=$_GET['comm_id'];
	$major_id=$_GET['major_id'];
	mysqli_query($conn,"UPDATE booking_optimize_tbl  SET arrival_dt='$dateTimeArrival' WHERE comm_id='$comm_id'");

	$sql=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE comm_id='$comm_id'");
	$row=mysqli_fetch_assoc($sql);
	$start=$_GET['dateTimeArrival'];
	$end=$row['departure_dt'];
	$ts1 = strtotime($start);
	$ts2 = strtotime($end);     
	$seconds_diff = ABS($ts2 - $ts1);                            
	$hrDiff = ($seconds_diff/3600);

	mysqli_query($conn,"UPDATE booking_optimize_tbl  SET actual_byahe='$hrDiff' WHERE comm_id='$comm_id'");

	header("Location:../commence3.php?major_id=$major_id");
	exit();
}
elseif(isset($_GET['departure_btn'])){
	$dateTimeDepar=$_GET['dateTimeDepar'];
	$comm_id=$_GET['comm_id'];
	$major_id=$_GET['major_id'];
	mysqli_query($conn,"UPDATE booking_optimize_tbl  SET departure_dt='$dateTimeDepar' WHERE comm_id='$comm_id'");
	header("Location:../commence3.php?major_id=$major_id");
	exit();
}