<?php
if((!isset($_POST['proceed']))){
	header("Location:index.php?error");
	exit();
}
else{
	require "header.php";
	$history_id=$_POST['history_id'];
	$rating_id=$_POST['rating_id'];
	$major_id=$_POST['major_id'];
	$tour_id=$_POST['tour_id'];
	$driver_type=$_POST['driver_type'];
	$driver_pk=$_POST['driver_pk'];
	$van_id=$_POST['van_id']; ?>
	<style>
		li{
			text-align: left;
		}
	</style>
	<div style="width:100%;">
		<div style="margin:50px 0;">
			<center>
			<div class="row" style="width:100%">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">	
					<form action="includes/save_rating.inc.php" method="post">
						<div class="card" style="padding:20px;">
							<h2 class="text-center" style="font-family:raleway;margin:0">Questions</h2>
							<p style="font-family:gravity; margin:0">Rate your trip! <b>1 is the least desirable</b> while <b>5 is the most desirable</b></p>
							<hr>
							<ol class="" style="font-family:gravity;">
								<li class="mb-2">
									<div class="row">
										<div class="col-lg-6">The driver/s provided high quality service and was polite and friendly with the clients</div>
										<div class="col-lg-6">
											<div class="row">
												<div class="col">1</div>
												<div class="col">2</div>
												<div class="col">3</div>
												<div class="col">4</div>
												<div class="col">5</div>
											</div>
											<div class="row">
												<div class="col">
													<input required type="radio" name="q1" value="1" id="">
												</div>
												<div class="col">
													<input type="radio" name="q1" value="2" id="">
												</div>
												<div class="col">
													<input type="radio" name="q1" value="3" id="">
												</div>
												<div class="col">
													<input type="radio" name="q1" value="4" id="">
												</div>
												<div class="col">
													<input type="radio" name="q1" value="5" id="">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="mb-2">
									<div class="row">
										<div class="col-lg-6">The driver was accommodating and showed a good attitude</div>
										<div class="col-lg-6">
											<div class="row">
												<div class="col">1</div>
												<div class="col">2</div>
												<div class="col">3</div>
												<div class="col">4</div>
												<div class="col">5</div>
											</div>
											<div class="row">
												<div class="col">
													<input required type="radio" name="q2" value="1" id="">
												</div>
												<div class="col">
													<input type="radio" name="q2" value="2" id="">
												</div>
												<div class="col">
													<input type="radio" name="q2" value="3" id="">
												</div>
												<div class="col">
													<input type="radio" name="q2" value="4" id="">
												</div>
												<div class="col">
													<input type="radio" name="q2" value="5" id="">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="mb-2">
									<div class="row">
										<div class="col-lg-6">The vehicle was clean, comfortable and safe to ride on</div>
										<div class="col-lg-6">
											<div class="row">
												<div class="col">1</div>
												<div class="col">2</div>
												<div class="col">3</div>
												<div class="col">4</div>
												<div class="col">5</div>
											</div>
											<div class="row">
												<div class="col">
													<input required type="radio" name="q3" value="1" id="">
												</div>
												<div class="col">
													<input type="radio" name="q3" value="2" id="">
												</div>
												<div class="col">
													<input type="radio" name="q3" value="3" id="">
												</div>
												<div class="col">
													<input type="radio" name="q3" value="4" id="">
												</div>
												<div class="col">
													<input type="radio" name="q3" value="5" id="">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="mb-2">
									<div class="row">
										<div class="col-lg-6">The trip went smoothly; the driver practiced safe driving</div>
										<div class="col-lg-6">
											<div class="row">
												<div class="col">1</div>
												<div class="col">2</div>
												<div class="col">3</div>
												<div class="col">4</div>
												<div class="col">5</div>
											</div>
											<div class="row">
												<div class="col">
													<input required type="radio" name="q4" value="1" id="">
												</div>
												<div class="col">
													<input type="radio" name="q4" value="2" id="">
												</div>
												<div class="col">
													<input type="radio" name="q4" value="3" id="">
												</div>
												<div class="col">
													<input type="radio" name="q4" value="4" id="">
												</div>
												<div class="col">
													<input type="radio" name="q4" value="5" id="">
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-lg-6">The trip was relaxing and no issues were encountered</div>
										<div class="col-lg-6">
											<div class="row">
												<div class="col">1</div>
												<div class="col">2</div>
												<div class="col">3</div>
												<div class="col">4</div>
												<div class="col">5</div>
											</div>
											<div class="row">
												<div class="col">
													<input required type="radio" name="q5" value="1" id="">
												</div>
												<div class="col">
													<input type="radio" name="q5" value="2" id="">
												</div>
												<div class="col">
													<input type="radio" name="q5" value="3" id="">
												</div>
												<div class="col">
													<input type="radio" name="q5" value="4" id="">
												</div>
												<div class="col">
													<input type="radio" name="q5" value="5" id="">
												</div>
											</div>
										</div>
									</div>
								</li>
							</ol>
							<hr>
							<h4 class="mb-2" style="text-align: left;font-family:raleway">Remarks and/or Complaints</h4>
							<textarea style="font-family: gravity;height:100px" class="mb-3 form-control" name="remark" id="" cols="10" rows="10"></textarea>
							<input type="hidden" name="history_id" value="<?php echo $history_id;?>">
							<input type="hidden" name="rating_id" value="<?php echo $rating_id;?>">
							<input type="hidden" name="major_id" value="<?php echo $major_id;?>">
							<input type="hidden" name="tour_id" value="<?php echo $tour_id?>">
							<input type="hidden" name="driver_type" value="<?php echo $driver_type; ?>">
							<input type="hidden" name="driver_pk" value="<?php echo $driver_pk; ?>">
							<input type="hidden" name="van_id" value="<?php echo $van_id; ?>">
							<button name="send_data" class="btn btn-success btn-block">Finish</button>
						</div>
					</form>
				</div>
				<div class="col-lg-2"></div>
			</div>
			</center>
		</div>
	</div>
	<?php
	require "footer.php";
}