<?php 
session_start();
require 'dbconnect.inc.php';

if( isset($_POST['edit-button']) ){

	$package_id=$_POST['package-id'];
	$package_name=$_POST['package-name'];
	$package_price=$_POST['package-price'];
	$package_description=$_POST['package-desc'];
	$completeadd=$_POST['completeadd'];
	$latitude=$_POST['latitude'];
	$longitude=$_POST['longitude'];
	$sale=$_POST['sale'];
	$NCR_choice=$_POST['NCR_choice'];
	$single_trip=$_POST['single_trip'];

	$update="UPDATE tours_and_packages_table 
	SET tour_name='$package_name', tour_description='$package_description', tour_price=$package_price 
	WHERE tour_id=$package_id";
	$uresult=mysqli_query($conn,$update);

	$up=mysqli_query($conn,"SELECT * FROM tours_sales WHERE tour_id='$package_id'");
	$num=mysqli_num_rows($up);

	if($sale=="yes"){
		mysqli_query($conn,"INSERT INTO tours_sales (id,tour_id) VALUES ('','$package_id')");
	}
	else{ //no
		mysqli_query($conn,"DELETE FROM tours_sales WHERE tour_id='$package_id'");
	}

	if(!empty($_FILES['tour_image']['tmp_name'])){
		$packages_image = addslashes(file_get_contents($_FILES['tour_image']['tmp_name']));
	    $packages_image_name = addslashes($_FILES['tour_image']['name']);
	    $packages_image_size = getimagesize($_FILES['tour_image']['tmp_name']);

	    $okie=null;
		if($packages_image_size!==false){
			$okie=1;
		}
		else{
			$okie=0;
			echo "header img not uploaded";
			exit();
		}
		if($_FILES["tour_image"]["size"]>1000000){
			$okie=0;
			echo "header img too large";
			exit();
		}
		if($okie==0){
			echo "header img not uploaded";
			exit();
		}else{
			$sql="UPDATE tours_and_packages_table
    		SET tour_image_name='$packages_image_name', tour_image='$packages_image' WHERE
    		tour_id='$package_id'";
    		if(!mysqli_query($conn,$sql)){
    			echo 'unsuccessfull';
    		}else{
    			//echo 'successful';
    		}
		}
	}

	$count=count($_FILES['tours_gallery']['name']);
	if($count>=2){
	    for($i=0;$i<$count;$i++){
	        $target_dir="tourgallery/";
	        $x=explode(".", $_FILES['tours_gallery']['name'][$i]);
	        $newx=round(microtime(true));
	        $target_file = $target_dir . $newx . basename($_FILES["tours_gallery"]["name"][$i]);
	        $name_of_image = $newx . basename($_FILES['tours_gallery']['name'][$i]);
	        $uploadOk = 1;
	        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	        $check = getimagesize($_FILES['tours_gallery']['tmp_name'][$i]);
	        if($check !== false){
	            //echo "File is an image - " . $check["mime"] . ".";
	            $uploadOk = 1;
	        }
	        else{
	            echo "File is not an image.";
	            $uploadOk = 0;
	        }
	        if (file_exists($target_file)){
	            echo "Sorry, file already exists.<br>";
	            $uploadOk = 0;
	        }
	        if ($_FILES["tours_gallery"]["size"][$i] > 1000000){
	            echo "Sorry, your file is too large.<br>";
	            $uploadOk = 0;
	        }
	        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	            && $imageFileType != "gif" ){
	            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
	            $uploadOk = 0;
	        }
	        if ($uploadOk == 0){
	            echo "Sorry, your file was not uploaded.";
	        }
	        else{
	            if (move_uploaded_file($_FILES["tours_gallery"]["tmp_name"][$i], $target_file)){
	                $sql="INSERT INTO tours_and_packages_gallery_table 
	                (tour_gallery_id,tour_id,target_dir) VALUES ('','$package_id','$target_file')";
	                mysqli_query($conn,$sql);
	            }
	            else{
	                echo "Sorry, there was an error uploading your file.";
	            }
	        }
	    }
	}

	$r=mysqli_query($conn,"SELECT * FROM tour_and_packages_location WHERE tour_id='$package_id'");
	$y=mysqli_num_rows($r);
	if($y<=0){
		mysqli_query($conn,"INSERT INTO tour_and_packages_location (id,tour_id,formatted_address,longitude,latitude) VALUES ('','$package_id','$completeadd','$longitude','$latitude')");
	}
	else{
		mysqli_query($conn,"UPDATE tour_and_packages_location SET formatted_address='$completeadd',
		longitude='$longitude',
		latitude='$latitude' WHERE tour_id='$package_id'");
	}

	if($NCR_choice=="YES"){
		$mqi=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$package_id'");
		$oop=mysqli_num_rows($mqi);
		if($oop<=0){
			mysqli_query($conn,"INSERT INTO tours_and_packages_NCR (tour_id) VALUES ('$package_id')");
		}
	}
	else{//no
		$mqi=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$package_id'");
		$oop=mysqli_num_rows($mqi);
		if($oop>=1){
			mysqli_query($conn,"DELETE FROM tours_and_packages_NCR WHERE tour_id='$package_id'");
		}
	}

	if($single_trip=="YES"){
		$mop=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$package_id'");
		$rue=mysqli_num_rows($mop);
		if($rue<=0){
			mysqli_query($conn,"INSERT INTO tours_and_packages_single (tour_id) VALUES ('$package_id')");
		}
	}
	else{
		$mop=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$package_id'");
		$rue=mysqli_num_rows($mop);
		if($rue>=1){
			mysqli_query($conn,"DELETE FROM tours_and_packages_single WHERE tour_id='$package_id'");
		}
	}

	header("Location:../business_dashboard/admin_tours_and_packages_edit.php?tour_id=$package_id");
	exit();

}

elseif(isset($_GET['deletebutton'])){

	$sql="SELECT * FROM tours_and_packages_gallery_table WHERE tour_gallery_id='$_GET[tour_gallery_id]'";
	$result=mysqli_query($conn,$sql);

	while($row=mysqli_fetch_assoc($result)){
		unlink($row['target_dir']);
	}
	$tour_id=$_GET['tour_id'];

	header("Location:../business_dashboard/admin_tours_and_packages_edit.php?tour_id=$tour_id");
	exit();
}

if(isset($_POST['Delete-button'])){

	$tour_id=$_POST['package-id'];
	$query=mysqli_query($conn,"SELECT * FROM tours_and_packages_gallery_table WHERE tour_id='$tour_id'");
	$count=mysqli_num_rows($query);

	mysqli_query($conn,"
		INSERT INTO tours_and_packages_archive_table
		SElECT * FROM tours_and_packages_table
		WHERE tour_id='$tour_id'
		");


	$sq="DELETE FROM tours_and_packages_table WHERE tour_id='$tour_id'";
	$re=mysqli_query($conn,$sq);

	header("Location:../business_dashboard/admin_tours_and_packages.php?delete=success");
	exit();

}

else{
	echo 'forbidden';
	header('Location:../index.php?error=forbidden');
	exit();
}