<?php
require "header.php";
if(!isset($_SESSION['memberapprovalacctid'])){
	header("Location:index.php");
	exit();
}else{
	$member_appointment_driver_number=$_GET['member_appointment_driver_number'];
?>
<main style="font-family:gravity;">
	<div class="container-fluid">
		<div style="margin:10px 0;">
			<?php
			$x="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_driver_number='$member_appointment_driver_number'";
			$y=mysqli_query($conn,$x);
			while($z=mysqli_fetch_assoc($y)){
			?>
			<div class="row">
				<div class="col-lg-7">
					<!-- Other Deetz -->
					<div class="form-group">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="signup_member_approval.php">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Authorized Driver</li>
							</ol>
						</nav>
					</div>
					<div class="form-group">
						<h2><?php echo $z['member_appointment_driver_name']; ?></h2>
					</div>
					<form action="includes/membership_authorised_drivers_approval.inc.php" method="post">
						<div class="form-group row">
							<div class="col">
								<input class="form-control" placeholder="Full Name" type="text" name="member_appointment_driver_name" value="<?php echo $z['member_appointment_driver_name']; ?>">
							</div>
							<div class="col">
								<input type="text" class="form-control" name="member_appointment_driver_birthdate" value="<?php echo $z['member_appointment_driver_birthdate']; ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col">
								<select name="member_appointment_driver_civil_status" class="form-control">
									<option value="Single" <?php if($z['member_appointment_driver_civil_status']=='Single'){
																										echo 'selected';
										} ?>>
										Single
									</option>
									<option value="Married" <?php if($z['member_appointment_driver_civil_status']=='Married'){
																										echo 'selected';
										} ?>>
										Married
									</option>
									<option value="Divorced" <?php if($z['member_appointment_driver_civil_status']=='Divorced'){
																										echo 'selected';
										} ?>>
										Divorced
									</option>
									<option value="Separated" <?php if($z['member_appointment_driver_civil_status']=='Separated'){
																										echo 'selected';
										} ?>>
										Separated
									</option>
									<option value="Widowed" <?php if($z['member_appointment_driver_civil_status']=='Widowed'){
																										echo 'selected';
										} ?>>
										Widowed
									</option>
								</select>
							</div>
							<div class="col">
								<select name="member_appointment_driver_weight" id="" class="form-control">
									<option value="unsure" <?php if($z['member_appointment_driver_weight']=='unsure'){
																							echo 'selected';
									} ?>>Unsure</option>
									<?php for($a=110;$a<=190;$a++){ ?>
									<option value="<?php echo $a; ?>lb" <?php if($a==$z['member_appointment_driver_weight']){
										echo 'selected';
									} ?>><?php echo $a; ?>lb</option>
									<?php } ?>
								</select>
							</div>
							<div class="col">
								<select name="member_appointment_driver_height" id="" class="form-control">
									<option value="unsure" <?php if($z['member_appointment_driver_height']=='unsure'){
																						echo 'selected';
									} ?>>Unsure</option>
									<?php for($a=130;$a<=196;$a++){ ?>
									<option value="<?php echo $a; ?>cm" <?php if($a==$z['member_appointment_driver_height']){
										echo 'selected';
									}?>><?php echo $a; ?>cm</option>
									<?php } ?>
								</select>
							</div>
							<div class="col">
								<select name="member_appointment_driver_blood" class="form-control">
									<option value="Unsure" <?php if($z['member_appointment_driver_blood']=='Unsure'){
																								echo 'selected';
										} ?>>
										Unsure
									</option>
									<option value="O-" <?php if($z['member_appointment_driver_blood']=='O-'){
																								echo 'selected';
										} ?>>
										O-
									</option>
									<option value="O+" <?php if($z['member_appointment_driver_blood']=='O+'){
																								echo 'selected';
										} ?>>
										O+
									</option>
									<option value="A-" <?php if($z['member_appointment_driver_blood']=='A-'){
																								echo 'selected';
										} ?>>
										A-
									</option>
									<option value="A+" <?php if($z['member_appointment_driver_blood']=='A+'){
																								echo 'selected';
										} ?>>
										A+
									</option>
									<option value="B-" <?php if($z['member_appointment_driver_blood']=='B-'){
																								echo 'selected';
										} ?>>
										B-
									</option>
									<option value="B+" <?php if($z['member_appointment_driver_blood']=='B+'){
																								echo 'selected';
										} ?>>
										B+
									</option>
									<option value="AB-" <?php if($z['member_appointment_driver_blood']=='AB-'){
																								echo 'selected';
										} ?>>
										AB-
									</option>
									<option value="AB+" <?php if($z['member_appointment_driver_blood']=='AB+'){
																								echo 'selected';
										} ?>>
										AB+
									</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col">
								<input placeholder="TIN" class="form-control" type="text" name="member_appointment_driver_tin" value="<?php echo $z['member_appointment_driver_tin']; ?>" readonly>
							</div>
							<div class="col">
								<input placeholder="Contact #" class="form-control" type="text" name="member_appointment_driver_contact" value="<?php echo $z['member_appointment_driver_contact']; ?>">
							</div>
						</div>
						<div class="form-group">
							<input placeholder="Driver's License" class="form-control" type="text" name="member_appointment_drivers_licence" value="<?php echo $z['member_appointment_drivers_licence']; ?>" required>
						</div>
						<div class="form-group">
							<h3>Emergency Contact</h3>
						</div>
						<?php
						$sjak="SELECT * FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$z[member_appointment_driver_number]";
						$mama=mysqli_query($conn,$sjak);
						while($sasa=mysqli_fetch_assoc($mama)){ ?>
						<div class="form-group row">
							<div class="col">
								<label for="">Full Name</label>
								<input id="fn" class="form-control" type="text" name="member_appointment_driver_emergency_name" value="<?php echo $sasa['member_appointment_driver_emergency_name']; ?>">
							</div>
							<div class="col">
								<label for="">Contact # </label>
								<input type="text" class="form-control" name="member_appointment_driver_emergency_contact" value="<?php echo $sasa['member_appointment_driver_emergency_contact']; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="">Address </label>
							<textarea class="form-control" name="member_appointment_driver_emergency_address" id="" cols="30" rows="3"><?php echo $sasa['member_appointment_driver_emergency_address']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="">Relationship </label>
							<input type="text" class="form-control" name="member_appointment_driver_emergency_relationship" value="<?php echo $sasa['member_appointment_driver_emergency_relationship']; ?>">
						</div>
						<?php } ?>
						<input type="hidden" value="<?php echo $z['member_appointment_driver_number']; ?>" name="member_appointment_driver_number">
						<button type="submit" class="btn btn-primary" name="saveauthdriv" value="saveauthdriv">Save changes</button>
					</form>
				</div>
				<div class="col-lg-5">
					<!-- Profile Pic -->
					<b><?php echo $z['member_appointment_driver_name']; ?>'s Photo<br></b>
					<?php
					if($z['member_appointment_driver_profpic']==null){}
					else{
						echo '
						<div class=\'card\' style=\'padding:20px;\'>
													<center><img style=\'height:450px;width:80%;object-fit:cover;\' src=includes/'.$z['member_appointment_driver_profpic'].'></center>
						</div>
						';}
					?>
					<form action="includes/driver_upload_profilepic.inc.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="member_appointment_driver_number" value="<?php echo $z['member_appointment_driver_number']; ?>">
						<input type="hidden" name="member_appointment_driver_name" value="<?php echo $z['member_appointment_driver_name']; ?>">
						<input style="margin-top:10px;" type="file" name="image_file" id="fileToUpload">
						<button style="margin-top:10px;" class="btn btn-block btn-success" name="uploadp" value="uploadp">Upload</button>
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</main>
<?php
	require_once "footer.php";
}
?>