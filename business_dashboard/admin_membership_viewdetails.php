<?php
session_start();
// put license
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?request=error");
	exit();
}else{
require "header.php";
require "../includes/dbconnect.inc.php";
$member_appointment_number=$_GET['member_appointment_number']; ?>
<main style="margin-bottom: 30px;">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="admin_membership_requests.php">Membership Requests</a>
			</li>
			<li class="breadcrumb-item active">More Details</li>
		</ol>
		<div style="margin:10px 0;" class="row">
			<div class="col-lg-7">
				<form action="../includes/membership_verdict.inc.php" method="post">
					<?php $aa="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
					$bb=mysqli_query($conn,$aa);
					while($row=mysqli_fetch_assoc($bb)) {
					$member_appointment_approval=$row['member_appointment_approval'];
					} ?>
					<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
					<?php $sql="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
					$result=mysqli_query($conn,$sql);
					while($roww=mysqli_fetch_assoc($result)){ ?>
					<div class="form-group row">
						<div class="col">
							<h1><?php echo $roww['member_appointment_first_name']; ?> <?php echo $roww['member_appointment_last_name']; ?></h1>
						</div>
					</div>
					<div class="form-group">
						<b>Desired Date: </b><?php echo $roww['member_appointment_timemeet'];?> //
						<b>Desired Time: </b><?php echo $roww['member_appointment_datemeet'];?>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">First Name</label>
							<input class="form-control" type="text" name="member_appointment_first_name" value="<?php echo $roww['member_appointment_first_name']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
						<div class="col">
							<label for="">Middle Name</label>
							<input class="form-control" type="text" name="member_appointment_middle_name" value="<?php echo $roww['member_appointment_middle_name']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';} ?> >
						</div>
						<div class="col">
							<label for="">Last Name</label>
							<input class="form-control" type="text" name="member_appointment_last_name" value="<?php echo $roww['member_appointment_last_name']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">Birthdate</label>
							<input class="form-control" type="date" name="member_appointment_birthdate" value="<?php echo $roww['member_appointment_birthdate']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
						<div class="col">
							<label for="">Phone Number</label>
							<input class="form-control" type="text" name="member_appointment_phone_number" value="<?php echo $roww['member_appointment_phone_number']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
					</div>
					<div class="form-group">
						<label for="">Address</label>
						<textarea class="form-control" name="member_appointment_address" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> cols="30" rows="2"><?php echo $roww['member_appointment_address']; ?></textarea>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">Civil Status</label>
							<input class="form-control" type="text" name="member_appointment_civil_status" value="<?php echo $roww['member_appointment_civil_status']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
						<div class="col">
							<label for="">Blood Type</label>
							<input class="form-control" type="text" name="member_appointment_blood_type" value="<?php echo $roww['member_appointment_blood_type']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">Weight</label>
							<input class="form-control" type="text" name="member_appointment_weight" value="<?php echo $roww['member_appointment_weight']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
						<div class="col">
							<label for="">Height</label>
							<input class="form-control" type="text" name="member_appointment_height" value="<?php echo $roww['member_appointment_height']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
						<div class="col">
							<label for="">TIN</label>
							<input class="form-control" type="text" name="member_appointment_tin" value="<?php echo $roww['member_appointment_tin']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?>>
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">Driver's License</label>
							<input class="form-control" type="text" name="member_appointment_drivers_licence" value="<?php echo $roww['member_appointment_drivers_licence']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?>>
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<label for="">Email</label>
							<input class="form-control" type="email" name="member_email" value="<?php echo $roww['mem_email']; ?>" <?php if($member_appointment_approval=='PENDING'){echo 'readonly';}elseif($member_appointment_approval=='APPROVED'){echo 'required';} ?> >
						</div>
					</div>
					<?php } ?>

					<div class="btn-group">
						<?php if($member_appointment_approval=='APPROVED') { ?>
						<input class="btn btn-success" type="submit" name="ApproveButton" value="Apprsove">
						<input class="btn btn-primary" type="submit" name="FollowupButton" value="Followup">
						<input class="btn btn-danger" type="submit" name="DenyButton" value="Deny">
						<?php }elseif($member_appointment_approval=='PENDING'){ ?>
						<button class="btn btn-success" type="submit" name="ApproveAppointment" value="ApproveAppointment">Approve Appointment</button>
						<button class="btn btn-warning" type="submit" name="ReschedAppoint" value="ReschedAppoint">Reschedule Appointment</button>
						<button class="btn btn-danger" type="submit" name="DenyAppointment" value="DenyAppointment">Deny Appointment</button>
						<?php } ?>
					</div>
				</form>
			</div>
			<div class="col-lg-5" >
				<form class="card" style="padding: 20px;" action="../includes/upload_profile_pic.inc.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
					<?php $sql_="SELECT * FROM member_appointment_details_table WHERE member_appointment_number='$member_appointment_number'";
					$res_=mysqli_query($conn,$sql_);
					while($row_=mysqli_fetch_assoc($res_)){
						$member_appointment_profile_pic=$row_['member_appointment_profile_pic'];
						$approval=$row_['member_appointment_approval'];
					}
					if($approval=='APPROVED'){
						if(empty($member_appointment_profile_pic)){
					echo '<h3>No picture</h3>';?>
					<input type="file" name="image_file">
					<button style="margin-top:10px;" class="btn btn-block btn-success" type="submit" name="upload" value="upload">Upload Photo</button>
					<?php }
					else{ ?>
					<center><img src="../includes/<?php echo $member_appointment_profile_pic; ?>" style="width:80%;height:400px;object-fit: cover;"></center>
					<br>
					<input type="file" name="image_file">
					<div class="btn-group d-flex" style="margin-top:10px;">
						<input class="btn btn-danger w-100" type="submit" name="remove" value="Remove Photo">
						<button class="btn btn-success w-100" type="submit" name="upload" value="upload">Upload Photo</button>
					</div>
					<?php }
					} else { ?>
					<?php if(empty($member_appointment_profile_pic)){ ?>
					<h3>No Profile Picture</h3>
					<?php } else { ?>
					<center><img src="../includes/<?php echo $member_appointment_profile_pic; ?>" style="width:80%;height:400px;object-fit: cover;"></center>
					<?php } ?>
					<?php } ?>
				</form>
				<div class="form-group row" style="margin-top:20px;">
					<div class="col">
						<?php $skaksa="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
						$re=mysqli_query($conn,$skaksa);
						$coun=mysqli_num_rows($re);
						if($coun>=1){ ?>
							<h2>Authorised Drivers</h2>
							<?php
							while($lolzz=mysqli_fetch_assoc($re)){
								?>
								<div class="form-group row" style="width:100%">
									<div class="col-sm-7">
										<b><?php echo $lolzz['member_appointment_driver_name']; ?></b><br>
										<?php if($member_appointment_approval=='APPROVED'){ ?>
										<small>
											<form action="../includes/save_auth_drivers.inc.php" method="POST">
												<a href="admin_driver_edit.php?mem_id=<?php echo $lolzz['member_appointment_number'];?>&member_appointment_driver_number=<?php echo $lolzz['member_appointment_driver_number'];?>">
													<button type="button" class="btn" style="font-size:10px;">Edit</button>
												</a>
												<input type="hidden" name="member_appointment_number" value="<?php echo $lolzz['member_appointment_number'];?>">
												<input type="hidden" name="member_appointment_driver_number" value="<?php echo $lolzz['member_appointment_driver_number']; ?>">
												<button class="btn" type="submit" name="removechanges_1" style="font-size:10px;">Remove</button>
											</form>
										</small>
										<?php } ?>
										<pre>TIN#<?php echo $lolzz['member_appointment_driver_tin'];?><br>Contact#<?php echo $lolzz['member_appointment_driver_contact'];?><br>Driver's License <?php echo $lolzz['member_appointment_drivers_licence'];?></pre>
									</div>
									<div class="col-sm-5">
										<?php
										if($lolzz['member_appointment_driver_profpic']==NULL){echo '';}
										else {
										?>
										<img style="width:100%;height:190px;object-fit:cover;" src="../includes/<?php echo $lolzz['member_appointment_driver_profpic']; ?>" alt="">
										<?php } ?>
									</div>
								</div>
								<?php
							}
						}else{?>
							<h3>Authorized Drivers</h3>
							<pre>No Authorized Drivers</pre>
						<?php }?>
						<?php if($member_appointment_approval=='APPROVED'){ ?>
						<form action="add_auth_drivers.php" method="POST">
							<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
							<button class="btn btn-primary btn-block" name="addauthdriv">Add Auth. Drivers</button>
						</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
require "footer.php";
} ?>