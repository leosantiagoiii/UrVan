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
			<li class="breadcrumb-item active">Capital Shares</li>
		</ol>
		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
			Data Table Example</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No.</th>
								<th>Name</th>
								<th>Share Capital</th>
								<th>Total Paid Up</th>
								<th>Share Balance</th>
								<th>Completed?</th>
							</tr>
						</thead>
						<tfoot>
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Share Capital</th>
							<th>Total Paid Up</th>
							<th>Share Balance</th>
							<th>Completed?</th>
						</tr>
						</tfoot>
						<tbody>
							<?php
							$sql=mysqli_query($conn,"SELECT * FROM share_capital_table");
							while($row=mysqli_fetch_assoc($sql)){
							?>
								<tr>
									<td><?php echo $row['share_id'];?></td>
									<td><a href="capital_shares_contents.php?share_id=<?php echo $row['share_id']; ?>"><?php echo $row['member_first_name'].' '.$row['member_last_name'];?></a></td>
									<td><?php echo $row['share_capital'];?></td>
									<td><?php echo $row['share_total_paid_up'];?></td>
									<td><?php echo $row['share_balance'];?></td>
									<td><?php echo $row['share_completion'];?></td>
								</tr>
							<?php
							} 
							?>
						</tbody>
					</table>
				</div>
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