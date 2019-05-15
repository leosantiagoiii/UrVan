<?php
session_start();
require "dbconnect.inc.php";
date_default_timezone_set('Asia/Manila');
$kloi=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id=$_SESSION[clientid] AND completion='NO' ORDER BY created_at ASC LIMIT 1");
$mechjor=mysqli_fetch_assoc($kloi);
$major_booking_id=$mechjor['major_id'];
$tour_id=$mechjor['tour_id'];
$startDate=$mechjor['start_date'];
$startDate=strtotime($startDate);
$deyt=DATE("Y-m-d");
$deyt=strtotime($deyt);
if($deyt==$startDate){
	$jkal=mysqli_query($conn,"SELECT * FROM checkin_tbl WHERE major_id='$major_booking_id'");
	$bhilung=mysqli_num_rows($jkal);
	if($bhilung==0){
		$hdjs="UPDATE booking_majordetails SET completion='NO_CANCELLED', refunded='NO' WHERE major_id='$major_booking_id'";
		mysqli_query($conn,$hdjs);

		//removing the info for driver trip
		$inc=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major_booking_id'");
		while($incr=mysqli_fetch_assoc($inc)){
			$get_id=$incr['main_id'];
			mysqli_query($conn,"UPDATE driver_queue SET status=null,acceptance=null,start_date=null,end_date=null WHERE main_id='$get_id'");
		}

		//removing the info for driver trip (van)

		$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
		$mai=mysqli_num_rows($ba);
		if($mai>=1){
			$cin=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major_booking_id'");
			while($cinr=mysqli_fetch_assoc($cin)){
				$get_id=$cinr['franc_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE franc_id='$get_id'");
			}
		}
		else{
			$cin=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major_booking_id'");
			while($cinr=mysqli_fetch_assoc($cin)){
				$get_id=$cinr['franc_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE franc_id='$get_id'");
			}
		}

		//email the drivers againZ1

		$forgotCheckin=true;
		$forgotId=$major_booking_id;
	}
	else{
		$duration=$mechjor['duration'];
		header("Location:trip_now.php?duration=$duration&trip_today=set");
		exit();
	}
}