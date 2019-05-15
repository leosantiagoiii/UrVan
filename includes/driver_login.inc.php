<?php
if(isset($_POST['loginBtn'])){
	require "dbconnect.inc.php";
	$uname=$_POST['uname'];
	$password=$_POST['pword'];
	if(empty($_POST['uname'])||empty($_POST['pword'])){
		header("Location: ../driver_login.php?error=emptyFields&uname=$uname&pword=$password");
		exit();
	}
	else{
		$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_email='$uname'");
		$count=mysqli_num_rows($sql);
		if($count<=0){
			$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_email='$uname' OR member_username='$uname' AND member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1')");
			$count=mysqli_num_rows($sql);
			if($count<=0){
				// echo $count;
				header("Location: ../driver_login.php?entry=no_user_in_db");
				exit();
			}
			else{
				if($row=mysqli_fetch_assoc($sql)){
					$pwCheck=password_verify($password, $row['member_password']);
					if($pwCheck==FALSE){
						header("Location:../driver_login.php?error=wrongpassword&uname=$uname");
            			exit();
					}
					else{
						session_start();
						$_SESSION['driverid']=$row['member_id'];
						$_SESSION['drivername']=$row['member_first_name'].' '.$row['member_last_name'];
						$_SESSION['type']="MEMBER";
						date_default_timezone_set('Asia/Singapore');
						$sql2="INSERT INTO activity_log_table 
							(activity_log_id,
							activity_log_activity,
							activity_log_time,
							activity_log_username,
							activity_log_role) VALUES 
							('',
							'LOGIN',
							CURRENT_TIMESTAMP(),
							'$_SESSION[driverid]',
							'DRIVER')";
						mysqli_query($conn,$sql2);
						header("Location:../index.php?login=driver_success");
		            	exit();
		            }
				}
			}
		}
		else{
			if($row=mysqli_fetch_assoc($sql)){
				$pwCheck = password_verify($password,$row['driver_password']);
				if($pwCheck==FALSE){
					header("Location:../driver_login.php?error=wrongpassword&uname=$uname");
            		exit();
				}
				else{ // if true
					session_start();
					$_SESSION['driverid']=$row['driver_id'];
					$_SESSION['drivername']=$row['driver_name'];
					$_SESSION['type']="DRIVER";
					date_default_timezone_set('Asia/Singapore');
					$sql2="INSERT INTO activity_log_table 
						(activity_log_id,
						activity_log_activity,
						activity_log_time,
						activity_log_username,
						activity_log_role) VALUES 
						('',
						'LOGIN',
						CURRENT_TIMESTAMP(),
						'$_SESSION[driverid]',
						'DRIVER')";
					mysqli_query($conn,$sql2);
					header("Location:../index.php?login=driver_success");
	            	exit();
				}
			}
		}
	}
}
else{
	header("Location: ../index.php?error=pg");
	exit();
}