<?php
session_start();
if(isset($_SESSION['adminid'])){
    require "header.php";
    require "../includes/dbconnect.inc.php";
    ?>
    <link rel="stylesheet" href="css/sb-admin.css">
    <script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="css/sb-admin.min.css">
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="js/sb-admin.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    $("#myModal").modal('show');
    });
    </script>
        <div class="container-fluid">
            <!--Add Trips-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-shuttle-van"></i>
                    Add Tours & Packages
                </div>
                <div class="card-body">
                    <form action="../includes/tours_and_packages.inc.php" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="inputPackageName" class="form-control" placeholder="Package Name" required="required" name="package-name">
                                        <label for="inputPackageName">Package Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="locationn" class="form-control" placeholder="Package Name" required="required" name="completeadd">
                                        <label for="locationn">Location</label>
                                    </div>
                                    <input type="hidden" id="latiy" name="latitude">
                                    <input type="hidden" id="longie" name="longitude">
                                    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI&libraries=places"></script>
                                    <script>
                                    var searchbox;
                                    searchbox = new google.maps.places.SearchBox(document.getElementById('locationn'));
                                    google.maps.event.addListener(searchbox,'places_changed', function(){
                                    var places = searchbox.getPlaces();
                                    var bounds = new google.maps.LatLngBounds();
                                    var i, place;
                                    for(i=0;place=places[i];i++){
                                    var lati = place.geometry.location.lat();
                                    var longi = place.geometry.location.lng();
                                    console.log(place);
                                    bounds.extend(place.geometry.location);
                                    }
                                    document.getElementById('latiy').value = lati;
                                    document.getElementById('longie').value = longi;
                                    });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="inputPrice" class="form-control" placeholder="Price" required="required" name="package-price">
                                        <label for="inputPrice">Price</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="file" name="tour-image" class="form-control" required style="padding:10px 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group" >
                                <textarea id="inputPackageDesc" class="form-control" placeholder="Description" name="package-desc" required rows="5" ></textarea>
                                <script>
                                CKEDITOR.replace( 'package-desc' );
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-label-group">
                                        Tours Gallery:
                                        <input type="file" name="tours_gallery[]" multiple="multiple" class="form-control" style="padding:13px 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label for="">Will go thru Manila/NCR?</label>
                                <select required class="form-control" name="NCR_choice" id="">
                                    <option>---</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Single Trips?</label>
                                <select required class="form-control" name="single_trip" id="">
                                    <option>---</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>   
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label for="">Single Location Trip</label>
                                <select required class="form-control" name="singleloc" id="">
                                    <option>---</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Multicity</label>
                                <select required class="form-control" name="multicity" id="">
                                    <option>---</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>                
                        <input type="submit" class="btn btn-success btn-md mt-3" value="Post Now">
                    </form>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <!--/Add Trips-->
            <!--table of trips-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-directions"></i>
                Existing Trips</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tour ID</th>
                                    <th>Tour Name</th>
                                    <th>Price</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Tour ID</th>
                                <th>Tour Name</th>
                                <th>Price</th>
                                <th>Options</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <?php $query2="SELECT * FROM tours_and_packages_table";
                                $result2=mysqli_query($conn,$query2);
                                while( $row2=mysqli_fetch_assoc($result2) ) { ?>
                                <tr>
                                    <td><?php echo $row2['tour_id']; ?></td>
                                    <td><?php echo $row2['tour_name']; ?></td>
                                    <td>₱ <?php echo $row2['tour_price']; ?></td>
                                    <td>
                                        <form>
                                            <div class="btn-group">
                                                <a target="_blank" class="btn btn-primary" href="../tours_content.php?tour_id=<?php echo $row2['tour_id']; ?>">View</a>
                                                <a class="btn btn-success" href="admin_tours_and_packages_edit.php?tour_id=<?php echo $row2['tour_id']; ?>">Modify</a>
                                                <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#tours-delete<?php echo $row2['tour_id']; ?>">Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Modal for delete -->
                                <div class="modal fade" id="tours-delete<?php echo $row2['tour_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">WARNING!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <?php echo $row2['tour_name']; ?>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="../includes/tours_and_packages_modify.inc.php" method="POST">
                                                    <input type="hidden" value="<?php echo $row2['tour_id']; ?>" name="package-id">
                                                    <button type="submit" class="btn btn-danger" name="Delete-button">Yes</button>
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
          <!--table of trips-->
        </div>

    <?php 
    if( isset($_GET['posting']) && $_GET['posting']=='success' ){ ?>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Package Information Posted!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="text-align:left;">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php $pkg_name = $_GET['package-name'];
                        $query="SELECT * FROM tours_and_packages_table WHERE tour_name='$pkg_name'";
                        $result=mysqli_query($conn,$query);
                        while($row=mysqli_fetch_assoc($result)){
                        $tour_id=$row['tour_id'];
                        $tour_name=$row['tour_name'];
                        } ?>
                        <p>What would you like to do for the package <b><?php echo $tour_name; ?></b>?</p>
                        <form method="POST" action="../includes/tours_and_packages_archive.inc.php">
                            <a class="btn btn-primary" target="_blank" href="../tours_content.php?tour_id=<?php echo $tour_id; ?>">View Post</a>
                            <input type="hidden" value="<?php echo $tour_id; ?>" name="tours_id">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php 
    } else; 
    require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>