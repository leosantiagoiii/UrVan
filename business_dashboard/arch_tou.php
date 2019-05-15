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
			<li class="breadcrumb-item active">Archived Tours</li>
		</ol>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-trash"></i>
				Archived Tours
			</div>
			<div class="card-body">
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tour Name</th>
							<th>Price</th>
							<th>~</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Tour Name</th>
							<th>Price</th>
							<th>~</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						$sql=mysqli_query($conn,"SELECT * FROM tours_and_packages_archive_table");
						while($row=mysqli_fetch_assoc($sql)){ ?>
							<tr>
								<td><?php echo $row['tour_id'];?></td>
								<td><?php echo $row['tour_name'];?></td>
								<td>Php<?php echo $row['tour_price'];?></td>
								<td>
									<form action="../includes/bring_archive_tours.inc.php" method="post">
										<input type="hidden" name="tour_id" value="<?php echo $row['tour_id'];?>">
										<button class="btn btn-success w-100" name="return">Retrieve</button>
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
} ?>