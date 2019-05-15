<?php
session_start();
if(!isset($_SESSION['adminid'])){

}
else{
	require "header.php";
	require "../includes/dbconnect.inc.php"; ?>

	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Past Trips</li>
		</ol>
		<div class="card mb-3" style="padding:20px;magrin:0">
			<?php 
			//for this year
			$yrnow=DATE("Y");
			$sumThisYr=array();
			$sqm=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id IN (SELECT major_id FROM booking_history_trip WHERE YEAR(created_at)='$yrnow') ORDER BY `created_at` DESC");
			while($major=mysqli_fetch_assoc($sqm)){
				$major_id=$major['major_id'];
				$getTr=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
				$trans=mysqli_fetch_assoc($getTr);
				if($trans['total_afterbal']!=null){//if afterbal is not null
					$sumThisYr[]=$trans['total_afterbal'];
				}
				else{ //if null, meaning no additional
					$sumThisYr[]=$trans['total_amount'];
				}
			}
			$sizeThisyear=sizeof($sumThisYr);
			$sumThisYear=array_sum($sumThisYr);
			unset($sumThisYr);

			//for last year
			$yearLastYr=DATE("Y",strtotime("-1 year"));
			$sumLastYr=array();
			$sqo=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id IN (SELECT major_id FROM booking_history_trip WHERE YEAR(created_at)='$yearLastYr') ORDER BY `created_at` DESC");
			while($major1=mysqli_fetch_assoc($sqo)){
				$major_id1=$major1['major_id'];
				$getTr1=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id1'");
				$trans=mysqli_fetch_assoc($getTr1);
				if($trans['total_afterbal']!=null){//if afterbal is not null
					$sumLastYr[]=$trans['total_afterbal'];
				}
				else{ //if null, meaning no additional
					$sumLastYr[]=$trans['total_amount'];
				}
			}
			$sizeLastyear=sizeof($sumLastYr);
			$sumLastYear=array_sum($sumLastYr);
			unset($sumLastYr); ?>
			<div class="row">
				<div class="col-lg-6">
					<div class="alert alert-success mb-2" role="alert" style="margin:0">
						<h4 class="alert-heading">Php <?php echo number_format($sumThisYear,2); ?></h4>
						<p>This year, <?php echo DATE("Y"); ?>, BTTSC made <?php echo number_format($sumThisYear,2); ?> pesos</p>
						<hr>
						<p class="mb-0">A total of <?php echo $sizeThisyear; ?> trip(s) happened this year</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="alert alert-primary" role="alert" style="margin:0">
						<h4 class="alert-heading">Php <?php echo number_format($sumLastYear,2); ?></h4>
						<p>Last year, <?php echo $yearLastYr; ?>, BTTSC made <?php echo number_format($sumLastYear,2); ?> pesos</p>
						<hr>
						<p class="mb-0">A total of <?php echo $sizeLastyear; ?> trip(s) happened this year</p>
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-undo-alt"></i>
				Past Trips
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No.</th>
							<th>ID</th>
							<th>By</th>
							<th>To</th>
							<th>Duration</th>
							<th>Created</th>
							<th>Type</th>
							<th>*</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No.</th>
							<th>ID</th>
							<th>By</th>
							<th>To</th>
							<th>Duration</th>
							<th>Created</th>
							<th>Type</th>
							<th>*</th>
						</tr>
					</tfoot>
					<tbody>
						<?php 
						$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='YES' AND refunded='NO' ORDER BY created_at DESC");
						$i=0;
						while($major=mysqli_fetch_assoc($sql)){
							$i++;
							$sql2=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$major[client_id]'");
							$cli=mysqli_fetch_assoc($sql2);
							$sql3=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'");
							$tran=mysqli_fetch_assoc($sql3); ?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $major['major_id'];?></td>
								<td><?php echo '@'.$cli['client_username']; ?></td>
								<td><?php echo $tran['trip_name'];?></td>
								<td><?php echo $major['duration'];?></td>
								<td><?php echo $major['created_at']; ?></td>
								<td><?php echo $tran['transaction_type']; ?></td>
								<td>
									<form action="assort_trips.php" method="POST" target="_blank">
										<input type="hidden" name="major_id" value="<?php echo $major['major_id'];?>">
										<input type="hidden" name="duration" value="<?php echo $major['duration'];?>">
										<input type="hidden" name="username" value="<?php echo $cli['client_username'];?>">
										<input type="hidden" name="place" value="<?php echo $tran['trip_name'];?>">
										<button type="submit" class="btn btn-block btn-secondary" name="past">View</button>
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

<?php
	require "footer.php";
}