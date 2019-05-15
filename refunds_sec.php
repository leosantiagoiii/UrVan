<?php
require "header.php";?>
<div class="container mt-5 mb-5">
	<?php
	$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id='$_SESSION[clientid]' AND (refund_2nddep='WAITING' OR refund_2nddep='GIVEN' OR refund_2nddep='APPROVED') ORDER BY created_at DESC");
	$count=mysqli_num_rows($sql);
	if($count>=1){ ?>
		<center><h1 style='font-family:monsbold;'>Refunds Request Section</h1></center>
		<div class="card" style="height:500px;overflow-y:scroll;padding:10px;">
			<table class="table table-striped" style="">
				<tr>
					<th>ID</th>
					<th>Tour</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Amount</th>
					<th>Status</th>
					<th>More</th>
				</tr>
				<?php
				while($row=mysqli_fetch_assoc($sql)){ ?>
					<tr>
						<td><?php echo $row['major_id'];?></td>
						<td>
							<?php
							$sqlo=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$row[tour_id]'");
							$getsq=mysqli_fetch_assoc($sqlo);
							echo $getsq['tour_name']; ?>
						</td>
						<td><?php echo DATE("Y M d",strtotime($row['start_date']));?></td>
						<td><?php echo DATE("Y M d",strtotime($row['end_date']));?></td>
						<td>
							<?php
							$fora=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$row[major_id]'");
							$tra=mysqli_fetch_assoc($fora);
								if($row['duration']>=1 AND $tra['transaction_type']=="DEPOSIT"){
								echo 'Php'.($tra['total_afterbal']);
							}
							if($row['duration']<=0 AND $tra['transaction_type']=="DEPOSIT"){
								echo 'Php'.($tra['total_amount']);
							}
							if($row['duration']>=1 AND $tra['transaction_type']=="STRIPE"){
								echo "Php";
								echo ($tra['total_afterbal']-$tra['total_amount']);
								echo " (Partially refunded via Stripe)";
							} ?>
						</td>
						<td>
							<?php
							if($row['refund_2nddep']=="WAITING"){
								echo '<div class="badge badge-primary text-wrap" style="">REQUEST</div>';
							}
							if($row['refund_2nddep']=="GIVEN"){
								echo '<div class="badge badge-info text-wrap" style="">DETAILS GIVEN</div>';
							}
							if($row['refund_2nddep']=="APPROVED"){
								echo '<div class="badge badge-success text-wrap" style="">COMPLETE</div>';
							} ?>
						</td>
						<td>
							<?php
							if($row['refund_2nddep']=="WAITING"){ ?>
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#req<?php echo $row['major_id']; ?>">
									Give Details
								</button>
								<div class="modal fade" id="req<?php echo $row['major_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<form action="includes/give_bank_details.inc.php" method="get">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														<?php 
														$major_id=$row['major_id'];
														echo $row['major_id'].' - '.$getsq['tour_name'];?>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Bank Name:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" name="refund_bank" class="form-control"> 
														</div>
													</div>
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Account Number:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" name="refund_account_number" class="form-control"> 
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													<button type="submit" name="send_info" class="btn btn-primary">Send Details</button>
												</div>
												<div class="modal-footer">
													<small class="">Make sure your details are correct. Once you send the details, you can't change it anymore.</small>
												</div>
											</form>
										</div>
									</div>
								</div>
								<?php
							}
							if($row['refund_2nddep']=="GIVEN"){ ?>
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#giv<?php echo $row['major_id']; ?>">
									View Details
								</button>
								<div class="modal fade" id="giv<?php echo $row['major_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<!-- <form action="includes/give_bank_details.inc.php" method="get"> -->
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														<?php 
														$major_id=$row['major_id'];
														echo $row['major_id'].' - '.$getsq['tour_name'];?>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<?php
													$sm=mysqli_query($conn,"SELECT * FROM `refund_table` WHERE major_id='$row[major_id]'");
													$sr=mysqli_fetch_assoc($sm);?>
													<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Bank Name:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" disabled name="refund_bank" value="<?php echo $sr['refund_bank']; ?>" class="form-control"> 
														</div>
													</div>
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Account Number:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" disabled name="refund_account_number" value="<?php echo $sr['refund_account_number']; ?>" class="form-control"> 
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												</div>
											<!-- </form> -->
										</div>
									</div>
								</div>
								<?php
							}
							if($row['refund_2nddep']=="APPROVED"){ ?>
								<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#giv<?php echo $row['major_id']; ?>">
									View Details
								</button>
								<div class="modal fade" id="giv<?php echo $row['major_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<!-- <form action="includes/give_bank_details.inc.php" method="get"> -->
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">
														<?php 
														$major_id=$row['major_id'];
														echo $row['major_id'].' - '.$getsq['tour_name'];?>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<?php
													$sm=mysqli_query($conn,"SELECT * FROM `refund_table` WHERE major_id='$row[major_id]'");
													$sr=mysqli_fetch_assoc($sm);?>
													<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Bank Name:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" disabled name="refund_bank" value="<?php echo $sr['refund_bank']; ?>" class="form-control"> 
														</div>
													</div>
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Account Number:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" disabled name="refund_account_number" value="<?php echo $sr['refund_account_number']; ?>" class="form-control"> 
														</div>
													</div>
													<div class="row form-group">
														<div class="col-lg-3">
															<label for="">Reference Number:</label>
														</div>
														<div class="col-lg-9">
															<input type="text" disabled name="refund_account_number" value="<?php echo $sr['refund_reference_no']; ?>" class="form-control"> 
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												</div>
											<!-- </form> -->
										</div>
									</div>
								</div>
								<?php
							} ?>
						</td>
					</tr>
					<?php
				} ?>
			</table>		
		</div>
		<?php
	}
	else{ ?>
		<div class="text-center" style="margin:200px 0 ;">
			<h1 style="font-family:monsbold">You haven't had a refund request yet</h1>
		</div>
		<?php
	} ?>

</div>
<?php
require "footer.php"; ?>