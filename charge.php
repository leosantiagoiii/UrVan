<?php session_start();
require "includes/dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?entry=error");
}
else{
	require "includes/dbconnect.inc.php";
	require_once('vendor/autoload.php');
	\Stripe\Stripe::setApiKey('sk_test_EEIBBGO7UPgAm230M1LLc0Ev');
	$POST=filter_var_array($_POST,FILTER_SANITIZE_STRING);
	$email = $POST['email'];
	$client_id = $POST['client_id'];
	$first_name = $POST['first_name'];
	$last_name = $POST['last_name'];
	$stripeamount=$POST['stripeamount'];
	$tour_name=$POST['tour_name'];
	$totalamount=$POST['totalamount'];
	$tour_price=$POST['tour_price'];
	$vans=$POST['vans'];
	$major_id=$POST['major_id'];
	$token=$POST['stripeToken'];

	//customer for stripe
	$customer=\Stripe\Customer::create(array(
		"email"=>$email,
		"source"=>$token
	));

	// Chareg customer
	$charge=\Stripe\Charge::create(array(
		"amount"=>$stripeamount,
		"currency"=>"php",
		"description"=>$tour_name.' ('.$major_id.')',
		"receipt_email"=>$email,
		"customer"=>$customer->id
	));

	// // echo "<br>";
	// echo "<pre>";
	// print_r($customer);
	// echo "</pre>";
	// echo "<br><br><br>";
	// echo "<pre>";
	// print_r($charge);
	// echo "</pre>";
	// echo "<br><br><br>";

	
	$sql="INSERT INTO booking_clients
	(id,client_id,first_name,last_name,email,major_id)
	VALUES
	('$charge->customer','$client_id','$first_name','$last_name','$email','$major_id')";
	mysqli_query($conn,$sql);

	$sql="INSERT INTO booking_transactions
	(id,customer_id,client_id,trip_name,price,total_amount,currency,status,vans_used,major_id,transaction_type,receipt_url)
	VALUES
	('$charge->id','$charge->customer','$client_id','$tour_name','$tour_price','$totalamount','$charge->currency','$charge->status','$vans','$major_id','STRIPE','$charge->receipt_url')";
	mysqli_query($conn,$sql);
	//pay.stripe.com/receipts/acct_1DtzBAGGMQO3VOFJ/ch_1Dz4GbGGMQO3VOFJDjwH3vHR/rcpt_ERyD3cbGmddllahqSc7BFU7X5vo8kuO

	// email
	$from="noreply@urvan.webstarterz.com";
	$to=$email;
	$subject=$tour_name." payment for ".$email;
	$message='
				<html>
					<head>
						<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
		<style type=\'text/css\' media=\'screen\'>
			body{
				font-family: \'Sarabun\', sans-serif;
			}
		</style>
	</head>
	<body style=\'padding:30px;background-color:skyblue;font-family:helvetica;\'>
		<h1>Hi, '.$first_name.'</h1>
		<p>You\'ve recently paid for a trip to '.$tour_name.'</p>
		<p>Here\'s the receipt:<br>'.$charge->receipt_url.'</p>
		<p>If you need a refund, please go to your account do the refunding process there.</p>
		<pre>Best Regards,</pre>
	<pre>BTSSC x UrVan</pre>
	</body>
</html>
';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);

	$mum=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$getMajor=mysqli_fetch_assoc($mum);
	$start_date=$getMajor['start_date'];
	$end_date=$getMajor['end_date'];
	$tour_id=$getMajor['tour_id'];
	$limit=ceil($getMajor['pax']/12);
	$tra=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
	$transa=mysqli_fetch_assoc($tra);
	
	if($getMajor['duration']=="0" AND $transa['transaction_type']=="STRIPE"){

		$algo_driver_query=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status IS NULL ORDER BY main_id ASC LIMIT $limit");
		while($algo_driver=mysqli_fetch_assoc($algo_driver_query)){
			$algo_driver_driver_id=$algo_driver['driver_pk'];
			mysqli_query($conn,"UPDATE driver_queue SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE driver_pk='$algo_driver_driver_id'");
		}

		$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
		$welz=mysqli_num_rows($ba);
		if($welz>=1){
			$algo_vehicle_query=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status IS NULL ORDER BY franc_id ASC LIMIT $limit");
			while($algo_vehicle=mysqli_fetch_assoc($algo_vehicle_query)){
				$algo_vehicle_vehicle_id=$algo_vehicle['vehicle_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE vehicle_id='$algo_vehicle_vehicle_id'");
			}
		}
		else{
			$algo_vehicle_query=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status IS NULL ORDER BY franc_id ASC LIMIT $limit");
			while($algo_vehicle=mysqli_fetch_assoc($algo_vehicle_query)){
				$algo_vehicle_vehicle_id=$algo_vehicle['vehicle_id'];
				mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status='$major_id', start_date='$start_date', end_date='$end_date' WHERE vehicle_id='$algo_vehicle_vehicle_id'");
			}
		}

	}

	header("Location:success.php?transaction_id=$charge->id&trip_name=$charge->description&receipt=$charge->receipt_url");
	exit();
}