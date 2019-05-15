<?php 
session_start();
if(!isset($_SESSION['clientid'])){
	header("Location:../index.php?entry=error");
}
else{
	$longitude=$_POST['longitude'];
	$latitude=$_POST['latitude'];
	$place_id=$_POST['place_id_'];
	if(isset($_POST['savebutton'])){
		require "dbconnect.inc.php";
		// $hash=sha1(rand(0,1000));
		// $hash="2TR".$hash;
		// $hash=substr($hash,0,-33);
		$hash=uniqid("2TR",false);
		$hash=strtoupper($hash);
		$major_id=$_POST['major_id'];
		$tour_id=$_POST['tour_id'];
		$jk=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
		$jkk=mysqli_fetch_assoc($jk);
		$start_date=$jkk['start_date'];
		$start_date_time=strtotime($start_date);
		$destination=$_POST['destination'];
		if(isset($_POST['endDate'])){
			$endDate=$_POST['endDate'];
			$duration=(strtotime($endDate))-$start_date_time;
			$duration=$duration/86400;
			$duration=intval($duration);
			mysqli_query($conn,"UPDATE booking_majordetails SET end_date='$endDate', duration='$duration' WHERE major_id='$major_id'");
			if($duration>=1){
				$bal_q=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
				$balq_count=mysqli_num_rows($bal_q);
				if($balq_count<=0){
					mysqli_query($conn,"INSERT INTO booking_balance (id,major_id,client_id,status) VALUES ('','$major_id','$_SESSION[clientid]','UNPAID')");
				}
			}
		}
		if($_POST['remarks']==''){
			$remarks=NULL;
		}
		if(empty($_POST['remarks'])){
			$remarks=NULL;
		}
		$remarks=$_POST['remarks'];
		$starr=$_POST['starr'];
		$as=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
		$ass=mysqli_num_rows($as);
		if(empty($destination)){
			if($ass<=0){
				header("Location:../itineraries.php?input=empty&major_id=$major_id&tour_id=$tour_id&bookingstill&desti=$destination&remarks=$remarks&start=$starr&duration=$endDate");
			 	exit();
		 	}
		 	else{
		 		header("Location:../itineraries.php?input=empty&minor_id=$hash&major_id=$major_id&tour_id=$tour_id&bookingstill&desti=$destination&remarks=$remarks&start=$starr&duration=$endDate");
			 	exit();
		 	}
		}
		else{
			$sql="INSERT INTO booking_minordetails (minor_id,major_id,tour_id,destination,remarks,longitude,latitude,place_id) VALUES ('$hash','$major_id','$tour_id','$destination','$remarks','$longitude','$latitude','$place_id')";
			mysqli_query($conn,$sql);
			$kalal=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE minor_id='$hash' AND ETA IS NULL");
			$counu=mysqli_num_rows($kalal);
			if($counu==1){
				$sql2=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
				$rut=mysqli_fetch_assoc($sql2);
				$originLngLat=$rut['latitude'].','.$rut['longitude'];
				$destLngLat=$longitude.','.$latitude;
				$url_a="https://maps.googleapis.com/maps/api/directions/json?origin=".$originLngLat."&destination=".$destLngLat."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
				$getJson_a=file_get_contents($url_a);
				$json2PHP_a=json_decode($getJson_a, true);
				$eta=$json2PHP_a['routes'][0]['legs'][0]['duration']['text'];
				mysqli_query($conn,"UPDATE booking_minordetails SET ETA='$eta' WHERE minor_id='$hash'");
				$sqqq=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
				$lib=mysqli_num_rows($sqqq);
				if($lib==1){
					mysqli_query($conn,"UPDATE booking_minordetails SET order_as='0' WHERE minor_id='$hash'");
				}
				else{
					$trav=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id' ORDER BY order_as ASC");
					while($order=mysqli_fetch_assoc($trav)){
						$order_as_arr[]=$order['order_as'];
					}
					$orderMax=max($order_as_arr);
					$orderMaxX=$orderMax+1;
					mysqli_query($conn,"UPDATE booking_minordetails SET order_as='$orderMaxX' WHERE minor_id='$hash'");
				}
			}
			header("Location:../itineraries.php?minor_id=$hash&major_id=$major_id&tour_id=$tour_id&bookingstill&start=$starr&end=$enn&duration=$endDate");
			exit();
		}
	}
	elseif(isset($_POST['cancbu'])){
		require "dbconnect.inc.php";
		$major_id=$_POST['major_id'];
		$tour_id=$_POST['tour_id'];
		mysqli_query($conn,"DELETE FROM booking_majordetails WHERE major_id='$major_id'");
		header("Location:../tours.php?trip=cancelled");
		exit();
	}
	elseif(isset($_POST['deleteer'])){
		require "dbconnect.inc.php";
		$major_id=$_POST['major_id'];
		$tour_id=$_POST['tour_id'];
		$minor_id=$_POST['minor_id_grod'];
		$sql="DELETE FROM booking_minordetails WHERE minor_id='$minor_id'";
		mysqli_query($conn,$sql);
		header("Location:../itineraries.php?delete=success&minor_id&major_id=$major_id&tour_id=$tour_id&bookingstill&start=$starr&end=$enn");
		exit();
	}
	elseif(isset($_POST['cancun'])){
		require "dbconnect.inc.php";
		$major_id=$_POST['major_id'];
		mysqli_query($conn,"DELETE FROM booking_majordetails WHERE major_id='$major_id'");
		mysqli_query($conn,"DELETE FROM booking_minordetails WHERE major_id='$major_id'");
		header("Location:../tours.php?trip=cancelled");
		exit();
	}
	else{
		header("Location:../index.php?entry=error");
		exit();
	}
}