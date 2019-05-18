<?php require "header.php"; ?>
<main>
    <?php require "includes/dbconnect.inc.php"; ?>
    <div class="tours_section">
        <h1 class="title-tours">Multi City</h1>
        <p class="subtitle-tours">From one place to another, come and try!</p>
        <div class="tours" id="comments">
            <?php $query="SELECT * FROM tours_and_packages_table WHERE tour_id IN (SELECT tour_id FROM tours_and_packages_single) AND tour_id IN (SELECT tour_id FROM tours_and_packages_multicity) ORDER BY tour_name LIMIT 8";
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
            $all=mysqli_query($conn,"SELECT * FROM tours_and_packages_single WHERE tour_id='$row[tour_id]'");
            $muu=mysqli_num_rows($all); ?>
            <div class="tours-content" style="position:relative;">
                <?php
                $al=mysqli_query($conn,"SELECT tour_id, COUNT(tour_id) AS value_occurrence FROM booking_majordetails WHERE completion='YES' AND refunded='NO' GROUP BY tour_id ORDER BY value_occurrence DESC LIMIT 3");
                $meh=mysqli_query($conn,"SELECT * FROM tours_sales WHERE tour_id='$row[tour_id]'");
                $gr=mysqli_num_rows($meh);
                while($all=mysqli_fetch_assoc($al)){
                    if($all['tour_id']==$row['tour_id']){ ?>
                        <img src="images/top-trip.png" style="position:absolute;left:-25px;bottom:-10px;width:33%;border-style: none;">
                        <?php if($gr>=1){ ?>
                            <img src="images/sales.png" style="position:absolute;left:75%;top:-35px;width:30%;border-style: none;">
                            <?php
                        }
                    }
                    elseif($all['tour_id']!=$row['tour_id']&&$gr>=1){
                        echo '<img src="images/sales.png" style="position:absolute;left:75%;top:-35px;width:30%;border-style: none;">';
                    }
                } ?>
                <img class="tours-landing-img" style="width:100%;" src="includes/tour_and_packages_image_get.inc.php?tour_id=<?php echo $row['tour_id']; ?>">
                <h1 class="trip-name-a"><?php echo $row['tour_name'];?></h1>
                <h3 class="trip-price-a"><b>Php <?php echo $row['tour_price'];?> per van</h3>
                <a href="tours_content.php?tour_id=<?php echo $row['tour_id']; ?>" class="btn btn-sm btn-info btn-n">Read More</a>
            </div>
            <?php }
            } else {
            echo '<h1>There are no comments</h1>';
            } ?>
        </div>
        <center>
            <button style="margin-top:30px;" class="boyra btn btn-lg" id="barte">View More</button>
        </center>
        <br>
        <hr>
        <div class="" style="padding:30px;margin-top:30px;">
            <p class="subtitle-tours" style="line-height:1px;">Are you a business or company insterested to partner up with us?</p>
            <h1 class="title-tours" style="text-transform: capitalize;">We have a travel quote request!</h1>
            <center><a href="quotation.php" class="btn btn-primary btn-lg">Click Here</a></center>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>
<script>
$(document).ready(function(){
    var commentcount=6;
    $("#barte").click(function(){
        commentcount=commentcount+6;
        $("#comments").load("load-trips.php", {
            newcom:commentcount
        });
    });
});
</script>
<?php require "footer.php"; ?>