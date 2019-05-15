<?php session_start(); 
require "header.php"; require "../includes/dbconnect.inc.php";?>

<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Client Deposits</li>
	</ol>
   <div class="card mb-3">
      <div class="card-header">
         <i class="fas fa-table"></i>
         Members
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                  	<th>Trip</th>
                  	<th>Username</th>
                  	<th>Total Price</th>
                  	<th>Reference Number</th>
                  	<th>Option</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                  	<th>Trip</th>
                  	<th>Username</th>
                  	<th>Total Price</th>
                  	<th>Reference Number</th>
                  	<th>Option</th>
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
						$glam=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$t[major_id]'");
						$gla=mysqli_fetch_assoc($glam);
						if($e['deposit_slip']!=null){
							if($e['approval']=="PENDING"){
								//if($nm['transaction_type']=='DEPOSIT'){ ?>
									<tr>
										<td><?php echo $gla['trip_name'];?></td>
										<td><?php echo $u['client_username'];?></td>
										<td>
											Php <?php
											if($gla['total_afterbal']!=null){
												echo $gla['total_afterbal'];
											}
											else{
												echo $gla['total_amount'].".00";
											}
											?> 
										</td>
										<td><?php echo $e['reference_num'];?></td>
										<td>
											<form action="deposit_trips_details.php" method="get">
												<input type="hidden" name="client_id" value="<?php echo $t['client_id'];?>">
												<input type="hidden" name="major_id" value="<?php echo $t['major_id'];?>">
												<button name="mal" type="submit" class="btn btn-block btn-primary">Details</button>
											</form>
										</td>
									</tr>
						<?php 
								//}
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

<?php 
require "footer.php";
?>