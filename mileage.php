<?php session_start();
require "includes/dbconnect.inc.php";
$major_id=$_GET['major_id'];
if(isset($major_id)){ ?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<style>
			*{
				width:100%;
			}
			body{
				padding:10px;
			}
		</style>
	</head>
	<body>

		<div class="row">
			<div class="col-lg-6">
				<div id="map" style="width:100%;height:800px;"></div>
			</div>
			<div class="col-lg-6">

				<div style="" class="mb-3"><!-- <div style="height:0%;visibility: hidden"> -->

					<?php
					$first_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
					$first=mysqli_fetch_assoc($first_q);
					$start_lng=$first['orig_lat'];
					$start_lat=$first['orig_lng'];
					$start_lt_ln=$start_lng.','.$start_lat;
					$start_place_id=$first['orig_place_id']; ?>
					Starting Lat & Lng (<?php echo $first['orig_place']; ?>): <input type="text" id="start" value="<?php echo $start_lt_ln; ?>">

					<br>
					
					Waypoints: <br>
					<select multiple id="waypoints" style="">
						<?php
						$second_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id > (SELECT MIN(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC");
						while($waypoints=mysqli_fetch_assoc($second_q)){
							$waypoint_lng=$waypoints['orig_lat'];
							$waypoint_lat=$waypoints['orig_lng'];
							$waypoint_lt_ln=$waypoint_lng.','.$waypoint_lat;
							$wp_array[]="via:".$waypoint_lt_ln; ?>
							<option selected value="<?php echo $waypoint_lt_ln; ?>"><?php echo $waypoints['orig_place']; ?> (<?php echo $waypoint_lt_ln; ?>)</option>
							<?php 
						} ?>
					</select>

					<!--  -->
					<?php
					$doop=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$major_id'");
					while($rub=mysqli_fetch_assoc($doop)){
						$latt=$rub['longitude'];
						$lonn=$rub['latitude'];
						$coords=$latt.','.$lonn;
						$coord_arr[]=$coords;
						$coord_place_id[]="place_id:".$rub['place_id'];
					} ?>
					<!--  -->

					<br>

					<?php
					$last_q=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE book_arrdep_id < (SELECT MAX(book_arrdep_id) FROM booking_arr_dep WHERE major_id='$major_id') AND major_id='$major_id' ORDER BY book_arrdep_id ASC LIMIT 1");
					$last=mysqli_fetch_assoc($last_q);
					$last_lng=$last['orig_lat'];
					$last_lat=$last['orig_lng'];
					$last_lt_ln=$last_lng.','.$last_lat; ?>
					Ending Lat & Lng (<?php echo $last['orig_place']; ?>): <input type="text" id="end" value="<?php echo $last_lt_ln; ?>">

					<br>

				</div>



				<div id="directions-panel"></div>

			</div>


			<?php
			$kio=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
			$counte=mysqli_fetch_assoc($kio);
			if($counte['optimise']==null){ //not optimise ?>
				<div class="row" style="padding:20px;">
					<div class="col-lg-12">
						<?php
						$qut=mysqli_query($conn,"SELECT * FROM booking_arr_dep WHERE major_id='$major_id'");
						while($rut=mysqli_fetch_assoc($qut)){
							$originLngLat=$rut['orig_lat'].','.$rut['orig_lng'];
							$destLngLat=$rut['des_lat'].','.$rut['des_lng'];
							// $url_a="https://maps.googleapis.com/maps/api/directions/json?origin=".$originLngLat."&destination=".$destLngLat."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
							$originPlace_id=$rut['orig_place_id'];
							$destPlace_id=$rut['des_place_id'];
							$url_a='https://maps.googleapis.com/maps/api/directions/json?origin=place_id:'.$originPlace_id.'&destination=place_id:'.$destPlace_id.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
							$getJson_a=file_get_contents($url_a);
							$json2PHP_a=json_decode($getJson_a, true);
							// echo "<pre>";
							// print_r($json2PHP_a);
							// echo "</pre>";
							$len_a=count($json2PHP_a['routes'][0]['legs'][0]['steps']);
							$one_u='https://maps.googleapis.com/maps/api/place/details/json?placeid='.$rut['orig_place_id'].'&fields=name&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
							$getj=file_get_contents($one_u);
							$jso=json_decode($getj,true);
							$origgg=$jso['result']['name'];
							$two_u='https://maps.googleapis.com/maps/api/place/details/json?placeid='.$rut['des_place_id'].'&fields=name&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
							$getj=file_get_contents($two_u);
							$jso=json_decode($getj,true);
							$desss=$jso['result']['name']; ?>
							<h2>Trip to <?php echo $origgg." → ".$desss; ?> (<?php echo $rut['duration'].' - '.$rut['mileage'].' km'; ?>)</h2>
							<?php
							echo "<ol>";
							for($i=0;$i<$len_a;$i++){
								echo "<li>[".$json2PHP_a['routes'][0]['legs'][0]['steps'][$i]['duration']['text']."]"."\t\t";
								echo $json2PHP_a['routes'][0]['legs'][0]['steps'][$i]['html_instructions']."</li>";
							}
							echo "</ol>";
						} ?>
					</div>
				</div>
				<?php
			}
			elseif($counte['optimise']=="true"){ //optimise ?>
				<div class="row" style="padding:20px;">
					<div class="col-lg-12">
						<?php
						// $implode_wp=implode("|",$coord_place_id);
						$implode_wp_place_id=implode("|",$coord_place_id);
						// $url="https://maps.googleapis.com/maps/api/directions/json?origin=".$start_lt_ln."&destination=".$last_lt_ln."&waypoints=optimize:true|".$implode_wp."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
						$url="https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$start_place_id."&destination=place_id:".$start_place_id."&waypoints=optimize:true|".$implode_wp_place_id."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
						$getJson=file_get_contents($url);
						$json2PHP=json_decode($getJson, true);
						$len=count($json2PHP['routes'][0]['legs']);
						for($i=0;$i<$len;$i++){
							echo "<h3>";
							$place_idA = $json2PHP['geocoded_waypoints'][$i]['place_id'];
							$urlA='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idA.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
							$getJsonA=file_get_contents($urlA);
							$json2PHPA=json_decode($getJsonA, true);
							$k=$i+1;
							$place_idB = $json2PHP['geocoded_waypoints'][$k]['place_id'];
							$urlB='https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place_idB.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
							$getJsonB=file_get_contents($urlB);
							$json2PHPB=json_decode($getJsonB, true);
							echo $json2PHPA['result']['name'].' → '.$json2PHPB['result']['name'].' ('.$json2PHP['routes'][0]['legs'][$i]['distance']['text'].'-'.$json2PHP['routes'][0]['legs'][$i]['duration']['text'].')';
							echo "</h3>";
							$len2=count($json2PHP['routes'][0]['legs'][$i]['steps']);
							echo "<ol>";
							for($j=0;$j<$len2;$j++){
								echo "<li>";
								echo $json2PHP['routes'][0]['legs'][$i]['steps'][$j]['html_instructions'];
								echo "</li>";
							}
							echo "</ol>";
						}
						// echo "<pre>";
						// print_r($json2PHP);
						// echo "</pre>";  ?>
					</div>
				</div>
				<?php 
			} ?>

		</div>

		<script>
		function initMap() {
			var directionsService = new google.maps.DirectionsService;
			var directionsDisplay = new google.maps.DirectionsRenderer;
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 17,
				center: {lat: 41.85, lng: -87.65}
			});
			directionsDisplay.setMap(map);
			calculateAndDisplayRoute(directionsService, directionsDisplay);
		}

		function calculateAndDisplayRoute(directionsService, directionsDisplay) {
			var waypts = [];
			var checkboxArray = document.getElementById('waypoints');
			for (var i = 0; i < checkboxArray.length; i++) {
			if (checkboxArray.options[i].selected) {
					waypts.push({
						location: checkboxArray[i].value,
						stopover: true
					});
				}
			}
			directionsService.route(
				{
					origin: document.getElementById('start').value,
					destination: document.getElementById('end').value,
					waypoints: waypts,
					optimizeWaypoints: <?php
						if($counte['optimise']==null){echo "false";}
						elseif($counte['optimise']=="true"){echo "true";} ?>,
					travelMode: 'DRIVING',
					avoidFerries: true,
					avoidHighways: false,
					avoidTolls: false
				}, 
				function(response, status) {
					if (status === 'OK') {
						directionsDisplay.setDirections(response);
						var route = response.routes[0];
						var summaryPanel = document.getElementById('directions-panel');
						summaryPanel.innerHTML = '';
						// For each route, display summary information.
						for (var i = 0; i < route.legs.length; i++) {
							var routeSegment = i + 1;
							summaryPanel.innerHTML += '<b>Trip ' + routeSegment +
							'</b><br>';
							summaryPanel.innerHTML += route.legs[i].start_address + ' ~ to ~ ';
							summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
							summaryPanel.innerHTML += route.legs[i].distance.text + '<br>';
							summaryPanel.innerHTML += route.legs[i].duration.text + '<br><br>';
						}
					} 
					else {
						window.alert('Directions request failed due to ' + status);
					}
				}
			);
		}
		</script>

		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&callback=initMap">
		</script>
	</body>
	</html>
	<?php 
}