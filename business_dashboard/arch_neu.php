<?php session_start();
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	require "../includes/dbconnect.inc.php";
	require "header.php"; ?>
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Archived News</li>
		</ol>
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-trash-alt"></i>
				Archived Trips
			</div>
			<div class="card-body">
				<table class="table" id="dataTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>News Article Title</th>
							<th>News Posted</th>
							<th>News Edited</th>
							<th>~</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>News Article Title</th>
							<th>News Posted</th>
							<th>News Edited</th>
							<th>~</th>
						</tr>
					</tfoot>
					<tbody>
					<?php
					$sql=mysqli_query($conn,"SELECT * FROM news_and_updates_archive_table ORDER BY news_time_posted");
					while($row=mysqli_fetch_assoc($sql)){ ?>
						<tr>
							<td><?php echo $row['news_id'];?></td>
							<td><?php echo $row['news_title'];?></td>
							<td><?php echo $row['news_time_posted'];?></td>
							<td><?php echo $row['news_edited'];?></td>
							<td>
								<form action="../includes/bring_archive_news.inc.php" method="post">
									<input type="hidden" name="news_id" value="<?php echo $row['news_id']; ?>">
									<div class="btn-group d-flex">
										<a href="arch_posts.php?q&news_id=<?php echo $row['news_id']; ?>" target="_blank" class="btn btn-secondary w-100">View Post</a>
										<button class="btn btn-success w-100" name="return">Retrieve</button>
									</div>
								</form>
							</td>
						</tr>
						<?php
					} ?>
					</tbody>
				</table>
			</div>
		</div>


		<?php
		// $sql=mysqli_query($conn,"SELECT * FROM news_and_updates_archive_table ORDER BY news_time_posted");
		// while($row=mysqli_fetch_assoc($sql)){ ?>
			<!-- <form action="../includes/bring_archive_news.inc.php" method="post">
				<input type="hidden" name="news_id" value="<?php //echo $row['news_id']; ?>">
				<button name="return">return</button>
			</form> -->
			<?php
			// echo $row['news_id'].' '.$row['news_title'].' ';
			// $sql2=mysqli_query($conn,"SELECT * FROM news_and_updates_gallery_archive_table WHERE news_id='$row[news_id]'");
			// $cou=mysqli_num_rows($sql2);
			// if($cou>=1){ 
			// 	while($row2=mysqli_fetch_assoc($sql2)){ ?>
			<?php
			// 		echo $row2['news_gallery_id'];
			// 	}
			// }
			// echo '<br><br>';
		//} ?>
	</div>
	<?php
	require "footer.php";
} ?>