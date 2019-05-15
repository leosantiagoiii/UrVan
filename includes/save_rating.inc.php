<?php session_start();
require "dbconnect.inc.php";
if(isset($_POST['send_data'])){
	$q1=$_POST['q1'];
	$q2=$_POST['q2'];
	$q3=$_POST['q3'];
	$q4=$_POST['q4'];
	$q5=$_POST['q5'];
	$final_q=(($q1+$q2+$q3+$q4+$q5)/5);
	$history_id=$_POST['history_id'];
	$rating_id=$_POST['rating_id'];
	$major_id=$_POST['major_id'];
	$tour_id=$_POST['tour_id'];
	$driver_type=$_POST['driver_type'];
	$driver_pk=$_POST['driver_pk'];
	$van_id=$_POST['van_id'];
	$remark=$_POST['remark'];

	mysqli_query($conn,"UPDATE booking_rating_sub SET booking_rating_sub.value='$q1' WHERE rating_id='$rating_id' AND questions='1'");
	mysqli_query($conn,"UPDATE booking_rating_sub SET booking_rating_sub.value='$q2' WHERE rating_id='$rating_id' AND questions='2'");
	mysqli_query($conn,"UPDATE booking_rating_sub SET booking_rating_sub.value='$q3' WHERE rating_id='$rating_id' AND questions='3'");
	mysqli_query($conn,"UPDATE booking_rating_sub SET booking_rating_sub.value='$q4' WHERE rating_id='$rating_id' AND questions='4'");
	mysqli_query($conn,"UPDATE booking_rating_sub SET booking_rating_sub.value='$q5' WHERE rating_id='$rating_id' AND questions='5'");

	mysqli_query($conn,"UPDATE booking_rating_overall SET booking_rating_overall.value='$final_q', booking_rating_overall.remarks='$remark' WHERE history_id='$history_id'");

	header("Location:../index.php?rating=done");
	exit();
}