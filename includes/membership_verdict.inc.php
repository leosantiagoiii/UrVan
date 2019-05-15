<?php session_start();
require "dbconnect.inc.php";
$member_appointment_number=$_POST['member_appointment_number'];
$member_appointment_last_name=$_POST['member_appointment_last_name'];
$member_appointment_middle_name=$_POST['member_appointment_middle_name'];
$member_appointment_first_name=$_POST['member_appointment_first_name'];
$member_appointment_birthdate=$_POST['member_appointment_birthdate'];
$member_appointment_address=$_POST['member_appointment_address'];
$member_appointment_phone_number=$_POST['member_appointment_phone_number'];
$member_appointment_civil_status=$_POST['member_appointment_civil_status'];
$member_appointment_blood_type=$_POST['member_appointment_blood_type'];
$member_appointment_weight=$_POST['member_appointment_weight'];
$member_appointment_height=$_POST['member_appointment_height'];
$member_appointment_tin=$_POST['member_appointment_tin'];
$member_appointment_drivers_licence=$_POST['member_appointment_drivers_licence'];
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}elseif(isset($_POST['ApproveButton'])){

	$member_email=$_POST['member_email'];

	$sql="UPDATE member_appointment_details_table SET
		member_appointment_last_name='$member_appointment_last_name',
		member_appointment_middle_name='$member_appointment_middle_name',
		member_appointment_first_name='$member_appointment_first_name',
		member_appointment_birthdate='$member_appointment_birthdate',
		member_appointment_address='$member_appointment_address',
		member_appointment_phone_number='$member_appointment_phone_number',
		member_appointment_civil_status='$member_appointment_civil_status',
		member_appointment_blood_type='$member_appointment_blood_type',
		member_appointment_weight='$member_appointment_weight',
		member_appointment_drivers_licence='$member_appointment_drivers_licence',
		member_appointment_height='$member_appointment_height',
		member_appointment_tin='$member_appointment_tin'
		WHERE member_appointment_number='$member_appointment_number'";
		mysqli_query($conn,$sql);

		$prefix='mem';
		$temp_id=uniqid('',false);
		$reduce=substr($temp_id, strlen($temp_id) - 6, strlen($temp_id));
		$id=$prefix.$reduce;
		$final_member_id=strtoupper($id);

		$init_pw=uniqid('',false);
		$hashed_pw=password_hash($init_pw,PASSWORD_DEFAULT);
		
		//for official_member_table
		$sql="
			INSERT INTO official_member_table (
			member_id,
			member_email,
			member_first_name,
			member_middle_name,
			member_last_name,
			member_profile_pic,
			member_address,
			member_phone_number,
			member_birthdate,
			member_civil_status,
			member_blood_type,
			member_weight,
			member_height,
			member_tin,
			member_drivers_licence,
			member_username,
			member_password
			)
			VALUES (
				'$final_member_id',
				'$member_email',
				(SELECT member_appointment_first_name FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_middle_name FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_last_name FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_profile_pic FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_address FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_phone_number FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_birthdate FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_civil_status FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_blood_type FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_weight FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_height FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_tin FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_drivers_licence FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_username FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				'$hashed_pw'
			)
		";
		mysqli_query($conn,$sql);

		//for official_member_emergency
		$sql="
			INSERT INTO official_member_emergency_contact_table (
			member_id,
			member_emergency_name,
			member_emergency_address,
			member_emergency_phone,
			member_emergency_relationship
			)
			VALUES (
				'$final_member_id',
				(SELECT member_appointment_emergency_name FROM member_appointment_emergency_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_emergency_address FROM member_appointment_emergency_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_emergency_phone FROM member_appointment_emergency_table WHERE member_appointment_number LIKE '$member_appointment_number'),
				(SELECT member_appointment_emergency_relationship FROM member_appointment_emergency_table WHERE member_appointment_number LIKE '$member_appointment_number')
			)
		";
		mysqli_query($conn,$sql);

		$dri_pw=uniqid('',false);
		$hashed_dri_pw=password_hash($dri_pw, PASSWORD_DEFAULT);

		//for official_member_authorised_driver
		$s="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number = '$member_appointment_number'";
		$m=mysqli_query($conn,$s);
		while($r=mysqli_fetch_assoc($m)){

			$prefix='dri';
			$temp_id=uniqid('',false);
			$reduce=substr($temp_id, strlen($temp_id) - 6, strlen($temp_id));
			$id=$prefix.$reduce;
			$final_driver_id=strtoupper($id);

			$sql="
			INSERT INTO official_authorized_driver_table (
			driver_id,
			member_id,
			driver_name,
			driver_profile_pic,
			driver_birthdate,
			driver_civil_status,
			driver_weight,
			driver_height,
			driver_blood_type,
			driver_tin,
			driver_licence,
			driver_contact,
			driver_email,
			driver_password
			)
			VALUES (
			'$final_driver_id',
			'$final_member_id',
			(SELECT member_appointment_driver_name FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_profpic FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_birthdate FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_civil_status FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_weight FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_height FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_blood FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_tin FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_drivers_licence FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_contact FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT mem_app_driv_email FROM member_appointment_driver_details_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			'$hashed_dri_pw'
			)
			";
			mysqli_query($conn,$sql);

			$skaa1=mysqli_query($conn,"SELECT mem_app_driv_email FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$r[member_appointment_driver_number]'");
			$sajk0=mysqli_fetch_assoc($skaa1);
			$emay=$sajk0['mem_app_driv_email'];

			$djs=mysqli_query($conn,"SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$r[member_appointment_driver_number]'");
			$saj=mysqli_fetch_assoc($djs);
			$dri_em=$saj['mem_app_driv_email'];
			$dri_nm=$saj['member_appointment_driver_name'];

			$from="noreply@urvan.webstarterz.com";
			$to=$dri_em;
			//$replyto=""; bttsc email
			$subject="Your email & PW, ".$dri_nm;
			$message='driver email = '.$emay.'<br>driver pw = '.$dri_pw;
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: UrVan / BTTSC ".$from."\r\n";
			//$headers .= 'Reply-to: <'.$replyto.'>' . "\r\n"; bttsc email
			mail($to,$subject,$message,$headers);

			//for driver emergency
			$sql="
			INSERT INTO official_authorized_driver_emergency_contact_table (
			driver_id,
			member_id,
			driver_emergency_name,
			driver_emergency_address,
			driver_emergency_contact,
			driver_emergency_relationship
			)
			VALUES (
			'$final_driver_id',
			'$final_member_id',
			(SELECT member_appointment_driver_emergency_name FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_emergency_address FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_emergency_contact FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number]),
			(SELECT member_appointment_driver_emergency_relationship FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$r[member_appointment_driver_number])
			)
			";
			mysqli_query($conn,$sql);
		}

		//confirmation email
		$hash=md5(rand(0,1000));
		$sql="
			INSERT INTO verify_mem_table
			(
			verify_id,
			member_id,
			verify_hash,
			verify_active,
			member_first_name,
			member_username,
			member_email,
			member_password
			) 
			VALUES 
			(
			'',
			'$final_member_id',
			'$hash',
			'0',
			'$member_appointment_first_name',
			(SELECT member_appointment_username FROM member_appointment_details_table WHERE member_appointment_number LIKE '$member_appointment_number'),
			'$member_email',
			'$init_pw'
		)";
		$res=mysqli_query($conn,$sql);

		$from="noreply@urvan.webstarterz.com";
		$to=$member_email;
		//$replyto=""; bttsc email
		$subject="Confirm your email, ".$member_appointment_first_name;
		$message='<html><head>Email Confirmation</head><p>Click the link below to verify your account, @'.$member_email.'</p><p>http://urvan.webstarterz.com/verify_member.php?member_email='.$member_email.'&hash='.$hash.'</p><p>Email -'.$member_email.'<br>Temporary Password -'.$init_pw.'</p></html>';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		//$headers .= 'Reply-to: <'.$replyto.'>' . "\r\n"; bttsc email
		mail($to,$subject,$message,$headers);

		mysqli_query($conn,"DELETE FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'");
		mysqli_query($conn,"DELETE FROM member_appointment_emergency_table WHERE member_appointment_number='$member_appointment_number'");
		mysqli_query($conn,"DELETE FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'");
		mysqli_query($conn,"DELETE FROM member_appointment_driver_emergency_table WHERE member_appointment_number='$member_appointment_number'");

		header("Location:../business_dashboard/admin_membership_requests.php?member=success&verification_email=sent");
		exit();
}elseif(isset($_POST['FollowupButton'])){

	$sql="UPDATE member_appointment_details_table SET
	member_appointment_last_name='$member_appointment_last_name',
	member_appointment_middle_name='$member_appointment_middle_name',
	member_appointment_first_name='$member_appointment_first_name',
	member_appointment_birthdate='$member_appointment_birthdate',
	member_appointment_address='$member_appointment_address',
	member_appointment_phone_number='$member_appointment_phone_number',
	member_appointment_civil_status='$member_appointment_civil_status',
	member_appointment_blood_type='$member_appointment_blood_type',
	member_appointment_weight='$member_appointment_weight',
	member_appointment_drivers_licence='$member_appointment_drivers_licence',
	member_appointment_height='$member_appointment_height',
	member_appointment_tin='$member_appointment_tin'
	WHERE member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	$sql="UPDATE member_appointment_details_table
	SET
	member_appointment_approval='PENDING'
	WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_requests.php?status=forfollowup");
	exit();
}elseif(isset($_POST['DenyButton'])){
	$sql="DELETE FROM member_appointment_details_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	
	$sql="DELETE FROM member_appointment_driver_details_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	
	$sql="DELETE FROM member_appointment_driver_emergency_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	
	$sql="DELETE FROM member_appointment_emergency_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	header("Location:../business_dashboard/admin_membership_requests.php?status=denied");
	exit();
}elseif(isset($_POST['ApproveAppointment'])){
	$sql="UPDATE member_appointment_details_table
	SET
	member_appointment_approval='APPROVED'
	WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_requests.php?status=appointmentapproved");
	exit();
}elseif(isset($_POST['ReschedAppoint'])){
	$sql="UPDATE member_appointment_details_table
	SET
	member_appointment_approval='DECLINED'
	WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_membership_requests.php?status=resched");
	exit();
}elseif(isset($_POST['DenyAppointment'])){
	$sql="DELETE FROM member_appointment_details_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	$sql="DELETE FROM member_appointment_driver_details_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	$sql="DELETE FROM member_appointment_driver_emergency_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	$sql="DELETE FROM member_appointment_emergency_table WHERE
	member_appointment_number='$member_appointment_number'";
	mysqli_query($conn,$sql);

	header("Location:../business_dashboard/admin_membership_requests.php?status=denied");
	exit();
}else{
echo 'forbidden. return home <a href="../index.php">here</a>';
}