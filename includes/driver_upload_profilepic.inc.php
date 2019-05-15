<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['memberid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(!isset($_POST['uploadp'])){
		header("Location:../business_dashboard/Member_dashboard/index.php?error");
		exit();
	}
	else{
		$member_id=$_SESSION['memberid'];
		$target_dir = "driversprofilepic/";
		$tt=explode(".", $_FILES['image_file']['name']);
		$newtt=round(microtime(true));
		$target_file = $target_dir . uniqid("",false) . basename($_FILES["image_file"]["name"]);
		$name_of_image = $newtt . basename($_FILES["image_file"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if(isset($_POST["uploadp"])) {
			$check = getimagesize($_FILES["image_file"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		if ($_FILES["image_file"]["size"] > 700000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ){
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0){
			echo "Sorry, your file was not uploaded.";
		}
		else{
			$sql="SELECT * FROM official_member_table WHERE member_id='$member_id'";
			$res=mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($res);
			$img=$row['member_profile_pic'];
			if($img!=null)
			{
			unlink($img);
			}
			if(move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)){
				$sql="UPDATE official_member_table SET
					member_profile_pic='$target_file' WHERE
					member_id='$member_id'";
				mysqli_query($conn,$sql);
				// echo $target_file." ".$member_id;
				header("Location:../business_dashboard/Member_dashboard/index.php?profile_pic_upload=success");
				exit();
			}
			else{
				echo "Sorry, error uploading the file. Perhaps try again?<br>";
				echo '<a href="../business_dashboard/Member_dashboard/index.php?profile_pic_upload=error">Return to Profile</a>';
			}
		}
	}
}