<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php";
?>
<link rel="stylesheet" href="css/sb-admin.css">
<link rel="stylesheet" href="css/sb-admin.min.css">
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
<script src="js/sb-admin.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#myModal").modal('show');
});
</script>
<div class="container-fluid">
  <!--Add News-->
  <div class="card mb-3">
    <div class="card-header">
      <i class="fas fa-newspaper"></i>
      Add News and Updates
    </div>
    <div class="card-body">
      <form action="../includes/news_and_updates.inc.php" enctype="multipart/form-data" method="POST">
        <div class="form-group">
          <div class="form-label-group">
            <input type="text" id="Title" class="form-control" placeholder="title" required="required" name="article-title">
            <label for="Title">Title</label>
          </div>
        </div>
        <div class="checkbox form-group card" style="padding:10px 10px 3px;">
          <label>
            Featured?<br>
            <input type="radio" name="is-featured" value="TRUE"  required> Yes
            <input type="radio" name="is-featured" value="FALSE" > No
          </label>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <div class="form-label-group">
                Header Photo:
                <input type="file" name="article-image" class="form-control" style="padding:13px 10px;">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group" >
            <textarea id="" class="form-control" placeholder="Content" name="article-content" required rows="5" ></textarea>
            <script>
            CKEDITOR.replace( 'article-content' );
            </script>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <div class="form-label-group">
                Photo Gallery:
                <input type="file" name="news_gallery[]" multiple="multiple" class="form-control" style="padding:13px 10px;">
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" value="<?php echo $_SESSION['adminlname'].', '.$_SESSION['adminfname']; ?>" name="article-author">
        <input type="submit" class="btn btn-success btn-md" value="Post Now">
      </form>
    </div>
    <div class="card-footer small text-muted">Updated <?php
    date_default_timezone_set('Asia/Manila'); echo date("h:i:sa"); ?></div>
  </div>
  <!--/Add NEWS-->
  <!--table of News-->
  <div class="card mb-3">
    <div class="card-header">
      <i class="fas fa-directions"></i>
    Posts</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Post ID</th>
              <th>Post Title</th>
              <th>Posted on</th>
              <th>Author</th>
              <th>View Count</th>
              <th>Options</th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Post ID</th>
            <th>Post Title</th>
            <th>Posted on</th>
            <th>Author</th>
            <th>View Count</th>
            <th>Options</th>
          </tr>
          </tfoot>
          <tbody>
            <?php $query2="SELECT * FROM news_and_updates_table ORDER BY news_time_posted DESC";
            $result2=mysqli_query($conn,$query2);
            while( $row2=mysqli_fetch_assoc($result2) ) { ?>
            <tr>
              <td><?php echo $row2['news_id']; ?></td>
              <td><?php echo $row2['news_title']; ?></td>
              <td><?php echo $row2['news_time_posted']; ?>
                <br><?php if($row2['news_edited']==NULL){
                echo 'Edited: Not yet';
                }
                else{
                echo '<b style=\'color:red;\'>Edited: '.$row2['news_edited'].'</b>';
                } ?>
              </td>
              <td><?php echo $row2['news_author']; ?></td>
              <td>
                <?php
                $alo=mysqli_query($conn,"
                  SELECT * FROM page_visit_table_news WHERE news_id='$row2[news_id]'
                  ");
                $ans=mysqli_num_rows($alo);
                echo $ans;
                ?>
              </td>
              <td>
                <form>
                  <div class="btn-group">
                    <a class="btn btn-primary" href="../news_content.php?news_id=<?php echo $row2['news_id']; ?>">View</a>
                    <a class="btn btn-success" href="admin_news_and_updates_edit.php?news_id=<?php echo $row2['news_id']; ?>">Modify</a>
                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#news-delete<?php echo $row2['news_id']; ?>">Delete</button>
                  </div>
                </form>
              </td>
            </tr>
            <!-- Modal for delete -->
            <div class="modal fade" id="news-delete<?php echo $row2['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">WARNING!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete <?php echo $row2['news_title']; ?>?
                  </div>
                  <div class="modal-footer">
                    <form action="../includes/news_and_updates_archive.inc.php" method="POST">
                      <input type="hidden" value="<?php echo $row2['news_id']; ?>" name="news_id">
                      <button type="submit" class="btn btn-danger">Yes</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal for delete -->
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
  </div>
  <!--table of News-->
</div>
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>