<?php if(!empty($_GET['transaction_id']) && !empty($_GET['trip_name']) && !empty($_GET['receipt'])){
	$GET=filter_var_array($_GET,FILTER_SANITIZE_STRING);
	$transaction_id=$GET['transaction_id'];
	$trip_name=$GET['trip_name'];
	$receipt=$GET['receipt'];
}
else{
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
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
	<div class="madam">
		<div class="quio">
			<center><h1 style="font-family: gravity;font-weight: 500;">Thank you for booking to <?php echo $trip_name; ?></h1></center>
			<hr>
			The TransactionID is <?php echo $transaction_id;?>
			<a href="index.php" class="btn btn-block buton">Click Here To Return home</a>
			<a href="<?php echo $receipt; ?>" class="btn mt-2 btn-block buton">Click Here To See Your Receipt</a>
		</div>
	</div>
</body>
</html>