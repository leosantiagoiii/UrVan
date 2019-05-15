<?php session_start();
if(!isset($_SESSION['clientid'])){
    header("Location:index.php?error=page");
}
else{
	require "header.php";
?>
<main>
	<div class="row corro">
		<div class="col-lg-2">
			<div class="sidebar_a">
				<a href="client_profile.php">Personal Details</a>
				<a class="dropdown-btn">
					Security&nbsp;
					<i class="fa fa-caret-down"></i>
				</a>
				<div class="">
					<a href="client_password_settings.php" class="active_a">&nbsp;&nbsp;&nbsp;&nbsp;Password Settings</a>
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
				<h2>Password Settings</h2>
				<p>Once you change your password, you'll receive a notification in your email <b>(<?php echo $row['client_email'];?>)</b></p>
				<form action="includes/client_pw_change.inc.php" method="POST">
					<div class="row" style="padding-right:10px;">
						<div class="col-lg-4">
							<label for="">Old Password</label>
							<input type="password" class="form-control" name="oldpw" placeholder="Enter your old password">
						</div>
						<div class="col-lg-4">
							<label for="">New Password</label>
							<input type="password" class="form-control" name="newpw" placeholder="Enter your new password" value="<?php
							if(isset($_GET['generate'])){
								echo $_GET['generatedpw'];
							}
							?>">
						</div>
						<div class="col-lg-4">
							<label for="">Confirm New Password</label>
							<input type="password" class="form-control" placeholder="Confirm your new password" name="repeatpw" value="<?php
							if(isset($_GET['generate'])){
								echo $_GET['generatedpw'];
							}
							?>">
						</div>
					</div>
					<div class="row" style="margin-top:20px;text-align:right;padding-right:10px;">
						<div class="col">
							<button class="btn btn-success" name="savechange">Save Changes</button>
						</div>
					</div>
				</form>
				<div class="row" style="margin-top:30px;">
					<div class="col">
						<h4>Or do you want us to generate a more secure password for you?</h4>
						<a style="text-align:center;" class="sureting" href="includes/client_pw_change.inc.php?generatepw=yes">Yes!</a>
					</div>
				</div>
				<?php
				if(isset($_GET['generate'])){
				?>
				<div class="row">
					<div class="col-lg-11" style="margin-top:30px;">
						<label for="">Generated Password</label>
						<div class="row">
							<div class="col">
								<input type="text" value="<?php echo $_GET['generatedpw'];?>" class="form-control" readonly>
								<small><b>*Please </b>remember this password</small>
							</div>
							<div class="col">
								<a href="includes/client_pw_change.inc.php?clear=yes" class="btn btn-danger">Clear</a>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				?>
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