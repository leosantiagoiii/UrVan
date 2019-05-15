<?php
session_start();
// put license
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}else{
require "header.php";
require "../includes/dbconnect.inc.php";
$member_appointment_number=$_GET['mem_id'];
$member_appointment_driver_number=$_GET['member_appointment_driver_number'];
$sql="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($res);
?>
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
				<a href="admin_membership_viewdetails.php?member_appointment_number=<?php echo $member_appointment_number;?>">Member Details</a>
			</li>
			<li class="breadcrumb-item active">Auth. Drivers</li>
		</ol>
		<form action="../includes/save_auth_drivers.inc.php" method="POST">
			<div style="margin:10px 0;" class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="">Full Name:</label>
						<input type="text" class="form-control" value="<?php echo $row['member_appointment_driver_name'];?>" name="member_appointment_driver_name">
					</div>
					<div class="form-group">
						<label for="">Birthdate:</label>
						<input type="text" class="form-control" value="<?php echo $row['member_appointment_driver_birthdate'];?>" name="member_appointment_driver_birthdate">
					</div>
					<div class="form-group">
						<label for="">Civil Status</label>
						<select class="form-control" required name="member_appointment_driver_civil_status">
							<option active>---</option>
							<option value="Single" <?php if($row['member_appointment_driver_civil_status']=="Single"){echo 'selected';}?> >Single</option>
							<option value="Married" <?php if($row['member_appointment_driver_civil_status']=="Married"){echo 'selected';}?> >Married</option>
							<option value="Divorced" <?php if($row['member_appointment_driver_civil_status']=="Divorced"){echo 'selected';}?> >Divorced</option>
							<option value="Separated" <?php if($row['member_appointment_driver_civil_status']=="Separated"){echo 'selected';}?> >Separated</option>
							<option value="Widowed" <?php if($row['member_appointment_driver_civil_status']=="Widowed"){echo 'selected';}?> >Widowed</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Weight (lb)</label>
						<select id="" class="form-control" required name="member_appointment_driver_weight">
							<option value="">---</option>
							<option value="unsure" <?php if($row['member_appointment_driver_weight']=="unsure"){echo 'selected';}?> >Unsure</option>
							<?php for($a=110;$a<=190;$a++){ ?>
							<option value="<?php echo $a; ?>lb" <?php if($row['member_appointment_driver_weight']==$a){echo 'selected';}?> ><?php echo $a; ?>lb</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="">Height (cm)</label>
						<select id="" class="form-control" required name="member_appointment_driver_height">
							<option value="">---</option>
							<option value="unsure">Unsure</option>
							<?php for($a=130;$a<=196;$a++){ ?>
							<option value="<?php echo $a; ?>cm" <?php if($row['member_appointment_driver_height']==$a){echo 'selected';}?> ><?php echo $a; ?>cm</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="">Blood Type</label>
						<select class="form-control" required name="member_appointment_driver_blood">
							<option value="">---</option>
							<option value="Unsure" <?php if($row['member_appointment_driver_blood']=="Unsure"){echo 'selected';}?> >Unsure</option>
							<option value="O-" <?php if($row['member_appointment_driver_blood']=="O-"){echo 'selected';}?> >O-</option>
							<option value="O+" <?php if($row['member_appointment_driver_blood']=="O+"){echo 'selected';}?> >O+</option>
							<option value="A-" <?php if($row['member_appointment_driver_blood']=="A-"){echo 'selected';}?> >A-</option>
							<option value="A+" <?php if($row['member_appointment_driver_blood']=="A+"){echo 'selected';}?> >A+</option>
							<option value="B-" <?php if($row['member_appointment_driver_blood']=="B-"){echo 'selected';}?> >B-</option>
							<option value="B+" <?php if($row['member_appointment_driver_blood']=="B+"){echo 'selected';}?> >B+</option>
							<option value="AB-" <?php if($row['member_appointment_driver_blood']=="AB-"){echo 'selected';}?> >AB-</option>
							<option value="AB+" <?php if($row['member_appointment_driver_blood']=="AB+"){echo 'selected';}?> >AB+</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="">TIN</label>
						<input type="text" class="form-control" value="<?php echo $row['member_appointment_driver_tin'];?>" name="member_appointment_driver_tin">
					</div>
					<div class="form-group">
						<label for="">License Num.</label>
						<input type="text" class="form-control" value="<?php echo $row['member_appointment_drivers_licence'];?>" name="member_appointment_drivers_licence">
					</div>
					<div class="form-group">
						<label for="">Contact Number</label>
						<input type="text" class="form-control" value="<?php echo $row['member_appointment_driver_contact'];?>" name="member_appointment_driver_contact">
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" class="form-control" value="<?php echo $row['mem_app_driv_email'];?>" name="mem_app_driv_email" required placeholder="Enter email">
					</div>
					<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
					<input type="hidden" name="member_appointment_driver_number" value="<?php echo $member_appointment_driver_number; ?>">
					<div class="form-group btn-group mt-4">
						<button type="submit" class="btn btn-primary w-100" name="savechanges">Save Changes</button>
						<button type="submit" class="btn btn-danger w-100" name="removechanges">Remove Driver</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</main>
<?php
require "footer.php";
} ?>