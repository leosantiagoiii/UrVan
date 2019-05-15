<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?error");
	exit();
}
else{
	if(!isset($_POST['uploadp'])){
		header("Location:../client_profile.php?error");
		exit();
	}
	else{
		$client_id=$_POST['client_id'];
		$target_dir = "clientpic/";
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
		if ($_FILES["image_file"]["size"] > 1000000) {
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
			$sql="SELECT * FROM clients_table WHERE client_id='$client_id'";
			$res=mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($res);
			$img=$row['client_profilepic'];
			if($row['client_profilepic']!=null){
				unlink($img);
			}
			if(move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)){
				$sql="UPDATE clients_table SET
					client_profilepic='$target_file' WHERE
					client_id='$client_id'";
				mysqli_query($conn,$sql);
				header("Location:../client_profile.php?profile_pic_upload=success");
				exit();
			}
			else{
				echo "Sorry, error uploading the file. Perhaps try again?<br>";
				echo '<a href="../client_profile.php?profile_pic_upload=error">Return to Profile</a>';
			}
		}
	}
}