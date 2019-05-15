<?php session_start();
if(!isset($_SESSION['clientid'])){
	header('Location:index.php?error');
	exit();
}
else{
	require "header.php";
	$a="SELECT * FROM client_deact_request WHERE client_id=$_SESSION[clientid]";
	$b=mysqli_query($conn,$a);
	$cou=mysqli_num_rows($b);
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
						<a href="client_password_settings.php">&nbsp;&nbsp;&nbsp;&nbsp;Password Settings</a>
						<a href="client_acct_deactivation.php" class="active_a">&nbsp;&nbsp;&nbsp;&nbsp;Account Deactivation</a>
					</div>
					<a href="client_past_trips.php">Your Trips</a>
				</div>
			</div>
			<div class="col-lg-10">
				<div class="row">
					<div class="col-lg-9">
						<div class="container-fluid hara">
							<?php
							$query=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id=$_SESSION[clientid]");
							$row=mysqli_fetch_assoc($query);
							?>
							<h1 style="margin-bottom:18px;">Request for Account Deactivation</h1>
							<h4 style="color:#77797f;text-transform:uppercase;"><b>This will Deactivate Your Account</b></h4>
							<p>This process will entirely remove your account from UrVan. Please be mindful that everything cannot be retrieved once you have finished.<br>If you want to use UrVan again, you will have to create a new account.</p>
							<h4 style="color:#77797f;text-transform:uppercase;"><b>additional information</b></h4>
							<ul class="hehehe">
								<li>If you just want to change your username, please change it in your <a href="client_password_settings.php">profile</a>.</li>
								<li>If you want to download your personal data, you must request it using this <a href="">link</a>. Doing so would require your presence in the site so request for it first before deactivating.</li>
								<li>We only collect information from you that involved the business process to further improve our services in the future. We do not in any way keep personal data.</li>
							</ul>
							<?php
							if($cou<=0){ ?>
								<form action="includes/client_deac_req.inc.php" method="POST">
									<?php 
									if(isset($_GET['DEAC_REQ_EMAIL']) AND $_GET['DEAC_REQ_EMAIL']=='CANCELLED'){
									?>
										<div class="alert alert-success" role="alert">
											<strong>HOORAY!</strong> You're not leaving us!
										</div>
									<?php
									}
									?>
									<div class="alert alert-primary" role="alert">
										<strong>Before you</strong>. hit the button below, please read the notes above.
									</div>
									<?php $hash=SHA1(rand(0,1000)); ?>
									<input type="hidden" name="hash_to_deac" value="<?php echo $hash; ?>">
									<input type="hidden" name="client_id" value="<?php echo $_SESSION['clientid']; ?>">
									<button name="deactivate_button" class="btn btn-danger" type="submit">Deactivate</button>
								</form>
							<?php }
							else{ ?>
								<form action="includes/client_deac_req.inc.php" method="POST">
									<div class="alert alert-danger" role="alert">
										<strong>Oh, okay</strong>. We've sent you an email for the confirmation. If you want to cancel the request, please hit the button below.
									</div>
									<input type="hidden" name="client_id" value="<?php echo $_SESSION['clientid']; ?>">
									<button name="cancel_request" class="btn btn-secondary" type="submit">Cancel Request</button>
								</form>
							<?php } ?>
						</div>
					</div>
					<div class="col-lg-3"></div>
				</div>
			</div>
		</div>
	</main>
	<script>
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