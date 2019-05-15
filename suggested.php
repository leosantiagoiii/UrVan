<?php
if(!isset($_GET['kashsjdgsfmgfkdsbfhjdgdfsj67hgfshgdsd'])){
	header("Location:index.php?entry=error");
	exit();
}
else{
	require "header.php";
	$place_id=$_GET['place_id'];
	$url='https://maps.googleapis.com/maps/api/place/details/json?placeid='.$place_id.'&fields=name,geometry,formatted_address&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
	$getJson=file_get_contents($url);
	$json2PHP=json_decode($getJson, true);
	$formatted_address = $json2PHP['result']['formatted_address'];
	$lat=$json2PHP['result']['geometry']['location']['lat'];
	$lng=$json2PHP['result']['geometry']['location']['lng'];
	$latLng=$lat.','.$lng;
	// echo "<div style='text-align:left;'><pre>";
	// print_r($json2PHP);
	// echo "</pre></div>"; 
	// $url2='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=amusement_park';
	$url2='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=amusement_park';
	$getJson2=file_get_contents($url2);
	$json2PHP2=json_decode($getJson2, true);

	$url3='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=zoo';
		$getJson3=file_get_contents($url3);
	$json2PHP3=json_decode($getJson3, true);


	$url4='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=stadium';
		$getJson4=file_get_contents($url4);
	$json2PHP4=json_decode($getJson4, true);


	$url5='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=shopping_mall';
		$getJson5=file_get_contents($url5);
	$json2PHP5=json_decode($getJson5, true);


	$url6='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&types=lodging';
		$getJson6=file_get_contents($url6);
	$json2PHP6=json_decode($getJson6, true);


	$url7='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=natural_feature';
		$getJson7=file_get_contents($url7);
	$json2PHP7=json_decode($getJson7, true);


	$url8='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=airport';
		$getJson8=file_get_contents($url8);
	$json2PHP8=json_decode($getJson8, true);


	$url9='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=art_gallery';
		$getJson9=file_get_contents($url9);
	$json2PHP9=json_decode($getJson9, true);


	$url10='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=church';
		$getJson10=file_get_contents($url10);
	$json2PHP10=json_decode($getJson10, true);


	$url11='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=mosque';
		$getJson11=file_get_contents($url11);
	$json2PHP11=json_decode($getJson11, true);


	$url12='https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$latLng.'&radius=40000&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&types=campground';
		$getJson12=file_get_contents($url12);
	$json2PHP12=json_decode($getJson12, true);


	// echo "<div style='text-align:left;width:100%;overflow-y:scroll'><pre>";
	// print_r($json2PHP2);
	// echo "</pre></div>"; ?>

	<style>
		.grid-gallery{
			display: grid;
			grid-template-columns: repeat(auto-fill,minmax(250px,auto));
			grid-auto-rows: minmax(250px, auto);
			grid-gap:1rem;
		}
		@supports(display:grid){
			.grid-gallery-item{
				padding:15px;
				height:auto;
				margin:0;
				max-width: none;
				border-style: solid;
				border-width: 1px;
			}
			.grid-gallery-item:nth-child(odd){
			}
			.grid-gallery-item > img{
				/*bottom:100px;
				position:relative;*/
				margin-bottom:10px;
			}
			.grid-gallery-item > h1{
				height:47px;
				font-family:roboto;
			}
		}
	</style>

	<div class="container mb-5 mt-5">
		<div>
			<h1 class="text-center mb-4" style="font-family:raleway"><?php echo $formatted_address; ?></h1>
			<div>
				<?php 
				$my = "hllo";
				if( $json2PHP2['status']!="OK" AND $json2PHP3['status']!="OK" AND $json2PHP4['status']!="OK" AND $json2PHP5['status']!="OK" AND $json2PHP6['status']!="OK" AND $json2PHP7['status']!="OK" AND $json2PHP8['status']!="OK" AND $json2PHP9['status']!="OK" AND $json2PHP10['status']!="OK" AND $json2PHP11['status']!="OK" AND $json2PHP12['status']!="OK" ){ ?>
						<div class="row">
							<div class="col-lg-2"></div>
							<div class="col-lg-8">
								<center>
									<div style="text-align:left;padding:20px;">
										<div style="border-style:solid;border-width:1px; padding:50px;box-shadow: 10px 10px 0px 0px rgba(64,64,64,1);">
											<h2 style="margin:0;font-family:gravity" class="text-center mb-3">
												Well... this is absolutely embarrassing
											</h2>
											<div style="font-family:robotoreg;text-align:left;" class="mb-2">
												So we've been partly using Google's software to provide you information all about this stuff. 
											</div>
											<div style="font-family:robotoreg;text-align:left;" class="mb-2">
												Unfortunately, even then can't even give you that right now. We promise to satisfy your needs in the future, though!
											</div>
											<div style="font-family:robotoreg;text-align:right;margin:0">
												We deeply apologise, <br> BTTSC xx
											</div>
										</div>
									</div>
								</center>
							</div>
							<div class="col-lg-2"></div>
						</div>
					<?php
				}
				elseif( $json2PHP2['status']=="OK" OR $json2PHP3['status']=="OK" OR $json2PHP4['status']=="OK" OR $json2PHP5['status']=="OK" OR $json2PHP6['status']=="OK" OR $json2PHP7['status']=="OK" OR $json2PHP8['status']=="OK" OR $json2PHP9['status']=="OK" OR $json2PHP10['status']=="OK" OR $json2PHP11['status']=="OK" OR $json2PHP12['status']=="OK" ){ ?>

					<div class="grid-gallery">
						<?php
						$len = count($json2PHP2['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP2['results'][$i]['name']."</h1>";
								if(isset($json2PHP2['results'][$i]['photos'])){
									$imgplace = $json2PHP2['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: amusement_park</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP3['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP3['results'][$i]['name']."</h1>";
								if(isset($json2PHP3['results'][$i]['photos'])){
									$imgplace = $json2PHP3['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: zoo</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP4['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP4['results'][$i]['name']."</h1>";
								if(isset($json2PHP4['results'][$i]['photos'])){
									$imgplace = $json2PHP4['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: stadium</small>
								</div>
							</div>
							<?php
						}


						$len = count($json2PHP5['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP5['results'][$i]['name']."</h1>";
								if(isset($json2PHP5['results'][$i]['photos'])){
									$imgplace = $json2PHP5['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: shopping_mall</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP6['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP6['results'][$i]['name']."</h1>";
								if(isset($json2PHP6['results'][$i]['photos'])){
									$imgplace = $json2PHP6['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: lodging</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP7['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
							<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP7['results'][$i]['name']."</h1>";
								if(isset($json2PHP7['results'][$i]['photos'])){
									$imgplace = $json2PHP7['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: natural_feature</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP8['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP8['results'][$i]['name']."</h1>";
								if(isset($json2PHP8['results'][$i]['photos'])){
									$imgplace = $json2PHP8['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: airport</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP9['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP9['results'][$i]['name']."</h1>";
								if(isset($json2PHP9['results'][$i]['photos'])){
									$imgplace = $json2PHP9['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: art_gallery</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP10['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP10['results'][$i]['name']."</h1>";
								if(isset($json2PHP10['results'][$i]['photos'])){
									$imgplace = $json2PHP10['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: church</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP11['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP11['results'][$i]['name']."</h1>";
								if(isset($json2PHP11['results'][$i]['photos'])){
									$imgplace = $json2PHP11['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: mosque</small>
								</div>
							</div>
							<?php
						}

						$len = count($json2PHP12['results']);
						for($i=0;$i<$len;$i++){ ?>
							<div class="grid-gallery-item">
								<?php
								echo "<h1 style=\"font-size:20px;text-transform:capitalize;\" class='text-center'>".$json2PHP12['results'][$i]['name']."</h1>";
								if(isset($json2PHP12['results'][$i]['photos'])){
									$imgplace = $json2PHP12['results'][$i]['photos'][0]['photo_reference'];
									$imgUrl='https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$imgplace.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; ?>
									<img src="<?php echo $imgUrl; ?>" style="border-style:none;border-width:0px;width:100%;object-fit:cover;height:250px;">
									<?php
								}
								else{ ?>
									<img src="https://www.blakeslistings.com/assets/images/image-not-available.jpg" style="width:100%;object-fit:cover;height:250px;" alt="">
									<?php
								} ?>
								<div style="font-family:gravity;text-transform:uppercase">
									<small>Type: campground</small>
								</div>
							</div>
							<?php
						} ?>
					</div>

					<div class="mt-5" style="font-family: gravity;">
						<small>*<b>Note</b> that everything you see in this page is provided by Google. We simply intend to show you the famous places that may want to visit in the future. That being said, we actually have no control over with what you're seeing.</small>
					</div>

					<?php
				} ?>
			</div>
			<?php
			// echo "<div style='text-align:left;width:100%;overflow-y:scroll'><pre>";
			// print_r($json2PHP2);
			// echo "</pre></div>"; ?>
		</div>
	</div>
	<?php
	require "footer.php";
}