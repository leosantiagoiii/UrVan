<?php session_start();
$rating_id=$_GET['rating_id'];
$major_id=$_GET['major_id'];
$name=$_GET['name'];
require "../includes/dbconnect.inc.php";
require "header.php";
?>
<main>
	<div class="container-fluid">
		<div class="container mt-4">
			<div class="card" style="padding:20px;height:560px;overflow:scroll;">
				<div style="width:100%">
					<h3 style="margin-bottom:20px;">
						<?php
						echo $major_id.' ('.$name.')'; ?>
					</h3>
					<table class="table tbl tbl-striped">
						<thead>
							<tr>
								<th style="width:10%;">Q#</th>
								<th>Question</th>
								<th style="width:20%;">Rating</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql=mysqli_query($conn,"SELECT * FROM booking_rating_sub WHERE rating_id='$rating_id' AND booking_rating_sub.questions='1'");
							while($row1=mysqli_fetch_assoc($sql)){ ?>
								<tr>
									<td>1</td>
									<td>The driver/s provided high quality service and was polite and friendly with the clients</td>
									<td><?php echo $row1['value'];?></td>
								</tr>
								<?php
							} ?>
							<?php
							$momo=mysqli_query($conn,"SELECT * FROM booking_rating_sub WHERE rating_id='$rating_id' AND booking_rating_sub.questions='2'");
							while($row=mysqli_fetch_assoc($momo)){ ?>
								<tr>
									<td>2</td>
									<td>The driver was accommodating and showed a good attitude</td>
									<td><?php echo $row['value'];?></td>
								</tr>
								<?php
							} ?>
							<?php
							$vef=mysqli_query($conn,"SELECT * FROM booking_rating_sub WHERE rating_id='$rating_id' AND booking_rating_sub.questions='3'");
							while($row=mysqli_fetch_assoc($vef)){ ?>
								<tr>
									<td>3</td>
									<td>The vehicle was clean, comfortable and safe to ride on</td>
									<td><?php echo $row['value'];?></td>
								</tr>
								<?php
							} ?>
							<?php
							$mimi=mysqli_query($conn,"SELECT * FROM booking_rating_sub WHERE rating_id='$rating_id' AND booking_rating_sub.questions='4'");
							while($row=mysqli_fetch_assoc($mimi)){ ?>
								<tr>
									<td>4</td>
									<td>The trip went smoothly; the driver practiced safe driving</td>
									<td><?php echo $row['value'];?></td>
								</tr>
								<?php
							} ?>
							<?php
							$solk=mysqli_query($conn,"SELECT * FROM booking_rating_sub WHERE rating_id='$rating_id' AND booking_rating_sub.questions='5'");
							while($row=mysqli_fetch_assoc($solk)){ ?>
								<tr>
									<td>5</td>
									<td>The trip was relaxing and no issues were encountered</td>
									<td><?php echo $row['value'];?></td>
								</tr>
								<?php
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<th>Q#</th>
								<th>Question</th>
								<th>Rating</th>
							</tr>
						</tfoot>
					</table>
					<h4>Complaint(s)/Remarks:</h4>
					<?php
					$m=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id'");
					$r=mysqli_fetch_assoc($m);
					if(!isset($r['remarks']) or $r['remarks']==""){
						echo "No remark/complaints";
					}
					else{
						echo $r['remarks'];
					} ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
require "footer.php"; ?>