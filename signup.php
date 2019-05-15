<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
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
            min-height: 1000px;
            }
            .signup-right{
            padding: 50px 40px 0 40px;
            }
            .signup-left{
            background-image: url('images/kuri.png');
            background-position: left;
            background-size:cover;
            }
            .signup-btn{
            background-color:white;
            color:#1565ae;
            border-style: solid;
            border-color: #1565ae;
            transition: 0.5s;
            margin-top:20px;
            }
            .signup-btn:hover{
            color:white;
            border-color: #ed3237;
            background-color: #ed3237;
            box-shadow:7px 8px #1565ae;
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
            </style>
            <body>
                <main>
                    <div class="signup-grid">
                        <div class="signup-left"></div>
                        <div>
                            <div class="signup-right">
                                <form action="includes/signup.inc.php" method="post" class="needs-validation">
                                    <div>
                                        <a href="index.php"><img class="photosign" src="images/logo.png" width="45%" alt=""></a>
                                        <br>
                                        <h1 class="msgsign" style="font-family:monsbold; font-size:2.1em;">Sign up in just under 3 minutes!</h1>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-4">
                                            <label for="inputEmail4">First Name *</label>
                                            <input type="text" name="rider-first-name" class="form-control" placeholder="First name" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['rider-first-name'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                            <div class="valid-tooltip">Looks Good!</div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputPassword4">Last Name *</label>
                                            <input type="text" name="rider-last-name" class="form-control" placeholder="Last Name" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['rider-last-name'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="inputPassword4">Nickname</label>
                                            <input type="text" name="rider-nickname" class="form-control" placeholder="Nickname" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['rider-nickname'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="inputCity">Email *</label>
                                            <input type="text" name="rider-email" class="form-control" placeholder="Email" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                                if($_GET['error']=="email_exists"){
                                                    echo "";
                                                }
                                                else{
                                                    echo $_GET['rider-email'];
                                                }
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputCity">Username *</label>
                                            <input type="text" name="rider-username" class="form-control" placeholder="Username" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                                if($_GET['error']=="username_exists"){
                                                    echo "";
                                                }
                                                else{
                                                    echo $_GET['rider-username'];
                                                }
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputZip">Password *</label>
                                            <input type="password" name="rider-password" class="form-control" id="inputZip" placeholder="Password">
                                        </div>
                                        <div class="form-group col">
                                            <label for="inputZip">Repeat Password *</label>
                                            <input type="password" name="rider-password-repeat" class="form-control" id="inputZip"
                                            placeholder="Repeat Password">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            <label for="locationn">Address Line (Street/Bldg. No.) *</label>
                                            <input type="text" name="address_line" required class="form-control" id="locationn"
                                            placeholder="1234 Main St" value="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Barangay *</label>
                                            <input type="text" name="barangay" required class="form-control" id="locationn"
                                            placeholder="Poblacion/Brgy. Bulaklak/Sitio" value="">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">City *</label>
                                            <input type="text" name="city" required placeholder="Manila" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Province *</label>
                                            <input type="text" name="province" required placeholder="NCR" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Postal Code</label>
                                            <input type="text" name="postal_code" required placeholder="1011" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputZip">Phone Number</label>
                                            <input type="text" name="rider-phone-number" class="form-control" id="inputZip" placeholder="Phone number" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['rider-phone-number'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputAddress">Emergency Contact (Name) *</label>
                                            <input type="text" name="emergency_name" class="form-control"
                                            placeholder="Name" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['em_name'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputZip">Emergency Contact (Number) *</label>
                                            <input type="text" name="emergency_num" class="form-control" placeholder="Phone number" value="<?php
                                            $var = NULL;
                                            if(isset($_GET['error'])){
                                            echo $_GET['em_num'];
                                            } else {
                                            echo NULL;
                                            }
                                            ?>">
                                        </div>
                                    </div>

                                    <pre style="margin:0">* - Required Fields</pre>

                                    <button type="submit" class="btn btn-lg signup-btn" name="signup-button">Sign up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--<div class="container content-s">
                        <form action="includes/signup.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputEmail4">First Name</label>
                                    <input type="text" name="rider-first-name" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col">
                                    <label for="inputPassword4">Last Name</label>
                                    <input type="text" name="rider-last-name" class="form-control" placeholder="Last Name">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Nickname</label>
                                    <input type="text" name="rider-nickname" class="form-control" placeholder="Nickname">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Home Address</label>
                                <input type="text" name="rider-home-address" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputCity">Email</label>
                                    <input type="text" name="rider-email" class="form-control" id="inputCity" placeholder="Email" value="
                                </div>
                                <div class="form-group col">
                                    <label for="inputCity">Username</label>
                                    <input type="text" name="rider-username" class="form-control" id="inputCity" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputZip">Password</label>
                                    <input type="password" name="rider-password" class="form-control" id="inputZip" placeholder="Password">
                                </div>
                                <div class="form-group col">
                                    <label for="inputZip">Repeat Password</label>
                                    <input type="password" name="rider-password-repeat" class="form-control" id="inputZip" placeholder="Repeat Password">
                                </div>
                                <div class="form-group col">
                                    <label for="inputZip">Phone Number</label>
                                    <input type="number" name="rider-phone-number" class="form-control" id="inputZip" placeholder="Phone number">
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