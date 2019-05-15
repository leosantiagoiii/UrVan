<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?entry=error1");
}
else{
	if(!isset($_POST['trudep'])){
		header("Location:index.php?entry=error2");
	}
	else{
		$major_id=$_POST['major_id'];
		$tour_id=$_POST['tour_id'];

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
		$totalamount=$vans*$tours['tour_price'];

		$hash=sha1(rand(0,1000));
		$hash="3TR".$hash;
		$hash=substr($hash,0,-25);
		$id_hash=strtoupper($hash);

		$yao=sha1(rand(0,1000));
		$yao="X_CH".$yao;
		$yao=substr($yao,0,-25);
		$ch_id=strtoupper($yao);

		$sql="INSERT INTO booking_clients
		(id,client_id,first_name,last_name,email,major_id)
		VALUES
		('$id_hash','$_SESSION[clientid]','$client[client_first_name]','$client[client_last_name]','$client[client_email]','$major_id')";
		mysqli_query($conn,$sql);

		$sql="INSERT INTO booking_transactions
		(id,
		customer_id,
		client_id,
		trip_name,
		price,
		total_amount,
		currency,
		status,
		vans_used,
		major_id,
		transaction_type)
		VALUES
		('$ch_id',
		'$id_hash',
		'$_SESSION[clientid]',
		'$tours[tour_name]',
		'$tours[tour_price]',
		'$totalamount',
		'php',
		'succeeded',
		'$vans',
		'$major_id',
		'DEPOSIT')";
		mysqli_query($conn,$sql);

		$sql="INSERT INTO booking_deposit_slip (id,major_id,approval) VALUES ('','$major_id','NO')";
		mysqli_query($conn,$sql);

		// insert email function

		header("Location:../book_payment_deposit_slip.php?tripname=$tours[tour_name]&major_id=$major_id&tour_id=$tour_id&tripid=$major_id&price=$totalamount&bookingstill");
		exit();
	}
}