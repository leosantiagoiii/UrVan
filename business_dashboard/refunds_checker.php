<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Refunds</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-hand-holding-usd"></i>
			Refund Requests
		</div>
		<div class="card-body">
			<!-- <form action="../includes/refund_approval.inc.php" method="POST"> -->
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Trip ID</th>
							<th>Dates</th>
							<th>Request From</th>
							<th>Package</th>
							<th>Amount</th>
							<th>Type</th>
							<th>Reference Number Prior</th>
							<th>Verdict</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sf=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refund_2nddep='RECEIVED' OR refund_2nddep='WAITING' OR refund_2nddep='GIVEN' ORDER BY created_at DESC");
						$i=0;
						while($sff=mysqli_fetch_assoc($sf)){ ?>
							<tr>
								<td>
									<?php
									$i++;
									echo $i; ?>
								</td>
								<td>
									<?php echo $sff['major_id'];?>
								</td>
								<td>
									<?php
									if($sff['start_date']==$sff['end_date']){
										echo DATE("Y M d",strtotime($sff['start_date'])).' (1 day)';
									}
									else{
										$durationh=$sff['duration']+1;
										echo DATE("Y M d",strtotime($sff['start_date'])).' to '.DATE("Y M d",strtotime($sff['end_date'])).' ('.$durationh.' days)';
									} ?>
								</td>
								<td>
									<?php 
									$client_id = $sff['client_id'];
									$sql=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
									$rou=mysqli_fetch_assoc($sql);
									echo $rou['client_first_name'].' '.$rou['client_last_name']; ?>
								</td>
								<td>
									<?php
									$sqlo=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$sff[tour_id]'");
									$getsq=mysqli_fetch_assoc($sqlo);
									echo $getsq['tour_name']; ?>
								</td>
								<td>
									<?php
									$fora=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$sff[major_id]'");
									$tra=mysqli_fetch_assoc($fora);
									if($sff['duration']>=1 AND $tra['transaction_type']=="DEPOSIT"){
										echo 'Php '.$tra['total_afterbal'];
									}
									if($sff['duration']<=0 AND $tra['transaction_type']=="DEPOSIT"){
										echo 'Php '.$tra['total_amount'];
									}
									if($sff['duration']>=1 AND $tra['transaction_type']=="STRIPE"){
										echo "Php ";
										echo $tra['total_afterbal']-$tra['total_amount'];
										echo " (Partially refunded via Stripe already)";
									} ?>
								</td>
								<td>
									<?php
									echo $tra['transaction_type']; ?>
								</td>
								<td>
									<?php
									$ssss=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$sff[major_id]'");
									$miff=mysqli_fetch_assoc($ssss);
									echo $miff['reference_num']; ?>
								</td>
								<td>
									<form action="../includes/refund_approval.inc.php" method="POST">
										<input type="hidden" name="major_id" value="<?php echo $sff['major_id']; ?>">
										<input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
										<?php
										if($sff['refund_2nddep']=="RECEIVED"){ ?>
											<button type="submit" class="btn btn-primary" name="asking">Request for Acct. No.</button>
											<?php
										}
										elseif($sff['refund_2nddep']=="WAITING"){?>
											<button type="button" class="btn btn-warning">Awaiting Response</button>
											<?php }
										elseif($sff['refund_2nddep']=="GIVEN"){ ?>
											<button type="button" class="btn btn-info" data-toggle="modal" data-target="#giv<?php echo $sff['major_id']; ?>">
												Approve Refund
											</button>
											<div class="modal fade" id="giv<?php echo $sff['major_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<!-- <form action="includes/give_bank_details.inc.php" method="get"> -->
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">
																	<?php 
																	$major_id=$sff['major_id'];
																	echo $major_id;?>
																</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<?php
																$sm=mysqli_query($conn,"SELECT * FROM `refund_table` WHERE major_id='$major_id'");
																$sr=mysqli_fetch_assoc($sm);?>
																<input type="hidden" name="major_id" value="<?php echo $major_id; ?>">
																<div class="row form-group">
																	<div class="col-lg-3">
																		<label for="">Bank Name:</label>
																	</div>
																	<div class="col-lg-9">
																		<input type="text" disabled value="<?php echo $sr['refund_bank']; ?>" class="form-control"> 
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-lg-3">
																		<label for="">Account Number:</label>
																	</div>
																	<div class="col-lg-9">
																		<input type="text" disabled value="<?php echo $sr['refund_account_number']; ?>" class="form-control"> 
																	</div>
																</div>
																<div class="row form-group">
																	<div class="col-lg-3">
																		<label for="">Reference Number:</label>
																	</div>
																	<div class="col-lg-9">
																		<input type="text" required name="refund_reference_no" class="form-control"> 
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-info" name="aprubado">Approve Refund</button>
															</div>
														<!-- </form> -->
													</div>
												</div>
											</div>
											<?php
										} ?>
									</form>
								</td>
							</tr>
						<?php
						} ?>
					</tbody>
				</table>
			<!-- </form> -->
		</div>
	</div>
</div>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>