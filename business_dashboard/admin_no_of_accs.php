<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Number of Accounts</li>
	</ol>
	<div class="row">
		<div class="col">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-area"></i>
					Number of Clients Joined This Week
				</div>
				<div class="card-body">
					<canvas id="numofclient" width="100%" height="30"></canvas>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>
		</div>
		<div class="col">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-area"></i>
					Number of Members Joined This Week
				</div>
				<div class="card-body">
					<canvas id="numofmember" width="100%" height="30"></canvas>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-area"></i>
					Clients Created This Week
				</div>
				<div class="card-body">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Name</th>
								<th>Created At</th>
								<th>Activation</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tfoot>
						<tr>
							<th>Name</th>
							<th>Created At</th>
							<th>Activation</th>
							<th>Actions</th>
						</tr>
						</tfoot>
						<tbody>
							<?php $sQl="SELECT * FROM clients_table WHERE client_createdat > ADDDATE(NOW(), INTERVAL -1 WEEK) ORDER BY client_createdat DESC";
							$rEs=mysqli_query($conn,$sQl);
							while($rOw=mysqli_fetch_assoc($rEs)){
								$ano="SELECT * FROM verify_client_table WHERE client_id=$rOw[client_id]";
								$amo=mysqli_query($conn,$ano);
								while($ka=mysqli_fetch_assoc($amo)){ ?>
								<tr>
									<td><?php echo $rOw['client_first_name'].' '.$rOw['client_last_name'];?></td>
									<td><?php echo $rOw['client_createdat'];?></td>
									<td>
										<?php
										if($ka['client_verify']==1){
											echo 'YES';
										}
										else{
											echo 'NO';
										}
										?>
									</td>
									<td></td>
								</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>
		</div>
		<div class="col">
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-chart-area"></i>
					Members Joined This Week
				</div>
				<div class="card-body">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Name</th>
								<th>Created At</th>
								<th>Activation</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tfoot>
						<tr>
							<th>Name</th>
							<th>Created At</th>
							<th>Activation</th>
							<th>Actions</th>
						</tr>
						</tfoot>
						<tbody>
							<?php
							$sQl="SELECT * FROM official_member_table WHERE member_created_at > ADDDATE(NOW(), INTERVAL -1 WEEK) ORDER BY member_created_at DESC";
							$rEs=mysqli_query($conn,$sQl);
							while($rOw=mysqli_fetch_assoc($rEs)){
								$ouo=mysqli_query($conn,"SELECT * FROM verify_mem_table WHERE member_id='$rOw[member_id]'");
								while($ure=mysqli_fetch_assoc($ouo)){
							?>
								<tr>
									<td><?php echo $rOw['member_first_name'].' '.$rOw['member_last_name'];?></td>
									<td><?php echo $rOw['member_created_at'];?></td>
									<td>
										<?php
										if($ure['verify_active']==1){
											echo 'YES';
										}
										else{
											echo 'NO';
										}
										?>
									</td>
									<td></td>
								</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>
		</div>
	</div>
	
</div>
<!-- Sticky Footer -->
<footer class="sticky-footer">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright © UrVan 2018</span>
		</div>
	</div>
</footer>
</div>
<!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">×</span>
		</button>
	</div>
	<div class="modal-body">Are you sure you want to logout?</div>
	<div class="modal-footer">
		<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
		<a class="btn btn-primary" href="../includes/logout.inc.php">Logout</a>
	</div>
</div>
</div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>
<!-- Demo scripts for this page-->
<script>
<?php
$eskyuel="SELECT DISTINCT date(client_createdat) FROM clients_table WHERE client_createdat > ADDDATE(NOW(), INTERVAL -1 WEEK) ORDER BY client_createdat ASC";
$results=mysqli_query($conn,$eskyuel);
$datea=array();
$hahaa=array();
while($row1=mysqli_fetch_assoc($results)){
$datea[]=$row1['date(client_createdat)'];
$date1=$row1['date(client_createdat)'];
$eskyuel2="SELECT * FROM clients_table WHERE date(client_createdat)='$date1'";
$res2=mysqli_query($conn,$eskyuel2);
$hahaa[]=mysqli_num_rows($res2);
}
$datecount=count($datea);
$countcount=count($hahaa);
?>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// Area Chart Example
var ctx = document.getElementById("numofclient");
var myLineChart = new Chart(ctx, {
type: 'line',
data: {
labels: [
<?php
for($x=0;$x<$datecount;$x++){
	echo "\"".$datea[$x]."\",";
}
?>
],
datasets: [{
label: "Clients Joined",
data: [
<?php
for($x=0;$x<$countcount;$x++){
	echo "\"".$hahaa[$x]."\",";
}
?>
],
lineTension: 0.3,
backgroundColor: "rgba(2,117,216,0.2)",
borderColor: "rgba(2,117,216,1)",
pointRadius: 5,
pointBackgroundColor: "rgba(2,117,216,1)",
pointBorderColor: "rgba(255,255,255,0.8)",
pointHoverRadius: 5,
pointHoverBackgroundColor: "rgba(2,117,216,1)",
pointHitRadius: 50,
pointBorderWidth: 2,
}],
},
options: {
scales: {
xAxes: [{
time: {
unit: 'date'
},
gridLines: {
display: true
},
ticks: {
maxTicksLimit: 7
}
}],
yAxes: [{
ticks: {
min: 0,
max: <?php echo max($hahaa)+1; ?>,
maxTicksLimit: 5
},
gridLines: {
color: "rgba(0, 0, 0, .125)",
}
}],
},
legend: {
display: false
}
}
});
</script>
<script>
<?php
$eskyuel="SELECT DISTINCT date(member_created_at) FROM official_member_table WHERE member_created_at > ADDDATE(NOW(), INTERVAL -1 WEEK) ORDER BY member_created_at ASC";
$results=mysqli_query($conn,$eskyuel);
$datea=array();
$hahaa=array();
while($row1=mysqli_fetch_assoc($results)){
$datea[]=$row1['date(member_created_at)'];
$date1=$row1['date(member_created_at)'];
$eskyuel2="SELECT * FROM official_member_table WHERE date(member_created_at)='$date1'";
$res2=mysqli_query($conn,$eskyuel2);
$hahaa[]=mysqli_num_rows($res2);
}
$datecount=count($datea);
$countcount=count($hahaa);
?>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// Area Chart Example
var ctx = document.getElementById("numofmember");
var myLineChart = new Chart(ctx, {
type: 'line',
data: {
labels: [
<?php
for($x=0;$x<$datecount;$x++){
	echo "\"".$datea[$x]."\",";
}
?>
],
datasets: [{
label: "Members Joined",
data: [
<?php
for($x=0;$x<$countcount;$x++){
	echo "\"".$hahaa[$x]."\",";
}
?>
],
lineTension: 0.3,
backgroundColor: "rgba(2,117,216,0.2)",
borderColor: "rgba(2,117,216,1)",
pointRadius: 5,
pointBackgroundColor: "rgba(2,117,216,1)",
pointBorderColor: "rgba(255,255,255,0.8)",
pointHoverRadius: 5,
pointHoverBackgroundColor: "rgba(2,117,216,1)",
pointHitRadius: 50,
pointBorderWidth: 2,
}],
},
options: {
scales: {
xAxes: [{
time: {
unit: 'date'
},
gridLines: {
display: true
},
ticks: {
maxTicksLimit: 7
}
}],
yAxes: [{
ticks: {
min: 0,
max: <?php echo max($hahaa)+1; ?>,
maxTicksLimit: 5
},
gridLines: {
color: "rgba(0, 0, 0, .125)",
}
}],
},
legend: {
display: false
}
}
});
</script>
</body>
<?php
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>