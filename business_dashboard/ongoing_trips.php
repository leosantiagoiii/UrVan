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
			<li class="breadcrumb-item active">Ongoing Trips</li>
		</ol>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-shuttle-van"></i>
				On going Trips
			</div>
			<div class="card-body">
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th>Trip ID</th>
							<th>By</th>
							<th>To</th>
							<th>Duration</th>
							<th>Amount</th>
							<th>Driver(s)</th>							
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Trip ID</th>
							<th>By</th>
							<th>To</th>
							<th>Duration</th>
							<th>Amount</th>
							<th>Driver(s)</th>							
						</tr>
					</tfoot>
					<tbody>
						<?php
						$sql=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='NO' AND refunded='NO'");
						while($major=mysqli_fetch_assoc($sql)){
							$sql2=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE major_id='$major[major_id]'");
							$sli=mysqli_fetch_assoc($sql2);
							$sql3=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major[major_id]'");
							$tra=mysqli_fetch_assoc($sql3);
							$sql4=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$major[client_id]'");
							$cli=mysqli_fetch_assoc($sql4);
							$sql5=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$major[tour_id]'");
							$tou=mysqli_fetch_assoc($sql5);

							$mem=mysqli_query($conn,"SELECT * FROM driver_queue WHERE status='$major[major_id]'");
							$bla=mysqli_num_rows($mem);
							if($bla<=0){
								$driver_name="<i>Unassigned</i>";
							}
							else{
								$arrayDri=array();
								while($quoto=mysqli_fetch_assoc($mem)){
									$driver_pk=$quoto['driver_pk'];
									if($quoto['type']=="MEMBER"){
										$sal=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$driver_pk'");
										$sem=mysqli_fetch_assoc($sal);
										$name=$sem['member_first_name'].' '.$sem['member_last_name'];
									}
									else{//auth driv
										$sal=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$driver_pk'");
										$sem=mysqli_fetch_assoc($sal);
										$name=$sem['driver_name'];
									}
									$arrayDri[]=$name;
								}
								$driver_name=implode("<br>",$arrayDri);
								unset($arrayDri);
							}

							if($major['duration']>=0 && $tra['transaction_type']=="DEPOSIT" && $sli['approval']=="APPROVED"){?>
								<tr>
									<td><?php echo $major['major_id'];?></td>
									<td>@<?php echo $cli['client_username'];?></td>
									<td><?php echo $tra['trip_name'];?></td>
									<td><?php echo $major['duration'];?> day(s) [<?php echo $major['start_date'].' - '.$major['end_date'];?>]        <!-- deposit --></td>
									<td>
										<?php echo 'Php '.$tra['total_amount']; ?>
									</td>
									<td><?php echo $driver_name; ?></td>
								</tr>
								<?php
							}
							elseif($major['duration']>=0 && $tra['transaction_type']=="STRIPE" && $tra['receipt_url']!=NULL){ ?>
								<tr>
									<td><?php echo $major['major_id'];?></td>
									<td>@<?php echo $cli['client_username'];?></td>
									<td><?php echo $tra['trip_name'];?></td>
									<td><?php echo $major['duration'];?> day(s) [<?php echo $major['start_date'].' - '.$major['end_date'];?>]       <!-- stripe --></td>
									<td>
										<?php echo 'Php '.$tra['total_amount']; ?>
									</td>
									<td><?php echo $driver_name; ?></td>
								</tr>
								<?php
							}
							elseif($major['duration']>=1 && $sli['approval']=="APPROVED"){ ?>
								<tr>
									<td><?php echo $major['major_id'];?></td>
									<td>@<?php echo $cli['client_username'];?></td>
									<td><?php echo $tra['trip_name'];?></td>
									<td><?php echo $major['duration'];?> day(s) [<?php echo $major['start_date'].' - '.$major['end_date'];?>]        <!-- stripe/deposit doesnt matter --></td>
									<td>
										<?php echo 'Php '.$tra['total_afterbal']; ?>
									</td>
									<td><?php echo $driver_name; ?></td>
								</tr>
								<?php
							}
							else{
							    //nothing
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	require "footer.php";
} ?>