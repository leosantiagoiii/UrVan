<?php session_start();
require "../includes/dbconnect.inc.php";
if(!isset($_SESSION['adminid'])){
	header("Location:../index.php?entry=error");
	exit();
}
else{
	if(isset($_GET['q']) && isset($_GET['news_id'])){
		$news_id=$_GET['news_id'];
		$sql=mysqli_query($conn,"SELECT * FROM news_and_updates_archive_table WHERE news_id='$news_id'");
		$row=mysqli_fetch_assoc($sql);
		$sql2=mysqli_query($conn,"SELECT * FROM news_and_updates_gallery_table WHERE news_id='$news_id'");
		$count=mysqli_num_rows($sql2); ?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>Archive for Post <?php echo $news_id; ?></title>
			<link rel="stylesheet" href="">
		</head>
		<body>
			<?php
			echo "<h1>Post No. ".$news_id.": ".$row['news_title']."</h1>"; ?>
			<p>
				<?php
				echo $row['news_content']; ?>
			</p>
			<div>
				<?php
				if($count>=1){
					while($row2=mysqli_fetch_assoc($sql2)){ ?>
						<img style="width:45%" src="../includes/<?php echo $row2['target_dir'];?>" alt="">
						<?php
					}
				} ?>
			</div>
			<p>
				<?php
				echo 'Posted: '.$row['news_time_posted'];?>
			</p>
		</body>
		</html>
		<?php
	}
	else{
		header("Location:../index.php?entry=error");
		exit();
	}
}