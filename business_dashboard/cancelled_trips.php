<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	require "../includes/dbconnect.inc.php";
	require "header.php"; ?>
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Cancelled Trips</li>
		</ol>


		<?php
		$op=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refunded='YES'");
		$lio=0;
		while($major=mysqli_fetch_assoc($op)){
			$mn=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'");
			$wabu=mysqli_fetch_assoc($mn);
			if($wabu['total_amount']!=null){
				$lio+=$wabu['total_amount'];
			}
		}
		// echo 'The business could\'ve generated Php'.$lio;?>

		<div class="card mb-3">
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<?php
						$yearNow=DATE("Y");
						$yearLastYr=DATE("Y",strtotime("-1 year"));

						$smul=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refunded='YES' AND YEAR(created_at)='$yearNow' ORDER BY created_at DESC");
						$terno=array();

						$oioi=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refunded='YES' AND YEAR(created_at)='$yearLastYr' ORDER BY created_at DESC");
						$vame=array();

						while($smel=mysqli_fetch_assoc($smul)){
							$sliop=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$smel[major_id]'");
							$mipi=mysqli_fetch_assoc($sliop);
							if($mipi['total_afterbal']!=null){
								$terno[]=$mipi['total_afterbal'];
							}
							else{
								$terno[]=$mipi['total_amount'];
							}
						}
						$sumThisYear = array_sum($terno); 
						$sizeThisyear = sizeof($terno);

						while($haha=mysqli_fetch_assoc($oioi)){
							$quipo=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$haha[major_id]'");
							$mever=mysqli_fetch_assoc($quipo);
							if($mever['total_afterbal']!=null){
								$vame[]=$mever['total_afterbal'];
							}
							else{
								$vame[]=$mever['total_amount'];
							}
						}
						$sumLastYear = array_sum($vame);
						$sizeLastYear = sizeof($vame); ?>
						<div class="alert alert-danger mb-2" role="alert" style="margin:0">
							<h4 class="alert-heading">Php <?php echo number_format($sumThisYear,2); ?></h4>
							<p>This year, <?php echo DATE("Y"); ?>, BTTSC could have made <?php echo number_format($sumThisYear,2); ?> pesos</p>
							<hr>
							<p class="mb-0">A total of <?php echo $sizeThisyear; ?> cancelled trip(s) happened this year</p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="alert alert-warning" role="alert" style="margin:0">
							<h4 class="alert-heading">Php <?php echo number_format($sumLastYear,2); ?></h4>
							<p>In <?php echo $yearLastYr; ?>, BTTSC could have made <?php echo number_format($sumLastYear,2); ?> pesos</p>
							<hr>
							<p class="mb-0">A total of <?php echo $sizeLastYear; ?> cancelled trip(s) happened last year</p>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-ban"></i>
				Cancelled Trips
			</div>
			<div class="card-body">
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th></th>
							<th>Trip ID</th>
							<th>To</th>
							<th>Duration</th>
							<th>Date(s)</th>
							<th>Pax</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refunded='YES' ORDER BY created_at DESC");
						$i=0;
						$total=array();
						while($major=mysqli_fetch_assoc($sql)){ 
							$sql2=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'");
							$tra=mysqli_fetch_assoc($sql2);
							$i++;
							if($tra['total_amount']!=null){ ?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $major['major_id'];?></td>
									<td><?php echo $tra['trip_name'];?></td>
									<td><?php echo $major['duration'];?></td>
									<td><?php echo DATE("Y M d",strtotime($major['start_date'])).' - '.DATE("Y M d",strtotime($major['end_date']));?></td>
									<td><?php echo $major['pax'];?></td>
									<td>
										Php 
										<?php 
										if($tra['total_afterbal']!=null){
											echo $total[]=$tra['total_afterbal'];
										}
										else{
											echo $total[]=$tra['total_amount']+$tra['total_afterbal'];
										} ?> 
									</td>
								</tr>
								<?php
							}
						} ?>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th>Trip ID</th>
							<th>To</th>
							<th>Duration</th>
							<th>Date(s)</th>
							<th>Pax</th>
							<th><?php echo number_format(array_sum($total),2); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php
	require "footer.php";
} ?>