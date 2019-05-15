<?php require "header.php";
if(isset($_GET['rediredi'])){
    session_unset();
    session_destroy();
	$mu=$_GET['client_id'];
	mysqli_query($conn,"DELETE FROM active_accs WHERE acc_id='$mu'");
}
?>
<div class="container text-center" style="padding:30px;">
	<div style="border-style:solid;border-width:1px;margin:200px 0;padding:30px;box-shadow: 17px 20px 0px 0px rgba(0,0,0,0.75);">
		<?php
		if(isset($_GET['client_id']) && !empty($_GET['client_id']) AND isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['deac_hash']) && !empty($_GET['deac_hash'])){
			$client_id=$_GET['client_id'];
			$id=$_GET['id'];
			$deac_hash=$_GET['deac_hash'];
			$search="SELECT * FROM client_deact_request WHERE id='$id' AND deac_hash='$deac_hash'";
			$result=mysqli_query($conn,$search);
			$count=mysqli_num_rows($result);
			if($count>=1){
				$query="INSERT INTO clients_table_archive SELECT * FROM clients_table WHERE client_id='$client_id'";
				mysqli_query($conn,$query);
				mysqli_query($conn,"DELETE FROM clients_table WHERE client_id='$client_id'");
				$query="INSERT INTO client_deact_request_success SELECT * FROM client_deact_request WHERE id='$id'";
				mysqli_query($conn,$query);
				mysqli_query($conn,"DELETE FROM client_deact_request WHERE id='$id'");
				echo '<h2>Oh, no :(</h2><div>We\'ll definitely miss you!</div>';

			}
			else{
				echo '<h2>Um, excuse me.</h2><div>This link is either invalid or you\'ve already deactivated your account.</div>';
			}
		}
		// elseif(isset($_GET['verification']) && !empty($_GET['verification']) AND isset($_GET['client_id']) && !empty($_GET['client_id'])){
		// echo '
		// <h2>I\'m sorry '. $_GET['client_fname'] .' but...</h2>
		// <div>You still haven\'t verified your account. We send an email to <b><u>'. $_GET['email'] .'</u></b> containing the link for verification.<br>If it isn\'t in your inbox, try checking the spam folder.</div>
		// ';
		// }
		else{
			echo '
			<h2>I\'m sorry but...</h2>
			<div>That\'s link you\'re trying to access is fobidden.</div>
			';
		}?>
	</div>
</div>
<?php require "footer.php";?>