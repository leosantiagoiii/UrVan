<?php session_start();

if(!isset($_POST['FinishRequest'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}else{
	require "dbconnect.inc.php";

	$member_appointment_number=$_POST['member_appointment_number'];

	$member_appointment_datemeet=$_POST['member_appointment_datemeet'];
	$member_appointment_timemeet=$_POST['member_appointment_timemeet'];

	function random_middle(){
	    $alphabet = 'abcdefghijklmnopqrstuvwxyz0956124387ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function random_password(){
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	$sql="SELECT * FROM member_appointment_details_table 
	WHERE
		member_appointment_number='$member_appointment_number'";
	$query=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($query)){
		$firstname=$row['member_appointment_first_name'];
	}
	$middlename=random_middle();
	$namearray=array($firstname,$middlename);

	$username_m=implode("", $namearray);
	$username=preg_replace('/\s+/', '', $username_m);
	$password=random_password();

	$sql="
		UPDATE
			member_appointment_details_table 
		SET 
			member_appointment_datemeet='$member_appointment_datemeet',
			member_appointment_timemeet='$member_appointment_timemeet',
			member_appointment_username='$username',
			member_appointment_password='$password',
			member_appointment_approval='PENDING'
		WHERE 
			member_appointment_number='$member_appointment_number'
	";
	mysqli_query($conn,$sql);
	
	header("Location:../signup_member5.php?member_appointment_number=$member_appointment_number&appointmentreq_stepfour=approved");
	exit();
}

