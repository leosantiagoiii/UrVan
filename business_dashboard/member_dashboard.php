<?php
session_start();
if(isset($_SESSION['memberid'])){
  require "header_memberdashboard.php";
  require "../includes/dbconnect.inc.php";
?>

<div class="container">
	<h1> Dashboard </h1>
</div>
<?}?>