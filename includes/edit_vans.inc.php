<?php session_start();
if(isset($_POST['savechanges_hho']) && isset($_SESSION['adminid'])){
	require "dbconnect.inc.php";
	$member_id=$_POST['member_id_2'];
	$vehicle_id=$_POST['vehicle_id_2'];

	$make=$_POST['make'];
	$plate_number=$_POST['plate_number'];
	$model=$_POST['model'];
	$franchised=$_POST['franchised'];
	$year=$_POST['year'];
	$status=$_POST['status'];

	$update="
	UPDATE vehicle_table
	SET
	make='$make',
	plate_number='$plate_number',
	model='$model',
	year='$year',
	status='$status'
	WHERE
	id='$vehicle_id';
	";
	mysqli_query($conn,$update);

	if($franchised=="YES"){
		if($status=="ACTIVE"){
			$sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE vehicle_id='$vehicle_id'");
			$sqnum=mysqli_num_rows($sq);
			if($sqnum<=0){
				mysqli_query($conn,"INSERT INTO vehicleQueue_franchised (franc_id,vehicle_id,member_id) VALUES ('','$vehicle_id','$member_id')");
			}
		}
		else{//inactive
			$sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE vehicle_id='$vehicle_id'");
			$sqnum=mysqli_num_rows($sq);
			if($sqnum<=1){
				mysqli_query($conn,"DELETE FROM vehicleQueue_franchised WHERE vehicle_id='$vehicle_id'");
			}
		}
	}
	else{//no
		if($status=="ACTIVE"){
			$sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicle_id'");
			$sqnum=mysqli_num_rows($sq);
			if($sqnum<=0){
				mysqli_query($conn,"INSERT INTO vehicleQueue_not_franchised (franc_id,vehicle_id,member_id) VALUES ('','$vehicle_id','$member_id')");
			}
		}
		else{//inactive
			$sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicle_id'");
			$sqnum=mysqli_num_rows($sq);
			if($sqnum<=1){
				mysqli_query($conn,"DELETE FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicle_id'");
			}
		}
	}


	header("Location:../business_dashboard/edit_remove_vehi.php?edited=success&member_id=$member_id&vehicle_id=$vehicle_id");
	exit();
}
else{
	echo "Forbidden";
}