<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php";
?>

<main>
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Training Seminar Recipients</li>
		</ol>
		<div class="row">
			<div class="col-lg-7">
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-truck-monster"></i>
						Training Seminar Recipients
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Type</th>
										<th>Option</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Type</th>
										<th>Option</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
									$sql=mysqli_query($conn,"SELECT * FROM training_seminar_table_present");
									while($row=mysqli_fetch_assoc($sql)){ ?>
										<tr>
											<td><?php echo $row['person_id'];?></td>
											<td><?php echo $row['person_name'];?></td>
											<td><?php echo $row['type'];?></td>
											<td>
												<form action="../includes/uninvite_sem.php" method="get">
													<input type="hidden" name="email_add" value="<?php echo $row['email_add'];?>">
													<input type="hidden" name="training_id" value="<?php echo $row['training_id'];?>">
													<button class="btn btn-danger btn-block" name="unin">Uninvite</button>
												</form>
											</td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-truck-monster"></i>
						Invitation Details:
					</div>
					<div class="card-body">
						<?php 
						$qua=mysqli_query($conn,"SELECT * FROM training_seminar_table_present");
						$djk=mysqli_num_rows($qua);
						if($djk!=0){
							$sqlll=mysqli_query($conn,"SELECT * FROM training_seminar_table_present WHERE invite='1'");
							$coun=mysqli_num_rows($sqlll);
							if($coun<=0){ ?>
								<form action="../includes/send_invite.inc.php" method="get">
									<div id="section1">
										<div class="form-group">
											<input required type="text" name="subject" class="form-control" placeholder="Subject" style="font-weight:500;">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-6">
													<input required type="date" name="semiDate" id="" class="form-control">
												</div>
												<div class="col-lg-6">
													<input required type="time" name="semiTime" id="" class="form-control">
												</div>
											</div>
										</div>
										<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
										<textarea required id="" class="form-control" placeholder="Content" name="message_deets" required rows="5"></textarea>
										<script>
											CKEDITOR.replace( 'message_deets' );
										</script>
										<button class="btn btn-block btn-success mt-3" name="send">Send</button>
									</div>
								</form>
								<?php 
							}
							else {?>
								<div id="section2" style="padding:30px;"><center>
									<h3>Invitations were sent!</h3>
									<form action="../includes/verdict_seminar.inc.php" method="get">
										<button class="btn btn-block btn-primary" name="fin">Finish Training Seminar</button>
										<button class="btn btn-block btn-danger" name="can">Cancel Training Seminar</button>
									</form>
								</center></div>
								<?php
							}
						}
						else{ ?>
							<center><h2>No people in the list</h2></center>
							<?php
						} ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-truck-monster"></i>
						Past Seminars
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Seminar Date</th>
										<th>Seminar Time</th>
										<th>Status</th>
										<th>Invite List</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$md=mysqli_query($conn,"SELECT * FROM seminar_table");
									while($roui=mysqli_fetch_assoc($md)){ ?>
										<tr>
											<td><?php echo $roui['seminar_id']; ?></td>
											<td><?php 
											$araw=$roui['seminar_date'];
											$araws=strtotime($araw);
											$day=DATE("d M Y",$araws);
											echo $day; ?></td>
											<td><?php echo $roui['seminar_time']; ?></td>
											<td><?php
											if($roui['status']=="OK"){
												echo "ONGOING";
											}
											else{
												echo $roui['status'];
											} ?></td>
											<td style="width:20%">
												<button class="btn btn-block btn-secondary text-white">See More</button>
											</td>
										</tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php
  require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>