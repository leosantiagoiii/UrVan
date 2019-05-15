<?php
session_start();
if(isset($_SESSION['adminid'])){
	if(isset($_GET['tour_id'])){
	require "header.php";
	require "../includes/dbconnect.inc.php";
	$tour_id=$_GET['tour_id'];
?>
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<div class="container-fluid">
	<?php $sql="SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'";
	$res=mysqli_query($conn,$sql); 
	while($row=mysqli_fetch_assoc($res)){ ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="admin_tours_and_packages.php">Tours And Packages Content</a>
		</li>
		<li class="breadcrumb-item active">Edit Post #<?php echo $row['tour_id'];?></li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Edit <?php echo $row['tour_name']; ?>
		</div>
		<div class="card-body">
			<form action="../includes/tours_and_packages_modify.inc.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="package-id" value="<?php echo $tour_id; ?>">
				<div class="form-group">
					<div class="row">
						<div class="col">
							<label for="package-name">Tour Name:</label>
							<input type="text" id="" class="form-control" placeholder="Package Name" required="required" name="package-name" value="<?php echo $row['tour_name']; ?>">
						</div>
						<div class="col">
							<label for="package-price">Price:</label>
							<input type="text" id="inputPrice" class="form-control" placeholder="Price" required="required" name="package-price" value="<?php echo $row['tour_price']; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group" >
						<div class="card" style="padding:30px; margin-bottom:10px;">
							<img style="width:100%;height:400px;object-fit:cover;" src="../includes/tour_and_packages_image_get.inc.php?tour_id=<?php echo $row['tour_id']; ?>">
						</div>
						<div class="row">
							<div class="col-lg-6">
								Header Image:
                				<input type="file" name="tour_image" class="form-control" style="padding:10px 10px;">
							</div>
							<div class="col-lg-6">
								<?php
								$yu=mysqli_query($conn,"SELECT * FROM tour_and_packages_location WHERE tour_id='$tour_id'");
								$tu=mysqli_num_rows($yu);
								$mu=mysqli_fetch_assoc($yu); ?>
								Location:
								<input type="text" id="locationn" class="form-control" placeholder="Package Name" required="required" name="completeadd" value="<?php if($tu>=1){echo $mu['formatted_address'];} ?>">
			                     <input type="hidden" id="latiy" name="latitude" value="<?php if($tu>=1){echo $mu['latitude'];} ?>">
			                     <input type="hidden" id="longie" name="longitude" value="<?php if($tu>=1){echo $mu['longitude'];} ?>">
			                     <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&libraries=places"></script>
			                     <script>
			                      var searchbox;
			                      searchbox = new google.maps.places.SearchBox(document.getElementById('locationn'));
			                      google.maps.event.addListener(searchbox,'places_changed', function(){
			                        var places = searchbox.getPlaces();
			                        var bounds = new google.maps.LatLngBounds();
			                        var i, place;
			                        for(i=0;place=places[i];i++){
			                           var lati = place.geometry.location.lat();
			                           var longi = place.geometry.location.lng();
			                           console.log(place);
			                           bounds.extend(place.geometry.location);
			                        }
			                        document.getElementById('latiy').value = lati;
			                        document.getElementById('longie').value = longi;
			                      });
			                     </script>
							</div>
						</div>
						
              		</div>
				</div>
				<div class="form-group">
		          <div class="form-label-group" >
		            <textarea id="inputPackageDesc" class="form-control" placeholder="Description" name="package-desc" required rows="5" ><?php echo $row['tour_description']; ?></textarea>
		            <script>
		            CKEDITOR.replace( 'package-desc' );
		            </script>
		          </div>
		        </div>
		        <div class="form-group">
					<div class="form-label-group">
						<div class="card" style="padding:20px;">
							<div class="row">
								<?php
									$codse="SELECT * FROM tours_and_packages_gallery_table WHERE tour_id='$_GET[tour_id]'";
									$resulting=mysqli_query($conn,$codse);
									while($roww=mysqli_fetch_assoc($resulting)){
									if($roww['target_dir']==NULL){}else{ ?>
									<div class="col-sm-3 card">
										<img src="../includes/<?php echo $roww['target_dir']; ?>" alt="" style="width:100%;">
										<a href="../includes/tours_and_packages_modify.inc.php?tour_gallery_id=<?php echo $roww['tour_gallery_id'];?>&tour_id=<?php echo $tour_id; ?>&deletebutton=succ&target_dir=<?php echo $roww['target_dir']; ?>">Delete</a>
									</div>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-sm-12 card">
									Add More:
									<input type="file" name="tours_gallery[]" multiple="multiple" style="padding:10px;">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<b>On Sale?</b><br>
									<?php $dj=mysqli_query($conn,"SELECT * FROM tours_sales WHERE tour_id='$tour_id'");
									$jd=mysqli_num_rows($dj); ?>
									<input type="radio" name="sale" value="yes" id="" required <?php
									if($jd>=1){
										echo "checked";
									}
									?>> Yes
									<input type="radio" name="sale" value="no" id="" <?php
									if($jd<=0){
										echo "checked";
									}
									?>> No
								</div>
								<div class="col-sm-5">
									<?php
									$dksa=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
									$pree=mysqli_num_rows($dksa); ?>
									<label for="">NCR or Will Go Thru NCR?</label>
									<select name="NCR_choice" class="form-control">
										<option value="YES" <?php if($pree>=1){echo "selected";} ?>>Yes</option>
										<option value="NO" <?php if($pree<=0){echo "selected";} ?>>No</option>
									</select>
									<!-- <input type="text" name="NCR_choice" value="YES"> -->
								</div>
								<div class="col-sm-5">
									<?php
									$mumi=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$tour_id'");
									$kas=mysqli_num_rows($mumi); ?>
									<label for="">Single Trip?</label>
									<select name="single_trip" class="form-control">
										<option value="YES" <?php if($kas>=1){echo "selected";} ?>>Yes</option>
										<option value="NO" <?php if($kas<=0){echo "selected";} ?>>No</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-success" name="edit-button" value="edit-button">Save Changes</button>
			</form>
		</div>
		<div class="card-footer small text-muted">
		Updated yesterday at 11:59 PM
		</div>
	</div>
	<?php } ?>
</div>
<?php
require "footer.php";
}
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>