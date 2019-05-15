

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div id="demo" style=""></div>
	<form action="" method="get">
		<input type="text" name="lng" id="lng">
		<input type="text" name="lat" id="lat">
		<button  type="button" onclick="getLocation()">Try It</button>
		<button name="track">Track now</button>
	</form>

	<script>
	var x = document.getElementById("demo");
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}
	function showPosition(position) {
		x.innerHTML = "Latitude: " + position.coords.latitude +
		"<br>Longitude: " + position.coords.longitude;
		document.getElementById('lng').value = position.coords.longitude;
		document.getElementById('lat').value = position.coords.latitude;
	}
	</script>

	<?php
	if(isset($_GET['track'])){
		$lng=$_GET['lng'];
		$lat=$_GET['lat'];?>
		<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $lat; ?>,<?php echo $lng; ?>&zoom=18&size=1000x500&sensor=false&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&maptype=roadmap&format=png&markers=color:red%7Clabel:%7C14.083576376965484,121.15050964625487" alt="">
		<br>
		<?php 
		$url='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'; //lt/lng
		$getJson=file_get_contents($url);
		$json2PHP=json_decode($getJson, true);
		// echo "Latitude: ".$json2PHP['results'][0]['geometry']['location']['lat']."<br>";
		// echo "Longitude: ".$json2PHP['results'][0]['geometry']['location']['lng']."<br>";
		// echo "Formatted Address: ".$json2PHP['results'][0]['formatted_address']."<br>";
		echo $X_lat=$json2PHP['results'][0]['geometry']['location']['lat'];
		echo "<br>";
		echo $X_lng=$json2PHP['results'][0]['geometry']['location']['lng'];
		echo "<br>";
		echo $X_addr=$json2PHP['results'][0]['formatted_address'];
		echo "<br><br>Retrieved JSON from google maps api:";
		echo "<pre>";
		print_r($json2PHP);
		echo "</pre>";
	} ?>
</body>
</html>