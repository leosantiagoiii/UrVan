<?php 
session_start();
require 'dbconnect.inc.php';

if( isset($_POST['edit-button']) ){

	$news_id=$_POST['news-id'];
	$news_content=$_POST['news-content'];
	$news_title=$_POST['news-title'];
	$news_is_featured=$_POST['isfeatured'];

	if($news_is_featured=='TRUE'){
		$news_is_featured='TRUE';
	}else{
		$news_is_featured='FALSE';
	}

	$update="UPDATE news_and_updates_table  
	SET news_is_featured='$news_is_featured', news_title='$news_title', news_content='$news_content', news_edited=CURRENT_TIMESTAMP() WHERE news_id=$news_id";
	$uresult=mysqli_query($conn,$update);

	if( (file_exists($_FILES['news_image']['tmp_name'])) OR (is_uploaded_file($_FILES['news_image']['tmp_name'])) ){
		$packages_image = addslashes(file_get_contents($_FILES['news_image']['tmp_name']));
	    $packages_image_name = addslashes($_FILES['news_image']['name']);
	    $packages_image_size = getimagesize($_FILES['news_image']['tmp_name']);
	    $okie=null;
		if($packages_image_size!==false){
			$okie=1;
		}
		else{
			$okie=0;
			echo "header img not uploaded";
			exit();
		}
		if($_FILES["news_image"]["size"]>1000000){
			$okie=0;
			echo "header img too large";
			exit();
		}
		if($okie==0){
			echo "header img not uploaded";
			exit();
		}
		else{
    		$sql="UPDATE news_and_updates_table
    		SET news_image_name='$packages_image_name', news_image='$packages_image' WHERE
    		news_id='$news_id'";
    		if(!mysqli_query($conn,$sql)){
    			echo 'unsuccessful. You may have not used the correct file type.';
    			exit();
    		}else{
    			//echo 'successful';
    		}
		}
	}

	$count=count($_FILES['news_gallery']['name']);
	if( isset($count) AND $count >=2 ){
		for($i=0;$i<$count;$i++){
			$target_dir="newsgallery/";
			$x=explode(".", $_FILES['news_gallery']['name'][$i]);
	        $newx=round(microtime(true));
	        $target_file = $target_dir . $newx . basename($_FILES["news_gallery"]["name"][$i]);
	        $name_of_image = $newx . basename($_FILES['news_gallery']['name'][$i]);
	        $uploadOk = 1;
	        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	        $check = getimagesize($_FILES['news_gallery']['tmp_name'][$i]);
	        if($check !== false){
	            //echo "File is an image - " . $check["mime"] . ".";
	            $uploadOk = 1;
	        }
	        else{
	            echo "File is not an image.";
	            $uploadOk = 0;
	            exit();
	        }
	        if (file_exists($target_file)){
	            echo "Sorry, file already exists.";
	            $uploadOk = 0;
	            exit();
	        }
	        if ($_FILES["news_gallery"]["size"][$i] > 1000000){
	            echo "Sorry, your file is too large.";
	            $uploadOk = 0;
	            exit();
	        }
	        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	            && $imageFileType != "gif" ){
	            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	            $uploadOk = 0;
	            exit();
	        }
	        if ($uploadOk == 0){
	            echo "Sorry, your file was not uploaded.";
	            exit();
	        }
	        else{
	        	if (move_uploaded_file($_FILES["news_gallery"]["tmp_name"][$i], $target_file)){
	                $sql="INSERT INTO news_and_updates_gallery_table 
	                (news_gallery_id,news_id,target_dir) VALUES ('','$news_id','$target_file')";
	                mysqli_query($conn,$sql);
	            }
	            else{
	                echo "Sorry, there was an error uploading your file.";
	            }
	        }
		}
	}
	else{
		echo "Add more photos. Can't just be one";
		// exit();
	}

	header("Location:../business_dashboard/admin_news_and_updates_edit.php?news_id=$news_id");
	exit();
}

elseif(isset($_GET['deletebutton'])){
	$sql="SELECT * FROM news_and_updates_gallery_table WHERE news_gallery_id='$_GET[news_gallery_id]'";
	$result=mysqli_query($conn,$sql);
	$qq="UPDATE news_and_updates_table SET
	news_edited=CURRENT_TIMESTAMP() WHERE
	news_id=$_GET[news_id]";
	$rere=mysqli_query($conn,$qq);
	while($row=mysqli_fetch_assoc($result)){
		unlink($row['target_dir']);
	}
	$news_id=$_GET['news_id'];
	header("Location:../business_dashboard/admin_news_and_updates_edit.php?news_id=$news_id");
	exit();
}

elseif(isset($_POST['Del'])){
	$news_id=$_POST['news-id'];
	$k="SELECT * FROM news_and_updates_gallery_table WHERE news_id='$news_id'";
	$m=mysqli_query($conn,$k);
	$cl=mysqli_num_rows($m);
	// while($row=mysqli_fetch_assoc($re)){
	// 	unlink($row['target_dir']);
	// }
	mysqli_query($conn,"
		INSERT INTO news_and_updates_archive_table
		SELECT * FROM news_and_updates_table
		WHERE news_id='$news_id'
		");
	mysqli_query($conn,"
		UPDATE news_and_updates_archive_table SET
		news_edited=CURRENT_TIMESTAMP()
		WHERE news_id='$news_id'
		");
	$sq="DELETE FROM news_and_updates_table WHERE news_id='$news_id'";
	$re=mysqli_query($conn,$sq);
	header("Location:../business_dashboard/admin_news_and_updates.php?delete=success");
	exit();
}

elseif(isset($_GET['removeheaderphoto'])){
	$news_id=$_GET['news_id'];
	$sql="UPDATE news_and_updates_table SET
	news_image_name=NULL, news_image=NULL, news_edited=CURRENT_TIMESTAMP()
	WHERE news_id='$news_id'";
	mysqli_query($conn,$sql);
	header("Location:../business_dashboard/admin_news_and_updates_edit.php?news_id=$news_id");
	exit();
}

else{
	echo 'forbidden';
	header('Location:../index.php?error=forbidden');
}