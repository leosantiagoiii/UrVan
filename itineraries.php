<?php session_start();
require "header.php";
if(!isset($_SESSION['clientid'])){
}
else{
	if( !isset($_GET['tour_id']) && !isset($_GET['major_id']) ){
	}
	else{
		$major_id=$_GET['major_id'];
		$tour_id=$_GET['tour_id'];
		$start=$_GET['start'];
		// $end=$_GET['end']; ?>
		<style>
			#map{
				width:100%;
				height:400px;
			}
		</style>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
		<!--  -->
		<link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
		<div class="container" style="padding:50px 0 60px 0">
			<div class="text-center">
				<h1 style="font-family:roboto;margin-bottom:17px;">ITINERARY</h1>
			</div>
			<form action="includes/itineraries.inc.php" method="POST">
				<input type="hidden" name="longitude" id="loung">
		        <input type="hidden" name="latitude" id="laut">

		        <input type="hidden" name="place_name_" id="plazenam">
				<input type="hidden" name="place_id_" id="plazeid">

				<div class="row" style="width:100%;">
					<div class="col-lg-5 card" style="padding:20px;">
						<div class="row form-group">
							<div class="col-lg-12">
								<input name="destination" id="reportplaceauto" type="text" class="form-control" placeholder="Destination"
									<?php
									if(isset($_GET['desti'])){
										echo 'value=\''.$_GET['desti'].'\'';
									}
									?>
								>
							</div>
						</div>
						<!-- <div class="row form-group">
							<div class="col-lg-6">
								<script   src="http://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
								<input id="sim" name="expected_arr_date" type="text" class="form-control"  placeholder="Expected Arrival Date" style="margin:0;"
									<?php
									// if(isset($_GET['arr_date'])){
									// 	echo 'value=\''.$_GET['arr_date'].'\'';
									//} ?> >
							</div>
							<div class="col-lg-6">
								<input id="tap" name="expected_dep_date" type="text" class="form-control"  placeholder="Expected Departure Date" style="margin:0;"
									<?php
									// if(isset($_GET['dep_date'])){
									// 	echo 'value=\''.$_GET['dep_date'].'\'';
									//} ?> >
							</div>
						</div> -->
						<input type="hidden" id="st" value="<?php echo $start; ?>" name="starr">
						<!-- <input type="hidden" id="en" value="<?php //echo $end; ?>" name="enn"> -->
						<!-- <script>
						$(document).ready(function(){
							$.datepicker.setDefaults({
								dateFormat: 'yy-mm-dd'
							});
							$(function(){
						            var minDate=document.getElementById('st').value;
						            var maxDate=document.getElementById('en').value;
						            console.log(minDate);
						            console.log(maxDate);
								$('#sim').datepicker({
						                  numberOfMonth:1,
						                  minDate:minDate,
						                  maxDate:maxDate,
						                  onClose:function(selectedDate){
						                        $('#tap').datepicker("option","minDate",selectedDate);
						                        var viol=document.getElementById('sim').value;
						                        var newd=new Date(viol);
						                        var newmax=newd.toString();
						                        console.log(newmax);
						                  }
						            });
						            $('#tap').datepicker({
						                  numberOfMonth:1,
						                  minDate:minDate,
						                  maxDate:maxDate,
						                  onClose:function(selectedDate){
						                        $('#tap').datepicker("option","minDate",selectedDate)
						                  }
						            });
							});
						});
						</script> -->
						<!-- div class="row form-group">
							<div class="col-lg-6">
								<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
								<script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
								<input name="expected_arr_time" class="form-group" id="timepicker1"  placeholder="Expected Arrival Time"
									<?php
									//if(isset($_GET['arr_time'])){
									//	echo 'value=\''.$_GET['arr_time'].'\'';
									//} ?> >
							</div>
							<div class="col-lg-6">
								<input name="expected_dep_time" class="form-group" id="timepicker2"  placeholder="Expected Departure Time"
									<?php
									//if(isset($_GET['dep_time'])){
									//	echo 'value=\''.$_GET['dep_time'].'\'';
									//} ?> >
								<script>
								$('#timepicker1').timepicker();
								</script>
								<script>
									$('#timepicker2').timepicker();
								</script>
							</div>
						</div> -->
						<div class="row form-group">
							<div class="col-lg-12">
								<textarea name="remarks" id="" rows="3" class="form-control" placeholder="REMARKS"><?php if(isset($_GET['remarks'])){ echo $_GET['remarks']; } ?></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-lg-12">
								<script src="http://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
								<?php
								$kali=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
								$kalif=mysqli_fetch_assoc($kali);
								$first_dayt=$kalif['start_date'];
								$first_dayt=strtotime($first_dayt);
								$mum1 = strtotime($_SESSION['date_js']);
								// echo 'in session '.DATE("Y M d H:i:s",$mum1);
								// echo "<br>";
								$hal = strtotime($_GET['duration']);
								// echo 'in input '.DATE("Y M d H:i:s",$hal); ?>
								<input type="text" name="endDate" <?php if(isset($_GET['duration'])){echo 'value=\''.$_GET['duration'].'\'';} ?> class="form-control daepic <?php if($hal<$mum1){echo "bg-danger text-white";} ?>" id="end_date_x" placeholder="End Date" style="margin:0;">
								<?php
								$mae=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$tour_id'");
                              	$fuel=mysqli_num_rows($mae); ?>
								<script>
									$(document).ready(function(){
										$.datepicker.setDefaults({
											dateFormat: 'yy-mm-dd'
										});
										$(function(){
											var minDate=new Date("<?php echo $_SESSION['date_js'];?>");
											minDate.setDate(minDate.getDate());
											var maxDate=new Date();
											<?php
											if($fuel>=1){
												echo "maxDate.setDate(minDate.getDate()+0);";
											}
											else{
												echo "maxDate.setDate(minDate.getDate()+365);";
											} ?>
											console.log(minDate);
											console.log(maxDate);
											$('#end_date_x').datepicker({
												numberOfMonth:1,
												minDate:minDate,
												maxDate:maxDate,
											});
										});
									});
								</script>
							</div>
						</div>
						<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
						<input type="hidden" name="tour_id" value="<?php echo $tour_id; ?>">
						<!-- <input type="hidden" name="duration" value="<?php //echo $duration; ?>"> -->
						<div style="width:100%">
							<?php $sql="SELECT * FROM booking_minordetails WHERE major_id='$major_id'";
							$sja=mysqli_query($conn,$sql);
							$cdsj=mysqli_num_rows($sja);
							if($cdsj<=0){ ?>
								<div class="btn-group" style="width:100%">
									<button type="submit" required name="savebutton" class="btn btn-primary w-100">Save Record</button>
									<button type="submit" required name="cancbu" class="btn btn-danger w-100">Cancel Trip</button>
								</div>
								<?php
							}
							else{ ?>
								<div class="btn-group" style="width:100%;">
									<button type="submit" name="savebutton" class="btn btn-primary w-100">Save Record</button>
									<button class="btn btn-danger w-100" name="cancun">Cancel Trip</button>
									<button type="button" class="btn btn-success w-100" data-toggle="modal" data-target="#exampleModal">Proceed To Payment</button>
								</div>
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Payment Method</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn text-white" name="payment" formaction="book_payment.php" style="background-color:#74107f;">Thru Stripe</button>
												<button type="submit" class="btn btn-primary" name="trudep" formaction="includes/book_payment_deposit_slip.inc.php">Thru Deposit</button>
											</div>
										</div>
									</div>
								</div>
								<?php 
							} ?>
						</div>
					</div>
					<div class="col-lg-7">
						<?php
						if(!isset($_GET['minor_id'])){
							// echo "<div class='text-center' style='margin-top:30px;'><h3 style='font-family:raleway;'>- You haven't put anything yet! -</h3></div>"; ?>
							<div class="alert alert-warning text-center" role="alert" style="font-family:monsreg;height:auto;">
								<h1>Whoa there!</h1>
								You haven't entered anything yet.
							</div>
							<?php
						}
						else{ ?>
							<div style="overflow-y:auto;height:250px;" class="card">
								<table class="tbl table" style="overflow: auto;">
									<tr>
										<th>Destination</th>
										<th>Remarks</th>
										<th>Option</th>
									</tr>
									<?php
									$mamacita=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
									$rowi=mysqli_fetch_assoc($mamacita);
									$origin_arr[]=$rowi['latitude'].','.$rowi['longitude'];
									$mey="SELECT * FROM booking_minordetails WHERE major_id='$major_id' ORDER BY created_at ASC";
									$mey=mysqli_query($conn,$mey);
									$couy=mysqli_num_rows($mey);
									if($couy<=0){ 
										//echo "<div class='text-center' style='margin-top:30px;'><h3 style='font-family:gravity;'>- You haven't put anything yet! -</h3></div>"; ?>
										<div class="alert alert-warning text-center" role="alert" style="font-family:monsreg;height:auto;">
											<h1>Whoa there!</h1>
											You haven't entered anything yet.
										</div>
										<?php
									}
									else{
										while($quel=mysqli_fetch_assoc($mey)){
											$origin_arr[]=$quel['longitude'].','.$quel['latitude'];
											$destination_arr[]=$quel['longitude'].','.$quel['latitude']; ?>
											<tr>
												<td><?php echo $quel['destination']; ?></td>
												<td>
													<?php  
													if($quel['remarks']!=''){
														echo $quel['remarks'];
													}
													else{
														echo "N/A";
													} ?>
												</td>
												<td>
													<input type="hidden" name="minor_id_grod" value="<?php echo $quel['minor_id'];?>">
													<!-- input type="submit" name="deleteer" class="btn btn-danger btn-block" formaction="includes/delete_itin.inc.php" value="<?php //echo $quel['minor_id'];?>">  -->
													<a href="includes/delete_itin.inc.php?deleteq&major_id=<?php echo $major_id; ?>&end=<?php echo $_GET['duration']; ?>&tour_id=<?php echo $tour_id; ?>&minor_id=<?php echo $quel['minor_id'];?>" class="btn btn-danger btn-block">Remove</a>
												</td>
											</tr>
											<?php 
										}  
									} ?>
								</table>
							</div>
							<?php
							$destination_arr[]=$rowi['latitude'].','.$rowi['longitude'];
							$arr_count=count($destination_arr);
							for($i=0;$i<$arr_count;$i++){
								$url_a="https://maps.googleapis.com/maps/api/directions/json?origin=".$origin_arr[$i]."&destination=".$destination_arr[$i]."&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI";
								$getJson_a=file_get_contents($url_a);
								$json2PHP_a=json_decode($getJson_a, true);
								$strtotime_num=$json2PHP_a['routes'][0]['legs'][0]['duration']['value'];
								// $strtotime_num=strtotime($strtotime_num);
								// $strtotime_num=DATE("Y-M-d H:i:s",$strtotime_num);
								$total_time[]=$strtotime_num;
							}
							$total_time_x=array_sum($total_time);
							$trip_start_date=$rowi['start_date'].' '.$rowi['reporting_time']; // pstarting date of trip
							$trip_start_date=strtotime($trip_start_date);
							$trip_start_date_read=DATE("y M d H:i A",$trip_start_date);
							$recommended_date = DATE("y M d H:i A",$total_time_x+$trip_start_date); //recommended day for not trip
							// $_SESSION['recommended_just_date'] = strtotime(DATE("D M d Y H:i:s O",$total_time_x+$trip_start_date));
							$_SESSION['date_js'] = DATE("Y/m/d",$total_time_x+$trip_start_date); ?>
							<div class="alert alert-primary  mt-3" role="alert" style="font-family:raleway;height:auto;">
								<h3 class="text-center">Least Duration for this Trip</h3>
								<script>
									$(function () {
									$('[data-toggle="popover"]').popover()
									})
								</script>
								<h4 style="font-size:28px;" class="text-center" data-toggle="tooltip" data-placement="top" title="Tooltip on top">	<?php echo $trip_start_date_read.' to <u>'.$recommended_date.'</u>';?>
								</h4>
								<hr>
								<div style="font-weight: 100">* The recommended time is provided to you by Google Maps. Take note that the everything is only an approximate; accidents, emergencies, calamities and the like may affect or delay your trip.</div>
							</div>
							<?php 
							// echo "<pre>";
							// print_r($origin_arr);
							// echo "</pre>";
							// echo "<pre>";
							// print_r($destination_arr);
							// echo "</pre>";
						} ?>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-lg-12">
					<div class="card" style="margin-top:27px;border-style:solid;border-color: black;width:100%;" id="map"></div>
				</div>
			</div>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&libraries=places"></script>
			<script>
				var map;
				var luzonBounds = {
                    north:22.126313526021505,
                    south:5.200320352447366,
                    west:100.63103549327548,
                    east:130.93132846202548,
                };
				map = new google.maps.Map(document.getElementById('map'), {
					center:{
						lat:13.9450, lng: 121.1312
					},
					restriction:{
                              latLngBounds: luzonBounds,
                              strictBounds: false,
                       },
					zoom: 8
				});
				var marker;
				marker = new google.maps.Marker({
					position:{
						lat: 13.9450, lng: 121.1312
					},
						map:map,
						draggable:false
				});
				var searchbox;
				searchbox = new google.maps.places.SearchBox(document.getElementById('reportplaceauto'));
				google.maps.event.addListener(searchbox,'places_changed', function(){
					var places = searchbox.getPlaces();
					var bounds = new google.maps.LatLngBounds();
					var i, place;
					for(i=0;place=places[i];i++){
						var lati = place.geometry.location.lat();
						var longi = place.geometry.location.lng();
						var placeName = place.name;
						var placeID = place.place_id;
						console.log(place);
						bounds.extend(place.geometry.location);
						marker.setPosition(place.geometry.location);
						                              var aNorth  =   map.getBounds().getNorthEast().lat();
                              var aEast   =   map.getBounds().getNorthEast().lng();
                              var aSouth  =   map.getBounds().getSouthWest().lat();
                              var aWest   =   map.getBounds().getSouthWest().lng();
					}
					map.fitBounds(bounds);
					map.setZoom(15);
					document.getElementById('plazenam').value = placeName;
					document.getElementById('plazeid').value = placeID;
					document.getElementById('loung').value = lati;
					document.getElementById('laut').value = longi;
					                        document.getElementById('nor').value = aNorth;
                        document.getElementById('sou').value = aSouth;
                        document.getElementById('eas').value = aEast;
                        document.getElementById('wes').value = aWest;
				});
			</script>
		</div>
		<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
		<script>
			$(document).ready(function(){
				$.datepicker.setDefaults({
					dateFormat: 'yy-mm-dd'
				});
				$(function(){
					$(".daepic").datepicker();
				});
			});
		</script>
		<?php
		require "footer.php";
	}
}
?>