<?php session_start();
require "dbconnect.inc.php";

if($_GET['type']=="A"){//driveroerator
	$member_id=$_GET['member_id'];
	$member_email=$_GET['member_email'];
	$hash=md5(rand(0,1000));
	$sql=mysqli_query($conn,"SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	$row=mysqli_fetch_assoc($sql);
	mysqli_query($conn,"INSERT INTO verify_mem_table (verify_id,member_id,verify_hash,verify_active,member_first_name,member_username,member_email,member_password) VALUES ('','$member_id','$hash','1','$row[member_first_name]','$row[member_username]','$member_email','$row[member_password]')");

	mysqli_query($conn,"INSERT INTO official_member_table SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_member_emergency_contact_table SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");

	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$member_id','MEMBER')");

	mysqli_query($conn,"DELETE FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_member_appointment WHERE member_id='$member_id'");

	// $from="noreply@urvan.webstarterz.com";
	// $to=$member_email;
	// $subject="Confirm your email, ".$member_appointment_first_name;
	// $message='<html><head>Email Confirmation</head><p>Click the link below to verify your account, @'.$member_email.'</p><p>http://urvan.webstarterz.com/verify_member.php?member_email='.$member_email.'&hash='.$hash.'</p><p>Email -'.$member_email.'<br>Temporary Password -'.$init_pw.'</p></html>';
	// $headers = "MIME-Version: 1.0" . "\r\n";
	// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	// $headers .= "From: UrVan / BTTSC ".$from."\r\n";
	// mail($to,$subject,$message,$headers);

	header("Location:../business_dashboard/mem_requests.php?account=approve");
}
elseif($_GET['type']=="B"){//driversonly
	$member_id=$_GET['member_id'];
	$member_email=$_GET['member_email'];
	$hash=md5(rand(0,1000));
	$sql=mysqli_query($conn,"SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	$row=mysqli_fetch_assoc($sql);
	mysqli_query($conn,"INSERT INTO verify_mem_table (verify_id,member_id,verify_hash,verify_active,member_first_name,member_username,member_email,member_password) VALUES ('','$member_id','$hash','1','$row[member_first_name]','$row[member_username]','$member_email','$row[member_password]')");

	mysqli_query($conn,"INSERT INTO official_member_table SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_member_emergency_contact_table SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_authorized_driver_table SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_authorized_driver_emergency_contact_table SELECT * FROM initial_official_authorized_driver_emergency_contact_table WHERE member_id='$member_id'");

	$po=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	while($pou=mysqli_fetch_assoc($po)){
		mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$pou[driver_id]','AUTH_DRIV')");
	}

	mysqli_query($conn,"DELETE FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_authorized_driver_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_member_appointment WHERE member_id='$member_id'");

	header("Location:../business_dashboard/mem_requests.php?account=approve");
}
elseif($_GET['type']=="C"){//both
	$member_id=$_GET['member_id'];
	$member_email=$_GET['member_email'];
	$hash=md5(rand(0,1000));
	
	$sql=mysqli_query($conn,"SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	$row=mysqli_fetch_assoc($sql);
	mysqli_query($conn,"INSERT INTO verify_mem_table (verify_id,member_id,verify_hash,verify_active,member_first_name,member_username,member_email,member_password) VALUES ('','$member_id','$hash','1','$row[member_first_name]','$row[member_username]','$member_email','$row[member_password]')");

	mysqli_query($conn,"INSERT INTO official_member_table SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_member_emergency_contact_table SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_authorized_driver_table SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	mysqli_query($conn,"INSERT INTO official_authorized_driver_emergency_contact_table SELECT * FROM initial_official_authorized_driver_emergency_contact_table WHERE member_id='$member_id'");

	mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$member_id','MEMBER')");
	$po=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	while($pou=mysqli_fetch_assoc($po)){
		mysqli_query($conn,"INSERT INTO driver_queue (main_id,driver_pk,type) VALUES ('','$pou[driver_id]','AUTH_DRIV')");
	}

	mysqli_query($conn,"DELETE FROM initial_official_member_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_official_authorized_driver_emergency_contact_table WHERE member_id='$member_id'");
	mysqli_query($conn,"DELETE FROM initial_member_appointment WHERE member_id='$member_id'");

	header("Location:../business_dashboard/mem_requests.php?account=approve");
}