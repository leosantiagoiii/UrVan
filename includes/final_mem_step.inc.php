<?php session_start();
require "dbconnect.inc.php";

$init_appt_date=$_GET['init_appt_date'];
$init_appt_time=$_GET['init_appt_time'];
$member_id=$_GET['member_id'];

mysqli_query($conn,"INSERT INTO initial_member_appointment (init_appt_id,member_id,init_appt_date,init_appt_time) VALUES ('','$member_id','$init_appt_date','$init_appt_time')");

header("Location:../index.php?membership_request_for_$member_id=success");