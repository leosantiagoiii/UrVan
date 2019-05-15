<?php session_start();
if(isset($_POST['uploadProfPic']) AND isset($_SESSION['driverid'])){
	if(!file_exists($_FILES['profilePicAuthDriv']['tmp_name']) || !is_uploaded_file($_FILES['profilePicAuthDriv']['tmp_name'])){
		echo "You didn't upload anything";
		exit();
	}
	require 'dbconnect.inc.php';
	$driver_id=$_POST['driver_id'];
	$target_dir="driversprofilepic/";

	$explodedFileName=explode(".", $_FILES['profilePicAuthDriv']['name']);
	$roundMicro=round(microtime(true));
	$target_file = $target_dir . uniqid("",false) . basename($_FILES["profilePicAuthDriv"]["name"]);
	$imgName = $roundMicro . basename($_FILES["profilePicAuthDriv"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	$check=getimagesize($_FILES["profilePicAuthDriv"]["tmp_name"]);
	if($check !== false){
		$uploadOk=1;
	}
	else{
		$uploadOk=0;
		echo "This is a ".$check['mime'];
	}
	if(file_exists($target_file)){
		$uploadOk=0;
		echo "File already exists";
	}
	if($_FILES["profilePicAuthDriv"]["size"] > 1000000){
		echo "File too large";
		$uploadOk=0;
	}
	if($imageFileType!="jpg" && $imageFileType!="png" && $imageFileType!="jpeg" && $imageFileType!="gif" ){
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	if ($uploadOk == 0){
		echo "Img not uploaded";
		exit();
	}
	else{
		$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$driver_id'");
		$row=mysqli_fetch_assoc($sql);
		if($row['driver_profile_pic']!=null){
			unlink($row['driver_profile_pic']);
		}
		if(move_uploaded_file($_FILES["profilePicAuthDriv"]["tmp_name"],$target_file)){
			$sql=mysqli_query($conn,"UPDATE official_authorized_driver_table SET driver_profile_pic='$target_file' WHERE driver_id='$driver_id'");
			header("Location:../driv_settings.php?pic=uploaded");
			exit();
		}
		else{
			echo "Sorry, your file wasn't uploaded";
			exit();
		}
	}
}