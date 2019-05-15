<?php session_start();
require "dbconnect.inc.php";
date_default_timezone_set("Asia/Manila");
if(isset($_GET['carChose'])){
	$major_id=$_GET['major_id'];
	$vehicle_id=$_GET['vehicle_id'];
	mysqli_query($conn,"UPDATE driver_queue SET vehicle_id='$vehicle_id' WHERE driver_pk='$_SESSION[driverid]'");
	$checkMajor=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$row=mysqli_fetch_assoc($checkMajor);
	$duration=$row['duration'];
	$optimise=$row['optimise'];
	$date_now = DATE("Y-m-d");
	$time_now = DATE("H:i:s");
	$dateTime_now = $date_now.' '.$time_now;
	$dateTime_now=DATE("Y-m-d H:i:s");

	$maqui=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id'");
	$maqB=mysqli_num_rows($maqui);
	if($maqB<=0){ //resason for this is para isang driver lang ung magiinsert nung records sa optiised table hehe
		if($optimise==null){
			$normalArDe=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major_id'");
			while($ArDeNul=mysqli_fetch_assoc($normalArDe)){
				$origin=$ArDeNul['orig_place'];
				$destination=$ArDeNul['des_place'];
				$orig_place_id=$ArDeNul['orig_place_id'];
				$des_place_id=$ArDeNul['des_place_id'];
				$duration=$ArDeNul['duration'];
				$mileage=$ArDeNul['mileage'];
				mysqli_query($conn,"INSERT INTO booking_optimize_tbl (comm_id,major_id,origin,orig_place_id,destination,des_place_id,duration,mileage) VALUES ('','$major_id','$origin','$orig_place_id','$destination','$des_place_id','$duration','$mileage')");
			}
			mysqli_query($conn,"UPDATE booking_optimize_tbl SET departure_dt='$dateTime_now' WHERE major_id='$major_id' ASC LIMIT 1");
		}
		else{
			$first_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
			$first=mysqli_fetch_assoc($first_q);
			$start_place_id=$first['orig_place_id'];//

			$doop=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
			while($rub=mysqli_fetch_assoc($doop)){
				$coords_place_id=$rub['place_id'];//
				$coord_arr_place_id[]="place_id:".$coords_place_id;//
			}

			$last_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id > (SELECT MIN(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
			$last=mysqli_fetch_assoc($last_q);
			$last_place_id=$last['des_place_id'];//

			$implode_wp_place_id=implode("|",$coord_arr_place_id);
			$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$start_place_id."&destination=place_id:".$start_place_id."&waypoints=optimize:true|".$implode_wp_place_id."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";

			$getJson=file_get_contents($url);
			$json2PHP=json_decode($getJson, true);
			$len=count($json2PHP['routes'][0]['legs']);

			for($i=0;$i<$len;$i++){
				$orig_place_id = $json2PHP['geocoded_waypoints'][$i]['place_id'];
				$urlA='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$orig_place_id.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
				$getJsonA=file_get_contents($urlA);
				$json2PHPA=json_decode($getJsonA, true);
				$originArray[] = $json2PHPA['result']['name'];
				$lenComp1=count($json2PHPA['result']['address_components']);
				for($l=1;$l<$lenComp1;$l++){
					$originArray[] = $json2PHPA['result']['address_components'][$l]['short_name'];
				}
				$origin=implode(", ",$originArray);

				$j=$i+1;
				$des_place_id = $json2PHP['geocoded_waypoints'][$j]['place_id'];
				$urlB='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$des_place_id.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
				$getJsonB=file_get_contents($urlB);
				$json2PHPB=json_decode($getJsonB, true);
				$desArray[] = $json2PHPB['result']['name'];
				$lenComp2=count($json2PHPB['result']['address_components']);
				for($m=1;$m<$lenComp2;$m++){
					$desArray[] = $json2PHPB['result']['address_components'][$m]['short_name'];
				}
				$destination=implode(", ",$desArray);

				$durationText = $json2PHP['routes'][0]['legs'][$i]['duration']['text'];//words itself
				$durationValue = $json2PHP['routes'][0]['legs'][$i]['duration']['value'];//unix form?
				$json2PHP['routes'][0]['legs'][$i]['distance']['text'];//words itself
				$json2PHP['routes'][0]['legs'][$i]['distance']['value'];//unix form?
				$mileage = substr($json2PHP['routes'][0]['legs'][$i]['distance']['text'], 0, -3);

				mysqli_query($conn,"INSERT INTO booking_optimize_tbl (comm_id,major_id,origin,orig_place_id,destination,des_place_id,duration,duration_val,mileage) VALUES ('','$major_id','$origin','$orig_place_id','$destination','$des_place_id','$durationText','$durationValue','$mileage')");

				unset($originArray);
				unset($desArray);
			}
			mysqli_query($conn,"UPDATE booking_optimize_tbl SET departure_dt='$dateTime_now' WHERE major_id='$major_id' ASC LIMIT 1");
		}
	}
	header("Location:../commence3.php?major_id=$major_id");
	exit();
}