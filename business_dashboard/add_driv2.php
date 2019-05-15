<?php session_start();
require "../includes/dbconnect.inc.php";
require "header.php";
$member_id=$_GET['member_id'];?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="add_driv.php?member_id=<?php echo $member_id;?>">Driver Mgmnt.</a>
		</li>
		<li class="breadcrumb-item active">Add Driver</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-user-edit"></i>
			Add Driver: <?php echo $member_id; ?>
		</div>
		<div class="card-body">
			<form action="../includes/add_driver_n.inc.php" method="post">
				<?php 
				$temp_id=uniqid('DR',false);
				$final_driver_id=strtoupper($temp_id); ?>
				<input type="hidden" name="driver_id" value="<?php echo $final_driver_id;?>">
				<input type="hidden" name="member_id" value="<?php echo $member_id;?>">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Driver Name</label>
							<input type="text" class="form-control" required  name="driver_name">
						</div>
						<div class="form-group">
							<label for="">Birthdate</label>
							<input type="text" class="form-control" required  name="driver_birthdate">
						</div>
						<div class="form-group">
							<label for="">Civil Status</label>
							<input type="text" class="form-control" required  name="driver_civil_status">
						</div>
						<div class="form-group">
							<label for="">Blood Type</label>
							<input type="text" class="form-control" required  name="driver_blood_type">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Weight</label>
							<input type="text" class="form-control" required  name="driver_weight">
						</div>
						<div class="form-group">
							<label for="">Height</label>
							<input type="text" class="form-control" required  name="driver_height">
						</div>
						<div class="form-group">
							<label for="">TIN</label>
							<input type="text" class="form-control" required  name="driver_tin">
						</div>
						<div class="form-group">
							<label for="">Licence</label>
							<input type="text" class="form-control" required  name="driver_licence">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Email</label>
							<input type="text" class="form-control" required  name="driver_email">
						</div>
						<div class="form-group">
							<label for="">Password</label>
							<input type="password" class="form-control" required  name="driver_password">
						</div>
						<div class="form-group">
							<label for="">Contact</label>
							<input type="text" class="form-control" required  name="driver_contact">
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="">Emergency Contact</label>
							<input type="text" class="form-control" required  name="driver_emergency_name">
						</div>
						<div class="form-group">
							<label for="">Address</label>
							<input type="text" class="form-control" required  name="driver_emergency_address">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="">Contact Number</label>
							<input type="number" class="form-control" required  name="driver_emergency_contact">
						</div>
						<div class="form-group">
							<label for="">Relationship</label>
							<input type="text" class="form-control" required  name="driver_emergency_relationship">
						</div>
					</div>
				</div>
				<hr>
				<button name="sve" class="btn btn-success">Save Record</button>
			</form>
		</div>
	</div>
</div>
<?php
require "footer.php";