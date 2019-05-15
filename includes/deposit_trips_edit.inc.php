<?php session_start();
require "dbconnect.inc.php";
$major_id=$_POST['major_id'];
$client_id=$_POST['client_id'];
$amount=$_POST['amount'];
$transaction_type=$_POST['transaction_type'];
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(isset($_POST['apruba'])){

		if(isset($_POST['amount'])){
			$sqlll=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
			$ssja=mysqli_fetch_assoc($sqlll);
			$total=$ssja['total_amount']+$amount;
			mysqli_query($conn,"UPDATE booking_balance SET amount='$amount' WHERE major_id='$major_id'");
			mysqli_query($conn,"UPDATE booking_transactions SET total_afterbal='$total' WHERE major_id='$major_id'");
		}
		if( (file_exists($_FILES['costsummary']['tmp_name'])) || (is_uploaded_file($_FILES['costsummary']['tmp_name'])) ){
			$folderpath="summarycost/";
			$nm=SHA1(rand(0,1000000));
			$filename=$nm.basename($_FILES['costsummary']['name']);
			$newname=$folderpath.$filename;
			$filetype=pathinfo($newname,PATHINFO_EXTENSION);
			if($filetype=="pdf"){
				if(move_uploaded_file($_FILES['costsummary']['tmp_name'], $newname)){
					$you=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
					$youu=mysqli_fetch_assoc($you);
					$filez=$youu['filepath'];
					if($youu['filepath']!=null){
						unlink($filez);
					}
					mysqli_query($conn,"UPDATE booking_balance SET filepath='$newname' WHERE major_id='$major_id'");
				}
				else{
					echo "upload failed";
					exit();
				}
			}
			else{
				echo "must be a pdf";
				exit();
			}
		}

		header("Location:../business_dashboard/deposit_trips_details_edit.php?details=saved&transaction_type=$transaction_type&client_id=$client_id&major_id=$major_id&viewdee");
		exit();
	}
	elseif(isset($_POST['remub'])){
		$you=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
		$youu=mysqli_fetch_assoc($you);
		$filez=$youu['filepath'];
		if($youu['filepath']!=null){
			unlink($filez);
		}
		mysqli_query($conn,"UPDATE booking_balance SET amount=null, filepath=null WHERE major_id='$major_id'");
		mysqli_query($conn,"UPDATE booking_transactions SET total_afterbal=null WHERE major_id='$major_id'");
		header("Location:../business_dashboard/deposit_trips.php?entry=remvoed");
		exit();
	}
	else{
		header("Location:../index.php?entry=error");
		exit();
	}
}