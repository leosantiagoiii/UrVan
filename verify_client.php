<?php require "header.php"; ?>
<div class="container text-center" style="padding:30px;">
	<div style="border-style:solid;border-width:1px;margin:200px 0;padding:30px;box-shadow: 17px 20px 0px 0px rgba(0,0,0,0.75);">
		<?php if(isset($_GET['client_id']) && !empty($_GET['client_id']) AND isset($_GET['client_hash']) && !empty($_GET['client_hash'])){
		require 'includes/dbconnect.inc.php';
		$id=$_GET['client_id'];
		$hash=$_GET['client_hash'];
		$search="SELECT * FROM verify_client_table WHERE client_verify='0' AND client_id='$id' AND client_hash='$hash'";
		$result=mysqli_query($conn,$search);
		$count=mysqli_num_rows($result);
		if($count>0){
		$query="UPDATE verify_client_table SET client_verify='1' WHERE client_verify='0' AND client_hash='$hash' AND client_id='$id'";
		mysqli_query($conn,$query);
		echo '<h2>Hurrah!</h2><div>Your account has been activated!</div>';
		}
		else{
		echo '<h2>Um, excuse me.</h2><div>This link is either invalid or you\'ve already activated your account.</div>';
		}
		}
		elseif(isset($_GET['verification']) && !empty($_GET['verification']) AND isset($_GET['client_id']) && !empty($_GET['client_id'])){
		echo '
		<h2>I\'m sorry '. $_GET['client_fname'] .' but...</h2>
		<div>You still haven\'t verified your account. We send an email to <b><u>'. $_GET['email'] .'</u></b> containing the link for verification.<br>If it isn\'t in your inbox, try checking the spam folder.</div>
		';
		}
		else{
		echo '
		<h2>I\'m sorry but...</h2>
		<div>That\'s link you\'re trying to access is fobidden.</div>
		';
		}?>
	</div>
</div>
<?php require "footer.php";?>