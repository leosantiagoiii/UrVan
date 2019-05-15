<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
}
else{
	require "header.php";
	require "../includes/dbconnect.inc.php";

	$member_id=$_GET['member_id'];
	$member_details=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
	$member_d=mysqli_fetch_assoc($member_details); ?>

	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Membership Overview</li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
			<?php echo $_GET['member_id'];?></div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-4 mb-2">
						<div class="card" style="padding:17px;">
							<h4 style="line-height:50px;"><?php echo $member_d['member_first_name'].' '.$member_d['member_middle_name'].' '.$member_d['member_last_name'];?></h4>
							<p style="line-height:5px;"><b>Address:</b> <?php echo $member_d['member_address'];?></p>
							<p style="line-height:5px;"><b>Contact Number:</b> <?php echo $member_d['member_phone_number'];?></p>
							<p style="line-height:5px;"><b>Birthdate:</b> <?php echo DATE("Y M d",strtotime($member_d['member_birthdate']));?></p>
							<hr>
							<br>
							<p style="line-height:5px;"><b>Civil Status:</b> <?php echo $member_d['member_civil_status'];?></p>
							<p style="line-height:5px;"><b>Blood Type:</b> <?php echo $member_d['member_blood_type'];?></p>
							<p style="line-height:5px;"><b>Weight:</b> <?php echo $member_d['member_weight'];?></p>
							<p style="line-height:5px;"><b>Height:</b> <?php echo $member_d['member_height'];?></p>
							<p style="line-height:5px;"><b>TIN:</b> <?php echo $member_d['member_tin'];?></p>
							<p style="line-height:5px;"><b>Driver's Licence:</b> <?php echo $member_d['member_drivers_licence'];?></p>
							<p style="line-height:5px;"><b>Username:</b> <?php echo $member_d['member_username'];?></p>
							<p style="line-height:5px;"><b>Email:</b> <a href="mailto:<?php echo $member_d['member_email'];?>"><?php echo $member_d['member_email'];?></a></p>
						</div>
					</div>
					<div class="col-lg-4 mb-2">
						<div class="card mb-2" style="padding:17px;">
							<h4>Reward Points: <u>5.5</u> </h4>
							<h5>Avg. Rating: <u>5.5</u> </h5>
							<hr>
							<br>
							<?php
							$sql_c=mysqli_query($conn,"SELECT * FROM `official_member_emergency_contact_table` WHERE member_id='$member_id'");
							$emergency=mysqli_fetch_assoc($sql_c); ?>
							<p style="line-height:5px;"><b>Emergency Contact:</b> <?php echo $emergency['member_emergency_name'];?></p>
							<p style="line-height:5px;"><b>Address:</b> <?php echo $emergency['member_emergency_address'];?></p>
							<p style="line-height:5px;"><b>Contact Number:</b> <?php echo $emergency['member_emergency_phone'];?></p>
							<p style="line-height:5px;"><b>Relationship:</b> <?php echo $emergency['member_emergency_relationship'];?></p>
						</div>
						<div class="card" style="padding:17px;">
							<?php
							$sql_a=mysqli_query($conn,"SELECT COUNT(*) as num_of_driv FROM official_authorized_driver_table WHERE member_id='$member_id'");
							$count_driv=mysqli_fetch_assoc($sql_a); ?>
							<h4 style="line-height:5px;" class="mb-4 mt-3">
								Drivers: 
								<?php 
								if($count_driv['num_of_driv']<=0){
									echo 'No drivers</h4>';
								}
								else{
									echo $count_driv['num_of_driv'].'</h4>';
									$i=0;
									$sql_b=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id='$member_id'");
									while($drivers=mysqli_fetch_assoc($sql_b)){
										$i++; ?>
										<p style="line-height:5px;"><b><?php echo $i; ?>.</b> <?php echo $drivers['driver_name'];?></p>
										<?php
									}
								}
							$vehi=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE member_id='$member_id'");
							$vehicle_count=mysqli_num_rows($vehi); ?>
							<h4 style="line-height:5px;" class="mb-4 mt-3">
								Vehicles: 
								<?php
								if($vehicle_count<=0){
									echo "N/A";
								}
								else{
									echo $vehicle_count;
								} ?>
							</h4>
							<?php
							if($vehicle_count>0){
								$i=0;
								while($vehicle_deter=mysqli_fetch_assoc($vehi)){
									$i++; ?>
									<p style="line-height:5px;">
										<?php echo $i.'. '.$vehicle_deter['plate_number'].' - <b>'.$vehicle_deter['franchised'].'</b>'; ?>
									</p>
									<?php
								}
							} ?>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="card" style="padding:17px;">
							<img src="<?php
							if($member_d['member_profile_pic']==null){
								echo 'https://www.w3schools.com/howto/img_avatar.png';
							}
							else{
								echo 'includes/'.$member_d['member_profile_pic'];
							} ?>
							" style="border-radius: 100%;height:300px;object-fit:cover;border-width:0.5px; border-color: black;border-style: solid">
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer small text-muted">Member since <?php echo DATE("Y M d H:i:s",strtotime($member_d['member_created_at']));?></div>
		</div>

	</div>

	<?php
	require "footer.php";
}