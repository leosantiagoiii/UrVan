<?php session_start();
if(!isset($_SESSION['driverid'])){
	header("Location:index.php?entry=error");
	exit();
}
else{
	require "header.php";?>
	<main>
		<div class="container-fluid">
				<div class="mt-3 mb-3 card" style="padding:30px;">
					<div class="row">
						<div class="col-lg-6">
							<h3>Hello, <?php echo $_SESSION['drivername'];?>!</h3>
							<h6>You are a&nbsp;
								<?php
								if($_SESSION['type']=="MEMBER"){
									echo "a member of BTTSC";
								}
								if($_SESSION['type']=="DRIVER"){
									$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$_SESSION[driverid]'");
									$res=mysqli_fetch_assoc($sql);
									$affiliatedDrivID=$res['member_id'];
									$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$affiliatedDrivID'");
									$res=mysqli_fetch_assoc($sql);
									$nameOfAffiliatedMem=$res['member_first_name'].' '.$res['member_last_name'];
									echo "an authorised member of ".$nameOfAffiliatedMem."'s";
								} ?>
							</h6>
							<?php 
							if($_SESSION['type']=="MEMBER"){
								$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[driverid]'");
								$offMem=mysqli_fetch_assoc($sql); ?>
								<form method="post">
									<div class="row form-group">
										<div class="col-lg-4">
											<label for="">First</label>
											<input type="text" name="" id="" class="form-control" disabled  value="<?php echo $offMem['member_first_name'];?>">
										</div>
										<div class="col-lg-4">
											<label for="">Middle</label>
											<input type="text" name="" id="" class="form-control" disabled  value="<?php echo $offMem['member_middle_name'];?>">
										</div>
										<div class="col-lg-4">
											<label for="">Last</label>
											<input type="text" name="" id="" class="form-control" disabled  value="<?php echo $offMem['member_last_name'];?>">
										</div>
									</div>
								</form>
								<?php
							} ?>
							<?php 
							if($_SESSION['type']=="DRIVER"){ ?>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$_SESSION[driverid]'");
								$row=mysqli_fetch_assoc($sql); ?>
								<form method="post" action="includes/offic_driv.inc.php">
									<div class="row form-group">
										<div class="col-lg-6">
											<label for="">Name</label>
											<input type="text" name="driName" id="" class="form-control" value="<?php echo $row['driver_name']; ?>">
										</div>
										<div class="col-lg-6">
											<label for="">Email</label>
											<input type="text" disabled="" id="" class="form-control" value="<?php echo $row['driver_email']; ?>">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-lg-6">
											<label for="">Old Password</label>
											<input type="password" name="oldPw" id="" class="form-control">
										</div>
										<div class="col-lg-6">
											<label for="">New Password</label>
											<input type="password" name="newPw" id="" class="form-control">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-lg-12">
											<input type="hidden" name="driver_id" value="<?php echo $_SESSION['driverid'];?>">
											<button class="btn btn-primary" type="submit" name="savec">Save Changes</button>
										</div>
									</div>
								</form>
								<?php
							} ?>
						</div>
						<div class="col-lg-3">
							<?php
							if($_SESSION['type']=="DRIVER"){?>
								<form action="includes/auth_driv_imgUpload.inc.php" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<input type="hidden" name="driver_id" value="<?php echo $_SESSION['driverid'];?>">
										<div class="card" style="border-style:solid;border-width: 1px;padding:10px;">
											<input type="file" name="profilePicAuthDriv">
										</div>
									</div>
									<button class="btn btn-success" name="uploadProfPic">Upload</button>
								</form>
								<?php
							}
							else { ?>
								<div class="card" style="padding:30px;">
									<h3>In order to change your settings, proceed to your member account. Logout and proceed there.</h3>
									<h4>Thank you.</h4>
								</div>
								<?php
							} ?>
						</div>
						<div class="col-lg-3">
							<div class="card" style="padding:20px;">
								<?php
								if($_SESSION['type']=="DRIVER"){
									$sql=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$_SESSION[driverid]'");
									$row=mysqli_fetch_assoc($sql); ?>
									<img src="<?php
									if($row['driver_profile_pic']==null){
										echo 'https://www.w3schools.com/howto/img_avatar.png';
									}
									else{
										echo 'includes/'.$row['driver_profile_pic'];
									} ?>
									" style="border-radius: 100%;height:300px;object-fit:cover;border-width:0.5px; border-color: black;border-style: solid">
									<?php
								}
								else{
									$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[driverid]'");
									$row=mysqli_fetch_assoc($sql); ?>
									<img src="<?php
									if($row['member_profile_pic']==null){
										echo 'https://www.w3schools.com/howto/img_avatar.png';
									}
									else{
										echo 'includes/'.$row['member_profile_pic'];
									} ?>
									" style="border-radius: 100%;height:300px;object-fit:cover;border-width:0.5px; border-color: black;border-style: solid">
									<?php
								} ?>
							</div>
						</div>
					</div>
				</div>
		</div>
	</main>
	<?php
	require "footer.php";
}