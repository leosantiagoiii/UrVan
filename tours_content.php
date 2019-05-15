<?php require "header.php"; require "includes/dbconnect.inc.php"; ?>
<main>
	<div class="tours_section">
		<form action="book_trip.php" method="GET">
			<?php //$tour_id=$_GET['tour_id'];
			$tour_id=$_REQUEST['tour_id'];
			$query="SELECT * FROM tours_and_packages_table WHERE tour_id=$tour_id";
			$result=mysqli_query($conn,$query);
			while($row = mysqli_fetch_assoc($result)){
			$all=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$row[tour_id]'");
			$cco=mysqli_num_rows($all); ?>
			<input type="hidden" name="tour_id" value="<?php echo $row['tour_id']; ?>">
			<input type="hidden" name="tour_name" value="<?php echo $row['tour_name']; ?>">
			<h1 class="h1-trip-name"><?php echo $row['tour_name']; if($cco>=1){echo " <u>(SINGLE TRIP)</u>";} ?></h1>
			<img style="border-style:solid;margin-bottom:20px;width:80%;object-fit: cover;height:450px" src="includes/tour_and_packages_image_get.inc.php?tour_id=<?php echo $row['tour_id']; ?>">
			<h3 class="h3-trip-price">Php<?php echo $row['tour_price']; ?> per van</h3>
			<p>
				<ul>
					<li>Increments of 12 (pax) is the basis in order to determine how many vans will be used.</li>
					<li>The number of vans will be multiplied to the rate of the tour.</li>
				</ul>
			</p>
			<p class="p-trip-desc"><?php echo $row['tour_description'];?></p>
			<?php $ss="SELECT * FROM tours_and_packages_gallery_table WHERE tour_id='$tour_id'";
			$rr=mysqli_query($conn,$ss); ?>
			<div class="roror" style="background-color:none;border-style:solid;border-width:2px;">
				<?php while($rro=mysqli_fetch_assoc($rr)){ ?>
				<div class="colcol">
					<a data-toggle="modal" data-target="#img<?php echo $rro['tour_gallery_id'].$rro['tour_id']; ?>"><img src="includes/<?php echo $rro['target_dir']; ?>" style="border-style:solid;border-width:2px;width:100%;object-fit:cover;height:300px;"></a>
				</div>
				<div class="modal fade bd-example-modal-lg" id="img<?php echo $rro['tour_gallery_id'].$rro['tour_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<img src="includes/<?php echo $rro['target_dir']; ?>" style="width:100%;" alt="">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php if(!isset($_SESSION['clientid'])){ ?>
				<button class="btn btn-lg btn-primary mt-4 btn-block" data-toggle="tooltip" data-placement="top" title="You should login/create an account first" type="button">Book Now</button>
			<?php } else { ?>
			<?php
			$ee=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE client_id=$_SESSION[clientid] AND completion='NO' ORDER BY created_at ASC LIMIT 1");
			$bila=mysqli_num_rows($ee);
			if($bila<=0){
			?>
			<button class="btn btn-lg btn-primary mt-4 btn-block" 
					<?php if(!isset($_SESSION['clientid'])){
					echo ' data-toggle=\'tooltip\' 
					type=\'button\' 
					data-placement=\'top\' 
					title=\'You should login/create an account first\'';
					} elseif(isset($_SESSION['clientid'])){
						echo 'type=\'submit\'';
					} ?>>
				Book Now
			</button>
			<?php } else { ?>
			<button class="btn btn-lg btn-primary mt-4 btn-block" data-toggle="tooltip" data-placement="top" title="You haven't finished your tour" type="button">Book Now</button><?php
					}
				}
			} ?>
		</form>
	</div>
</main>
<script>
$(function () {
$('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php require "footer.php"; ?>