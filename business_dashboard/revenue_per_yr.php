<?php session_start(); 
require "../fpdf181/fpdf.php";
require "../includes/dbconnect.inc.php";
if( (!isset($_GET['viewbutton'])) OR (!isset($_GET['tripin'])) ) {
	header("Location../index.php?entry=error");
	exit();
}
else{ ?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title></title>
			<link rel="stylesheet" href="">
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
				if($_GET['tripin']=="all"){ ?>
					<button class="btn btn-lg btn-secondary btn-block mb-3" onclick="myFunction()">Print Record</button>
					<script>
						function myFunction(){
							window.print();
						}
					</script>
					<?php 
					$o=0;
					$sqlMothr=mysqli_query($conn,"SELECT DISTINCT YEAR(created_at) as createi FROM booking_majordetails");
					while($rowMothr=mysqli_fetch_assoc($sqlMothr)){ ?>
						<h2 style="font-family:gravity;font-weight: bold;font-size: 60px;"><?php echo $rowMothr['createi'];?></h2>
						<?php
						$sql1=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='YES' AND refunded='NO' AND YEAR(created_at)='$rowMothr[createi]' ORDER BY created_at");
						while($row1=(mysqli_fetch_assoc($sql1))){
							$o++; ?>
							<div class="card mb-5" style="padding:20px;">
								<h2 style="font-family:monsbold;font-size:35px;margin:0"><?php echo $major_id = $row1['major_id'];?></h2>
								<div style="font-family:robotoreg;">
									<b>By:</b>
									<?php
									$client_id = $row1['client_id'];
									$sql2=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
									$row2=mysqli_fetch_assoc($sql2);
									$tour_id= $row1['tour_id'];
									$sql3=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
									$row3=mysqli_fetch_assoc($sql3);
									echo $row2['client_first_name'].' '.$row2['client_last_name'].' to <u>'.$row3['tour_name'].'</u><br>';
									$start_date=strtotime($row1['start_date']);
									$end_date=strtotime($row1['end_date']);
									if($start_date==$end_date){
										echo "<b>Date(s):</b> ".DATE("Y M d",$start_date)."<br>";
									}
									else{
										echo "<b>Date(s):</b> ".DATE("Y M d",$start_date).' to '.DATE("Y M d",$end_date)."<br>";
									}
									echo "<b>Duration: </b>";
									echo $row1['duration']+1;
									echo " day(s)<br>";
									echo "<b>Pax: </b>";
									echo $row1['pax'].' ';
									$vans_used_ha = ceil($row1['pax']/12);
									echo "(used ".$vans_used_ha." vans)";
									$sql4=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
									$row4=mysqli_fetch_assoc($sql4);
									$transaction_type=$row4['transaction_type'];
									echo "<br><b>Payment Type: </b>".$transaction_type; ?>
								</div>
								<hr>
								<div style="font-family:robotoreg">
									<div class="row mb-2">
										<div class="col-lg-4">
											<b>Reporting Place:</b>
											<br>
											<?php
											echo $row1['reporting_place']; ?>
										</div>
										<div class="col-lg-3">
											<b>Reporting Time:</b>
											<br>
											<?php
											echo DATE("H:i A",strtotime($row1['reporting_time'])); ?>
										</div>
										<div class="col-lg-3">
											<b>Contact Person:</b>
											<br>
											<?php
											echo $row1['contact_person']; ?>
										</div>
										<div class="col-lg-2">
											<b>Contact Number:</b>
											<br>
											<?php
											echo $row1['contact_persons_number']; ?>
										</div>
									</div>
									<h3 style="font-family:robotoblack;">Itinerary:</h3>
									<div class="mb-2" style="padding:5px;width:100%;overflow:auto;">
										<table class="table table-striped table-light" style="">
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
												$sql5=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' ORDER BY created_at");
												while($row5=mysqli_fetch_assoc($sql5)){ ?>
													<tr>
														<td>
															<?php
															echo $row5['origin']; ?>
														</td>
														<td>
															<?php
															echo $row5['destination']; ?>
														</td>
														<td>
															<?php
															echo DATE("Y M d H:i A",strtotime($row5['departure_dt'])); ?>
														</td>
														<td>
															<?php
															echo DATE("Y M d H:i A",strtotime($row5['arrival_dt'])); ?>
														</td>
														<td>
															<?php
															$timeA=strtotime($row5['departure_dt']);
															$timeB=strtotime($row5['arrival_dt']);
															$seconds = ABS($timeA-$timeB);
															$hours = floor($seconds / 3600);
															$mins = floor($seconds / 60 % 60);
															$secs = floor($seconds % 60);
															echo sprintf('%02d:%02d:%02d', $hours, $mins, $secs); ?>
														</td>
														<td>
															<?php
															echo $row5['mileage'].' km'; ?>
														</td>
													</tr>
													<?php
												} ?>
											</tbody>
										</table>
									</div>
									<div style="font-family:robotoreg">
										<div class="row">
											<div class="col-lg-6">
												<?php
												if($transaction_type=="STRIPE"){
													if($row1['duration']<=0){
														echo "<b>Receipt URL: </b><br>";
														echo "<a href=\"".$row4['receipt_url']."\">".$row4['receipt_url']."</a><br>";
													}
													else{
														echo "<b>Initial Payment: </b><br>";
														echo "<a href=\"".$row4['receipt_url']."\">".$row4['receipt_url']."</a><br>";
													}
												}
												$sql6=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
												$row6=mysqli_fetch_assoc($sql6);
												$sql6count=mysqli_num_rows($sql6);
												if($sql6count!=0){ ?>
													<b>Deposit Slip (Reference Number): </b>
													<br>
													<?php echo $row6['reference_num']; ?>
													<br>
													<b class="mb-3">Deposit Slip: </b>
													<br>
													<?php
													echo '<img src="../includes/'.$row6['deposit_slip'].'" style="width:75%;">';
												}?>
											</div>
											<div class="col-lg-6">
												<?php
												$sql7=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
												$row7=mysqli_fetch_assoc($sql7);
												if($row1['duration']>=1){ ?>
													<div class="mb-3">
														<b>Cost Breakdown:</b><br>
														<a href="../includes/<?php echo $row7['filepath']; ?>" download class="btn btn-primary btn-block">Click Here</a>
													</div>
													<div class="mb-3">
														<table style="width:100%">
															<tr>
																<th style="width:50%">Original Rate</th>
																<td style="width:50%">Php <?php echo $row4['price'];?> (x <?php echo ceil($row1['pax']/12);?> van[s])</td>
															</tr>
															<?php
															if($row1['duration']>=1){ ?>
																<tr>
																	<th>Total Before Additional</th>
																	<td>Php <?php echo number_format($row4['total_amount'],2);?></td>
																</tr>
																<tr>
																	<th>Additional</th>
																	<td>Php <?php echo $row7['amount'];?></td>
																</tr>
																<?php
															} ?>
															<tr>
																<th>TOTAL</th>
																<th>
																	<?php
																	if($row1['duration']>=1){
																		echo 'Php '.number_format($row4['total_afterbal'],2);
																	}
																	else{
																		echo 'Php '.number_format($row4['total_amount'],2);
																	} ?>
																</th>
															</tr>
														</table>
													</div>
													<div style="font-family:robotoreg;">
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
												}
												else{ ?>
													<div class="mb-3">
														<table style="width:100%">
															<tr>
																<th style="width:50%">Original Rate</th>
																<td style="width:50%">Php <?php echo $row4['price'];?> (x <?php echo ceil($row1['pax']/12);?> van[s])</td>
															</tr>
															<?php
															if($row1['duration']>=1){ ?>
																<tr>
																	<th>Total Before Additional</th>
																	<td>Php <?php echo number_format($row4['total_amount'],2);?></td>
																</tr>
																<tr>
																	<th>Additional</th>
																	<td>Php <?php echo $row7['amount'];?></td>
																</tr>
																<?php
															} ?>
															<tr>
																<th>TOTAL</th>
																<th>
																	<?php
																	if($row1['duration']>=1){
																		echo 'Php '.number_format($row4['total_afterbal'],2);
																	}
																	else{
																		echo 'Php '.number_format($row4['total_amount'],2);
																	} ?>
																</th>
															</tr>
														</table>
													</div>
													<div style="font-family:robotoreg;">
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
												} ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						echo "<hr>";
					} ?>
					<div class="mt-4 mb-5" style="font-family: robotoblack;text-align: right;">
						<?php
						$id=$_SESSION['adminid'];
						$qu=mysqli_query($conn,"SELECT * FROM admin_table WHERE admin_id='$id'");
						$nm=mysqli_fetch_assoc($qu); ?>
						<h2>Retrieved By: </h2> <?php echo $nm['admin_first_name'].' '.$nm['admin_last_name']; ?>
						<h3>Time: </h3> <?php echo DATE("Y M d H:i A"); ?>
						<h3>Records: </h3> <?php echo $o.' Records Retrieved'; ?>
					</div>

					<?php
				}
				else{
					$year=$_GET['tripin']; ?>
					<button class="btn btn-lg btn-secondary btn-block mb-3" onclick="myFunction()">Print <?php echo $year; ?> Record</button>
					<script>
						function myFunction(){
							window.print();
						}
					</script>
					<?php 
					$sql1=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='YES' AND refunded='NO' AND YEAR(created_at)=\"$year\" ORDER BY created_at");
					while($row1=(mysqli_fetch_assoc($sql1))){ ?>
						<div class="card mb-5" style="padding:20px;">
							<h2 style="font-family:monsbold;font-size:35px;margin:0"><?php echo $major_id = $row1['major_id'];?></h2>
							<div style="font-family:robotoreg;">
								<b>By:</b>
								<?php
								$client_id = $row1['client_id'];
								$sql2=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
								$row2=mysqli_fetch_assoc($sql2);
								$tour_id= $row1['tour_id'];
								$sql3=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
								$row3=mysqli_fetch_assoc($sql3);
								echo $row2['client_first_name'].' '.$row2['client_last_name'].' to <u>'.$row3['tour_name'].'</u><br>';
								$start_date=strtotime($row1['start_date']);
								$end_date=strtotime($row1['end_date']);
								if($start_date==$end_date){
									echo "<b>Date(s):</b> ".DATE("Y M d",$start_date)."<br>";
								}
								else{
									echo "<b>Date(s):</b> ".DATE("Y M d",$start_date).' to '.DATE("Y M d",$end_date)."<br>";
								}
								echo "<b>Duration: </b>";
								echo $row1['duration']+1;
								echo " day(s)<br>";
								echo "<b>Pax: </b>";
								echo $row1['pax'].' ';
								$vans_used_ha = ceil($row1['pax']/12);
								echo "(used ".$vans_used_ha." vans)";
								$sql4=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
								$row4=mysqli_fetch_assoc($sql4);
								$transaction_type=$row4['transaction_type'];
								echo "<br><b>Payment Type: </b>".$transaction_type; ?>
							</div>
							<hr>
							<div style="font-family:robotoreg">
								<div class="row mb-2">
									<div class="col-lg-4">
										<b>Reporting Place:</b>
										<br>
										<?php
										echo $row1['reporting_place']; ?>
									</div>
									<div class="col-lg-3">
										<b>Reporting Time:</b>
										<br>
										<?php
										echo DATE("H:i A",strtotime($row1['reporting_time'])); ?>
									</div>
									<div class="col-lg-3">
										<b>Contact Person:</b>
										<br>
										<?php
										echo $row1['contact_person']; ?>
									</div>
									<div class="col-lg-2">
										<b>Contact Number:</b>
										<br>
										<?php
										echo $row1['contact_persons_number']; ?>
									</div>
								</div>
								<h3 style="font-family:robotoblack;">Itinerary:</h3>
								<div class="mb-2" style="padding:5px;width:100%;overflow:auto;">
									<table class="table table-striped table-light" style="">
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
											$sql5=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' ORDER BY created_at");
											while($row5=mysqli_fetch_assoc($sql5)){ ?>
												<tr>
													<td>
														<?php
														echo $row5['origin']; ?>
													</td>
													<td>
														<?php
														echo $row5['destination']; ?>
													</td>
													<td>
														<?php
														echo DATE("Y M d H:i A",strtotime($row5['departure_dt'])); ?>
													</td>
													<td>
														<?php
														echo DATE("Y M d H:i A",strtotime($row5['arrival_dt'])); ?>
													</td>
													<td>
														<?php
														$timeA=strtotime($row5['departure_dt']);
														$timeB=strtotime($row5['arrival_dt']);
														$seconds = ABS($timeA-$timeB);
														$hours = floor($seconds / 3600);
														$mins = floor($seconds / 60 % 60);
														$secs = floor($seconds % 60);
														echo sprintf('%02d:%02d:%02d', $hours, $mins, $secs); ?>
													</td>
													<td>
														<?php
														echo $row5['mileage'].' km'; ?>
													</td>
												</tr>
												<?php
											} ?>
										</tbody>
									</table>
								</div>
								<div style="font-family:robotoreg">
									<div class="row">
										<div class="col-lg-6">
											<?php
											if($transaction_type=="STRIPE"){
												if($row1['duration']<=0){
													echo "<b>Receipt URL: </b><br>";
													echo "<a href=\"".$row4['receipt_url']."\">".$row4['receipt_url']."</a><br>";
												}
												else{
													echo "<b>Initial Payment: </b><br>";
													echo "<a href=\"".$row4['receipt_url']."\">".$row4['receipt_url']."</a><br>";
												}
											}
											$sql6=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
											$row6=mysqli_fetch_assoc($sql6);
											$sql6count=mysqli_num_rows($sql6);
											if($sql6count!=0){ ?>
												<b>Deposit Slip (Reference Number): </b>
												<br>
												<?php echo $row6['reference_num']; ?>
												<br>
												<b class="mb-3">Deposit Slip: </b>
												<br>
												<?php
												echo '<img src="../includes/'.$row6['deposit_slip'].'" style="width:75%;">';
											}?>
										</div>
										<div class="col-lg-6">
											<?php
											$sql7=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
											$row7=mysqli_fetch_assoc($sql7);
											if($row1['duration']>=1){ ?>
												<div class="mb-3">
													<b>Cost Breakdown:</b><br>
													<a href="../includes/<?php echo $row7['filepath']; ?>" download class="btn btn-primary btn-block">Click Here</a>
												</div>
												<div class="mb-3">
													<table style="width:100%">
														<tr>
															<th style="width:50%">Original Rate</th>
															<td style="width:50%">Php <?php echo $row4['price'];?> (x <?php echo ceil($row1['pax']/12);?> van[s])</td>
														</tr>
														<?php
														if($row1['duration']>=1){ ?>
															<tr>
																<th>Total Before Additional</th>
																<td>Php <?php echo number_format($row4['total_amount'],2);?></td>
															</tr>
															<tr>
																<th>Additional</th>
																<td>Php <?php echo $row7['amount'];?></td>
															</tr>
															<?php
														} ?>
														<tr>
															<th>TOTAL</th>
															<th>
																<?php
																if($row1['duration']>=1){
																	echo 'Php '.number_format($row4['total_afterbal'],2);
																}
																else{
																	echo 'Php '.number_format($row4['total_amount'],2);
																} ?>
															</th>
														</tr>
													</table>
												</div>
												<div style="font-family:robotoreg;">
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
											}
											else{ ?>
												<div class="mb-3">
													<table style="width:100%">
														<tr>
															<th style="width:50%">Original Rate</th>
															<td style="width:50%">Php <?php echo $row4['price'];?> (x <?php echo ceil($row1['pax']/12);?> van[s])</td>
														</tr>
														<?php
														if($row1['duration']>=1){ ?>
															<tr>
																<th>Total Before Additional</th>
																<td>Php <?php echo number_format($row4['total_amount'],2);?></td>
															</tr>
															<tr>
																<th>Additional</th>
																<td>Php <?php echo $row7['amount'];?></td>
															</tr>
															<?php
														} ?>
														<tr>
															<th>TOTAL</th>
															<th>
																<?php
																if($row1['duration']>=1){
																	echo 'Php '.number_format($row4['total_afterbal'],2);
																}
																else{
																	echo 'Php '.number_format($row4['total_amount'],2);
																} ?>
															</th>
														</tr>
													</table>
												</div>
												<div style="font-family:robotoreg;">
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
											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					} ?>
					<div class="mt-4 mb-5" style="font-family: robotoblack;text-align: right;">
						<?php
						$id=$_SESSION['adminid'];
						$qu=mysqli_query($conn,"SELECT * FROM admin_table WHERE admin_id='$id'");
						$nm=mysqli_fetch_assoc($qu); ?>
						<h2>Retrieved By: </h2> <?php echo $nm['admin_first_name'].' '.$nm['admin_last_name']; ?>
						<h3>Time: </h3> <?php echo DATE("Y M d H:i A"); ?>
					</div>
					<?php
				} ?>
			</div>
		</body>
	</html>
	<?php 
} ?>