<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <title></title>
            <style>
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
            .content-s{
            padding-top:30px;
            }
            .topnav{
            overflow: hidden;
            background-color: black;
            }
            .topnav a{
            float: left;
            color:white;
            text-align: center;
            padding: 1em 3em;
            text-decoration: none;
            font-size: 0.8em;
            }
            .topnav a:hover{
            background-color: #ddd;
            color: black;
            }
            .topnav a.active {
            background-color: #4CAF50;
            color: white;
            }
            .navbar{
            font-family:Helvetica;
            font-size:0.8em;
            }
            .topnav-right {
            float: right;
            }
            .header-h a{
            color:white;
            transition: 0.5s;
            }
            .header-h a:hover{
            color:#1565ae;
            }
            .rightlink-h a{
            color:white;
            }
            .rightlink-h a:hover{
            color:#ed3237;
            }
            .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
            }
            .navbar-toggler {
            border-color:white;
            }
            .dropdown-h a{
            color:black;
            font-size:0.8em;
            }
            .navbar-nav li{
            margin: 0 10px;
            }
            .navbar{
            padding: 20px 50px;
            font-family:monsreg;
            }
            .btn-logout{
            border-color: #ed3237;
            background-color: black;
            color:#ed3237;
            font-size:1em;
            transition:0.8s;
            }
            .btn-logout:hover{
            background-color: #1565ae;
            color: black;
            border-color: #1565ae;
            }
            .signup-grid{
            display:grid;
            grid-template-columns: repeat(2,1fr);
            height:900px;
            min-height: 900px;
            }
            .signup-right{
            padding: 50px 40px 0 40px;
            }
            .signup-left{
            background-image: url('images/jaja.png');
            background-position: left;
            background-size:cover;
            }
            .signup-btn{
            background-color:transparent;
            color:white;
            border-style: solid;
            border-color: white;
            transition: 0.5s;
            margin-top:20px;
            }
            .signup-btn:hover{
            color:black;
            border-color: transparent;
            background-color: white;
            }
            .errormsg-sign{
            position:absolute;
            background-color:red;
            opacity:0.8;
            color:white;
            padding:30px;
            right:0%;
            bottom:0%;
            }
            .msgsign{
            margin-top:20px;
            margin-bottom: 20px;
            }
            .video-container {
            position: relative;
            }
            video {
            height: auto;
            vertical-align: middle;
            width: 100%;
            opacity:0.9;
            background-color: white;
            }
            .overlay-desc {
            background: rgba(0,0,0,0);
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            }
            .below-video-content{
            margin: 0 auto;
            width: 100%;
            }
            .below-video-content p{
            color: green;
            font-family: 'Open Sans', sans-serif;
            font-size: 1.1rem;
            line-height: 1.7rem;
            }
            label{
            color:white;
            }
            .form-control{
            background-color:transparent;
            border-style: solid;
            border-color: white;
            color:white;
            }
            </style>
            <body>
                <main>
                    <div class="signup-grid" style="background-color:black;">
                        
                        <div>
                            <div class="signup-right">
                                <form action="includes/signup_member_step1.inc.php" method="post" class="needs-validation">
                                    <div style="text-align:right;">
                                        <a href="index.php"><img class="photosign" src="images/bwLogo.png" style="text-align:right;" width="45%" alt=""></a>
                                        <br>
                                        <h1 class="msgsign" style="font-family:monsbold; font-size:2.1em; text-align:right; color:white;">Request For A Membership Appointment</h1>
                                    </div>
                                    <!--names-->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="inputEmail4">First Name</label>
                                            <input type="text" name="member-first-name" class="form-control" required>
                                            <div class="valid-tooltip">Looks Good!</div>
                                        </div>
                                        <div class="form-group col">
                                            <label for="inputPassword4">Last Name</label>
                                            <input type="text" name="member-last-name" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPassword4">Middle Name</label>
                                            <input placeholder="(Optional)" type="text" name="member-middle-name" class="form-control">
                                        </div>
                                    </div>
                                    <!--names-->
                                    <!--addressphoneno-->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="inputAddress">Home Address</label>
                                            <input type="text" name="member-home-address" class="form-control" id="inputAddress" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputZip">Phone Number</label>
                                            <input type="text" name="member-phone-number" class="form-control" id="inputZip" required>
                                        </div>
                                    </div>
                                    <!--addressphoneno-->
                                    <!--birth status blood-->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="">Birthdate</label>
                                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                            <script>
                                                $(function(){
                                                    $("#starty").datepicker({dateFormat:'yy-mm-dd'}).val();
                                                });
                                            </script>
                                            <input name="member-birthdate" class="form-control datepicker" required id="starty">
                                        </div>
                                        <div class="form-group col">
                                            <label for="">Civil Status</label>
                                            <select class="form-control" name="member-civil-status" required>
                                                <option active>---</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Separated">Separated</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="">Blood Type</label>
                                            <select class="form-control" name="member-blood-type" required>
                                                <option value="">---</option>
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
                                    <!--birth status blood-->
                                    <!--weight height-->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="">Weight (lb)</label>
                                            <select name="member-weight" id="" class="form-control" required>
                                                <option value="">---</option>
                                                <option value="unsure">Unsure</option>
                                                <?php for($a=110;$a<=190;$a++){ ?>
                                                <option value="<?php echo $a; ?>lb"><?php echo $a; ?>lb</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="">Height (cm)</label>
                                            <!--<input type="number" class="form-control" name="Height">-->
                                            <select name="member-height" id="" class="form-control" required>
                                                <option value="">---</option>
                                                <option value="unsure">Unsure</option>
                                                <?php for($a=130;$a<=196;$a++){ ?>
                                                <option value="<?php echo $a; ?>cm"><?php echo $a; ?>cm</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--weight height-->
                                    <!--tin-->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="">TIN Number*</label>
                                            <input type="text" class="form-control" name="member-tin" required>
                                        </div>
                                    </div>
                                    <!--tin-->
                                    
                                    <div style="text-align:right;">
                                        <button type="submit" class="btn btn-lg signup-btn" name="next1button">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="signup-left"></div>
                    </div>
                    <!--<div class="container content-s">
                        <form action="includes/signup.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputEmail4">First Name</label>
                                    <input type="text" name="member-first-name" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col">
                                    <label for="inputPassword4">Last Name</label>
                                    <input type="text" name="member-last-name" class="form-control" placeholder="Last Name">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Nickname</label>
                                    <input type="text" name="member-nickname" class="form-control" placeholder="Nickname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Home Address</label>
                                <input type="text" name="member-home-address" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputCity">Email</label>
                                    <input type="text" name="member-email" class="form-control" id="inputCity" placeholder="Email" value="
                                </div>
                                <div class="form-group col">
                                    <label for="inputCity">Username</label>
                                    <input type="text" name="member-username" class="form-control" id="inputCity" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputZip">Password</label>
                                    <input type="password" name="member-password" class="form-control" id="inputZip" placeholder="Password">
                                </div>
                                <div class="form-group col">
                                    <label for="inputZip">Repeat Password</label>
                                    <input type="password" name="member-password-repeat" class="form-control" id="inputZip" placeholder="Repeat Password">
                                </div>
                                <div class="form-group col">
                                    <label for="inputZip">Phone Number</label>
                                    <input type="number" name="member-phone-number" class="form-control" id="inputZip" placeholder="Phone number">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck" required>
                                        Do you agree to the terms and conditions?
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success" name="signup-button">Signup</button>
                        </form>
                    </div>-->
                </main>
                <?php
                if(isset($_GET['error'])){
                if($_GET['error']=='emptyfields'){
                echo '<div class="errormsg-sign">Empty fields</div>';
                }
                else if($_GET['error']=='invalidmailuname'){
                echo '<div class="errormsg-sign">Invalid email and username</div>';
                }
                else if($_GET['error']=='invalidmail'){
                echo '<div class="errormsg-sign">Invalid email</div>';
                }
                else if($_GET['error']=='invalidusername'){
                echo '<div class="errormsg-sign">Invalid username</div>';
                }
                else if($_GET['error']=='invalidphonenumber'){
                echo '<div class="errormsg-sign">Invalid phone number</div>';
                }
                else if($_GET['error']=='passwordcheck'){
                echo '<div class="errormsg-sign">Password didn\'t match</div>';
                }
                else if($_GET['error']=='invalidemailandusername'){
                echo '<div class="errormsg-sign">Invalid email and username</div>';
                }
                else {
                echo "";
                }
                } else {
                echo NULL;
                }
                ?>
            </body>
        </html>