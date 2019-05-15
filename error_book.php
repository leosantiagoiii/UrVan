<?php require "header.php";
$tour_id=$_GET['tour_id'];
$sql=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
$row=mysqli_fetch_assoc($sql);
$tour_name=$row['tour_name'];?>
<main>
	<div style="margin:100px 0px;">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div style="padding:30px;" class="container text-center">
					<div style="border-style:solid;border-width:1px; padding:50px;box-shadow: 10px 10px 0px 0px rgba(64,64,64,1);">
						<h1 style="font-family:raleway">We apologise for this inconvenience, but we don't have enough vans and/or drivers to accomodate your trip at the moment.</h1>
						<div style="font-family:monsreg">Perhaps you could reduce the number of pax or wait for a few more days before booking again.</div>
						<a href="tours_content.php?tour_id=<?php echo $tour_id; ?>" class="mt-3 btn btn-primary">Return to <?php echo $tour_name; ?> Tour here</a>
					</div>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
</main>
<?php
require "footer.php"; ?>