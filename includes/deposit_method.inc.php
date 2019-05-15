<?php session_start();
require "dbconnect.inc.php";
$major_id=$_POST['major_id'];
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(isset($_POST['cansel'])){
		if(isset($_POST['kamama'])){
			$sk=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
			$skk=mysqli_fetch_assoc($sk);
			if($skk['duration']>=1){
				mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='RECEIVED' WHERE major_id='$major_id'");
			}
			elseif($skk['duration']<=0){
				mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='RECEIVED' WHERE major_id='$major_id'");
			}
		}
		$sql="UPDATE booking_majordetails SET completion='YES', refunded='YES' WHERE major_id='$major_id'";
		mysqli_query($conn,$sql);
		
		$cancelDriver=mysqli_query($conn,"UPDATE driver_queue SET status=null, acceptance=null, start_date=null, end_date=null WHERE status='$major_id'");

		$hel=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
		$hi=mysqli_fetch_assoc($hel);
		$tour_id=$hi['tour_id'];
		$pre=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
		$bil=mysqli_num_rows($pre);
		if($bil>=1){
			$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
		}
		else{
			$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
		}
		
		header("Location:../reservations.php?cancelled=yes");
		exit();
	}
	elseif(isset($_POST['uplowd'])){
		$referencenum=$_POST['referencenum'];
		$target_dir="depositslips/";
		// abc tt
		$abc=explode(".", $_FILES['depositpic']['name']);
		// abchash newtt
		$abchash=round(microtime(true));
		$target_file = $target_dir . uniqid("",false) . basename($_FILES["depositpic"]["name"]);
		$name_of_image = $abchash . basename($_FILES["depositpic"]["name"]);
		$uploadOk = null;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["depositpic"]["tmp_name"]);
		if($check!==false){
			$uploadOk=1;
		}
		else{
			echo "not an img!<br>";
			$uploadOk=0;
		}
		if ($_FILES["depositpic"]["size"] > 1000000){
			echo "File too large<br>";
			$uploadOk=0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		if($uploadOk==0){
			echo "img not uploaded<br>";
			exit();
		}
		else{
			$sql="SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'";
			$res=mysqli_query($conn,$sql);
			$sql=mysqli_fetch_assoc($res);
			$img=$sql['deposit_slip'];
			if($sql['deposit_slip']==null){}
			else{unlink($img);}
			if(move_uploaded_file($_FILES["depositpic"]["tmp_name"], $target_file)){
				$sql="UPDATE booking_deposit_slip SET
				deposit_slip='$target_file', reference_num='$referencenum', approval='PENDING' WHERE
				major_id='$major_id'";
				mysqli_query($conn,$sql);
				header("Location:../reservations.php?deposit_slip=uploaded");
				exit();
			}
			else{
				echo "Sorry error uploading ur file<br>";
				exit();
			}
		}
	}
	elseif(isset($_POST['upup'])){
		$referencenum=$_POST['referencenum'];
		$target_dir="depositslips/";
		// abc tt
		$abc=explode(".", $_FILES['depositpic']['name']);
		// abchash newtt
		$abchash=round(microtime(true));
		$target_file = $target_dir . uniqid("",false) . basename($_FILES["depositpic"]["name"]);
		$name_of_image = $abchash . basename($_FILES["depositpic"]["name"]);
		$uploadOk = null;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["depositpic"]["tmp_name"]);
		if($check!==false){
			$uploadOk=1;
		}
		else{
			echo "not an img<br>";
			$uploadOk=0;
		}
		if ($_FILES["depositpic"]["size"] > 1000000){
			echo "File too large<br>";
			$uploadOk=0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		if($uploadOk==0){
			echo "img not uploaded<br>";
			exit();
		}
		else{
			$sql="SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'";
			$res=mysqli_query($conn,$sql);
			$sql=mysqli_fetch_assoc($res);
			$img=$sql['deposit_slip'];
			if($sql['deposit_slip']==null){}
			else{unlink($img);}
			if(move_uploaded_file($_FILES["depositpic"]["tmp_name"], $target_file)){
				$sql="UPDATE booking_deposit_slip SET
				deposit_slip='$target_file', reference_num='$referencenum', approval='PENDING' WHERE
				major_id='$major_id'";
				mysqli_query($conn,$sql);
				header("Location:../reservations.php?deposit_slip=uploaded");
				exit();
			}
			else{
				echo "Sorry error uploading ur file<br>";
				exit();
			}
		}
	}
}