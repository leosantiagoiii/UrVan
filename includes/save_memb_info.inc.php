<?php
session_start();
require "dbconnect.inc.php";

$member_id=$_POST['member_id'];
$member_emergency_name=$_POST['member_emergency_name'];
$member_emergency_address=$_POST['member_emergency_address'];
$member_emergency_phone=$_POST['member_emergency_phone'];
$member_emergency_relationship=$_POST['member_emergency_relationship'];

mysqli_query($conn,"INSERT INTO initial_official_member_emergency_contact_table
	(
	member_id,
	member_emergency_name,
	member_emergency_address,
	member_emergency_phone,
	member_emergency_relationship
	)
	VALUES
	(
	'$member_id',
	'$member_emergency_name',
	'$member_emergency_address',
	'$member_emergency_phone',
	'$member_emergency_relationship'
	)");

header("Location:../adding_drivers_signup.php?member_id=$member_id");