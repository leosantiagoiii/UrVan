<?php session_start();
date_default_timezone_set("Asia/Manila");
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?entry=error");
}
else{
	if(!isset($_POST['bookbtn'])){
		header("Location:../index.php?entry=error");
	}
	else{
		require "dbconnect.inc.php";

		$tour_id=$_POST['tour_id'];

		if(isset($_POST['pax'])){
			$paxi=$_POST['pax'];
			$vanndriv=ceil($paxi/12);//

			$M=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
			$Cp=mysqli_num_rows($M);
			if($Cp>=1){
				$sqqq1=mysqli_query($conn,"SELECT COUNT(*) AS countTheDrivers FROM driver_queue WHERE status IS NULL");
				$sqqq2=mysqli_fetch_assoc($sqqq1);
				$freeDriverCount=$sqqq2['countTheDrivers'];//
				$sqqq1=mysqli_query($conn,"SELECT COUNT(*) AS countTheVans FROM vehicleQueue_franchised WHERE status IS NULL");
				$sqqq2=mysqli_fetch_assoc($sqqq1);
				$freeVanCount=$sqqq2['countTheVans'];//
				if( ($vanndriv>$freeDriverCount) OR ($vanndriv>$freeVanCount) ){
					header("Location:../error_book.php?booking=error&amount=driverANDvan_not_enough&tour_id=$_POST[tour_id]");
					exit();
				}
			}
			else{
				$sqqq1=mysqli_query($conn,"SELECT COUNT(*) AS countTheDrivers FROM driver_queue WHERE status IS NULL");
				$sqqq2=mysqli_fetch_assoc($sqqq1);
				$freeDriverCount=$sqqq2['countTheDrivers'];//
				$sqqq1=mysqli_query($conn,"SELECT COUNT(*) AS countTheVans FROM vehicleQueue_not_franchised WHERE status IS NULL");
				$sqqq2=mysqli_fetch_assoc($sqqq1);
				$freeVanCount=$sqqq2['countTheVans'];//
				if( ($vanndriv>$freeDriverCount) OR ($vanndriv>$freeVanCount) ){
					header("Location:../error_book.php?booking=error&amount=driverANDvan_not_enough&tour_id=$_POST[tour_id]");
					exit();
				}
			}
		}

		$longitude=$_POST['longitude'];
		$place_id=$_POST['place_id'];//
		$latitude=$_POST['latitude'];
		// $hash=sha1(rand(0,1000));
		$hash=uniqid("",false);
		$hash="1TR".$hash;
		// $hash=substr($hash,0,-33);
		$hash=strtoupper($hash);
		$client_id=$_SESSION['clientid'];
		$startDate=$_POST['startDate'];
		$startDate2=$_POST['startDate'];
		$startDate3=strtotime($startDate2);
		$_SESSION['date_js']=DATE("Y/m/d",$startDate3);
		if(isset($_POST['endDate'])){
			$endDate=$_POST['endDate'];
			$endDateB=strtotime($endDate);
			$_SESSION['end_date']=DATE("Y/m/d",$endDateB);
		}
		else{
			$endDate=$_POST['startDate'];
			$endDateB=strtotime($endDate);
			$_SESSION['end_date']=DATE("Y/m/d",$endDateB);
		}
		$startDateCalc=strtotime($startDate);
		// $endDateCalc=strtotime($endDate);
		$reportingPlace=$_POST['reportingPlace'];
		$reportingTime=$_POST['reportingTime'];
		$pax=$_POST['pax'];
		$contact_person=$_POST['contact_person'];
		$contact_persons_number=$_POST['contact_persons_number'];
		$tour_name=$_POST['tour_name'];
		$rightNow=$_POST['rightNow'];
		$rightNow=strtotime($rightNow);
		$rightNow=date('Y-m-d',$rightNow);
		$oneWeek=date('Y-m-d',strtotime("+1 week"));
		$oneWeek=strtotime($oneWeek);
		$tooMuch=date('Y-m-d',strtotime("+1 month"));
		$tooMuch=strtotime($tooMuch);
		$rightNow=strtotime($rightNow);
		// $dayz=$endDateCalc-$startDateCalc;
		// $dayz=$dayz/86400;
		// $dayz=intval($dayz);
		
		
// PUT THIS BACK
		if($startDateCalc<=$oneWeek){
			header("Location:../book_trip.php?date=one_week_dapat&tour_id=$tour_id&tour_name=$tour_name&now=$rightNow");
			exit();
		}
// 		if(!isset($oneWeek)){
// 			header("Location:../book_trip.php?date=one_week_dapat&tour_id=$tour_id&tour_name=$tour_name&now=$rightNow");
// 			exit();
// 		}
		else{
			$sql="INSERT INTO booking_majordetails (major_id,client_id,tour_id,start_date,reporting_place,reporting_time,pax,contact_person,contact_persons_number,completion,refunded,longitude,latitude,place_id) VALUES ('$hash','$client_id','$tour_id','$startDate','$reportingPlace','$reportingTime','$pax','$contact_person','$contact_persons_number','NO','NO','$longitude','$latitude','$place_id')";
			mysqli_query($conn,$sql);
			// if($dayz>=1){
			// 	mysqli_query($conn,"INSERT INTO booking_balance (id,major_id,client_id,status) VALUES ('','$hash','$client_id','UNPAID')");
			// }
			header("Location:../itineraries.php?major_id=$hash&tour_id=$tour_id&bookingstill&start=$startDate&duration=$endDate");
			// header("Location:../itineraries.php?major_id=$hash&tour_id=$tour_id&bookingstill&start=$startDate&end=$endDate");
			exit();
		}
	}
}