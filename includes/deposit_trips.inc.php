<?php session_start();
require "dbconnect.inc.php";
$major_id=$_POST['major_id'];
$client_id=$_POST['client_id'];
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(isset($_POST['declin'])){

		$barbie="SELECT * FROM clients_table WHERE client_id='$client_id'";
		$barbie=mysqli_query($conn,$barbie);
		$email=mysqli_fetch_assoc($barbie);

		mysqli_query($conn,"UPDATE booking_majordetails SET completion='YES', refunded='YES' WHERE major_id='$major_id'");

		$from="noreply@urvan.webstarterz.com";
		$to=$email['client_email'];
		$subject="declined trip";
		$message="<!DOCTYPE html>
		<html>
		<head>
			<meta charset=\"utf-8\">
			<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
			<title></title>
			<link rel=\"stylesheet\" href=\"\">
		</head>
		<body>
			Your  trip #".$major_id." was declined. please upload another one or talk to the management why it happened.
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);

		header("Location:../business_dashboard/deposit_trips.php?deposit_slip=disapproved");
		exit();

	}
	elseif(isset($_POST['denio'])){
		mysqli_query($conn,"UPDATE booking_deposit_slip SET 
			deposit_slip=null,reference_num=null,approval='NO' WHERE major_id='$major_id'");
		$barbie="SELECT * FROM clients_table WHERE client_id='$client_id'";
		$barbie=mysqli_query($conn,$barbie);
		$email=mysqli_fetch_assoc($barbie);

		$from="noreply@urvan.webstarterz.com";
		$to=$email['client_email'];
		$subject="declined deposit slip";
		$message="<!DOCTYPE html>
		<html>
		<head>
			<meta charset=\"utf-8\">
			<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
			<title></title>
			<link rel=\"stylesheet\" href=\"\">
		</head>
		<body>
			Your deposit slip for trip #".$major_id." was declined. please upload another one or talk to the management why it happened.
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);

		header("Location:../business_dashboard/deposits.php?deposit_slip=disapproved");
		exit();
	}
	elseif(isset($_POST['acceptado'])){
		$hash=sha1(rand(0,1000));
		$hash="DRCT".$hash;
		$hash=strtoupper($hash);
		$r=mysqli_query($conn,"SELECT * FROM admin_table WHERE admin_id='$_SESSION[adminid]'");
		$sagot=mysqli_fetch_assoc($r);
		$name=$sagot['admin_first_name'].' '.$sagot['admin_last_name'];
		mysqli_query($conn,"UPDATE booking_deposit_slip SET approval='APPROVED', administer='$name' WHERE major_id='$major_id'");
		mysqli_query($conn,"UPDATE booking_balance SET status='PAID' WHERE major_id='$major_id'");
		$prob=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
		$probb=mysqli_fetch_assoc($prob);
		if($probb['transaction_type']=="DEPOSIT"){
			mysqli_query($conn,"UPDATE booking_transactions SET receipt_url='$hash' WHERE major_id='$major_id'");
		}

		// urvan.webstarterz.com/deposit_receipt.php?major_id=$major_id&rec_id=$hash
		$barbie="SELECT * FROM clients_table WHERE client_id='$client_id'";
		$barbie=mysqli_query($conn,$barbie);
		$email=mysqli_fetch_assoc($barbie);
		$from="noreply@urvan.webstarterz.com";
		$to=$email['client_email'];
		$subject="Receipt for your trip";
		$message="<!DOCTYPE html>
		<html>
		<head>
			<meta charset=\"utf-8\">
			<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
			<title></title>
			<link rel=\"stylesheet\" href=\"\">
		</head>
		<body>
			Click the link for the receipt: http://urvan.webstarterz.com/deposit_receipt.php?major_id="."$major_id"."&rec_id="."$hash"."
		</body>
		</html>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: UrVan / BTTSC ".$from."\r\n";
		mail($to,$subject,$message,$headers);

		$fin=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
		$finn=mysqli_fetch_assoc($fin);
		$start_date=$finn['start_date'];
		$end_date=$finn['end_date'];
		$limit=$finn['pax'];
		$limit=ceil($limit/12);

		// algoooooooo

		$algo_driver_query=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status IS NULL ORDER BY main_id ASC LIMIT $limit");
		while($algo_driver=mysqli_fetch_assoc($algo_driver_query)){
		$algo_driver_driver_id=$algo_driver['driver_pk'];
		mysqli_query($conn,"UPDATE driver_queue SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE driver_pk='$algo_driver_driver_id'");
		}

		$tour_id=$_POST['tour_id'];
		$ja=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
		$jac=mysqli_num_rows($ja);
		if($jac>=1){ // ncr
			$algo_vehicle_query=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status IS NULL ORDER BY franc_id ASC LIMIT $limit");
			while($algo_vehicle=mysqli_fetch_assoc($algo_vehicle_query)){
				$algo_vehicle_vehicle_id=$algo_vehicle['vehicle_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE vehicle_id='$algo_vehicle_vehicle_id'");
			}
		}
		else{
			$algo_vehicle_query_notFra=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status IS NULL ORDER BY franc_id ASC LIMIT $limit");
			while($algo_vehicle_notFra=mysqli_fetch_assoc($algo_vehicle_query_notFra)){
				$algo_vehicle_vehicle_id_notfr=$algo_vehicle_notFra['vehicle_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE vehicle_id='$algo_vehicle_vehicle_id_notfr'");
			}
		}

		// algoooooooo
		
		header("Location:../business_dashboard/deposits.php");
		exit();
	}
	elseif(isset($_POST['apruba'])){

		$amount=$_POST['amount'];

		$sja=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
		$sja11=mysqli_fetch_assoc($sja);

		$skk=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
		$bd=mysqli_num_rows($skk);
		
		if($sja11['transaction_type']=='STRIPE'){
			if($bd==0){
				$sql="INSERT INTO booking_deposit_slip (id,major_id,approval) VALUES ('','$major_id','NO')";
				mysqli_query($conn,$sql);
			}
		}

		$folderpath="summarycost/";
		$nm=SHA1(rand(0,1000000));
		$filename=$nm.basename($_FILES['costsummary']['name']);
		$newname=$folderpath.$filename;
		$filetype=pathinfo($newname,PATHINFO_EXTENSION);
		if($filetype=="pdf"){
			if(move_uploaded_file($_FILES['costsummary']['tmp_name'], $newname)){
				$sqlll=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
				$ssja=mysqli_fetch_assoc($sqlll);
				$total=$ssja['total_amount']+$amount;
				mysqli_query($conn,"UPDATE booking_balance SET amount='$amount', filepath='$newname' WHERE major_id='$major_id'");
				mysqli_query($conn,"UPDATE booking_transactions SET total_afterbal='$total' WHERE major_id='$major_id'");
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

		header("Location:../business_dashboard/deposit_trips.php");
		exit();
	}
	else{
		header("Location:../index.php?entry=error");
		exit();
	}
}