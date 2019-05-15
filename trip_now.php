<?php
if(isset($_GET['trip_today'])){

	session_start();

	require "includes/dbconnect.inc.php";

	$mari=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id='$_SESSION[clientid]' AND completion='NO' ORDER BY created_at ASC LIMIT 1");
	$mai=mysqli_num_rows($mari);

	if($mai<=0){
		header("Location:client_past_trips.php");
		exit();
	}


	require "header.php";

	$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id=$_SESSION[clientid] AND completion='NO' ORDER BY created_at ASC LIMIT 1");
	$row=mysqli_fetch_assoc($sql);
	$major_id=$row['major_id'];
	$duration=$_GET['duration'];
	$sql2=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id' AND (departure_dt IS NULL OR arrival_dt IS NULL) ORDER BY created_at ASC LIMIT 1");
	$count=mysqli_num_rows($sql2);
	if($count>=1){ ?>
		<main style="margin-top:50px;margin-bottom:50px;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<?php 
						while($getI=mysqli_fetch_assoc($sql2)){
							$dateTime_now=DATE("Y-m-d H:i:s");
							$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$getI['orig_place_id']."&destination=place_id:".$getI['des_place_id']."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
							$getJson=file_get_contents($url);
							$json2PHP=json_decode($getJson, true); ?>
							<div class="alert alert-warning" style="padding:20px;">
								<h3 class="text-center mb-1" style="font-family:raleway;padding:0;margin:0;font-size:20px;">Currently:</h3>
								<h1 class="text-center" style="font-family:raleway;padding:0;margin:0;font-size:27px;">
									<?php
									echo $getI['origin'].' → '.$getI['destination']; ?>
								</h1>
							</div>
							<?php 
							if($getI['departure_dt']!=null AND $getI['arrival_dt']==null){ ?>
								<div class="mt-2 card" style="padding:20px;">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<h6 style="margin:0;padding:0;font-family:robotoreg;">
												We left on: 
											</h6>
											<h4 style="margin:0;padding:0;font-family:robotoblack;">
												<?php
												$timeb4 = $getI['departure_dt'];
												$timeb4 = strtotime($timeb4);
												echo DATE("Y M d | h:i A",$timeb4); ?>
											</h4>
										</div>
										<div class="col-lg-6" style="text-align:right;">
											<h6 style="margin:0;padding:0;font-family:robotoreg;">
													We should arrive by: 
											</h6>
											<h4 style="margin:0;padding:0;font-family:robotoblack;">
												<?php
												$additionalA = $json2PHP['routes'][0]['legs'][0]['duration']['value'];
												$additionalB = strtotime($getI['departure_dt']);
												echo DATE("Y M d | h:i A", $additionalA + $additionalB); ?>
											</h4>
										</div>
									</div>
								</div>
								<div class="mt-2 card">
									<?php 
									$url_img='https://maps.googleapis.com/maps/api/staticmap?size=1500x300&path=enc:'.$json2PHP['routes'][0]['overview_polyline']['points'].'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $url_img;?>" style="width:100%;padding:5px;border-radius:3%">
								</div>
								<?php
							}
							elseif($getI['departure_dt']==null AND $getI['arrival_dt']==null){ ?>
								<div class="mt-2 card" style="padding:20px;">
									<div class="row">
										<div class="col-lg-6 mb-2">
											<h6 style="margin:0;padding:0;font-family:robotoreg;">
												Current Time: 
											</h6>
											<h4 style="margin:0;padding:0;font-family:robotoblack;">
												<?php
												$timeb4 = DATE("Y-m-d H:i:s");
												$timeb4 = strtotime($timeb4);
												echo DATE("Y M d | h:i A",$timeb4); ?>
											</h4>
										</div>
										<div class="col-lg-6" style="text-align:right;">
											<h6 style="margin:0;padding:0;font-family:robotoreg;">
													If we left <?php echo $getI['origin'].', we\'d arrive by'; ?>: 
											</h6>
											<h4 style="margin:0;padding:0;font-family:robotoblack;">
												<?php
												$additionalA = $json2PHP['routes'][0]['legs'][0]['duration']['value'];
												echo DATE("Y M d | h:i A", $additionalA + $timeb4); ?>
											</h4>
										</div>
									</div>
								</div>
								<?php
							} ?>
							<?php
						} ?>
					</div>
					<div class="col-lg-1"></div>
				</div>
			</div>
		</main>
		<?php 
	}
	else{
		$sql3=mysqli_query($conn,"SELECT * FROM booking_optimize_tbl WHERE major_id='$major_id'");
		$rem=mysqli_fetch_assoc($sql3);
		if(isset($rem['comm_id'])){ ?>
			<main style="margin-top:50px;margin-bottom:50px;">
				<div class="container">
					<div class="row">
						<div class="col-lg-2"></div>
						<div class="col-lg-8">
							<div class="card text-center" style="padding:20px;">
								<h2 style="font-family:raleway;margin:0">Yay! Your Trip (<?php echo $major_id;?>) is almost done. Await for the driver's confirmation</h2>
								<hr>
								<p style="margin:0;font-family:monsreg;">How was your trip? Tell us all about it via the email sent to you by our lovely driver(s).<br><br>We do hope you answer it! Thanks for being a part of BTTSC! We hope to see you again!</p>
							</div>
						</div>
						<div class="col-lg-2"></div>
					</div>
				</div>
			</main>
			<?php
		}
		elseif(!isset($rem['comm_id'])){ ?>
			<main style="margin-top:50px;margin-bottom:50px;">
				
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-8">
						<div class="card text-center" style="padding:20px">
							<h2 style="font-family:raleway;margin:0">Today's the day! Please wait for your driver or go to the meeting place. (<?php echo $major_id;?>)</h2>
							<hr>
							<p style="margin:0;font-family:monsreg;">Refresh the page if you wish to see the progress</p>
						</div>
					</div>
					<div class="col-lg-2"></div>
				</div>
			</main>
			<?php
		}
	} ?>

	<?php
	require "footer.php"; 
}
else{
	echo "<h1>Forbidden</h1>";
}
?>