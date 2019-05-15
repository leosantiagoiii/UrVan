<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
require "header.php";
require '../includes/dbconnect.inc.php'; ?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Deposit Slips (Trips)</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-sticky-note"></i>
			Deposit Slips (Trips)
		</div>
		<div class="card-body">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>By</th>
						<th>To</th>
						<th>Duration</th>
						<th>Uploaded</th>
						<th>Reference Number</th>
						<th>*</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>By</th>
						<th>To</th>
						<th>Duration</th>
						<th>Uploaded</th>
						<th>Reference Number</th>
						<th>*</th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='YES' AND refunded='NO'");
					while($major=mysqli_fetch_assoc($sql)){ 
						$sql2=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'");
						while($slip=mysqli_fetch_assoc($sql2)){
							$sql3=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$major[client_id]'");
							$cli=mysqli_fetch_assoc($sql3);
							$sql4=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'");
							$tra=mysqli_fetch_assoc($sql4); ?>
							<tr>
								<td><?php echo $major['major_id'];?></td>
								<td>@<?php echo $cli['client_username']; ?></td>
								<td><?php echo $tra['trip_name']; ?></td>
								<td><?php echo $major['duration']; ?></td>
								<td><?php echo $slip['created_at']; ?></td>
								<td><?php echo $slip['reference_num']; ?></td>
								<td>
									<div class="btn-group">
										<a href="../includes/<?php echo $slip['deposit_slip'];?>" target="_blank" class="btn btn-secondary">View</a>
										<a href="../includes/<?php echo $slip['deposit_slip'];?>" download class="btn btn-success">Download</a>
									</div>
								</td>
							</tr>
					<?php
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
require "footer.php";
}