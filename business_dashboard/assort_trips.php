<?php session_start();
require "../includes/dbconnect.inc.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
                  crossorigin="anonymous">
	<style>
	@font-face{
	font-family:monsbold;
	src:url('../fonts/Monsbold.otf');
	}
	@font-face{
	font-family:monsreg;
	src:url('../fonts/Monsreg.otf');
	}
	@font-face{
	font-family:bebas;
	src:url('../fonts/Bebas.ttf');
	}
	@font-face{
	font-family:gravity;
	src:url('../fonts/Gravity.otf');
	}
	@font-face{
	font-family:raleway;
	src:url('../fonts/Raleway.ttf');
	}
	@font-face{
	font-family:robotoblack;
	src:url('../fonts/Robotoblack.ttf');
	}
	@font-face{
	font-family:robotoreg;
	src:url('../fonts/Robotoreg.ttf');
	}
	</style>
</head>
<body>
	<div class="container mt-3">
		<?php 
		if(isset($_POST['past'])) {
			$duration=$_POST['duration'];
			$major_id=$_POST['major_id'];
			$username=$_POST['username'];
			$place=$_POST['place'];
			$sql=mysqli_query($conn,"SELECT * FROm booking_majordetails WHERE major_id='$major_id'");
			$major=mysqli_fetch_assoc($sql);
			$sql2=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
			$tran=mysqli_fetch_assoc($sql2); ?>
			<h1 style="font-family:monsbold;"><?php echo $major_id; ?></h1>
			<div style="font-family:monsreg;">
				by @<?php echo $username; ?> (<?php echo DATE("Y M d H:i A",strtotime($major['created_at']));?>)<br><br>
				<div style="width:100%;overflow: scroll;">
					<table class="table table-light">
						<tr>
							<td><b>To</b><br><?php echo $place; ?></td>
							<td><b>Start Date</b><br><?php echo DATE("Y M d",strtotime($major['start_date'])); ?></td>
							<td><b>End Date</b><br><?php echo DATE("Y M d",strtotime($major['end_date'])); ?></td>
							<td><b>Reporting Place</b><br><?php echo $major['reporting_place']; ?></td>
							<td><b>Reporting Time</b><br><?php echo DATE("H:i A",strtotime($major['reporting_time'])); ?></td>
						</tr>
						<tr>
							<td><b>Pax</b><br><?php echo $major['pax']; ?></td>
							<td><b>Duration</b><br><?php echo $duration.' day(s)'; ?></td>
							<td><b>Payment Type</b><br><?php echo $tran['transaction_type']; ?></td>
							<td><b>Contact Person</b><br><?php echo $major['contact_person']; ?></td>
							<td><b>Contact Number</b><br><?php echo $major['contact_persons_number']; ?></td>
						</tr>
					</table>
				</div>
				<div style="width:100%;overflow: scroll;">
					<table class="table table-dark">
						<thead>
							<tr>
								<th width="20%">Origin</th>
								<th width="20%">Destination</th>
								<th>Departure</th>
								<th>Arrival</th>
								<th width="5%">Duration</th>
								<th>Mileage</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$sql3=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' ORDER BY created_at");
							while($minor=mysqli_fetch_assoc($sql3)){ ?>
							<tr>
								<td><?php echo $minor['origin'];?></td>
								<td><?php echo $minor['destination']; ?></td>
								<td><?php echo DATE("Y M d H:i A",strtotime($minor['departure_dt'])); ?></td>
								<td><?php echo DATE("Y M d H:i A",strtotime($minor['arrival_dt'])); ?></td>
								<td>
									<?php
									$timeA=strtotime($minor['departure_dt']);
									$timeB=strtotime($minor['arrival_dt']);
									$seconds = ABS($timeA-$timeB);
									$hours = floor($seconds / 3600);
									$mins = floor($seconds / 60 % 60);
									$secs = floor($seconds % 60);
									echo sprintf('%02d:%02d:%02d', $hours, $mins, $secs); ?>
								</td>
								<td><?php echo $minor['mileage'].' km';?></td>
							</tr>
							<?php
							} ?>
						</tbody>
					</table>
				</div>
				<div class="card" style="padding:20px;">
					<?php
					if($tran['transaction_type']=='STRIPE'){
						if($duration<=0){
							echo '<b>Stripe Receipt:</b> <a target="_blank" href="'.$tran['receipt_url'].'">'.$tran['receipt_url'].'</a>';
							echo "<br>";
						}
						else{
							echo '<b>Initial Payment:</b> <a target="_blank" href="'.$tran['receipt_url'].'">'.$tran['receipt_url'].'</a>';
							echo "<br>";
						}
					}
					$sql4=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
					$dep=mysqli_fetch_assoc($sql4);
					$depco=mysqli_num_rows($sql4);
					if($depco!=0){
						echo '<b>Deposit Slip (Reference No.): </b>'.$dep['reference_num'].'<br>';
						echo '<b>Deposit Slip:</b><br>';
						echo '<img src="../includes/'.$dep['deposit_slip'].'" style="width:50%;">';
						echo "<br>";
					}
					$sql5=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
					$bal=mysqli_fetch_assoc($sql5);
					if($duration>=1){
						echo '<b>Cost Breakdown:</b><a class="btn btn-primary" href="../includes/'.$bal['filepath'].'" download>Download</a>';
						echo '<br>';
					} ?>
					<big>
						<table style="width:75%;">
							<tr>
								<th>Rate per trip/van:</th>
								<td><?php echo 'Php'.number_format($tran['price'],2); ?></td>
							</tr>
							<tr>
								<th>Vans Used:</th>
								<td>x <?php echo $tran['vans_used'];?></td>
							</tr>
							<?php
							if($duration>=1){ ?>
								<tr>
									<th>Total Before Additional:</th>
									<td><?php echo 'Php'.number_format($tran['total_amount'],2);?></td>
								</tr>
								<tr>
									<th>Additional:</th>
									<td><?php echo 'Php'.$bal['amount'];?></td>
								</tr>
								<?php
							} ?>
							<b>
								<tr style="font-weight: bolder;background-color:yellow">
									<th>TOTAL</th>
									<td>PHP<?php
									if($duration>=1){
										echo number_format($tran['total_afterbal'],2);
									}
									else{
										echo number_format($tran['total_amount'],2);
									} ?></td>
								</tr>
							</b>
						</table>
					</big>
					<div style="font-weight: bold;font-size:18px;text-align: right;">
						<div>
							<h4>Driver(s):</h4>
							<ul>
								<?php
								$sql8=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE major_id='$major_id'");
								while($row8=mysqli_fetch_assoc($sql8)){ ?>
								<li>
									<?php
									if($row8['driver_type']=="AUTH_DRIV"){
										$sql8A=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$row8[driver_pk]'");
										$row8A=mysqli_fetch_assoc($sql8A);
										echo $row8A['driver_name'];
									}
									else{
										$sql8B=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$row8[driver_pk]'");
										$row8B=mysqli_fetch_assoc($sql8B);
										echo $row8B['member_first_name'].' '.$row8B['member_last_name'];
									} ?>
								</li>
								<?php
								} ?>
							</ul>
							<h4>Van(s):</h4>
							<ul>
								<?php
								$sql8=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE major_id='$major_id'");
								while($row8=mysqli_fetch_assoc($sql8)){ ?>
								<li>
									<?php
									$sql8C=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$row8[van_id]'");
									$row8C=mysqli_fetch_assoc($sql8C);
									echo $row8C['make'].' '.$row8C['model'].' '.$row8C['plate_number']; ?>
								</li>
								<?php
								} ?>
							</ul>
						</div>
						<?php
						$id=$_SESSION['adminid'];
						$qu=mysqli_query($conn,"SELECT * FROM admin_table WHERE admin_id='$id'");
						$nm=mysqli_fetch_assoc($qu); ?>
						Retrieved by: <?php echo $nm['admin_first_name'].' '.$nm['admin_last_name']; ?><br>
						<?php echo DATE('Y-m-d H:i:s'); ?>
					</div>
				</div>
			</div>
			<br>
			<?php
		} ?>
		<div style="background-color: white;padding:30px;" class="mb-3">
			<center>
				<img src="../images/bttsclogo.png" width="25%" alt="">
				<img src="../images/logo.png" width="25%" alt=""><br>
			</center>
		</div>
		<button class="btn btn-lg btn-secondary btn-block mb-3" onclick="myFunction()">Print Record</button>
		<script>
			function myFunction(){
				window.print();
			}
		</script>
	</div>
</body>
</html>