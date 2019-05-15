<?php session_start();
$stepone=$_GET['appointmentreq_steptwo'];
if( !isset($stepone) ) {
header("Location:signup_member.php?membership=error");
exit();
}else{
require "includes/dbconnect.inc.php";
$member_appointment_number = $_GET['member_appointment_number']; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <style>
            .pangalan{
            margin-top:30px;
            }
            </style>
        </head>
        <body style="
            background-image:url('images/jsaka.png');background-size: cover;
            ">
            <div class="text-center" style="padding:30px 0;">
                <img src="images/logo.png" style="width:30%" alt="">
                <img src="images/bttsclogo.png" style="width:30%" alt="">
            </div>
            <div class="container" style="border-style:solid;padding:30px;margin-bottom:80px;background-color: white;">
                <form action="includes/signup_member_step3.inc.php" method="post">
                    <h1>Your Authorized Driver(s) Details:</h1>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="member_appointment_driver_name" placeholder="Full Name">
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script>
                                $(function(){
                                    $("#starty").datepicker({dateFormat:'yy-mm-dd'}).val();
                                });
                            </script>
                            <input class="form-control form-control-lg" type="date" name="member_appointment_driver_birthdate" placeholder="Birthday" id="starty">
                        </div>
                        <div class="col">
                            <select class="form-control form-control-lg" name="member_appointment_driver_civil_status">
                                <option active>-- Civil Status --</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Separated">Separated</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <select class="form-control form-control-lg" name="member_appointment_driver_weight">
                                <option value="">-- Weight --</option>
                                <option value="unsure">Unsure</option>
                                <?php for($a=110;$a<=190;$a++){ ?>
                                <option value="<?php echo $a; ?>lb"><?php echo $a; ?>lb</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control form-control-lg" name="member_appointment_driver_height">
                                <option value="">-- Height --</option>
                                <option value="unsure">Unsure</option>
                                <?php for($a=130;$a<=196;$a++){ ?>
                                <option value="<?php echo $a; ?>cm"><?php echo $a; ?>cm</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control form-control-lg" name="member_appointment_driver_blood">
                                <option value="">-- Blood Type --</option>
                                <option value="Unsure">Unsure</option>
                                <option value="O-">O-</option>
                                <option value="O+">O+</option>
                                <option value="A-">A-</option>
                                <option value="A+">A+</option>
                                <option value="B-">B-</option>
                                <option value="B+">B+</option>
                                <option value="AB-">AB-</option>
                                <option value="AB+">AB+</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" name="member_appointment_driver_tin" placeholder="TIN">
                        </div>
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" name="member_appointment_driver_contact" placeholder="Phone Number">
                        </div>
                    </div>
                    
                    <h1>Their Go-To Emergency Contact:</h1>
                    <div class="row form-group">
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" name="member_appointment_driver_emergency_name" placeholder="Full Name">
                        </div>
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" name="member_appointment_driver_emergency_address" placeholder="Home Address">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <input class="form-control form-control-lg" type="text" name="member_appointment_driver_emergency_contact" placeholder="Contact #">
                        </div>
                        <div class="col">
                            <select class="form-control form-control-lg" name="member_appointment_driver_emergency_relationship">
                                <option value="">-- Relationship --</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Parent">Parent</option>
                                <option value="Grandparent">Grandparent</option>
                                <option value="Cousin">Cousin</option>
                                <option value="Relative">Relative</option>
                                <option value="Godparent">Godparent</option>
                                <option value="Friend">Friend</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="member_appointment_number" value="<?php echo $member_appointment_number; ?>">
                    <div class="btn-group">
                        <button class="btn btn-success btn-lg" type="submit" name="step3addmore">Add more</button>
                        <button class="btn btn-danger btn-lg" type="submit" formaction="includes/signup_member_step3_CANCEL.inc.php" name="step3cancel">Cancel Membership</button>
                        <button class="btn btn-primary btn-lg" type="submit" name="FinalStep" formaction="signup_member4.php">Submit</button>
                    </div>
                </form>
                <?php $sql="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
                $query=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($query)){
                $isPresent=$row['member_appointment_number'];
                $member_appointment_driver_number=$row['member_appointment_driver_number'];
                }
                if(empty($isPresent)){
                echo '';
                }else{
                $sql1="SELECT * FROM member_appointment_driver_details_table WHERE member_appointment_number='$member_appointment_number'";
                $query1=mysqli_query($conn,$sql1);?>
                <div class="pangalan">
                    <div class="alert alert-warning" role="alert">
                        If you want to change/edit the details, wait until you've finished all the forms.
                    </div>
                </div>
                <table class="pangalan table table-striped">
                    <tr>
                        <td style="text-align: center;font-weight: bolder;">Authorized Driver</td>
                        <td style="text-align: center;font-weight: bolder;">Emergency Contact</td>
                    </tr>
                    <?php while($row1=mysqli_fetch_assoc($query1)){
                    $sql2="SELECT * FROM member_appointment_driver_emergency_table WHERE member_appointment_driver_number=$row1[member_appointment_driver_number]";
                    $query2=mysqli_query($conn,$sql2);
                    while($row2=mysqli_fetch_assoc($query2)){ ?>
                    <tr>
                        <td><?php echo $row1['member_appointment_driver_name']; ?></td>
                        <td><?php echo $row2['member_appointment_driver_emergency_name']; ?></td>
                    </tr>
                    <?php } } ?>
                </table>
                <?php } } ?>
            </div>
        </body>
    </html>