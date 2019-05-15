<?php session_start();
require "../includes/dbconnect.inc.php";
$major_id=$_POST['major_id'];
$client_id=$_POST['client_id'];
// not isset something

// gist of the code:
if(isset($_POST['aprubado'])){
	$refund_reference_no=$_POST['refund_reference_no'];
	mysqli_query($conn,"UPDATE refund_table SET refund_reference_no='$refund_reference_no' WHERE major_id='$major_id'");
	mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='APPROVED' WHERE major_id='$major_id'");
	header("Location:../business_dashboard/refunds_checker.php");
	exit();
}
elseif(isset($_POST['asking'])){
	mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='WAITING' WHERE major_id='$major_id'");
	$sql="
	INSERT INTO refund_table
	(
	major_id,client_id
	)
	VALUES
	(
	'$major_id','$client_id'
	)";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/refunds_checker.php");
	exit();
}