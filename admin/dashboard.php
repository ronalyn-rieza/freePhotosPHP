<?php 
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Dashboard</title>
<?php
    include("admin_includes/admin_nav.php"); 
?>
 
 <!-- admin graph  -->
 <section id="admin-graph" class="bg-light">
     <div class="container">
         <div class="row py-4">
             <div class="col m-3 admin-chart" style="background-color: #fff;">
                 <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Data', ''],
                            
            
 <?php

$time = time() - 60*60*24;
                            
$query = "SELECT user_id FROM users WHERE time_online > $time";
$select_online_users = query($query);
confirm($select_online_users);                           
$online_users_count = row_count($select_online_users);
            
$query = "SELECT image_id FROM images WHERE image_cat_title = 'Landscape'";
$select_landscape_img = query($query);
confirm($select_landscape_img);                            
$landscape_count = row_count($select_landscape_img);
            
$query = "SELECT image_id FROM images WHERE image_cat_title = 'Street'";
$select_street_img = query($query);
confirm($select_street_img);
$street_count = row_count($select_street_img);
            
$query = "SELECT image_id FROM images WHERE image_cat_title = 'Commercial'";
$select_commercial_img = query($query);
confirm($select_commercial_img);
$commercial_count = row_count($select_commercial_img);            
            
$element_text = ['Online', 'Landscape', 'Street', 'Commercial'];
$element_count = [$online_users_count, $landscape_count, $street_count, $commercial_count];

//loop to show data on google chart                            
for($i = 0; $i < 4; $i++){
    
   echo "['{$element_text[$i]}'".", "."{$element_count[$i]}],"; 
}

?>   
    
            
                        ]);//closing of google table data visualization array
    
                        var options = {
                        title: '',
                        hAxis: {title: 'Data', titleTextStyle: {color: '#333'}},
                        colors: '#333',
                        is3D: true
                        };
                        
                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
          
                        function resizeHandler () {
                            chart.draw(data, options);
                        }
                        //make the graph reponsive
                        if (window.addEventListener) {
                            window.addEventListener('resize', resizeHandler, false);
                        }else if (window.attachEvent) {
                            window.attachEvent('onresize', resizeHandler);
                        }

                    }//closing of draw chart function

                </script>
                    <!--div to draw the chart-->
                    <div id="columnchart_material" class="p-3" style="max-width: 100%; height: 430px;"></div>
                 
            </div><!--end of col div--> 
        </div> <!--end of row div-->
    </div><!--end of container div-->
</section> 
 
  <!-- footer-->
  
<footer id="footer" class="bg-info">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-4 mb-5"> 
                <div class="card text-center bg-info text-white"> 
                    <div class="card-body">
                        <h3>Images</h3>
<?php
//getting the number of images in the db                           
$sql =  "SELECT image_id FROM images";
$select_all_img = query($sql);
confirm($select_all_img);
$images_count = row_count($select_all_img);
                           
echo "<p class='lead'>{$images_count} <i class='fa fa-image'></i></p>";
?>
                       <a href="images.php" class="btn btn-outline-light text-dark btn-sm mr-2">View</a>
                       <a href="add_image.php" class="btn btn-outline-light text-dark btn-sm ml-2">Add Image</a>
                   </div> 
                 
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card text-center bg-info text-white">
                    <div class="card-body">
                        <h3>Categories</h3>
<?php                     
// getting the number of categories in the db   
$query = "SELECT cat_id FROM categories ";
$select_all_cat = query($query);
confirm($select_all_cat);
$category_count = row_count($select_all_cat);
                           
echo "<p class='lead'>{$category_count} <i class='fa fa-filter'></i></p>";
?>
                       <a href="categories.php" class="btn btn-outline-light text-dark btn-sm mr-2">View</a>
                       <a href="categories.php" class="btn btn-outline-light text-dark btn-sm ml-2">Add Catergory</a>
                   </div> 
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card text-center bg-info text-white">
                    <div class="card-body">
                        <h3>Users</h3>
<?php                     
// getting the number of users in the db   
$query = "SELECT user_id FROM users ";
$select_all_users = query($query);
confirm($select_all_users);
$user_count = row_count($select_all_users);
        
echo "<p class='lead'>{$user_count} <i class='fa fa-users'></i></p>"; 
?>
                       <a href="users.php" class="btn btn-outline-light text-dark btn-sm mr-2">View</a>
                       <a href="add_user.php" class="btn btn-outline-light text-dark btn-sm ml-2">Add User</a>
                   </div> 
                </div>
            </div>
        </div><!--- end of row div =-->
    </div><!--- end of col div =-->
</footer><!--- end of footer =-->      
<!--- html closing tags =-->
<?php 
    include("admin_includes/admin_close_tags.php");