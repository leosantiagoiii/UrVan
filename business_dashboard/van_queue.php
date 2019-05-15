<?php session_start();
if(isset($_SESSION['adminid'])){
  	require "header.php";
  	require "../includes/dbconnect.inc.php"; ?>
  	<main>
  		<div class="container-fluid">
  			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="index.php">Dashboard</a>
				</li>
				<li class="breadcrumb-item active">Driver Queue</li>
			</ol>					
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-money"></i>
					List of Franchised Vehicles
				</div>
				<div class="card-body">
					<table id="dataTable" class="table">
						<thead>
							<tr>
								<th>Queue</th>
								<th>Make</th>
								<th>Model</th>
								<th>Year</th>
								<th>Plate No.</th>
								<th>Member ID</th>
								<th>Affiliation</th>
								<th>Dates</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Queue</th>
								<th>Make</th>
								<th>Model</th>
								<th>Year</th>
								<th>Plate No.</th>
								<th>Member ID</th>
								<th>Affiliation</th>
								<th>Dates</th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							$sql=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised ORDER BY franc_id ASC");
							$i=0;
							while($row=mysqli_fetch_assoc($sql)){
								$vehicle_id=$row['vehicle_id'];
								$member_id=$row['member_id'];
								$sql2=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
								$row2=mysqli_fetch_assoc($sql2);
								$sql3=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
								$row3=mysqli_fetch_assoc($sql3);
								$name=$row3['member_first_name'].' '.$row3['member_last_name'];
								$i++; ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row2['make'];?></td>
									<td><?php echo $row2['model'];?></td>
									<td><?php echo $row2['year'];?></td>
									<td><?php echo $row2['plate_number'];?></td>
									<td><?php echo $member_id;?></td>
									<td><?php echo $name; ?></td>
									<td>
										<?php
										if(isset($row['start_date'])){
											if($row['start_date']==$row['end_date']){
												echo DATE("Y M d",strtotime($row['start_date']));
											}
											else{
												echo DATE("Y M d",strtotime($row['start_date'])).' - '.DATE("Y M d",strtotime($row['end_date']));
											}
										}
										else{
											echo "<i>Idle</i>";
										} ?> 
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-money"></i>
					List of Non-Franchised Vehicles
				</div>
				<div class="card-body">
					<table id="dataTable" class="table">
						<thead>
							<tr>
								<th>Queue</th>
								<th>Make</th>
								<th>Model</th>
								<th>Year</th>
								<th>Plate No.</th>
								<th>Member ID</th>
								<th>Affiliation</th>
								<th>Dates</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Queue</th>
								<th>Make</th>
								<th>Model</th>
								<th>Year</th>
								<th>Plate No.</th>
								<th>Member ID</th>
								<th>Affiliation</th>
								<th>Dates</th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							$sql=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised ORDER BY franc_id ASC");
							$i=0;
							while($row=mysqli_fetch_assoc($sql)){
								$vehicle_id=$row['vehicle_id'];
								$member_id=$row['member_id'];
								$sql2=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicle_id'");
								$row2=mysqli_fetch_assoc($sql2);
								$sql3=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
								$row3=mysqli_fetch_assoc($sql3);
								$name=$row3['member_first_name'].' '.$row3['member_last_name'];
								$i++; ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row2['make'];?></td>
									<td><?php echo $row2['model'];?></td>
									<td><?php echo $row2['year'];?></td>
									<td><?php echo $row2['plate_number'];?></td>
									<td><?php echo $member_id;?></td>
									<td><?php echo $name; ?></td>
									<td>
										<?php
										if(isset($row['start_date'])){
											if($row['start_date']==$row['end_date']){
												echo DATE("Y M d",strtotime($row['start_date']));
											}
											else{
												echo DATE("Y M d",strtotime($row['start_date'])).' - '.DATE("Y M d",strtotime($row['end_date']));
											}
										}
										else{
											echo "<i>Idle</i>";
										} ?> 
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
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