<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php"; ?>

	<main>


		<div class="container-fluid">

			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="index.php">Dashboard</a>
				</li>
				<li class="breadcrumb-item active">Active Authorized Drivers</li>
			</ol>

			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-truck-monster"></i>
					Active Authorized Drivers
				</div>
				<div class="card-body">

					<div class="table-responsive">

						<table class="table" id="dataTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Affiliation</th>
									<th>Licence</th>
									<th>Email</th>
									<th>Avg. Rating</th>
									<th>Options</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Affiliation</th>
									<th>Licence</th>
									<th>Email</th>
									<th>Avg. Rating</th>
									<th>Options</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
								//active means 0, deactive 1
								$ratingARR=array();
								$off_mem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE active='0' AND member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1')");
								while($row=mysqli_fetch_assoc($off_mem)){
									$member_id=$row['member_id'];
									$auth_driv=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id='$member_id'");
									while($row2=mysqli_fetch_assoc($auth_driv)){ ?>
										<tr>
											<td><?php echo $row2['driver_id'];?></td>
											<td><?php echo $row2['driver_name'];?></td>
											<td><?php echo $row['member_id'].'<br>('.$row['member_first_name']." ".$row['member_last_name'].')';?></td>
											<td><?php echo $row2['driver_licence'];?></td>
											<td><?php echo $row2['driver_email'];?></td>
											<td>
												<?php
												$sqi=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$row2[driver_id]'");
												while($reu=mysqli_fetch_assoc($sqi)){
													$history_id = $reu['history_id'];
													$smi=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE history_id='$history_id' AND value IS NOT NULL");
													while($roi=mysqli_fetch_assoc($smi)){
														$ratingARR[]=$roi['value'];
													}
												} 
												if(!isset($ratingARR)){
													$sum=0;
													$size=0;
												}
												else{
													$sum = array_sum($ratingARR);
													$size = sizeof($ratingARR);
												}
												if($sum<=0 OR $size<=0){
													echo $finalAns = "No ratings yet";
												}
												else{
													echo $finalAns = number_format((($sum/$size)),2);
												} ?>
											</td>
											<td>
												<button type="button" data-toggle="modal" data-target="#driv<?php echo $row2['driver_id']; ?>" class="btn btn-primary btn-block">View More</button>

												<!-- Modal -->
												<div class="modal fade bd-example-modal-lg" id="driv<?php echo $row2['driver_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel"><?php echo $row2['driver_name'].' ('.$row2['driver_id'].')';?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">

																<div class="row form-group">
																	<div class="col-lg-4">
																		<div class="row form-group">
																			<div class="col-lg-12">
																				<?php
																				if($row2['driver_profile_pic']==null){ ?>
																					<img src="https://www.w3schools.com/howto/img_avatar.png" style="width:100%;border-radius: 50%" alt="">
																					<?php
																				}
																				else{ ?>
																					<img src="../includes/<?php echo $row2['driver_profile_pic']; ?>" style="width:100%;border-radius: 0%" alt="">
																					<?php
																				} ?>
																			</div>
																		</div>
																		<div class="row form-group">
																			<div class="col-lg-12">
																				<center>
																					<label style="font-weight: 500;">EMAIL: </label>
																					<?php
																					echo $row2['driver_email']; ?>
																					<!-- stars rating -->
																					<h1>
																						<?php 
																						if($finalAns=="No ratings yet"){
																							echo "No ratings yet";
																						}
																						else{
																							echo ($finalAns).' points'; ?>
																							<br>
																							<a style="font-size:20px;" target="_blank" href="ratingFor.php?driver_pk=<?php echo $row2['driver_id'] ?>&type=AUTH_DRIV&name=<?php echo $row2['driver_name']; ?>">See More</a>
																							<?php
																						} ?>
																					</h1>
																				</center>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-8">
																		<div class="row form-group">
																			<div class="col-lg-6">
																				<label style="font-weight: 500;">Name: </label><br>
																				<?php echo $row2['driver_name']; ?>
																			</div>
																			<div class="col-lg-6">
																				<label style="font-weight: 500;">Contact no.: </label><br>
																				<?php echo $row2['driver_contact'];?>
																			</div>
																		</div>
																		<div class="row form-group">
																			<div class="col-lg-6">
																				<label style="font-weight: 500;">Affiliation: </label><br>
																				<?php echo $row['member_first_name']." ".$row['member_last_name']." (".$row['member_id'].")";?>
																			</div>
																			<div class="col-lg-6">
																				<label style="font-weight: 500;">Contact no: </label><br>
																				<?php echo $row['member_phone_number'];?>
																			</div>
																		</div>
																		<hr>
																		<?php
																		$sql3=mysqli_query($conn,"SELECT * FROM official_authorized_driver_emergency_contact_table WHERE driver_id='$row2[driver_id]'");
																		$row3=mysqli_fetch_assoc($sql3); ?>
																		<div class="row form-group">
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Emergency Contact: </label><br>
																				<?php
																				if(empty($row3['driver_emergency_name'])){
																					echo "N/A";
																				}
																				else{
																					echo $row3['driver_emergency_name'];
																				}?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Contact no: </label> <br>
																				<?php 
																				if(empty($row3['driver_emergency_contact'])){
																					echo "N/A";
																				}
																				else{
																					echo $row3['driver_emergency_contact'];
																				}?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Relationship: </label> <br>
																				<?php 
																				if(empty($row3['driver_emergency_relationship'])){
																					echo "N/A";
																				}
																				else{
																					echo $row3['driver_emergency_relationship'];
																				}?>
																			</div>
																		</div>
																		<div class="row form-group">
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Birthdate: </label><br>
																				<?php
																				$bd=$row2['driver_birthdate'];
																				$bdd=strtotime($bd);
																				echo DATE('d M Y',$bdd);?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Weight: </label> <br>
																				<?php 
																				echo $row2['driver_weight'];?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Height: </label> <br>
																				<?php 
																				echo $row2['driver_height'];?>
																			</div>
																		</div>
																		<div class="row form-group">
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Blood Type: </label><br>
																				<?php 
																				echo $row2['driver_blood_type'];?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">TIN: </label><br>
																				<?php 
																				echo $row2['driver_tin'];?>
																			</div>
																			<div class="col-lg-4">
																				<label style="font-weight: 500;">Licence: </label><br>
																				<?php 
																				echo $row2['driver_licence'];?>
																			</div>
																		</div>
																	</div>
																</div>
															

															</div>
															<div class="modal-footer">
																<form action="../includes/driver_recommend.php" method="post">
																	<input type="hidden" name="person_id" value="<?php echo $row2['driver_id']; ?>">
																	<input type="hidden" name="email_add" value="<?php echo $row2['driver_email']; ?>">
																	<input type="hidden" name="person_name" value="<?php echo $row2['driver_name']; ?>">
																	<?php
																	$sqsq1=mysqli_query($conn,"SELECT * FROM training_seminar_table_present WHERE person_id='$row2[driver_id]'");
																	$cou1=mysqli_num_rows($sqsq1);
																	if($cou1>=1){ ?>
																		<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="You have already sent the notification">You have already sent the notification</button>
																		<?php 
																	}
																	else{ ?>
																		<button type="submit" class="btn <?php if($finalAns<=3.3){echo 'btn-danger';} else{echo 'btn-primary';} ?>" name="driverButton">Recommend for Training Seminar</button>
																		<?php 
																	} ?>
																	<!-- put in recommendation training and send email for training -->
																</form>
															</div>
														</div>
													</div>
												</div>



											</td>
										</tr>
										<?php
										unset($ratingARR);
									}
								} ?>




								<?php
								$ratingARR=array();
								$sak=mysqli_query($conn,"SELECT * FROM official_member_table WHERE active='0' AND member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1') AND member_drivers_licence!='NONE' AND member_drivers_licence IS NOT NULL");
								while($rou=mysqli_fetch_assoc($sak)){ ?>
									<tr>
										<td><?php echo $rou['member_id'];?></td>
										<td><?php echo $nami = $rou['member_first_name']." ".$rou['member_last_name'];?></td>
										<td><?php echo "Driver-Operator";?></td>
										<td><?php echo $rou['member_drivers_licence'];?></td>
										<td><?php echo $rou['member_email'];?></td>
										<td>
												<?php
												$sqi=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$rou[member_id]'");
												while($reu=mysqli_fetch_assoc($sqi)){
													$history_id = $reu['history_id'];
													$smi=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE history_id='$history_id' AND value IS NOT NULL");
													while($roi=mysqli_fetch_assoc($smi)){
														$ratingARR[]=$roi['value'];
													}
												} 
												if(!isset($ratingARR)){
													$sum=0;
													$size=0;
												}
												else{
													$sum = array_sum($ratingARR);
													$size = sizeof($ratingARR);
												}
												if($sum<=0 OR $size<=0){
													echo $finalAns = "No ratings yet";
												}
												else{
													echo $finalAns = number_format((($sum/$size)),2);
												} ?>
										</td>
										<td>
											<button type="button" data-toggle="modal" data-target="#mem<?php echo $rou['member_id']; ?>" class="btn btn-primary btn-block">View More</button>


											<!-- Modal -->
											<div class="modal fade bd-example-modal-lg" id="mem<?php echo $rou['member_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel"><?php echo $rou['member_first_name']." ".$rou['member_last_name'].' ('.$rou['member_id'].')';?></h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="row form-group">
															<div class="col-lg-4">
																<div class="row form-group">
																	<div class="col-lg-12">
																		<?php
																		if($rou['member_profile_pic']==null){ ?>
																			<img src="https://www.w3schools.com/howto/img_avatar.png" style="width:100%;border-radius: 50%" alt="">
																			<?php
																		}
																		else{ ?>
																			<img src="../includes/<?php echo $rou['member_profile_pic'];?>" style="width:100%;border-radius: 0%" alt="">
																			<?php
																		} ?>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-lg-12">
																		<center>
																		<label style="font-weight: 500;">EMAIL: </label>
																		<?php
																		echo $rou['member_email']; ?>
																		<!-- stars rating -->
																		<h1>
																			<?php
																			if($finalAns=="No ratings yet"){
																				echo "No ratings yet";
																			}
																			else{
																				echo ($finalAns).' points'; ?>
																				<br>
																				<a style="font-size:20px;" target="_blank" href="ratingFor.php?driver_pk=<?php echo $rou['member_id'];?>&type=MEMBER&name=<?php echo $nami;?>">See More</a>
																				<?php
																			} ?>
																		</h1>
																		</center>
																	</div>
																</div>
															</div>
															<div class="col-lg-8">
																<div class="row form-group">
																	<div class="col-lg-6">
																		<label style="font-weight: 500;">Name: </label><br>
																		<?php echo $rou['member_first_name']." ".$rou['member_last_name']; ?>
																	</div>
																	<div class="col-lg-6">
																		<label style="font-weight: 500;">Contact no.: </label><br>
																		<?php echo $rou['member_phone_number'];?>
																	</div>
																</div>
																<hr>
																<?php
																$sql4=mysqli_query($conn,"SELECT * FROM official_member_emergency_contact_table WHERE member_id='$rou[member_id]'");
																$row4=mysqli_fetch_assoc($sql4); ?>
																<div class="row form-group">
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Emergency Contact: </label><br>
																		<?php
																		if(empty($row4['member_emergency_name'])){
																			echo "N/A";
																		}
																		else{
																			echo $row4['member_emergency_name'];
																		}?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Contact no: </label> <br>
																		<?php
																		if(empty($row4['member_emergency_phone'])){
																			echo "N/A";
																		}
																		else{
																			echo $row4['member_emergency_phone'];
																		}?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Relationship: </label> <br>
																		<?php
																		if(empty($row4['member_emergency_relationship'])){
																			echo "N/A";
																		}
																		else{
																			echo $row4['member_emergency_relationship'];
																		}?>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Birthdate: </label><br>
																		<?php
																		$cd=$rou['member_birthdate'];
																		$cdd=strtotime($cd);
																		echo DATE('d M Y',$cdd);?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Weight: </label> <br>
																		<?php
																		echo $rou['member_weight'];?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Height: </label> <br>
																		<?php
																		echo $rou['member_height'];?>
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Blood Type: </label><br>
																		<?php
																		echo $rou['member_blood_type'];?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">TIN: </label><br>
																		<?php
																		echo $rou['member_tin'];?>
																	</div>
																	<div class="col-lg-4">
																		<label style="font-weight: 500;">Licence: </label><br>
																		<?php
																		echo $rou['member_drivers_licence'];?>
																	</div>
																</div>
															</div>
														</div>
														
													</div>
													<div class="modal-footer">
														<form action="../includes/driver_recommend.php" method="post">
															<input type="hidden" name="person_id" value="<?php echo $rou['member_id']; ?>">
															<input type="hidden" name="email_add" value="<?php echo $rou['member_email']; ?>">
															<input type="hidden" name="person_name" value="<?php echo $rou['member_first_name']." ".$rou['member_last_name']; ?>">
															<?php
															$sqsq2=mysqli_query($conn,"SELECT * FROM training_seminar_table_present WHERE person_id='$rou[member_id]'");
															$cou2=mysqli_num_rows($sqsq2);
															if($cou2>=1){ ?>
																<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="You have already sent the notification">You have already sent the notification</button>
																<?php 
															}
															else{ ?>
																<button type="submit" class="btn btn-primary" name="memberButton">Recommend for Training Seminar</button>
																<?php 
															} ?>														
															<!-- put in recommendation training and send email for training -->
														</form>
													</div>
												</div>
												</div>
											</div>


										</td>
									</tr>
									<?php
									unset($ratingARR);
								} ?>
							</tbody>
						</table>
						
					</div>

				</div>
			</div>

		</div>

		
	</main>

	<?php
  	require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>