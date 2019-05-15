<?php session_start();
$stepone=$_GET['appointmentreq_stepone'];
if(!isset($stepone)){
header("Location:signup_member.php?membership=error");
exit();
}else{
$member_appointment_number = $_GET['member_appointment_number']; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
        </head>
        <body style="
        background-image:url('images/jsaka.png');background-size: cover;
        ">
            <div class="text-center" style="padding:30px 0;">
                <img src="images/logo.png" style="width:30%" alt="">
                <img src="images/bttsclogo.png" style="width:30%" alt="">
            </div>
            <div class="container" style="border-style:solid;padding:30px;margin-bottom:80px;background-color: white;">
                <form action="includes/signup_member_step2.inc.php" method="post">
                    <h1>In case of emergency, please notify:</h1>
                    <input class="form-control form-control-lg" type="text" placeholder="Name" name="emergencyName"><br>
                    <input class="form-control form-control-lg" type="text" placeholder="Address" name="emergencyAddress"><br>
                    <input class="form-control form-control-lg" type="text" placeholder="Telephone/Phone Number" name="emergencyPhone"><br>
                    <input class="form-control form-control-lg" type="text" placeholder="Relationship" name="emergencyRelationship"><br>
                    <br>
                    <input type="hidden" value="<?php echo $member_appointment_number; ?>" name="member_appointment_number">
                    <button class="btn btn-primary btn-lg" type="submit" name="step2submit">Add Authorised Drivers</button>
                    <button class="btn btn-primary btn-lg" type="submit" name="step2DriverOperator" formaction="signup_member4.php">Be A Driver-Operator</button>
                    <button class="btn btn-danger btn-lg" type="submit" name="step2cancel" formaction="includes/signup_member_step2_CANCEL.inc.php">Cancel Registration</button>
                </form>
            </div>
        </body>
    </html>
    <?php } ?>