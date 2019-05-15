<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['deleteq'])){
	$major_id=$_GET['major_id'];
	$tour_id=$_GET['tour_id'];
	$minor_id=$_GET['minor_id'];
	$end=$_GET['end'];
	mysqli_query($conn,"DELETE FROM `booking_minordetails` WHERE `booking_minordetails`.`minor_id` = '$minor_id'");
	header("Location:../itineraries.php?delete=success&minor_id&major_id=$major_id&tour_id=$tour_id&bookingstill&start=$starr&end=$enn&duration=$end");
	exit();
}