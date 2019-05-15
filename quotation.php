<?php require "header.php"; ?>
<style>
	label{
		font-weight: bolder;
	}
</style>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
<main>
	<div style="margin:50px 20px;">
		<?php if(!isset($_GET['msg'])){ ?>
		<div class="container" style="padding:35px;border-width:1px;box-shadow: 0 0 0 0.2vh black;">
			<form action="includes/quotation.inc.php" method="POST">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4">
							<label for="">Organization/Company Name:</label>
							<input type="text" class="form-control" required="" name="OrgName">
						</div>
						<div class="col-lg-2">
							<label for="">For How Many?</label>
							<select name="count" id="" required="" class="form-control">
								<?php for($i=1;$i<=100;$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-3">
							<label for="">Expected Trip Start Date</label>
							<input type="text" name="startDate" class="form-control daepic" required="" placeholder="Start Date">
						</div>
						<div class="col-lg-3">
							<label for="">Expected Trip End Date</label>
							<input type="text" name="endDate" class="form-control daepic" required="" placeholder="End Date">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4">
							<label for="">Your email:</label>
							<input type="email" required="" class="form-control" name="email">
						</div>
						<div class="col-lg-4">
							<label for="">Name of Contact Person:</label>
							<input type="text" required="" class="form-control" name="contactPerson">
						</div>
						<div class="col-lg-4">
							<label for="">Contact Number:</label>
							<input type="text" required="" class="form-control" name="contactNumber">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<label for="">Message & Details</label>
							<textarea class="form-control" placeholder="Content" name="msgContent" required="" rows="7">
								<?php
								echo "<h2><strong>Company Address (Preferred area of pickup)</strong>:</h2>
								<h2><strong>Itinerary</strong>:</h2>
								<ul>
									<li>&nbsp;</li>
								</ul>
								<h2><strong>Other Details</strong>:</h2>
								<p>&nbsp;</p>";?>
							</textarea>
				            <script>
				            	CKEDITOR.replace( 'msgContent' );
				            </script>
						</div>
					</div>
				</div>
				<div class="form-group" style="text-align:right;">
					<button type="submit" class="btn btn-primary btn-lg" name="sendbutton">Send</button>
				</div>
			</form>
		</div>
		<?php } else { ?>
			<h1 class="text-center">Message Sent</h1>
		<?php } ?>
	</div>
</main>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd'
	});
	$(function(){
		$(".daepic").datepicker();
	});
});
</script>

<?php require "footer.php"; ?>