<?php session_start();
$major_id=$_GET['major_id'];
$tour_id=$_GET['tour_id'];
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?entry=error3");
}
else{
	if(!isset($_GET['bookingstill'])){
		header("Location:index.php?entry=error4");
	}
	else{
	require "header.php";
	$major_id=$_GET['tripid'];
	$dsj=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id' AND duration>=1");
	$b=mysqli_num_rows($dsj);
	?>
	<style>
		.container{
		min-width:600px;	
		}
		.graaaaaaa{
			background-color:black;
			color:white;
			padding:8px;
		}
	</style>
	<div class="container text-center" style="padding:150px 130px;">
		<div style="border-style:solid;padding:30px;border-width:1px;border-radius:5px;box-shadow: 10px 10px 0px 0px rgba(59,59,59,1);">
			<h1 style="font-family:raleway;text-transform:uppercase;"><b>Success!</b></h1>
			<h4 style="font-family: gravity;text-transform:capitalize;">That will cost <b><u>₱<?php echo $_GET['price'].".00"; ?></u></b> <small>(cost breakdown provided in the link below)</small></h4>
			<h4 style="font-family: gravity;text-transform:capitalize;">You've booked your trip to <?php echo $_GET['tripname']; ?></h4>
			<h4 style="font-family: gravity;text-transform:capitalize;">Please upload your deposit slip <a href="reservations.php">here</a></h4>
			<h5 style="font-family: gravity;">We accept the payements through MetroBank with the account number:<br><br><b class="graaaaaaa">897-7-89700167-1</b></h5>
			<?php if($b>=1){
				echo "<div class='card' style=\"background-color:;margin-top:20px;padding:5px;\">This is only a partial payment. Any trip that exceeds more than 1 day will be reviewed by the management for additional costs.</div>";
			} ?>
		</div>
	</div>
<?php
	require "footer.php";
	}
}
?>