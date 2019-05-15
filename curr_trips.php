<?php session_start();

require "includes/dbconnect.inc.php";

if(isset($_SESSION["driverid"])){
      $meli=mysqli_query($conn,"SELECT * FROM driver_queue WHERE driver_pk='$_SESSION[driverid]' AND status IS NOT NULL AND acceptance='accepted'");
      $merde=mysqli_fetch_assoc($meli);
      $isThe=mysqli_num_rows($meli);
      $mejor=$merde['status'];

      $mel=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$mejor'");
      $exists=mysqli_num_rows($mel);
      if($exists>=1 AND $isThe>=1 AND $merde['vehicle_id']!=null){
			header("Location: commence3.php?major_id=$mejor");
            exit();
      }
}

require "header.php";

$getMajorID=mysqli_query($conn,"SELECT * FROM driver_queue WHERE driver_pk='$_SESSION[driverid]'");
$getMajorID_=mysqli_fetch_assoc($getMajorID);
$major_id=$getMajorID_['status'];

$date_today1=DATE("Y-m-d");
$date_today=strtotime($date_today1); ?>
<style>
	label{
		font-weight: bolder;
	}
</style>
<main>
	<div class="container-fluid">
		<?php
		$sql=mysqli_query($conn,"SELECT *,COUNT(driver_pk) AS countDriv FROM driver_queue WHERE driver_pk='$_SESSION[driverid]' AND status IS NOT NULL");
		$result=mysqli_fetch_assoc($sql);
		if($result['countDriv']<=0){ ?>
			<div class="container">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<center>
							<div class="card" style="padding:40px;margin:120px 0;">
								<h1 style="font-family:monsbold;margin:0;text-align:right;">Apologies, but we don't have any trips available for you at the moment.</h1>
								<p style="text-align:left;font-family:robotoreg;margin:0"><br>You can check your past trips <a href="list_trips.php">here</a>, though</p>
							</div>
						</center>
					</div>
					<div class="col-lg-1"></div>
				</div>
			</div>
			<?php
		}
		else{ ?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<center>
							<div class="card mb-3" style="padding:40px;margin-top:50px;">
								<div style="font-family:robotoreg;font-size:20px;">You have a trip!</div>
								<h1 style="font-family:raleway;"><u><?php echo $major_id; ?></u></h1>
							</div>
						</center>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<?php
							$getMajorBook=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
							$start_date1=$getMajorID_['start_date'];
							$start_date=strtotime($start_date1);
							if($result['acceptance']=="accepted" AND ($date_today>=$start_date)){ //when trip is TODAY ?>
								<div class="col-lg-12">
									<?php
									$getMajorD=mysqli_fetch_assoc($getMajorBook);
									$duration=$getMajorD['duration'];
									$clientid=$getMajorD['client_id'];
									$get=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$clientid'");
									$getcli=mysqli_fetch_assoc($get);
									$name=$getcli['client_first_name'].' '.$getcli['client_last_name'];
									$startDate=$getMajorD['start_date'];
									$endDate=$getMajorD['end_date'];
									$reportingTime=$getMajorD['reporting_time'];
									$optimise=$getMajorD['optimise']; ?>
									<div class='alert alert-secondary mt-2 mb-3' style='font-family:robotoreg'>
										<?php
										echo "<b>Date:</b> " . DATE("Y M d")."<br>";
										echo "<b>Time:</b> " . DATE("H:i:s")."<br>"; ?>
									</div>
									<form style="font-family:robotoreg;font-weight:bolder;" action="includes/commence1.inc.php" method="get">
										<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
										<div class="btn-group mb-5">
											<button class="btn btn-primary w-100" name="proceed">
											Start The Trip
											</button>
											<button class="btn btn-danger w-100" name="flaked">
											<?php echo $name." Didn't Show Up :("; ?>
											</button>
										</div>
									</form>
								</div>
								<?php 
							}
							else{ //today NOT trip
								while($getMajorBook_=mysqli_fetch_assoc($getMajorBook)){ ?>
									<div class="col-lg-4">
										<label for="">To: </label>
										Tour #<?php echo $tour_id = $getMajorBook_['tour_id']; ?>
										<br>
										<label for="">Name of Client: </label>
										Client #<?php echo $getMajorBook_['client_id']; ?>
										<br>
										<?php
										if($getMajorBook_['start_date']==$getMajorBook_['end_date']){ ?>
											<label for="">Date: </label>
											<?php 
											$c = strtotime($getMajorBook_['start_date']);
											echo DATE("Y M d", $c); ?>
											<br>
											<?php
										}
										else{ ?>
											<label for="">Start Date: </label>
											<?php 
											$a=strtotime($getMajorBook_['start_date']);
											echo DATE("Y M d",$a); ?>
											<br>
											<label for="">End Date: </label>
											<?php 
											$b=strtotime($getMajorBook_['start_date']);
											echo DATE("Y M d",$b); ?>
											<br>
											<?php
										} ?>
										<label for="">Duration: </label>
										<?php echo $getMajorBook_['duration']+1; ?> day(s)
									</div>
									<div class="col-lg-4">
										<label for="">Pax: </label>
										<?php echo $getMajorBook_['pax']; ?> persons
										<br>
										<label for="">Reporting Place: </label>
										<?php echo $getMajorBook_['reporting_place']; ?>
										<br>
										<label for="">Reporting Time: </label>
										<?php echo $getMajorBook_['reporting_time']; ?>
										<br>
										<label for="">Contact Person: </label>
										<?php echo $getMajorBook_['contact_person']; ?>
										<br>
									</div>
									<div class="col-lg-4">
										<label for="">Contact Number: </label>
										<?php echo $getMajorBook_['contact_persons_number']; ?>
										<br>
										<?php
										$mei=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
										$ccc=mysqli_num_rows($mei);
										if($ccc>=1){
											$getVehicleID=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major_id'");
										}
										else{
											$getVehicleID=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major_id'");
										}
										while($getVehicleID_=mysqli_fetch_assoc($getVehicleID)){
											$vehicle_id=$getVehicleID_['vehicle_id'];
											$getVehicleDetails=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
											while($getVehicleDetails_=mysqli_fetch_assoc($getVehicleDetails)){ ?>
												<label for="">Vehicle: </label>
												<?php echo $vehicle_name=$getVehicleDetails_['year'].' '.$getVehicleDetails_['make'].' '.$getVehicleDetails_['model']; ?>
												<br>
												<label for="">Plate Number: </label>
												<?php echo $vehicle_plate_num=$getVehicleDetails_['plate_number']; ?>
												<br>
												<?php 
											}
										} ?>
									</div>
									<br>
									<div class="col-lg-12 mt-3">
										<h1 style="font-family:raleway;font-size:28px;">Itinerary:</h1>
										<?php
										if($getMajorBook_['optimise']==null){ //not api
											$i=0;
											$getItin=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major_id'");
											echo "<ol>";
											while($getItin_=mysqli_fetch_assoc($getItin)){
												$i++; ?>
												<li>
													<?php
													echo $getItin_['orig_place'].' - '.$getItin_['des_place'].' ('.$getItin_['duration'].')'; ?>
												</li>
												<?php 
											}
											echo "</ol>";
											$sumMile=mysqli_query($conn,"SELECT SUM(mileage) as mileSum FROM booking_arr_dep WHERE major_id='$major_id'");
											$sumMile_=mysqli_fetch_assoc($sumMile); ?>
											<h1 style="font-family:raleway;font-size:28px;">Mileage: </h1>
											<ul>
												<li><?php echo $sumMile_['mileSum'];?> km</li>
											</ul>
											<?php
											if($getMajorID_['acceptance']=="refused"){ ?>
												<div class="alert alert-warning mb-5" role="alert">
													<h4 style="margin:0; font-family:raleway;font-size:23px;" class="alert-heading">You have declined this trip</h4>
													<hr>
													<p style="margin:0">Await for admin confirmation</p>
												</div>
												<?php
											}
											elseif($getMajorID_['acceptance']=="accepted"){ ?>
												<div class="alert alert-primary mb-5" role="alert">
													<h4 style="margin:0; font-family:raleway;font-size:23px;" class="alert-heading">You have accepted this trip</h4>
													<hr>
													<p style="margin:0">Return by: <?php echo DATE("Y M d",strtotime($getMajorBook_['start_date']))." on ".$getMajorBook_['reporting_time']; ?></p>
												</div>
												<?php
											}
											else{ ?>
												<form action="includes/fcfs_driver.inc.php" method="get">
													<input type="hidden" name="driver_pk" value="<?php echo $_SESSION['driverid'];?>">
													<div class="btn-group mb-5">
														<button class="btn btn-primary" name="tripAccept">Accept</button>
														<button class="btn btn-danger" name="tripDecline">Decline</button>
													</div>
												</form>
												<?php
											}
										}
										else{ //for the optimised
											$first_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
											$first=mysqli_fetch_assoc($first_q);
											$start_lng=$first['orig_lat'];
											$start_lat=$first['orig_lng'];
											$start_lt_ln=$start_lng.','.$start_lat;
											$start_place_id=$first['orig_place_id'];//

											$second_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id > (SELECT MIN(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC");
											while($waypoints=mysqli_fetch_assoc($second_q)){
												$waypoint_lng=$waypoints['orig_lat'];
												$waypoint_lat=$waypoints['orig_lng'];
												$waypoint_lt_ln=$waypoint_lng.','.$waypoint_lat;
												$wp_array[]="via:".$waypoint_lt_ln;
											}

											$doop=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
											while($rub=mysqli_fetch_assoc($doop)){
												$latt=$rub['longitude'];
												$lonn=$rub['latitude'];
												$coords=$latt.','.$lonn;
												$coord_arr[]=$coords;
												$coor_place_id[]="place_id:".$rub['place_id'];
												$coords_place_id=$rub['place_id'];//
												$coord_arr_place_id[]="place_id:".$coords_place_id;//
											}

											$last_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
											$last=mysqli_fetch_assoc($last_q);
											$last_lng=$last['orig_lat'];
											$last_lat=$last['orig_lng'];
											$last_lt_ln=$last_lng.','.$last_lat;
											$last_place_id=$last['des_place_id'];// 

											$implode_wp_place_id=implode("|",$coord_arr_place_id);
											$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$start_place_id."&destination=place_id:".$start_place_id."&waypoints=optimize:true|".$implode_wp_place_id."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";

											$getJson=file_get_contents($url);
											$json2PHP=json_decode($getJson, true);
											$len=count($json2PHP['routes'][0]['legs']);

											echo "<ol>";
											for($i=0;$i<$len;$i++){ ?>
												<li>
													<?php
													$place_idA = $json2PHP['geocoded_waypoints'][$i]['place_id'];
													$urlA='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idA.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
													$getJsonA=file_get_contents($urlA);
													$json2PHPA=json_decode($getJsonA, true);
													echo $json2PHPA['result']['name'];
													$lenComp1=count($json2PHPA['result']['address_components']);
													for($l=1;$l<$lenComp1;$l++){
														echo ', '.$json2PHPA['result']['address_components'][$l]['short_name'];
													}
													echo " → ";
													$k=$i+1;
													$place_idB = $json2PHP['geocoded_waypoints'][$k]['place_id'];
													$urlB='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idB.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
													$getJsonB=file_get_contents($urlB);
													$json2PHPB=json_decode($getJsonB, true);
													echo $json2PHPB['result']['name'];
													$lenComp2=count($json2PHPB['result']['address_components']);
													for($m=1;$m<$lenComp2;$m++){
														echo ', '.$json2PHPB['result']['address_components'][$m]['short_name'];
													}

													echo ' '.' ('.$json2PHP['routes'][0]['legs'][$i]['distance']['text'].' - '.$json2PHP['routes'][0]['legs'][$i]['duration']['text'].')'; ?>
												</li>
												<?php
											}
											echo "</ol>";
											if($getMajorID_['acceptance']=="refused"){ ?>
												<div class="alert alert-primary mb-5" role="alert">
													<h4 style="margin:0; font-family:raleway;font-size:23px;" class="alert-heading">You have declined this trip</h4>
													<hr>
													<p style="margin:0">Await for the admin's confirmation</p>
												</div>
												<?php
											}
											elseif($getMajorID_['acceptance']=="accepted"){ ?>
												<div class="alert alert-primary mb-5" role="alert">
													<h4 style="margin:0; font-family:raleway;font-size:23px;" class="alert-heading">You have accepted this trip</h4>
													<hr>
													<p style="margin:0">Return by: <?php echo DATE("Y M d",strtotime($getMajorBook_['start_date']))." on ".$getMajorBook_['reporting_time']; ?></p>
												</div>
												<?php
											}
											else{ ?>
												<form action="includes/fcfs_driver.inc.php" method="get">
													<input type="hidden" name="driver_pk" value="<?php echo $_SESSION['driverid'];?>">
													<div class="btn-group mb-5">
														<button class="btn btn-primary" name="tripAccept">Accept</button>
														<button class="btn btn-danger" name="tripDecline">Decline</button>
													</div>
												</form>
												<?php
											}
										} ?>
									</div>
									<?php
								}
							} ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		} ?>
	</div>
</main>
<?php 
require "footer.php"; ?>