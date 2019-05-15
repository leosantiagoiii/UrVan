<?php require "header.php"; ?>

<style>
	.mero{
		box-shadow: 4px 4px 0px -1px rgba(0,0,0,0.75);
		transition: 0.2s;
	}
	.mero:hover{
		transition: 0.3s;
		box-shadow: 7px 7px 0px -1px rgba(0,0,0,0.75);
	}
	@font-face{
		font-family:playfair;
		src:url('fonts/playf.ttf');
	}
	hr.style17 {
		border-top: 1px solid #8c8b8b;
		text-align: center;
	}
	hr.style17:after {
		content: '§';
		display: inline-block;
		position: relative;
		top: -14px;
		padding: 0 10px;
		background: white;
		color: #8c8b8b;
		font-size: 18px;
		-webkit-transform: rotate(60deg);
		-moz-transform: rotate(60deg);
		transform: rotate(60deg);
	}
	.meio > a{
		color:black;
		font-family: gravity;
		font-size:14px;
	}
</style>

<main>
	
	<div>
		
		<!--
		<div class="video-container">
				<video autoplay loop muted>
					<source src="images/ad.mp4" type="video/mp4">
					Your browser does not support the video tag.
				</video>
		    <div class="overlay-desc">
		       	<img src="images/logo3.png" style="opacity:0.8;width:20%;" alt="">
				<h1>We're the solution for your travel needs</h1>
		    </div>
		</div>
		-->

		<div class="headI">
			<div class="headI2">
				<img src="images/bwLogo.png">
				<h1>Ready for <span style="color:#5383d3;">Pick</span><span style="color:#ed3237;">up!</span></h1>
			</div>
		</div>

		<?php
		if( isset($_SESSION['clientid']) ){ 
			$theSql=mysqli_query($conn,"SELECT client_id, tour_id, count(tour_id) as `occuri` FROM booking_majordetails WHERE client_id='$_SESSION[clientid]' GROUP BY tour_id ORDER BY `occuri` DESC LIMIT 3");
			$dump=mysqli_fetch_assoc($theSql);

			if($dump['occuri']<=2){}
			elseif($dump['occuri']>=3){ ?>
				<div class="container-fluid" style="padding:20px;background-color:;margin-top:20px;">
					<div class="container-fluid">
						<div>
							<h1 style="font-family: playfair;" class="text-center">You've been travelling a lot these days!</h1>
							<h1 style="font-family: monsreg;font-size:20px;" class="text-center">We'd like to suggest a few places you might wanna visit</h1>
						</div>
						<div class="row">
							<?php 
							$theSql=mysqli_query($conn,"SELECT client_id, tour_id, count(tour_id) as `occuri` FROM booking_majordetails WHERE client_id='$_SESSION[clientid]' GROUP BY tour_id ORDER BY `occuri` DESC LIMIT 3");
							$meteri=mysqli_num_rows($theSql);
							if($meteri>=3){
								while($notDump=mysqli_fetch_assoc($theSql)){ ?>
									<div style="margin-top:20px;" class="col-lg-4 mb-4">
										<center>	
											<div class="mero" style="padding:40px;border-width: 1px;border-style: solid;">
												<?php 
												$tour_id = $notDump['tour_id'];
												$tour_select=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
												$getTour=mysqli_fetch_assoc($tour_select);
												$tour_name=$getTour['tour_name'];
												$url='https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.urlencode($tour_name).'&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,place_id,geometry&types=city&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
												$getJson=file_get_contents($url);
												$json2PHP=json_decode($getJson, true);
												$photo = $json2PHP['candidates'][0]['photos'][0]['photo_reference'];
												$url2='https://maps.googleapis.com/maps/api/place/photo?maxwidth=850&photoreference='.$photo.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
												// echo count($json2PHP['candidates']);
												// echo "<div style='text-align:left;'><pre>";
												// print_r($json2PHP);
												// echo "</pre></div>"; 
												?>	
												<div style="width:100%" class="mb-4">
													<img src="<?php echo $url2; ?>" style="border-style:solid;border-width:1px;width:100%;object-fit:cover;height:250px;">
												</div>
												<h3 style="margin:0;font-family:gravity;font-size:25px;font-weight:bolder;">
													<?php
													echo $tour_name; ?>
												</h3>
												<div class="mt-2 meio">
													<?php
													$place_id = $json2PHP['candidates'][0]['place_id']; ?>
													<a target="_blank" href="suggested.php?kashsjdgsfmgfkdsbfhjdgdfsj67hgfshgdsd&place_id=<?php echo $place_id;?>">Learn more →</a>
												</div>
											</div>
										</center>
									</div>
									<?php
								}
							}
							else{
								$notDump=mysqli_fetch_assoc($theSql); ?>
									<div style="margin-top:20px;" class="col-lg-4 mb-4">
										<center>
											<div class="mero" style="padding:40px;border-width: 1px;border-style: solid;">
												<div style="width:100%" class="mb-4">
													<img src="http://urvan.webstarterz.com/images/bwLogo.png" style="border-style:solid;border-width:1px;width:100%;padding:70px 20px;object-fit:;height:250px;background-color:black;">
												</div>
												<h3 style="margin:0;font-family:gravity;font-size:25px;font-weight:bolder;">Not enough data</h3>
												<div class="mt-2 meio">
													<a>Come back later when you've had more trips</a>
												</div>
											</div>
										</center>
									</div>
									<div style="margin-top:20px;" class="col-lg-4 mb-4">
										<center>	
											<div class="mero" style="padding:40px;border-width: 1px;border-style: solid;">
												<?php 
												$tour_id = $notDump['tour_id'];
												$tour_select=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
												$getTour=mysqli_fetch_assoc($tour_select);
												$tour_name=$getTour['tour_name'];
												$url='https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.urlencode($tour_name).'&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,place_id,geometry&types=city&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
												$getJson=file_get_contents($url);
												$json2PHP=json_decode($getJson, true);
												$photo = $json2PHP['candidates'][0]['photos'][0]['photo_reference'];
												$url2='https://maps.googleapis.com/maps/api/place/photo?maxwidth=850&photoreference='.$photo.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
												// echo count($json2PHP['candidates']);
												// echo "<div style='text-align:left;'><pre>";
												// print_r($json2PHP);
												// echo "</pre></div>"; 
												?>	
												<div style="width:100%" class="mb-4">
													<img src="<?php echo $url2; ?>" style="border-style:solid;border-width:1px;width:100%;object-fit:cover;height:250px;">
												</div>
												<h3 style="margin:0;font-family:gravity;font-size:25px;font-weight:bolder;">
													<?php
													echo $tour_name; ?>
												</h3>
												<div class="mt-2 meio">
													<?php
													$place_id = $json2PHP['candidates'][0]['place_id']; ?>
													<a target="_blank" href="suggested.php?kashsjdgsfmgfkdsbfhjdgdfsj67hgfshgdsd&place_id=<?php echo $place_id;?>">Learn more →</a>
												</div>
											</div>
										</center>
									</div>
									<div style="margin-top:20px;" class="col-lg-4 mb-4">
										<center>
											<div class="mero" style="padding:40px;border-width: 1px;border-style: solid;">
												<div style="width:100%" class="mb-4">
													<img src="http://urvan.webstarterz.com/images/bwLogo.png" style="border-style:solid;border-width:1px;width:100%;padding:70px 20px;object-fit:;height:250px;background-color:black;">
												</div>
												<h3 style="margin:0;font-family:gravity;font-size:25px;font-weight:bolder;">Not enough data</h3>
												<div class="mt-2 meio">
													<a>Come back later when you've had more trips</a>
												</div>
											</div>
										</center>
									</div>
								<?php
							} ?>
						</div>
						<div class="mt-3"></div>
					</div>
				</div>
				<div class="container-fluid">
					<hr class="style17">
				</div>
				<?php
			}
		} ?>

		<div class="below-video-content-1">
			<div>
				<div class="grid-2">
					<div style="text-align:right;">
						<br><br><br>
						<h1 class="text-01">Who We Are</h1>
						<a href="about.php" class="linkhome">Learn more →</a>
					</div>
					<div class="in-p">
						<img class="index-grid-photos"  src="images/nonono.png" alt="">
					</div>
					<div class="in-p">
						<img class="index-grid-photos" src="images/index-2.png" alt="">
					</div>
					<div style="text-align:left;">
						<br><br><br>
						<h1 class="text-01">Luzon Coverage</h1>
						<a href="tours.php" class="linkhome">← Learn more</a>
					</div>
				</div>
			</div>
		</div>

		<div class="below-video-content-3">
			<h1>We are committed</h1>
			<p class="e-e">We at BTTSC provide the best of the best. From personal getaways, to family trips; even official business excursions.<br>We're looking forward to work with you</p>
			<a href="about.php" class="btn btn-primary">View More</a>
		</div>
		
	</div>

</main>

<?php require "footer.php"; ?>