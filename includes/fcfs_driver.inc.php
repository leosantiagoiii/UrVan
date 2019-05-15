<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['tripAccept'])){
	$driver_pk=$_GET['driver_pk'];
	mysqli_query($conn,"UPDATE driver_queue SET acceptance='accepted' WHERE driver_pk='$driver_pk'");
	header("Location:../curr_trips.php");
}
elseif(isset($_GET['tripDecline'])){
	$driver_pk=$_GET['driver_pk'];
	mysqli_query($conn,"UPDATE driver_queue SET acceptance='refused' WHERE driver_pk='$driver_pk'");
	header("Location:../curr_trips.php");
}