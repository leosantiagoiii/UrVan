<?php session_start();
require "dbconnect.inc.php";
$training_id=$_GET['training_id'];
$email_add=$_GET['email_add'];
if(isset($_GET['unin'])){
	mysqli_query($conn,"DELETE FROM training_seminar_table_present WHERE training_id='$training_id'");


	$from="noreply@urvan.webstarterz.com";
	$to=$email_add;
	$subject="Invite: Revoked | BTTSC";
	$message='
	<html>
		<head>
			<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
			<style type=\'text/css\' media=\'screen\'>
				body{
					font-family: \'Sarabun\', sans-serif;
				}
			</style>
		</head>
		<body>
			<p>
				Hi, '.$email_add.'! We have seem to sent you an email a while ago regarding the training seminar. Worry not, you don\'t have to attend anymore. 
			</p>
			<p><i>
				Apologies.
			</i></p>
			<h5>-URVAN / BTTSC</h5>
		</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);


	header("Location:../business_dashboard/training_sem.php?uninvite=success");
	exit();
}
else{
	header("Location:../index.php?entry=error");
	exit();
}