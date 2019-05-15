<?php
session_start();
if(isset($_SESSION['adminid'])){
	if(isset($_GET['news_id'])){
	require "header.php";
	require "../includes/dbconnect.inc.php";
	$news_id=$_GET['news_id'];
?>
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<div class="container-fluid">
	<?php $sql="SELECT * FROM news_and_updates_table WHERE news_id='$news_id'";
	$res=mysqli_query($conn,$sql);
	$coco=mysqli_num_rows($res);
	while($row=mysqli_fetch_assoc($res)){ ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="admin_news_and_updates.php">News & Updates Content</a>
		</li>
		<li class="breadcrumb-item active">Edit Post #<?php echo $row['news_id'];?></li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			Edit: <b><?php echo $row['news_title']; ?></b>
		</div>
		<div class="card-body">
			<form action="../includes/news_and_updates_modify.inc.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="news-id" value="<?php echo $news_id; ?>">
				<div class="form-group">
					<div class="row">
						<div class="col">
							<label for="news-title">News Title:</label>
							<input type="text" id="" class="form-control" placeholder="Title" required="required" name="news-title" value="<?php echo $row['news_title']; ?>">
						</div>
						<div class="col">
							<label for="isfeatured">Featured?</label><br>
							<input type="radio" name="isfeatured" value="TRUE" <?php if($row['news_is_featured']=='TRUE'){echo 'checked';} ?>> Yes
							<input type="radio" name="isfeatured" value="FALSE" style="margin-left:10px;" <?php if($row['news_is_featured']=='FALSE'){echo 'checked';} ?>> No
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group" >
						<div class="card" style="padding:30px; margin-bottom:10px;">
							<?php if($row['news_image']==NULL){echo 'No Header Image';}else{ ?>
								<img style="width:100%;height:400px;object-fit:cover;" src="../includes/../includes/news_and_updates_image_get.inc.php?news_id=<?php echo $row['news_id']; ?>">
								<a href="../includes/news_and_updates_modify.inc.php?news_id=<?php echo $news_id;?>&removeheaderphoto=m">Remove</a>
							<?php } ?>
						</div>
						Header Image:
						<input type="file" name="news_image" class="form-control" style="padding:10px 10px;">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group" >
						<textarea class="form-control" placeholder="Description" name="news-content" required rows="5" ><?php echo $row['news_content']; ?></textarea>
						<script>
						CKEDITOR.replace( 'news-content' );
						</script>
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<div class="card" style="padding:20px;">
							<div class="row">
								<?php
									$codse="SELECT * FROM news_and_updates_gallery_table WHERE news_id='$news_id'";
									$resulting=mysqli_query($conn,$codse);
									while($roww=mysqli_fetch_assoc($resulting)){
								if($roww['target_dir']==NULL){}else{ ?>
								<div class="col-sm-3 card">
									<img src="../includes/<?php echo $roww['target_dir']; ?>" alt="" style="width:100%;">
									<a href="../includes/news_and_updates_modify.inc.php?news_gallery_id=<?php echo $roww['news_gallery_id'];?>&news_id=<?php echo $news_id; ?>&deletebutton=succ&target_dir=<?php echo $roww['target_dir']; ?>">Delete</a>
								</div>
								<?php } ?>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-sm-12 card">
									Add More:
									<input type="file" name="news_gallery[]" multiple="multiple" style="padding:10px;">
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-success" name="edit-button" value="edit-button">Save Changes</button>
			</form>
		</div>
		<div class="card-footer small text-muted">
			Updated yesterday at 11:59 PM
		</div>
	</div>
	<?php } ?>
</div>
<?php
require "footer.php";
}
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>