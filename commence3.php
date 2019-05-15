<?php
if(isset($_GET['major_id'])){
	$major_id=$_GET['major_id'];
	require "header.php"; ?>

	<style>
		#mierde{
			color:black;
			transition: 0.5s;
		}
		#mierde:hover{
			color:white;
			background-color:#c5303e;
			border-color: #c5303e;
			transition: 0.5s;
			box-shadow: 5px 5px 0px 0px black;
		}
	</style>

	<main style="margin-top:50px;margin-bottom:50px;">
		<div class="container">

			<?php
			$getItinerary=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' AND (departure_dt IS NULL OR arrival_dt IS NULL) ORDER BY created_at ASC LIMIT 1");
			$count=mysqli_num_rows($getItinerary);
			if($count>=1){ //if there are still places left
				while($getI=mysqli_fetch_assoc($getItinerary)){ ?>
					<!-- SHOWING THE RESULTS FOR THE TRIPS! H3H3 -->
					<div class="alert alert-success" style="padding:20px;">
						<h1 class="text-center" style="font-family:raleway;padding:0;margin:0;font-size:27px;">
							<?php
							echo $getI['origin'].' → '.$getI['destination']; ?>
						</h1>
					</div>
					<form action="" method="get">
						<div class="card" style="padding:30px;font-family:monsreg;font-size:15px;font-weight:lighter;letter-spacing:-0.5px;">
							<?php
							$date_now = DATE("Y-m-d");
							$time_now = DATE("H:i:s");
							$dateTime_now = $date_now.' '.$time_now;
							$dateTime_now=DATE("Y-m-d H:i:s"); ?>
							<center>
								<div class="text-center alert alert-secondary" style="padding:10px;width:100%;">
									<h6 style="padding:0;margin:0;font-weight:bolder;">
										It is currently:
									</h6>
									<h4 style="padding:0;margin:0;font-weight:bolder;">
										<?php
										$date_1 = strtotime($date_now);
										echo strtoupper(DATE("Y M d",$date_1));
										echo '<br>';
										$time_1 = strtotime($time_now);
										echo strtoupper(DATE("h:i A",$time_1));

										$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$getI['orig_place_id']."&destination=place_id:".$getI['des_place_id']."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
										$getJson=file_get_contents($url);
										$json2PHP=json_decode($getJson, true); ?>
									</h4>
								</div>
							</center>
							<div class="" style="margin-top:10px">
								<div class="row">
									<div class="col-lg-8">
										<?php 
										if($getI['departure_dt']!=null AND $getI['arrival_dt']==null){ // dep is not null waiting response
											$additionalA = $json2PHP['routes'][0]['legs'][0]['duration']['value'];
											$additionalB = strtotime($getI['departure_dt']);
											$expDate =  DATE("Y M d | h:i A", $additionalA + $additionalB); ?>
											<div class="alert alert-primary mb-3">
												<div class="row">
													<div class="col-lg-6">
														<b style="font-weight: bolder;">Expected Time of Arrival: </b>
														<h4 style="margin:0;"><?php echo $expDate; ?></h4>
													</div>
													<div class="col-lg-6" style="text-align: right;">
														<b style="font-weight: bolder;">Mileage: </b>
														<h4 style="margin:0;"><?php echo $getI['mileage'].' km'; ?></h4>
													</div>
												</div>
											</div>
											<?php
											$url_img='https://maps.googleapis.com/maps/api/staticmap?size=1500x700&path=enc:'.$json2PHP['routes'][0]['overview_polyline']['points'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
											<div class="card mb-3">
												<img src="<?php echo $url_img;?>" style="width:100%;padding:5px;border-radius:3%">
											</div>
											<div class="mb-3" style="width:100%;">
												<input type="hidden" name="dateTimeArrival" value="<?php echo $dateTime_now; ?>">
												<button class="btn btn-success btn-block" name="arrival_btn" formaction="includes/arrdep.inc.php">We're in <?php echo $getI['destination'];?>!</button>
											</div>
											<?php 
										}
										elseif($getI['departure_dt']==null AND $getI['arrival_dt']==null){ // both arr and dep null
											$additionalA = $json2PHP['routes'][0]['legs'][0]['duration']['value'];
											$additionalB = strtotime($dateTime_now);
											$expDate =  DATE("Y M d | h:i A", $additionalA + $additionalB); ?>
											<div class="alert alert-primary mb-3">
												<div class="row">
													<div class="col-lg-6">
														<b style="font-weight: bolder;">Expected Time of Arrival: </b>
														<h4 style="margin:0;"><?php echo $expDate; ?></h4>
													</div>
													<div class="col-lg-6" style="text-align: right;">
														<b style="font-weight: bolder;">Mileage: </b>
														<h4 style="margin:0;"><?php echo $getI['mileage'].' km'; ?></h4>
													</div>
												</div>
											</div>
											<?php
											$url_img='https://maps.googleapis.com/maps/api/staticmap?size=1500x700&path=enc:'.$json2PHP['routes'][0]['overview_polyline']['points'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
											<div class="card mb-3">
												<img src="<?php echo $url_img;?>" style="width:100%;padding:5px;border-radius:3%">
											</div>
											<div class="mb-3" style="width:100%;">
												<input type="hidden" name="dateTimeDepar" value="<?php echo $dateTime_now; ?>">
												<button class="btn btn-primary btn-block" name="departure_btn" formaction="includes/arrdep.inc.php">Start <?php echo '<u>'.$getI['origin'].' to '.$getI['destination'].'</u>';?> trip</button>
											</div>
											<?php
										} ?>
									</div>
									<div class="col-lg-4">
										<?php 
										$len = count($json2PHP['routes'][0]['legs'][0]['steps']);
										// echo "<pre>";
										// print_r($json2PHP);
										// echo "</pre>";
										for($i=0;$i<$len;$i++){
											echo $i+1;
											echo ". ";
											echo $json2PHP['routes'][0]['legs'][0]['steps'][$i]['html_instructions'].'<br>';
										} ?>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="major_id" value="<?php echo $major_id;?>">
						<input type="hidden" name="comm_id" value="<?php echo $getI['comm_id'];?>">
					</form>
					<!-- SHOWING THE RESULTS FOR THE TRIPS! H3H3 -->
					<?php
				}
			}
			elseif($count<=0){ //if there are no places left! ?>
				<form action="" method="get">
					<div class="card" style="border-style:solid;border-width:1px; padding:50px;">
						<h2 style="margin:0;padding:0;font-family:monsbold" class="text-center">Trip finished?</h2>
						<hr>
						<center style="">
							<a href="includes/finish_trip.inc.php?finished_trip&major_id=<?php echo $major_id; ?>&driver_pk=<?php echo $_SESSION['driverid'];?>&type=<?php echo $_SESSION['type']; ?>" style="text-decoration:none;">
								<!-- after this pede na gawing null si trip then meron ding history of what happened  -->
								<div id="mierde" style="padding:10px;border-style:solid;white-space:nowrap;width:25%;border-width:1px;">Yes</div>
							</a>
						<center>
					</div>
				</form>
				<?php
			} ?>

		</div>
	</main>

	<?php
	require "footer.php";
}
?>