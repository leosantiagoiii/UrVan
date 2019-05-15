<?php session_start();
require "dbconnect.inc.php";
if(isset($_POST['sendbutton'])){

	$OrgName=$_POST['OrgName'];
	$count=$_POST['count'];
	$startDate=$_POST['startDate'];
	$endDate=$_POST['endDate'];
	$email=$_POST['email'];
	$contactPerson=$_POST['contactPerson'];
	$contactNumber=$_POST['contactNumber'];
	$msgContent=$_POST['msgContent'];

	$from=$email;
	$to="support@urvan.webstarterz.com";
	$subject="QUOTE REQUEST FROM ".$OrgName;
	$message='
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet"> 
		 <style>
		 	body{
		 		font-family: \'Source Sans Pro\', sans-serif;
		 		padding:20px;
		 	}
		 </style>
	</head>
	<body>
	For how many people: '.
	$count
	.'<br>
	Start of Trip: '.
	$startDate
	.'<br>
	End of Trip: '.
	$endDate
	.'<br>'.
	$msgContent
	.'<br>
	Contact Person: '.
	$contactPerson
	.'<br>
	Contact Number: '.
	$contactNumber
	.'</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: ".$from."\r\n";
	mail($to,$subject,$message,$headers);

// 


	$from="noreply@urvan.webstarterz.com";
	$to=$email;
	$subject="QUOTE REQUEST NOTIFICATION FOR ".$OrgName;
	$message='
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet"> 
		 <style>
		 	body{
		 		font-family: \'Source Sans Pro\', sans-serif;
		 		padding:20px;
		 	}
		 </style>
	</head>
	<body>
	<h1>Hi! You recently sent us a message regarding your wish to partner with us.</h1>
	<p>Sometimes we respond slow, but rest assured we\'re going to the moment we see it. Until then, please patiently wait. We will respond either to the email you used, or contact number you\'ve given.</p>
	<p>======================================================================</p>
	<p>Here\'s the contents of your message: </p><br>
	For how many people: '.
	$count
	.'<br>
	Start of Trip: '.
	$startDate
	.'<br>
	End of Trip: '.
	$endDate
	.'<br>'.
	$msgContent
	.'<br>
	Contact Person: '.
	$contactPerson
	.'<br>
	Contact Number: '.
	$contactNumber
	.'<br>
	<p>======================================================================</p>
	<p>If none of this is familiar, contact us IMMEDIATELY. Thank you.</p>
	</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: ".$from."\r\n";
	mail($to,$subject,$message,$headers);

	header("Location:../quotation.php?msg=sent");
	exit();
}
else{
	echo 'Forbidden';
}