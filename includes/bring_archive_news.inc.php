<?php session_start();
require "dbconnect.inc.php";
if(!isset($_POST['return']) || !isset($_SESSION['adminid'])){

}
else{
	$news_id = $_POST['news_id'];
	$sql=mysqli_query($conn,"INSERT INTO news_and_updates_table
		SELECT * FROM news_and_updates_archive_table
		WHERE news_id='$news_id'");
	$sql=mysqli_query($conn,"DELETE FROM news_and_updates_archive_table
		WHERE news_id='$news_id'");
	$count=mysqli_num_rows($sql);
	header("Location:../business_dashboard/arch_neu.php?return=success");
	exit();
}