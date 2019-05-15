<?php 
session_start();
require "includes/dbconnect.inc.php";
$major_id = $_GET['major_id'];
$history=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE major_id='$major_id' LIMIT 1");
$historyCount=mysqli_num_rows($history);
if($historyCount==0){
	$completed = 0;
}
else{
	$completed = 1;
} ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
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
	</style>
</head>
<body>
	<div class="container mt-4 mb-4">
		<div class="card" style="padding:20px;">
			<h1 style="font-family:raleway;text-decoration:underline;margin:0"><?php echo $major_id; ?></h1>
			<?php
			if($completed==1){ // Trip pushed thru
				$majorsql=mysqli_query($conn,"SELECT * FROM booking_majordetails  WHERE major_id='$major_id'");
				$major=mysqli_fetch_assoc($majorsql);
				$transacsql=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
				$transac=mysqli_fetch_assoc($transacsql); ?>
				<div style="font-family:monospace;font-size:15px;" class="mt-2">
					<div>Completed</div>
					<div class="row">
						<div class="col-lg-3">
							<b>To:</b>
							<?php
							$toursql=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$major[tour_id]'");
							$tours=mysqli_fetch_assoc($toursql);
							echo $tours['tour_name']; ?>
						</div>
						<div class="col-lg-3"><b>Start Date:</b> <?php echo DATE("Y M d",strtotime($major['start_date'])); ?></div>
						<div class="col-lg-3"><b>End Date:</b> <?php echo DATE("Y M d",strtotime($major['end_date'])); ?></div>
						<div class="col-lg-3"><b>Duration:</b> <?php echo $major['duration'];?></div>
					</div>
					<div class="row">
						<div class="col-lg-9"><b>Reporting Place: </b><?php echo $major['reporting_place'];?></div>
						<div class="col-lg-3"><b>Reporting Time: </b><?php echo $major['reporting_time'];?></div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<b>Transaction Type:</b> <?php echo $transac['transaction_type']; ?>
						</div>
					</div>
					<?php 
					if($transac['transaction_type']=="STRIPE"){ ?>
						<div class="row">
							<div class="col-lg-12">
								<b>Stripe Receipt:</b> <?php echo $transac['receipt_url']; ?>
							</div>
						</div>
						<?php 
					} ?>
				</div>
				<hr>
				<!-- <div class="row">
					<div class="col-lg-12">
						<?php
						//if($major['duration']>=1 AND $transac['transaction_type']){
						//	echo "More than 1 day & Stripe. Show the deposit slip";
						//} ?>
					</div>
				</div> -->
				<h3 class="text-center mb-3" style="font-family: monsbold;margin:0">ITINERARY</h3>
				<div class="card" style="padding:25px;font-family:gravity;">
					<?php
					$itinerarysql=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' ORDER BY created_at ASC");
					$i=0;
					while($itin=mysqli_fetch_assoc($itinerarysql)){
						$i++; ?>
						<h5 style="margin:6px;">
							<?php 
							echo $i.'. ';
							echo $itin['origin'].' to '.$itin['destination']; ?>
						</h5>
						<div style="margin:1px;"><b>Departure:</b> <?php echo DATE("Y M d h:i:s A",strtotime($itin['departure_dt']));?></div>
						<div style="margin:1px;"><b>Arrival:</b> <?php echo DATE("Y M d h:i:s A",strtotime($itin['arrival_dt']));?></div>
						<div style="margin:1px;"><b>ETA:</b> <?php echo $itin['duration'];?></div>
						<div style="margin:1px;">
							<b>Actual: </b>
							<?php
							$timeA=strtotime($itin['departure_dt']);
							$timeB=strtotime($itin['arrival_dt']);
							$seconds = ABS($timeA-$timeB);
							$hours = floor($seconds / 3600);
							$mins = floor($seconds / 60 % 60);
							$secs = floor($seconds % 60);
							echo sprintf('%02d hrs %02d mins %02d secs', $hours, $mins, $secs); ?>
						</div>
						<?php
					} ?>
				</div>
				<div class="mt-3 row" style="font-family:monospace;font-size:15px;">
					<?php
					if($transac['transaction_type']=="STRIPE" and $major['duration']>=1){
						$depslipsql=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
						$depslip=mysqli_fetch_assoc($depslipsql); ?>
						<div class="col-lg-6" style="padding:0 10px 10px 10px;">
							<p class="mb-3">Deposit Slip:</p>
							<img src="includes/<?php echo $depslip['deposit_slip']; ?>" alt="" style="width:100%">
						</div>
						<div class="col-lg-6">
							<table class="table">
								<tr>
									<th style="width:40%">Tour Price: </th>
									<td>Php <?php echo $transac['price'];?></td>
								</tr>
								<tr>
									<th>Vans Used: </th>
									<td>x <?php echo ceil($major['pax']/12);?></td>
								</tr>
								<tr>
									<th>Amount: </th>
									<td>Php <?php echo $transac['total_amount'];?></td>
								</tr>
								<?php 
								if($transac['total_amount']!=$transac['total_afterbal']){ ?>
									<tr>
										<th>Additional: </th>
										<td>Php <?php echo ABS($transac['total_amount']-$transac['total_afterbal']);?></td>
									</tr>
									<?php 
								} ?>
								<tr class="bg-warning">
									<th>Total: </th>
									<td>Php <?php echo $transac['total_afterbal'];?></td>
								</tr>
							</table>

							<div class="mt-3">
								Drivers:
								<?php
								$vandr=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE major_id='$major_id'"); ?>
								<ul>
									<?php 
									while($vanr=mysqli_fetch_assoc($vandr)){
										if($vanr['driver_type']=="AUTH_DRIV"){
											$getDrivS=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$vanr[driver_pk]'");
											$driv=mysqli_fetch_assoc($getDrivS);
											echo "<li>".$driv['driver_name']."</li>";
										}
										else{
											$getMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$vanr[driver_pk]'");
											$mem=mysqli_fetch_assoc($getMem);
											echo "<li>".$mem['member_first_name'].' '.$mem['member_last_name']."</li>";
										} ?>
										<?php
									} ?>
								</ul>
								Vans:
								<?php
								$vandr=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE major_id='$major_id'"); ?>
								<ul>
									<?php 
									while($mum=mysqli_fetch_assoc($vandr)){ ?>
										<li>
											<?php
											$vanId = $mum['van_id'];
											$vanQ=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vanId'");
											$van=mysqli_fetch_assoc($vanQ);
											echo $van['make'].' '.$van['model'].' '.$van['plate_number']; ?>
										</li>
										<?php
									} ?>
								</ul>
							</div>
						</div>
						<?php
					} ?>
				</div>
				<?php
			}
			else{ //Trip pushed thru ?>
				<?php
			} ?>
		</div>
	</div>
</body>
</html>