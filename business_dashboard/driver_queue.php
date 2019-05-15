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
			<div class="row">
				<div class="col-lg-6">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-money"></i>
							List of Drivers
						</div>
						<div class="card-body" style="overflow:scroll;height:600px;">
							<table class="table" id="dataTable">
								<thead>
									<tr>
										<th>Name</th>
										<th>Affiliation</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Name</th>
										<th>Affiliation</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									$sql1=mysqli_query($conn,"SELECT * FROM official_member_table WHERE active='0' AND member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1') AND member_drivers_licence!='NONE' AND member_drivers_licence IS NOT NULL");
									while($row1=mysqli_fetch_assoc($sql1)){ ?>
										<tr>
											<td><?php echo $row1['member_first_name'].' '.$row1['member_last_name']; ?></td>
											<td>Driver Operator</td>
											<td>
												<?php
												$sqla=mysqli_query($conn,"SELECT * FROM driver_queue WHERE driver_pk='$row1[member_id]'"); //
												$count1=mysqli_num_rows($sqla);
												if($count1>=1){
													echo "In queue";
												}
												else{
													echo "Absent";
												} ?>
											</td>
											<td>
												<form action="../includes/driver_queue.inc.php" method="get">
													<?php
													if($count1<=0){ ?>
														<input type="hidden" name="driver_pk" value="<?php echo $row1['member_id']; ?>">
														<input type="hidden" name="type_acct" value="MEMBER">
														<button class="btn btn-block btn-primary" name="addit">Add</button>
														<?php 
													} ?>
												</form>
											</td>
										</tr>
										<?php
									} ?>
									<?php
									$sql2=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id IN (SELECT member_id FROM official_member_table WHERE active='0')");
									while($row2=mysqli_fetch_assoc($sql2)){ ?>
										<tr>
											<td> <?php echo $row2['driver_name']; ?></td>
											<td>
												Affiliation w/ 
												<?php 
												$mme_id=$row2['member_id'];
												$sqlop=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$mme_id'");
												$co=mysqli_fetch_assoc($sqlop);
												echo $co['member_first_name'].' '.$co['member_last_name']; ?>
												[<?php echo $mme_id=$row2['member_id'];?>]
											</td>
											<td>
												<?php
												$sqlb=mysqli_query($conn,"SELECT * FROM driver_queue WHERE driver_pk='$row2[driver_id]'"); //
												$count2=mysqli_num_rows($sqlb);
												if($count2>=1){
													echo "In queue";
												}
												else{
													echo "Absent";
												} ?>
											</td>
											<td>
												<form action="../includes/driver_queue.inc.php" method="get">
													<?php
													if($count2<=0){ ?>
														<input type="hidden" name="driver_pk" value="<?php echo $row2['driver_id']; ?>">
														<input type="hidden" name="type_acct" value="AUTH_DRIV">
														<button class="btn btn-block btn-primary" name="addit">Add</button>
														<?php
													} ?>
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
				<div class="col-lg-6">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-money"></i>
							Driver Queue
						</div>
						<div class="card-body" style="overflow:scroll;height:600px;">
							<table class="tbl table" id="dataTable">
								<thead>
									<tr>
										<th width="10%">Position</th>
										<th>Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$miu=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status IS NULL ORDER BY main_id ASC");
									$i=0;
									while($queue=mysqli_fetch_assoc($miu)){
										$i++; ?>
										<tr>
											<td><?php echo $i; ?></td>
											<?php
											if($queue['type']=="MEMBER"){
												$member=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$queue[driver_pk]'");
												$member_ftch=mysqli_fetch_assoc($member); ?>
												<td><?php echo $member_ftch['member_first_name'].' '.$member_ftch['member_last_name'];?></td>
												<?php
											}
											else{
												$driver=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$queue[driver_pk]'");
												$driver_ftch=mysqli_fetch_assoc($driver); ?>
												<td><?php echo $driver_ftch['driver_name'];?></td>
												<?php
											} ?>
											<td>
												<form action="../includes/driver_queue.inc.php" method="get">
													<input type="hidden" name="driver_pk" value="<?php echo $queue['driver_pk']; ?>">
													<button class="btn btn-block btn-danger" name="remove_queue">Remove</button>
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
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-money"></i>
							Driver Decline Await
						</div>
						<div class="card-body">
							<table class="table tbl">
								<thead>
									<tr>
										<th>Name</th>
										<th>Trip ID</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
										<?php
										$getDecline=mysqli_query($conn,"SELECT * FROM driver_queue WHERE acceptance='refused'");
										while($getDecline_=mysqli_fetch_assoc($getDecline)){ ?>
											<tr>
												<?php
												if($getDecline_['type']=="MEMBER"){
													$getNameofMem=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$getDecline_[driver_pk]'");
													$getNameofMem_=mysqli_fetch_assoc($getNameofMem);
													echo '<td>'.$getNameofMem_['member_first_name'].' '.$getNameofMem_['member_last_name'].'</td>';
												}
												else{ // auth driver
													$getNameofDri=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$getDecline_[driver_pk]'");
													$getNameofDri_=mysqli_fetch_assoc($getNameofDri);
													echo '<td>'.$getNameofDri_['driver_name'].'</td>';
												} ?>
												<td>
													<?php echo $getDecline_['status']; ?>
												</td>
												<td>
													<a href="../includes/decline_trip_byDriv.inc.php?major_id=<?php echo $getDecline_['status']; ?>&id=<?php echo $getDecline_['main_id'];?>" class="btn btn-block btn-primary">Accept</a>
												</td>
											</tr>
											<?php
										} ?>
								</tbody>
							</table>
						</div>
					</div>
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