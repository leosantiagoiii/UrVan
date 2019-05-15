<?php session_start();
$driver_id=$_GET['driver_id'];
$member_id=$_GET['member_id'];
require "../includes/dbconnect.inc.php";
require "header.php";?>

<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="add_driv.php?member_id=<?php echo $member_id;?>">Driver Management</a>
		</li>
		<li class="breadcrumb-item active"><?php echo $driver_id;?></li>
	</ol>
	<div class="card mb-3">
		<?php
		$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$driver_id'");
		$driv=mysqli_fetch_assoc($sql); ?>
		<div class="card-header">
			<i class="fas fa-user-edit"></i>
			<?php echo $driv['driver_name']; ?>
		</div>
		<div class="card-body">
			<div style="width:100%;overflow-y: scroll">
				<form action="../includes/save_edit_driv.inc.php" method="get">
					<h4>Basic Details</h4>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="">Name:</label>
								<input type="text" class="form-control" name="driver_name" value="<?php echo $driv['driver_name'];?>">
							</div>
							<div class="form-group">
								<label for="">Birthdate:</label>
								<input type="text" class="form-control" name="driver_birthdate" value="<?php echo $driv['driver_birthdate'];?>">
							</div>
							<div class="form-group">
								<label for="">Civil Status</label>
								<select name="driver_civil_status" class="form-control" id="">
                                	<option>---</option>
                                	<option <?php if($driv['driver_civil_status']=="Single"){echo "selected";} ?> value="Single">Single</option>
                                	<option <?php if($driv['driver_civil_status']=="Married"){echo "selected";} ?> value="Married">Married</option>
                                	<option <?php if($driv['driver_civil_status']=="Divorced"){echo "selected";} ?> value="Divorced">Divorced</option>
                                	<option <?php if($driv['driver_civil_status']=="Separated"){echo "selected";} ?> value="Separated">Separated</option>
                                	<option <?php if($driv['driver_civil_status']=="Widowed"){echo "selected";} ?> value="Widowed">Widowed</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="">Weight</label>
								<select name="driver_weight" id="" class="form-control" required>
									<option value="unsure" <?php if($driv['driver_weight']=="unsure"){echo "selected";}?>>Unsure</option>
									<?php
									for($a=110;$a<=190;$a++){
										$w=$a.'lb'; ?>
										<option <?php if($driv['driver_weight']=="$w"){echo "selected";}?> value="<?php echo $a.'lb'; ?>"><?php echo $a; ?>lb</option>
										<?php 
									} ?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Height</label>
								<select name="driver_height" id="" class="form-control" required>
									<option value="unsure" <?php if($driv['driver_height']=="unsure"){echo "selected";}?>>Unsure</option>
									<?php
									for($a=130;$a<=196;$a++){
										$h=$a.'cm'; ?>
										<option <?php if($driv['driver_height']=="$h"){echo "selected";}?> value="<?php echo $a.'cm'; ?>"><?php echo $a; ?>cm</option>
										<?php 
									} ?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Blood Type</label>
								<select class="form-control" name="driver_blood_type" required>
									<option <?php if($driv['driver_blood_type']=="Unsure"){echo "selected";} ?> value="Unsure">Unsure</option>
									<option <?php if($driv['driver_blood_type']=="O-"){echo "selected";} ?> value="O-">O-</option>
									<option <?php if($driv['driver_blood_type']=="O+"){echo "selected";} ?> value="O+">O+</option>
									<option <?php if($driv['driver_blood_type']=="A-"){echo "selected";} ?> value="A-">A-</option>
									<option <?php if($driv['driver_blood_type']=="A+"){echo "selected";} ?> value="A+">A+</option>
									<option <?php if($driv['driver_blood_type']=="B-"){echo "selected";} ?> value="B-">B-</option>
									<option <?php if($driv['driver_blood_type']=="B+"){echo "selected";} ?> value="B+">B+</option>
									<option <?php if($driv['driver_blood_type']=="AB-"){echo "selected";} ?> value="AB-">AB-</option>
									<option <?php if($driv['driver_blood_type']=="AB+"){echo "selected";} ?> value="AB+">AB+</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="">Contact Number</label>
								<input type="text" name="driver_contact" class="form-control" value="<?php echo $driv['driver_contact'];?>">
							</div>
							<div class="form-group">
								<label for="">TIN Number</label>
								<input type="text" disabled class="form-control" value="<?php echo $driv['driver_tin'];?>">
							</div>
							<div class="form-group">
								<label for="">Licence</label>
								<input type="text" disabled class="form-control" value="<?php echo $driv['driver_licence'];?>">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input type="text" disabled class="form-control" value="<?php echo $driv['driver_email'];?>">
							</div>
						</div>
					</div>
					<hr>
					<h4>Emergency Contact</h4>
					<?php
					$sql = mysqli_query($conn,"SELECT * FROM official_authorized_driver_emergency_contact_table WHERE driver_id='$driver_id'");
					$auth_cont=mysqli_fetch_assoc($sql); ?>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="">Emergency Contact</label>
								<input type="text" value="<?php echo $auth_cont['driver_emergency_name']; ?>" class="form-control" name="driver_emergency_name">
							</div>
							<div class="form-group">
								<label for="">Contact Number</label>
								<input type="text" value="<?php echo $auth_cont['driver_emergency_contact']; ?>" class="form-control" name="driver_emergency_contact">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="">Address</label>
								<input type="text" value="<?php echo $auth_cont['driver_emergency_address']; ?>" class="form-control" name="driver_emergency_address">
							</div>
							<div class="form-group">
								<label for="">Relationship</label>
								<input type="text" value="<?php echo $auth_cont['driver_emergency_relationship']; ?>" class="form-control" name="driver_emergency_relationship">
							</div>
						</div>
					</div>
					<hr>
					<input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
					<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
					<button class="btn btn-success" name="savech" type="submit">Save Changes</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
require "footer.php";