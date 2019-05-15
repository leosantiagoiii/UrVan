<?php session_start();
require "includes/dbconnect.inc.php";
$member_id = $_GET['member_id']; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>UrVan | Signup</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		*{
			margin:0;
			padding:0;
		}
		@font-face{
		font-family:monsbold;
		src:url('fonts/Monsbold.otf');
		}
		@font-face{
		font-family:monsreg;
		src:url('fonts/Monsreg.otf');
		}
		@font-face{
		font-family:bebas;
		src:url('fonts/Bebas.ttf');
		}
		@font-face{
		font-family:gravity;
		src:url('fonts/Gravity.otf');
		}
		@font-face{
		font-family:raleway;
		src:url('fonts/Raleway.ttf');
		}
		@font-face{
		font-family:robotoblack;
		src:url('fonts/Robotoblack.ttf');
		}
		@font-face{
		font-family:robotoreg;
		src:url('fonts/Robotoreg.ttf');
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col-lg-6">
			<form action="includes/adding_drivers_signup.inc.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
				Driver's Name: <input type="text" name="driver_name">
				<br>
				Birthday: <input type="date" name="driver_birthdate" id="">
				<br>
				Civil Status: <input type="text" name="driver_civil_status">
				<br>
				Weight: <input type="text" name="driver_weight">
				<br>
				Height: <input type="text" name="driver_height">
				<br>
				Blood Type: <input type="text" name="driver_blood_type">
				<br>
				TIN: <input type="text" name="driver_tin">
				<br>
				Licence: <input type="text" name="driver_licence">
				<br>
				Email: <input type="text" name="driver_email">
				<br>
				Password: <input type="password" name="driver_password">
				<br>
				Contact Number: <input type="text" name="driver_contact">
				<br>
				Upload the authorised driver's official licence, BRGY. clearance, NBI, Police Clearance and Residential Certificate. Upload at least two of them. The rest can be brought during the meet up
				<input name="driverFilup[]" required type="file" multiple="multiple">
				<br>
				<h2>Driver Emergency Conatct</h2>
				Emergency name: <input type="text" name="driver_emergency_name">
				<br>
				Emergency Address: <input type="text" name="driver_emergency_address">
				<br>
				Emergency Contact: <input type="text" name="driver_emergency_contact">
				<br>
				Emergency Relationship: <input type="text" name="driver_emergency_relationship">
				
				<br>
				<button type="submit">Save Changes</button>
				<?php
				$sq=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
				$co=mysqli_num_rows($sq);
				if($co>=1){ ?>
					<button type="submit" formaction="includes/finish_pro.inc.php">Finish Process</button>
					<?php
				} ?>
			</form>
		</div>
		<div class="col-lg-6">
			<?php
			$s=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_table WHERE member_id='$member_id'");
			$c=mysqli_num_rows($s);
			if($c>=1){ ?>
				<ul>
					<?php
					while($r=mysqli_fetch_assoc($s)){ ?>
						<li>
							<?php
							echo $r['driver_name'].' - '.$r['driver_licence']; ?>
							<ul>
								<li>
									<?php
									$s3=mysqli_query($conn,"SELECT * FROM initial_official_authorized_driver_emergency_contact_table WHERE driver_id='$r[driver_id]'");
									$r2=mysqli_fetch_assoc($s3);
									echo $r2['driver_emergency_name']; ?>
								</li>
							</ul> 
						</li>
						<?php 
					} ?>
				</ul>
				<?php
			} ?>
		</div>
	</div>
</body>
</html>