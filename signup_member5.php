<?php
if(!isset($_GET['appointmentreq_stepfour'])){
	header("Location:../signup_member.php?membership=error");
	exit();
}else{
	require "includes/dbconnect.inc.php";
	require "header.php";
	$member_appointment_number=$_GET['member_appointment_number'];
	$sql="SELECT * FROM
			member_appointment_details_table
		WHERE
			member_appointment_number='$member_appointment_number'";
	$res=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($res)){ ?>
<main>
	
	<div class="container" style="padding:50px 50px;">
		<h1 class="text-center" style="font-family: raleway;">Thank you, <?php echo $row['member_appointment_first_name'].' '.$row['member_appointment_last_name']; ?>!</h1>
		<h3 class="text-center">Use the ff. to edit other details in your account.</h3>
		<h4 class="text-center">In it you will see if you've been approved to have the interview or not.</h4>
		<p style="font-size:3vh;border-style:solid;padding:10px;" class="text-center">
			<b>Username:</b> <?php echo $row['member_appointment_username']; ?> <br>
			<b>Password:</b> <?php echo $row['member_appointment_password']; ?>
		</p>
		<div class="alert alert-success" role="alert" style="font-size:2vh;">
			It is <b>HIGHLY ENCOUNRAGED</b> to check the temporary account. You'll be able to edit some details about yourself. It would help to lessen the changes once you've been approved to be interviewed.
		</div>
		<div class="alert alert-warning" role="alert" style="font-size:2vh;">
			<b>Please take note</b> that you have to create an email address to be an actual member of BTTSC. Upon the approval for the appointment, don't foget to bring the following:
			<br>
			<div class="row">
				<div class="col-lg-4">
					<b>For the member:</b>
					<ul>
						<li>OR/CR</li>
						<li>The Vehicle's Facial Receipt</li>
						<li>The Vehicle's insurance Copy</li>
						<li>Official Driver's License (if he/she is an Authorized Driver)</li>
						<li>TIN ID</li>
					</ul>
				</div>
				<div class="col-lg-4">
					<b>For the Authorized Driver:</b>
					<ul>
						<li>Official Driver's License</li>
						<li>Brgy. Clearance</li>
						<li>NBI</li>
						<li>Police Clearance</li>
						<li>Residential Certificate (CEDULA)</li>
					</ul>
				</div>
				<div class="col-lg-4">
					<b>For both (Members who are also authorised drivers):</b>
					<ul>
						<li>Please include all items</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="text-center">
			<a href="signup_member_approval.php" class="btn btn-primary btn-lg">Click <b>HERE</b> to Login</a>
		</div>
	</div>
</main>
<?php }
require "footer.php";
} ?>