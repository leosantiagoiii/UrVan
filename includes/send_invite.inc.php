<?php session_start();
require "dbconnect.inc.php";
$subject=$_GET['subject'];
$semiDate=$_GET['semiDate'];
$semiTime=$_GET['semiTime'];
$message_deets=$_GET['message_deets'];
if(isset($_GET['send'])){
	$sql=mysqli_query($conn,"SELECT * FROM training_seminar_table_present");
	while($row=mysqli_fetch_assoc($sql)){
		$from="noreply@urvan.webstarterz.com";
		$to=$row['email_add'];
		$subject="SEMINAR DETAILS | BTTSC";
		$message='<html><h1>'.$subject.'</h1>'.$message_deets.'</html>';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);
		$sql2=mysqli_query($conn,"UPDATE training_seminar_table_present SET invite='1', seminar_date='$semiDate' WHERE training_id='$row[training_id]'");
	}
	mysqli_query($conn,"INSERT INTO seminar_table (seminar_id,seminar_date,seminar_time,status) VALUES ('','$semiDate','$semiTime','OK')");
	header("Location:../business_dashboard/training_sem.php?invite=sent");
}
else{
	header("Location:../index?entry=error");
	exit();
}