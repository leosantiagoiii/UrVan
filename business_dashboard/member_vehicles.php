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
			<li class="breadcrumb-item active">Vehicles</li>
		</ol>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-shuttle-van"></i>
				BTTSC Vehicles
			</div>
			<div class="card-body">
				<form method="post" class="mb-3">
					<div class="row">
						<div class="col-lg-12">
							<h6>Sort By:</h6>
							<div class="btn-group">
								<button class="btn w-100 btn-primary" name="statbutton">Status</button>
								<button class="btn w-100 btn-secondary" name="idbutton">ID</button>
								<button class="btn w-100 btn-light" name="nambut">Name</button>
								<button class="btn w-100 btn-danger" name="makbut">Make</button>
								<button class="btn w-100 btn-warning" name="modbut">Model</button>
								<button class="btn w-100 btn-success" name="yearbut">Year</button>
								<button class="btn w-100 btn-info" name="pltbut">Plate Number</button>
								<button class="btn w-100 btn-primary" name="res">Recently</button>
							</div>
						</div>
					</div>
				</form>
				<div style="height:350px;overflow:auto;">
					<?php if(isset($_POST['statbutton'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY Status ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['idbutton'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY member_id ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['nambut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY member_first_name ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php }elseif(isset($_POST['makbut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY make ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['modbut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY model ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['yearbut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY year DESC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['pltbut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY plate_number ASC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['franbut'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY franchised DESC");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } elseif(isset($_POST['res'])){ ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table ORDER BY created_at");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Owner ID</th>
									<th>Member Name</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Plate Number</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$sql=mysqli_query($conn,"SELECT * FROM vehicle_table");
								while($row=mysqli_fetch_assoc($sql)){
								?>
								<tr>
									<th scope="row"><?php echo $row['status'];?></th>
									<td><?php echo $row['member_id'];?></td>
									<td><?php echo $row['member_first_name'];?></td>
									<td><?php echo $row['make'];?></td>
									<td><?php echo $row['model'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['plate_number'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
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