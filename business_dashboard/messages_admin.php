<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php";
?>

<main>
	
</main>

<?php
  require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>