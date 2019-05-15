<?php session_start();
require "dbconnect.inc.php";
if(isset($_POST['1day'])){
	$major_id=$_POST['major_id'];
	$po=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$ru=mysqli_fetch_assoc($po);
	$tour_id=$ru['tour_id'];
	$sql="UPDATE booking_majordetails SET completion='NO_CANCELLED', refunded='NO' WHERE major_id='$major_id'";
	$res=mysqli_query($conn,$sql);
	// email

	$cancelDriver=mysqli_query($conn,"UPDATE driver_queue SET status=null, acceptance=null, start_date=null, end_date=null WHERE status='$major_id'");

	$pel=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
	$he=mysqli_num_rows($pel);
	if($he>=1){
		$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}
	else{
		$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}

	header("Location:../client_past_trips.php");
	exit();
}