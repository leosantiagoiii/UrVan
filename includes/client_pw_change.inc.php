<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(isset($_POST['savechange'])){
		$oldpw=$_POST['oldpw'];
		$newpw=$_POST['newpw'];
		$repeatpw=$_POST['repeatpw'];
		if(empty($oldpw)||empty($newpw)||empty($repeatpw)){
			header("Location:../client_password_settings.php?emptyfields");
			exit();
		}
		else{
			if($newpw!=$repeatpw){
				header("Location:../client_password_settings.php?notequal");
				exit();
			}
			else{
				if($oldpw==$newpw){
					header("Location:../client_password_settings.php?samepass");
					exit();
				}
				else{
					$sql=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id=$_SESSION[clientid]");
					if($row=mysqli_fetch_assoc($sql)){
						$verify=password_verify($oldpw,$row['client_password']);
						if($verify==FALSE){
							header("Location:../client_password_settings.php?entered_wrong_old_pw");
							exit();
						}
						else{
							if($oldpw==$newpw){
								header("Location:../client_password_settings.php?samepass");
								exit();
							}
							else{
								$encrypt=password_hash($newpw,PASSWORD_DEFAULT);
								$cli=$_SESSION['clientid'];
								$rez="UPDATE clients_table SET client_password='$encrypt' WHERE client_id='$cli'";
								mysqli_query($conn,$rez);

								$from="noreply@urvan.webstarterz.com";
								$to=$row['client_email'];
								//$replyto=""; bttsc email
								$subject="Notif for Password Change ".$member_appointment_first_name;
								$message='<html>
								<head>Password Change</head>
								<body style=\'background-color:skyblue;padding:30px;\'>
								<h1>Hi, @'.$row['client_username'].'</h1>
								<p>
									This is to inform you that you\'ve changed your password. <br>
									If this is something you didn\'t do, please contact us immediately.
								</p>
								<pre>
									Thank you.
								</pre>
								</body>
								</html>';
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= "From: UrVan / BTTSC ".$from."\r\n";
								//$headers .= 'Reply-to: <'.$replyto.'>' . "\r\n"; bttsc email
								mail($to,$subject,$message,$headers);

								header("Location:../client_password_settings.php?pw_change=success");
								exit();
							}
						}
					}
				}
			}
		}
	}
	elseif(isset($_GET['generatepw'])){
		function randomPassword() {
			$alphabet = 'ab!!cdef!ghijklm@no.pqr@stuvw.xyzABCDE.FGHIJKLMNOPQRSTUVWXYZ_@**!_._';
			$pass = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < 9; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass);
		}
		$newpw=randomPassword();
		header("Location:../client_password_settings.php?generate=success&generatedpw=$newpw");
		exit();
	}
	elseif(isset($_GET['clear'])){
		header("Location:../client_password_settings.php?clear=complete");
		exit();
	}
	else{
		header("Location:../client_password_settings.php?error");
		exit();
	}
}