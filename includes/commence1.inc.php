<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['flaked'])){
	$major_id=$_GET['major_id'];
	mysqli_query($conn,"UPDATE booking_majordetails SET completion='NO_CANCELLED', refunded='NO' WHERE major_id='$major_id'");
	mysqli_query($conn,"UPDATE driver_queue SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");

	$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$row=mysqli_fetch_assoc($sql);
	$tour_id=$row['tour_id'];
	$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
	$welz=mysqli_num_rows($ba);
	if($welz>=1){
		mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}
	else{
		mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}
	header("Location:../curr_trips.php?they%flaked");
	exit();
}
elseif(isset($_GET['proceed'])){
	$major_id=$_GET['major_id'];
	//put something here that signifies they can enter this pg
	header("Location:../commence2.php?major_id=$major_id");
	exit();
}