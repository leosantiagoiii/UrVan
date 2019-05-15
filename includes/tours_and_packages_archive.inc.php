<?php 

require "dbconnect.inc.php";

$tours_id=$_POST['tours_id'];

$sql="INSERT INTO tours_and_packages_archive_table (tour_id,tour_name,tour_description,tour_price,tour_image_name,tour_image) SELECT tour_id,tour_name,tour_description,tour_price,tour_image_name,tour_image FROM tours_and_packages_table WHERE tour_id=$tours_id";
$res=mysqli_query($conn,$sql);
$del="DELETE FROM tours_and_packages_table WHERE tour_id=$tours_id";
$res=mysqli_query($conn,$del);

header('Location:../business_dashboard/admin_tours_and_packages.php?archive=success');