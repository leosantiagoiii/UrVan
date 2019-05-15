<?php require "header.php"; ?>
<main style="margin-top:20px;margin-bottom:20px;font-family:gravity;">
	<div class="container-fluid">
		<?php if(isset($_SESSION['memberapprovalacctid'])){ ?>
		<?php $sql="SELECT * FROM member_appointment_details_table WHERE member_appointment_number=$_SESSION[memberapprovalacctid]";
		$res=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($res)){
			$member_appointment_approval=$row['member_appointment_approval'];
			$member_appointment_datemeet_before=$row['member_appointment_datemeet'];
		$member_appointment_timemeet_before=$row['member_appointment_timemeet']; ?>
		<div class="alert alert-warning" role="alert" style="font-size:20px;">
			<strong>Note:</strong> Other modifications are only enabled when you are an official member of BTTSC
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-lg-7">
				<form action="includes/membership_approval_changes.inc.php" method="post">
					<!-- <div class="form-group">
						<input class="form-control" type="text" value="<?php //echo $row['member_appointment_first_name'].' '.$row['member_appointment_middle_name'].' '.$row['member_appointment_last_name']; ?>" readonly>
					</div> -->
					<div class="row form-group">
						<div class="col">
							<input type="text" class="form-control" value="<?php echo $row['member_appointment_first_name'];?>" placeholder="First name" name="member_appointment_first_name">
						</div>
						<div class="col">
							<input type="text" class="form-control" value="<?php echo $row['member_appointment_middle_name'];?>" placeholder="Middle name" name="member_appointment_middle_name">
						</div>
						<div class="col">
							<input type="text" class="form-control" value="<?php echo $row['member_appointment_last_name'];?>" placeholder="Last name" name="member_appointment_last_name">
						</div>
					</div>
					<div class="form-group">
						<textarea class="form-control" placeholder="Address" name="member_appointment_address" id="" cols="30" rows="5"><?php echo $row['member_appointment_address'];?></textarea>
					</div>
					<div class="form-group row">
						<div class="col">
							<input class="form-control" type="date" value="<?php echo $row['member_appointment_birthdate'];?>" name="member_appointment_birthdate">
						</div>
						<div class="col">
							<select name="member_appointment_civil_status" class="form-control">
								<option value="Single" <?php if($row['member_appointment_civil_status']=='Single'){
																			echo 'selected';
									} ?>>
									Single
								</option>
								<option value="Married" <?php if($row['member_appointment_civil_status']=='Married'){
																			echo 'selected';
									} ?>>
									Married
								</option>
								<option value="Divorced" <?php if($row['member_appointment_civil_status']=='Divorced'){
																			echo 'selected';
									} ?>>
									Divorced
								</option>
								<option value="Separated" <?php if($row['member_appointment_civil_status']=='Separated'){
																			echo 'selected';
									} ?>>
									Separated
								</option>
								<option value="Widowed" <?php if($row['member_appointment_civil_status']=='Widowed'){
																			echo 'selected';
									} ?>>
									Widowed
								</option>
							</select>
						</div>
						<div class="col">
							<select name="member_appointment_blood_type" class="form-control">
								<option value="Unsure" <?php if($row['member_appointment_blood_type']=='Unsure'){
																			echo 'selected';
									} ?>>
									Unsure
								</option>
								<option value="O-" <?php if($row['member_appointment_blood_type']=='O-'){
																			echo 'selected';
									} ?>>
									O-
								</option>
								<option value="O+" <?php if($row['member_appointment_blood_type']=='O+'){
																			echo 'selected';
									} ?>>
									O+
								</option>
								<option value="A-" <?php if($row['member_appointment_blood_type']=='A-'){
																			echo 'selected';
									} ?>>
									A-
								</option>
								<option value="A+" <?php if($row['member_appointment_blood_type']=='A+'){
																			echo 'selected';
									} ?>>
									A+
								</option>
								<option value="B-" <?php if($row['member_appointment_blood_type']=='B-'){
																			echo 'selected';
									} ?>>
									B-
								</option>
								<option value="B+" <?php if($row['member_appointment_blood_type']=='B+'){
																			echo 'selected';
									} ?>>
									B+
								</option>
								<option value="AB-" <?php if($row['member_appointment_blood_type']=='AB-'){
																			echo 'selected';
									} ?>>
									AB-
								</option>
								<option value="AB+" <?php if($row['member_appointment_blood_type']=='AB+'){
																			echo 'selected';
									} ?>>
									AB+
								</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<select name="member_appointment_weight" id="" class="form-control">
								<option value="unsure" <?php if($row['member_appointment_weight']=='unsure'){
																		echo 'selected';
								} ?>>Unsure</option>
								<?php for($a=110;$a<=190;$a++){ ?>
								<option value="<?php echo $a; ?>lb" <?php if($a==$row['member_appointment_weight']){
									echo 'selected';
								} ?>><?php echo $a; ?>lb</option>
								<?php } ?>
							</select>
						</div>
						<div class="col">
							<select name="member_appointment_height" id="" class="form-control">
								<option value="unsure" <?php if($row['member_appointment_height']=='unsure'){
																	echo 'selected';
								} ?>>Unsure</option>
								<?php for($a=130;$a<=196;$a++){ ?>
								<option value="<?php echo $a; ?>cm" <?php if($a==$row['member_appointment_height']){
									echo 'selected';
								}?>><?php echo $a; ?>cm</option>
								<?php } ?>
							</select>
						</div>
						<div class="col">
							<input type="text" class="form-control" name="member_appointment_tin" value="<?php echo $row['member_appointment_tin']; ?>" placeholder="TIN">
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
						<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
						<link rel="stylesheet" href="/resources/demos/style.css">
						<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
						<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	                        <script>
								$(document).ready(function(){
									$.datepicker.setDefaults({
										dateFormat: 'yy-mm-dd'
									});
									$(function(){
										var minDate=new Date(); //
										minDate.setDate(minDate.getDate()+7);
										var maxDate=new Date(); //
										// maxDate.setDate(minDate.getDate()+365);
										console.log(minDate);
										console.log(maxDate);
										$('#metro').datepicker({
											numberOfMonth:1,
											minDate:minDate,
											// maxDate:maxDate, //
										});
									});
								});
							</script>
							<input class="form-control" name="member_appointment_datemeet" id="metro" type="date" value="<?php echo $row['member_appointment_datemeet'];?>" <?php if($row['member_appointment_approval']=='PENDING')
							{echo 'readonly';}
							elseif($row['member_appointment_approval']=='DECLINED')
							{echo 'style="background-color:#fff9ce;"';}
							elseif($row['member_appointment_approval']=='APPROVED')
							{echo 'readonly';} ?> >
						</div>
						<div class="col">
							<input class="form-control" type="time" name="member_appointment_timemeet" value="<?php echo $row['member_appointment_timemeet'];?>" <?php if($row['member_appointment_approval']=='PENDING')
							{echo 'readonly';}
							elseif($row['member_appointment_approval']=='DECLINED')
							{echo 'style="background-color:#fff9ce;"';}
							elseif($row['member_appointment_approval']=='APPROVED')
							{echo 'readonly';} ?> >
						</div>
					</div>
					<div class="form-group row">
						<div class="col">
							<input class="form-control" type="text" name="member_appointment_phone_number" value="<?php echo $row['member_appointment_phone_number']; ?>" placeholder="Phone Number">
						</div>
						<div class="col">
							<input class="form-control" type="text" name="member_appointment_username" value="<?php echo $row['member_appointment_username']; ?>" readonly="">
						</div>
						<div class="col">
							<input class="form-control" type="password" name="member_appointment_password" value="<?php echo $row['member_appointment_password']; ?>">
						</div>
					</div>
					<?php
					$gru=mysqli_query($conn,"SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number=$_SESSION[memberapprovalacctid]");
					$bilang=mysqli_num_rows($gru);
					if($bilang<=0){
					?>
					<!-- required bc 0 drivers -->
					<div class="form-group">
						<input class="form-control" placeholder="DRIVERS LICENCE" type="text" name="member_appointment_drivers_licence"  value="<?php echo $row['member_appointment_drivers_licence']; ?>" required>
					</div>
					<?php } else { ?>
					<!-- not required bc marami drivers -->
					<div class="form-group">
						<input class="form-control" placeholder="DRIVERS LICENCE: Type NONE if you do not wish to be a driver" type="text" name="member_appointment_drivers_licence"  value="<?php echo $row['member_appointment_drivers_licence']; ?>">
					</div>
					<?php } ?>
					<div class="form-group">
						<input class="form-control" placeholder="Email" type="email" name="mem_email"  value="<?php echo $row['mem_email']; ?>" required>
					</div>
					<h2>Emergency Contact Details</h2>
					<?php $aaa="SELECT * FROM member_appointment_emergency_table WHERE member_appointment_number=$_SESSION[memberapprovalacctid]";
							$bbb=mysqli_query($conn,$aaa);
					while($row2=mysqli_fetch_assoc($bbb)){ ?>
					<div class="row form-group">
						<div class="col">
							<input class="form-control" type="text" name="member_appointment_emergency_name" value="<?php echo $row2['member_appointment_emergency_name'];?>" placeholder="Full Name">
						</div>
						<div class="col">
							<input class="form-control" type="text" name="member_appointment_emergency_phone" value="<?php echo $row2['member_appointment_emergency_phone'];?>" placeholder="Phone Number">
						</div>
						<div class="col">
							<input class="form-control" type="text" name="member_appointment_emergency_relationship" value="<?php echo $row2['member_appointment_emergency_relationship'];?>" placeholder="Relationship">
						</div>
					</div>
					<div class="form-group">
						<textarea placeholder="Address" class="form-control" name="member_appointment_emergency_address" id="" cols="30" rows="5"><?php echo $row2['member_appointment_emergency_address'];?></textarea>
					</div>
					<?php } ?>
					<input type="hidden" name="member_appointment_number" value="<?php echo $_SESSION['memberapprovalacctid']; ?>">
					<input type="hidden" name="member_appointment_datemeet_before" value="<?php echo $row['member_appointment_datemeet']; ?>">
					<input type="hidden" name="member_appointment_timemeet_before" value="<?php echo $row['member_appointment_timemeet']; ?>">
					<input class="btn btn-primary" type="submit" value="Save Changes" name="savechanges">
					<input class="btn btn-danger" type="submit" value="Cancel Membership Request" name="CancelRequest" formaction="includes/membership_approval_cancellation.inc.php">
				</form>
				<div class="card" style="margin-top:20px;padding:15px;">
					<?php $x="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number=$_SESSION[memberapprovalacctid]";
					$y=mysqli_query($conn,$x);
					$count=mysqli_num_rows($y);
					if($count<=0){
					echo '<h2>You do not have any authorised drivers</h2>';
					echo '
						<div class="alert alert-primary" role="alert">
								<strong>Note:</strong> If you wish to change this, please wait when you\'re an official member of BTTSC <br>
								Your information will be reviewed so please wait for a confirmation.
						</div>
					';
					}
					else{
					echo '<h2>Authorised Drivers</h2>';?>
					<ul style="margin-top:5px;">
						<?php while($z=mysqli_fetch_assoc($y)){ ?>
						<li style="line-height: 25px;"><a href="signup_member_approval_auth_driv.php?member_appointment_driver_number=<?php echo $z['member_appointment_driver_number']; ?>" style="text-decoration:none;" ><?php echo $z['member_appointment_driver_name']; ?></a></li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-5">
				<div style="border-style:solid;padding:30px;border-width: 1px;background-color:
					<?php if($row['member_appointment_approval']=="PENDING"){
						echo 'grey;';
					}elseif($row['member_appointment_approval']=="APPROVED"){
						echo 'skyblue;';
					}else{
						echo 'pink;';
					} ?>
					" class="text-center">
					<h6>APPOINTMENT:</h6>
					<h2 style="line-height:15px;"><?php echo $row['member_appointment_approval']; ?></h2>
					<?php if($row['member_appointment_approval']=='DECLINED'){
						echo '<h6 style="line-height:17px;margin-bottom:-2px;">Due to scheduling issues. Please change time and date for the appointment</h6>';
					} ?>
				</div>
				<div class="" style="margin-top:15px;">
					Your Photo: <br>
					<?php if(empty($row['member_appointment_profile_pic'])){ ?>
					<form action="includes/upload_profile_pic.inc.php" method="post" enctype="multipart/form-data">
						<input style="margin-top:10px;" class="" type="file" name="image_file" id="fileToUpload">
						<br>
						<button style="margin-top:10px;" type="submit" class="btn btn-block btn-success" name="submitbutton" value="submitbutton">Upload Photo</button>
					</form>
					<?php }
					else{ ?>
					<div class="card" style="padding:30px;">
						<center><img src="includes/<?php echo $row['member_appointment_profile_pic']; ?>" alt="<?php echo $row['member_appointment_first_name']; ?>'s profile pic" style="width:80%;height:400px;object-fit: cover;"></center>
					</div>
					<form action="includes/upload_profile_pic.inc.php" method="post" enctype="multipart/form-data">
						<input style="margin-top:10px;" class="" type="file" name="image_file" id="fileToUpload">
						<div class="btn-group d-flex" style="margin-top:10px;">
							<button type="submit" class="btn btn-danger w-100" name="removebutton" value="removebutton">Remove Photo</button>
							<button type="submit" class="btn btn-success w-100" name="submitbutton" value="submitbutton">Upload Photo</button>
						</div>
					</form>
					<?php } ?>
					<div class="mt-3">
						<div class="alert alert-danger" role="alert" style="font-size:2vh;">
							<b>Reminder: </b>If you do not have any authorized drivers, make sure that you yourself knows how to drive. Be ready to present your official member's licence. In addition, the vehicle to be used should not be older than 2 years prior to the application of membership.
						</div>
					</div>
					<div class="mt-3">
						<div class="alert alert-primary" role="alert" style="font-size:2vh;">
							<b>Please take note</b> that you have to create an email address to be an actual member of BTTSC. Upon the approval for the appointment, don't foget to bring the following:
						<div class="row mt-3">
							<div class="col-lg-4">
								<b>For the Member:</b>
								<ul>
									<li>OR/CR</li>
									<li>The Vehicle's Facial Receipt</li>
									<li>The Vehicle's insurance Copy</li>
									<li>Official Driver's License (if he/she is an Authorized Driver)</li>
									<li>TIN ID</li>
								</ul>
							</div>
							<div class="col-lg-4">
								<b>For the Authorized Driver:</b>
								<ul>
									<li>Official Driver's License</li>
									<li>Brgy. Clearance</li>
									<li>NBI</li>
									<li>Police Clearance</li>
									<li>Residential Certificate (CEDULA)</li>
								</ul>
							</div>
							<div class="col-lg-4">
								<b>For both (Members who are also authorised drivers):</b>
								<ul>
									<li>Bring all</li>
								</ul>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<?php
		}
		}
		else{
		?>
		<div class="koala">
			<div class="container text-center fandra">
				<div class="fandrabelow">
					<h1>Appointment Approval</h1>
					<form action="includes/login_membership_approval.inc.php" method="post">
						<div class="form-group">
							<input class="form-control form-control form-control-lg" style="width:100%;
							<?php
							if(isset($_GET['error'])){
								if($_GET['error']=='wrongusernameorpassword'){
									echo 'background-color:pink;';
								}
							} ?>" name="member_appointment_username" placeholder="Username" type="text"><br>
							<input class="form-control form-control form-control-lg" style="width:100%;
							<?php
							if(isset($_GET['error'])){
								if($_GET['error']=='wrongusernameorpassword'){
									echo 'background-color:pink;';
								}
							} ?>" name="member_appointment_password" placeholder="Password" type="password">
							<br>
							<button type="submit" name="loginbutton" class="btn btn-lg btn-primary btn-block">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</main>
<?php require "footer.php"; ?>