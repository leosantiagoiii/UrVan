<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php";
?>

<main>
	<div class="container-fluid">

		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Membership Fees</li>
		</ol>

		<div class="row">
			<div class="col-lg-12">
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-user-circle"></i>
						Subscribed Capital
					</div>
					<div class="card-body">
						<!-- <div>
							<form action="reportSub.php" method="get" target="_blank">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-4">
											<input type="date" name="start_date" class="form-control">
										</div>
										<div class="col-lg-4">
											<input type="date" name="end_date" class="form-control">
										</div>
										<div class="col-lg-4">
											<button class="btn btn-secondary btn-block">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div> -->
						<hr>
						<div class="table-responsive" style="padding:0px 0 0 0;">
							<?php
							function percent($x){
								$y=($x/60000.00)*100.00;
								$y=number_format($y,1,".","");
								// $y=abs($y-100.00);
								return $y;
							}
							$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1')"); ?>
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Member ID</th>
										<th>Name</th>
										<th>Paid (PHP)</th>
										<th>Remaining</th>
										<th>Paid (%)</th>
										<th>Last Paid</th>								
										<th>Status</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Member ID</th>
										<th>Name</th>
										<th>Paid (PHP)</th>
										<th>Remaining</th>
										<th>Paid (%)</th>
										<th>Last Paid</th>								
										<th>Status</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									while($row=mysqli_fetch_assoc($sql)){
										$sql2=mysqli_query($conn,"SELECT SUM(amount) AS total_amt FROM official_member_capital WHERE member_id='$row[member_id]' AND status='APPROVED'");
										$row2=mysqli_fetch_assoc($sql2);
										$sql3 = mysqli_query($conn,"SELECT created_at FROM official_member_capital WHERE member_id='$row[member_id]' ORDER BY created_at DESC LIMIT 1");
										$row3 = mysqli_fetch_assoc($sql3);

										$created_at1=strtotime($row3['created_at']);
										$new_date = DATE('Y-m-d', strtotime('+2 years', $created_at1));
										$dateNow=DATE('Y-m-d');
										$new_date=strtotime($new_date);
										$dateNow=strtotime($dateNow); ?>
										<tr <?php
											if($row2['total_amt']==null){
												$stat="1";
											}
											elseif($row2['total_amt']>0 && $row2['total_amt']<60000.00){
												$stat="1";
											}
											else{
												echo 'class="text-white bg-success"';
												$stat="0";
											}
											if(($dateNow>=$new_date) AND ($row2['total_amt']<60000.00)){
												echo "class='bg-danger text-white'";
											}
											?>>
											<td><?php echo $row['member_id'];?></td>
											<td><?php echo $row['member_first_name'].' '.$row['member_last_name'];?></td>
											<td>
												<?php
												if($row2['total_amt']==null){
													echo 'NONE';
												}
												elseif($row2['total_amt']>0 && $row2['total_amt']<60000.00){
													echo 'PHP '.$row2['total_amt'];
												}
												else{ //$row2['total_amt']>=60000.00
													echo "COMPLETE";
												} ?>
											</td>
											<td>
												<!-- abs(total-60000) -->
												<?php
												$x=$row2['total_amt'];
												$x=abs($x-60000.00);
												$x=number_format($x,2,".","");
												echo 'PHP '.$x;
												$per=$row2['total_amt']; ?>
											</td>
											<td><?php echo $per=percent($per); echo '%'; ?></td>
											<td><?php 
												if($row3['created_at']!=null){
													echo DATE("Y M d",strtotime($row3['created_at']));										
												}else{
													echo "NONE";
												}?>
											</td>
											<td style="width:15%">
												<form action="subsc_cap_2.php" method="get">
													<input type="hidden" name="remaining" value="<?php echo $x;?>">
													<input type="hidden" name="member_id" value="<?php echo $row['member_id'];?>">
													<button class="btn btn-block btn-primary" name="xyz" type="submit"
														<?php
														if($stat=="1"){
															echo 'value="1"';
														}
														if($stat=="1"){
															echo 'value="1"';
														}
														if($stat=="0"){
															echo 'value="0"';													
														} ?>>View Details</button>
												</form>
											</td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
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