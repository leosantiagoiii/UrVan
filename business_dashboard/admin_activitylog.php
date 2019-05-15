<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
?>
<main>
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Activity Log</li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-chart-area"></i>
				Activity Log
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Activity</th>
								<th>Time</th>
								<th>Username</th>
								<th>Role</th>
							</tr>
						</thead>
						<tfoot>
						<tr>
							<th>ID</th>
							<th>Activity</th>
							<th>Time</th>
							<th>Username</th>
							<th>Role</th>
						</tr>
						</tfoot>
						<tbody>
							<?php
							$query=mysqli_query($conn,"SELECT * FROM activity_log_table ORDER BY activity_log_time DESC");
							while($rez=mysqli_fetch_assoc($query)){ ?>
							<tr>
								<td><?php echo $rez['activity_log_id']; ?></td>
								<td><?php echo $rez['activity_log_activity']; ?></td>
								<td><?php echo $rez['activity_log_time']; ?></td>
								<td><?php echo $rez['activity_log_username']; ?></td>
								<td><?php echo $rez['activity_log_role']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
		</div>


		<div class="row">
			<div class="col-lg-6">
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-chart-area"></i>
						Active Accounts
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$A1=mysqli_query($conn,"SELECT * FROM clients_table");
								while($row=mysqli_fetch_assoc($A1)){ ?>
								<tr>
									<td><?php echo $row['client_id']; ?></td>
									<td><?php echo $row['client_first_name']." ".$row['client_last_name']; ?></td>
									<td>
										<?php
										$A2=mysqli_query($conn,"SELECT * FROM for_activeusers WHERE acc_id='$row[client_id]'");
										$count=mysqli_num_rows($A2);
										if($count==0){
											echo ' <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Disc_Plain_red_dark.svg/768px-Disc_Plain_red_dark.svg.png" style="width:10px;height:10px;" alt="">';
										}
										else{
											echo ' <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Disc_Plain_green_dark.svg/768px-Disc_Plain_green_dark.svg.png" style="width:10px;height:10px;" alt="">';
										}
										?>
									</td>
								</tr>
								<?php
								} ?>
							</tbody>
						</table>
					</div>
					<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
				</div>
			</div>
			<div class="col-lg-6"></div>
		</div>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-chart-area"></i>
				Active Accounts
			</div>
			<div class="card-body">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


				<?php
				$sss=mysqli_query($conn,"SELECT DISTINCT HOUR(log_at) FROM active_accs ORDER BY HOUR(log_at)"); ?>

			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);

			      function drawChart() {

			        var data = google.visualization.arrayToDataTable([
			          ['Task', 'Hours per Day'],
			          <?php
			          while($row=mysqli_fetch_assoc($sss)){
			          	$log_at=$row['HOUR(log_at)'];
				       	$k=mysqli_query($conn,"SELECT * FROM active_accs WHERE HOUR(log_at)='$log_at'");
				       	$users=mysqli_num_rows($k);
				       	echo "['".$log_at.":00',".$users."],";
			          } ?>
			        ]);

			        var options = {
			          title: 'Number of logs per hour',
			          pieSliceText: 'label',
			        };

			        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			        chart.draw(data, options);
			      }
			    </script>
				<div id="piechart" style="width:100%;height:500px;padding:0;margin:0;"></div>
			</div>
			<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
		</div>

	</div>
</main>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>