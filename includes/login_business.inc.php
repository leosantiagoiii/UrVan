<?php if(isset($_POST['login-admin-button'])){
require "dbconnect.inc.php";
$unameemail=$_POST['admin-email-uname'];
$password=$_POST['admin-password'];
if(empty($unameemail)||empty($password)){
	header("Location: ../business_dashboard/login.php?error=emptyfields&admin-email-uname=".$unameemail);
		exit();
}
else{
	$sqladmin="SELECT * FROM admin_table WHERE ( admin_username = '$unameemail' OR admin_email = '$unameemail' )";
	$adminaccq=mysqli_query($conn,$sqladmin);
	$adminres=mysqli_num_rows($adminaccq);
	if($adminres=1){
		if($row=mysqli_fetch_assoc($adminaccq)){
			$checkpw=password_verify($password,$row['admin_password']);
			if($checkpw==false){
				header("Location:../business_dashboard/login.php?wrongpassword=admin");
				exit();
			}
			else{
				session_start();
				$_SESSION['adminid']=$row['admin_id'];
				$_SESSION['adminuname']=$row['admin_username'];
				$_SESSION['adminfname']=$row['admin_first_name'];
				$_SESSION['adminlname']=$row['admin_last_name'];
				mysqli_query($conn," INSERT INTO activity_log_table
					(activity_log_id,
					activity_log_activity,
					activity_log_time,
					activity_log_username,
					activity_log_role)
					VALUES
					('',
					'LOGIN',
					CURRENT_TIMESTAMP(),
					'$_SESSION[adminuname]',
					'ADMIN') ");
				header("Location:../business_dashboard/?login=success");
				exit();
			}
		}
		else{
			$sqlmember="SELECT * FROM official_member_table WHERE ( member_username = '$unameemail' OR member_email = '$unameemail' )";
			$memberaccq=mysqli_query($conn,$sqlmember);
			$memberres=mysqli_num_rows($memberaccq);
			if($memberres>0){
				if($row=mysqli_fetch_assoc($memberaccq)){
					$checkpw=password_verify($password,$row['member_password']);
					if($checkpw==false){
						header("Location:../business_dashboard/login.php?wrongpassword=member");
				        exit();
					}
					else{
						$sqlactivate="SELECT * FROM verify_mem_table WHERE (member_username='$unameemail' OR member_email='$unameemail') ";
						$act=mysqli_query($conn,$sqlactivate);
						$rowa=mysqli_fetch_assoc($act);
						if($rowa['verify_active']=='0'){
						    //can't access acount bc not activated
							echo 'not activated';
						}elseif($rowa['verify_active']=='1'){
						//continue to access bc activated
						//echo 'activated';
							if($row['active']==0){
								session_start();
								$_SESSION['memberid']=$row['member_id'];
								$_SESSION['memberfname']=$row['member_first_name'];
								$_SESSION['memberlname']=$row['member_last_name'];
								$_SESSION['memberusername']=$row['member_username'];
								mysqli_query($conn," INSERT INTO activity_log_table
								(activity_log_id,
								activity_log_activity,
								activity_log_time,
								activity_log_username,
								activity_log_role)
								VALUES
								('',
								'LOGIN',
								CURRENT_TIMESTAMP(),
								'$_SESSION[memberusername]',
								'ADMIN') ");
								header("Location:../business_dashboard/Member_dashboard");
								exit();
							}
							else{
								echo "sorry. can't login. account suspended";
							}
						}
						//session_start();
					}
				}
				else{
					header("Location:../business_dashboard/login.php?account=does_not_exist");
					exit();
				}
			}
			else{
				header("Location:../business_dashboard/login.php?account=does_not_exist");
			exit();
			}
		}
	}
}
////////////
////////////
}
else {
echo '<h1>forbidden</h1><br>please return to the homepage. click <a href="../index.php">here</a>';
}