<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['finished_trip'])){
	$major_id=$_GET['major_id'];
	$driver_pk=$_GET['driver_pk'];
	$type=$_GET['type'];
	if($type=="DRIVER"){
		$type="AUTH_DRIV";
		$sop=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$driver_pk'");
		$sopi=mysqli_fetch_assoc($sop);
		$getDrivName=$sopi['driver_name'];
	}
	else{
		$type="MEMBER";
		$sop=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$driver_pk'");
		$sopi=mysqli_fetch_assoc($sop);
		$getDrivName=$sopi['member_first_name'].' '.$sopi['member_last_name'];
	}
	$getVanid=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major_id' AND driver_pk='$driver_pk'");
	$getVanid_=mysqli_fetch_assoc($getVanid);
	$van_id=$getVanid_['vehicle_id'];
	mysqli_query($conn,"INSERT INTO booking_history_trip
		(
		history_id,major_id,driver_pk,driver_type,van_id
		) VALUES (
		'','$major_id','$driver_pk','$type','$van_id'
		)
		");
	$getIdForRating=mysqli_insert_id($conn);
	$sql=mysqli_query($conn,"SELECT * FROM booking_clients WHERE major_id='$major_id'");
	$getCliid=mysqli_fetch_assoc($sql);
	$client_id=$getCliid['client_id'];
	$sql=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
	$getem=mysqli_fetch_assoc($sql);
	$email=$getem['client_email'];

	$quip=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$van_id'");
	$quipo=mysqli_fetch_assoc($quip);
	$getVanName=$quipo['make'].' '.$quipo['model'].' - '.$quipo['plate_number'];

	$from="noreply@urvan.webstarterz.com";
	$to=$email;
	$subject="EVALUATION ASSESSMENT FOR TRIP ".$major_id." (VEHICLE: ".$getVanName.")";
	$message='
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="">
		<style>
			body{
				margin:0;
				padding:0;
				background-color: #007bff;
				color:white;
			}
		</style>
	</head>
	<body>
		<h1>Evaluation!</h1>
		You rode <b>'.$getVanName.'</b> & your driver was '.$getDrivName.'<br>
		Open this link: <a href="http://urvan.webstarterz.com/trip_evalt1on.php?history_id='.$getIdForRating.'&rating">here</a> for the trip evaluation.
	</body>
	</html>';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);

	mysqli_query($conn,"INSERT INTO booking_rating_overall (
		rating_id,history_id,sent_to
		)
		VALUES (
		'','$getIdForRating','$email'
		)");
	$getIdForWholeRating=mysqli_insert_id($conn);
	mysqli_query($conn,"UPDATE booking_history_trip SET rating_id='$getIdForWholeRating' WHERE history_id='$getIdForRating'");
	for($i=1;$i<=5;$i++){
		mysqli_query($conn,"INSERT INTO booking_rating_sub (rating_sub_id,questions,rating_id,value) VALUES ('','$i','$getIdForWholeRating',NULL)");
	}
	$getmainid=mysqli_query($conn,"SELECT * FROM driver_queue WHERE acceptance='accepted' AND status='$major_id' AND driver_pk='$driver_pk'");
	$ha=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$m=mysqli_fetch_assoc($ha);
	$tour_id=$m['tour_id'];
	$sqlm=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
	$mai=mysqli_num_rows($sqlm);
	if($mai>=1){
		$getvahi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE vehicle_id='$van_id' AND status='$major_id'");
	}
	else{
		$getvahi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE vehicle_id='$van_id' AND status='$major_id'");
	}
	$getMain=mysqli_fetch_assoc($getmainid);
	$getVeh=mysqli_fetch_assoc($getvahi);
	$main_id=$getMain['main_id'];
	$franc_id=$getVeh['franc_id'];
	$member_id=$getVeh['member_id'];
	mysqli_query($conn,"DELETE FROM driver_queue WHERE main_id='$main_id'");	
	if($mai>=1){
		mysqli_query($conn,"DELETE FROM vehicleQueue_franchised WHERE franc_id='$franc_id'");	
	}
	else{
		mysqli_query($conn,"DELETE FROM vehicleQueue_not_franchised WHERE franc_id='$franc_id'");	
	}
	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$driver_pk','$type')");
	if($mai>=1){
		mysqli_query($conn,"INSERT INTO vehicleQueue_franchised (franc_id,vehicle_id,member_id) VALUES ('','$van_id','$member_id')");
	}
	else{
		mysqli_query($conn,"INSERT INTO vehicleQueue_not_franchised (franc_id,vehicle_id,member_id) VALUES ('','$van_id','$member_id')");
	}
	mysqli_query($conn,"UPDATE booking_majordetails SET completion='YES' WHERE major_id='$major_id'");
	header("Location:../list_trips.php");
	exit();
}