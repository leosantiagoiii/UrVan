<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
$member_id=$_GET['member_id'];
$vehicle_id=$_GET['vehicle_id'];
$sql=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE id='$vehicle_id'");
$count=mysqli_num_rows($sql);
$row=mysqli_fetch_assoc($sql);
?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="add_vehicles.php?member_id=<?php echo $member_id;?>&count=<?php echo $count;?>">Add Vehicles</a>
		</li>
		<li class="breadcrumb-item active">Edit Vehicle</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Edit Van <?php echo $row['id']; ?>
		</div>
		<div class="card-body">
			<form method="POST" action="../includes/edit_vans.inc.php">
				<input type="hidden" name="member_id_2" value="<?php echo $member_id; ?>">
				<input type="hidden" name="vehicle_id_2" value="<?php echo $vehicle_id; ?>">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Make</label>
							<input type="text" class="form-control" name="make" placeholder="Brand (e.g. Honda, Nissan, Toyota)" value="<?php echo $row['make'];?>">
						</div>
						<div class="form-group">
							<label for="">Plate Number</label>
							<input type="text" class="form-control" name="plate_number" value="<?php echo $row['plate_number'];?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Model</label>
							<input type="text" class="form-control" name="model" placeholder="(e.g. Urvan, etc.)" value="<?php echo $row['model'];?>">
						</div>

						<div class="form-group">
							<label for="">Franchised?</label>
							<br>
							<select name="franchised">
								<option value="YES" <?php if($row['franchised']=="YES"){echo "selected";} ?>>Yes</option>
								<option value="NO" <?php if($row['franchised']=="NO"){echo "selected";} ?>>No</option>
							</select>
							<!-- <input type="hidden" name="franchised" value="YES"> -->
						</div>

					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Year</label>
							<input type="number" class="form-control" name="year" value="<?php echo $row['year'];?>">
						</div>
						<div class="form-group">
							<label for="">Active? <small>(Ready to be used, or is it under maintenance/repair? etc.)</small></label>
							<div class="form-check">
								<input type="radio" value="ACTIVE" name="status" class="form-check-input" id="haha3" <?php if($row['status']=="ACTIVE"){echo "checked";} ?>>
								<label class="form-check-label" for="haha3">Yes</label>
							</div>
							<div class="form-check">
								<input type="radio" value="INACTIVE" name="status" class="form-check-input" id="haha4" <?php if($row['status']=="INACTIVE"){echo "checked";} ?>>
								<label class="form-check-label" for="haha4">No</label>
							</div>
						</div>
						<div style="text-align: right;">
							<button name="savechanges_hho" class="btn btn-lg btn-primary">Save Changes</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>