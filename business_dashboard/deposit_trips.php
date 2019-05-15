<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	require "../includes/dbconnect.inc.php";
	require "header.php";
?>
<main>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Extended Trips</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Deposit
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Trip</th>
							<th>Username</th>
							<th>Total Amount</th>
							<th>Payment Method</th>
							<th>Created At</th>
							<th>Options</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Trip</th>
							<th>Username</th>
							<th>Total Amount</th>
							<th>Payment Method</th>
							<th>Created At</th>
							<th>Options</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						$m=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion=\"NO\" AND refunded=\"NO\"");
						while($t=mysqli_fetch_assoc($m)){
							$r=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$t[major_id]'");
							$nm=mysqli_fetch_assoc($r);
							$p=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$t[client_id]'");
							$u=mysqli_fetch_assoc($p);
							$k=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$t[major_id]'");
							$e=mysqli_fetch_assoc($k);
							$sulk=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$t[major_id]'");
							$sulk2=mysqli_fetch_assoc($sulk);
							if($t['duration']>=1){
								if($sulk2['status']=="UNPAID"){
									if($sulk2['amount']==NULL){
						?>
									<tr>
										<td><?php echo $nm['trip_name'];?></td>
										<td><?php echo $u['client_username'];?></td>
										<td>Php <?php echo $nm['total_amount'];?>.00</td>
										<td><?php echo $nm['transaction_type'];?></td>
										<td><?php echo $nm['created_at']; ?></td>
										<td>
											<form action="deposit_trips_details.php" method="get">
												<input type="hidden" name="transaction_type" value="<?php echo $nm['transaction_type'];?>">
												<input type="hidden" name="client_id" value="<?php echo $t['client_id'];?>">
												<input type="hidden" name="major_id" value="<?php echo $t['major_id'];?>">
												<button name="viewdee" type="submit" class="btn btn-block btn-primary">Details</button>
											</form>
										</td>
									</tr>
						<?php 
									}
								}
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
	</div>


	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Approved
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No.</th>
							<th>Trip</th>
							<th>Username</th>
							<th>Total Amount</th>
							<th>Payment Method</th>
							<th>Created At</th>
							<th>Options</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No.</th>
							<th>Trip</th>
							<th>Username</th>
							<th>Total Amount</th>
							<th>Payment Method</th>
							<th>Created At</th>
							<th>Options</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						$i=0;
						$fabian=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion=\"NO\" AND refunded=\"NO\"");
						while($phi=mysqli_fetch_assoc($fabian)){
							$i++;
							$r=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$phi[major_id]'");
							$melo=mysqli_fetch_assoc($r);
							$p=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$phi[client_id]'");
							$mesti=mysqli_fetch_assoc($p);
							$k=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$phi[major_id]'");
							$forkl=mysqli_fetch_assoc($k);
							$sulk=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$phi[major_id]'");
							$bubbi=mysqli_fetch_assoc($sulk);
							if($phi['duration']>=1){
								if($bubbi['status']=="UNPAID"){
									if($bubbi['amount']!=NULL){
										// 
										if(!isset($forkl['deposit_slip'])){ ?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $melo['trip_name'];?></td>
												<td><?php echo $mesti['client_username'];?></td>
												<td>Php <?php echo $melo['total_amount'];?>.00</td>
												<td><?php echo $melo['transaction_type'];?></td>
												<td><?php echo $melo['created_at']; ?></td>
												<td>
													<form action="deposit_trips_details_edit.php" method="get">
														<input type="hidden" name="transaction_type" value="<?php echo $melo['transaction_type'];?>">
														<input type="hidden" name="client_id" value="<?php echo $phi['client_id'];?>">
														<input type="hidden" name="major_id" value="<?php echo $phi['major_id'];?>">
														<button name="viewdee" type="submit" class="btn btn-block btn-warning">Edit</button>
													</form>
												</td>
											</tr>
										<?php 
										}
									}
								}
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
	</div>


</div>
</main>
<?php
	require "footer.php";
}