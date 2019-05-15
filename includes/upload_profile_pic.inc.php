<?php
session_start();
if(isset($_SESSION['memberapprovalacctid'])){
	if(isset($_POST['submitbutton'])){
		require 'dbconnect.inc.php';
		$member_appointment_number=$_SESSION['memberapprovalacctid'];
		$target_dir = "imagesupload/";
		$tt=explode(".", $_FILES['image_file']['name']);
		$newtt=round(microtime(true));
		$target_file = $target_dir . $newtt . basename($_FILES["image_file"]["name"]);
		$name_of_image = $newtt . basename($_FILES["image_file"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["image_file"]["tmp_name"]);
		if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
		} else {
		echo "File is not an image.";
		$uploadOk = 0;
		}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["image_file"]["size"] > 1000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		$aaa="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
		$bbb=mysqli_query($conn,$aaa);
		while($ccc=mysqli_fetch_assoc($bbb)){
			$img=$ccc['member_appointment_profile_pic'];
		}
		if($img!=null){
			unlink($img);
		}
		if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
			$sql="UPDATE member_appointment_details_table SET
				member_appointment_profile_pic='$target_file'
				WHERE
				member_appointment_number='$member_appointment_number'";
			mysqli_query($conn,$sql);
		header("Location:../signup_member_approval.php?upload=success");
		exit();
		} else {
		echo "Sorry, there was an error uploading your file.";
		}
		}
	}
	elseif(isset($_POST['removebutton'])){
		require 'dbconnect.inc.php';
		$member_appointment_number=$_SESSION['memberapprovalacctid'];
		$aaa="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
		$bbb=mysqli_query($conn,$aaa);
		while($ccc=mysqli_fetch_assoc($bbb)){
			$img=$ccc['member_appointment_profile_pic'];
		}
		$sql="UPDATE member_appointment_details_table SET
				member_appointment_profile_pic=NULL
				WHERE
				member_appointment_number='$member_appointment_number'";
		mysqli_query($conn,$sql);
		unlink($img);
		
		header("Location:../signup_member_approval.php?delete=success");
		exit();
	}
}
elseif(isset($_SESSION['adminid'])){
	if(isset($_POST['upload'])){
		require 'dbconnect.inc.php';
		$member_appointment_number=$_POST['member_appointment_number'];
		$target_dir = "imagesupload/";
		$tt=explode(".", $_FILES['image_file']['name']);
		$newtt=round(microtime(true));
		$target_file = $target_dir . $newtt . basename($_FILES["image_file"]["name"]);
		$name_of_image = $newtt . basename($_FILES["image_file"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["image_file"]["tmp_name"]);
		if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
		} else {
		echo "File is not an image.";
		$uploadOk = 0;
		}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["image_file"]["size"] > 1000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
			$sql="UPDATE member_appointment_details_table SET
				member_appointment_profile_pic='$target_file'
				WHERE
				member_appointment_number='$member_appointment_number'";
			mysqli_query($conn,$sql);
		header("Location:../business_dashboard/admin_membership_viewdetails.php?member_appointment_number=$member_appointment_number");
		exit();
		} else {
		echo "Sorry, there was an error uploading your file.";
		}
		}
	}
	elseif(isset($_POST['remove'])){
		require 'dbconnect.inc.php';
		$member_appointment_number=$_POST['member_appointment_number'];
		$aaa="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
		$bbb=mysqli_query($conn,$aaa);
		while($ccc=mysqli_fetch_assoc($bbb)){
			$img=$ccc['member_appointment_profile_pic'];
		}
		$sql="UPDATE member_appointment_details_table SET
				member_appointment_profile_pic=NULL
				WHERE
				member_appointment_number='$member_appointment_number'";
		mysqli_query($conn,$sql);
		unlink($img);
		header("Location:../business_dashboard/admin_membership_viewdetails.php?member_appointment_number=$member_appointment_number");
		exit();
	}
}
else{
	echo 'forbidden';
}