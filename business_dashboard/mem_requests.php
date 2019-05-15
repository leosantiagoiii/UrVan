<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php"; ?>

<div class="container-fluid">
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-line"></i>
			Membership Requests
		</div>
		<div class="card-body">
			<?php
			$sql=mysqli_query($conn,"SELECT * FROM initial_member_appointment"); ?>
			<table id="dataTable" class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Type</th>
						<th>Appt. Date & Time</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($row=mysqli_fetch_assoc($sql)){
						$member_id=$row['member_id']; ?>
						<tr>
							<td><?php echo $member_id; ?></td>
							<td>
								<?php
								$sql2=mysqli_query($conn,"SELECT * FROM initial_official_member_table WHERE member_id='$member_id'");
								$row2=mysqli_fetch_assoc($sql2);
								echo $row2['member_first_name'].' '.$row2['member_last_name']; ?>
							</td>
							<td>
								<?php
								$sql3=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
								$row3=mysqli_fetch_assoc($sql3);
								if(isset($row2['member_id']) AND $row2['member_drivers_licence']!="NONE" AND !isset($row3['member_id'])){
									echo "Driver-Operator";
									$type="A";
								}
								elseif(isset($row2['member_id']) AND $row2['member_drivers_licence']=="NONE" AND isset($row['member_id'])){
									echo "Authorized Drivers Only";
									$type="B";
								}
								elseif(isset($row2['member_id']) AND $row2['member_drivers_licence']!="NONE" AND isset($row['member_id'])){
									echo "Both";
									$type="C";
								} ?>
							</td>
							<td>
								<?php
								echo DATE("Y M d",strtotime($row['init_appt_date'])).' | '.DATE("H:i A",strtotime($row['init_appt_time'])); ?>
							</td>
							<td>
								<a href="member_req_info.php?member_id=<?php echo $member_id; ?>&type=<?php echo $type;?>" class="btn btn-block btn-primary" target="_blank">Details</a>
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
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>