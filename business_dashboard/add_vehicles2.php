<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
$member_id=$_GET['member_id'];
$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
$row=mysqli_fetch_assoc($sql);
$ssss=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE member_id='$member_id'");
$cc=mysqli_num_rows($ssss);
?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="add_vehicles.php?member_id=<?php echo $member_id;?>&count=<?php echo $cc;?>">Add Vehicles</a>
		</li>
		<li class="breadcrumb-item active">Add For <?php echo $row['member_first_name']; ?></li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			<?php echo $row['member_first_name'].' '.$row['member_last_name']; ?>
		</div>
		<div class="card-body">
			<form action="../includes/save_vehicles_admin_side.inc.php" method="POST">
				<input type="hidden" name="member_id" value="<?php echo $member_id;?>">
				<input type="hidden" name="member_first_name" value="<?php echo $row['member_first_name'];?>">
				<input type="hidden" name="count" value="<?php echo $cc; ?>">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Make</label>
							<input type="text" class="form-control" name="make" placeholder="Brand (e.g. Honda, Nissan, Toyota)">
						</div>
						<div class="form-group">
							<label for="">Plate Number</label>
							<input type="text" class="form-control" name="plate_number">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Model</label>
							<input type="text" class="form-control" name="model" placeholder="(e.g. Urvan, etc.)">
						</div>
						<div class="form-group">
							<label for="">Franchised?</label>
							<select name="franchised" class="form-control">
								<option value="YES">Yes</option>
								<option value="NO">No</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Year</label>
							<input type="number" class="form-control" name="year">
						</div>
						<div class="form-group">
							<label for="">Active? <small>(Ready to be used, or is it under maintenance/repair? etc.)</small></label>
							<div class="form-check">
								<input type="radio" value="ACTIVE" name="status" class="form-check-input" id="haha3">
								<label class="form-check-label" for="haha3">Yes</label>
							</div>
							<div class="form-check">
								<input type="radio" value="INACTIVE" name="status" class="form-check-input" id="haha4">
								<label class="form-check-label" for="haha4">No</label>
							</div>	
						</div>
						<div style="text-align: right;">
							<button name="savechanges" class="btn btn-lg btn-primary">Save Changes</button>
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