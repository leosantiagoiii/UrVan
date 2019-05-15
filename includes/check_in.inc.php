<?php session_start();
require "dbconnect.inc.php";
if(!isset($_POST['check_in'])){
	header();
	exit();
}
else{
	$major_id=$_POST['major_id'];
	mysqli_query($conn,"INSERT INTO checkin_tbl (checkin_id,major_id) VALUES ('','$major_id')");
	header("Location:../reservations.php?check_in=success");
	exit();
}