<?php session_start();
require "../includes/dbconnect.inc.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script>
		$(document).ready(function(){
			$.datepicker.setDefaults({
				dateFormat: 'yy-mm-dd'
			});
			$(function(){
				var minDate=new Date(); //
				// minDate.setDate(minDate.getDate()+17);
				var maxDate=new Date(); //
				// maxDate.setDate(minDate.getDate()+365);
				console.log(minDate);
				console.log(maxDate);
				$('#start_date').datepicker({
					numberOfMonth:1,
					// minDate:minDate,
					maxDate:maxDate, //
					onClose:function(selectedDate){
						$('#end_date').datepicker("option","minDate",selectedDate);
						var viol=document.getElementById('start_date').value;
						var newd=new Date(viol);
						var newmax=newd.toString();
						console.log(newmax);
					}
				});
				$('#end_date').datepicker({
					numberOfMonth:1,
					minDate:minDate,
					maxDate:maxDate,
					onClose:function(selectedDate){
						$('#end_date').datepicker("option","minDate",selectedDate)
					}
				});
			});
		});
	</script>
	<link rel="stylesheet" href="">
</head>

<body style="body:100%;padding:20px;">
	<div class="container card" style="padding:20px;width:100%;overflow:scroll;">
		<div class="mt-1 mb-3">
			<a class="btn btn-success" href="index.php">Return Home</a>
		</div>
		<form method="get">
			<div class="row">
				<div class="col-lg-3 form-group"><input required class="form-control" type="text" name="start_date" id="start_date" placeholder="Start Date" value="<?php if(isset($_GET['start_date'])){echo $_GET['start_date'];} ?>"></div>
				<div class="col-lg-3 form-group"><input required class="form-control" type="text" name="end_date" id="end_date" placeholder="End Date" value="<?php if(isset($_GET['end_date'])){echo $_GET['end_date'];} ?>"></div>
				<div class="col-lg-3 form-group">
					<select required name="selectVal" class="form-control" id="">
						<option></option>
						<option value="actlog">Activity Log</option>
						<option value="tripz">Trips</option>
						<option value="capz">Capital</option>
						<option value="membersh">Membership</option>
					</select>
				</div>
				<div class="col-lg-3 form-group"><button class="btn btn-block btn-primary" type="submit" value="all" name="submitButton">Submit</button></div>
			</div>			
		</form>
		<hr>
		<?php
		if(isset($_GET['submitButton']) AND $_GET['submitButton']=="all" AND isset($_GET['selectVal'])){
			$start_date=$_GET['start_date'];
			$end_date=$_GET['end_date'];

			if($_GET['selectVal']=='actlog'){
				$ju=mysqli_query($conn,"SELECT * FROM activity_log_table WHERE DATE(activity_log_time) BETWEEN '$start_date' AND '$end_date'");
				$countju=mysqli_num_rows($ju); ?>
				<h2>Activity Log:</h2>
				<?php
				if($countju<=0){
					echo "<h2>~~``No exisitng data in db~~``</h2>";
				}
				else{ ?>
					<table class="table table-striped">
						<tr>
							<th>Role</th>
							<th>UN</th>
							<th>Time</th>
						</tr>
						<?php
						while($activity=mysqli_fetch_assoc($ju)){ ?>
							<tr>
								<td><?php echo $activity['activity_log_role']; ?></td>
								<td><?php echo $activity['activity_log_username']; ?></td>
								<td><?php echo DATE("Y M d H:i A",strtotime($activity['activity_log_time'])); ?></td>
							</tr>
							<?php 
						} ?>
					</table>
					<?php 
				}
			}
			elseif($_GET['selectVal']=='tripz'){ ?>
				<h2>Trips:</h2>
				<?php
				$sql=mysqli_query($conn,"SELECT DISTINCT major_id FROM booking_history_trip WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date' ORDER BY created_at ASC");
				$countsql=mysqli_num_rows($sql);
				if($countsql<=0){
					echo "<h2>~~``No exisitng data in db~~``</h2>";
				}
				else{ ?>
					<table class="table table-striped">
						<tr>
							<th>No</th>
							<th>Trip ID</th>
							<th>Tour</th>
							<th>Made by</th>
							<th>Duration</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Pax</th>
							<th>Transaction Type</th>
							<th>Vans</th>
							<th>Initial Amt</th>
							<th>Total Amount</th>
						</tr>
						<?php
						$i=0;
						while($history=mysqli_fetch_assoc($sql)){
							$om=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$history[major_id]'");
							$major=mysqli_fetch_assoc($om);
							$client_id=$major['client_id'];
							$po=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$history[major_id]'"); 
							$trans=mysqli_fetch_assoc($po);
							$i++; ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $history['major_id'];?></td>
								<td><?php echo $trans['trip_name']; ?></td>
								<td>
									<?php 
									$pi=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_id='$client_id'");
									$client=mysqli_fetch_assoc($pi);
									echo $client['client_nickname'].' '.$client['client_last_name']; ?>
								</td>
								<td>
									<?php echo $major['duration']+1; ?>
								</td>
								<td>
									<?php echo DATE("Y M d",strtotime($major['start_date'])); ?>
								</td>
								<td>
									<?php echo DATE("Y M d",strtotime($major['end_date'])); ?>
								</td>
								<td>
									<?php 
									echo $pax = $major['pax'];
									$numOfVan = ceil($pax/12); ?>
								</td>
								<td>
									<?php echo $trans['transaction_type'];?>
								</td>
								<td><?php echo $numOfVan; ?></td>
								<td><?php echo $trans['total_amount']; ?></td>
								<td>
									<?php
									if($trans['total_afterbal']==null){
										echo $amt = $trans['total_amount'];
									}
									else{
										echo $amt = $trans['total_afterbal'];
									}
									$totalAmt[]=$amt; ?>
								</td>
							</tr>
							<?php 
						} ?>
						<tr>
							<th colspan="11">Total:</th>
							<td>
								<?php
								$sum=array_sum($totalAmt);
								$sizeof=sizeof($totalAmt);
								echo number_format($sum,2); ?>
							</td>
						</tr>
						<tr>
							<th colspan="11">Average:</th>
							<td><?php echo number_format(($sum/$sizeof),2); ?></td>
						</tr>
						<?php
						unset($totalAmt); ?>
					</table>
				<?php
				}
			}
			elseif($_GET['selectVal']=='capz'){ ?>
				<h2>Capital:</h2>
				<?php
				$mp=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE (DATE(created_at) BETWEEN '$start_date' AND '$end_date') AND status='APPROVED' ORDER BY created_at ASC");
				$countmp=mysqli_num_rows($mp);
				if($countmp<=0){
					echo "<h2>~~``No exisitng data in db~~``</h2>";
				}
				else{ ?>
					<table class="table table-striped">
						<tr>
							<th>Member ID</th>
							<th>Name</th>
							<th>Reference Number</th>
							<th>Amount</th>
							<th>Created At</th>
						</tr>
						<?php
						while($capital=mysqli_fetch_assoc($mp)){ ?>
							<tr>
								<td><?php echo $member_id=$capital['member_id'];?></td>
								<td>
									<?php
									$sqllo=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
									$mem=mysqli_fetch_assoc($sqllo);
									echo $mem['member_first_name'].' '.$mem['member_last_name']; ?>
								</td>
								<td>
									<?php 
									if(isset($capital['ref_num'])){
										echo $capital['ref_num'];
									}
									else{
										echo "None. Paid directly.";
									} ;?>
								</td>
								<td>
									<?php
									echo $capitalArr[] = $capital['amount']; ?>
								</td>
								<td><?php echo DATE("Y M d H:i A",strtotime($capital['created_at']));?></td>
							</tr>
							<?php
						}
						$sumofcap=array_sum($capitalArr);
						$sizeofcap=sizeof($capitalArr);
						unset($capitalArr); ?>
						<tr>
							<th colspan="3">Total:</th>
							<td colspan="2"><?php echo number_format($sumofcap,2);?></td>
						</tr>
						<tr>
							<th colspan="3">Average:</th>
							<td colspan="2"><?php echo number_format(($sumofcap/$sizeofcap),2);?></td>
						</tr>
					</table>
					<?php
				}
			}
			elseif($_GET['selectVal']=='membersh'){ ?>
				<h2>Membership Fees</h2>
				<?php
				$mpi=mysqli_query($conn,"SELECT * FROM `official_member_member_payment` WHERE (DATE(created_at) BETWEEN '$start_date' AND '$end_date') ORDER BY created_at DESC");
				$vr=mysqli_num_rows($mpi);
				if($vr<=0){ ?>
					<h2>~~``No exisitng data in db~~``</h2>
					<?php 
				}
				else{ ?>
					<table class="table table-striped">
						<tr>
							<th>Member ID</th>
							<th>Name</th>
							<th>Rate</th>
							<th>Date Paid</th>
						</tr>
						<?php 
						while($mei=mysqli_fetch_assoc($mpi)){ ?>
							<tr>
								<td><?php echo $member_id=$mei['member_id']; ?></td>
								<td>
									<?php
									$de=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$member_id'");
									$fork=mysqli_fetch_assoc($de);
									echo $name=$fork['member_first_name'].' '.$fork['member_last_name']; ?>
								</td>
								<td>Php <?php echo $fives[]="500.00"; ?></td>
								<td>
									<?php echo DATE("Y M d H:i A",strtotime($mei['created_at'])); ?>
								</td>
							</tr>
							<?php
						}
						$summy=array_sum($fives);
						unset($fives); ?>
						<tr>
							<td colspan="2"></td>
							<th colspan="2">Php <?php echo number_format($summy,2);?></th>
						</tr>
					</table>
					<?php
				} 
			} ?>

			<?php
		}
		?>
		<button class="btn btn-lg btn-secondary btn-block mb-3" onclick="myFunction()">Print Record</button>
		<script>
			function myFunction(){
				window.print();
			}
		</script>
	</div>
</body>
</html>