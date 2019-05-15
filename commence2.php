<?php require "header.php";
$major_id=$_GET['major_id'];
$major1=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
$major=mysqli_fetch_assoc($major1);
$tour_id=$major['tour_id']; ?>
<div class="container-fluid">
	<div class="row" style="margin-top:100px;margin-bottom:100px">
		<div class="col-lg-1"></div>
		<div class="col-lg-10">

			<div class="card" style="padding:20px;">

				<h1 style="font-family:raleway;">So one more thing: </h1>

				<p style="font-family:robotoreg;font-size:20px;">Which car are you driving?</p>

				<form  style="font-family:roboto;font-size:20px;" action="includes/commence2.inc.php" method="get">
					<input type="hidden" name="major_id" value="<?php echo $major_id;?>">
					<div class="form-group">
						<select name="vehicle_id" class="form-control" required id="">
							<option value="" disabled="">-- Pick One --</option>
							<?php
							$ba=mysqli_query($conn,"SELECT * FROM tours_and_packages_NCR WHERE tour_id='$tour_id'");
							$welz=mysqli_num_rows($ba);
							if($welz>=1){
								$vehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE status='$major_id'");
							}
							else{
								$vehi=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE status='$major_id'");
							}
							while($vehicle=mysqli_fetch_assoc($vehi)){
								$getv=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle[vehicle_id]'");
								$getV=mysqli_fetch_assoc($getv); ?>
								<option value="<?php echo $vehicle['vehicle_id'];?>"><?php echo $getV['model'].' ('.$getV['plate_number'].')';?></option>
								<?php
							} ?>
						</select>
					</div>
					<button class="btn btn-primary btn-block mt-3" name="carChose" type="submit">Start Trip</button>
				</form>

			</div>

		</div>
		<div class="col-lg-1"></div>
	</div>
</div>
<?php
require "footer.php"; ?>