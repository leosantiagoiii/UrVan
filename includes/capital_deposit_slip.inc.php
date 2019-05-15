<?php session_start();
require "dbconnect.inc.php";
$member_id=$_GET['member_id'];
$id=$_GET['id'];
if(!isset($_SESSION['adminid'])){
		header("Location:../index.php?error");
		exit();
}
else{
	if(isset($_GET['app'])){
		mysqli_query($conn,"UPDATE `official_member_capital` SET `status` = 'APPROVED' WHERE `official_member_capital`.`id` = '$id'");
		$sql=mysqli_query($conn,"SELECT SUM(amount) AS total_amt FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'");
		$row=mysqli_fetch_assoc($sql);
		$x=$row['total_amt'];
		$x=abs($x-60000.00);
		$x=number_format($x,2,".",""); //remaining new
		if($x<=0){
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=0");
			// echo $x."<br>".$member_id;
		}
		else{
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=1");
			// echo $x."<br>".$member_id;
		}
		exit();
	}
	elseif(isset($_GET['dec'])){
		mysqli_query($conn,"UPDATE `official_member_capital` SET `status` = 'DECLINED' WHERE `official_member_capital`.`id` = '$id'");
		$sql=mysqli_query($conn,"SELECT SUM(amount) AS total_amt FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'");
		$row=mysqli_fetch_assoc($sql);
		$x=$row['total_amt'];
		$x=abs($x-60000.00);
		$x=number_format($x,2,".",""); //remaining new
		if($x<=0){
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=0");
			// echo $x."<br>".$member_id;
		}
		else{
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=1");
			// echo $x."<br>".$member_id;
		}
		exit();
	}
	else{
		header("Location:../index.php?error");
		exit();
	}
}