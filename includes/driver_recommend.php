<?php session_start();
require "dbconnect.inc.php";
$person_id=$_POST['person_id'];
$email_add=$_POST['email_add'];
$person_name=$_POST['person_name'];
if(isset($_POST['driverButton'])){
	mysqli_query($conn,"INSERT INTO training_seminar_table_present (
		training_id,person_id,email_add,person_name,type,invite) VALUES (
		'','$person_id','$email_add','$person_name','DRIVER','0')");


	$from="noreply@urvan.webstarterz.com";
	$to=$email_add;
	$subject="You've been invited to a training seminar | BTTSC";
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
				Hi, '.$person_name.'! You\'ve been invited to a training seminar. This is not in any way required but you\'re highly encouraged to attend.
			</p>
			<p><i>
				Ang event na ito ay magbibigay pansin sa mga pwede mong gawin para matuwa ang iyong mga pasahero.
			</i></p>
			<h5>Details to follow.</h5>
		</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);


	header("Location:../business_dashboard/drivers.php?entry=success");
	exit();
}
elseif(isset($_POST['memberButton'])){
	mysqli_query($conn,"INSERT INTO training_seminar_table_present (
		training_id,person_id,email_add,person_name,type,invite) VALUES (
		'','$person_id','$email_add','$person_name','MEMBER','0')");

	$from="noreply@urvan.webstarterz.com";
	$to=$email_add;
	$subject="You've been invited to a training seminar | BTTSC";
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
				Hi, '.$person_name.'! You\'ve been invited to a training seminar. This is not in any way required but you\'re highly encouraged to attend.
			</p>
			<p><i>
				Ang event na ito ay magbibigay pansin sa mga pwede mong gawin para matuwa ang iyong mga pasahero.
			</i></p>
			<h5>Details to follow.</h5>
		</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);
	
	header("Location:../business_dashboard/drivers.php?entry=success");
	exit();
}
else{
	header("Location:../index.php?entry=error");
	exit();
}