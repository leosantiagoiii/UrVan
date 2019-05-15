<?php
session_start();

require "dbconnect.inc.php";
$id=stripslashes($_REQUEST['news_id']);
$image=mysqli_query($conn,"SELECT * FROM news_and_updates_table WHERE news_id=$id");
$image=mysqli_fetch_assoc($image);
$image=$image['news_image'];

header("Content-type:image/jpeg");

echo $image;