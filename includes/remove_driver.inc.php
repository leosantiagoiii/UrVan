<?php session_start();
require "dbconnect.inc.php";
$driver_id=$_GET['driver_id'];
$member_id=$_GET['member_id'];

mysqli_query($conn,"DELETE FROM official_authorized_driver_table WHERE driver_id='$driver_id'");
mysqli_query($conn,"DELETE FROM official_authorized_driver_emergency_contact_table WHERE driver_id='$driver_id'");
mysqli_query($conn,"DELETE FROM driver_queue WHERE driver_pk='$driver_id'");

header("Location:../business_dashboard/add_driv.php?delete=success&member_id=$member_id");