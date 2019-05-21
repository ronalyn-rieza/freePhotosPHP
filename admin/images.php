<?php 
    include("admin_includes/admin_header.php");
?>
<title>freePhotos.io - Images</title>
<?php
    include("admin_includes/admin_nav.php"); 
?>

 <!-- images  -->
<section id="images" class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
               <?php display_message(); ?>
            </div>
        </div>
        <div class="row pt-4 pb-5">
            <div class="col">
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">              
                        <thead style="background-color:#3292a6; color:#fff;">
                            <tr>
                                <th>Cat Title</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Tags</th>
                                <th>Likes</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                               
                                  
<?php
 //setting how many images to show on the table 
                            
 if(isset($_GET['page'])){
      
        $page = abs((int)$_GET['page']);  
      
  }else{
      
    $page = 1;  
      
  }

  $shownimg_num = 4;

  if($page == "" || $page == 1){
      
     $page_1 = 0; 
      
  }else{
      
     $page_1 = ($page * $shownimg_num) - $shownimg_num; 
      
  }

//show images info on a table from database                              
$sql = "SELECT * FROM images ORDER BY image_id DESC LIMIT $page_1, $shownimg_num";
$select_images = query($sql);
confirm($select_images);
                            
 if(mysqli_num_rows($select_images) < 1){
       
       echo "<h1 class='text-center m-auto py-5'>No image available here</h1>";
       
   }else{
                                 
    while($row = mysqli_fetch_assoc($select_images)){
        $image_id = $row['image_id']; 
        $image_cat_title = $row['image_cat_title'];
        $image_standard_name = $row['standard_name'];
        $image_thumbnail_name = $row['thumbnail_name'];
        $image_type = $row['image_type'];
        $image_post_date = $row['image_post_date'];
        $image_tags = $row['image_tags'];
        $image_likes = $row['image_likes'];
       
        
        echo "<tr>";
            echo "<td>{$image_cat_title}</td>";
            echo "<td><img class='img img-fluid' width='100' src='../img/$image_thumbnail_name' alt=''></td>";
            echo "<td>{$image_type}</td>";
            echo "<td>{$image_post_date}</td>";
            echo "<td>{$image_tags}</td>";
            echo "<td>{$image_likes}</td>";
            echo "<td><a class='view-image btn btn-outline-info' href='#view-image' data-toggle='modal' data-id='{$image_id}'>View Image</a></td>";
            echo "<td><a href='edit_img.php?img_id={$image_id}'>Edit</a></td>";
            echo "<td><a href='#delete-image' data-toggle='modal' data-id='{$image_id}' style='color: red;' class='delete-image'>Delete</a></td>";
        echo "</tr>";
    }//end of while loop
 }//end of else num rows 
?>                                
                                
                        </tbody>
                    </table>
                </div><!--responsive table closing div -->                  
                    
<?php 
//delete image in database
if(isset($_GET['delete'])){
    
  $delete_image = abs((int)$_GET['delete']);
    
    $get_img_name = query("SELECT standard_name, thumbnail_name FROM images WHERE image_id = '".escape($delete_image)."'");

    confirm($get_img_name);

    $row = fetch_array($get_img_name);

    $standard_path = '../img/' . $row['standard_name'];
    
    $thumbnail_path = '../img/' . $row['thumbnail_name'];

    unlink($standard_path);
    
    unlink($thumbnail_path);
    
    
    $stmt = query_stmt("DELETE FROM images WHERE image_id = ? ");
               
    mysqli_stmt_bind_param($stmt, "i", $delete_image);
        
    mysqli_stmt_execute($stmt);
                
    confirm($stmt); 
    
    set_message("<p class='text-center py-2 mt-4 text-dark displyed-message-success'>Image has been deleted</p>");
    
    //header("Location: images.php");
    
    redirect("images.php");
    
}

?>
                    
                    <!--pagination link -->
                     <ul class="pagination justify-content-center mt-admin-pagi">
<?php 
                         
  //get how many images in database   
 $image_count_query = "SELECT image_id FROM images";
 $find_image_count = query($image_count_query);
 confirm($find_image_count);
 $image_count = mysqli_num_rows($find_image_count); 
                         
                         
 if($image_count >= 1){
         
        $count = ceil($image_count/ $shownimg_num);
     
        //prev page link
        if($page > 1 ){

            $j = $page - 1;
            
            echo "<li class='page-item'><a class='page-link' href='images.php?page=$j'>Prev</a></li>";
            
        }
           
       if($count > 1){
        //looping pagination pages
        for($i = 1; $i <= $count; $i++ ){
             
                if($i == $page){ 
                
                    echo "<li class='page-item active-link'>{$i} of {$count}</li>";
            
                }
            }
        }
     
        //next page link
        if($page < $count ){

           $j = $page + 1;
        
           echo "<li class='page-item'><a class='page-link' href='images.php?page=$j'>Next</a></li>";

        }
        
 }//end of if image_count > = 1                        
                      
?>  
                    </ul>
                    <!-- end of pagination -->
                    
            </div><!--table col closing div -->
            
            <div class="col-md-6 mt-4"><!--add image div -->
				<a class="btn btn-outline-info d-block" href="add_image.php"><i class="fa fa-angle-double-left"></i> Add Image <i class="fa fa-angle-double-right"></i></a>
            </div>          
            <div class="col-md-6 mt-4"><!--back to dashboard div -->
				<a class="btn btn-outline-dark d-block" href="dashboard.php"><i class="fa fa-angle-double-left"></i> Back to Dashboard <i class="fa fa-angle-double-right"></i></a>
            </div>
                        
        </div><!--row colsing div -->    
            
    </div><!--container closing div -->
</section>


<!-- view image modal -->
 <div class="modal fade" id="view-image" tabindex="-1" role="dialog">
      <div class="modal-dialog m-auto modal-lg" role="document">
        <div class="modal-content">
        
        </div>
      </div>
</div>
<!-- delete image modal -->
<div class="modal fade" id="delete-image" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
        
        </div>
      </div>
</div>                                                                                                 
<?php 
    include("admin_includes/admin_close_tags.php");