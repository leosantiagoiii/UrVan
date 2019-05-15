<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
  require "../includes/dbconnect.inc.php";
?>

<style>
	button{
		margin-bottom:5px;
	}
</style>

<main>
	
	<div class="container-fluid">
		
		<!-- Breadcrumbs-->
        <ol class="breadcrumb">
        	<li class="breadcrumb-item">
            	<a href="index.php">Dashboard</a>
         	</li>
         	<li class="breadcrumb-item active">Membership Requests</li>
        </ol>

        <div class="card mb-3">
        	<div class="card-header">
            	<i class="fas fa-table"></i>
            	Membership Requests
          	</div>
            <div class="card-body">
            	<div class="table-responsive">
            		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
		                    <tr>
			                    <th>Name</th>
			                    <th>Address</th>
			                    <th>Appointment Date</th>
			                    <th>Appointment Time</th>
			                    <th>Options</th>
		                    </tr>
	                  	</thead>
	                  	<tfoot>
		                    <tr>
			                    <th>Name</th>
			                    <th>Address</th>
			                    <th>Appointment Date</th>
			                    <th>Appointment Time</th>
			                    <th>Options</th>
		                    </tr>
	                  	</tfoot>
	                  	<tbody>
	                  		<?php $sql="SELECT * FROM member_appointment_details_table WHERE member_appointment_approval='APPROVED' OR member_appointment_approval='PENDING' ORDER BY member_appointment_datemeet ASC";
	                  		$result=mysqli_query($conn,$sql);
	                  		while($row=mysqli_fetch_assoc($result)){ ?>
		                  		<tr <?php if($row['member_appointment_approval']=='APPROVED')
		                  		{echo 'class=\'bg-secondary text-white\'';}
		                  		elseif($row['member_appointment_approval']=='PENDING')
		                  		{}
		                  		else
		                  		{} ?>">
		                  			<td><?php echo $row['member_appointment_first_name'].' '.$row['member_appointment_last_name']; ?></td>
		                  			<td><?php echo $row['member_appointment_address'];?></td>
		                  			<td><?php echo $row['member_appointment_datemeet'];?></td>
		                  			<td><?php echo $row['member_appointment_timemeet'];?></td>
		                  			<td>
		                  				<?php if($row['member_appointment_approval']=='PENDING'){ ?>
			
				                  				<form action="../includes/membership_approved.inc.php" method="post">
				                  					<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
					                  				<button class="btn btn-primary btn-block" type="submit" name="approved">Approve</button>
					                  			</form>
						                  		<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#decline<?php echo $row['member_appointment_number'];?>">Decline</button>
						                  		<form action="admin_membership_viewdetails.php" method="GET">
						                  			<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
						                  			<button class="btn btn-info btn-block">Details</button>
						                  		</form>
			
		                  				<?php }elseif($row['member_appointment_approval']=='APPROVED'){ ?>
			
				                  				<form action="admin_membership_viewdetails.php" method="GET">
				                  					<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
					                  				<button class="btn btn-warning btn-block">Details</button>
					                  			</form>
					                  			<form action="../includes/membership_forfollowup.inc.php" method="post">
					                  				<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
					                  				<button class="btn btn-primary btn-block" data-toggle="modal" type="submit" name="followup">For Follow-up</button>
					                  			</form>
					                  			<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#completedeny<?php echo $row['member_appointment_number'];?>">Deny</button>
			
				                  			</div>
		                  				<?php } ?>
		                  			</td>
		                  		</tr>

		                  		<div class="modal fade" id="completedeny<?php echo $row['member_appointment_number'];?>" tabindex="-1" role="dialog">
		                  			<div class="modal-dialog" role="document">
		                  				<div class="modal-content">
		                  					<div class="modal-header">
		                  						<h6 class="modal-title" id="exampleModalLabel">
		                  							ALERT
		                  						</h6>
		                  						<button class="close" type="button" data-dismiss="modal" aria-label="close">
		                  							<span aria-label="true">&times;</span>
		                  						</button>
		                  					</div>
		                  					<div class="modal-body">
		                  						Are you sure you want to completely deny <?php echo $row['member_appointment_first_name']; ?>'s membership?
		                  					</div>
		                  					<div class="modal-footer">
		                  						<form action="../includes/membership_declined.inc.php" method="post">
		                  							<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
		                  							<button class="btn btn-danger" type="submit" name="completedeny" formaction="../includes/membership_declined_completedenial.inc.php">Yes</button>
		                  						</form>
		                  						<button class="btn" type="button" data-dismiss="modal">No</button>
		                  					</div>
		                  				</div>
		                  			</div>
		                  		</div>

		                  		<div class="modal fade" id="decline<?php echo $row['member_appointment_number'];?>" tabindex="-1" role="dialog">
		                  			<div class="modal-dialog" role="document">
		                  				<div class="modal-content">
		                  					<div class="modal-header">
		                  						<h6 class="modal-title" id="exampleModalLabel">
		                  							ALERT
		                  						</h6>
		                  						<button class="close" type="button" data-dismiss="modal" aria-label="close">
		                  							<span aria-label="true">&times;</span>
		                  						</button>
		                  					</div>
		                  					<div class="modal-body">
		                  						Why decline <?php echo $row['member_appointment_first_name']; ?>'s request for an appointment?
		                  					</div>
		                  					<div class="modal-footer">
		                  						<form action="../includes/membership_declined.inc.php" method="post">
		                  							<input type="hidden" name="member_appointment_number" value="<?php echo $row['member_appointment_number']; ?>">
		                  							<button class="btn btn-warning" type="submit" name="yesbutton">Scheduling Issues</button>
		                  							<button class="btn btn-danger" type="submit" name="completedeny" formaction="../includes/membership_declined_completedenial.inc.php">Complete Denial</button>
		                  						</form>
		                  						<button class="btn" type="button" data-dismiss="modal">No</button>
		                  					</div>
		                  				</div>
		                  			</div>
		                  		</div>

	                  		<?php } ?>
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