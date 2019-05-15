<?php session_start();
require "dbconnect.inc.php";
if(isset($_GET['fin'])){
	$sqll=mysqli_query($conn,"SELECT * FROM seminar_table ORDER BY seminar_id DESC LIMIT 1");
	$sajh=mysqli_fetch_assoc($sqll);
	$get_id=$sajh['seminar_id'];
	$upda=mysqli_query($conn,"UPDATE training_seminar_table_present SET seminar_id='$get_id'");

	$sql=mysqli_query($conn,"SELECT * FROM training_seminar_table_present");
	while($row=mysqli_fetch_assoc($sql)){
		$from="noreply@urvan.webstarterz.com";
		$to=$row['email_add'];
		$date=$row['seminar_date'];
		$dates=strtotime($date);
		$datess=DATE("Y-M-d",$dates);
		$subject="Thank you for participating! (".$datess.")";
		$message="Thanks a lot for being so cooperative. We hope you learned a lot today!";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);
	}
	$sqll=mysqli_query($conn,"INSERT INTO training_seminar_table_past SELECT * FROM training_seminar_table_present");
	$sqll=mysqli_query($conn,"DELETE FROM training_seminar_table_present");
	mysqli_query($conn,"UPDATE seminar_table SET status='COMPLETE' WHERE seminar_id='$get_id'");
	header("Location:../business_dashboard/training_sem.php?invite=complete");
}
elseif(isset($_GET['can'])){
	$sqll=mysqli_query($conn,"SELECT * FROM seminar_table ORDER BY seminar_id DESC LIMIT 1");
	$sajh=mysqli_fetch_assoc($sqll);
	$get_id=$sajh['seminar_id'];
	mysqli_query($conn,"UPDATE training_seminar_table_present SET invite='0', seminar_id='$get_id'");

	$sql=mysqli_query($conn,"SELECT * FROM training_seminar_table_present");
	while($row=mysqli_fetch_assoc($sql)){
		$from="noreply@urvan.webstarterz.com";
		$to=$row['email_add'];
		$subject="Seminar Cancellation | BTTSC";
		$message="We have decided to cancel our training seminar. We deeply apologise for the turn of events. We'll immediately contact you and the others shall there be any concerns/follow ups. Have a great day!";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);
	}
	$sqll=mysqli_query($conn,"INSERT INTO training_seminar_table_past SELECT * FROM training_seminar_table_present");
	$sqll=mysqli_query($conn,"DELETE FROM training_seminar_table_present");
	mysqli_query($conn,"UPDATE seminar_table SET status='CANCELLED' WHERE seminar_id='$get_id'");
	header("Location:../business_dashboard/training_sem.php?invite=cancel");
}
else{
	header("Location:../index.php?entry=error");
	exit();
}