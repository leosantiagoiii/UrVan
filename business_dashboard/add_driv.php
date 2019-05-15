<?php session_start();
require "../includes/dbconnect.inc.php";
require "header.php";
$member_id=$_GET['member_id']; ?>

<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Driver Management</li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			<?php
			$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
			$member=mysqli_fetch_assoc($sql);
			echo $member['member_first_name'].' '.$member['member_last_name'].'\'s Drivers'; ?>
		</div>
		<div class="card-body" style="width:100%;overflow-y: scroll">
			<table id="dataTable" class="table">
				<thead>
					<tr>
						<th>No.</th>
						<th>ID</th>
						<th>Name</th>
						<th>License</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql2=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id='$member_id'");
					$i=0;
					while($auth_dr=mysqli_fetch_assoc($sql2)){
						$i++; ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $auth_dr['driver_id'];?></td>
							<td><?php echo $auth_dr['driver_name'];?></td>
							<td><?php echo $auth_dr['driver_licence'];?></td>
							<td><?php echo $auth_dr['driver_email'];?></td>
							<td>
								<div class="btn-group d-flex">
									<a href="edit_driver.php?driver_id=<?php echo $auth_dr['driver_id']; ?>&member_id=<?php echo $member_id; ?>" class="btn btn-primary w-100">More</a>
									<a href="../includes/remove_driver.inc.php?member_id=<?php echo $member_id;?>&driver_id=<?php echo $auth_dr['driver_id'];?>" class="btn btn-danger w-100">Remove</a>
								</div>
							</td>
						</tr>
						<?php
					} ?>
				</tbody>
				<tfoot>
					<tr>
						<th>No.</th>
						<th>ID</th>
						<th>Name</th>
						<th>License</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
			<div class="text-center" style="margin:25px 0 25px 0;">
				<h2>Add Drivers</h2>
				<a href="add_driv2.php?member_id=<?php echo $member_id; ?>" style="color:gray;">
					<i class="fas fa-plus" style="font-size:20px;"></i>
					<i class="fas fa-taxi" style="font-size:40px;"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
require "footer.php"; ?>