<?php 
require "includes/check_trips.inc.php";
require "header.php"; 
$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id=$_SESSION[clientid] AND completion='NO' ORDER BY created_at ASC LIMIT 1");
$count=mysqli_num_rows($sql);
$major=mysqli_fetch_assoc($sql);
$sql=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$major[tour_id]'");
$tour=mysqli_fetch_assoc($sql);
if($count<=0){ ?>
	<div style="margin:120px 0px;">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div style="padding:30px;" class="container text-center">
					<div style="border-style:solid;border-width:1px; padding:50px;box-shadow: 10px 10px 0px 0px rgba(64,64,64,1);">
						<?php
						if(isset($forgotCheckin)){ ?>
							<h1 style="font-family:raleway">Unfortunately, the system automatically cancelled your latest trip. We're sorry. We hope to see you again, though!</h1>
							<div style="font-family:monsreg">If you want to see your past trips, click <a href="client_past_trips.php">here</a></div>
							<hr>
							<p style="margin:0;padding:0"><b>Take note that not checking in one day before will cause your trip to be cancelled. No refunds at all.</b></p>
							<?php 
						}
						else{ ?>
							<h1 style="font-family:raleway">Your have no reservations</h1>
							<div style="font-family:monsreg">If you want to see your past trips, click <a href="client_past_trips.php">here</a></div>
							<?php
						} ?>
					</div>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
<?php
}
else{ ?>
	<?php $aaa=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'"); ?>
	<?php $transac=mysqli_fetch_assoc($aaa); ?>
	<?php $sq="SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'";
	$sq=mysqli_query($conn,$sq);
	$slip=mysqli_fetch_assoc($sq);
	?>
	<main style="margin-top:20px;margin-bottom:30px;">
		<div class="container">
			<h1>Trip ID: <?php echo $major['major_id'];?></h1>
			<div class="row">
				<div class="col-lg-7">
					<div class="text-center" style="padding:30px;border-style:solid;border-width:1px;margin-top:5px;">
						<h3>
							<?php
							echo $tour['tour_name'];
							$jklo=$major['start_date'];
							$jklo2=$major['end_date'];
							$da1i=strtotime($jklo);
							$da2i=strtotime($jklo2);
							$kailo1=DATE("Y M d",$da1i); 
							$kailo2=DATE("Y M d",$da2i); ?>
						</h3>
						<p style="line-height:0px;">From <?php echo $kailo1;?> to <?php echo $kailo2;?></p>
						<p style="line-height:2px;"><b>Mode of Payment: <u><?php echo $transac['transaction_type'];?></u></b></p>
					</div>
					<div class="row text-center mt-3">
						<div class="col-lg-6">
							Reporting Time:<br><b><?php echo $major['reporting_time'];?></b>
						</div>
						<div class="col-lg-6">
							Reporting Place:<br><b><?php echo $major['reporting_place'];?></b>
						</div>
					</div>
					<div class="mt-3">
						<h3>ITINERARY</h3>
						<div style="height:300px;overflow: auto;border-style:solid;border-width:1px;">
							<table class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th style="width:35%">Origin</th>
										<th style="width:35%">Destination</th>
										<th style="width:30%">Duration</th>
										<th style="width:30%">Mileage</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($major['optimise']==null){
										$sss=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major[major_id]'");
										while($minor=mysqli_fetch_assoc($sss)){ ?>
											<tr>
												<td><?php echo $minor['orig_place'];?></td>
												<td><?php echo $minor['des_place'];?></td>
												<td><?php echo $minor['duration'];?></td>
												<td><?php echo $minor['mileage'].' km';?></td>
											</tr>
											<?php 
										}
									}
									elseif($major['optimise']=="true"){
										$first_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY book_arrdep_id ASC LIMIT 1");
										$first=mysqli_fetch_assoc($first_q);
										$start_lng=$first['orig_lat'];
										$start_lat=$first['orig_lng'];
										$start_lt_ln=$start_lng.','.$start_lat;

										$start_place_id=$first['orig_place_id'];//

										$doop=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major[major_id]'");
										while($rub=mysqli_fetch_assoc($doop)){
											$latt=$rub['longitude'];
											$lonn=$rub['latitude'];
											$coords=$latt.','.$lonn;
											$coord_arr[]=$coords;

											$coords_place_id=$rub['place_id'];//
											$coord_arr_place_id[]="place_id:".$coords_place_id;//
										}

										$last_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id > (SELECT MIN(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY book_arrdep_id ASC LIMIT 1");
										$last=mysqli_fetch_assoc($last_q);
										$last_lng=$last['des_lat'];
										$last_lat=$last['des_lng'];
										$last_lt_ln=$last_lng.','.$last_lat;

										$last_place_id=$last['des_place_id'];

										// $implode_wp=implode("|",$coord_arr);
										// $url="https://maps.googleapis.com/maps/api/directions/json?origin=".$start_lt_ln."&destination=".$last_lt_ln."&waypoints=optimize:true|".$implode_wp."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";

										$implode_wp_place_id=implode("|",$coord_arr_place_id);
										$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$start_place_id."&destination=place_id:".$start_place_id."&waypoints=optimize:true|".$implode_wp_place_id."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";

										$getJson=file_get_contents($url);
										$json2PHP=json_decode($getJson, true);
										$len=count($json2PHP['routes'][0]['legs']);
										for($i=0;$i<$len;$i++){?>
											<tr>
												<td>
													<?php
													// echo $json2PHP['routes'][0]['legs'][$i]['start_address'].'<br>';
													// echo $json2PHP['routes'][0]['legs'][$i]['start_location']['lat'].'<br>';
													// echo $json2PHP['routes'][0]['legs'][$i]['start_location']['lng'].'<br>';
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
													<?php
													// echo $json2PHP['routes'][0]['legs'][$i]['end_address'].'<br>';
													// echo $json2PHP['routes'][0]['legs'][$i]['end_location']['lat'].'<br>';
													// echo $json2PHP['routes'][0]['legs'][$i]['end_location']['lng'].'<br>';
													$j=$i+1;
														$place_idB = $json2PHP['geocoded_waypoints'][$j]['place_id'];
														$urlB='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idB.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
														$getJsonB=file_get_contents($urlB);
														$json2PHPB=json_decode($getJsonB, true);
														echo $json2PHPB['result']['name'];
														$lenComp2=count($json2PHPB['result']['address_components']);
														for($m=1;$m<$lenComp2;$m++){
															echo ', '.$json2PHPB['result']['address_components'][$m]['short_name'];
														} 
													 ?>
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
							</table>
						</div>
					</div>
					<div class="mt-3">
						<?php
						$sqm=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major[major_id]'");
						$countofiten=mysqli_num_rows($sqm);
						if($countofiten==0){ ?>
							<div class="alert alert-warning" role="alert">
								<h3 class="alert-heading">Please refresh to compute the mileage</h3>
							</div>
							<?php
							$con=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major[major_id]'");
							$con_num=mysqli_num_rows($con);
							if($con_num==1){
								$start_and_end_lat=$major['latitude'].','.$major['longitude'];
								$start_place_id=$major['place_id'];
								$kuku=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major[major_id]'");
								$only_destination=mysqli_fetch_assoc($kuku);
								$only_destination_long_lat=$only_destination['longitude'].','.$only_destination['latitude'];
								$only_place_id=$only_destination['place_id'];
								$url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=place_id:'.$start_place_id.'&destinations=place_id:'.$only_place_id.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$getJson=file_get_contents($url);
								$json2PHP=json_decode($getJson, true);
								$mileage=$json2PHP['rows'][0]['elements'][0]['distance']['text'];
								$mileage = substr($mileage, 0, -3);
								$duration=$json2PHP['rows'][0]['elements'][0]['duration']['text'];
								$orig_place=$major['reporting_place'];
								$orig_lat=$major['latitude'];
								$orig_lng=$major['longitude'];
								$des_place=$only_destination['destination'];
								$des_lat=$only_destination['longitude'];
								$des_lng=$only_destination['latitude'];
								$juy=mysqli_query($conn,"INSERT INTO booking_arr_dep (book_arrdep_id,major_id,orig_place,orig_lng,orig_lat,des_place,des_lng,des_lat,duration,mileage,orig_place_id,des_place_id) VALUES ('','$major[major_id]','$orig_place','$orig_lng','$orig_lat','$des_place','$des_lng','$des_lat','$duration','$mileage','$start_place_id','$only_place_id')");
								//from trip to home
								$kra=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major[major_id]'");
								$last_destination=mysqli_fetch_assoc($kra);
								// $url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.$only_destination_long_lat.'&destinations='.$start_and_end_lat.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=place_id:'.$only_place_id.'&destinations=place_id:'.$start_place_id.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$getJson=file_get_contents($url);
								$json2PHP=json_decode($getJson, true);
								$mileage=$json2PHP['rows'][0]['elements'][0]['distance']['text'];
								$mileage = substr($mileage, 0, -3);
								$duration=$json2PHP['rows'][0]['elements'][0]['duration']['text'];
								$orig_place=$last_destination['destination'];
								$orig_lat=$last_destination['longitude'];
								$orig_lng=$last_destination['latitude'];
								$orig_place_id=$last_destination['place_id'];
								$des_place=$major['reporting_place'];
								$des_lat=$major['latitude'];
								$des_lng=$major['longitude'];
								$des_place_id=$major['place_id'];
								$juy=mysqli_query($conn,"INSERT INTO booking_arr_dep (book_arrdep_id,major_id,orig_place,orig_lng,orig_lat,des_place,des_lng,des_lat,duration,mileage,orig_place_id,des_place_id) VALUES ('','$major[major_id]','$orig_place','$orig_lng','$orig_lat','$des_place','$des_lng','$des_lat','$duration','$mileage','$orig_place_id','$des_place_id')");
							}
							elseif($con_num>=2){
								//home
								$kuku=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE created_at < (SELECT MAX(created_at) FROM booking_minordetails WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY created_at ASC LIMIT 1");
								$first_destination=mysqli_fetch_assoc($kuku);
								// $url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.$major['latitude'].','.$major['longitude'].'&destinations='.$first_destination['longitude'].','.$first_destination['latitude'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=place_id:'.$major['place_id'].'&destinations=place_id:'.$first_destination['place_id'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$getJson=file_get_contents($url);
								$json2PHP=json_decode($getJson, true);
								$mileage=$json2PHP['rows'][0]['elements'][0]['distance']['text'];
								$mileage = substr($mileage, 0, -3);
								$duration=$json2PHP['rows'][0]['elements'][0]['duration']['text'];
								$orig_place=$major['reporting_place'];
								$orig_lat=$major['latitude'];
								$orig_lng=$major['longitude'];

								$orig_place_id=$major['place_id'];

								$des_place=$first_destination['destination'];
								$des_lat=$first_destination['longitude'];
								$des_lng=$first_destination['latitude'];

								$des_place_id=$first_destination['place_id'];

								$juy=mysqli_query($conn,"INSERT INTO booking_arr_dep ( book_arrdep_id, major_id, orig_place, orig_lng, orig_lat, des_place, des_lng, des_lat, duration, mileage, orig_place_id, des_place_id) VALUES ( '', '$major[major_id]','$orig_place','$orig_lng','$orig_lat','$des_place','$des_lng','$des_lat','$duration','$mileage', '$orig_place_id', '$des_place_id')");
								//home
								//frm itinerary
								$orgin_q=mysqli_query($conn,"SELECT * FROM `booking_minordetails` WHERE created_at < (SELECT MAX(created_at) FROM booking_minordetails WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY `created_at` ASC");
								$destination_q=mysqli_query($conn,"SELECT * FROM `booking_minordetails` WHERE created_at > (SELECT MIN(created_at) FROM booking_minordetails WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY `created_at` ASC");
								while($origin=mysqli_fetch_assoc($orgin_q) AND $destination=mysqli_fetch_assoc($destination_q)){
									// $url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.$origin['longitude'].','.$origin['latitude'].'&destinations='.$destination['longitude'].','.$destination['latitude'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
									$url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=place_id:'.$origin['place_id'].'&destinations=place_id:'.$destination['place_id'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
									$getJson=file_get_contents($url);
									$json2PHP=json_decode($getJson, true);
									$mileage=$json2PHP['rows'][0]['elements'][0]['distance']['text'];
									$mileage = substr($mileage, 0, -3);
									$duration=$json2PHP['rows'][0]['elements'][0]['duration']['text'];
									mysqli_query($conn,"INSERT INTO booking_arr_dep ( book_arrdep_id, major_id,orig_place,orig_lng,orig_lat,des_place,des_lng,des_lat,duration,mileage,orig_place_id,des_place_id) VALUES ('','$major[major_id]','$origin[destination]','$origin[latitude]','$origin[longitude]','$destination[destination]','$destination[latitude]','$destination[longitude]','$duration','$mileage','$origin[place_id]','$destination[place_id]') ");
								}
								//frm itinerary
								// to home
								$kra=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE created_at > (SELECT MIN(created_at) FROM booking_minordetails WHERE major_id='$major[major_id]') AND major_id='$major[major_id]' ORDER BY created_at DESC LIMIT 1");
								$last_destination=mysqli_fetch_assoc($kra);
								// $url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.$last_destination['longitude'].','.$last_destination['latitude'].'&destinations='.$major['latitude'].','.$major['longitude'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$url='https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=place_id:'.$last_destination['place_id'].'&destinations=place_id:'.$major['place_id'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
								$getJson=file_get_contents($url);
								$json2PHP=json_decode($getJson, true);
								$mileage=$json2PHP['rows'][0]['elements'][0]['distance']['text'];
								$mileage = substr($mileage, 0, -3);
								$duration=$json2PHP['rows'][0]['elements'][0]['duration']['text'];
								$orig_place=$last_destination['destination'];
								$orig_lat=$last_destination['longitude'];
								$orig_lng=$last_destination['latitude'];
								$orig_place_id=$last_destination['place_id'];
								$des_place=$major['reporting_place'];
								$des_lat=$major['latitude'];
								$des_lng=$major['longitude'];
								$des_place_id=$major['place_id'];
								$juy=mysqli_query($conn,"INSERT INTO booking_arr_dep (book_arrdep_id,major_id,orig_place,orig_lng,orig_lat,des_place,des_lng,des_lat,duration,mileage,orig_place_id,des_place_id) VALUES ('','$major[major_id]','$orig_place','$orig_lng','$orig_lat','$des_place','$des_lng','$des_lat','$duration','$mileage','$orig_place_id','$des_place_id')");
								//  to home
							} ?>
							<?php
						}
						else{
							$arr_des_present=mysqli_query($conn,"SELECT *, SUM(mileage) AS mile_sum FROM booking_arr_dep WHERE major_id='$major[major_id]'");
							$rowta=mysqli_fetch_assoc($arr_des_present); ?>
							<div class="alert alert-success" role="alert">
								<h3 class="alert-heading"><b>Mileage: </b>
									<?php
									if($major['optimise']==null){
										echo $rowta['mile_sum']." km";
									}
									else{
										echo $mileage_optimise_sum." km";
									} ?>
								</h3>
								Click <a target="_blank" href="mileage.php?major_id=<?php echo $major['major_id'];?>">here</a> to see the details
							</div>
							<?php
						} ?>
					</div>
				</div>
				<div class="col-lg-5">
					<?php
					$end_DATE=$major['start_date'];				
					$toTime1=strtotime($end_DATE);
					$toTime2=strtotime("-1 day",$toTime1);	
					$end_DATEMINUS1=date("Y-m-d",$toTime2);	
					$DAY2DAY=DATE("Y-m-d");
					if($DAY2DAY<$end_DATEMINUS1 AND $slip['approval']!="APPROVED"){ ?>
						<?php
						if($major['duration']>=1){ ?>
							<div class="alert alert-primary" role="alert">
								<?php
								if($major['optimise']==null){ ?>
									<h5 class="alert-heading">Want to get to these places in a shorter amount of time?</h5>
									Click <a href="includes/optimise_trip.inc.php?optim=yes&major_id=<?php echo $major['major_id']; ?>"class="btn btn-secondary btn-sm active">here</a> to activate <b>Optimize Mode</b>
									<?php
								}
								else{ ?>
									<h5 class="alert-heading">Currently in Optimize Mode</h5>
									Click <a href="includes/optimise_trip.inc.php?optim=no&major_id=<?php echo $major['major_id']; ?>" class="btn btn-danger btn-sm active">here</a> to turn it off</b>
									<?php
								} ?>
							</div>
							<?php
						}
					} ?>
					<?php
					$mar=mysqli_query($conn,"SELECT * FROM checkin_tbl WHERE major_id='$major[major_id]'");
					$marb=mysqli_num_rows($mar);
					if($marb==1){?>
						<div class="text-center alert alert-primary mb-3" style="padding-top:25px;margin:0">
							<h3 class="alert-heading">Checked in!</h3>
							<p>Let's wait for tomorrow on your trip. See you!</p>
						</div>
						<?php
					} ?>
					<table class="table">
						<thead>
							<tr>
								<th>Pax</th>
								<th>No. of Vans</th>
								<th>Price</th>
								<th>Total Amount</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $major['pax'];?></td>
								<td><?php echo $transac['vans_used'];?></td>
								<td><?php echo "₱".$transac['price'];?></td>
								<td><?php echo "₱".$transac['total_amount'].".00";?></td>
							</tr>
						</tbody>
					</table>
					<?php
					$end_date=$major['start_date'];				
					$to_time1=strtotime($end_date);
					$to_time2=strtotime("-1 day",$to_time1);	
					$end_dateminus1=date("Y-m-d",$to_time2);	
					$today=DATE("Y-m-d");						
					if($major['duration']>=1){
						$slk=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major[major_id]'");
						$harp=mysqli_fetch_assoc($slk); ?>
						<div>
							<?php if($harp['amount']==null){
								echo "<h5 style='line-height:10px;'>Additional Cost: Review Pending</h5><div class='mt-3 mb-2 card' style='line-height:15px;text-align:left;font-weight:100;padding:13px;'>
									<small>Your trip won't push through unless you've partially paid (for Stripe users). For Deposits, wait for the management to give you the additional costs and pay the trip in whole.</small>
								</div>";
							}
							else{
								$mocha=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major[major_id]'");
								$mocha1=mysqli_fetch_assoc($mocha);
								echo "<h5 style='line-height:10px;'>Additional Cost: PHP"
								.$harp['amount'].
								"</h5> <h5><b>Final Cost: <u>PHP".$transac['total_afterbal']."</u></b></h5><div class='mb-1'>
									Cost Breakdown <a href=\"includes/".$mocha1['filepath']."\" target='_blank'>Here</a>
								</div>
								<div class='mt-3 mb-2 card' style='line-height:15px;text-align:left;font-weight:100;padding:13px;'>
									<small>Your trip won't push through unless you've partially paid (for Stripe users). For Deposits, wait for the management to give you the additional costs and pay the trip in whole.</small>
								</div>";
							} ?>
						</div>
						<?php
					} ?>
					<small>
						<small>
							<ul>
								<li>BTTSC has a strict policy of allowing only 12 passengers per van.</li>
								<?php 
								if($transac['transaction_type']!="DEPOSIT"){ ?>
									<li>Click <a href="<?php echo $transac['receipt_url'];?>">here</a> to view your receipt</li>
									<?php 
								} ?>
							</ul>
						</small>
					</small>
					<div>
						<?php 
						if($transac['transaction_type']!="DEPOSIT"){ ?> <!--if stripe-->
							<form action="refund.php" method="post">
								<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
								<input type="hidden" name="refund_id" value="<?php echo $transac['id']; ?>">
								<?php 
								if($slip['approval']=="APPROVED"){ ?>
									<input type="hidden" name="koool">
									<?php 
								} ?>

								<?php
								// kapag nagcheck in na, okay na. there's a cancel button dahil pag may emergency etc.
								$kwr=mysqli_query($conn,"SELECT * FROM checkin_tbl WHERE major_id='$major[major_id]'");
								$p09p=mysqli_num_rows($kwr);
								if($p09p==0){?>
									<?php 
									if($today==$end_dateminus1){ ?>
										<button class="btn btn-warning btn-block" name="1day" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
										<button class="btn btn-block btn-primary" name="check_in" type="submit" formaction="includes/check_in.inc.php">Check in</button>
										<?php 
									}
									elseif($today<$end_dateminus1){ ?>
										<button class="btn btn-danger btn-block" name="reund">Cancel Trip</button>
										<?php
									} ?>
									<?php 
								} ?>


							</form>

							<small><small>
								<ul class="mt-3">
									<li>Cancelling the trip means you'll be getting a full refund.</li>
									<li>However, no refunds will occur had the refund been done 1 day prior to the trip</li>
								</ul>
							</small></small>
							<?php
							$par1=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major[major_id]' AND amount IS NOT NULL");
							$par2=mysqli_fetch_assoc($par1);
							$par3=mysqli_num_rows($par1);
							if($par3!=0){ ?> <!--if stripe more than 1 day-->
								<form action="includes/deposit_method.inc.php" method="POST"  enctype="multipart/form-data">
									<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
									<?php
									if($slip['deposit_slip']==null && $slip['reference_num']==null){ //stripe dep slip and ref num not yet uploaded ?>
										<div class="form-group">
											<input type="text" name="referencenum" placeholder="Reference Number" class="form-control">
											<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
										</div>
										<div class="form-group">
											<label for="">Upload Deposit Slip</label>
											<input type="file" name="depositpic" class="form-control" style="padding:3.5px;">
										</div>
										<div class="btn-group d-flex">
											<button class="btn btn-success w-100" name="upup" type="submit">Upload Deposit Slip</button>
										</div>
										<?php
									}
									else{ //stripe pic and ref num uploaded ?>
										<div class="form-group">
											<h3>Payment: <?php if($slip['approval']=="PENDING"){echo 'Received';}elseif($slip['approval']=="APPROVED"){echo 'Approved';}elseif($slip['approval']=="DENIED"){echo 'Denied';} ?></h3>
											<small>
												<?php
												if($slip['approval']=="APPROVED"){ ?>
													<!-- Here's the receipt: <a href="deposit_receipt.php?major_id=<?php //echo $major['major_id']; ?>&rec_id=<?php //echo $transac['receipt_url'];?>">Click Here</a> -->
													<br><br>
													<?php
													$findDriver=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major[major_id]'");
													$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$major[tour_id]'");
													$welz=mysqli_num_rows($ba);
													if($welz>=1){
														$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major[major_id]'"); 
													}
													else{
														$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major[major_id]'"); 
													} ?>
													<h6>
														Your driver is/are: 
														<ul>
															<?php
															while($fort=mysqli_fetch_assoc($findDriver)){
																if($fort['type']=="AUTH_DRIV"){
																	$findAuth=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$fort[driver_pk]'");
																	$findAuth_=mysqli_fetch_assoc($findAuth);
																	echo '<li>'.strtoupper($findAuth_['driver_name']).'</li>';
																}
																else{
																	$findMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$fort[driver_pk]'");
																	$findMem_=mysqli_fetch_assoc($findMem);
																	echo '<li>'.strtoupper($findMem_['member_first_name'].' '.$findMem_['member_last_name']).'</li>';
																}
															} ?>
														<ul>
													</h6>
													<h6>
														The van assigned to you is/are:
														<ul>
															<?php
															while($fort=mysqli_fetch_assoc($findVehi)){
																$vehicle_id=$fort['vehicle_id'];
																$findVeh=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
																$findVeh_=mysqli_fetch_assoc($findVeh);
																echo '<li>'.strtoupper($findVeh_['plate_number']).' ('.$findVeh_['year'].' '.$findVeh_['make'].' '.$findVeh_['model'].')'.'</li>';
															} ?>
														</ul>
													</h6>
													<?php 
												} ?>
											</small>
										</div>
										<div class="form-group">
											<input type="text" name="referencenum" placeholder="Reference Number" value="<?php echo $slip['reference_num']; ?>" readonly class="form-control">
											<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
										</div>
										<div class="form-group">
											<div class="card" style="padding:10px;">
												<img src="includes/<?php echo $slip['deposit_slip'];?>" style="width:100%;" alt="">
											</div>
										</div>
									<?php
									} ?>
								</form>
								<?php
							}
							else{
								echo "<small>";
								$findDriver=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major[major_id]'");
								$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$major[tour_id]'");
								$welz=mysqli_num_rows($ba);
								if($welz>=1){
									$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major[major_id]'");
								}
								else{
									$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major[major_id]'");
								}
								echo "<h6>Your driver(s) is/are:</h6>";
								echo "<ul>";
								while($fort=mysqli_fetch_assoc($findDriver)){
									if($fort['type']=="AUTH_DRIV"){
										$findAuth=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$fort[driver_pk]'");
										$findAuth_=mysqli_fetch_assoc($findAuth);
										echo '<li>'.strtoupper($findAuth_['driver_name']).'</li>';
									}
									else{
										$findMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$fort[driver_pk]'");
										$findMem_=mysqli_fetch_assoc($findMem);
										echo '<li>'.strtoupper($findMem_['member_first_name'].' '.$findMem_['member_last_name']).'</li>';
									}
								}
								echo "</ul>";
								echo "<h6>Your van(s) is/are:</h6>";
								echo "<ul>";
								while($fort=mysqli_fetch_assoc($findVehi)){
									$vehicle_id=$fort['vehicle_id'];
									$findVeh=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
									$findVeh_=mysqli_fetch_assoc($findVeh);
									echo '<li>'.strtoupper($findVeh_['plate_number']).' ('.$findVeh_['year'].' '.$findVeh_['make'].' '.$findVeh_['model'].')'.'</li>';
								}
								echo "</ul>";
								echo "<small>";
							}
						}
						





						else{ // if deposit
							$slk=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$major[major_id]'");
							$harp=mysqli_fetch_assoc($slk);
							if($major['duration']<=0){ ?> <!--if deposit 0 days-->
								<form action="includes/deposit_method.inc.php" method="POST"  enctype="multipart/form-data">
									<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
									<?php $sq="SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'";
									$sq=mysqli_query($conn,$sq);
									$slip=mysqli_fetch_assoc($sq);
									if($slip['deposit_slip']==null && $slip['reference_num']==null){ ?> <!--if dep slip hasnt been uploaded yet-->
										<div class="form-group">
											<input type="text" name="referencenum" placeholder="Reference Number" class="form-control">
											<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
										</div>
										<div class="form-group">
											<label for="">Upload Deposit Slip</label>
											<input type="file" name="depositpic" class="form-control" style="padding:3.5px;">
										</div>
										<div class="btn-group d-flex">
											<button class="btn btn-success w-100" name="uplowd" type="submit">Upload Deposit Slip</button>
											<?php 
											if($today==$end_dateminus1){ ?>
												<button class="btn btn-warning w-100" name="1day" type="submit" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
												<?php 
											}
											elseif($today<$end_dateminus1){ ?>
												<button class="btn btn-danger w-100" name="cansel" type="submit">Cancel Trip</button>
												<?php
											} ?>
										</div>
										<?php 
									}
									else{ // if dep has already been uploaded ?>
										<div class="form-group">
											<h3>Payment: <?php if($slip['approval']=="PENDING"){echo 'Received';}elseif($slip['approval']=="APPROVED"){echo 'Approved';}elseif($slip['approval']=="DENIED"){echo 'Denied';} ?></h3>
											<small>
												<?php 
												if($slip['approval']=="APPROVED"){ ?>
													<!-- Here's the receipt: <a href="deposit_receipt.php?major_id=<?php //echo $major['major_id']; ?>&rec_id=<?php //echo $transac['receipt_url'];?>">Click Here</a><br><br> -->
													<?php 
													$findDriver=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major[major_id]'");
													$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$major[tour_id]'");
													$welz=mysqli_num_rows($ba);
													if($welz>=1){
														$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major[major_id]'"); 
													}
													else{
														$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major[major_id]'"); 
													} ?>			
													<h6>
														Your driver(s) is/are:
														<ul>
															<?php 
															while($fort=mysqli_fetch_assoc($findDriver)){
																if($fort['type']=="AUTH_DRIV"){
																	$findAuth=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$fort[driver_pk]'");
																	$findAuth_=mysqli_fetch_assoc($findAuth);
																	echo '<li>'.strtoupper($findAuth_['driver_name']).'</li>';
																}
																else{
																	$findMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$fort[driver_pk]'");
																	$findMem_=mysqli_fetch_assoc($findMem);
																	echo '<li>'.strtoupper($findMem_['member_first_name'].' '.$findMem_['member_last_name']).'</li>';
																}
															} ?>
														</ul>
													</h6>	
													<h6>
														The van(s) assigned to you is/are:
														<ul>
															<?php
															while($fort=mysqli_fetch_assoc($findVehi)){
																$vehicle_id=$fort['vehicle_id'];
																$findVeh=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
																$findVeh_=mysqli_fetch_assoc($findVeh);
																echo '<li>'.strtoupper($findVeh_['plate_number']).' ('.$findVeh_['year'].' '.$findVeh_['make'].' '.$findVeh_['model'].')'.'</li>';
															} ?>
														</ul>
													</h6>	
													<?php
												} ?>
											</small>						
										</div>
										<div class="form-group">
											<input type="text" name="referencenum" placeholder="Reference Number" value="<?php echo $slip['reference_num']; ?>" readonly class="form-control">
											<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
										</div>
										<div class="form-group">
											<div class="card" style="padding:10px;">
												<img src="includes/<?php echo $slip['deposit_slip'];?>" style="width:100%;" alt="">
											</div>
										</div>
										<?php 
										if($slip['approval']=="APPROVED"){ ?>
											<input type="hidden" name="kamama">
											<?php 
										} 


										// kapag nagcheck in na, okay na. there's a cancel button dahil pag may emergency etc.
										$kwr=mysqli_query($conn,"SELECT * FROM checkin_tbl WHERE major_id='$major[major_id]'");
										$p09p=mysqli_num_rows($kwr);
										if($p09p==0){
											if($today==$end_dateminus1){ ?>
												<button class="btn btn-warning btn-block" name="1day" type="submit" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
												<button class="btn btn-block btn-primary" name="check_in" type="submit" formaction="includes/check_in.inc.php">Check in</button>
												<?php
											}
											elseif($today<$end_dateminus1){ ?>
												<button class="btn btn-block btn-danger" name="cansel" type="submit">Cancel Trip</button>
												<?php
											}
										}

									} ?>
								</form>
								<?php
							}



							else{ // if deposit 1 days or more
								if($harp['amount']!=null){ //uploaded cost breakdown ?>
									<form action="includes/deposit_method.inc.php" method="POST"  enctype="multipart/form-data">
										<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
										<?php
										$sq="SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'";
										$sq=mysqli_query($conn,$sq);
										$slip=mysqli_fetch_assoc($sq);
										if($slip['deposit_slip']==null && $slip['reference_num']==null){ //deposit slip not uploaded?>
											<div class="form-group">
												<input type="text" name="referencenum" placeholder="Reference Number" class="form-control">
												<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
											</div>
											<div class="form-group">
												<label for="">Upload Deposit Slip</label>
												<input type="file" name="depositpic" class="form-control" style="padding:3.5px;">
											</div>
											<div class="btn-group d-flex">
												<button class="btn btn-success w-100" name="uplowd" type="submit">Upload Deposit Slip</button>
												<?php 
												if($today==$end_dateminus1){ ?>
													<button class="btn btn-warning btn-block" name="1day" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
													<?php 
												}
												elseif($today<$end_dateminus1){ ?>
													<button class="btn btn-danger w-100" name="cansel" type="submit">Cancel Trip</button>
													<?php
												} ?>
											</div>
											<?php
										}
										else{ //deposit slip uploaded ?>
											<div class="form-group">
												<h3>Payment: <?php if($slip['approval']=="PENDING"){echo 'Received';}elseif($slip['approval']=="APPROVED"){echo 'Approved';}elseif($slip['approval']=="DENIED"){echo 'Denied';} ?></h3>
												<small>
													<?php 
													if($slip['approval']=="APPROVED"){
													    $findDriver=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major[major_id]'");
													    $ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$major[tour_id]'");
														$welz=mysqli_num_rows($ba);
														if($welz>=1){
															$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major[major_id]'"); 
														}
														else{
															$findVehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major[major_id]'"); 
														} ?>
													    <h6>
													        Your driver(s) is/are:
    														<ul>
    															<?php 
    															while($fort=mysqli_fetch_assoc($findDriver)){
    																if($fort['type']=="AUTH_DRIV"){
    																	$findAuth=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$fort[driver_pk]'");
    																	$findAuth_=mysqli_fetch_assoc($findAuth);
    																	echo '<li>'.strtoupper($findAuth_['driver_name']).'</li>';
    																}
    																else{
    																	$findMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$fort[driver_pk]'");
    																	$findMem_=mysqli_fetch_assoc($findMem);
    																	echo '<li>'.strtoupper($findMem_['member_first_name'].' '.$findMem_['member_last_name']).'</li>';
    																}
    															} ?>
    														</ul>
													    </h6>
													    <h6>
													        The van(s) assigned to you is/are:
    														<ul>
    															<?php
    															while($fort=mysqli_fetch_assoc($findVehi)){
    																$vehicle_id=$fort['vehicle_id'];
    																$findVeh=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
    																$findVeh_=mysqli_fetch_assoc($findVeh);
    																echo '<li>'.strtoupper($findVeh_['plate_number']).' ('.$findVeh_['year'].' '.$findVeh_['make'].' '.$findVeh_['model'].')'.'</li>';
    															} ?>
    														</ul>
													    </h6>
														<!-- Here's the receipt: <a href="deposit_receipt.php?major_id=<?php //echo $major['major_id']; ?>&rec_id=<?php //echo $transac['receipt_url'];?>">Click Here</a> -->
														<?php
													} ?>
												</small>
											</div>
											<div class="form-group">
												<input type="text" name="referencenum" placeholder="Reference Number" value="<?php echo $slip['reference_num']; ?>" readonly class="form-control">
												<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
											</div>
											<div class="form-group">
												<div class="card" style="padding:10px;">
													<img src="includes/<?php echo $slip['deposit_slip'];?>" style="width:100%;" alt="">
												</div>
											</div>
											<?php 
											if($slip['approval']=="APPROVED"){ ?>
												<input type="hidden" name="kamama">
												<?php 
											} ?>

											<?php
											$kwr=mysqli_query($conn,"SELECT * FROM checkin_tbl WHERE major_id='$major[major_id]'");
											$p09p=mysqli_num_rows($kwr);
											if($p09p==0){ ?>
												<?php 
												if($today==$end_dateminus1){ ?>
													<button class="btn btn-warning btn-block" name="1day" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
													<button class="btn btn-block btn-primary" name="check_in" type="submit" formaction="includes/check_in.inc.php">Check in</button>
													<?php 
												}
												elseif($today<$end_dateminus1){ ?>
													<?php 
													if($today==$end_dateminus1){ ?>
														<button class="btn btn-warning btn-block" name="1day" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
														<button class="btn btn-block btn-primary" name="check_in" type="submit" formaction="includes/check_in.inc.php">Check in</button>
														<?php 
													}
													elseif($today<$end_dateminus1){ ?>
														<button class="btn btn-block btn-danger" name="cansel" type="submit">Cancel Trip</button>
														<?php
													} ?>
													<?php
												} ?>
												<?php 
											} ?>



											<?php 
										} ?>
									</form>
									<?php
								}
								else{ //not uploaded si cost breakdown na ?>
									<form action="includes/deposit_method.inc.php" method="POST"  enctype="multipart/form-data">
										<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
										<?php 
										$sq="SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'";
										$sq=mysqli_query($conn,$sq);
										$slip=mysqli_fetch_assoc($sq);
										if($slip['deposit_slip']==null && $slip['reference_num']==null){ ?>
											<div class="btn-group d-flex">
												<?php 
												if($today==$end_dateminus1){ ?>
													<button class="btn btn-warning btn-block" name="1day" formaction="includes/cancel_1daybef.inc.php">Cancel Trip</button>
													<?php 
												}
												elseif($today<$end_dateminus1){ ?>
													<button class="btn btn-danger w-100" name="cansel" type="submit">Cancel Trip</button>
													<?php
												} ?>
											</div>
											<?php 
										}
										else{ ?>
											<div class="form-group">
												<h3>Payment: <?php if($slip['approval']=="PENDING"){echo 'Received';}elseif($slip['approval']=="APPROVED"){echo 'Approved';}elseif($slip['approval']=="DENIED"){echo 'Denied';} ?></h3>
												<small>
													<?php if($slip['approval']=="APPROVED"){ ?>
														<!-- Here's the receipt: <a href="deposit_receipt.php?major_id=<?php //echo $major['major_id']; ?>&rec_id=<?php //echo $transac['receipt_url'];?>">Click Here</a> -->
													<?php } ?>
												</small>
											</div>
											<div class="form-group">
												<input type="text" name="referencenum" placeholder="Reference Number" value="<?php echo $slip['reference_num']; ?>" readonly class="form-control">
												<div class="mt-1 mb-1">BTTSC Acct. No: 897-7-89700167-1</div>
											</div>
											<div class="form-group">
												<div class="card" style="padding:10px;">
													<img src="includes/<?php echo $slip['deposit_slip'];?>" style="width:100%;" alt="">
												</div>
											</div>
											<button class="btn btn-block btn-danger" name="cansel" type="submit">Cancel Trip</button>
											<?php
										} ?>
									</form>
									<?php
								}
							}
						} ?>



					</div>
				</div>
			</div>
		</div>
	</main>
<?php
}
require "footer.php"; ?>