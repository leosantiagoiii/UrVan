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
	<form action="includes/driveroperator_final.inc.php" method="post" enctype="multipart/form-data">
		<?php echo $member_id; ?>
		<br>
		Your Licence:
		<input type="text" name="member_drivers_licence">
		<br>
		Upload your Driver's Licence, Barangy Clearance, NBI, Police Clearance and Residential Certificate
		If it isn't available, on the day of your meet up, please bring all of it:
		<input name="secondaryFillup[]" required type="file" multiple="multiple">
		<h2>emergency contact</h2>
		Name: <input type="text" name="member_emergency_name" id="">
		<br>
		Address: <input type="text" name="member_emergency_address" id="">
		<br>
		Phone: <input type="text" name="member_emergency_phone" id="">
		<br>
		Relationship: <input type="text" name="member_emergency_relationship" id="">
		<br>
		<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
		<button type="submit">Submit</button>
	</form>
</body>
</html>