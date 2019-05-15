<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
$member_id=$_GET['member_id']; ?>

<style>
	p{
		margin-bottom:2px;
		padding:0;
	}
	.imagePopup{
		height:500px;
		padding:10px;
		overflow-y:scroll;
	}
</style>

<div class="container-fluid">
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-line"></i>
			<?php 
			echo $member_id;
			$sql=mysqli_query($conn,"SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
			$row=mysqli_fetch_assoc($sql); ?>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-4">
					<p><b>Name: </b><?php echo $row['member_first_name'].' '.$row['member_last_name'];?></p>
					<p><b>Address: </b><?php echo $row['member_address'];?></p>
					<p><b>Phone Number: </b><?php echo $row['member_phone_number'];?></p>
					<p><b>Birthdate: </b><?php echo $row['member_birthdate'];?></p>
					<p><b>Civil Status: </b><?php echo $row['member_civil_status'];?></p>
					<p><b>Blood Type: </b><?php echo $row['member_blood_type'];?></p>
					<p><b>Weight: </b><?php echo $row['member_weight'];?></p>
					<p><b>Height: </b><?php echo $row['member_height'];?></p>
					<p><b>TIN: </b><?php echo $row['member_tin'];?></p>
					<p><b>Licence: </b><?php echo $row['member_drivers_licence'];?></p>
				</div>
				<?php
				if($_GET["type"]=="A"){//driveroperator ?>
					<div class="col-lg-4">
						<?php
						$sqlA=mysqli_query($conn,"SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
						$rowA=mysqli_fetch_assoc($sqlA); ?>
						<p><b>Emergency Name: </b><?php echo $rowA['member_emergency_name'];?></p>
						<p><b>Address: </b><?php echo $rowA['member_emergency_address'];?></p>
						<p><b>Phone Number: </b><?php echo $rowA['member_emergency_phone'];?></p>
						<p><b>Relationship: </b><?php echo $rowA['member_emergency_relationship'];?></p>
						<!-- drivers -->
					</div>
					<div class="col-lg-4">
						<h3>Driver-Operator (Images)</h3>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg">View Here</button>
						<!-- modal -->
						<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Driver-Operator</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="imagePopup card">
											<h3>OR/CR, Vehicle Facial Receipt, Vehicle Insurance Copy and TIN ID</h3>
											<?php
											$sqlB=mysqli_query($conn,"SELECT * FROM initial_upload WHERE member_id='$member_id'");
											while($rowB=mysqli_fetch_assoc($sqlB)){ ?>
												<img class="card" src="../includes/<?php echo $rowB['init_filepath']; ?>" style="width:100%" alt="">
												<?php
											} ?>
											<hr>
											<h3>Driver's Licence, Barangy Clearance, NBI, Police Clearance and Residential Certificate (Cedula)</h3>
											<?php
											$sqlC=mysqli_query($conn,"SELECT * FROM initial_upload_two WHERE member_id='$member_id'");
											while($rowC=mysqli_fetch_assoc($sqlC)){ ?>
												<img class="card" src="../includes/<?php echo $rowC['init_filepath']; ?>" style="width:100%" alt="">
												<?php
											} ?>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal -->
						<form action="../includes/approve_new_mem.inc.php" method="get">
							<input type="hidden" name="member_email" value="<?php echo $row['member_email']; ?>">
							<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
							<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
							<button type="submit" class="btn btn-block btn-primary mt-3">Approve</button>
						</form>
					</div>
					<?php
				}
				elseif($_GET["type"]=="B"){//driversonly ?>
					<div class="col-lg-4">
						<?php
						$sqlX=mysqli_query($conn,"SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
						$rowX=mysqli_fetch_assoc($sqlX); ?>
						<p><b>Emergency Name: </b><?php echo $rowX['member_emergency_name'];?></p>
						<p><b>Address: </b><?php echo $rowX['member_emergency_address'];?></p>
						<p><b>Phone Number: </b><?php echo $rowX['member_emergency_phone'];?></p>
						<p><b>Relationship: </b><?php echo $rowX['member_emergency_relationship'];?></p>
						<h4>Drivers:</h4>
						<ul>
							<?php 
							$sqlY=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
							while($rowY=mysqli_fetch_assoc($sqlY)){ ?>
								<li><?php echo $rowY['driver_name'];?> - <a href data-toggle="modal" data-target=".driveTings<?php echo $rowY['driver_id']; ?>">View More</a></li>
								<!-- modal -->
								<div class="modal fade driveTings<?php echo $rowY['driver_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Auth. Drivers ONLY (<?php echo $rowY['driver_id'];?>)</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="imagePopup card">
													<div class="row">	
														<div class="col-lg-6">
															<h3>Basic Info</h3>
															<p><b>Birthdate: </b><?php echo $rowY['driver_birthdate'];?></p>
															<p><b>Civil Status: </b><?php echo $rowY['driver_civil_status'];?></p>
															<p><b>Weight: </b><?php echo $rowY['driver_weight'];?></p>
															<p><b>Height: </b><?php echo $rowY['driver_height'];?></p>
															<p><b>Blood Type: </b><?php echo $rowY['driver_blood_type'];?></p>
															<p><b>TIN: </b><?php echo $rowY['driver_tin'];?></p>
															<p><b>Licence: </b><?php echo $rowY['driver_licence'];?></p>
															<p><b>Contact: </b><?php echo $rowY['driver_contact'];?></p>
														</div>
														<div class="col-lg-6">
															<h3>Emergency Details</h3>
															<?php 
															$driver_id = $rowY['driver_id'];
															$sqlO=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_emergency_contact_table WHERE driver_id='$driver_id'");
															$rowO=mysqli_fetch_assoc($sqlO); ?>
															<p><b>Name: </b><?php echo $rowO['driver_emergency_name'];?></p>
															<p><b>Address: </b><?php echo $rowO['driver_emergency_address'];?></p>
															<p><b>Contact No.: </b><?php echo $rowO['driver_emergency_contact'];?></p>
															<p><b>Relationship: </b><?php echo $rowO['driver_emergency_relationship'];?></p>
														</div>
													</div>													
												</div>
												<br>
												<br>
												<br>
												<br>
												<br>
												<div class="row">
													<div class="col-lg-12">
														<h3>Driver's Licence, Barangy Clearance, NBI, Police Clearance and Residential Certificate</h3>
														<?php
														$sqlZ=mysqli_query($conn,"SELECT * FROM initial_upload_three WHERE driver_id='$rowY[driver_id]'");
														while($rowZ=mysqli_fetch_assoc($sqlZ)){ ?>
														<img src="../includes/<?php echo $rowZ['init_filepath']; ?>" style="width:100%" alt="">
														<?php
														} ?>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<!-- modal -->
								<?php
							} ?>
						</ul>
					</div>
					<div class="col-lg-4">
						<h3>Auth. Drivers Only (Images)</h3>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".authDPic">View Here</button>
						<!-- modal -->
						<div class="modal fade authDPic" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Auth. Drivers ONLY</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="imagePopup card">
											<h3>OR/CR, Vehicle Facial Receipt, Vehicle Insurance Copy and TIN ID</h3>
											<?php
											$sqlM=mysqli_query($conn,"SELECT * FROM initial_upload WHERE member_id='$member_id'");
											while($rowM=mysqli_fetch_assoc($sqlM)){ ?>
												<img class="card" src="../includes/<?php echo $rowM['init_filepath']; ?>" style="width:100%" alt="">
												<?php
											} ?>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal -->
						<form action="../includes/approve_new_mem.inc.php" method="get">
							<input type="hidden" name="member_email" value="<?php echo $row['member_email']; ?>">
							<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
							<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
							<button type="submit" class="btn btn-block btn-primary mt-3">Approve</button>
						</form>
					</div>
					<?php
				}
				elseif($_GET["type"]=="C"){//both ?>
					<div class="col-lg-4">
						<?php
						$sqlX=mysqli_query($conn,"SELECT * FROM initial_official_member_emergency_contact_table WHERE member_id='$member_id'");
						$rowX=mysqli_fetch_assoc($sqlX); ?>
						<p><b>Emergency Name: </b><?php echo $rowX['member_emergency_name'];?></p>
						<p><b>Address: </b><?php echo $rowX['member_emergency_address'];?></p>
						<p><b>Phone Number: </b><?php echo $rowX['member_emergency_phone'];?></p>
						<p><b>Relationship: </b><?php echo $rowX['member_emergency_relationship'];?></p>
						<h4>Drivers:</h4>
						<ul>
							<?php 
							$sqlY=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
							while($rowY=mysqli_fetch_assoc($sqlY)){ ?>
								<li><?php echo $rowY['driver_name'];?> - <a href data-toggle="modal" data-target=".driveTings<?php echo $rowY['driver_id']; ?>">View More</a></li>
								<!-- modal -->
								<div class="modal fade driveTings<?php echo $rowY['driver_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Auth. Drivers (<?php echo $rowY['driver_id'];?>)</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="imagePopup card">
													<div class="row">	
														<div class="col-lg-6">
															<h3>Basic Info</h3>
															<p><b>Birthdate: </b><?php echo $rowY['driver_birthdate'];?></p>
															<p><b>Civil Status: </b><?php echo $rowY['driver_civil_status'];?></p>
															<p><b>Weight: </b><?php echo $rowY['driver_weight'];?></p>
															<p><b>Height: </b><?php echo $rowY['driver_height'];?></p>
															<p><b>Blood Type: </b><?php echo $rowY['driver_blood_type'];?></p>
															<p><b>TIN: </b><?php echo $rowY['driver_tin'];?></p>
															<p><b>Licence: </b><?php echo $rowY['driver_licence'];?></p>
															<p><b>Contact: </b><?php echo $rowY['driver_contact'];?></p>
														</div>
														<div class="col-lg-6">
															<h3>Emergency Details</h3>
															<?php 
															$driver_id = $rowY['driver_id'];
															$sqlO=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_emergency_contact_table WHERE driver_id='$driver_id'");
															$rowO=mysqli_fetch_assoc($sqlO); ?>
															<p><b>Name: </b><?php echo $rowO['driver_emergency_name'];?></p>
															<p><b>Address: </b><?php echo $rowO['driver_emergency_address'];?></p>
															<p><b>Contact No.: </b><?php echo $rowO['driver_emergency_contact'];?></p>
															<p><b>Relationship: </b><?php echo $rowO['driver_emergency_relationship'];?></p>
														</div>
													</div>
													<hr>
													<h3>Driver's Licence, Barangy Clearance, NBI, Police Clearance and Residential Certificate</h3>
													<?php
													$sqlZ=mysqli_query($conn,"SELECT * FROM initial_upload_three WHERE driver_id='$rowY[driver_id]'");
													while($rowZ=mysqli_fetch_assoc($sqlZ)){ ?>
														<img src="../includes/<?php echo $rowZ['init_filepath']; ?>" style="width:100%" alt="">
														<?php
													} ?>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<!-- modal -->
								<?php
							} ?>
						</ul>
					</div>
					<div class="col-lg-4">
						<h3>Driver-Operator (Images)</h3>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg">View Here</button>
						<!-- modal -->
						<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Driver-Operator</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="imagePopup card">
											<h3>OR/CR, Vehicle Facial Receipt, Vehicle Insurance Copy and TIN ID</h3>
											<?php
											$sqlB=mysqli_query($conn,"SELECT * FROM initial_upload WHERE member_id='$member_id'");
											while($rowB=mysqli_fetch_assoc($sqlB)){ ?>
												<img class="card" src="../includes/<?php echo $rowB['init_filepath']; ?>" style="width:100%" alt="">
												<?php
											} ?>
											<hr>
											<h3>Driver's Licence, Barangy Clearance, NBI, Police Clearance and Residential Certificate (Cedula)</h3>
											<?php
											$sqlC=mysqli_query($conn,"SELECT * FROM initial_upload_two WHERE member_id='$member_id'");
											while($rowC=mysqli_fetch_assoc($sqlC)){ ?>
												<img class="card" src="../includes/<?php echo $rowC['init_filepath']; ?>" style="width:100%" alt="">
												<?php
											} ?>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- modal -->
						<form action="../includes/approve_new_mem.inc.php" method="get">
							<input type="hidden" name="member_email" value="<?php echo $row['member_email']; ?>">
							<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
							<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
							<button type="submit" class="btn btn-block btn-primary mt-3">Approve</button>
						</form>
					</div>
					<?php
				} ?>
			</div>
		</div>
	</div>
</div>

<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>