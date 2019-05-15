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
	<form action="includes/save_memb_info.inc.php" method="post">
		<?php echo $member_id; ?>
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