<?php require "header.php";
$sql=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$_SESSION[driverid]' ORDER BY created_at ASC");
$count=mysqli_num_rows($sql);
if($count<=0){ ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-10">
				<center>
					<div class="card" style="padding:40px;margin:120px 0;">
						<h1 style="font-family:monsbold;margin:0;text-align:right;">Aw! You haven't had your first trip yet! Worry not, it'll be your turn one of these days!</h1>
						<p style="text-align:left;font-family:robotoreg;margin:0"><br>Regularly check your email for more updates</p>
					</div>
				</center>
			</div>
			<div class="col-lg-1"></div>
		</div>
	</div>
	<?php
}
else{ ?>
		<div style="margin:80px 0;" class="container-fluid">
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					<h1 style="font-family:monsbold;margin:0;text-align:right;font-size:37px;">Your Past Trips</h1>
					<hr>
					<div class="card" style="font-family:gravity;font-size:14px;height:400px;overflow-y:scroll;">
						<center>
							<table class="table table-hover">
								<thead style="text-align:left" class="thead-light">
									<tr>
										<th style="width:20%">Trip to</th>
										<th style="width:36%">Van Used</th>
										<th style="width:20%">Evaluation Score</th>
										<th>Dates</th>
									</tr>
								</thead>
								<tbody style="text-align:left">
								<?php
									while($row=mysqli_fetch_assoc($sql)){
										$rating_id=$row['rating_id'];
										$sql3=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$row[major_id]'");
										$row3=mysqli_fetch_assoc($sql3);
										$sql2=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id'");
										while($row2=mysqli_fetch_assoc($sql2)){ ?>

											<tr>
												<td>
													<?php 
													$tour_id=$row3['tour_id'];
													$mu=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
													$mumi=mysqli_fetch_assoc($mu);
													echo $mumi['tour_name']; ?>
												</td>
												<td>
													<?php
													$vanid=$row['van_id'];
													$mei=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vanid'");
													$mai=mysqli_fetch_assoc($mei);
													echo $mai['make'].' '.$mai['model'].' ('.$mai['year'].') with the Plate Number of '.$mai['plate_number']; ?>
												</td>
												<td>
													<?php
													if(!isset($row2['value'])){
														echo "No rating";
													}
													else{
														echo $row2['value'];
													} ?>
												</td>
												<td>
													<?php
													$t1=strtotime($row3['start_date']);
													$t2=strtotime($row3['end_date']);
													if($t1==$t2){
														echo $nT1=DATE("Y M d", $t1);
													}
													else{
														$nT1=DATE("Y M d", $t1);
														$nT2=DATE("Y M d", $t2);
														echo $nT1.' to '.$nT2;
													} ?> 
												</td>
											</tr>

										<?php
										}
									} ?>
								</tbody>
							</table>
						</center>
					</div>
				</div>
				<div class="col-lg-2"></div>
			</div>
		</div>
		<?php
	
}
require "footer.php";?>