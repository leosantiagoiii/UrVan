<?php session_start();
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?entry=error1");
	exit();
}else{
require "header.php";
$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id='$_SESSION[clientid]' ORDER BY created_at DESC");
$numero=mysqli_num_rows($sql);
?>
<div class="container" style="margin-top:30px;margin-bottom:30px;">
	<?php if($numero<=0){ ?>

	<div style="margin:120px 0px;">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div style="padding:30px;" class="container text-center">
					<div style="border-style:solid;border-width:1px; padding:50px;box-shadow: 10px 10px 0px 0px rgba(64,64,64,1);">
						<h1 style="font-family:raleway">You Haven't Had Any Reservations Before</h1>
						<div style="font-family:monsreg">Book Now! Click <a href="tours.php">here</a></div>
					</div>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>

	<?php } else { ?>
	<h2 style="font-family:gravity;" class="text-center mb-4">YOUR PAST TRIPS</h2>
	<div style="overflow-y:auto;height:500px;padding:20px;" class="card mb-5">
		<table class="table table-hover">
			<thead class="">
				<tr>
					<th>Trip ID</th>
					<th>Trip to</th>
					<th>Dates</th>
					<th>Payment Method</th>
					<th>Status</th>
					<th>Receipt</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($query=mysqli_fetch_assoc($sql)){
					$major_id=$query['major_id'];
					$sqawk=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
					$rou=mysqli_fetch_assoc($sqawk);
					$sq=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$query[tour_id]'");
					$que=mysqli_fetch_assoc($sq);
				?>
				<tr>
					<td><?php echo $major_id; ?></td>
					<td><?php echo $que['tour_name'];?></td>
					<td><?php echo $query['start_date'];?> to <?php echo $query['end_date'];?></td>
					<td><?php echo $rou['transaction_type'];?></td>
					<td>
						<?php 
						if($query['completion']=="YES" AND $query['refunded']=="NO"){
							echo "COMPLETED";
						} elseif($query['completion']=="YES" AND $query['refunded']=="YES"){
							echo "CANCELLED";
						} elseif($query['completion']=="NO_CANCELLED" AND $query['refunded']=="NO"){
							echo "CANCELLED";
						} ?>
					</td>
					<td>
						<div class="btn-group">
							<?php
							if($query['completion']=="YES" AND $query['refunded']=="NO"){ ?>
								<a target="_blank" class="btn btn-primary" 
									<?php if($rou['transaction_type']=="STRIPE"){ ?>
										href="<?php echo $rou['receipt_url']; ?>"
									<?php } elseif($rou['transaction_type']=="DEPOSIT"){ ?>
										href="deposit_receipt.php?major_id=<?php echo $major_id;?>&rec_id=<?php echo $rou['receipt_url'];?>"
									<?php } ?>
									>1st: Payment</a>
							<?php 
							} 
							elseif($query['completion']=="YES" AND $query['refunded']=="YES"){ 
								if($rou['transaction_type']=="STRIPE"){ ?>
									<a target="_blank" href="<?php echo $rou['receipt_url']; ?>" class="btn btn-danger">1st: Payment</a>
								<?php 
								} 
								else {
									echo "<button class='btn btn-secondary'>None</button>";
									$su=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id' AND approval='APPROVED'");
									$su=mysqli_num_rows($su);
									if($query['refund_2nddep']=="APPROVED"){?>
										<button type="button" class="btn btn-info">Refund Complete</button>
									<?php 
									}
								} 
							}
							elseif($query['completion']=="NO_CANCELLED" AND $query['refunded']=="NO"){ ?>
								<?php
								if($rou['transaction_type']=="STRIPE"){ ?>
									<a target="_blank" class="btn btn-primary" href="<?php echo $rou['receipt_url']; ?>">1st Payment</a>
									<?php 
								}
								$obs=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id'");
								$kwu=mysqli_fetch_assoc($obs);
								if($rou['transaction_type']=="DEPOSIT" && $kwu['approval']=="APPROVED"){ ?>
									<!-- <a target="_blank" class="btn btn-primary" href="deposit_receipt.php?major_id=<?php //echo $major_id;?>&rec_id=<?php //echo $rou['receipt_url'];?>&cancell">1st: Payment</a> -->
									<a target="_blank" class="btn btn-secondary text-white">None</a>
									<?php
								}
								elseif($rou['transaction_type']=="DEPOSIT" && $kwu['approval']!="APPROVED"){ ?>
									<a target="_blank" class="btn btn-secondary">None</a>
									<?php
								} ?>
								<?php
							} ?>
							<?php
							if($query['refund_2nddep']=='RECEIVED' OR $query['refund_2nddep']=='WAITING' OR $query['refund_2nddep']=='GIVEN'){
								echo '<button type="button" class="btn btn-secondary" style="font-weight:500;text-transform:uppercase"><u>2nd: Deposit Refund Processing</u></button>';
							}
							elseif($query['refund_2nddep']=='APPROVED'){
								if($rou['transaction_type']=='STRIPE'){
									$su=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id' AND approval='APPROVED'");
									$su=mysqli_num_rows($su);
									if($su!=0){?>
										<!-- <a class="btn btn-warning" target="_blank" href="receipt_two.php?major_id=<?php //echo $major_id;?>">2nd: Refund Complete</a> -->
										<a class="btn btn-warning">2nd: Refund Complete</a>
									<?php 
									}
								}						
							}
							?>
							<?php
							if($query['completion']=="YES" AND $query['refunded']=="NO"){
								if($query['duration']>=1){
									if($rou['transaction_type']=="STRIPE"){ ?>
										<a target="_blank" href="receipt_two.php?major_id=<?php echo $major_id;?>" class="btn btn-success">2nd: Deposit</a>
							<?php
									}
								}
							}
							elseif($query['completion']=="NO_CANCELLED" AND $query['refunded']=="NO"){
								$sklop=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major_id' AND approval='APPROVED'");
								$lk=mysqli_num_rows($sklop);
								$ksld=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
								$sddksl=mysqli_fetch_assoc($ksld);
								if($sddksl['transaction_type']=="STRIPE"){
									if($lk>=1){ ?>
										<a class="btn btn-warning" target="_blank" href="receipt_two.php?major_id=<?php echo $major_id;?>">2nd: Deposit</a>
										<?php
									}
								}
							} ?>	
						</div>				
					</td>
				</tr>
				<?php 
				}
				?>
			</tbody>
		</table>
	</div>
	<?php } ?>
</div>
<?php
require "footer.php";
}
?>