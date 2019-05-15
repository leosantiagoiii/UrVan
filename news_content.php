<?php require "header.php"; require "includes/dbconnect.inc.php"; ?>
<main>
    <?php
    $ab=(SHA1(rand(0,500)));
    $bc=strtoupper($ab);
    $cd='NVI_'.substr($bc, 0,10);
    $m1="SELECT * FROM page_visit_table_news WHERE ip_address='$ip_address'";
    $m2=mysqli_query($conn,$m1);
    $m3=mysqli_num_rows($m2);
    ?>
    <div class="tours_section">
        <?php $news_id=$_REQUEST['news_id'];
        $query="SELECT * FROM news_and_updates_table WHERE news_id=$news_id";
        $result=mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result)){ ?>
        <?php
        if(!isset($_SESSION['adminid'])){
            if($m3<=0){
                  //if zero
                  $kal="INSERT INTO page_visit_table_news (id,news_id,ip_address,visit_date) VALUES ('$cd','$news_id','$ip_address','$currdate')";
                  mysqli_query($conn,$kal);
            }
            else{
                  //if not zero
                  $mabu="INSERT INTO page_visit_table_news (id,news_id,ip_address,visit_date) VALUES ('$cd','$news_id','$ip_address','$currdate')";
                  mysqli_query($conn,$mabu);
            }
        }
        ?>
        <h1 class="NewsTitle">
        <?php if($row['news_is_featured']=='TRUE'){echo 'HEADLINES: ';}
        else{}?>
        <?php echo $row['news_title']; ?> <?php //echo $row['news_id']; ?>
        </h1>
        <h5 style="line-height: 15px;">By <?php echo $row['news_author']; ?></h5>
        <?php $m="SELECT * FROM page_visit_table_news WHERE news_id=$news_id";
        $n=mysqli_query($conn,$m);
        $cccoun=mysqli_num_rows($n); ?>
        <h6>Posted on: <?php echo $row['news_time_posted']; ?> | Page Hits: <?php echo $cccoun; ?></h6>
        <?php if(empty($row['news_image'])){
        echo '';
        }else{?>
        <img class="grulk" src="includes/news_and_updates_image_get.inc.php?news_id=<?php echo $row['news_id']; ?>">
        <?php } ?>
        <p class="NewsDesc"><?php echo $row['news_content'];?></p>
        <?php $ss="SELECT * FROM news_and_updates_gallery_table WHERE news_id='$news_id'";
        $rr=mysqli_query($conn,$ss); ?>
        <div class="roror">
            <?php while($rro=mysqli_fetch_assoc($rr)){ ?>
            <div class="colcol">
                <a data-toggle="modal" data-target="#img<?php echo $rro['news_gallery_id'].$rro['news_id']; ?>"><img src="includes/<?php echo $rro['target_dir']; ?>" style="border-style:solid;width:100%;object-fit:cover;height:300px;"></a>
            </div>
            <div class="modal fade bd-example-modal-lg" id="img<?php echo $rro['news_gallery_id'].$rro['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <?php if($row['news_edited']==NULL){}else{ ?>
        <p style="color:red"><i>Edited: <?php echo $row['news_edited']; ?></i></p>
        <?php } ?>
        <?php } ?>
        <br>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="fb-share-button"
            data-href="http://urvan.webstarterz.com/news_content.php?news_id=<?php echo $news_id;?>"
            data-layout="button_count"
            data-size="large">
        </div>
    </div>
</main>
<?php require "footer.php"; ?>