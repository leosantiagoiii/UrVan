<?php session_start();
require "includes/dbconnect.inc.php"; ?>

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
	<a href="index.php"><<< home</a>
	<div>
		<form action="" method="post" enctype="multipart/form-data">
			<label for="">First Name</label>
			<input type="text" required name="member_first_name">
			<br>
			<label for="">Middle name</label>
			<input type="text" required name="member_middle_name">
			<br>
			<label for="">Last Name</label>
			<input type="text" required name="member_last_name">
			<br>
			<label for="">Address</label>
			<input type="text" required name="member_address">
			<br>
			<label for="">Phone Number</label>
			<input type="text" required name="member_phone_number">
			<br>
			<label for="">Birthdate</label>
			<input type="date" required name="member_birthdate">
			<br>
			<label for="">Civil Status</label>
			<select name="member_civil_status" id="">
				<option value="">---</option>
				<option value="Single">Single</option>
				<option value="Married">Married</option>
				<option value="Divorced">Divorced</option>
				<option value="Separated">Separated</option>
				<option value="Widowed">Widowed</option>
			</select>
			<br>
			<label for="">Blood Type</label>
			<input type="text" required name="member_blood_type">
			<br>
			<label for="">Weight</label>
			<input type="text" required name="member_weight">
			<br>
			<label for="">Height</label>
			<input type="text" required name="member_height">
			<br>
			<label for="">TIN</label>
			<input type="text" required name="member_tin">
			<br>
			<label for="">Username</label>
			<input type="text" required name="member_username">
			<br>
			<label for="">Email</label>
			<input type="text" required name="member_email">
			<br>
			<label for="">Password</label>
			<input type="password" required name="member_password">
			<br>
			Upload your OR/CR, Vehicle Facial Receipt, Vehicle Insurance Copy and TIN ID (images only)
			If it isn't available, on the day of your meet up, please bring all of it:
			<input name="initialFileUp[]" required type="file" multiple="multiple">
			<br>
			as driver-operator <button type="submit" formaction="includes/x_asDriverOperator.inc.php">Click Here</button>
			<br>
			with drivers only? <button type="submit" formaction="includes/x_asAuthDrivOnly.inc.php">Click Here</button>
			<br>
			be a driver-operator with your own drivers <button type="submit" formaction="includes/x_asMemberAndAuthDriv.inc.php">Click here</button>
		</form>
	</div>
</body>
</html>