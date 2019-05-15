<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(isset($_POST['deactivate_button'])){
		if(!isset($_POST['hash_to_deac'])){
			header("Location:../client_acct_deactivation.php?no_hash");
			exit();
		}
		else{
			$hash=$_POST['hash_to_deac'];
			if($_POST['hash_to_deac']!=$hash){
				header("Location:../client_acct_deactivation.php?wrong_hash");
				exit();
			}
			else{
				$client_id=$_POST['client_id'];

				// verify first before sending a request
				$sql=mysqli_query($conn,"SELECT * FROM client_deact_request WHERE client_id=$client_id");
				$count=mysqli_num_rows($sql);
				if($count>=1){
					header("Location:../client_acct_deactivation.php?DEAC_REQ_EMAIL=ALREADY_SENT");
					exit();
				}

				// get email
				$sql=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id=$client_id");
				$row=mysqli_fetch_assoc($sql);
				$member_email=$row['client_email'];

				// hash
				$hash=SHA1(rand(0,1000));

				// deac id
				$new_hash=SHA1(rand(0,1000));
				$xyz='clidc'.substr($new_hash, 35);
				$deac_id=strtoupper($xyz);

				// email
				$from="noreply@urvan.webstarterz.com";
				$to=$member_email;
				$subject="Deactivation Request For, ".$row['client_username'];
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
				<body style=\'padding:30px;background-color:skyblue;font-family:helvetica;\'>
				<h1>Hi, '.$row['client_first_name'].'</h1>
				<p>We received an account deactivation requesr from you. We\'re really sad to see you go! :( But if your decision\'s final, please click the link below:</p>
				<p>http://urvan.webstarterz.com/deac_client_verify.php?rediredi=123a_k&client_id='.$client_id.'&id='.$deac_id.'&deac_hash='.$hash.'</p>
				<pre>Best Regards,</pre>
				<pre>BTSSC x UrVan</pre>
				</body>
				</html>
				';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: UrVan / BTTSC ".$from."\r\n";
				mail($to,$subject,$message,$headers);

				$sql2="INSERT INTO client_deact_request
				(id,client_id,client_email,deac_hash)
				VALUES
				('$deac_id','$client_id','$member_email','$hash')";
				mysqli_query($conn,$sql2);

				//echo $deac_id.' '.$client_id.' '.$member_email.' '.$hash;

				header("Location:../client_acct_deactivation.php?DEAC_REQ_EMAIL=SENT");
				exit();
			}
		}
	}
	elseif(isset($_POST['cancel_request'])){
		$client_id=$_POST['client_id'];
		mysqli_query($conn,"DELETE FROM client_deact_request WHERE client_id='$client_id'");
		header("Location:../client_acct_deactivation.php?DEAC_REQ_EMAIL=CANCELLED");
		exit();
	}
	else{
		header("Location:../client_acct_deactivation.php?didNOT_pass_button");
		exit();
	}
}