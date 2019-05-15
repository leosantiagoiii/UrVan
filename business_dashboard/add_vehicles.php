<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
$member_id=$_GET['member_id'];
$count=$_GET['count'];
$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
$row=mysqli_fetch_assoc($sql);
$sql2=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE member_id='$member_id'");
?>
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Vehicle Management</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			<?php echo $row['member_first_name'].' '.$row['member_last_name']; ?>
		</div>
		<div class="card-body">
			<?php if($count<=0){ ?>
				<div class="text-center" style="margin:25px 0 25px 0;">
					<h2>Add Vehicles</h2>
					<a href="add_vehicles2.php?member_id=<?php echo $member_id; ?>" style="color:gray;">
						<i class="fas fa-plus" style="font-size:20px;"></i>
						<i class="fas fa-bus" style="font-size:40px;"></i>
					</a>
				</div>
			<?php } else { ?>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Status</th>
							<th>Make</th>
							<th>Model</th>
							<th>Year</th>
							<th>Plate Number</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($Ro=mysqli_fetch_assoc($sql2)){
						?>
						<tr>
							<th scope="row"><?php echo $Ro['id'];?></th>
							<td><?php echo $Ro['status'];?></td>
							<td><?php echo $Ro['make'];?></td>
							<td><?php echo $Ro['model'];?></td>
							<td><?php echo $Ro['year'];?></td>
							<td><?php echo $Ro['plate_number'];?></td>
							<td>
								<form action="edit_remove_vehi.php" method="GET">
									<input type="hidden" name="member_id" value="<?php echo $member_id;?>">
									<input type="hidden" name="vehicle_id" value="<?php echo $Ro['id'];?>">
									<div class="btn-group">
										<button class="btn btn-info" name="fororo">Edit</button>
										<button class="btn btn-danger" name="lalal" formaction="../includes/remove_vehi.inc.php">Remove</button>
									</div>
								</form>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<div class="text-center" style="margin:25px 0 25px 0;">
					<h2>Add Vehicles</h2>
					<a href="add_vehicles2.php?member_id=<?php echo $member_id; ?>" style="color:gray;">
						<i class="fas fa-plus" style="font-size:20px;"></i>
						<i class="fas fa-bus" style="font-size:40px;"></i>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>