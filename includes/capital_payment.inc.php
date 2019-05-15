<?php session_start();
require "dbconnect.inc.php";
$cash=$_GET['cash'];
$member_id=$_GET['member_id'];
$xyz=$_GET['xyz'];
if(!isset($_SESSION['adminid'])){
		header("Location:../index.php?error");
		exit();
}
else{
	if(!isset($_GET['submitb'])){
		header("Location:../index.php?error");
		exit();
	}
	else{
		//pag 0 complete payment, 1 otherwise
		mysqli_query($conn,"INSERT INTO official_member_capital (id,member_id,amount,status) VALUES ('','$member_id','$cash','APPROVED')");
		$sql=mysqli_query($conn,"SELECT SUM(amount) AS total_amt FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'");
		$row=mysqli_fetch_assoc($sql);
		$x=$row['total_amt'];
		$x=abs($x-60000.00);
		$x=number_format($x,2,".",""); //remaining new
		if($x<=0){
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=0");
		}
		else{
			header("Location:../business_dashboard/subsc_cap_2.php?remaining=$x&member_id=$member_id&xyz=$xyz");
		}
		exit();
	}
}