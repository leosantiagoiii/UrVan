<?php session_start();
require "includes/dbconnect.inc.php";
$major_id=$_POST['major_id'];
$tour_id=$_POST['tour_id'];
$who=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id' AND duration>=1");
$bhil=mysqli_num_rows($who);
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?entry=error");
}
else{
	if(!isset($_POST['payment'])){
		header("Location:index.php?entry=error");
	}
	else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="stripe_payment.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
                  crossorigin="anonymous">
<style>
	*{
		padding:0;
		margin:0;
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
	.madam{
		margin-top:10%;
		padding:0 350px;
	}
	.quio{
		background-color: #f7f8f9;
		padding:20px;
		border-radius: 3px;
		box-shadow: 0px 0px 10px -5px rgba(0,0,0,0.75);
	}
	.buton{
		background-color:#32325d;
		color:white;
		font-weight: 500;
		margin-top:10px;
	}
</style>
</head>
<body>
	<?php 
	$sql="SELECT * FROM booking_majordetails WHERE major_id='$major_id'";
	$sql=mysqli_query($conn,$sql);
		$major=mysqli_fetch_assoc($sql);

	$sql="SELECT * FROM booking_minordetails WHERE major_id='$major_id'";
	$sql=mysqli_query($conn,$sql);
		$minor=mysqli_fetch_assoc($sql);

	$sql="SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'";
	$sql=mysqli_query($conn,$sql);
		$tours=mysqli_fetch_assoc($sql);

	$sql="SELECT * FROM clients_table WHERE client_id=$_SESSION[clientid]";
	$sql=mysqli_query($conn,$sql);
		$client=mysqli_fetch_assoc($sql);

	$vans=ceil($major['pax']/12);
	$totalamount=$vans*$tours['tour_price']; // for db
	$stripeamount=$totalamount."00"; // for stripe
	?>
	<div class="madam">
		<div class="quio">
			<form action="charge.php" method="post" id="payment-form">
				<h1 style="font-family:gravity;margin-bottom:10px;">Trip to <?php echo $tours['tour_name'];?></h1>
				<div class="form-row">
					<div class="form-row" style="width:100%">
						<div class="col-lg-3">
							<label for="">Number of Vans</label>
							<input type="text" placeholder="" class="form-control mb-3 StripeElement StripeElement--empty" required="" value="<?php echo $vans; ?>" readonly>
						</div>
						<div class="col-lg-3">
							<label for="">Trip Price</label>
							<input type="text" placeholder="" class="form-control mb-3 StripeElement StripeElement--empty" required="" value="<?php echo "₱".$tours['tour_price']; ?>" readonly>
						</div>
						<div class="col-lg-3">
							<label for="">Total Amount</label>
							<input type="text" placeholder="" class="form-control mb-3 StripeElement StripeElement--empty" required="" value="<?php echo "₱".$totalamount.".00"; ?>" readonly>
						</div>
						<div class="col-lg-3">
							<label for="">Pax</label>
							<input type="text" placeholder="" class="form-control mb-3 StripeElement StripeElement--empty" required="" value="<?php echo $major['pax']; ?>" readonly>
						</div>
					</div>
					<div class="form-row" style="width:100%">
						<div class="col-lg-6">
							<label for="">First Name</label>
							<input type="text" placeholder="First Name" class="form-control mb-3 StripeElement StripeElement--empty" readonly="" value="<?php echo $client['client_first_name'];?>">
						</div>
						<div class="col-lg-6">
							<label for="">Last Name</label>
							<input type="text" placeholder="Last Name" class="form-control mb-3 StripeElement StripeElement--empty" readonly="" value="<?php echo $client['client_last_name'];?>">
						</div>
					</div>
					<div class="form-row" style="width:100%">
						<div class="col-lg-12">
							<input type="email" name="email" placeholder="Email" class="form-control mb-3 StripeElement StripeElement--empty" required="" value="<?php echo $client['client_email'];?>">
						</div>
					</div>
					<?php if($bhil>=1){ ?>
					<div class="form-row" style="width:100%;margin-bottom:20px;">
						<div class="col-lg-12">
							This is only a partial payment. Any trip that exceeds more than 1 day will be reviewed by the management for additional costs.
						</div>
					</div>
					<?php } ?>
					<div id="card-element" class="form-control">
						<!-- A Stripe Element will be inserted here. -->
					</div>
					<!-- Used to display form errors. -->
					<div id="card-errors" role="alert"></div>
				</div>
				<input type="hidden" value="<?php echo $_SESSION['clientid']; ?>" name="client_id">
				<input type="hidden" value="<?php echo $client['client_first_name']; ?>" name="first_name">
				<input type="hidden" value="<?php echo $client['client_last_name']; ?>" name="last_name">
				<input type="hidden" name="stripeamount" value="<?php echo $stripeamount; ?>">
				<input type="hidden" name="tour_name" value="<?php echo $tours['tour_name'];?>">
				<input type="hidden" name="totalamount" value="<?php echo $totalamount; ?>">
				<input type="hidden" name="tour_price" value="<?php echo $tours['tour_price'];?>">
				<input type="hidden" name="vans" value="<?php echo $vans; ?>">
				<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
				<button class="buton btn btn-block">Submit Payment</button>
			</form>
		</div>
	</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="stripe_payment.js"></script>	
</body>
</html>
<?php 		
	}
}
?>