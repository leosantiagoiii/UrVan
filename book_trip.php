<?php session_start();
if(!isset($_SESSION['clientid'])){
}
else{
      if( !isset($_GET['tour_id']) && !isset($_GET['tourname']) ){
      }
      else{?>


<?php session_start();
require "includes/dbconnect.inc.php";
if(isset($_SESSION['clientid'])){
$mu=$_SESSION['clientid'];



$ha_i=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id='$mu' ORDER BY created_at DESC LIMIT 1");
$resultaaa=mysqli_fetch_assoc($ha_i);
$yungbasis=$resultaaa['major_id'];
$po1=mysqli_query($conn,"SELECT * FROM booking_minordetails WHERE major_id='$yungbasis'");
$billa1=mysqli_num_rows($po1);
$po2=mysqli_query($conn,"SELECT * FROM booking_clients WHERE major_id='$yungbasis'");
$billa2=mysqli_num_rows($po2);
$po3=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$yungbasis'");
$billa3=mysqli_num_rows($po3);
if( !isset($_GET['bookingstill']) ){
      if( $billa1<=0 || $billa2<=0 || $billa3<=0 ){
            mysqli_query($conn,"DELETE FROM booking_majordetails WHERE major_id='$yungbasis'");
            mysqli_query($conn,"DELETE FROM booking_minordetails WHERE major_id='$yungbasis'");
            mysqli_query($conn,"DELETE FROM booking_clients WHERE major_id='$yungbasis'");
            mysqli_query($conn,"DELETE FROM booking_transactions WHERE major_id='$yungbasis'");
            mysqli_query($conn,"DELETE FROM booking_balance WHERE major_id='$yungbasis'");
      }
      else{}
}


$para="SELECT * FROM active_accs WHERE acc_id='$mu'";
$parapo=mysqli_query($conn,$para);
$bila=mysqli_num_rows($parapo);
if($bila=="0"){
      session_unset();
      session_destroy();
}
else{}
} ?>
<?php
// leo 21 jan
date_default_timezone_set("Asia/Manila");
$currdate = date('Y-m-d H:i:s', time());
$hash=(SHA1(rand(0,500)));
$upper=strtoupper($hash);
$final_ip_id='IP_'.substr($upper, 0,10);
//new visit
function getRealIpAddr(){
if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
{
$ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
{
$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else{
$ip=$_SERVER['REMOTE_ADDR'];
}
return $ip;
}
$ip_address=getRealIpAddr();
//retrieve existing visits
$eskyuel="SELECT * FROM page_visit_table_webpage WHERE ip_address='$ip_address'";
$mgaresultaa=mysqli_query($conn,$eskyuel);
$bilang=mysqli_num_rows($mgaresultaa);
if($bilang<=0){
//if zero
$insertion="INSERT INTO page_visit_table_webpage (id,ip_address,visit_date) VALUES ('$final_ip_id','$ip_address','$currdate')";
mysqli_query($conn,$insertion);
}
else{
//if not zero
$hanap="INSERT INTO page_visit_table_webpage (id,ip_address,visit_date) VALUES ('$final_ip_id','$ip_address','$currdate')";
mysqli_query($conn,$hanap);
}
// leo 21 jan
?>
<!DOCTYPE html>
<html lang="en">
      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                  .NewsTitle{
                  font-family: monsbold;font-size: 45px;
                  }
                  .NewsDesc{
                  font-family: gravity;
                  }
                  @media(max-width:1500px){
                  .tours_section{
                  padding:30px 30px;
                  }
                  }
                  .boyra{
                  background-color:transparent;
                  border-color: #1565ae;
                  color:#1565ae;
                  border-radius: 0px;
                  font-family: raleway;
                  border-width: 1.5px;
                  padding:10px 15px;
                  white-space: nowrap;
                  text-align: center;
                  cursor: pointer;
                  transition: 0.5s;
                  }
                  .linkhome{
                  color:black;
                  text-decoration:none;
                  transition:0.5s;
                  }
                  .linkhome:hover{
                  color:#285296;
                  text-decoration:none;
                  transition:0.5s;
                  }
                  .boyra:hover{
                  color:#ed3237;
                  border-color: #ed3237;
                  transition: 0.5s;
                  box-shadow: 5px 5px 0px 0px rgba(237,50,55,1);
                  }
                  .boyra_1{
                  background-color:transparent;
                  border-color: #1565ae;
                  color:#1565ae;
                  border-radius: 0px;
                  font-family: raleway;
                  border-width: 1.5px;
                  padding:10px 15px;
                  white-space: nowrap;
                  text-align: center;
                  cursor: pointer;
                  transition: 0.5s;
                  }
                  .boyra_1:hover{
                  color:#ed3237;
                  border-color: #ed3237;
                  transition: 0.5s;
                  box-shadow: 5px 5px 0px 0px rgba(237,50,55,1);
                  }
                  /*ed3237*/
                  @media(min-width:1000px){
                  .tours_section{
                  padding:60px 90px;
                  }
                  }
                  .h1-trip-name{
                  font-family: monsbold;font-size: 45px;
                  }
                  .h3-trip-price{
                  color:red;
                  font-weight: bolder;
                  font-family: gravity;
                  }
                  .p-trip-desc{
                  font-family: gravity;
                  }
                  .below-feature{
                  margin-top:1.5em;
                  }
                  .h3-thing{
                  font-family: Robotoblack;
                  }
                  .h5-thing{
                  font-family: Robotoreg;
                  }
                  .haha{
                  padding-left:30px;
                  }
                  .p-thing{
                  font-family: raleway;
                  }
                  .news-sec{
                  width:100%;
                  }
                  .tours-content>h1{
                  font-family: bebas;
                  font-weight: bolder;
                  }
                  .title-tours{
                  font-family:Raleway;
                  font-size:55px;
                  text-align: center;
                  }
                  .subtitle-tours{
                  font-family:monsreg;
                  font-weight: bolder;
                  text-align: center;
                  font-size:20px;
                  }
                  .red{
                  background-color:pink;
                  }
                  .content-s{
                  transition: 0.5s;
                  padding:40px;
                  width:800px;
                  margin-top:60px;
                  }
                  /*leo 22 jan*/
                  .errormsg-sign{
                  position:absolute;
                  position:fixed;
                  background-color:red;
                  opacity:0.8;
                  color:white;
                  padding:30px;
                  bottom:0%;
                  }
                  /*leo 22 jan*/
                  .card{
                  background-color:white;
                  border-radius: 10px;
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
                  height:1200px;
                  min-height: 1200px;
                  }
                  .signup-right{
                  padding: 50px 40px 0 40px;
                  }
                  .signup-left{
                  background-image: url('images/signup-side.png');
                  background-position: center;
                  background-size:cover;
                  background-repeat: no-repeat;
                  }
                  .login-member-bg{
                  background-image: url('images/corra.png');
                  background-position: left;
                  background-size:cover;
                  background-repeat: no-repeat;
                  }
                  /*leo 21 jan*/
                  .tours-landing-img{
                  width:100%;
                  height:260px;
                  object-fit: cover;
                  }
                  /*leo 21 jan*/
                  .trip-name-a{
                  font-family: bebas;
                  margin-top:5px;
                  font-weight: bolder;
                  }
                  .trip-price-a{
                  font-family:monsbold;
                  font-size:15px;
                  color:red;
                  }
                  @media screen and (max-width: 650px){
                  .content-s{
                  width:100%;
                  }
                  .login-member-bg{
                  background-image: green;
                  }
                  .tours-landing-img{
                  height:250px;
                  }
                  }
                  .btn-n{
                  margin:5px 0;
                  padding:5px 15px;
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
                  .msgsign{
                  margin-top:20px;
                  margin-bottom: 20px;
                  }
                  .headI{
                  background-image: url('images/headerImglol.png');
                  background-size: cover;
                  background-repeat: no-repeat;
                  text-align: center;
                  background-position: center;
                  }
                  .headI2{
                  padding:300px 0;
                  }
                  .headI2 > h1{
                  color:white;
                  font-family: monsbold;
                  text-transform:uppercase;
                  margin-top:5px;
                  }
                  .headI2 > img{
                  width:26%;
                  }
                  @media screen and (max-width: 650px){
                  .headI2 > img{
                  width:55%;
                  }
                  .headI2 > h1{
                  font-size: 30px;
                  }
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
                  .below-video-content-1{
                  padding: 70px 60px;
                  width:100%;
                  }
                  .below-video-content-1>div{
                  background-image: url('images/map.png');
                  background-position: center;
                  background-size:cover;
                  background-repeat: no-repeat;
                  padding:60px 30px;
                  }
                  
                  .below-video-content-2{
                  margin: 0 auto;
                  width: 100%;
                  }
                  .log-status{
                  color: black;
                  font-family: robotoreg, sans-serif;
                  font-size: 2em;
                  text-align: center;
                  margin:30px;
                  }
                  .below-video-content-3{
                  background-image: url('images/index-3.png');
                  background-position: center;
                  background-attachment:fixed;
                  background-size:cover;
                  background-repeat: no-repeat;
                  text-align:center;
                  padding:350px 100px;
                  width:100%;
                  }
                  .below-video-content-3>h1{
                  font-family:raleway;
                  font-size:50px;
                  }
                  .e-e
                  {
                  font-family:gravity;
                  font-size:1em;
                  font-weight: bold;
                  }
                  .aboutsectionA{
                  padding:30px;
                   color:white;
                  }
                  .hehehe > li > a{
                  color:#2a3c75;
                  font-weight:bolder;
                  }
                  .hehehe > li > a:hover{
                  text-decoration:none;
                  }
                  .aboutsectionA1{
                  border-style: solid;
                  padding:40px;
                  border-width:1px;
                  background-image:url('images/akl.png');
                  background-size:cover;
                  background-repeat: no-repeat;
                  background-position: center;
                  background-attachment: fixed;
                   color:white;                  }
                  .aboutsectionA h1{
                  text-align:center;
                  font-family:raleway;
                  text-transform:uppercase;
                  color:white;
                  }
                  .aboutsectionA p{
                  font-family:gravity;
                 color:  white;
                  }
                  .aboutsection1{
                  display: grid;
                  grid-template-columns: repeat(2,1fr);
                  grid-gap:1.5em;
                  }
                  @media screen and (max-width: 650px){
                  .shajs{
                  text-align: center;
                   color:white;
                  }
                  .aboutsection1{
                  grid-template-columns: repeat(1,1fr);
                  }
                  }
                  .aboutsectionB{
                  text-align:center;
                  padding:30px;
                  }
                  .aboutsectionB h1{
                  font-family:monsbold;
                  font-size:45px;
                  }
                  /* If the screen size is 600px wide or less, hide the element */
                  @media screen and (max-width: 650px){
                  .below-video-content-1{
                  padding: 15px;
                  width:100%;
                  }
                  .in-p{
                  display:none;
                  }
                  .below-video-content-3{
                  padding:200px 35px;
                  }
                  .below-video-content-3>h1{
                  font-size: 2.1em;
                  }
                  .e-e{
                  font-size:0.9em;
                  font-weight: lighter;
                  }
                  }
                  @media(max-width:1500px){
                  .grid-2{
                  display: grid;
                  grid-template-columns: repeat(1, 1fr); /*per row*/
                  /*grid-column-gap: 1em;
                  grid-row-gap: 1em;*/
                  grid-gap: 1em;
                  }
                  }
                  @media(min-width:900px){
                  .grid-2{
                  display: grid;
                  grid-template-columns: repeat(2, 1fr); /*per row*/
                  /*grid-column-gap: 1em;
                  grid-row-gap: 1em;*/
                  grid-gap: 1em;
                  }
                  }
                  .grid-2 > div{
                  padding:1em;
                  border-width:1px;
                  }
                  .text-01{
                  font-family:monsbold;
                  }
                  .index-grid-photos{
                  width:100%;
                  height:300px;
                  object-fit:cover;
                  filter:grayscale(100%);
                  transition:0.5s;
                  }
                  footer{
                  bottom:0%;
                  background-color: red;
                  }
                  .footer-distributed{
                  background-color: #292c2f;
                  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
                  box-sizing: border-box;
                  width: 100%;
                  text-align: left;
                  font: bold 16px sans-serif;
                  padding: 55px 50px;
                  }
                  .footer-distributed .footer-left,
                  .footer-distributed .footer-center,
                  .footer-distributed .footer-right{
                  display: inline-block;
                  vertical-align: top;
                  }
                  /* Footer left */
                  .footer-distributed .footer-left{
                  width: 40%;
                  }
                  /* Footer links */
                  .footer-distributed .footer-links{
                  color:  #ffffff;
                  margin: 20px 0 12px;
                  padding: 0;
                  }
                  .footer-distributed .footer-links a{
                  display:inline-block;
                  line-height: 1.8;
                  text-decoration: none;
                  color:  inherit;
                  }
                  .footer-distributed .footer-company-name{
                  color:  #8f9296;
                  font-size: 14px;
                  font-weight: normal;
                  margin: 0;
                  }
                  /* Footer Center */
                  .footer-distributed .footer-center{
                  width: 35%;
                  }
                  .footer-distributed .footer-center i{
                  background-color:  #33383b;
                  color: #ffffff;
                  font-size: 25px;
                  width: 38px;
                  height: 38px;
                  border-radius: 50%;
                  text-align: center;
                  line-height: 42px;
                  margin: 10px 15px;
                  vertical-align: middle;
                  }
                  .footer-distributed .footer-center i.fa-envelope{
                  font-size: 17px;
                  line-height: 38px;
                  }
                  .footer-distributed .footer-center p{
                  display: inline-block;
                  color: #ffffff;
                  vertical-align: middle;
                  margin:0;
                  }
                  .footer-distributed .footer-center p span{
                  display:block;
                  font-weight: normal;
                  font-size:14px;
                  line-height:2;
                  }
                  .footer-distributed .footer-center p a{
                  color:  #5383d3;
                  text-decoration: none;;
                  }
                  /* Footer Right */
                  .footer-distributed .footer-right{
                  width: 20%;
                  }
                  .footer-distributed .footer-company-about{
                  line-height: 20px;
                  color:  #92999f;
                  font-size: 13px;
                  font-weight: normal;
                  margin: 0;
                  }
                  .footer-distributed .footer-company-about span{
                  display: block;
                  color:  #ffffff;
                  font-size: 14px;
                  font-weight: bold;
                  margin-bottom: 20px;
                  }
                  .footer-distributed .footer-icons{
                  margin-top: 25px;
                  }
                  .footer-distributed .footer-icons a{
                  display: inline-block;
                  width: 35px;
                  height: 35px;
                  cursor: pointer;
                  background-color:  #33383b;
                  border-radius: 2px;
                  font-size: 20px;
                  color: #ffffff;
                  text-align: center;
                  line-height: 35px;
                  margin-right: 3px;
                  margin-bottom: 5px;
                  }
                  /* If you don't want the footer to be responsive, remove these media queries */
                  .grulk{
                  border-style:solid;margin-bottom:20px;width:80%;object-fit: cover;height:500px;
                  }
                  ..aboutsectionB>.row>.column>img{
                  width:auto;
                  }
                  @media (max-width: 650px) {
                  .aboutsectionB>.row>.column>img{
                  width:100%;
                  height:80px;
                  }
                  .grulk{
                  width:100%;
                  height:300px;
                  }
                  .sajk{
                  display:none;
                  }
                  .h3-thing{
                  margin-top:30px;
                  }
                  .haha{
                  padding:10px;
                  }
                  .below-feature table{
                  width:100%;
                  }
                  .footer-distributed{
                  font: bold 14px sans-serif;
                  }
                  .footer-distributed .footer-left,
                  .footer-distributed .footer-center,
                  .footer-distributed .footer-right{
                  display: block;
                  width: 100%;
                  margin-bottom: 40px;
                  text-align: center;
                  }
                  .footer-distributed .footer-center i{
                  margin-left: 0;
                  }
                  }
                  @media(max-width:1500px){
                  .tours{
                  display: grid;
                  grid-template-columns: repeat(1,1fr);
                  grid-gap:1.5em;
                  margin-top:30px;
                  }
                  }
                  @media(min-width:1000px){
                  .tours{
                  display: grid;
                  grid-template-columns: repeat(3,1fr);
                  grid-gap:1.5em;
                  margin-top:30px;
                  }
                  }
                  .tours-content{
                  padding:1rem;
                  background: #fafafa;
                  border-style: solid;
                  transition: 0.3s;
                  text-align: center;
                  }
                  .tours-content:hover{
                  box-shadow: 10px 12px 0px 0px rgba(0,0,0,0.63);
                  transition: 0.3s;
                  }
                  .tours-content>img{
                  border-style: solid;
                  }
                  .roror{
                  display: flex;
                  flex-wrap: wrap;
                  padding: 4px;
                  margin:0;
                  width:90%;
                  }
                  .colcol{
                  flex: 25%;
                  max-width: 25%;
                  padding: 4px;
                  }
                  .colcol img{
                  margin:0;
                  vertical-align: middle;
                  }
                  @media screen and (max-width: 800px) {
                  .colcol {
                  -ms-flex: 50%;
                  flex: 50%;
                  max-width: 50%;
                  }
                  }
                  @media screen and (max-width: 600px) {
                  .colcol {
                  -ms-flex: 100%;
                  flex: 100%;
                  max-width: 100%;
                  }
                  }
                  /*Janella CLientele Roster 1/9/2018*/
                  .column {
                  float: left;
                  width: 25%;
                  padding: 0px;
                  text-align: center;
                  font-size: 25px;
                  cursor: pointer;
                  color: white;
                  margin-bottom: 30px;
                  }
                  .containerTab {
                  padding: px;
                  color: white;
                  display:none;
                  width:100%;
                  border-style:solid;
                  border-color:black;
                  border-width: 2px;
                  padding:20px 20px 10px 20px;
                  border-radius: 10px;
                  }
                  .outera{
                  position: relative;
                  z-index: 0;
                  width:100%;
                  height:350px;
                  }
                  .juan{
                  position: absolute;
                  z-index: 1;
                  width: 40%;
                  top:-3%;
                  left: 15%;
                  }
                  .juan>img{
                  width:100%;
                  }
                  .twodo{
                  text-transform: capitalize;
                  font-family:gravity;
                  position: absolute;
                  z-index: 2;
                  background-color: white;
                  border-style:solid;
                  border-width:2px;
                  width: 350px;
                  top:50%;
                  left:50%;
                  }
                  .twodo:hover{
                  transition:0.5s;
                  }
                  .kauh{
                  width:auto;padding:30px;line-height:20px;
                  }
                  .haye{
                  display:none;
                  }
                  .tenen{
                  background-image: url('images/akl.png');
                  background-size: cover;
                  background-attachment: fixed;
                  color:white;
                  }
                  @media (max-width: 650px){
                  .tenen{
                  display:none;
                  }
                  .haye{
                  display:inline;
                  }
                  .outera{
                  position:static;
                  height:auto;
                  }
                  .twodo{
                  margin-top:20px;
                  width:100%;
                  position:static;
                  }
                  .juan{
                  position:static;
                  width:100%;
                  }
                  }
                  .containerTab>h2{
                  font-family:raleway;
                  text-transform: uppercase;
                  }
                  .containerTab>p{
                  font-family:gravity;
                  }
                  /* Clear floats after the columns */
                  /* Closable button inside the image */
                  .closebtn {
                  float: right;
                  color: white;
                  font-size: 35px;
                  cursor: pointer;
                  }
                  .fandra{
                  width:50%;padding:80px 40px;padding-bottom:200px;
                  }
                  .fandrabelow{
                  padding:70px;background-image: url('images/kakakaboom.png');
                  background-size: cover;
                  }
                  .fandrabelow h1{
                  font-family:raleway;
                  font-size:60px;
                  text-align: left;
                  line-height:60px;
                  margin-bottom:30px;
                  }
                  .koala{
                  background-image: url('images/jsaka.png');
                  background-size: cover;
                  }
                  /* If the screen size is 600px wide or less, hide the element */
                  @media screen and (max-width: 850px){
                  .fandra{
                  padding:0px;
                  padding-top:80px;
                  width:80%;
                  padding-bottom:150px;
                  }
                  .fandrabelow{
                  padding:30px;
                  }
                  .fandrabelow h1{
                  font-size:50px;
                  }
                  .koala{
                  padding-bottom:200px;
                  }
                  }
                  /*24 jan leo*/
                  .sidebar_a {
                  margin: 0;
                  padding: 0;
                  background-color: #f1f1f1;
                  height: 700px;
                  overflow: auto;
                  width:100%;
                  }
                  .sidebar_a a {
                  font-family: gravity;
                  font-size: 14px;
                  font-weight:100;
                  display: block;
                  color: black;
                  padding: 16px;
                  text-decoration: none;
                  }
                  
                  .sidebar_a a.active_a {
                  background-color: #555;
                  color: white;
                  }
                  .sidebar_a a:hover:not(.active_a) {
                  background-color: #555;
                  color: white;
                  }
                  .hara{
                  font-family:gravity;
                  margin-top:30px;
                  }
                  .sureting{
                  margin-top:20px;
                  font-family: raleway;
                  border-style:solid;
                  border-width:2px;
                  display: block;
                  padding:20px;
                  font-size: 30px;
                  width:25%;
                  color:#1565ae;
                  border-color: #1565ae;
                  text-decoration:none;
                  transition: 0.5s;
                  }
                  .otherab{
                  background-color:#f9f9f9;
                  padding: 70px 30px;
                  margin-top:80px 0 0 0;
                  }
                  .foretea{
                  margin:0;
                  font-family:monsbold;
                  }
                  .imginbelow{
                  padding:30px;
                  }
                  .imginbelow>a>img{
                  width:100%;
                  transition: transform .2s;
                  filter:grayscale(100%);
                  }
                  .imginbelow>a>img:hover{
                  transform: scale(1.05);
                  box-shadow: 0px 0px 53px -19px rgba(0,0,0,0.75);
                  }
                  .imginbelow>a>h3{
                  margin-top:8px;
                  font-family:raleway;
                  text-transform:uppercase;
                  background-color:black;
                  color:white;
                  transition: 0.5s;
                  }
                  .grashj{
                  padding:40px 0px 0px 0px;
                  margin:0;
                  }
                  .topprof{
                  width:40%;
                  }
                  .topprof>h1{
                  font-family:monsbold;
                  }
                  .topprof_x{
                  font-family: gravity;
                  }
                  .imginbelow>a>h3:hover{
                  background-color:#c63939;
                  transition: 0.5s;
                  }
                  .imginbelow>a{
                  color:black;
                  }
                  .imginbelow>a:hover{
                  text-decoration:none;
                  }
                  .imginbelow>p{
                  font-family:gravity;
                  }
                  .sureting:hover{
                  text-decoration: none;
                  color:#ed3237;
                  border-color: #ed3237;
                  transition: 0.5s;
                  }
                  .dropdown-container_a {
                  display: none;
                  }
                  .sansa{
                  width:100%;
                  height:300px;
                  }
                  @media screen and (max-width: 1000px){
                  .sidebar_a{
                  height:auto;
                  }
                  .hara{
                  margin-top:10px;
                  padding:5px 20px;
                  margin-bottom:15px;
                  }
                  .sansa{
                  width:50%;
                  }
                  
                  }
                  @media screen and (max-width: 700px) {
                  .sansa{
                  width:80%;
                  }
                  .bhutan{
                  margin-bottom:20px;
                  }
                  .hara{
                  margin-top:10px;
                  padding:10px 30px;
                  }
                  .sidebar_a {
                  width: 100%;
                  height: auto;
                  position: relative;
                  }
                  .sidebar_a a {float: left;}
                  }
                  @media screen and (max-width: 100px;) {
                  .sidebar_a a {
                  text-align: center;
                  float: none;
                  width:100%;
                  }
                  }
                  #map{
                        width:100%;
                        height:400px;
                  }
                  /*24 jan leo*/
                  /* janella 1/20/19 */
                  /*contact us page */
                  /*.bg-img {*/
                  /*   The image used */
                  /*  background-image: url("images/contact.png");*/
                  /*   Control the height of the image */
                  /*  min-height: 650px;*/
                  /*   Center and scale the image nicely */
                  /*  background-position: center;*/
                  /*  background-repeat: no-repeat;*/
                  /*  background-size: cover;*/
                  /*  position: relative;*/
                  /*}*/
                  /*     Add styles to the form container */
                  /*    .container { */
                  /*      position: absolute;*/
                  /*      top: 35px;*/
                  /*      left: 60px;*/
                  /*      margin: 20px;*/
                  /*      max-width: 450px;*/
                  /*      padding: 16px;*/
                  /*      background-color: white;*/
                  /*    }*/
                  /*     Full-width input fields */
                  /*      input[type=text], input[type=password] , input[type=email] { */
                  /*      width: 100%;*/
                  /*      padding: 10px;*/
                  /*      margin: 3px 0 8px 0;*/
                  /*      border: none;*/
                  /*      background: #f1f1f1;*/
                  /*    }*/
                  /*     textarea[id=subject] { */
                  /*      width: 100%;*/
                  /*      padding: 10px;*/
                  /*      margin: 3px 0 8px 0;*/
                  /*      border: none;*/
                  /*      background: #f1f1f1;*/
                  /*    }*/
                  /*    input[type=text]:focus, input[type=password]:focus, input[type=email]:focus{ */
                  /*      background-color: #ddd;*/
                  /*      outline: none;*/
                  /*    }*/
                  /*     textarea[id=subject]:focus{ */
                  /*      background-color: #ddd;*/
                  /*      outline: none;*/
                  /*    }*/
                  /*     Set a style for the submit button */
                  /*    .btn {*/
                  /*      background-color: #4CAF50;*/
                  /*      color: white;*/
                  /*      padding: 16px 20px;*/
                  /*      border: none;*/
                  /*      cursor: pointer;*/
                  /*      width: 100%;*/
                  /*      opacity: 0.9;*/
                  /*    }*/
                  /*    .btn:hover {*/
                  /*      opacity: 1;*/
                  /*    }*/
                  /*    .top-right { */
                  /*      position: absolute;*/
                  /*      top: 154px;*/
                  /*      right: 205px;*/
                  /*    }*/
                  /*    #icons{ */
                  /*      width: 80px; */
                  /*      padding-left: 20px; */
                  /*    }*/
                  
                  /*    @import url('http://getbootstrap.com/2.3.2/assets/css/bootstrap.css');*/
                  /*    @import url('http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css');*/
                  
                  /*    #counterContact {*/
                  /*        position: relative;*/
                  /*        display: inline;*/
                  /*        padding-top: 50px;*/
                  
                  /*    }*/
                  /*    #over {*/
                  /*        position:absolute;*/
                  /*        left:13%;*/
                  /*        top:43%;*/
                  /*        max-width: 80px;*/
                  
                  /*    }*/
                  
                  /*    #over1 {*/
                  /*        position:absolute;*/
                  /*        left:23%;*/
                  /*        top:43%;*/
                  /*        max-width: 80px;*/
                  
                  /*    }*/
                  /*    #over2 {*/
                  /*        position:absolute;*/
                  /*        left:33%;*/
                  /*        top:43%;*/
                  /*        max-width: 80px;*/
                  
                  /*    }*/
                  /*    #over3{*/
                  /*        position:absolute;*/
                  /*        left:43%;*/
                  /*        top:43%;*/
                  /*        max-width: 80px;*/
                  
                  /*    }*/
                  /**
                  * The CSS shown here will not be introduced in the Quickstart guide, but shows
                  * how you can use CSS to style your Element's container.
                  */
                  .StripeElement {
                  background-color: white;
                  height: 40px;
                  padding: 10px 12px;
                  border-radius: 4px;
                  border: 1px solid transparent;
                  box-shadow: 0 1px 3px 0 #e6ebf1;
                  -webkit-transition: box-shadow 150ms ease;
                  transition: box-shadow 150ms ease;
                  }
                  .StripeElement--focus {
                  box-shadow: 0 1px 3px 0 #cfd7df;
                  }
                  .StripeElement--invalid {
                  border-color: #fa755a;
                  }
                  .StripeElement--webkit-autofill {
                  background-color: #fefde5 !important;
                  }
                  </style>
            </head>
            <body>
                  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                  crossorigin="anonymous"></script>
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
                  crossorigin="anonymous"></script>
                  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
                  crossorigin="anonymous"></script>
                  <header style="width:100%;">
                        <!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-default">
                              <a class="navbar-brand" href="#">
                                    <img src=" " width="30" height="30" class="d-inline-block align-top" alt="logo">
                                    UrVan
                              </a>
                              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                              aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                    <div class="navbar-nav">
                                          <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                                          <a class="nav-item nav-link" href="login.php">Login</a>
                                          <a class="nav-item nav-link" href="signup.php">Rider Signup</a>
                                          <form action="includes/logout.inc.php" method="post">
                                                <button type="submit" class="btn" name="logout-button">Logout</button>
                                          </form>
                                    </div>
                              </div>
                        </nav>-->
                        <div id="app">
                              <nav class="navbar navbar-expand-lg header-h " style="background-color:black;">
                                    <a class="navbar-brand" href="index.php">
                                          <img src="images/bwLogo.png" width="100px" class="d-inline-block align-top" alt="logo">
                                    </a>
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div id="navbarNavDropdown" class="navbar-collapse collapse">
                                          <ul class="navbar-nav mr-auto navbar-h">
                                                <li class="nav-item active">
                                                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="about.php">About</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="news.php">News</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="tours.php">Tours & Packages</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a href="contact-us.php" class="nav-link">Contact Us</a>
                                                </li>
                                          </ul>
                                          <ul class="navbar-nav rightlink-h">
                                                <?php
                                                if(isset($_SESSION['clientid']) ){
                                                echo '<li class="nav-item">
                                                      <b><a class="nav-link" style="color:white;">Welcome, '.$_SESSION['clientfname'].'</a></b>
                                                </li>
                                                <li class="nav-item dropdown">
                                                      <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            More
                                                      </a>
                                                      <div class="dropdown-menu dropdown-h" aria-labelledby="navbarDropdownMenuLink">
                                                            <a class="dropdown-item" href="client_profile.php">Your Profile</a>
                                                            <a class="dropdown-item" href="reservations.php">Your Reservations</a>
                                                      </div>
                                                </li>
                                                <li class="nav-item">
                                                      <form action="includes/logout.inc.php" method="post">
                                                            <button class="btn btn-logout btn-block" type="submit" name="logout-button">Log out</button>
                                                      </form>
                                                </li>';
                                                }
                                                elseif(isset($_SESSION['adminid']) ){
                                                echo '<li class="nav-item">
                                                      <b><a class="nav-link" style="color:white;">Welcome, '.$_SESSION['adminfname'].'</a></b>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="business_dashboard/">Dashboard</a>
                                                </li>
                                                <li class="nav-item">
                                                      <form action="includes/logout.inc.php" method="post">
                                                            <button class="btn btn-logout btn-block" type="submit" name="logout-button">Log out</button>
                                                      </form>
                                                </li>';
                                                }
                                                elseif(isset($_SESSION['memberapprovalacctid'])){
                                                echo '
                                                <li class="nav-item">
                                                      <a class="nav-link" href="signup_member_approval.php">Membership Status</a>
                                                </li>
                                                <li class="nav-item">
                                                      <form action="includes/logout.inc.php" method="post">
                                                            <button class="btn btn-logout btn-block" type="submit" name="logout-button">Log out</button>
                                                      </form>
                                                </li>';
                                                }
                                                else{
                                                echo '<li class="nav-item dropdown">
                                                      <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Register
                                                      </a>
                                                      <div class="dropdown-menu dropdown-h" aria-labelledby="navbarDropdownMenuLink">
                                                            <a class="dropdown-item" href="signup.php">as Rider</a>
                                                            <a class="dropdown-item" href="signup_member.php">as Coop Member</a>
                                                      </div>
                                                </li>
                                                <li class="nav-item dropdown">
                                                      <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Login
                                                      </a>
                                                      <div class="dropdown-menu dropdown-h dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                                            <a class="dropdown-item" href="login.php">Rider Login</a>
                                                            <a class="dropdown-item" href="business_dashboard/login.php">Business Login</a>';
                                                            if(!isset($_SESSION['memberapprovalacctid'])){
                                                            // leo 22 jan //
                                                            echo '<a class="dropdown-item" href="signup_member_approval.php">Apppointment Approval</a>';
                                                            }
                                                            // leo 22 jan //
                                                      echo '</div>
                                                </li>';
                                                }
                                                ?>
                                          </ul>
                                    </div>
                              </nav>
                        </div>
                        <!--<div class="topnav">
                              <a href="" class="active-link">Logo</a>
                              <a href="">Home</a>
                              <a href="">About</a>
                              <a href="">News</a>
                              <a href="">Tours & Packages</a>
                              <div class="topnav-right">
                                    <a href="">Membership</a>
                                    <a href="">Login</a>
                                    <a href="">Signup</a>
                              </div>
                        </div>-->
                  </header>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
<!--  -->
<link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!--  -->
<?php
$tour_id = $_GET['tour_id'];
$tour_name = $_GET['tour_name'];
$query=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
$forTour=mysqli_fetch_assoc($query); //important
$query=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$_SESSION[clientid]'");
$forClient=mysqli_fetch_assoc($query); //important
?>
<main style="width:100%;">
      <div class="row" style="width:100%">
            <div class="col-lg-6">
                  <img src="includes/tour_and_packages_image_get.inc.php?tour_id=<?php echo $tour_id; ?>" style="width:100%;height:100%;object-fit: cover;" alt="">
            </div>
            <div class="col-lg-6" style="margin:100px 0;">
                  <form action="includes/book_trip.inc.php" method="POST">
                        <?php
                        $all=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$tour_id'");
                        $cco=mysqli_num_rows($all); ?>
                        <h1 style="font-family:bebas;font-weight:500;font-size:45px;text-align:right;"><?php echo $tour_name;?><br><u><?php if($cco>=1){echo "Single Trip";} ?></u></h1>
                        <div class="row form-group">
                              <?php
                              if($cco<=0){ ?>
                                    <div class="col-lg-4">
                                          <script   src="http://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
                                          <input type="text" name="startDate" class="form-control daepic" id="starty" required="" placeholder="Start Date" style="margin:0;" required>
                                    </div>
                                    <div class="col-lg-4">
                                          <input type="text" name="endDate" class="form-control daepic" id="endy" required="" placeholder="End Date" style="margin:0;" required>
                                    </div>
                                    <?php 
                              }
                              else{ ?>
                                    <div class="col-lg-8">
                                          <script   src="http://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
                                          <input type="text" name="startDate" class="form-control daepic" id="starty" required="" placeholder="Start Date" style="margin:0;" required>
                                    </div>
                                    <?php
                              } ?>
                              <!-- <div class="col-lg-4">
                                    <input type="text" name="endDate" class="form-control daepic" required="" placeholder="End Date" style="margin:0;" required id="endy">
                              </div> -->
                              <script>
                              
                              $(document).ready(function(){
                                    $.datepicker.setDefaults({
                                          dateFormat: 'yy-mm-dd'
                                    });
                                    $(function(){
                                          var minDate=new Date();
                                        //   CHANGE CHANGE CHANGE
                                          minDate.setDate(minDate.getDate()+15);
                                          var maxDate=new Date();
                                          maxDate.setDate(minDate.getDate()+200);
                                          console.log(minDate);
                                          console.log(maxDate);
                                          $('#starty').datepicker({
                                                numberOfMonth:1,
                                                minDate:minDate,
                                                maxDate:maxDate,
                                                onClose:function(selectedDate){
                                                      $('#endy').datepicker("option","minDate",selectedDate);
                                                      var viol=document.getElementById('starty').value;
                                                      var newd=new Date(viol);
                                                      var newmax=newd.toString();
                                                      console.log(newmax);
                                                }
                                          });
                                          <?php
                                          if($cco<=0){ ?>
                                                $('#endy').datepicker({
                                                      numberOfMonth:1,
                                                      minDate:minDate,
                                                      maxDate:maxDate,
                                                      onClose:function(selectedDate){
                                                            $('#endy').datepicker("option","minDate",selectedDate)
                                                      }
                                                });
                                                <?php
                                          } ?>
                                    });
                              });
                              </script>
                              <div class="col-lg-4">
                                    <select name="pax" class="form-control" required>
                                          <option value="" selected>Pax</option>
                                          <?php for($i=1;$i<=100;$i++){ ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                          <?php } ?>
                                    </select>
                              </div>
                        </div>
                        <div class="row form-group">
                              <div class="col-lg-8">
                                    <input type="text" placeholder="Reporting Place" id="reportplaceauto" class="form-control" required name="reportingPlace" value="<?php echo $forClient['client_home_address']; ?>">
                              </div>
                              <div class="col-lg-4">
                                    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                                    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
                                    <input class="form-group" id="timepicker" required name="reportingTime" placeholder="Reporting Time">
                                    <script>
                                          $('#timepicker').timepicker();
                                    </script>
                              </div>
                        </div>
                        <div class="row form-group">
                              <?php
                              $op=mysqli_query($conn,"SELECT * FROM clients_emergency WHERE client_id='$_SESSION[clientid]'");
                              $opp=mysqli_num_rows($op);
                              $oppp=mysqli_fetch_assoc($op); ?>
                              <div class="col-lg-6">
                                    <input type="text" required class="form-control" value="<?php if($opp<=0){}else{echo $oppp['emergency_name'];}?>" name="contact_person" placeholder="Contact Person's Name">
                              </div>
                              <div class="col-lg-6">
                                    <input type="text" required class="form-control" value="<?php if($opp<=0){}else{echo $oppp['emergency_num'];}?>" name="contact_persons_number" placeholder="Contact Person's Number">
                              </div>
                        </div>
                        <input type="hidden" name="tour_id" value="<?php echo $tour_id;?>">
                        <input name="tour_name" type="hidden" value="<?php echo $tour_name;?>">
                        <?php $rightNow=date('Y-m-d H:i:s'); ?>
                        <input type="hidden" name="rightNow" value="<?php echo $rightNow; ?>">
                        <?php $goss=mysqli_query($conn,"SELECT * FROM clients_location WHERE client_id='$_SESSION[clientid]'");
                        $fd=mysqli_fetch_assoc($goss);
                        $lo=$fd['longitude'];
                        $la=$fd['latitude']; ?>
                        <input type="hidden" name="longitude" id="loung"  value="<?php echo $lo;?>">
                        <script>
                              console.log(<?php echo $lo;?>);
                        </script>
                        <input type="hidden" name="latitude" id="laut" value="<?php echo $la;?>">
                        <script>
                              console.log(<?php echo $la;?>);
                        </script>
                        <input type="hidden" id="plazeid" name="place_id" value="<?php echo $fd['place_id'];?>">
                        <button type="submit" name="bookbtn" class="btn btn-secondary">Proceed To The Itinerary</button>

                        <input type="hidden" id="nor">

                        <input type="hidden" id="sou">

                        <input type="hidden" id="eas">

                        <input type="hidden" id="wes">
                  </form>

                  <div class="card" style="margin-top:25px;border-style:solid;border-color: black;" id="map"></div>
                  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&libraries=places"></script>
                  <script>
                      var map;
                      var luzonBounds = {
                        north:22.126313526021505,
                        south:5.200320352447366,
                        west:100.63103549327548,
                        east:130.93132846202548,
                      };
                      map = new google.maps.Map(document.getElementById('map'), {
                        center:{
                              lat: <?php echo $la;?>, lng: <?php echo $lo;?>
                        },
                        restriction:{
                              latLngBounds: luzonBounds,
                              strictBounds: false,
                        },
                        zoom: 8,
                        // draggable:false,
                        mapTypeId: 'roadmap'
                      });
                      var marker;
                      marker = new google.maps.Marker({
                        position:{
                              lat: <?php echo $la;?>, lng: <?php echo $lo;?>
                        },
                        map:map,
                        draggable:true
                      });
                      var searchbox;
                      searchbox = new google.maps.places.SearchBox(document.getElementById('reportplaceauto'));
                      google.maps.event.addListener(searchbox,'places_changed', function(){
                        var places = searchbox.getPlaces();
                        var bounds = new google.maps.LatLngBounds();
                        var i, place;
                        for(i=0;place=places[i];i++){
                              var lati = place.geometry.location.lat();
                              var longi = place.geometry.location.lng();
                              console.log(place);
                              bounds.extend(place.geometry.location);
                              marker.setPosition(place.geometry.location);
                              var plazeid = place.place_id;
                              var aNorth  =   map.getBounds().getNorthEast().lat();
                              var aEast   =   map.getBounds().getNorthEast().lng();
                              var aSouth  =   map.getBounds().getSouthWest().lat();
                              var aWest   =   map.getBounds().getSouthWest().lng();
                        }
                        map.fitBounds(bounds);
                        map.setZoom(15);
                        document.getElementById('loung').value = longi;
                        document.getElementById('laut').value = lati;
                        document.getElementById('plazeid').value = plazeid;
                        document.getElementById('nor').value = aNorth;
                        document.getElementById('sou').value = aSouth;
                        document.getElementById('eas').value = aEast;
                        document.getElementById('wes').value = aWest;
                      });
                  </script>
<!--                   <br><br>
                  <div id="formatted-address" class="card"></div>
                  <div id="address-comp-tab" class="card"></div>
                  <div id="geometry-tab" class="card"></div> -->
            </div>
      </div>
</main>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

<!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<!-- <script>
      //call geo
      geocode();
      function geocode(){
            var location = 'Makati';
            axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
                  params:{
                        address:location,
                        key:'AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI'
                  }
            })
            .then(function(response){
                  console.log(response);
                  //formatted address
                  var formattedaddress=response.data.results[0].formatted_address;
                  var formattedaddressoutput=`
                  <div>${formattedaddress}</div>
                  `;
                  //address components
                  var addressComponents = response.data.results[0].address_components;
                  var addressComponentsOutput = '<ul>';
                  for(var i=0;i<addressComponents.length;i++){
                        addressComponentsOutput+=`
                        <li>${addressComponents[i].types}: ${addressComponents[i].long_name}</li>
                        `;
                  }
                  addressComponentsOutput += '</ul>';
                  //geometry
                  var lat = response.data.results[0].geometry.location.lat;
                  var lng = response.data.results[0].geometry.location.lng;
                  var geometryOutput = `
                  <ul>
                        <li>Lat: ${lat}</li>
                        <li>Lng: ${lng}</li>
                  </ul>
                  `;
                  //output to app
                  document.getElementById('formatted-address').innerHTML = formattedaddressoutput;
                  document.getElementById('address-comp-tab').innerHTML = addressComponentsOutput;
                  document.getElementById('geometry-tab').innerHTML = geometryOutput;
            })
            .catch(function(error){
                  console.log(error);
            })
      }
</script> -->

<?php
            require "footer.php";
      }
}
?>