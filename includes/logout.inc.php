<?php session_start();
require "dbconnect.inc.php";
if(isset($_SESSION['clientid'])){
	mysqli_query($conn,"DELETE FROM for_activeusers WHERE acc_id='$_SESSION[clientid]'");
}
session_unset();
session_destroy();

header("Location: ../index.php?logout=success");
