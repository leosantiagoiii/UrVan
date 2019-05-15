<?php session_start();
if(!isset($_SESSION['clientid'])){
	header("Location:index.php?error");
	exit();
}
else{
	require "header.php";
?>
<main>
	<div class="row corro" style="width:100%;">
		<div class="col-lg-2">
			<div class="sidebar_a">
				<a href="client_profile.php" class="active_a">Personal Details</a>
				<a class="dropdown-btn">
					Security&nbsp;
					<i class="fa fa-caret-down"></i>
				</a>
				<div class="dropdown-container_a">
					<a href="client_password_settings.php">&nbsp;&nbsp;&nbsp;&nbsp;Password Settings</a>
					<a href="client_acct_deactivation.php">&nbsp;&nbsp;&nbsp;&nbsp;Account Deactivation</a>
				</div>
				<a href="client_past_trips.php">Your Trips</a>
			</div>
		</div>
		<div class="col-lg-10">
			<div class="container-fluid hara">
				<?php
				$query=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id=$_SESSION[clientid]");
				$row=mysqli_fetch_assoc($query);
				?>
				<div class="row">
					<div class="col-lg-8">
						<form action="includes/personal_acct_save.inc.php" method="POST">
							<h1><?php echo $row['client_first_name'].' '.$row['client_last_name']; ?>'s Profile</h1>
							<div style="margin-top:15px;">
								<div class="form-group row">
									<div class="col-lg-2">
										<label for="">ID</label>
										<div class="input-group mb-3">
											<input required type="text" class="form-control" name="client_id" value="<?php echo $row['client_id'];?>" readonly>
										</div>
									</div>
									<div class="col">
										<label for="">Nickame</label>
										<div class="input-group mb-3">
											<input type="text" style="font-style:oblique;" name="client_nickname" class="form-control" value="<?php echo $row['client_nickname'];?>">
										</div>
									</div>
									<div class="col">
										<label for="">First Name</label>
										<div class="input-group mb-3">
											<input required type="text" class="form-control" name="client_first_name" value="<?php echo $row['client_first_name'];?>">
										</div>
									</div>
									<div class="col-lg-4">
										<label for="">Last Name</label>
										<div class="input-group mb-3">
											<input required type="text" class="form-control" name="client_last_name" value="<?php echo $row['client_last_name'];?>">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col">
										<textarea placeholder="Address" name="client_home_address" id="" class="form-control" cols="30" rows="5"><?php echo $row['client_home_address'];?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<div class="col">
										<label for="">Phone Number</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">☎</span>
											</div>
											<input required type="text" name="client_phone_number" value="<?php echo $row['client_phone_number'];?>" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
										</div>
									</div>
									<div class="col">
										<label for="">Username</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">@</span>
											</div>
											<input required type="text" name="client_username" value="<?php echo $row['client_username'];?>" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
										</div>
									</div>
									<div class="col-lg-4">
										<label for="">Email</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">✉</span>
											</div>
											<input required type="text" class="form-control" aria-label="" aria-describedby="basic-addon1" readonly="" value="<?php echo $row['client_email'];?>" name="mailz">
										</div>
									</div>
								</div>
							</div>
							<div style="text-align: right;">
								<button class="btn btn-primary" style="margin-top:0px;" name="savechang" type="submit">Save Changes</button>
							</div>
							<div style="margin-top:20px;text-align: right;font-style: oblique;margin-bottom:20px;">
								<small>Did you know you created your account on <?php echo $row['client_createdat'];?></small>
							</div>
						</form>
					</div>
					<div class="col-lg-4">
						<div class="card" style="padding:30px;">
							<h3>Profile Picture</h3>
							<center><img class="sansa" src="<?php
							if($row['client_profilepic']==NULL){
								echo 'https://www.w3schools.com/howto/img_avatar.png';
							}
							elseif($row['client_profilepic']==''){
								echo 'https://www.w3schools.com/howto/img_avatar.png';
							}
							else{
								echo 'includes/'.$row['client_profilepic'];
							}
							?>" style="border-radius: 50%;object-fit: cover;"></center>
							<br>
							<form action="includes/client_prof_pic.inc.php" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="client_id" value="<?php echo $row['client_id'];?>">
								<input type="file" name="image_file">
								<button class="btn btn-success btn-block mt-3" name="uploadp">Upload</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>
		<script>
		/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
		var dropdown = document.getElementsByClassName("dropdown-btn");
		var i;
		for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var dropdownContent = this.nextElementSibling;
		if (dropdownContent.style.display === "block") {
		dropdownContent.style.display = "none";
		} else {
		dropdownContent.style.display = "block";
		}
		});
		}
		</script>
		<?php
		require "footer.php";
		}
		?>