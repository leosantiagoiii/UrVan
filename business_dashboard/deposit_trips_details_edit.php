<?php session_start();
$major_id=$_GET['major_id'];
$client_id=$_GET['client_id'];
$transaction_type=$_GET['transaction_type'];
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(!isset($_GET['viewdee'])){
		header("Location:../index.php?entry=error");
		exit();
	}
	else{
		require "../includes/dbconnect.inc.php";
		require "header.php";
		?>
		<main>
			<?php
			$sql1=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
			$rez1=mysqli_fetch_assoc($sql1);

			$sql2=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
			$rez2=mysqli_fetch_assoc($sql2);

				$kl=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$rez2[tour_id]'");
				$kl1=mysqli_fetch_assoc($kl);

			$sql3=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'"); //looping will occur

			$sql4=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
			$rez4=mysqli_fetch_assoc($sql4);

			$sql5=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
			$rez5=mysqli_fetch_assoc($sql5);

			$sql6=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major_id'");
			$rez6=mysqli_fetch_assoc($sql6);

			$sql7=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major_id'"); ?>
			<div class="container-fluid">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="index.php">Dashboard</a>
					</li>
					<li class="breadcrumb-item">
						<a href="deposit_trips.php">Deposit Trips</a>
					</li>
					<li class="breadcrumb-item active"><?php echo $major_id;?></li>
				</ol>
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-table"></i>
						<?php echo $major_id;?>
					</div>
					<div class="card-body">
						<!-- orihinal -->


						<!-- not orig -->
						<form action="../includes/deposit_trips_edit.inc.php" method="post" enctype="multipart/form-data">
							<!-- show all details pls -->
							<div class="row form-group">
								<div class="col-lg-4">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Trip ID:</div>
										</div>
										<input type="text" class="form-control" value="<?php echo $major_id; ?>" readonly>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Request By:</div>
										</div>
										<input type="text" class="form-control" value="<?php echo $rez1['client_first_name'].' '.$rez1['client_last_name'].' (@'.$rez1['client_username'].')';?>" readonly>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Trip To:</div>
										</div>
										<input type="text" class="form-control" value="<?php echo $kl1['tour_name'];?>" readonly>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-4">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Trip Amount:</div>
										</div>
										<input type="text" class="form-control" value="<?php echo 'Php'.$rez4['price']; ?>" readonly>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="row">
										<div class="col-lg-6">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Pax:</div>
												</div>
												<input type="text" class="form-control" value="<?php echo $rez2['pax']; ?>" readonly>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Vans:</div>
												</div>
												<input type="text" class="form-control" value="<?php echo $rez4['vans_used']; ?>" readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Current Amount:</div>
										</div>
										<input type="text" class="form-control" value="<?php echo 'Php'.$rez4['total_amount'].'.00'; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-lg-12">
									<div class="card" style="padding:20px; overflow-y: auto;height:250px;">
										<table class="table table-hover">
											<thead>
												<tr>
													<th width="35%">Origin</th>
													<th width="35%">Destination</th>
													<th>Duration</th>
													<th>Mileage</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sqe=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
												$op=mysqli_fetch_assoc($sqe);
												$opt=$op['optimise'];
												if($opt==null){
													while($rez3=mysqli_fetch_assoc($sql7)){ ?>
														<tr>
															<td><?php echo $rez3['orig_place'];?></td>
															<td><?php echo $rez3['des_place'];?></td>
															<td><?php echo $rez3['duration'];?></td>
															<td><?php echo $rez3['mileage'].' km';?></td>
														</tr>
														<?php
														$mil_not_opt[]=$rez3['mileage'];
													}
													$milage_sum_not_opt=array_sum($mil_not_opt);
												}
												elseif($opt=="true"){
														$first_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
														$first=mysqli_fetch_assoc($first_q);
														$start_lng=$first['orig_lat'];
														$start_lat=$first['orig_lng'];
														$start_lt_ln=$start_lng.','.$start_lat;
														$start_place_id=$first['orig_place_id'];//
														$doop=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
														while($rub=mysqli_fetch_assoc($doop)){
															$latt=$rub['longitude'];
															$lonn=$rub['latitude'];
															$coords=$latt.','.$lonn;
															$coord_arr[]=$coords;
															$coords_place_id=$rub['place_id'];//
															$coord_arr_place_id[]="place_id:".$coords_place_id;//
														}
														$last_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
														$last=mysqli_fetch_assoc($last_q);
														$last_lng=$last['orig_lat'];
														$last_lat=$last['orig_lng'];
														$last_lt_ln=$last_lng.','.$last_lat;
														$last_place_id=$last['des_place_id'];
														// $implode_wp=implode("|",$coord_arr);
														// $url="https://maps.googleapis.com/maps/api/directions/json?origin=".$start_lt_ln."&destination=".$last_lt_ln."&waypoints=optimize:true|".$implode_wp."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
														$implode_wp_place_id=implode("|",$coord_arr_place_id);
														$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$start_place_id."&destination=place_id:".$start_place_id."&waypoints=optimize:true|".$implode_wp_place_id."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
														$getJson=file_get_contents($url);
														$json2PHP=json_decode($getJson, true);
														$len=count($json2PHP['routes'][0]['legs']);
														for($i=0;$i<$len;$i++){ ?>
															<tr>
																<td>
																	<?php //echo $json2PHP['routes'][0]['legs'][$i]['start_address'];
																	$place_idA = $json2PHP['geocoded_waypoints'][$i]['place_id'];
																	$urlA='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idA.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
																	$getJsonA=file_get_contents($urlA);
																	$json2PHPA=json_decode($getJsonA, true);
																	echo $json2PHPA['result']['name'];
																	$lenComp1=count($json2PHPA['result']['address_components']);
																	for($l=1;$l<$lenComp1;$l++){
																		echo ', '.$json2PHPA['result']['address_components'][$l]['short_name'];
																	} ?> 
																</td>
																<td>
																	<?php //echo $json2PHP['routes'][0]['legs'][$i]['end_address'];
																	$j=$i+1;
																	$place_idB = $json2PHP['geocoded_waypoints'][$j]['place_id'];
																	$urlB='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idB.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
																	$getJsonB=file_get_contents($urlB);
																	$json2PHPB=json_decode($getJsonB, true);
																	echo $json2PHPB['result']['name'];
																	$lenComp2=count($json2PHPB['result']['address_components']);
																	for($m=1;$m<$lenComp2;$m++){
																		echo ', '.$json2PHPB['result']['address_components'][$m]['short_name'];
																	} ?> 
																</td>
																<td><?php echo $json2PHP['routes'][0]['legs'][$i]['duration']['text'];?></td>
																<td><?php echo $json2PHP['routes'][0]['legs'][$i]['distance']['text'];?></td>
															</tr>
															<?php
															$mileage_optimise[] = substr($json2PHP['routes'][0]['legs'][$i]['distance']['text'], 0, -3);
														}
														$mileage_optimise_sum=array_sum($mileage_optimise);
													} ?>
											</tbody>
											<tfoot>
												<?php
												if($opt==null){?>
													<tr>
														<td></td>
														<td></td>
														<th>Total:</th>
														<td><?php echo $milage_sum_not_opt.' km';?></td>
													</tr>
													<?php
												}
												elseif($opt=="true"){ ?>
													<tr>
														<td></td>
														<td></td>
														<th>Total:</th>
														<td><?php echo $mileage_optimise_sum.' km';?></td>
													</tr>
													<?php
												} ?>
											</tfoot>
										</table>
									</div>
								</div>
								<div class=""></div>
							</div>
							
							<div class="row form-group">
								<div class="col-lg-4">
									<label for="ahhaj">Additional Balance</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Php:</div>
										</div>
										<input type="text" id="ahhaj" class="form-control" name="amount" value="<?php echo $rez6['amount']; ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<label for="jkjk">Upload Cost Breakdown (.pdf only)</label>
									<input type="file" id="jkjk" name="costsummary" class="form-control" style="padding:3.5px;">
								</div>
								<div class="col-lg-4">
									<a href="../includes/<?php echo $rez6['filepath']; ?>" class="btn btn-lg btn-secondary" download>Download Original Uplaoded PDF</a>
								</div>
							</div>
							<input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
							<input type="hidden" name="major_id" value="<?php echo $major_id;?>">
							<input type="hidden" name="transaction_type" value="<?php echo $transaction_type; ?>">
							<button name="apruba" class="btn btn-success">Save Changes</button>&nbsp;
							<button name="remub" class="btn btn-danger">Remove</button>
						</form>
						<!-- not orig -->


					</div>
				</div>
			</div>
		</main>
		<?php
		require "footer.php";
	}
}