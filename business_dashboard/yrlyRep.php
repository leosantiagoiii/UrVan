<?php session_start();
require "../includes/dbconnect.inc.php";
$now=$_GET['yr'];
$tripMoney=$_GET['1'];
$membershipMoney=$_GET['2'];
$subscribedMoney=$_GET['3'];?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script type="text/javascript">
		google.charts.load("current", {packages:["corechart"]});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Task', 'Hours per Day'],
				['Trips',     <?php echo $tripMoney; ?>],
				['Membership', <?php echo $membershipMoney; ?>],
				['Capital',  <?php echo $subscribedMoney; ?>],
			]);
			var options = {
				pieHole: 1,
			};
			var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
			chart.draw(data, options);
		}
	</script>
</head>
<body>
	<div class="container-fluid mt-4">
		<div class="card" style="padding:20px;">
			<div class="row">
				<div class="col-lg-8">
					<div id="donutchart" style="width: 100%; height: 400px;"></div>
				</div>
				<div class="col-lg-4">
					<div class="card" style="padding:20px;">
						<?php
						// 
						$fardin=mysqli_query($conn,"SELECT DISTINCT major_id FROM booking_history_trip WHERE YEAR(created_at)='$now'");
						while($maiml=mysqli_fetch_assoc($fardin)){
							$mejor_id=$maiml['major_id'];
							$handz=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$mejor_id'");
							$dw=mysqli_fetch_assoc($handz);
							$forg=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$mejor_id'");
							while($bum=mysqli_fetch_assoc($forg)){
								if($bum['total_afterbal']!=null){
								$IBEL[]=$bum['total_afterbal'];
								}
								else{
								$IBEL[]=$bum['total_amount'];
								}
							}
						}
						$SUMTRIP = array_sum($IBEL);
						// 
						$mene=mysqli_query($conn,"SELECT * FROM official_member_member_payment WHERE YEAR(created_at)='$now'");
						while($lolol=mysqli_fetch_assoc($mene)){
							$lol[]=$lolol['amount'];
						}
						$SUMMEMBSPAY = array_sum($lol);
						// 
						$meeei=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE YEAR(created_at)='$now' AND status='APPROVED'");
						while($hardt=mysqli_fetch_assoc($meeei)){
							$joke[]=$hardt['amount'];
						}
						$SUMCAP = array_sum($joke);
						// 
						$totalYearMoney=number_format(($SUMCAP+$SUMMEMBSPAY+$SUMTRIP),2); ?>
						<h2>This year, BTTSC made <u>PHP <?php echo $totalYearMoney;  ?></u></h2>
						<ul style="margin:0">
						<?php
						$sak=mysqli_query($conn,"SELECT DISTINCT major_id FROM booking_history_trip WHERE YEAR(created_at)='$now'");
						echo '<li> A total of '.mysqli_num_rows($sak).' trip(s) happened in '.$now.'</li>';
						$fel=mysqli_query($conn,"SELECT * FROM official_member_member_payment WHERE YEAR(created_at)='$now'");
						echo '<li> A total of '.mysqli_num_rows($fel).' member(s) paid for their membership this '.$now.'</li>';
						$foo=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE YEAR(created_at)='$now' AND status='APPROVED'");
						$fah=mysqli_query($conn,"SELECT DISTINCT member_id FROM official_member_capital WHERE YEAR(created_at)='$now' AND status='APPROVED'");
						echo '<li> '.mysqli_num_rows($fah).' member(s) paid for their subscribed capital in '.$now.'</li>'; ?>
						</ul>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-4">
					<h3 style="text-align:center">Trips</h3>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Trip ID</th>
								<th>Dates</th>
								<th>Amount</th>
							</tr>
						</thead>
							<tbody>
								<?php
								$meimo=mysqli_query($conn,"SELECT DISTINCT major_id FROM booking_history_trip WHERE YEAR(created_at)='$now'");
								while($sur=mysqli_fetch_assoc($meimo)){
									$major_id=$sur['major_id'];
									$wil=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
									$dw=mysqli_fetch_assoc($wil);
									$sle=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
									while($wor=mysqli_fetch_assoc($sle)){ ?>
										<tr>
											<td><?php echo $major_id; ?></td>
											<td><?php echo DATE("y M d",strtotime($dw['start_date'])).' - '.DATE("y M d",strtotime($dw['end_date']));?></td>
											<td>
												<?php
												if($wor['total_afterbal']!=null){
													$allTripMoney[]=$wor['total_afterbal'];
													echo number_format($wor['total_afterbal'],2);
												}
												else{
													$allTripMoney[]=$wor['total_amount'];
													echo number_format($wor['total_amount'],2);
												} ?>
											</td>
										</tr>
										<?php
									}
								} ?>
							</tbody>
							<tfoot>
								<tr>
									<th colspan="2">Amount</th>
									<td>PHP <?php echo (array_sum($allTripMoney));?></td>
								</tr>
							</tfoot>
					</table>
				</div>
				<div class="col-lg-4">
					<h3 style="text-align:center">Membership</h3>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Date Paid</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$mail=mysqli_query($conn,"SELECT * FROM official_member_member_payment WHERE YEAR(created_at)='$now'");
							while($fer=mysqli_fetch_assoc($mail)){
								$member_id=$fer['member_id'];
								$sqj=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
								$sko=mysqli_fetch_assoc($sqj);
								$memnm=$sko['member_first_name'].' '.$sko['member_last_name']; ?>
								<tr>
									<td><?php echo $memnm; ?></td>
									<td><?php echo DATE("y M d H:i A",strtotime($fer['created_at']));?></td>
									<td><?php echo $fer['amount'];?></td>
								</tr>
								<?php
								$all500money[]=$fer['amount'];
							} ?> 
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total</th>
								<th><?php echo number_format(array_sum($all500money),2); ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="col-lg-4">
					<h3 style="text-align:center">Subscribed Capital</h3>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Date Paid</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$maip=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE YEAR(created_at)='$now' AND status='APPROVED'");
							while($sole=mysqli_fetch_assoc($maip)){
								$member_id=$sole['member_id'];
								$folf=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
								$bai=mysqli_fetch_assoc($folf);
								$memnm2=$bai['member_first_name'].' '.$bai['member_last_name']; ?>
								<tr>
									<td><?php echo $memnm2; ?></td>
									<td><?php echo DATE("y M d H:i A", strtotime($sole['created_at'])); ?></td>
									<td><?php echo $sole['amount'];?></td>
								</tr>
								<?php
								$allSubs[]=$sole['amount'];
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total</th>
								<th><?php echo number_format(array_sum($allSubs),2);?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>