<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php";
  $remaining=$_GET['remaining'];
  $member_id=$_GET['member_id'];
  $xyz=$_GET['xyz'];
?>

<main>
	
	<div class="container-fluid">

		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="subsc_cap.php">Membership Fees</a>
			</li>
			<li class="breadcrumb-item active"><?php echo $member_id; ?></li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-user-circle"></i>
				Capital for <?php echo $member_id;?>
			</div>
			<div class="card-body">
				<?php
				if($xyz=="0"){ ?>
					<!-- here -->
					<div class="row">
						<div class="col-lg-7">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'"); ?>
								<thead>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									while($row=mysqli_fetch_assoc($sql)){ ?>
										<tr>
											<td><?php echo $row['id'];?></td>
											<td>PHP <?php echo $row['amount']?></td>
											<td><?php
											if($row['ref_num']==null){
												echo "N/A";
											}
											else{
												echo $row['ref_num'];
											}
											?></td>
											<td><?php
											if($row['file_path']==null){
												echo "N/A";
											}
											else{
												echo '<a href="../includes/'.$row['file_path'].'" target="_blank">View</a>';
											}
											?></td>
											<td><?php echo $row['created_at'];?></td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
						<div class="col-lg-5">
							<?php
							$sql2=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'"); ?>
							<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
							<script type="text/javascript">
								google.charts.load("current", {packages:["corechart"]});
     							google.charts.setOnLoadCallback(drawChart);
     							function drawChart(){
     								var data = google.visualization.arrayToDataTable([
     									['Amount','Percentage'],
     									<?php
     									while($row2=mysqli_fetch_assoc($sql2)){
     										$date=$row2['created_at'];
     										$date=strtotime($date);
     										$date=DATE("Y-d-M H:i A",$date);
     										echo "['".$date."',".$row2['amount']."],";
     									}
     									echo "['Remaining',".$remaining."]"; ?>
     								]);
     								var options={
     									title:'Payment',
     									pieHole:0.4,
     									height: '100%',
     									chartArea:{
     										width:500,
     										height:900,
     										top:"10%",
     									}
     								};
     								var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
     								chart.draw(data, options);
     							}
							</script>
							<div id="donutchart" style="width: 100%;"></div>
							<div class="mt-5">
								<h3>Payments are complete for this one</h3>
							</div>
						</div>
					</div>
					<?php
				}
				if($xyz=="1"){ ?>
					<!-- here -->
					<div class="row">
						<div class="col-lg-7">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'"); ?>
								<thead>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									while($row=mysqli_fetch_assoc($sql)){ ?>
										<tr>
											<td><?php echo $row['id'];?></td>
											<td>PHP <?php echo $row['amount']?></td>
											<td><?php
											if($row['ref_num']==null){
												echo "N/A";
											}
											else{
												echo $row['ref_num'];
											}
											?></td>
											<td><?php
											if($row['file_path']==null){
												echo "N/A";
											}
											else{
												echo '<a href="../includes/'.$row['file_path'].'" target="_blank">View</a>';
											}
											?></td>
											<td><?php echo $row['created_at'];?></td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
						<div class="col-lg-5">
							<?php
							$sql2=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='APPROVED'"); ?>
							<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
							<script type="text/javascript">
								google.charts.load("current", {packages:["corechart"]});
     							google.charts.setOnLoadCallback(drawChart);
     							function drawChart(){
     								var data = google.visualization.arrayToDataTable([
     									['Amount','Percentage'],
     									<?php
     									while($row2=mysqli_fetch_assoc($sql2)){
     										$date=$row2['created_at'];
     										$date=strtotime($date);
     										$date=DATE("Y-d-M H:i A",$date);
     										echo "['".$date."',".$row2['amount']."],";
     									}
     									echo "['Remaining',".$remaining."]"; ?>
     								]);
     								var options={
     									title:'Payment',
     									pieHole:0.4,
     									height: '100%',
     									chartArea:{
     										width:500,
     										height:900,
     										top:"10%",
     									}
     								};
     								var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
     								chart.draw(data, options);
     							}
							</script>
							<div id="donutchart" style="width: 100%;"></div>
							<div class="mt-5">
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#sjakjska">Add Payment</button>
								<!-- modal -->
								<div class="modal fade" id="sjakjska" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="../includes/capital_payment.inc.php" method="get">
												<div class="modal-body">
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">Php</span>
														</div>
														<input required type="text" class="form-control" placeholder="Cash" aria-label="Username" aria-describedby="basic-addon1" name="cash">	
														<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
														<input type="hidden" name="xyz" value="<?php echo $xyz; ?>">			
													</div>
													Today is <?php echo DATE("Y-m-d H:i A"); ?>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													<button type="submit" name="submitb" class="btn btn-primary">Pay</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!-- moday -->
							</div>
						</div>
					</div>
					<?php
				} ?>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-user-circle"></i>
				Pending Deposit Slips for <?php echo $member_id;?>
			</div>
			<div class="card-body">
				<?php
				if($xyz=="0"){ ?>
					<!-- here -->
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='PENDING'"); ?>
								<thead>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
										<th>Approval</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
										<th>Approval</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									while($row=mysqli_fetch_assoc($sql)){ ?>
										<tr>
											<td><?php echo $row['id'];?></td>
											<td>PHP <?php echo $row['amount']?></td>
											<td><?php
											if($row['ref_num']==null){
												echo "N/A";
											}
											else{
												echo $row['ref_num'];
											}
											?></td>
											<td><?php
											if($row['file_path']==null){
												echo "N/A";
											}
											else{
												echo '<a href="../includes/'.$row['file_path'].'" target="_blank">View</a>';
											}
											?></td>
											<td><?php echo $row['created_at'];?></td>
											<td>
												<form action="../includes/capital_deposit_slip.inc.php" method="GET">
													<input type="hidden" value="<?php echo $member_id;?>" name="member_id">
													<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="btn-group d-flex">
														<button class="btn btn-primary w-100" type="submit" name="app">Approve</button>
														<button class="btn btn-danger w-100" type="submit" name="dec">Decline</button>
													</div>
												</form>
											</td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php
				}
				if($xyz=="1"){ ?>
					<!-- here -->
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE member_id='$member_id' AND status='PENDING'"); ?>
								<thead>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
										<th>Approval</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Amount</th>
										<th>Reference Num</th>
										<th>Image</th>
										<th>Payment Date</th>
										<th>Approval</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									while($row=mysqli_fetch_assoc($sql)){ ?>
										<tr>
											<td><?php echo $row['id'];?></td>
											<td>PHP <?php echo $row['amount']?></td>
											<td><?php
											if($row['ref_num']==null){
												echo "N/A";
											}
											else{
												echo $row['ref_num'];
											}
											?></td>
											<td><?php
											if($row['file_path']==null){
												echo "N/A";
											}
											else{
												echo '<a href="../includes/'.$row['file_path'].'" target="_blank">View</a>';
											}
											?></td>
											<td><?php echo $row['created_at'];?></td>
											<td>
												<form action="../includes/capital_deposit_slip.inc.php" method="GET">
													<input type="hidden" value="<?php echo $member_id;?>" name="member_id">
													<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="btn-group d-flex">
														<button class="btn btn-primary w-100" type="submit" name="app">Approve</button>
														<button class="btn btn-danger w-100" type="submit" name="dec">Decline</button>
													</div>
												</form>
											</td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php
				} ?>
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