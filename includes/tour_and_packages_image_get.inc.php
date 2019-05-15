<?php
session_start();

require "dbconnect.inc.php";
$id=stripslashes($_REQUEST['tour_id']);
$image=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id=$id");
$image=mysqli_fetch_assoc($image);
$image=$image['tour_image'];

header("Content-type:image/jpeg");

echo $image;