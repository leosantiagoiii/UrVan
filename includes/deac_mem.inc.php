<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['AcBut'])){
	$member_id=$_GET['member_id'];
	mysqli_query($conn,"UPDATE official_member_table SET active='0' WHERE member_id='$member_id'");
	mysqli_query($conn,"UPDATE vehicle_table SET active_v='1',vehicle_table.status='ACTIVE' WHERE member_id='$member_id'");
	$my=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE member_id='$member_id'");
	while($row=mysqli_fetch_assoc($my)){
		$id=$row['id'];
		if($row['franchised']=="YES"){
			mysqli_query($conn,"INSERT INTO vehicleQueue_franchised (franc_id,vehicle_id,member_id) VALUES ('','$id','$member_id')");
		}
		else{
			mysqli_query($conn,"INSERT INTO vehicleQueue_not_franchised (franc_id,vehicle_id,member_id) VALUES ('','$id','$member_id')");
		}
	}
	header("Location:../business_dashboard/index.php?activated=$member_id");
	exit();
}
elseif(isset($_GET['DeacBut'])){
	$member_id=$_GET['member_id'];
	mysqli_query($conn,"UPDATE official_member_table SET active='1' WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM driver_queue WHERE driver_pk='$member_id'");
	$sql = mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id='$member_id'");
	while($row=mysqli_fetch_assoc($sql)){
		mysqli_query($conn,"DELETE FROM driver_queue WHERE driver_pk='$row[driver_id]'");
	}
	mysqli_query($conn,"DELETE FROM vehicleQueue_franchised WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM vehicleQueue_not_franchised WHERE member_id='$member_id'");
	mysqli_query($conn,"UPDATE vehicle_table SET active_v='0', vehicle_table.status='INACTIVE' WHERE member_id='$member_id'");
	header("Location:../business_dashboard/index.php?deactivated=$member_id");
	exit();
}
else{
	header("Location:../index.php?entry=error");
	exit();
}