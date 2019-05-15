<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(!isset($_POST['savechanges'])){
		header("Location:../index.php?entry=error");
		exit();
	}
	else{
		$member_id=$_POST['member_id'];
		$member_first_name=$_POST['member_first_name'];
		$count=$_POST['count'];
		$make=$_POST['make'];
		$plate_number=$_POST['plate_number'];
		$model=$_POST['model'];
		$franchised=$_POST['franchised'];
		$status=$_POST['status'];
		$year=$_POST['year'];

		if($status=="ACTIVE"){
			$active_v=1;
		}
		else{
			$active_v=0;
		}

		$sql="INSERT INTO vehicle_table
		(id,status,member_id,member_first_name,make,model,year,plate_number,franchised,active_v)
		VALUES
		('','$status','$member_id','$member_first_name','$make','$model','$year','$plate_number','$franchised','$active_v')";
		mysqli_query($conn,$sql);

		$last_id=mysqli_insert_id($conn);

		$sql="SELECT * FROM vehicle_table WHERE member_id='$member_id'";
		$sal=mysqli_query($conn,$sql);

		$count=mysqli_num_rows($sal);

		if($status=="ACTIVE" AND $franchised=="YES"){
			mysqli_query($conn,"INSERT INTO vehicleQueue_franchised (franc_id,vehicle_id,member_id) VALUES ('','$last_id','$member_id')");
		}
		elseif($status=="ACTIVE" AND $franchised=="NO"){
			mysqli_query($conn,"INSERT INTO vehicleQueue_not_franchised (franc_id,vehicle_id,member_id) VALUES ('','$last_id','$member_id')");
		}

		header("Location:../business_dashboard/add_vehicles.php?member_id=$member_id&count=$count");
		exit();
	}
}