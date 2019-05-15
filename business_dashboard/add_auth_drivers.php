<?php
session_start();
// put license
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}else{
require "header.php";
require "../includes/dbconnect.inc.php";
$member_appointment_number=$_POST['member_appointment_number']; ?>
<main style="margin-bottom: 30px;">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="admin_membership_requests.php">Membership Requests</a>
			</li>
			<li class="breadcrumb-item">
				<a href="admin_membership_viewdetails.php?member_appointment_number=<?php echo $member_appointment_number; ?>">More Details</a>
			</li>
			<li class="breadcrumb-item active">Add Auth. Drivers</li>
		</ol>
		<form action="../includes/add_auth_drivers.inc.php" method="POST">
			<div style="margin:10px 0;" class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="">Full Name:</label>
						<input type="text" class="form-control" required name="member_appointment_driver_name">
					</div>
					<div class="form-group">
						<label for="">Birthdate:</label>
						<input type="text" class="form-control" required name="member_appointment_driver_birthdate">
					</div>
					<div class="form-group">
						<label for="">Civil Status</label>
						<select class="form-control" required name="member_appointment_driver_civil_status">
							<option active>---</option>
							<option value="Single">Single</option>
							<option value="Married">Married</option>
							<option value="Divorced">Divorced</option>
							<option value="Separated">Separated</option>
							<option value="Widowed">Widowed</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Weight (lb)</label>
						<select id="" class="form-control" required name="member_appointment_driver_weight">
							<option value="">---</option>
							<option value="unsure">Unsure</option>
							<?php for($a=110;$a<=190;$a++){ ?>
							<option value="<?php echo $a; ?>lb"><?php echo $a; ?>lb</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="">Height (cm)</label>
						<select id="" class="form-control" required name="member_appointment_driver_height">
							<option value="">---</option>
							<option value="unsure">Unsure</option>
							<?php for($a=130;$a<=196;$a++){ ?>
							<option value="<?php echo $a; ?>cm"><?php echo $a; ?>cm</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="">Blood Type</label>
						<select class="form-control" required name="member_appointment_driver_blood">
							<option value="">---</option>
							<option value="Unsure">Unsure</option>
							<option value="O-">O-</option>
							<option value="O+">O+</option>
							<option value="A-">A-</option>
							<option value="A+" >A+</option>
							<option value="B-" >B-</option>
							<option value="B+" >B+</option>
							<option value="AB-" >AB-</option>
							<option value="AB+">AB+</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">TIN</label>
						<input type="text" class="form-control" required  name="member_appointment_driver_tin">
					</div>
					<div class="form-group">
						<label for="">License Num.</label>
						<input type="text" class="form-control" required  name="member_appointment_drivers_licence">
					</div>
					<div class="form-group">
						<label for="">Contact Number</label>
						<input type="text" class="form-control" required name="member_appointment_driver_contact">
					</div>
					<div class="form-group">
						<label for="">Email Address</label>
						<input type="email" class="form-control" required name="mem_app_driv_email">
					</div>
					<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
					<div class="form-group btn-group mt-4">
						<button type="submit" class="btn btn-primary w-100" name="addDriv">Add Auth. Driver</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</main>
<?php
require "footer.php";
} ?>