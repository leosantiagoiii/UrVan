<?php 
require "header.php";
if(isset($_GET['rating'])){
	$mother=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE history_id='$_GET[history_id]'");
	$cunt=mysqli_num_rows($mother);
	$son=mysqli_fetch_assoc($mother);
	if($cunt<=0){
		//no id exists
		echo "ji";
	}
	else{ //it exists
		$father=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE history_id='$_GET[history_id]'");
		$daugh=mysqli_fetch_assoc($father);
		if($daugh['value']==null){ // it exists but value is null, so proceed ?>
			<main style="margin:120px 0px;">
				<form action="trip_evalt1on_pt2.php" method="post">
					<div class="row" style="width:100%">
						<div class="col-lg-2"></div>
						<div class="col-lg-8">
							<?php
							$query1=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE history_id='$_GET[history_id]'");
							$row1=mysqli_fetch_assoc($query1);
							$rating_id=$row1['rating_id'];
							$history_id=$_GET['history_id']; ?>
							<div style="margin:80px">
								<div class="card" style="padding:20px;">
									<h2 class="text-center" style="margin:0;font-family:raleway">You're about to rate Trip #<?php echo $son['major_id']; ?></h2>
									<hr>
									<div class="row">
										<div class="col-lg-6">
											<p style="font-family:gravity; margin:0;">
												<b>Your Tour Package:</b>
												<br>
												<?php 
												echo "\t";
												$queryA=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$son[major_id]'");
												$rowA=mysqli_fetch_assoc($queryA);
												$tour_id=$rowA['tour_id'];
												$queryB=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
												$rowB=mysqli_fetch_assoc($queryB);
												echo "<ul>";
												echo "<li>";
												echo $rowB['tour_name'];
												echo "</li>";
												echo "</ul>"; ?>
											</p>
											<p style="font-family:gravity; margin:0;">
												<b>You are/you were with:</b>
												<br>
												
												<?php
												echo "\t";
												$query2=mysqli_query($conn,"SELECT * FROM booking_clients WHERE major_id='$son[major_id]'");
												$row2=mysqli_fetch_assoc($query2);
												echo "<ul>";
												echo "<li>";
												echo $row2['first_name'].' '.$row2['last_name'];
												echo "</li>";
												echo "</ul>"; ?>
											</p>
										</div>
										<div class="col-lg-6">
											<p style="font-family:gravity; margin:0;">
												<b>Your driver was:</b>
												<br>
												
												<?php
												echo "\t";
												if($son['driver_type']=="AUTH_DRIV"){ // if they're a driver
													$query3=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE driver_id='$son[driver_pk]'");
													$row3=mysqli_fetch_assoc($query3);
													echo "<ul>";
													echo "<li>";
													echo $row3['driver_name'];
													echo "</li>";
													echo "</ul>";
												}
												else{ // if they're a operator driver
													$query3=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$son[driver_pk]'");
													$row3=mysqli_fetch_assoc($query3);
													echo "<ul>";
													echo "<li>";
													echo $row3['member_first_name'].' '.$row3['member_last_name'];
													echo "</li>";
													echo "</ul>";
												} ?>
											</p>
											<p style="font-family:gravity; margin:0;">
												<b>The van assigned to you was:</b>
												<br>
												
												<?php
												echo "\t";
												$query4=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$son[van_id]'");
												$row4=mysqli_fetch_assoc($query4);
												echo "<ul>";
												echo "<li>";
												echo $row4['make'].' '.$row4['model'].' ('.$row4['year'].') with the Plate Number of '.$row4['plate_number'];
												echo "</li>";
												echo "</ul>"; ?>
											</p>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<input type="hidden" name="history_id" value="<?php echo $_GET['history_id'];?>">
											<input type="hidden" name="rating_id" value="<?php echo $rating_id;?>">
											<input type="hidden" name="major_id" value="<?php echo $son['major_id'];?>">
											<input type="hidden" name="tour_id" value="<?php echo $tour_id?>">
											<input type="hidden" name="driver_type" value="<?php echo $son['driver_type']; ?>">
											<input type="hidden" name="driver_pk" value="<?php echo $son['driver_pk']; ?>">
											<input type="hidden" name="van_id" value="<?php echo $son['van_id']; ?>">
											<button class="btn btn-block btn-primary" name="proceed">Proceed</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2"></div>
					</div>
				</form>
			</main>
			<?php
		}
		else{
			//it already has rating. pls stop lol
		}
	}
}
else{ ?>
	<div style="margin:120px 0px;">
		<div class="row" style="width:100%">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div style="padding:30px;" class="container text-center">
					<div style="border-style:solid;border-width:1px; padding:50px;box-shadow: 10px 10px 0px 0px rgba(64,64,64,1);">
						<h1 style="font-family:raleway">This page you're trying to access is restricted.</h1>
						<div style="font-family:monsreg">Sorry</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
	<?php
}
require "footer.php";