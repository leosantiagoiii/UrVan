<?php session_start();
require "../includes/dbconnect.inc.php";
require "header.php";
$driver_pk=$_GET['driver_pk'];
$type = $_GET['type'];
$name=$_GET['name']; ?>
<main>
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="drivers.php">Active Authorized Drivers</a>
			</li>
			<li class="breadcrumb-item active"><?php echo $_GET['driver_pk'];?></li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-truck-monster"></i>
				<?php echo $name; ?>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<?php
					$sql=mysqli_query($conn,"SELECT * FROM  booking_history_trip WHERE driver_pk='$driver_pk' ORDER BY created_at DESC"); ?>
					<table id="dataTable" class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Trip ID</th>
								<th>Dates</th>
								<th>Van Used</th>
								<th>Overall Score</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							while($history=mysqli_fetch_assoc($sql)){
								$rating_id=$history['rating_id'];
								$sql3=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id'");
								$overall=mysqli_fetch_assoc($sql3);
								$i++; ?>
								<tr>
									<td><?php echo $i ;?></td>
									<td><?php echo $major_id = $history['major_id'];?></td>
									<td>
										<?php
										$sql4=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$major_id'");
										$major=mysqli_fetch_assoc($sql4);
										if( $major['start_date']== $major['end_date']){
											echo  DATE("Y M d",strtotime($major['start_date']));
										}
										else{
											echo  DATE("Y M d",strtotime($major['start_date'])).' - '. DATE("Y M d",strtotime($major['end_date']));
										} ?>
									</td>
									<td>
										<?php 
										$van_id=$history['van_id'];
										$sql2=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$van_id'");
										$vehicle=mysqli_fetch_assoc($sql2);
										echo $vehicle['make'].' '.$vehicle['model'].' '.$vehicle['year'].' ('.$vehicle['plate_number'].')'; ?>
									</td>
									<td>
										<?php
										if(isset($overall['value'])){
											echo $overall['value'];
										}
										else{
											echo "No Rating Yet";
										} ?>
									</td>
									<td>
										<?php
										if(isset($overall['value'])){ ?>
											<a href="evalResults.php?rating_id=<?php echo $rating_id; ?>&major_id=<?php echo $major_id;?>&name=<?php echo $name;?>" class="btn btn-primary btn-block">Evaluation Details</a>
											<?php 
										} ?>
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<th>No.</th>
								<th>Trip ID</th>
								<th>Dates</th>
								<th>Van Used</th>
								<th>Overall Score</th>
								<th>Actions</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

	</div>
</main>
<?php
require "footer.php"; ?>