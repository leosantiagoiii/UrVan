<?php
require "dbconnect.inc.php";
if(!isset($_POST['send'])){
  header("Location:../index.php?error");
  exit();
}
else{
  $nm=$_POST['fullname'];
  $sbj=$_POST['subject'];
  $eml=$_POST['email'];
  $msg=$_POST['message'];

  $from=$eml;
  $to="support@urvan.webstarterz.com";
  $subject="FROM CONTACT: ".$sbj;
  $message='
    <html>
      <body style=\'padding:30px;margin:0;border-style:solid;border-width:2px;\'>
        <h1>'.$sbj.'</h1>
        <p>'
          .$msg.
        '</p>
      </body>
    </html>
  ';
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: ".$from."\r\n";
  mail($to,$subject,$message,$headers);

  header("Location:../contact-us.php?msg=sent");
  exit();

}