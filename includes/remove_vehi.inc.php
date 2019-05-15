<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
}
else{
	if(!isset($_GET['lalal'])){
		header("Location:../index.php?entry=error");
	}
	else{
		$member_id=$_GET['member_id'];
		$vehicle_id=$_GET['vehicle_id'];
		$sql="DELETE FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'";
		mysqli_query($conn,$sql);
		$query=mysqli_query($conn,"DELETE FROM vehicleQueue_franchised WHERE vehicle_id='$vehicle_id'");
		$query=mysqli_query($conn,"DELETE FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicle_id'");
		$sql="SELECT * FROM vehicle_table WHERE member_id='$member_id'";
		$res=mysqli_query($conn,$sql);
		$count=mysqli_num_rows($res);
		$query=mysqli_query($conn,"DELETE FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
		header("Location:../business_dashboard/add_vehicles.php?deleted=yes&member_id=$member_id&count=$count");
		exit();
	}
}