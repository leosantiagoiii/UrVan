<?php session_start();
if(isset($_POST['step2DriverOperator']) || isset($_POST['FinalStep'])){
	require "includes/dbconnect.inc.php";
	$member_appointment_number = $_POST['member_appointment_number'];
	if( isset($_POST['step2DriverOperator']) ){
		$member_appointment_emergency_name=$_POST['emergencyName'];
		$member_appointment_emergency_address=$_POST['emergencyAddress'];
		$member_appointment_emergency_phone=$_POST['emergencyPhone'];
		$member_appointment_emergency_relationship=$_POST['emergencyRelationship'];
		$sql="INSERT INTO member_appointment_emergency_table (
				member_appointment_number,
				member_appointment_emergency_name,
				member_appointment_emergency_address,
				member_appointment_emergency_phone,
				member_appointment_emergency_relationship
			) VALUES (
				'$member_appointment_number',
				'$member_appointment_emergency_name',
				'$member_appointment_emergency_address',
				'$member_appointment_emergency_phone',
				'$member_appointment_emergency_relationship'
			)";
		$query=mysqli_query($conn,$sql);
} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		</head>
		<body style="background-image:url('images/jsaka.png');background-size: cover;">
			<div class="text-center" style="padding:30px 0;">
				<img src="images/logo.png" style="width:30%" alt="">
				<img src="images/bttsclogo.png" style="width:30%" alt="">
			</div>
			<div class="container" style="border-style:solid;padding:30px;margin-bottom:80px;background-color: white;">
				<form action="includes/signup_member_step4.inc.php" method="post">
					<h1>Desired Date and Time for the Appointment</h1>
					<div class="form-group">
						<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                        <script>
							$(document).ready(function(){
								$.datepicker.setDefaults({
									dateFormat: 'yy-mm-dd'
								});
								$(function(){
									var minDate=new Date(); //
									minDate.setDate(minDate.getDate()+7);
									var maxDate=new Date(); //
									// maxDate.setDate(minDate.getDate()+365);
									console.log(minDate);
									console.log(maxDate);
									$('#starty').datepicker({
										numberOfMonth:1,
										minDate:minDate,
										// maxDate:maxDate, //
									});
								});
							});
						</script>

						Desired Date: <input class="form-control form-control-lg" type="date" name="member_appointment_datemeet" required id="starty">
					</div>
					<div class="form-group">
						Desired Time: <input class="form-control form-control-lg" type="Time" name="member_appointment_timemeet" required>
					</div>
					<input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
					<div class="btn-group">
					<button class="btn btn-lg btn-success" type="submit" name="FinishRequest">Finish Request</button>
					<button class="btn btn-lg btn-danger" type="submit" name="step3cancel" formaction="includes/signup_member_step3_CANCEL.inc.php">Cancel Request</button>
					</div>
				</form>
			</div>
		</body>
	</html>
	<?php }else{
		header("Location:signup_member.php?membership=error");
		exit();
	}