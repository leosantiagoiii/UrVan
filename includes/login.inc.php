<?php

if(isset($_POST['login-button'])){

	require "dbconnect.inc.php";

	$unemail = $_POST['mail-and-uname'];
	$password = $_POST['password'];

	if(empty($unemail)||empty($password)){ //emptyfields
		header("Location: ../login.php?error=emptyfields&mail-and-uname=".$unemail);
		exit();
	}
	else{
		$sql = "SELECT * FROM clients_table WHERE client_username=? OR client_email=?";
		$statement = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($statement,$sql)){
			header("Location:../index.php?error=sqlerror");
            exit();
		}
		else{
			mysqli_stmt_bind_param($statement,"ss",$unemail,$unemail);
			mysqli_stmt_execute($statement);
			$result=mysqli_stmt_get_result($statement);
			if($row=mysqli_fetch_assoc($result)){
				$password_check=password_verify($password,$row['client_password']);
				if($password_check==false){ //wrong password
					header("Location:../login.php?error=wrongpassword&mail-and-uname=".$unemail);
            		exit();
				}
				elseif($password_check==true){ //correct password
					
					$kura="SELECT * FROM verify_client_table WHERE client_id=$row[client_id]";
					$rezulta=mysqli_query($conn,$kura);
					$fetchz=mysqli_fetch_assoc($rezulta);
					$fetchz['client_verify'];

					if($fetchz['client_verify']=='1'){
						session_start();
						$_SESSION['clientid']=$row['client_id'];
						$_SESSION['clientuname']=$row['client_username'];
						$_SESSION['clientfname']=$row['client_first_name'];
						mysqli_query($conn,"INSERT INTO active_accs (id,acc_id) VALUES ('',$_SESSION[clientid])");
						date_default_timezone_set('Asia/Singapore');
						$timeh=date('H:i:s');
						mysqli_query($conn,"INSERT INTO for_activeusers (id,acc_id,log_at) VALUES ('',$_SESSION[clientid],'$timeh')"); 
						$freu="INSERT INTO activity_log_table 
						(activity_log_id,
						activity_log_activity,
						activity_log_time,
						activity_log_username,
						activity_log_role) VALUES 
						('',
						'LOGIN',
						CURRENT_TIMESTAMP(),
						'$_SESSION[clientuname]',
						'CLIENT')";
						mysqli_query($conn,$freu);
						header("Location:../index.php?login=success");
	            		exit();
            		}
            		else{
            			//echo 'You have not verified your account yet';
            			$client_id=$row['client_id'];
            			$client_fname=$row['client_first_name'];
            			$email=$row['client_email'];
            			header("Location:../verify_client.php?verification=unfinished&client_id=$client_id&client_fname=$client_fname&email=$email");
	            		exit();
            		}
				}
				else{ // wrong password
					header("Location:../login.php?error=wrongpassword");
					exit();
				}
			}
			else{ //no user in db
				header("Location:../login.php?error=nouserindatabase&mail-and-uname=");
            	exit();
			}
		}
	}

}
else {
    echo '<h1>forbidden</h1><br>please return to the homepage. click <a href="../index.php">here</a>';
}