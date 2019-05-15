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
         	<li class="breadcrumb-item active">Membership Fees</li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-user-circle"></i>
				Membership Fees
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<?php
					$sql=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1')"); ?>
            		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            			<thead>
            				<tr>
            					<th>Member ID</th>
            					<th>Name</th>
            					<th>Status</th>
            					<th>Member Since</th>
            					<th>Options</th>
            				</tr>
            			</thead>
            			<tfoot>
            				<tr>
            					<th>Member ID</th>
            					<th>Name</th>
            					<th>Status</th>
            					<th>Member Since</th>
            					<th>Options</th>
            				</tr>
            			</tfoot>
            			<tbody>
            				<?php
            				while($row=mysqli_fetch_assoc($sql)){
            					$since=$row['member_created_at'];
	            				$since_=strtotime($since);
	            				$since=DATE("Y-m-d",$since_);
	            				$formatted_since=DATE("Y M d; H:i A",$since_);
	            				$day30=DATE("Y-m-d",strtotime("$since+30 day"));
	            				$today=DATE("Y-m-d");
	            				$sql2=mysqli_query($conn,"SELECT * FROM official_member_member_payment WHERE member_id='$row[member_id]'");
	            				$count=mysqli_num_rows($sql2); ?>
	            				<tr <?php
	            					if(($today>=$day30) AND ($count<=0)){
	            						echo 'class="text-white bg-danger"';
	            					}
	            					if(($today<$day30) AND ($count>=1)){
	            						echo 'class="bg-primary"';
	            					}
	            					?>>
	            					<td><?php echo $row['member_id']; ?></td>
	            					<td><?php echo $row['member_first_name'].' '.$row['member_last_name'];?></td>
	            					<td>
	            						<?php
	            						if($row['active']=='0'){
	            							echo "Active";
	            						}
	            						else{
	            							echo "Inactive";
	            						} ?>
	            					</td>
	            					<td>
	            						<?php 
	            						echo $formatted_since." ";
	            						if($day30==$today){
	            							echo "(Payment overdue)";
	            						} ?>
	            					</td>
	            					<td style="width:15%">
	            						<form action="../includes/mem_accept_payment.inc.php" method="post">
	            							<input type="hidden" name="email" value="<?php echo $row['member_email']; ?>">
	            							<input type="hidden" name="mem_id" value="<?php echo $row['member_id']; ?>">
	            							<?php
	            							if($count<=0){
	            								echo '<button class="btn btn-primary btn-block" type="submit" name="pay">Accept Payment</button>';
	            							}
	            							else{
	            								echo '<button class="btn btn-success btn-block" type="submit" name="unpay">Undo</button>';
	            							} ?>
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
</main>


<?php
  require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>