<?php session_start();
require_once('vendor/autoload.php');
require "includes/dbconnect.inc.php";
if(isset($_POST['reund'])){
	\Stripe\Stripe::setApiKey('sk_test_EEIBBGO7UPgAm230M1LLc0Ev');
	$POST=filter_var_array($_POST,FILTER_SANITIZE_STRING);
	$major_id=$POST['major_id'];
	$refund_id=$POST['refund_id'];
}
else{
	header("Location:index.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
<style>
		*{
			margin:0;
			padding:0;
		}
		body{
			position: relative;
			height:auto;
		}
		@font-face{
		font-family:monsbold;
		src:url('fonts/Monsbold.otf');
		}
		@font-face{
		font-family:monsreg;
		src:url('fonts/Monsreg.otf');
		}
		@font-face{
		font-family:bebas;
		src:url('fonts/Bebas.ttf');
		}
		@font-face{
		font-family:gravity;
		src:url('fonts/Gravity.otf');
		}
		@font-face{
		font-family:raleway;
		src:url('fonts/Raleway.ttf');
		}
		@font-face{
		font-family:robotoblack;
		src:url('fonts/Robotoblack.ttf');
		}
		@font-face{
		font-family:robotoreg;
		src:url('fonts/Robotoreg.ttf');
		}
		.img{
			width:100%;
		}
		.griii{
			width:30%;
			text-align: center;
			left:50%;
			transform: translate(-50%, 50%);
			padding:40px;
			margin: 0;
			position: absolute;
			border-style: solid;
			border-width: 1px;
			box-shadow: 10px 10px 0px 0px rgba(41,41,41,1);
			border-radius: 3px;
		}
		.griii > center > h1{
			font-family: raleway;
			font-size:3vh;
			line-height: 35px;
		}
		.griii > center > a{
			font-family:gravity;
			text-decoration: none;
			font-size:15px;
			color:#3f516d;
		}
</style>
</head>
<body>

	<?php
	$sql="SELECT * FROM booking_transactions WHERE id='$refund_id'";
	$res=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($res);
	$total_amount=$row['total_amount']."00";
	$refund = \Stripe\Refund::create([
	    'charge' => $refund_id,
	    'amount' => $total_amount,
	]);
	$retrieve_new=\Stripe\Charge::retrieve("$refund_id");
	?>

	<div class="griii">
		<center>
			<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/1200px-Stripe_Logo%2C_revised_2016.svg.png" alt="" class="img">
			<h1>Refunded!</h1>
			<p style="font-family: gravity;">An email was sent to you regarding this refund.</p>
			<br>
			<a href="index.php">Return home</a>
		</center>
	</div>

	<?php
	if(isset($_POST['koool'])){
		$sk=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
		$skk=mysqli_fetch_assoc($sk);
		if($skk['duration']>=1){
			mysqli_query($conn,"UPDATE booking_majordetails SET refund_2nddep='RECEIVED' WHERE major_id='$major_id'");
		}
	}

	$cancelDriver=mysqli_query($conn,"UPDATE driver_queue SET status=null, acceptance=null, start_date=null, end_date=null WHERE status='$major_id'");
	$sml=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
	$far=mysqli_fetch_assoc($sml);
	$tour_id=$far['tour_id'];
	$bei=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
	$welz=mysqli_num_rows($bei);
	if($welz>=1){
		$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}
	else{
		$cancelVan=mysqli_query($conn,"UPDATE vehicleQueue_not_franchised SET status=null,acceptance=null,start_date=null,end_date=null WHERE status='$major_id'");
	}
	?>

	<?php
	$sql="UPDATE booking_majordetails SET completion='YES', refunded='YES' WHERE major_id='$major_id'";
	$res=mysqli_query($conn,$sql);
	$sql="UPDATE booking_transactions SET receipt_url='$retrieve_new->receipt_url' WHERE major_id='$major_id'";
	mysqli_query($conn,$sql);

	// email
	$query=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$_SESSION[clientid]'");
	$angro=mysqli_fetch_assoc($query);
	$email=$angro['client_email'];
	$first_name=$angro['client_first_name'];
	$from="noreply@urvan.webstarterz.com";
	$to=$email;
	$subject="Refund for ".$email." on their trip to ".$retrieve_new->description;
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
		<body style=\'padding:30px;background-color:skyblue;font-family:Sarabun;\'>
			<h1>Hi, '.$first_name.'</h1>
			<p>You\'ve recently paid for a trip to '.$retrieve_new->description.' of which you cancelled.</p>
			<p>Here\'s the receipt:<br>'.$retrieve_new->receipt_url.'</p>
			<p>Shall you got any questions, don\'t hesistate to contact us.</p>
		<pre>Best Regards,</pre>
	<pre>BTSSC x UrVan</pre>
	</body>
	</html>
	';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: UrVan / BTTSC ".$from."\r\n";
	mail($to,$subject,$message,$headers);
	?>
	
</body>
</html>