<?php session_start();

require "dbconnect.inc.php";

$news_id=$_POST['news_id'];

$k="SELECT * FROM news_and_updates_gallery_table WHERE news_id='$news_id'";
$m=mysqli_query($conn,$k);
$cl=mysqli_num_rows($m);

mysqli_query($conn,"
		INSERT INTO news_and_updates_archive_table
		SELECT * FROM news_and_updates_table
		WHERE news_id='$news_id'
		");

mysqli_query($conn,"
		UPDATE news_and_updates_archive_table SET
		news_edited=CURRENT_TIMESTAMP()
		WHERE news_id='$news_id'
		");

$sq="DELETE FROM news_and_updates_table WHERE news_id='$news_id'";
$re=mysqli_query($conn,$sq);

header('Location:../business_dashboard/admin_news_and_updates.php?archive=success');
exit();