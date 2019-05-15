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
			<li class="breadcrumb-item">
				<a href="capital_shares.php">Capital Shares</a>
			</li>
			<li class="breadcrumb-item active">Content</li>
		</ol>
		<!-- DataTables Example -->
		<?php
		$share_id=$_GET['share_id'];
		$sqlA=mysqli_query($conn,"SELECT * FROM share_capital_table WHERE share_id='$share_id'");
		$rowA=mysqli_fetch_assoc($sqlA);
		?>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				<?php
				echo $rowA['member_first_name'].' '.$rowA['member_last_name'];
				?>
			</div>
			<div class="card-body">
				<h1>Monthly</h1>
				<!--  -->
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Date</th>
								<th>Time</th>
								<th>Voucher</th>
								<th>Payment</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sum=0;
							$sqlB=mysqli_query($conn,"SELECT * FROM share_capital_monthly WHERE share_id=$rowA[share_id] ORDER BY share_year ASC");
							while($rowB=mysqli_fetch_assoc($sqlB)){
							?>
							<tr>
								<td><?php echo $rowB['share_month_id'];?></td>
								<td><?php echo $rowB['share_date'];?></td>
								<td><?php echo $rowB['share_time'];?></td>
								<td><?php echo $rowB['share_monthly_voucher'];?></td>
								<td><?php echo $rowB['share_month_pay'];?></td>
							</tr>
							<?php
							$sum+=$rowB['share_month_pay'];
							}
							?>
						</tbody>
						<tfoot>
						<tr>
							<th>ID</th>
							<th>Date</th>
							<th>Time</th>
							<th>Voucher</th>
							<th><?php echo $sum;?></th>
						</tr>
						</tfoot>
					</table>
				</div>
				<!--  -->
				<div id="piechart1" style="height:400px;width:100%;"></div>
				<hr>
				<h1>Yearly</h1>
				<!--  -->
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Year</th>
								<th>Voucher</th>
								<th>Amount Paid</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sum=0;
							$sqlC=mysqli_query($conn,"SELECT * FROM share_capital_yearly WHERE share_id=$rowA[share_id]");
							while($rowC=mysqli_fetch_assoc($sqlC)){
							?>
							<tr>
								<td><?php echo $rowC['share_yearly_id'];?></td>
								<td><?php echo $rowC['share_year'];?></td>
								<td><?php echo $rowC['share_yearly_voucher'];?></td>
								<td><?php echo $rowC['share_yearly_amt'];?></td>
							</tr>
							<?php
							$sum+=$rowC['share_yearly_amt'];
							}
							?>
						</tbody>
						<tfoot>
						<tr>
							<th>ID</th>
							<th>Year</th>
							<th>Voucher</th>
							<th><?php echo $sum;?></th>
						</tr>
						</tfoot>
					</table>
				</div>
				<!--  -->
				<div id="donutchart" style="height:400px;width:100%;"></div>
			</div>
			<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
		</div>
	</div>
</main>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
['Year', 'Percentage of Payment'],
<?php
$sum=0;
$sqlC=mysqli_query($conn,"SELECT * FROM share_capital_yearly WHERE share_id=$rowA[share_id]");
while($rowC=mysqli_fetch_assoc($sqlC)){
	echo "['".$rowC['share_year']."', ".$rowC['share_yearly_amt']."],";
	$sum+=$rowC['share_yearly_amt'];
}
$ans=$rowA['share_capital']-$sum;
?>
['<?php echo 'Unpaid';?>',<?php echo $ans; ?>]
]);
var options = {
title: 'Yearly Payments',
pieHole: 0.4,
};
var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
chart.draw(data, options);
}
</script>







<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
	['Year', 'Payments'],
<?php
$sqlB=mysqli_query($conn,"SELECT * FROM share_capital_monthly WHERE share_id=$rowA[share_id] ORDER BY share_year ASC");
while($rowB=mysqli_fetch_assoc($sqlB)){
	echo "['".$rowB['share_date']."', ".$rowB['share_month_pay']."],";
}
?>
]);
var options = {
title: '<?php echo $rowA['member_first_name'].' '.$rowA['member_last_name']; ?>\'s Monthly Payment',
curveType: 'function',
legend: { position: 'bottom' }
};
var chart = new google.visualization.LineChart(document.getElementById('piechart1'));
chart.draw(data, options);
}
</script>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>