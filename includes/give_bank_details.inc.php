<?php
session_start();
require "dbconnect.inc.php";
if(isset($_GET['send_info'])){
	$major_id=$_GET['major_id'];
	$refund_bank=$_GET['refund_bank'];
	$refund_account_number=$_GET['refund_account_number'];
	mysqli_query($conn,"UPDATE refund_table SET refund_bank='$refund_bank', refund_account_number='$refund_account_number' WHERE major_id='$major_id'");
	mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='GIVEN' WHERE major_id='$major_id'");
	header("Location:../refunds_sec.php?bank_details=given");
} ?>